<?php
	session_start();
	if(!(isset($_SESSION['teacher'])) && !(isset($_SESSION['level'])))
	{
		header('Location:sign_instructor.php');
	}
?>
<?php 
	include('includes/header.php');
	include('includes/conf.php');
?>
	
<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">
WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM. You are login as<font color="red"> <?php echo $_SESSION['name_tr'];?> </font>| 
<a href="logout.php"><span class="glyphicon glyphicon-remove">Logout</span></a>&nbsp;|&nbsp;<a href="instructor_home.php">
<span class="glyphicon glyphicon-home">Home</span></a></div>

<div id="offered">

	<?php

					$id=$_SESSION['id'];
						$query=mysql_query("select * from subject_offered where instructor='$id'");
						$i=1;
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
								$id=$num['subject_code'];
								$sub_id=$num['sub_id'];
								$_SESSION['sub_code']=$num['subject_code'];
								$_SESSION['sections']=$num['sections'];

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
									<a href='grading_pg.php?name=$id&id=$sub_id' ><span class='glyphicon glyphicon-view' title='students'>Students</span></a>
									</td>";
								$i++;
							}
							
						echo "</table>";
					}

	
	?>
</div>
<?php 
	include('includes/footer.php');
?>