<?php
			session_start();
			include('includes/conf.php');
				$username=mysql_real_escape_string($_POST['username']);
				$password=mysql_real_escape_string($_POST['password']);
				$errors=array();
				if($_POST['submit'])
		{
				if($username=="")
				{
				
				header("Location:index.php?error=1");
				}
				elseif($password=="")
				{
				header("Location:index.php?error=2");
				}
				else 
				{
				//query the table
				$sql="select * from users where username='$username'and password='$password' and status='Active'";
				$query=mysql_query($sql);
				if($query){
				$numrows=mysql_num_rows($query);
				if($numrows>0)
				{
				$row=mysql_fetch_assoc($query);
				echo $row['username'];
				header("Location:home.php");
				$_SESSION['username']=$row['username'];
				$_SESSION['level']=$row['level'];
				$_SESSION['status']=$row['status'];
				}
				else
				{
				header("Location:index.php?error=3");
				}
				}
				else
				{
				header("Location:index.php?error=4");	
				}
			}
		}
				

			?>			