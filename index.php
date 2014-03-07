
<?php include('includes/header.php');?>
<!-- Main container-->
	<div id="main">
		<div class="alert alert-info" style="text-align:center;padding:10px;font-size:25px;color:#AA0D0D;font-weight:bold">CURRICULLUM-BASED ENROLMENT SYSTEM</div>
		<div id="login_form">
		<br>
			<?php
				if(isset($_GET['error']))
				{
				if($_GET['error']=='1'){
				echo "<div style='padding:4px;' id='error'class='alert alert-danger alert-dismissable'>";
				echo "The Username Field is empty";
				echo"</div>";
				}
				if($_GET['error']=='2'){
				echo "<div style='padding:4px;' id='error' class='alert alert-danger lert-dismissable'>";
				echo "The Password Field is empty";
				echo"</div>";
				}
				if($_GET['error']=='3'){
				echo "<div id='error' style='padding:5px'class='alert alert-danger alert-dismissable'>";
				echo "Your Account is not yet Activated or incorrect username and password!";
				echo"</div>";
				}
				if($_GET['error']=='4'){
				echo "<div style='padding:4px' id='error'class='alert alert-danger alert-dismissable'>";
				echo "Cannot Query the Table";
				echo"</div>";
				}				
				}
				if(isset($_GET['logout']))
				{
					if($_GET['logout']=='1')
					{
					echo "<div id='error' style='padding:5px'class='logout alert alert-success alert-dismissable'>";
					echo "You Logged Out. Welcome again!";
					echo"</div>";
					}
					if($_GET['logout']=='0')
					{
					echo "<div id='error' style='padding:5px'class='alert alert-success alert-dismissable'>";
					echo "You are not registered User!";
					echo"</div>";
					}					
				}
			?>
			<script type="text/javascript">
				$(document).ready(function() { 
				    setTimeout(function() { 
				        $('#error').fadeOut(); 
				 }, 2000); 
				});
			</script>
			<form action="login_user.php" method="post" >
			<div style="background-color:#f5f5f5">
			<br>
			<div><center><input type="text" required="" style="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" name="username" placeholder="username" class="form-control"></div>
			<br>
			<div><center><input required="" style="padding:10px;font-family:vernada;font-weight:bold;font-size:15px" type="password" name="password" placeholder="password" class="form-control pull-center"></div>
			<br>
			<div>
			<center><input style="font-size:15px" type="submit" name="submit" class="btn btn-primary" value="LOGIN">
			<input style="font-size:15px" type="reset" name="submit" class="btn btn-danger" value="CANCEL">
			</center></div>
			</div>
			<br><br>
			</form>
			<div  style="text-align:center">
			<a href="sign_up.php"><font color="grey"><b>REGISTER</b></font></a> and wait for your Account to be activated.<br>
			<a href="sign_instructor.php"><font color="green"><b>SUBMIT GRADES HERE</b></font></a>
			</div>	
			
			
		</div>
		
<!--End of the main container-->	

<!--footer-->
<?php include('includes/footer.php');?>