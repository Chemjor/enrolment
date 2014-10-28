<?php 
session_start();
	include('includes/conf.php');
	$grade=mysql_real_escape_string($_POST['grade']);
	$stud=mysql_real_escape_string($_POST['studno']);
	$code=mysql_real_escape_string($_POST['code']);
	$sub=$_SESSION['sub_id'];
	if($grade >=4.0)
	{
		$remarks="Fail";
	}
	elseif($grade>1.0 && $grade<=3.0)
	{
		$remarks="Pass";
	}



	if(!is_numeric($grade) || $grade<0)
	{
		header("Location:grading_pg.php?error=error&name=$code&id=$sub");
	}
	else
	{
		
	$query=mysql_query("select grade from subject_enrolled where studno='$stud' AND sub_id='$sub'");
		if($query)
		{
			$numrows=mysql_num_rows($query);
			if($numrows==1)
			{
				$update=mysql_query("UPDATE subject_enrolled set grade='$grade', Remarks='$remarks' where studno='$stud' AND sub_id='$sub'");
				header("Location:grading_pg.php?name=$code&id=$sub");
			}
			else
			{
				header("Location:grading_pg.php?error=2&id=$sub&name=$code");
			}
		}
		else
		{
			header("Location:grading_pg.php?error=2&id=$sub&name=$code");
		}
	}
?>