<html>
<body>
	<h3>Welcome to OpenML</h3>
	<p>Before you go out and play on OpenML, please verify your email address.</p>
	<p>Click this link to <?php echo anchor('frontend/page/profile_activate/id/'. $id .'/code/'. $activation, 'Activate Your Account');?>.</p>

	<p>If you are unable to click the link, please copy/paste this url: <?php echo BASE_URL; ?>profile_activate/id/<?php echo $id .'/code/'. $activation; ?></p>

	<p>If you did not create an OpenML account using this address, please contact us at openmachinelearning@gmail.com.</p>
</body>
</html>
