<h2 id="team-core">Gamification</h2>

<p>Since March 2016, OpenML includes gamification. This is in the form of a score system and in the future will include badges as well. Because the system is still very much in development, the details are subject to change. Below, the score system is described in more detailed followed by our rationale for this system for those interested. If anything is unclear or you have any feedback of the system do not hesitate to let us know.</p>

<h3>The scores</h3>
<p>All scores are awarded to users and involve datasets, flows, tasks and runs, or knowledge pieces in short.<p>
<div class="row">
    <div class="col-sm-4">
        <h4 class="activity">Activity <i class="fa fa-bolt"></i></h4>
        <p>Activity score is awarded to users for contributing to the knowledge base of OpenML. This includes uploading knowledge pieces, leaving likes and downloading new knowledge pieces. Uploads are rewarded strongest, with 3 activity, followed by likes, with 2 activity, and downloads are rewarded the least, with 1 activity.</p>
    </div>
    <div class="col-sm-4">
        <h4 class="reach">Reach <i class="fa fa-rss"></i></h4>
        <p>Reach score is awarded to knowledge pieces and by extension their uploaders for the expressed interest of other users. It is increased by 2 for every user that leaves a like on a knowledge piece and increased by 1 for every user that downloads it for the first time.</p>
    </div>
    <div class="col-sm-4">
        <h4 class="impact">Impact <i class="material-icons" style="font-size: 16px">flare</i></h4>
        <p>Impact score is awarded to knowledge pieces and by extension their uploaders for the reuse of these knowledge pieces. A dataset is reused if it is used as input in a task and a flow is reused in runs. Impact is increased by half of the acquired reach of a reuse. So the impact of a dataset that is used in a single task with reach 10, is 5.</p>
    </div>
</div>

<h3>The rationale</h3>
<p>The main reason for gamification for OpenML is to encourage participation in the website's core ideas. That is the sharing and exploration of knowledge and getting credit for your work. The <span class="activity">activity</span> score serves the encouragement of sharing and exploration. <span class="reach">Reach</span> makes exploration easier (by finding well liked, and/or often downloaded knowledge pieces), while also providing a form of credit to the user. <span class="impact">Impact</span> is another form of credit that is closer in concept to citation scores. When OpenML becomes popular enough, these scores can become true altmetrics.</p>



<h3>In development</h3>
<dl>
  <dt>Downvotes</dt>
  <dd> will not be included in the three scores above, but will serve to improve exploration of knowledge. The idea is to provide an option to downvote a knowledge piece with a reason, for example a missing description. Downvotes are intended to indicate problems with a knowledge piece that negativily influence their (re)usability but does not make them unusable all together. When searching for knowledge pieces you can sort by the number downvotes.</dd>
  <dt>Badges</dt>
  <dd>are intended to provide discrete goals for users to aim for. For example their might be a badge for a user increasing their activity by at least 1 every day for a week, month or year. Another badge could be uploading a dataset that achieves an impact of at least 10,100 or 1000.</dd>
</dl>
