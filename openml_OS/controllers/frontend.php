<?php
class Frontend extends CI_Controller {
  
  private $oath1_providers;
  private $oath2_providers;
  
  function __construct() {
    parent::__construct();
    
    $this->load->model('File');
    $this->load->model('Dataset');
    $this->load->model('Data_quality');
    $this->load->model('Implementation');
    $this->load->model('Math_function');
    $this->load->model('Task');
    $this->load->model('Task_values');
    $this->load->model('Task_type');
    $this->load->model('Task_type_function');
    $this->load->model('Estimation_procedure');
    
    
    $this->load->model('Thread');
    $this->load->model('Category');
    $this->load->model('Author');
    
    $this->load->helper('table');
    $this->load->helper('tasksearch');
    
    $this->controller = strtolower(get_class ($this));
    $this->query_string = $this->uri->uri_to_assoc(2);
    $this->data_controller = BASE_URL . 'files/';
    
    $this->oath1_providers = array(
      'twitter' => array('key' => TWITTER_CONSUMER_KEY,'secret' => TWITTER_CONSUMER_SECRET),
    );
    $this->oauth2_providers = array(
      'facebook' => array('id' => FACEBOOK_APP_ID,'secret' => FACEBOOK_APP_SECRET),
      'google' => array('id' => GOOGLE_CLIENT_ID,'secret' => GOOGLE_CLIENT_SECRET),
    );
    
    $this->page = 'home'; // default value
  }
  
  public function index() {
    $this->page( $this->page );
  }
  
  public function page( $indicator ) {
    $this->page = $indicator;
    $exploded_page = explode('_',$indicator);
    $this->active = $exploded_page[0]; // can be overridden. 
    $this->message = $this->session->flashdata('message'); // can be overridden
    
    if(!loadpage($indicator,TRUE,'pre')) {
      $this->error404();
      return;
    }
    if($_POST) loadpage($indicator,TRUE,'post');
    $this->load->view('frontend_main');
  }
  
  public function error404() {
    header("Status: 404 Not Found");
    $this->load->view('404');
  }
  
  public function logout() {
    $logout = $this->ion_auth->logout();
    $this->session->set_flashdata('message', $this->ion_auth->messages());
    redirect('frontend/page/home');
  }
  
  public function result_output() {
    $filetype  = $this->input->post('type');
    $filename  = preg_replace("/[^a-zA-Z0-9.-_]+/", "", $this->input->post('name') );
    $data    = json_decode( $this->input->post('data') );
    
    $allowedFiletypes = array( 'csv' );

    if( $filename == false ) $filename = 'results.' . $filetype;
    
    if( ( ! in_array( $filetype, $allowedFiletypes ) ) ) {
      header('Content-type: text/html' );
      die ( 'Unfortunately, an error has occured. ' );
    } else {
      header('Content-type: text/' . $filetype );
      header('Content-Disposition: attachment; filename="'.$filename.'"');
      
      foreach( $data->columns as $column ) {
        echo '"' . addslashes(safe(html_entity_decode($column->title))) . '",';
      }
      echo "\n";
      
      foreach( $data->data as $record ) {
        for( $i = 0; $i < count( $data->columns ); $i++ ) {
          echo '"' . addslashes(safe(html_entity_decode(str_replace("\n",'',$record[$i])))) . '",';
        }
        echo "\n";
      }
    }
  }
  
  public function oauth($provider) {
    if(array_key_exists($provider,$this->oath1_providers)) {
      $this->_oauth1($provider);
    } else if(array_key_exists($provider,$this->oauth2_providers)) {
      $this->_oauth2($provider);
    }
  }
  
  private function _oauth1($provider) {
    $this->load->spark('oauth1/0.3.1');

        // Create an consumer from the config
        $consumer = $this->oauth1->consumer($this->oath1_providers[$provider]);

        // Load the provider
        $provider = $this->oauth1->provider($provider);

        // Create the URL to return the user to
        $callback = site_url('frontend/oauth/'.$provider->name);

        if ( ! $this->input->get_post('oauth_token'))
        {
            // Add the callback URL to the consumer
            $consumer->callback($callback); 

            // Get a request token for the consumer
            $token = $provider->request_token($consumer);

            // Store the token
            $this->session->set_userdata('oauth_token', base64_encode(serialize($token)));

            // Get the URL to the twitter login page
            $url = $provider->authorize($token, array(
                'oauth_callback' => $callback,
            ));

            // Send the user off to login
            redirect($url);
        }
        else
        {
            if ($this->session->userdata('oauth_token'))
            {
                // Get the token from storage
                $token = unserialize(base64_decode($this->session->userdata('oauth_token')));
            }

            if ( ! empty($token) AND $token->access_token !== $this->input->get_post('oauth_token'))
            {   
                // Delete the token, it is not valid
                $this->session->unset_userdata('oauth_token');
        sm('An OAuth Exception has occured. Please try again. ');
                redirect('frontend/page/login');
            }

            // Get the verifier
            $verifier = $this->input->get_post('oauth_verifier');

            // Store the verifier in the token
            $token->verifier($verifier);

            // Exchange the request token for an access token
            $token = $provider->access_token($consumer, $token);

            // We got the token, let's get some user data
            $user = $provider->get_user_info($consumer, $token);

      $this->_processUser($provider,$user);
        }
  }
  
  private function _oauth2($provider) {
    $this->load->spark('oauth2/0.3.1');
        $provider = $this->oauth2->provider($provider, $this->oauth2_providers[$provider] );
        if ( ! $this->input->get('code'))
            $provider->authorize();
        else {
            try {
                $token = $provider->access($_GET['code']);
                $user = $provider->get_user_info($token);

                $this->_processUser($provider,$user);
            } catch (OAuth2_Exception $e) {
        sm('An OAuth Exception has occured. Please try again. ');
                redirect('frontend/page/login');
            }
        }
  }
  
  private function _processUser($provider,$user) {
    $ion_auth_config = $this->config->item('ion_auth');
    $ion_auth_config['email_activation'] = false; 
    $this->config->set_item('ion_auth',$ion_auth_config);
    
    $username = $provider->name.'_api_'.$user['nickname'];
    
    if( $this->ion_auth->username_check() == false  ) {
      // first time user, register it.
      $user['external_source'] = $provider->name;
      $user['external_id'] = $user['nickname'];
      
      $this->ion_auth->register(
        $username,
        EXTERNAL_API_PASSWORD,
        isset($user['email']) ? $user['email'] : 'undefined, contact via API',
        $user,
        array( 2 )
      );
    } 
    
    if ($this->ion_auth->login($username,EXTERNAL_API_PASSWORD,false))
    {
      $this->session->set_flashdata('message', $this->ion_auth->messages());
      $user = clean_array( $user, array( 'email', 'first_name', 'last_name', 'affiliation', 'country', 'image' ) );
      $this->ion_auth->update($this->ion_auth->user()->row()->id,$user); // update new data
      redirect('frontend');
    }
    else
    {
      $this->session->set_flashdata('message', $this->ion_auth->errors());
      redirect('frontend/page/login');
    }
  }
}
?>
