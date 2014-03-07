<?php 	session_start();?>

<?php
include("includes/conf.php");
include("includes/db_func.php");
$id =$_GET['num'];
$yr=$_GET['yr'];
$sub = $_GET['sub'];
$cods=$_GET['codes'];
	$query=mysql_query("select * from subject_offered where id='$id'");
	
				$data=mysql_fetch_assoc($query);
				$ids=trim($data['sub_id']);
				$code=trim($data['subject_code']);
				$sec=trim($data['sections']);
				$des=trim($data['sub_description']);
				$units=trim($data['sub_units']);
				$room=trim($data['room']);
				$sched=trim($data['schedule']);
				$sem=trim($data['semester']);
				$days=trim($data['days']);
				$schol="2014-2015";
				$grade="";
				$remarks="IR";	
				$studno=$_SESSION['studno'];
				$_SESSION['code']=$data['subject_code'];
				$_SESSION['sem']=$data['semester'];
				$_SESSION['sections']=$data['sections'];


			// Check Pre requisites
			$sql_pre = db_select('curriculum', '*', "where id = $data[curriculum_id]", true);
			$pre_sub_code = "'".str_replace(',', "','", $sql_pre->prequisite_sub)."'";

			// echo "select * from subject_enrolled where sub_code IN($pre_sub_code) and remarks IN('IR','INC', 'FAIL')";
			// Check if has pre requisite
			if($sql_pre->prequisite_sub):
				$pre_results = db_select('subject_enrolled', '*', "where studno='$studno' and (sub_code IN($pre_sub_code)) AND(remarks IN('IR','INC', 'FAILED'))");
				
				if($pre_results):
					header("location:enrol.php?exist=1&id=$studno&sub=$sub&codes=$cods&show_pre=1&time=$sched");
					die();
				endif;
			endif;



			//update subject_enrolled table
				$check=mysql_query("select * from subject_enrolled where (studno='$studno' AND schedule='$sched'
				 AND days='$days') AND sub_code='$code'") or die('Your Table cannot be queried');
				if($check){
					
					$num=mysql_num_rows($check);
					if($num>0)
					{
						header("Location:enrol.php?exist=1&id=$studno&sub=$sub&codes=$cods&time=$sched");
					
					}
					else
					{
						$sql=mysql_query("INSERT INTO subject_enrolled(studno,sub_id,sub_code,description,sub_units,sub_section,
											schedule,days,room,yrlevel,schoolyear,semester,grade,print,Remarks,printed_date)
											VALUES('$studno','$ids','$code','$des','$units','$sec','$sched','$days',
												'$room','$yr','$schol','$sem','$grade','','$remarks',now())");
							if($sql)
							{
							header("Location:enrol.php?exist=2&id=$studno&sub=$sub&codes=$cods&time=$sched");
							
							}
							else
							{
								echo "Cannot insert into the table";
								
							}

					}
						
	}
mysql_close();
?>