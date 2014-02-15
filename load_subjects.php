<?php 	session_start();?>
<?php
include("includes/conf.php");
$id =$_GET['num'];
$yr=$_GET['yr'];
	$query=mysql_query("select * from subject_offered where id='$id'");
		
			if($query)
			{
				$data=mysql_fetch_assoc($query);
				$ids=$data['sub_id'];
				$code=$data['subject_code'];
				$sec=$data['sections'];
				$des=$data['sub_description'];
				$units=$data['sub_units'];
				$room=$data['room'];
				$sched=$data['schedule'];
				$sem=$data['semester'];
				$days=$data['days'];
				$schol=$data['schoolyear'];
				$grade="";
				$remarks="INC";	
				$studno=$_SESSION['studno'];
				$_SESSION['code']=$data['subject_code'];
				$_SESSION['sem']=$data['semester'];
			//update subject_enrolled table
			$exist=mysql_query("select * from subject_enrolled where studno='$studno' and days='$days' and sub_code='$code'");
			if($exist)
			{
				if($num=mysql_num_rows($exist)>0)
				{
				header("Location:enrol.php?exist=1&id=$studno");
				
				}
				else
				{
					$sql=mysql_query("INSERT INTO subject_enrolled(studno,sub_id,sub_code,description,sub_units,sub_section,schedule,days,room,yrlevel,schoolyear,semester,grade,print,Remarks)
										VALUES('$studno','$ids','$code','$des','$units','$sec','$sched','$days','$room','$yr','$schol','$sem','$grade','','$remarks')");
						if($sql)
						{
						header("Location:enrol.php?exist=2&id=$studno");
						
						}
						else
						{
							echo "Cannot insert into the table";
							
						}

				}
			}
			
	}
mysql_close();
?>