<!--header-->
<?php include('includes/header.php');?>

<!-- Main container-->
	<div id="main">
		<div class="alert alert-info" style="text-align:center;padding:10px;font-size:25px;color:#AA0D0D;font-weight:bold">CURRICULLUM-BASED ENROLMENT SYSTEM</div>
		<div id="login_form" style="">
		
		<div class="alert alert-info center " style="padding:10px;margin-top:50px;"><center><b><span class="glyphicon glyphicon-lock"></span>&nbsp;ENTER YOUR ACCOUNT USERNAME AND PASSWORD</b></center></div>
		<script type="text/javascript">
		$(document).ready(function(){
			setTimeout(function(){
				$('#error').fadeOut();},2000);
		});
		</script>	
		<?php
			if(isset($_GET['login']))
			{
				if($_GET['login']=='fname')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The First Name field is empty</div>";				
				}
				if($_GET['login']=='mname')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The Middle Name field is empty</div>";
				}
				if($_GET['login']=='lname')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The Last Name field is empty</div>";
				}
				if($_GET['login']=='pass')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The Password field is empty</div>";
				}
				if($_GET['login']=='passc')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The confirm Password field is empty</div>";
				}
				if($_GET['login']=='mismatch')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The Password don't match with confirm</div>";
				}
				if($_GET['login']=='char')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The password should be more than 5 characters</div>";
				}
				if($_GET['login']=='success')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The Account has been created!</div>";
				}
				if($_GET['login']=='exist')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> The User Account Exist</div>";
				}				
				if($_GET['login']=='error')
				{
				echo "<div id='error'class='alert alert-warning alert-dismissable'> Cannot Query the Table</div>";
				}				
			}
		?>
			<div style="background-color:#f5f5f5">		
			<form action="sign_up_auth.php" method="post">
			<div><center><input type="text" style="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" name="fname" placeholder="Firstname"  class="form-control"></div>
			<br>	
			<div><center><input type="text" style="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" name="lname" placeholder="Surname" class="form-control"></div>
				<br>
			<div><center><input type="text" style="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" name="username" placeholder="Username"  class="form-control"></div>
				<br>
			<div><center><input style="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" type="password" name="password" placeholder="password" class="form-control pull-center"></div>
			<br>
			<div><center><input type="password" sstyle="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" name="cpassword" placeholder="ConfirmPassword" class="form-control"></div>
				<br>
			<div><a href="index.php"><span class="glyphicon glyphicon-chevron-left">&nbsp;LOGIN</span></a>
			<center>
			<input style="font-size:15px" type="submit" name="submit" class="btn btn-primary" value="REGISTER">
			<input style="font-size:15px" type="reset" name="submit" class="btn btn-danger" value="CANCEL">	
			</center>
			</div>
			
			
			</form>
			</div>
		</div>
	
	</div>
	
<!--End of the main container-->	

<!--footer-->
<?php include('includes/footer.php');?>