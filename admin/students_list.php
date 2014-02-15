<?php
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])) && !(isset($_SESSION['level'])=='100'))
	{
		header('Location:../index.php');
	}
?>
<?php include('includes/header.php'); ?>
<!-- ajax-->

<!--end ajax-->
<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">
WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM.You are login as<font color="red"> 
<?php echo $_SESSION['username'];?>|<a href="../home.php">
<span class="glyphicon glyphicon-home">Home</span></a>|<a href="instructors.php">
<span class="glyphicon glyphicon-user">Instructor</span></a>|<a href="../logout.php">
<span class="glyphicon glyphicon-remove">Logout</span></a> </font>
</div>

<div id="manage">
			 INSTRUCTOR: <?php $_SESSION['teacher']=$_GET['name']; echo $_GET['name'];?>
			 <br>
			 SUBJECT: <?php $code=$_GET['code']; echo $code;?>
			 <br>
			 SEMESTER: <?php $_SESSION['semester']=$_GET['sem'];$sem=$_GET['sem']; echo $sem;?> 
			
</div>

<div id="offered">
	<?php
	$id=$_GET['id'];
	//query
	$query=mysql_query("select stud_information.studno,payment.studno,payment.coursecode,
		payment.yrlevel,stud_information.fname,stud_information.mname,stud_information.lname,
		subject_enrolled.studno,subject_enrolled.Remarks,subject_enrolled.grade from stud_information inner join subject_enrolled on 
		stud_information.studno=subject_enrolled.studno inner join payment on 
		subject_enrolled.studno=payment.studno where subject_enrolled.sub_id='$id'");
					if($query){

							echo '<table id="tblSearch" class="table table-hover">
							
								<th>Studno</th>
								<th>Sur Name</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Course</th>
								<th>Year Level</th>
								<th>Grade</th>
								<th>Remarks</th>

								<tr/>';		
							while($num=mysql_fetch_assoc($query))
								{
								echo"<tr>
									<td>".$num['studno']."</td>
									<td>".$num['lname']."</td>
									<td>".$num['fname']."</td>
									<td>".$num['mname']."</td>
									<td>".$num['coursecode']."</td>
									<td >".$num['yrlevel']."</td>
									<td>".$num['grade']."</td>
									<td>".$num['Remarks']."</td>
									</tr >";
								}
								echo '</table>';
								if($numrow=mysql_num_rows($query)>0)
								{
									echo "<div ><button class='btn btn-default pull-right'><a href='print_students.php?id=$id'><span class='glyphicon glyphicon-print pull-right'>Print</span></a></button></div>";							
	
								}
								else
								{
									echo "<div style='text-align:center' class='alert alert-warning'>No students Enrolled to this subject</div>";
								}
							}

						else
						{
							echo "Cannot query the table";
									
							}
		
?>
</div>

<?php include('includes/footer.php');?>