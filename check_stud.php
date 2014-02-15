<?php
include("includes/conf.php");
$cors=$_GET['code'];
$stud=$_GET['id'];
$query=mysql_query("select * from payment where studno='$stud'");
$data=mysql_fetch_assoc($query);
$id=$data['studno'];
	if($numrows=mysql_num_rows($query)>0)
	{
	
	header("Location:home.php?id=$id&not=0");
	}
	else
	{
	header("Location:home.php?not=1");
	}
?>