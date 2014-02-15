<?php
session_start();
include('includes/conf.php');
$id=$_GET['sub'];
$stud=$_SESSION['studno'];
$query=mysql_query("delete from subject_enrolled where id='$id'");
if($query)
{
header("Location:enrol.php?del=1&id=$stud");
}
else
{
header("Location:enrol.php?del=0");
}
?>