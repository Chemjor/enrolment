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
	$query=mysql_query("SELECT stud_information.fname,payment.semester,stud_information.gender,stud_information.lname,stud_information.mname,payment.studno,
	payment.course,payment.coursecode,payment.yrlevel,payment.graduating,payment.schoolyear FROM stud_information
	INNER JOIN payment ON payment.studno=stud_information.studno where payment.studno='$id' 
	AND stud_information.studno='$id'") or die('cannot query');
	$rows=mysql_fetch_assoc($query);
	$name=$rows['lname']."\t\t,".$rows['fname']."\t".$rows['mname']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rows['studno']."&nbsp;(".$rows['gender'].")";
	$course=$rows['course'];
	$grad=$rows['graduating'];
	$yrlevel=$rows['yrlevel'];
	$sem=$rows['semester'];
	$yr=$rows['schoolyear'];
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
	
		$error='';
		if(isset($_GET['del']))
		{

			if($_GET['del']=='0')
			{
				$error='Cannot delete';
			}
		}
	?>

	<?php
	$studno=$_SESSION['studno'];
	$i=1;
	$done=mysql_query("select * from subject_enrolled where studno='{$_SESSION['studno']}' order by sub_code");
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
	$conf="NO";
	$total=mysql_num_rows($done);
	while($sub=mysql_fetch_assoc($done))
		{
		$id=$sub['id'];
		echo "<td>".$i."</td><td>".$sub['sub_code']."</td><td>".$sub['sub_section']."<td>".$sub['description']."</td>
		<td>".$sub['schedule']."</td><td>".$sub['days']."</td><td>".$sub['room']."</td><td>".$sub['sub_units']."</td>
		<td>$conf</td>
		<td><a href='del_subject.php?sub=$id'><span class='glyphicon glyphicon-Remove-Circle'title='Delete'></span></a></td><tr/>";
		$i++;
		}
			echo"</table>";
			$done=mysql_query("select sum(sub_units) as units,semester,yrlevel from subject_enrolled where studno='{$_SESSION['studno']}'");
			$check=mysql_fetch_assoc($done);
			$count=$check['units'];
			echo "<hr style='border:1 solid lightgrey'>";
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
</div>
	<div id="results">
	</div>
<?php
if(isset($_GET['exist'])){
	if($_GET['exist']=='1')
	{
	$error= "<div class='alert-danger' style='margin:10px;text-align:center'>The subject Conflicts</div>";
	$yes="YES";
	}
	elseif($_GET['exist']=='2')
	{
	echo "<div class='alert-danger' style='margin:10px;text-align:center'></div>";

	}
}	
?>	
	<?php if($error!=''){echo $error;}?>
</div>
</div>

<div id="enroling_student">
<div style="background-color:grey;color:white;height:25px">
Subjects to take this <?php echo $sem." semester ".$yr;?>
	<input  class='form-control pull-right'style='text-align:center;height:25px;font-weight:bold;width:200px;color:black' type='text' placeholder='Type Subject' id='search' name='search' />
					
</div>
<div id="" class="dropdown dropdown-processed">
    <div class="dropdown-container" style="display: none;">
<?php
			$sub=$_GET['sub'];
			$coscode_code=$_SESSION['coscode'];
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
					<th>LIMITS</th>
					</thead>";
					while($data=mysql_fetch_assoc($query))
					{
					$id=$data["id"];
					$studno=$_SESSION['studno'];
					echo "<tr>
					<td><a href='load_subjects.php?num=$id&id=$studno&yr=$yrlevel&sub=$sub'>".$data['subject_code']."</a></td>
					<td>".$data['sections']."</td>
					<td>".$data['sub_description']."</td>
					<td>".$data['schedule']."</td>
					<td>".$data['days']."</td>
					<td>".$data['room']."</td>
					<td>".$data['sub_units']."</td>
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
	$get=mysql_query("select * from curriculum where yrlevel='$yrlevel' and semester='$sem'") or die(mysql_error());
	if($get)
	{
		echo "<table id='table' class='table table-stripped'>
		<thead>
		<th>SUBJECT CODE</th>
		<th>DESCRIPTION</th>
		</thead><tbody>";
		while($result=mysql_fetch_assoc($get))
		{
			$sub=$result['id'];
			$_SESSION['sub']=$result['id'];
			echo "<tr><td class='target dropdown-link'><a href='enrol.php?id=$studno&sub=$sub''>". $result['sub_code']."</a></td>
			<td>".$result['description']."</td></tr>";
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
  		$div.toggle('slow');
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



