<?php
session_start();
 include('includes/conf.php');
 ?>
 <style type="text/css">
 #head
 {
	width:900px;
	
	margin-left:260px;

 }
#printload
{
	width:900px;
	height:500px;
	margin-left:160px;
}
#printload td
{
	font-size: 14px;
	font-family:arial;
}
#count
{
	margin-right: 2px;
}

 </style>
<?php
	$id=$_SESSION['studno'];
	$query=mysql_query("SELECT stud_information.course,stud_information.fname,payment.semester,stud_information.gender,
	stud_information.bday,stud_information.lname,stud_information.mname,payment.studno,payment.scholarship,payment.tut_amount,
	payment.tut_orno,payment.tut_ordate,payment.yrlevel,payment.graduating,
	payment.course,payment.coursecode,payment.yrlevel,payment.graduating,payment.schoolyear FROM stud_information
	INNER JOIN payment ON payment.studno=stud_information.studno where payment.studno='$id' 
	AND stud_information.studno='$id' AND payment.flag=0") or die('cannot query');
	$rows=mysql_fetch_assoc($query);
	$name=$rows['lname']."\t\t,".$rows['fname']."\t".$rows['mname'];
	$course=$rows['course'];
	$grad=$rows['graduating'];
	$yrlevel=$rows['yrlevel'];
	$sem=$rows['semester'];
	$yr=$rows['schoolyear'];
	$coscode=$rows['coursecode'];
	$gender=$rows['bday']."(".$rows['gender'].")";
	$college=$rows['course'];
	$mjor="None";

	//print the loadslip
	echo "<div id='head'>";
	echo "<center><table width='60%'>";
	echo "			
					<td width='100px'></td>
					<td style='width:200px;text-align:center'>
					Negros Oriental State University 
					(http://www.norsu.edu.ph)
					Main Campuses I & II
					Office of the University Registrar</td><td style='text-align:right'></td>";
	echo "</table></center>";
	echo "<table width='100%'>
	<td style='text-align:'>ENROLLMENT LOAD SLIP</td><td width='200px'></td>
	<td >".$sem." semester / ".$yr."</td>
	</table>";
	echo "</div>";
	if($rows['graduating']=='Y')
	{
		$ongoin="Graduating";
	}
	elseif($rows['graduating']=='N')
	{
		$ongoin="Ongoing";
	}

	echo "<div id='printload'>";

	echo "<hr><center>";
	echo "<table width='100%'>";
	echo "<tr><td style='text-align:left'>Student Number</td> <td style='text-align:left'> : ".$id."</td><td style='text-align:left'> Scholarship <td style='text-align:left'>: ".$rows['scholarship']."</td></tr>";
	echo "<tr><td style='text-align:left'>Full Name </td> <td>: ".$name."</td><td style='text-align:left'> Amount Paid<td style='text-align:left'> : ".$rows['tut_amount']."</td></tr>";
	echo "<tr><td style='text-align:left'>Date Birth / Gender </td> <td>: ".$gender."</td><td style='text-align:left'> OR Number <td style='text-align:left'>: ".$rows['tut_orno']."</td></tr>";
	echo "<tr><td style='text-align:left'>COllege/Course </td> <td>: ".$college."</td><td style='text-align:left'>Date Paid<td style='text-align:left'> :".$rows['tut_ordate']."</td></tr>";
	echo "<tr><td style='text-align:left'>Major/Minor </td> <td>: ".$mjor. "</td><td style='text-align:left'> Yr Level & Status <td style='text-align:left'>: ".$rows['yrlevel']." ".$ongoin."</tr>";
	echo "</table>";

	echo "<hr>";
	?>
		<?php
	$studno=$_SESSION['studno'];
	$done=mysql_query("select * from subject_enrolled where studno='{$_SESSION['studno']}' AND print='0' order by days");
	$i=1;
	if($done)
	{
	
	echo "<table width='100%'><th></th><th style='text-align:left'>Subject</th><th style='text-align:left'>Sec</th><th style='text-align:left'>Description</th><th style='text-align:left'>Schedule</th><th style='text-align:left'>Days</th><th style='text-align:left'>Room</th><th style='text-align:left'>Units</th><tr/>";
	$total=mysql_num_rows($done);
	while($sub=mysql_fetch_assoc($done))
		{
		$date=$sub['printed_date'];
		echo $date;
		$id=$sub['id'];
		$count=0;
		$code=$sub['sub_code'];
		echo "<td>".$i."</td><td>".$sub['sub_code']."</td><td>".$sub['sub_section']."<td>".$sub['description']."</td>
		<td>".$sub['schedule']."</td><td>".$sub['days']."</td><td>".$sub['room']."</td><td>".$sub['sub_units']."</td>
		<td><a href='del_subject.php?sub=$id'><span class='glyphicon glyphicon-Remove'title='Delete'></span></a></td><tr/>";
		$i++;

		}

	echo"</table>";
	echo "</center>";
	echo "<hr>";

		
}
	$data=mysql_query("select sum(sub_units) as units from subject_enrolled where studno='{$_SESSION['studno']}' AND print=0");
	$check=mysql_fetch_assoc($data);
	
	$count=$check['units'];	
	echo "</div";
	echo "</hr>";
	
	
?>
<?php
$yr=$_GET['id'];
$update=mysql_query("update subject_enrolled set print=1 where studno='$studno'");
?>
<div style="float:right">Total Units:<?php echo $count;?><br>No. Subjects:<?php echo $total; ?></div>
<div>
<br>
<p>When Its printed no further changes in this loadslip</p>
<p>Student Signature:__________________</p>
<p align="left">Printed  : <?php echo $date;?></p>
</div>
<script type='text/javascript'>
window.print();
</script>