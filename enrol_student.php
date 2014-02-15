<?php session_start();?>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<?php
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
	$country=mysql_real_escape_string(trim($_POST['country']));
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
if($_POST['submit'])
{
	$auth=mysql_query("select * from users where password='$pass' and username='{$_SESSION['username']}'");
	$get=mysql_fetch_assoc($auth);
	$userin=$get['fname'];
	$nums=mysql_num_rows($auth);
	if($nums==1)
	{
		$sql="select * from stud_information where or_num='$orno'";
		$query=mysql_query($sql);
		if($query)
		{
			$rows=mysql_num_rows($query);
			if($rows>0)
			{
			header("Location:home.php?error=1");
			}
			else
			{
				$query=mysql_query("insert into stud_information values(
				NULL,'$fname','$mname','$lname','$sufname','$gender','$bday','$bplace',
				'$course','$street','$barangay','$town','$prov','$country','$contact',
				'$status','$parent','$parno','$father','$fatherno','$mother','$motherno',
				'$spouse','$spouseno','$numboy','$numgirl','$orno','$ordate',now(),'{$_SESSION['username']}')
				");
				header("Location:home.php?error=2");
			}
		}
		else
		{
		echo "cannot query the Table";
		}
	}
	else
	{
	header("Location:home.php?error=4");
	}
}

?>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
$_SESSION['speed']= 'Page generated in '.$total_time.' seconds.';
?>