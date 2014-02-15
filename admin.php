<?php
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])) && !(isset($_SESSION['level'])=='100'))
	{
		header('Location:index.php');
	}
?>
<?php include('includes/header.php');?>


<div id="content">
	<div class="navbar navbar-default">
	<a href="logout.php">Logout</a>
	<center>ADMIN</center>
	</div>
	<!--User Accounts-->
	<div id="admins">
	<?php
	include("includes/conf.php");
	
	$sql="select * from users";
	$query=mysql_query($sql);
	if($query)
	{
	echo"<table class='table table-hover'>";
	echo"<tr class='success'><th>User ID</th><th>Username</th><th>Date Registered</th><th>Status</th><th>Action</th></tr>";
	while($data=mysql_fetch_assoc($query))
	{
		$id=$data['user_id'];
		echo "<td>".$data['user_id']."</td><td>".$data['username']."</td><td>".$data['date']."</td><td>".$data['status']." </td><td><a href='update.php?id=$id'><img src='images/update.jpg' title='Activate' width='20' height='20'></a>|<a href='deactivate.php?id=$id'><img src='images/deactivate.jpg' title='Deactivate' width='20' height='20'></a></td><tr/>";
	}
	echo"</table>";
	}
	else echo"cannot query ";
	?>
	</div>
</div>
<?php include('includes/footer.php');?>