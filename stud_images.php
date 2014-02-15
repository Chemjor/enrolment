<?php session_start();?>
<?php include('includes/header.php');?>
<script language="camera/jquery.min.js"></script>
		<script language="camera/swfobject.js"></script>
		<script language="JavaScript" src="camera/scriptcam.js"></script>
		<script language="JavaScript"> 
			$(document).ready(function() {
				$("#webcam").scriptcam({
					showMicrophoneErrors:false,
					onError:onError,
					cornerRadius:20,
					cornerColor:'e3e5e2',
					onWebcamReady:onWebcamReady,
					uploadImage:'upload.gif',
					onPictureAsBase64:base64_tofield_and_image
				});
			});
			function base64_tofield() {
				$('#formfield').val($.scriptcam.getFrameAsBase64());
			};
			function base64_toimage() {
				$('#image').attr("src","data:image/png;base64,"+$.scriptcam.getFrameAsBase64());
			};
			function base64_tofield_and_image(b64) {
				$('#formfield').val(b64);
				$('#image').attr("src","data:image/png;base64,"+b64);
			};
			function changeCamera() {
				$.scriptcam.changeCamera($('#cameraNames').val());
			}
			function onError(errorId,errorMsg) {
				$( "#btn1" ).attr( "disabled", true );
				$( "#btn2" ).attr( "disabled", true );
				alert(errorMsg);
			}			
			function onWebcamReady(cameraNames,camera,microphoneNames,microphone,volume) {
				$.each(cameraNames, function(index, text) {
					$('#cameraNames').append( $('<option></option>').val(index).html(text) )
				}); 
				$('#cameraNames').val(camera);
			}
		</script> 

<div style="text-align:center;color:green;padding:5px;background-color:#CCCCFF;border-radius:5px">WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM. You are login as<font color="red"> <?php echo $_SESSION['username'];?> </font>
|&nbsp;<a href="logout.php"><span class="glyphicon glyphicon-flash ">Logout</span></a></div>

<div id="container">
	<div id="images">
		<div id="left_studno">
			<input type="text" style="text-align:center;font-family:century;font-weight:bold;font-size:17px;" name="studno" class="form-control" placeholder="Enter Studno"/>

		</div>
		<div id="right_cam">
			<div style="height:440px;margin:2px;background-color:white">
				
			</div>
			<div>
				<input type="submit" style="width:200" class="btn btn-default" name="stud_image" value="TAKE IMAGE" />
				<input type="submit"   class="btn btn-default" name="stud_image" value="SUBMIT" />
			</div>
		</div>
		
	</div>
</div>	

<?php 
//http://stackoverflow.com/questions/18568491/image-upload-by-webcam-in-php
include('includes/footer.php');?>
