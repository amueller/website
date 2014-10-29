    <div class="col-sm-12 col-md-3 searchbar">
      <div class="bs-sidebar affix">
        <ul class="nav bs-sidenav">
              <li><a href="#json_data">Get data</a></li>
              <li><a href="#json_flow">Get flow</a></li>
              <li><a href="#json_task">Get task</a></li>
              <li><a href="#json_run">Get run</a></li>
              <li><a href="#json_sql">Free SQL query</a></li>
        </ul>
      </div>
    </div> <!-- end col-2 -->

    <div class="col-sm-12 col-md-9 openmlsectioninfo">
  <div class="bs-docs-section">
        <div class="page-header">
          <h1>JSON Endpoints</h1>
        </div>
        <p class="lead">OpenML also allows you to retrieve most information in JSON format using a predictable URL scheme. It does not allow you to upload data (yet).</p>

	<h2 id="json_data">Get data</h2>
	<p>Get a JSON description of a dataset with <code>www.openml.org/d/id/json</code> (or add <code>/json</code> to the dataset page's url).</p>
	<p>Example: <a href="d/1/json"><code>www.openml.org/d/1/json</code></a></p>

	<h3 id="json_flow">Get flows</h3>
	<p>Get a JSON description of a flow with <code>www.openml.org/f/id/json</code> (or add <code>/json</code> to the flow page's url).</p>
	<p>Example: <a href="f/100/json"><code>www.openml.org/f/100/json</code></a></p>

	<h3 id="json_task">Get tasks</h3>
	<p>Get a JSON description of a task with <code>www.openml.org/t/id/json</code> (or add <code>/json</code> to the task page's url).</p>
	<p>Example: <a href="t/1/json"><code>www.openml.org/t/1/json</code></a></p>

	<h3 id="json_run">Get runs</h3>
	<p>Get a JSON description of a run with <code>www.openml.org/r/id/json</code> (or add <code>/json</code> to the run page's url).</p>
	<p>Example: <a href="r/1/json"><code>www.openml.org/r/1/json</code></a></p>

	<h3 id="json_sql">Free SQL Queries</h3>
        <div class="bs-callout bs-callout-info" style="padding-top:20px;padding-bottom:20px">
          <p>Whenever the existing API functions do not cover your needs, it is possible to use direct SQL SELECT queries. The result will be returned in JSON format. </p>
          <p>The URL is 
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">http://www.openml.org/api_query/?q=&lt;urlencode(QUERY)&gt;</code></pre>
          </div>
          </p>
          <p>For instance, to request the result of <code>SELECT name,did FROM dataset WHERE name LIKE "iris%"</code>, invoke like this:
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">http://openml.liacs.nl/api_query/?q=SELECT%20name,did%20FROM%20dataset%20WHERE%20name%20LIKE%20%22iris%%22</code></pre>
          </div>
          </p>
          <p>Responses are always in JSON format, also when an error is returned. A typical response would be: 
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">{"status": "SQL was processed: 2 rows selected. ","id": "","time": 0.0020740032196045,"columns": [{"title":"name","datatype":"undefined"},{"title":"did","datatype":"undefined"},{"title":"url","datatype":"undefined"}],"data": [["iris","61","http:\/\/openml.liacs.nl\/files\/download\/61\/dataset_61_iris.arff"],["iris","282","http:\/\/openml.liacs.nl\/files\/download\/49033\/iris.arff"]]}
</code></pre>
          </div>
          <p>Please first consider using regular API functions before using this function. The database structure will likely evolve over time, which may break your code. If you need further API functions, simply let us know, or <a href="https://github.com/openml/OpenML/issues">open a new issue</a>.</p>
        </div>

  </div>
  <!-- end row -->
</div>
<!-- end container -->
