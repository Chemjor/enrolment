<?php
session_start();
include('includes/conf.php');
//student is enrolling..check
$studno=mysql_real_escape_string($_POST['studno']);
$orno=mysql_real_escape_string($_POST['orno']);
$pdate=mysql_real_escape_string($_POST['tut_date']);
$tut_amount=mysql_real_escape_string($_POST['tut_amount']);
$misor=mysql_real_escape_string($_POST['misor']);
$misdate=mysql_real_escape_string($_POST['misdate']);
$misamount=mysql_real_escape_string($_POST['mis_amount']);
$course=mysql_real_escape_string($_POST['course']);
$major=mysql_real_escape_string($_POST['major']);
$minor=mysql_real_escape_string($_POST['minor']);
$yrlevel=mysql_real_escape_string($_POST['yrlevel']);
$grad=mysql_real_escape_string($_POST['graduate']);
$scholar=mysql_real_escape_string($_POST['scholar']);
$grant=mysql_real_escape_string($_POST['grantamount']);
$status=mysql_real_escape_string($_POST['state']);
$semester=mysql_real_escape_string($_POST['sem']);
$codeid=mysql_real_escape_string($_POST['code']);
$schoolyr=mysql_real_escape_string($_POST['schoolyear']);
$pass=mysql_real_escape_string($_POST['password']);
if($_POST['submit'])
{
	$auth=mysql_query("select * from users where password='$pass' and username='{$_SESSION['username']}'");
	$get=mysql_fetch_assoc($auth);
	$userin=$get['fname'];
	$nums=mysql_num_rows($auth);
	if($nums==1)
	{
		$query=mysql_query("select * from payment where studno='$studno'") or die("Cannot query");
		$rows=mysql_num_rows($query);
		$check=mysql_fetch_assoc($query);
		$id=$check['studno'];
		$yrlevel=$check['yrlevel'];
		$codes=$check['coursecode'];
		$sem=$check['semester'];
		if($rows==1)
		{
			if($check['tut_orno']==$orno)
			{
				header("Location:enrol.php?done=0&id=$id&code=$codes&year=$yrlevel&sem=$sem");
			}
			elseif($check['tut_orno']!=$orno)
			{
				$update=mysql_query("UPDATE payment SET tut_orno='$orno',
				tut_ordate='$pdate',tut_amount='$tut_amount',mis_orno='$misor',
				mis_date='$misdate',mis_amount='$misamount',yrlevel='$yrlevel',graduating='$grad',
				scholarship='$scholar',grant_amount='$grant',schoolyear='$schoolyr',user_in='{$_SESSION['username']}',semester='$semester',updated=now() where studno='$studno'");		
				
				header("Location:enrol.php?done=3&id=$id&code=$codes&year=$yrlevel&sem=$sem");
				
			}
			else
			{
			echo "something is wrong";
			}

		}
		elseif($rows==0)
			{

			header("Location:enrol.php?code=$codes");
		
			}
			else
			{
			echo "cannot insert";
			}
		}else{echo "something is crazy";}
	}
	else
	{
		header("Location:enrol.php?id=$studno");
	}


?>