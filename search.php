<?php
session_start();
include('includes/conf.php');
$term = strip_tags(substr($_POST['searchit'],0, 100));
$term = mysql_real_escape_string($term); // Attack Prevention
if($term=="")
echo "<div class='alert alert-warning alert-dismissable'>Enter LastName or Stud No.</div>";
else{
$query = mysql_query("select stud_information.studno,stud_information.lname,stud_information.fname,
	stud_information.mname,stud_information.or_num,courses.courseid,courses.name from stud_information
	 inner join courses on stud_information.course=courses.name where studno='$term' || lname='$term'");
$string = '';

if (mysql_num_rows($query)>0){
$string="<table class='table table-alert' width='80%' style='padding:4px;color:grey;font-size:15px;'>";
$num=mysql_num_rows($query);

while($row = mysql_fetch_assoc($query)){
	
if($_SESSION['level']==100){
$id=$row['studno'];
$code=$row['courseid'];
$or=$row['or_num'];
$string.="<td><a title='Edit' href='_stud_edit.php?id=$id'><span style='font-size:8px' class='glyphicon glyphicon-edit'>
</span></a>
<a title='Enrol' href='check_stud.php?id=$id&code=$code'>$id </a></td>";
$string .= "<td>".$row['lname']."</td>";
$string .= "<td>".$row['fname']."</td>";
$string .= "<td>".$row['mname']."</td>";

$string .= "<tr/>\n";
}
else
{
$id=$row['studno'];
$code=$row['courseid'];
$or=$row['or_num'];
$string.="<td><a title='Enrol' href='check_stud.php?id=$id&code=$code'>$id </a></td>";
$string .= "<td>".$row['lname']."</td>";
$string .= "<td>".$row['fname']."</td>";
$string .= "<td>".$row['mname']."</td>";
$string .= "<tr/>\n";
}

}
$string.= "...$num record found";
}else{
$string = "<div class='alert alert-warning alert-dismissable'>No matches found!</div>";
}

echo $string;
}
?>