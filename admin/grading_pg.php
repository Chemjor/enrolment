<?php
	session_start();
	if(!(isset($_SESSION['teacher'])) && !(isset($_SESSION['level'])))
	{
		header('Location:index.php');
	}
?>
<?php 
	include('includes/header.php');
	include('includes/conf.php');
?>

<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">
WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM. You are login as<font color="red"> <?php echo $_SESSION['teacher'];?> </font>| 
<a href="logout.php"><span class="glyphicon glyphicon-remove">Logout</span></a>&nbsp;|&nbsp;<a href="instructor_home.php">
<span class="glyphicon glyphicon-home">Home</span></a></div>
<div style="font-weight:bold;color:white;background-color:maroon">
SUBJECT:<?php  echo $_GET['name'];?><br>
</div>
<!--Script ajax to send the data to php file-->


<!--Script ajax to send the data to php file-->

<div class="main">
<?php
	if(isset($_GET['error'])){
		if ($_GET['error']=='error') {
			echo "<div style='text-align:center;padding:2px;'class='alert alert-danger'>Thats not valid number!</div>";
		}

	}
?>
	<div id="offered">
	<?php
		$id=$_GET['id'];
		$i=1;
			$query=mysql_query("select distinct stud_information.studno,payment.studno,payment.coursecode,payment.yrlevel,payment.flag,
				stud_information.fname,subject_enrolled.Remarks,stud_information.mname,stud_information.lname,subject_enrolled.sub_code,subject_enrolled.sub_id,subject_enrolled.grade,subject_enrolled.studno from stud_information
				 inner join subject_enrolled on stud_information.studno=subject_enrolled.studno inner join payment on 
				 subject_enrolled.studno=payment.studno where subject_enrolled.sub_id='$id' and payment.flag='0'");
					if($query){

							echo '<table class="table table-hover">
								<tr style="background-color:lightgrey">
								<th></th>
								<th>Studno</th>
								<th>Sur Name</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Grade</th>
								<th>Remarks</th>
								<th>SUBMISSION</th>
							
								<tr/>';		

							while($num=mysql_fetch_assoc($query))
								{
									$grade=$num['grade'];
									$code=$num['sub_code'];
									$_SESSION['sub_id']=$num['sub_id'];
									$_SESSION['studno']=$num['studno'];
									$stud=$num['studno'];

									echo"<tr>
									<td>".$i."</td>
									<td>".$num['studno']."</td>
									<td>".$num['lname']."</td>
									<td>".$num['fname']."</td>
									<td>".$num['mname']."</td>
									<td>".$num['Remarks']."</td>
									<form method='post' name='form' action='submit_grade.php'>
									<td>
									<input type='text' name='grade' style='width:50px;' id='content' value='$grade'>
									<input type='hidden' name='studno' style='width:50px;' id='content' value='$stud'>
									<input type='hidden' name='code' style='width:50px;' id='content' value='$code'>
									</td>
									<td><input type='submit' class='btn btn-default' style='width:70px;' value='SUBMIT'></td>
									
									</form>
									</tr >";
									$i++;
								}
								echo '</table>';
						

							}

						else
						{
							echo "Cannot query the table";
						}		
	?>

	</div>

</div>

<?php include('includes/footer.php');?>