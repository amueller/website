<h2 id="team-core">Gamification</h2>

<p>Since May 2016, OpenML includes gamification. This is in the form of a score system and in the future will include badges as well. Because the system is still very much in development, the details are subject to change. Below, the score system is described in more detailed followed by our rationale for this system for those interested. If anything is unclear or you have any feedback of the system do not hesitate to let us know.</p>

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

<h3>Where to find it</h3>
<p>The number of likes and downloads as well as the reach and impact of knowledge pieces can be found on the top of their respective pages, for example the <a href='/d/61'>Iris data set</a>. In the top right you will also find the new Like button next to the already familiar download button.</p>
<p>When searching for knowledge pieces on <a href='/search'>the search page</a>, you will now be able to see the statistics mentioned above as well. In addition you can sort the search results on their downloads, likes, reach or impact.</p>
<p>On user profiles you will find all statistics relevant to that user, as well as graphs of their progress on the three scores.</p>

<h3>Badges</h3>
<p>Badges are intended to provide discrete goals for users to aim for. They are only in a conceptual phase, depending on the community's reaction they will be further developed. <br>
The badges a user has acquired can be found on their user profile below the score graphs. The currently implemented badges are:</p>
<dt>
<dd><b>Clockwork Scientist <img src='img/clockwork_scientist_1.svg' style="width:48px;height:48px;"></b></dd> For being active every day for a period of time. 
<dd><b>Team Player <img src='img/team_player_1.svg' style="width:48px;height:48px;"></b></dd> For collaborating with other users; reusing a knowledge piece of someone who has reused a knowledge piece of yours. 
<dd><b>Good News Everyone <img src='img/good_news_everyone_1.svg' style="width:48px;height:48px;"></b></dd> For achieving a high reach on singular knowledge piece you uploaded. 
</dt>
</p>

<h3>Downvotes</h3>
<p>Although not part of the scores, downvotes have also been introduced. They are inteded to indicate a flaw of a data set, flow, task or run that can be fixed, for example a missing description. </p>
<p>If you want to indicate something is wrong with a knowledge piece, click the number of issues statistic at the top the page. A panel will open where you either agree with an already raised issue anonymously or submit your own issue (not anonymously).</p>
<p>You can also sort search results by the number of downvotes, or issues on <a href='/search'>the search page</a>.</p>
