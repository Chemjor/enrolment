<?php 
session_start();
	include('includes/header.php');
	include('includes/conf.php');
?>
	
	<div id="main">
		<div class="alert alert-info" style="text-align:center;padding:10px;color:#000033;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CURRICULLUM-BASED ENROLMENT SYSTEM</div>
		<div id="login_form" style="border:1px solid lightgrey">
		
		<div class="alert alert-info center "><center><b><span class="glyphicon glyphicon-lock"></span>&nbsp;ENTER YOUR ACCOUNT CODE# AND PASSWORD</b></center></div>
			
		<?php
		
		if($_POST)
		{
			$error='';
			$id=rand(1000,2000);
			$title=$_POST['title'];
			$fname=$_POST['fname'];
			$mname=$_POST['mname'];
			$lname=$_POST['lname'];
			$college=$_POST['col'];
			$suf=$_POST['suffix'];
			$code=$_POST['code'];
			$pass=$_POST['password'];
			$cpass=$_POST['confirm'];
			//query
			if($cpass!=$pass)
			{
				$error="Password and confirmation Password don't match";
			}
			else
			{
				$query=mysql_query("select * from teachers where password='$pass' and code='$code'");	
				if($query)
				{
					$numrows=mysql_num_rows($query);
					if($numrows==1)
					{
						$error="Your account Exist Already <a href='sign_instructor.php'>LOGIN</a>";
					}else
					{
						$level=0;
						$query=mysql_query("insert into teachers values('$id','$title','$fname','$mname','$lname','$suf','$college','$pass','$level','$code',now())");
						if($query)
						{
							$error="You Account is successfully Created! Wait For Confirmation";	
						}
						else
						{
							$error="Taking Long to create.....";
						}
						
					}

				}
				else
				{
					$error="Cannot Query the Record";
				}
			}
			
			
		}

		?>
		<div >

			<?php
				if(isset($error)){echo "<div class='alert alert-danger' style='padding:4px;text-align:center'>".$error."</div>";}
			?>
		<div style="background-color:#f5f5f5">	
		<form method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
		<div>
		<select name="title" required="" class="form-control">
			
		<option>MR</option>	
		<option>MRS</option>
		<option>MS</option>
		<option>DR</option>
		<option>MBA</option>
		<option>ENGR</option>
		</select>
		</div>
		<br>
		<div>
		<input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="text" name="fname" placeholder="First Name" class="form-control pull-center"></div>
		<br>	
		<div>
		<input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="text" name="mname" placeholder="Middle Name" class="form-control pull-center"></div>
		<br>
		<div>
		<input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="text" name="lname" placeholder="Last Name" class="form-control pull-center"></div>
		<br>
		<div>
		<input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="text" name="suffix" placeholder="Suffix" class="form-control pull-center"></div>
		<br>			
		<div>
		<input type="text" required="" style="font-family:vernada;font-weight:bold;font-size:15px" name="code" placeholder="#code" class="form-control"></div>
		<br>
		<div>
		<input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="password" name="password" placeholder="password" class="form-control"></div>
		<br>
		<div>
		<input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="password" name="confirm" placeholder="Confirm Password" class="form-control pull-center"></div>
		<br>
		<div><font family="vernada" size="3px" color="grey">College</font>
		<select required="" name="col" class="form-control"style="font-family:vernada;font-weight:bold;font-size:15px">
		<?php 
			$query=mysql_query("select * from colleges");
			while ($data=mysql_fetch_assoc($query)) 
			{
				echo "<option>".$data['collegeid']."</option>";
			}
		?>
		</select>
		</div>
		<br>		
		<div>
		<input style="font-size:14px" type="submit" name="submit" class="btn btn-primary " value="REGISTER">
		<input style="font-size:14px" type="reset" name="submit" class="btn btn-danger" value="CANCEL">
		</div>
		</div>
		</form>
			<div style="text-align:center;font-family:arial;font-size:14px;background-color:#FFF5EE">
			<a href="sign_instructor.php"><span class="glyphicon glyphicon-backward pull-left">LOGIN</span></a>Your Account will be Activated.<br>
			</div>
	</div>

<?php include('includes/footer.php');?>