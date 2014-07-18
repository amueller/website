$(document).ready( function() {
  //check for change on the categories menu
  $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  
  $('#selectTaskType').change(function() {
    $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  });
  
  <?php 
    foreach( $this->task_types as $tt ): 
      foreach( $tt->in as $io ): 
        $template_search = json_decode( $io->template_search );
        $id = 'input_' . $tt->ttid . '-' . $io->name;
        if( $template_search && property_exists( $template_search, 'autocomplete' )  ): 
          if( $template_search->autocomplete == 'commaSeparated' ): 
            echo "makeCommaSeperatedAutoComplete( '#$id', $template_search->datasource );\n";
          else: // plain
            echo "makeAutoComplete( '#$id', $template_search->datasource );\n";
          endif;
        endif;
      endforeach; 
    endforeach; 
  ?>
});
