<?php
session_start();
	if($_SESSION['username'] || $_SESSION['status'])
	{
	session_destroy();
	unset($_SESSION['username']);
	header('Location:index.php?logout=1');
	}
?>