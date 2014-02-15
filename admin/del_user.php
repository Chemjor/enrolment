<?php
include('includes/conf.php');
	$id=$_GET['id'];
	$query=mysql_query("delete from users where user_id='$id'");
	if($query)
	{
	header("Location:manage.php?del=1");
	}
	else
	{
	header("Location:manage.php?del=0");
	}

?>