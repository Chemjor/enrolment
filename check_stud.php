<?php
include("includes/conf.php");
$cors=$_GET['code'];
$stud=$_GET['id'];
$schoolyear="2014-2015";
$sem="Second";
$yr="";
$query=mysql_query("select * from payment where studno='$stud' AND schoolyear='$schoolyear'
				 AND semester='$sem'");
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