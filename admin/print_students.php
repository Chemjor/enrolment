<?php
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])) && !(isset($_SESSION['level'])=='100'))
	{
		header('Location:../index.php');
	}
?>
<h3>TEACHER: <?php echo $_SESSION['teacher'];?></h3>
<h3>SUBJECT: <?php echo $_SESSION['sub_code'];?></h3>
<h4>SUBJECT: <?php echo $_SESSION['semester'];?></h4>
<div style="margin-left:150px;text-align:center">

	<?php
	include('includes/conf.php');
	$id=$_GET['id'];
	//query
	$query=mysql_query("select stud_information.studno,payment.studno,payment.coursecode,payment.yrlevel,stud_information.fname,stud_information.mname,stud_information.lname,subject_enrolled.studno from stud_information inner join subject_enrolled on stud_information.studno=subject_enrolled.studno inner join payment on subject_enrolled.studno=payment.studno where subject_enrolled.sub_id='$id'");
					if($query){

							echo '<table id="tblSearch" class="table table-hover">
							
								<th>Studno</th>
								<th>Sur Name</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Course</th>
								<th>Year Level</th>

								<tr/>';		
							while($num=mysql_fetch_assoc($query))
								{
								echo"<tr>
									<td >".$num['studno']."</td>
									<td>".$num['lname']."</td>
									<td>".$num['fname']."</td>
									<td>".$num['mname']."</td>
									<td>".$num['coursecode']."</td>
									<td style='text-align:center' >".$num['yrlevel']."</td>
									
									</tr >";
								}
								echo '</table>';
							}

						else
						{
							echo "Cannot query the table";
							}		
	?>
	<script type="text/javascript">
	window.print();
	</script>

</div>
