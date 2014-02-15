<?php
session_start();
	if($_SESSION['teacher'] || $_SESSION['level'])
	{
	session_destroy();
	unset($_SESSION['teacher']);
	header('Location:../sign_instructor.php?logout=1');
	}
?>