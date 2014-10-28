<?php
$con=mysql_connect('localhost','root','den');
if($con)
{
$db=mysql_select_db('enrolment');

}
else echo "Cannot connect to the server";
?>