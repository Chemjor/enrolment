<?php
session_start();
include("includes/conf.php");
	$fname=mysql_real_escape_string(trim($_POST['fname']));
	$mname=mysql_real_escape_string(trim($_POST['mname']));
	$lname=mysql_real_escape_string(trim($_POST['lname']));
	$sufname=mysql_real_escape_string(trim($_POST['suf']));
	$gender=mysql_real_escape_string(trim($_POST['gender']));
	$bday=mysql_real_escape_string(trim($_POST['dob']));
	$bplace=mysql_real_escape_string(trim($_POST['bplace']));
	$course=mysql_real_escape_string(trim($_POST['course']));
	$street=mysql_real_escape_string(trim($_POST['street']));
	$barangay=mysql_real_escape_string(trim($_POST['barangay']));
	$town=mysql_real_escape_string(trim($_POST['town']));
	$prov=mysql_real_escape_string(trim($_POST['province']));
	$countrys=mysql_real_escape_string(trim($_POST['country']));
	$contact=mysql_real_escape_string(trim($_POST['contact']));
	$status=mysql_real_escape_string(trim($_POST['status']));
	$parent=mysql_real_escape_string(trim($_POST['parent']));
	$parno=mysql_real_escape_string(trim($_POST['parno']));
	$father=mysql_real_escape_string(trim($_POST['father']));
	$fatherno=mysql_real_escape_string(trim($_POST['fatherno']));
	$mother=mysql_real_escape_string(trim($_POST['mother']));
	$motherno=mysql_real_escape_string(trim($_POST['motherno']));
	$spouse=mysql_real_escape_string(trim($_POST['spouse']));
	$spouseno=mysql_real_escape_string(trim($_POST['spouseno']));
	$numboy=mysql_real_escape_string(trim($_POST['boys']));
	$numgirl=mysql_real_escape_string(trim($_POST['girls']));
	$orno=mysql_real_escape_string(trim($_POST['orno']));
	$ordate=mysql_real_escape_string(trim($_POST['ordate']));
	$pass=mysql_real_escape_string(trim($_POST['password']));
	$studno=mysql_real_escape_string(trim($_POST['studno']));
if($_POST)
{ 
	$auth=mysql_query("select * from users where password='$pass' and username='{$_SESSION['username']}'");
	$get=mysql_fetch_assoc($auth);

	$nums=mysql_num_rows($auth);
		if($nums==1)
		{	
			
			$query=mysql_query("UPDATE stud_information SET fname='$fname',mname='$mname',
			lname='$lname',sufname='$sufname',gender='$gender',civilstatus='$status',
			bday='$bday',bplace='$bplace',course='$course',street='$street',barangay='$barangay',town='$town',province='$prov',
			country='$countrys',contact='$contact',parent='$parent',parent_con='$parno',father='$father',father_con='$fatherno',
			mother='$mother',mother_con='$motherno',spouse='$spouse',spouse_con='$spouseno',numboy='$numboy',numgirl='$numgirl',
			or_num='$orno',or_date='$ordate',date_in=now(),user_in='{$_SESSION['username']}'where studno='$studno'");
			
			if($query)
			{
				header("Location:home.php?error=5");				
			}
			else
			{
			echo "<div class='alert-warning'>Cannot Update the Record</div>";
			}
		}
		else
		{
			echo "<div class='alert-warning'>Incorrect Password..</div>";
		}
}	
		?>