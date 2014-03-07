<?php 	session_start();?>
<?php
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])))
	{
		header('Location:index.php');
	}

?>
<?php include('includes/header.php');?>
<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM. You are login as<font color="red"> 
<?php echo $_SESSION['username'];?> </font>|&nbsp;<a href="home.php"><span class="glyphicon glyphicon-home">Home</span></a>|
<a href="logout.php"><span class="glyphicons glyphicon-star">Logout</span></a>&nbsp;</div>
<div id="enrolment">
<script>
function getSubject(str)
{
if (str=="")
  {
  document.getElementById("results").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("results").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","load_subjects.php?q="+str,true);
xmlhttp.send();
}
</script>
<div id="pick_sub">
<?php
include('includes/conf.php');
	$id=$_GET['id'];
	$_SESSION['studno']=$id;
	$query=mysql_query("SELECT i.*,p.* FROM stud_information as i
	INNER JOIN payment as p ON p.studno=i.studno where p.studno='$id' 
	AND i.studno='$id'AND p.schoolyear='2014-2015' AND p.flag=0") or die('cannot query');
	$rows=mysql_fetch_assoc($query);
	$name=$rows['lname']."\t\t,".$rows['fname']."\t".$rows['mname']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rows['studno']."&nbsp;(".$rows['gender'].")";
	$course=$rows['course'];
	$grad=$rows['graduating'];
	$yrlevel=$rows['yrlevel'];
	$sem="Second";
	$yr="2014-2015";
	$coscode=$rows['coursecode'];
	$_SESSION['coscode']=$rows['coursecode'];
	
?>	
<div style="background-color:#300000"><h5 style="margin-top:0px;color:white;text-align:center;font-family:Tahoma"><?php echo $name;?></h5></div>
<div>
YrLevel:<?php echo $yrlevel;?><br>
Status:<?php echo $grad;?><br>
Semester:<?php echo $sem?><br>
Course:<?php echo $course;?><br>
School Year:<?php echo $yr;?>
</div>
<hr style='border:1px solid lightgrey'>
<div id="subjects">
<div id='loadslip'>


	<?php
	$studno=$_SESSION['studno'];
	if(isset($_GET['codes'])):
		$found= $_GET['codes'];
		$va=mysql_query("select * from subject_enrolled where studno='$studno' AND sub_code='$found'");
			if($nums=mysql_num_rows($va)>1):
				$row=mysql_fetch_assoc($va);
				echo "<div style='padding:3px;text-align:center;' class='alert-warning'>
				Subject Code Conflict at <font color='red'<b>".$row['sub_code']."</b></font>";
				echo "</div>";
			endif;

	endif;	
	
	$i=1;
	$conf="NO";

	$done=mysql_query("select * from subject_enrolled where (studno='$studno') AND (semester='$sem' AND yrlevel='$yrlevel')  order by sub_code");

		if($done)
		{
			echo "<table width='100%'><th>
				</th><th>Subject</th>
				<th>Sec</th>
				<th>Description</th>
				<th>Schedule</th>
				<th>Days</th>
				<th>Room</th>
				<th>Units</th>
				<th>CONFLICT</th>
				<th></th><tr/>";
			
				$total=mysql_num_rows($done);

				while($sub=mysql_fetch_assoc($done))
					{
					$id=$sub['id'];
					
					$code=$sub['sub_code'];
					echo "<td>".$i."</td><td>".$sub['sub_code']."</td><td>".$sub['sub_section']."<td>".$sub['description']."</td>
					<td>".$sub['schedule']."</td><td>".$sub['days']."</td><td>".$sub['room']."</td><td>".$sub['sub_units']."</td>
					<td>$conf</td>
					<td><a href='del_subject.php?sub=$id'><span class='glyphicon glyphicon-Remove-Circle'title='Delete'></span></a></td><tr/>";
					$i++;
					}
						echo"</table>";
						$done=mysql_query("select sum(sub_units) as units,semester,yrlevel,print from subject_enrolled where studno='{$_SESSION['studno']}' AND print=0");
						$check=mysql_fetch_assoc($done);
						$count=$check['units'];
						echo "<hr style='border:1 solid lightgrey'>";
						if(isset($_GET['time'])):
							$time=$_GET['time'];
							$sql=mysql_query("select * from subject_enrolled where 
								(studno='$studno' AND yrlevel='$yrlevel') AND (schedule='$time' AND semester='$sem')");
							if($set=mysql_num_rows($sql)>1):
								$data=mysql_fetch_assoc($sql);

								echo "<div style='color:red'><font color='green'><b>". $data['sub_code']."</b></font> conflict at this ".$data['schedule']."</div>";
							endif;

						endif;
						echo"<div style='margin:5px' class='pull-right'> Number of subjects added: $total | Total Units $count</div><br><br>";
						//validate the correct units to be take within that semester in correspondence to the courseId
						$subunits=mysql_query("select * from subject_units where course_id='$coscode' AND yrlevel='$yrlevel' and semester='$sem'");
						$rows=mysql_fetch_assoc($subunits);
						if($rows['course_id']=$coscode && $rows['yrlevel']==$yrlevel && $rows['semester']==$sem)
						{
							$units=$rows['units'];
							if($count>0 && $count<=$units)
							{
								$id=$yrlevel;
								echo"<div class='pull-right' style='margin:10px'>
								<a href='print_load.php?id=$id'>Print <span class='glyphicon glyphicon-print'></span></a>
								</div>";
							}
							else
							{
								echo "<div class='alert alert-danger' style='color:darkred;text-align:center;padding:2px'>
								Required to take <b><font color='green'>$units</font></b> Units this <b><font color='green'>
								 $sem</font></b>Semester</div>";
							}
						}
					
	}
	?>
<div>
<hr style="border:1px dotted lightgrey">
<script type="text/javascript">
	$(document).ready(function(){
		$('.view').click(function(){
			$('.view').fadeOut();
		});
	});
</script>
<div id="view" class="view" style="cursor:pointer;background-color:#2B1B17;
color:white;text-align:;text-decoration:underline"><span class="glyphicon glyphicon-exclamation-sign"></span> Curriculum
<span class="glyphicon glyphicon-share-alt"></span></div>
<div id="cur_sub" style="padding:4px;height:300px;overflow-y:scroll;display:none;">
<div style="overflow-y:scroll;height:200px">	
	<?php
	$test=$_GET['id'];
	$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='First' AND e.yrlevel='1')");
		if($query)
		{
			echo "<div class='alert-info' style='text-align:center'>1 YEAR FIRST SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th>Subject</th>
			<th>Description</th>
			<th>Year Level</th>
			<th>School Year</th>
			<th>Grade</th>
			<th>Remarks</th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'><td>".$row['sub_code']."</td>";
				echo"<td>".$row['description']."</td>";
				echo"<td>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td>".$row['schoolyear']."</td>";
				echo"<td>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}
		echo "<br>";
		
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='Second' AND e.yrlevel='1')");

		if($query)
		{
			echo "<div class='alert-info' style='text-align:center'>1 YEAR SECOND SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}
		echo "<br>";
	//2 yr First semester	
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='First' AND e.yrlevel='2')");

		if($query)
		{
			echo "<div class='alert-info' style='text-align:center'>2 YEAR FIRST SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}
echo "<br>";
	//2 yr second semester	
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='Second' AND e.yrlevel='2')");

		if($query)
		{
			echo "<div class='alert-info'style='text-align:center'>2 YEAR SECOND SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}
		echo "<br>";
	//3 yr First semester	
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='First' AND e.yrlevel='3')");
		if($query)
		{
			echo "<div class='alert-info' style='text-align:center'>3 YEAR FIRST SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}
		echo "<br>";
	//3 yr second semester	
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='Second' AND e.yrlevel='3')");

		if($query)
		{
			echo "<div class='alert-info' style='text-align:center'>3 YEAR SECOND SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}
		echo "<br>";
	//4 yr First semester	
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='First' AND e.yrlevel='4')");

		if($query)
		{
			echo "<div class='alert-info'style='text-align:center'>4 YEAR FIRST SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}	
		echo "<br>";
	//4 yr second semester	
	$test=$_GET['id'];

		$query=mysql_query("select c.*,e.* from 
			curriculum as c inner join subject_enrolled as e on e.sub_code=c.sub_code where (e.studno='$studno')
			AND (e.semester='Second' AND e.yrlevel='4')");

		if($query)
		{
			echo "<div class='alert-info'style='text-align:center'>4 YEAR SECOND SEMESTER</div>";
			if($exist_rows=mysql_num_rows($query)>0)
			{	
			echo "<table width='100%' style='padding:2px' >";
			echo "<tr style='background-color:green'>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			</tr>";
			while($row=mysql_fetch_assoc($query))
			{
				$rem="-";
				echo"<tr class='alert-danger' style='padding:3px;color:green'>
				<td width='13%'>".$row['sub_code']."</td>";
				echo"<td width='45%'>".$row['description']."</td>";
				echo"<td width='11%'>".$row['yrlevel']."</td>";
				//echo"<td>".$row['semester']."</td>";
				echo "<td width='15%'>".$row['schoolyear']."</td>";
				echo"<td width='7%'>".$row['grade']."</td>";
				echo"<td>".$row['Remarks']."</td></tr>";
			}
			echo "</table>";
		}
		}
		else{echo "Error";}													
	?>
	</div>
<br>
<div id="testing">
<div class="alert-info" style="text-align:center;font-weight:bold;font-size:15px;font-family:TimesRoman">
Subjects to be taken <?php echo $sem;?> Semester. Year <?php echo $yr;?></div>
		<?php

		$query=mysql_query("select * from curriculum where (course_id='$coscode' or course_id='') AND (semester='$sem' AND yrlevel='$yrlevel') order by yrlevel");

		if($query)
		{	
					echo "<table width='100%' style='padding:10px' >";
					echo "<th>Subject</th>
					<th>Description</th>
					<th>Prequisite Subject</th>
					<th>Year Level</th>
					<th>Semester</th>
					<tr/>";
					while($row=mysql_fetch_assoc($query))
					{
						
						echo"<td>".$row['sub_code']."</td>";
						echo "<td>".$row['description']."</td>";
						echo "<td>".$row['prequisite_sub']."</td>";
						echo "<td>".$row['yrlevel']."</td>";
						echo "<td>".$row['semester']."</td>
						<tr/>";
						
			
					}
					echo "</table>";
		}
		else{echo "Error";}
	?>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		$('#view').click(function(){
			$('#cur_sub').fadeIn(1000);
		});
	});
</script>
</div>
</div>
	<div id="results">
	</div>
<?php
if(isset($_GET['exist'])){
	if($_GET['exist']=='1')
	{
	//$error= "<div class='alert-danger' style='margin:10px;text-align:center'>The subject Conflicts</div>";
	$yes="YES";
	}
	elseif($_GET['exist']=='2')
	{
	echo "<div class='alert-danger' style='margin:10px;text-align:center'></div>";

	}
}	
?>	
	<!--<?php if($error!=''){echo $error;}?>-->
</div>
</div>

<div id="enroling_student">
<div style="background-color:#300000;font-size:15px;color:white;height:25px">
Subjects to take this <?php echo $sem." semester ".$yr;?>
	<input  class='form-control pull-right'style='text-align:center;height:25px;font-weight:bold;width:200px;color:black' type='text' placeholder='Type Subject' id='search' name='search' />
					
</div>
<div id="" class="dropdown dropdown-processed">

	<?php 
	
		$error='';
		if(isset($_GET['show_pre']))
		{

			if($_GET['show_pre']=='1')
			{
				$id=$_GET['codes'];
				$sql=mysql_query("select * from curriculum where sub_code='$id'");
				$row=mysql_fetch_assoc($sql);
				echo"<div class='alert-info' style='color:green;text-align:center;font-size:15px'>
					You have FAILED IN <font color='red'>".$row['prequisite_sub']."</font>
					<span class='glyphicon glyphicon-exclamation-sign'></span>
				</div>";
			}
		}
	?>
	<?php 

		if(isset($_GET['codes']))
		{

				$id=$_GET['codes'];
				$sql=mysql_query("select * from subject_enrolled where (sub_code='$id') 
					and (studno='{$_SESSION['studno']}' AND semester='$sem') AND (yrlevel='$yrlevel')");
				if($row=mysql_fetch_array($sql)>0)
				{
				echo"<div class='alert-info' style='color:red;text-align:center;font-size:10px'>
					The Subject is enrolled.....
					<span class='glyphicon glyphicon-exclamation-check'></span>
				</div>";
				
			}
		}
	?>	
    <div  class="dropdown-container" style="display: none;font-family:century;font-size:8px">
<?php
			$sub_code=$_GET['codes'];
			$sub=$_GET['sub'];
			$coscode_code=$_SESSION['coscode'];
			$nrol=mysql_query("select count(sub_code) as code,schedule from subject_enrolled where sub_code='$sub_code'");
			$get=mysql_fetch_assoc($nrol);
			// $cnt=$get['code'];


			$times=$get['schedule'];
			 
			$query=mysql_query("select * from subject_offered where curriculum_id='$sub'");


				if($query)
				{
					 
				echo "<form id='myform'>";
					echo"<table  id='table'  width='100%'><thead>
					<th>SUBJECT</th>
					<th>SECTION</th>
					<th>DESCRIPTION</th>
					<th>SCHEDULE</th>
					<th>DAYS</th>
					<th>ROOM</th>
					<th>UNITS</th>
					<th>Enrolled</th>
					<th>LIMITS</th>
					</thead>";
					while($data=mysql_fetch_assoc($query))
					{

					$cnt = mysql_fetch_array(mysql_query("select count(id) as enrolled from subject_enrolled where sub_id = $data[sub_id]"));


					$id=$data['id'];
					$cods=$data['subject_code'];
					$studno=$_SESSION['studno'];
					$_SESSION['schedule']=$data['schedule'];
					$_SESSION['days']=$data['days'];
					//$_SESSION['sec']=$data['sections'];
					$link = $cnt['enrolled'] == $data['limits'] ? "#full" : "href='load_subjects.php?num=$id&id=$studno&yr=$yrlevel&sub=$sub&codes=$cods'";


					echo "<tr class='". ($cnt['enrolled'] == $data['limits'] ? 'alert-info' : '') ."'>
					<td><a $link>".$data['subject_code']."</a></td>
					<td>".$data['sections']."</td>
					<td>".$data['sub_description']."</td>
					<td>".$data['schedule']."</td>
					<td>".$data['days']."</td>
					<td>".$data['room']."</td>
					<td>".$data['sub_units']."</td>
					<td>$cnt[enrolled]</td>
					<td>".$data['limits']."</td>
					
					</tr>";
					
					}
					
					echo"</table>";
					echo"</form>";
					
				}
				else{echo "error query";}

			
		?>
  </div>
  <div id="curriculum">

  <?php
	$get=mysql_query("select * from curriculum where (yrlevel='$yrlevel') AND (semester='$sem' or semester='') 
			 AND(course_id='$coscode_code' OR course_id='') order by sub_code") or die(mysql_error());
	if($get)
	{
		echo "<table id='table' ' class='table table-condensed'>
		<thead>
		<th>SUBJECT CODE</th>
		<th>DESCRIPTION</th>
		<th>Prequisite</th>
		</thead><tbody>";
		while($result=mysql_fetch_assoc($get))
		{
			$code=$result['sub_code'];
			$sub=$result['id'];
			$_SESSION['sub']=$result['id'];
			echo "<tr><td class='target dropdown-link'><a href='enrol.php?id=$studno&sub=$sub&codes=$code'>". $result['sub_code']."</a></td>
			<td>".$result['description']."</td><td>".$result['prequisite_sub']."</td></tr>";
		}
		echo"<tbody><table>";
	}
?>
</div>


</div>
<!--filter rows-->

<script type="text/javascript">
$(document).ready(function(){

  $('div.dropdown').each(function() {
    var $dropdown = $(this);

  	
  	<?php if(isset($_GET['sub'])): ?>
      	$div = $("div.dropdown-container", $dropdown);
  		$div.slideToggle();
        $("div.dropdown-container").not($div).hide();
  	<?php endif; ?>

});
    
  $('html').click(function(){
    $("div.dropdown-container").hide();
  });
     
});
</script>
<!--end of filter rows-->


		<script type="text/javascript">
	
		var $rows = $('#table tbody tr');
		$('#search').keyup(function () {
		    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

		    $rows.show().filter(function () {
		        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		        return !~text.indexOf(val);
		    }).hide();
		});

</script>

</div>

</div>

</div>



