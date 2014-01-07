<html>
<body>
	<h1>Activate account for <?php echo $identity;?></h1>
	<p>Please click this link to <?php echo anchor('frontend/page/profile_activate/id/'. $id .'/code/'. $activation, 'Activate Your Account');?>.</p>
</body>
</html>
