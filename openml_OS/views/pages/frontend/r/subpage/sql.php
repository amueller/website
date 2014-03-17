      <div class="redheader">
      <h1>SQL</h1>
      <p>Compose your own queries.</p>
      </div>

<div class="well" id="sqlbox"><textarea id="sql" name="sql"></textarea></div>
<div class="sqlmessage-buttonbox">
	<div class="sqlmessage"></div>
	<button id="sqlquery-btn" data-loading-text="Querying..." autocomplete="off" class="btn btn-info">
			Run Query
			</button>
</div>
<div id="dbschema">
    <div class="query-heading">
      <a data-toggle="collapse" href="#collapseDBSchema">
      <i class="fa fa-caret-down fa-fw"></i>  Show database schema</a>
    </div>
    <div id="collapseDBSchema" class="panel-collapse collapse">
      <div class="query-body">
      <div id="expdbschema">
	 <!--<div id="expdbtags"></div>

	 <div class="expdbtab" data-xpos="143" data-ypos="8"   data-tw="81"  data-th="111">#runModal</div>
	 <div class="expdbtab" data-xpos="145" data-ypos="145" data-tw="80"  data-th="57" >#dataModal</div>
	 <div class="expdbtab" data-xpos="26"  data-ypos="107" data-tw="81"  data-th="75" >#inputDataModal</div>
	 <div class="expdbtab" data-xpos="254" data-ypos="107" data-tw="79"  data-th="75" >#outputDataModal</div>
	 <div class="expdbtab" data-xpos="33"  data-ypos="247" data-tw="71"  data-th="75" >#datasetModal</div>
	 <div class="expdbtab" data-xpos="111" data-ypos="247" data-tw="71"  data-th="128">#evaluationModal</div>
	 <div class="expdbtab" data-xpos="204" data-ypos="248" data-tw="71"  data-th="75" >#modelModal</div>
	 <div class="expdbtab" data-xpos="280" data-ypos="248" data-tw="78"  data-th="75" >#predictionModal</div>
	 <div class="expdbtab" data-xpos="29"  data-ypos="386" data-tw="79"  data-th="93" >#dataQualityModal</div>
	 <div class="expdbtab" data-xpos="139" data-ypos="381" data-tw="80"  data-th="75" >#qualityModal</div>
	 <div class="expdbtab" data-xpos="247" data-ypos="385" data-tw="108" data-th="93" >#algorithmQualityModal</div>
	 <div class="expdbtab" data-xpos="37"  data-ypos="512" data-tw="81"  data-th="93" >#pprunModal</div>
	 <div class="expdbtab" data-xpos="154" data-ypos="510" data-tw="81"  data-th="92" >#bvrunModal</div>
	 <div class="expdbtab" data-xpos="267" data-ypos="510" data-tw="81"  data-th="111">#cvrunModal</div>
	 <div class="expdbtab" data-xpos="597" data-ypos="381" data-tw="102" data-th="134">#implementationModal</div>
	 <div class="expdbtab" data-xpos="557" data-ypos="24"  data-tw="94"  data-th="80" >#setupModal</div>
	 <div class="expdbtab" data-xpos="681" data-ypos="65"  data-tw="94"  data-th="74" >#componentModal</div>
	 <div class="expdbtab" data-xpos="391" data-ypos="65"  data-tw="86"  data-th="74" >#inputSettingModal</div>
	 <div class="expdbtab" data-xpos="453" data-ypos="423" data-tw="109" data-th="147">#inputModal</div>
	 <div class="expdbtab" data-xpos="737" data-ypos="423" data-tw="102" data-th="92" >#outputModal</div>
	 <div class="expdbtab" data-xpos="408" data-ypos="204" data-tw="103" data-th="57" >#algorithmSetupModal</div>
	 <div class="expdbtab" data-xpos="537" data-ypos="204" data-tw="114" data-th="56" >#functionSetupModal</div>
	 <div class="expdbtab" data-xpos="675" data-ypos="204" data-tw="100" data-th="58" >#workflowSetupModal</div>
	 <div class="expdbtab" data-xpos="541" data-ypos="310" data-tw="92"  data-th="55" >#functionModal</div>
	 <div class="expdbtab" data-xpos="810" data-ypos="9"   data-tw="85"  data-th="93" >#experimentModal</div>
	 <div class="expdbtab" data-xpos="680" data-ypos="310" data-tw="91"  data-th="57" >#workflowModal</div>
	 <div class="expdbtab" data-xpos="408" data-ypos="310" data-tw="102" data-th="58" >#algorithmModal</div>
	 <div class="expdbtab" data-xpos="815" data-ypos="204" data-tw="80"  data-th="129">#connectionModal</div>
	 <div class="expdbtab" data-xpos="810" data-ypos="114" data-tw="136" data-th="75" >#experimentalVariableModal</div>
	 <?php o("modals.php");?>-->
   </div>
   </div>
   </div>
</div>
