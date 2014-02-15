			<?php
			include('includes/conf.php');
				$fname=mysql_real_escape_string($_POST['fname']);
				$lname=mysql_real_escape_string($_POST['lname']);
				$username=mysql_real_escape_string($_POST['username']);
				$password=mysql_real_escape_string($_POST['password']);
				$cpass=mysql_real_escape_string($_POST['cpassword']);
				$errors=array();
				if($_POST['submit'])
			{
				if(empty($fname))
				{
				//header("Location:sign_up.php?error=1");
				
				}
				elseif(empty($lname))
				{
				header("Location:sign_up.php?error=2");
				
				}
				elseif(empty($username))
				{
				header("Location:sign_up.php?error=3");
				
				}
				elseif(empty($password))
				{
				header("Location:sign_up.php?error=4");
				
				}
				elseif(empty($cpass))
				{
				header("Location:sign_up.php?error=5");

				}
				elseif($cpass != $password)
				{
				header("Location:sign_up.php?error=6");

				}
				elseif(strlen($password) <5)
				{
				header("Location:sign_up.php?error=7");
				
				}
				else
				{}
					$sql="select * from users where username='$username' and password='$password'";
					$query=mysql_query($sql);
					$rows=mysql_num_rows($query);
					if($rows>0)
					{
						//header("Location:sign_up.php?error=8");
					}
					else
					{
					$query=mysql_query("insert into users(fname,lname,username,password,date,status,level) values('$fname','$lname','$username','$password',now(),'$status','$level')") or die("Cannot Create the acoount!");
					if($query)
						{
						header("Location:sign_up.php?error=9");
						}
					else
						{
						header("Location:sign_up.php?error=10");
						
						}	
					}
					
				
			}


			?>