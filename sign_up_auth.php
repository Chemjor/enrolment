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
				header("Location:sign_up.php?login=fname");
				}
				elseif(empty($lname))
				{
				header("Location:sign_up.php?login=mname");
				}
				elseif(empty($username))
				{
				header("Location:sign_up.php?login=lname");
				}
				elseif(empty($password))
				{
				header("Location:sign_up.php?login=pass");
				}
				elseif(empty($cpass))
				{
				header("Location:sign_up.php?login=passc");
				}
				elseif($cpass != $password)
				{
				header("Location:sign_up.php?login=mismatch");
				}
				elseif(strlen($password) <5)
				{
				header("Location:sign_up.php?login=char");
				}
				else
				{
					$sql="select * from users where username='$username' and password='$password'";
					$query=mysql_query($sql);
					$rows=mysql_num_rows($query);
					if($rows>0)
					{
					header("Location:sign_up.php?login=exist");
					}
					else
					{
					$query=mysql_query("insert into users(fname,lname,username,password,date,status,level) values('$fname','$lname','$username','$password',now(),'$status','$level')") or die("Cannot Create the acoount!");
					if($query)
						{
					header("Location:sign_up.php?login=success");
						}
					else
						{
					header("Location:sign_up.php?login=error");
						}	
					}
				}	
				
			}
			
				foreach($errors as $error)
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'>";
					echo $error.'<br>';
				echo"</div>";
				}
			
			?>	