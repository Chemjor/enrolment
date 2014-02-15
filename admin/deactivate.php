<?php
include('includes/conf.php');
$id=$_GET['id'];
	if(isset($_GET['id']))
	{
		$query=mysql_query("select user_id from users where user_id=$id");
		$row=mysql_fetch_assoc($query);
		$ids=$row['user_id'];
		if($ids==$id)
		{
		$activate=mysql_query("update users set status='Inactive' where user_id='$ids'")or die("cannot update");
			if($activate)
			{
			header('Location:manage.php?active=1');
			}
			else
			{
			header('Location:manage.php?active=2');
			}
			
		}
		else
		{
		echo "Cannot update User";
		}
	}
		

?>