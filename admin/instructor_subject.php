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
<span class="glyphicon glyphicon-home">Home</span></a>|<a href="manage_subjects.php">
<span class="glyphicon glyphicon-check">Subjects</span></a>|<a href="instructors.php">
<span class="glyphicon glyphicon-user">Instructor</span></a><a href="../logout.php">
<span class="glyphicon glyphicon-remove">Logout</span></a> </font>
</div>

<div id="manage"> SUBJECTS ASSIGNED TO <font color="maroon">
		<?php 
		$name=$_GET['name'];
		echo $name;
		?></font>
</div>

<div id='offered'>
		<?php
		$i=1;
					$id=$_GET['id'];
						$query=mysql_query("select * from subject_offered where instructor='$id'");
						if($query)
						{
							echo '<table id="tblSearch" class="table table-hover">
								<th></th>
								<th>Sub_ID</th>
								<th>Subject</th>
								<th>Section</th>
								<th>Description</th>
								<th>Units</th>
								<th>Schedule</th>
								<th>Days</th>
								<th>Rooms</th>
								<th>Limit</th>
								<th>Semester</th>
								<th style="font-weight:bold">Action</th>
							<tr/>';

							while($num=mysql_fetch_assoc($query))
							{
								$id=$num['sub_id'];
								$_SESSION['sub_code']=$num['subject_code'];
								$code=$num['subject_code'];
								$_SESSION['sections']=$num['sections'];
								$sem=$num['semester'];

								echo "
									<tr class='". ($num['block'] ? 'danger' : '') ."'>
									<td>".$i."</td>
									<td>".$num['sub_id']."</td>
									<td>".$num['subject_code']."</td>
									<td>".$num['sections']."</td>
									<td>".$num['sub_description']."</td>
									<td>".$num['sub_units']."</td>
									<td>".$num['schedule']."</td>
									<td>".$num['days']."</td>
									<td>".$num['room']."</td>
									<td>".$num['limits']."</td>
									<td>".$num['semester']."</td>
									<td >
									<a href='students_list.php?id=$id&name=$name&code=$code&sem=$sem' ><span class='glyphicon glyphicon-user' title='students'>Students</span></a>
									</td>";
									$i++;
							
							}

						echo "</table>";
					}
					
		?>
</div>
<?php include('includes/footer.php');?>