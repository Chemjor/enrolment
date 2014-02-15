<?php
include('includes/conf.php');
$id=$_GET['id'];
$query=mysql_query("select * from teachers where teacher_id='$id'");
if($query)
	{
		$update=mysql_query("UPDATE teachers set level='0' where teacher_id='$id'");
		if($update)
		{
			header("Location:instructors.php?done=2");
		}
		else
		{
			header("Location:instructors.php?done=0");
		}
	}
?>