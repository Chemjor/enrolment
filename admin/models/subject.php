<?php
/*
* SUBJECT DB MODEL 
*/

function createSubject()
{
	$id=$_POST['id'];
	$sec=$_POST['sections'];
	$code=$_POST['subject_code'];
	$sched=$_POST['schedule'];
	$room=$_POST['room'];
	$sem=$_POST['semester'];
	$cos=$_POST['course_id'];
	$yr=$_POST['sub_yr'];
	$sql=mysql_query("select * from subject_offered where room='$room' AND course_id='$cos' AND semester='$sem' AND sub_yr='$yr' AND schedule='$sched'");
	$numrows=mysql_num_rows($sql);
	if($numrows==0)
	{//add a subject..
		db_insert('subject_offered', $_POST);
		$_SESSION['alert'] = 'success|New Subject Added';
		redirect('manage_subjects.php');
	}
	else
	{
		$_SESSION['alert'] = 'warning|Subject Exists in the Records!';
		redirect('manage_subjects.php');
	}

	
}

function updateSubject(){
	$id = $_POST['id'];

	db_update('subject_offered', $_POST, 'id', $id);

	$_SESSION['alert'] = 'success|<strong>Subject is successfully updated! </strong>';
	redirect('manage_subjects.php');
}

function blockSubject()
{
	$id = $_GET['id'];
	db_update('subject_offered', ['block'=>1], 'id', $id);

	redirect('manage_subjects.php');

}
function unblockSubject()
{
	$id=$_GET['id'];
	db_update('subject_offered', ['block'=>0], 'id', $id);

	redirect('manage_subjects.php');
}
function deletesubject()
{
	$id=$_GET['id'];
	$del=mysql_query("delete from subject_offered where id='$id'");
	if($del)
	{
		$_SESSION['alert'] = 'success|<strong>Subject Deleted successfully! </strong>';
		redirect('manage_subjects.php');
	}
	else
	{
		$_SESSION['alert'] = 'success|<strong>Can not Delete the Subject! </strong>';
		redirect('manage_subjects.php');
	}
}
function createUnits(){
		$id = $_POST['id'];
	
		db_insert('subject_Units', $_POST);
		$_SESSION['alert'] = 'success|New Units Added';
		redirect('man_units.php');

}
function updateUnits(){
	$id = $_POST['id'];
	$course = $_POST['course_id'];
	$sem = $_POST['semester'];
	$units = $_POST['units'];
	$yrlevel = $_POST['yr_level'];
	$update=mysql_query("update subject_units set course_id='$course',semester='$sem',units='$units',yrlevel='$yrlevel' where id='$id'");
	if($update){
		$_SESSION['alert'] = 'success|<strong>Units is successfully updated! </strong>';
		redirect('man_units.php');
	}
	else{
	$_SESSION['alert'] = 'success|<strong>Units cannot be updated! </strong>';
	redirect('man_units.php');
	}
}
function deleteUnits()
{
		$id=$_GET['id'];
	$del=mysql_query("delete from subject_units where id='$id'");
	if($del)
	{
		$_SESSION['alert'] = 'success|<strong>Units Deleted successfully! </strong>';
		redirect('man_units.php');
	}
	else
	{
		$_SESSION['alert'] = 'success|<strong>Can not Delete the Units! </strong>';
		redirect('man_units.php');
	}
}