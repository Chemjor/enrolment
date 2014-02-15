<?php
session_start();
include 'includes/conf.php';
include 'includes/db_func.php';
include 'models/subject.php';

if(isset($_GET['r']) && function_exists($_GET['r'])){

	$_GET['r']();

}