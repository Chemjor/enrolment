<?php 
session_start();
	include('includes/header.php');
	include('includes/conf.php');
?>

	<div id="main">
		<div class="alert alert-info" style="text-align:center;padding:10px;font-size:25px;color:#AA0D0D;font-weight:bold">CURRICULLUM-BASED ENROLMENT SYSTEM</div>
		
		<div id="login_form" >
		<script type="text/javascript">
				$(document).ready(function() { 
				    setTimeout(function() { 
				        $('#error').fadeOut('slow'); 
				 }, 2000); 
				});
			</script>
			<br>
			<div style="background-color:#f5f5f5" >
			<?php
				if(isset($_SESSION['error']))
				{
					echo"<div id='error'>".$_SESSION['error'].'</div>';
				
				}
				else
				{

					unset($_SESSION['error']);
				}
			?>
			
			<form method="post" action="auth_inst.php" >
			
			<div>
			<br>
			<center>
			<input type="text" required="" style="font-family:vernada;font-weight:bold;font-size:15px" name="code" placeholder="#code" class="form-control">
			</div>
			<br>
			<div><center><input required="" style="font-family:vernada;font-weight:bold;font-size:15px" type="password" name="password" placeholder="password" class="form-control"></div>
			<br>
			<div><center>
			<button><input style="font-size:14px" type="submit" name="submit" class="btn btn-primary" value="LOGIN"></button>
			<button><input style="font-size:14px" type="reset" name="reset" class="btn btn-danger " value="CANCEL"></button>
			</center></div>
			
			</form>
			</div>
			<div style="text-align:center;font-size:14px;background-color:#FFF5EE">
			<a href="instru_sign_up.php">REGISTER</a> and wait for your Account to be activated.<br>
			</div>
	
		</div>

<?php include('includes/footer.php');?>