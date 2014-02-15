<?php
session_start();
include('includes/conf.php');
		
			$code=mysql_real_escape_string(trim($_POST['code']));
			$pass=mysql_real_escape_string(trim($_POST['password']));
			$query=mysql_query("select * from teachers where code='$code' AND password='$pass' and level='69'");
			if($query)
			{
				$numrows=mysql_num_rows($query);
				$data=mysql_fetch_assoc($query);
				if($numrows==1)
				{
					$id=$data['teacher_id'];
					//header('Location:admin/grading_pg.php');
					header('Location:admin/instructor_home.php');
					$_SESSION['teacher']=$data['code'];
					$_SESSION['level']=$data['level'];
					$_SESSION['id']=$data['teacher_id'];
					$_SESSION['name_tr']=$data['title'].','.$data['lname'].'&nbsp;'.$data['fname'].'&nbsp'.$data['mname'];

				
				}
				else
				{
					header("Location:sign_instructor.php");
					$_SESSION['error']="<div style='text-align:center' class='alert alert-warning'>Your Credentials are incorrect! Consult the Admin</div>";
				
				}
			}
			else
			{
					header("Location:sign_instructor.php");
					$_SESSION['error']="<div style='text-align:center' class='alert alert-warning'>Cannot Query the record!</div>";
			}
	

?>