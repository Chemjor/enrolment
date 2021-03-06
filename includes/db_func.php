<?php 
	

	function connect_db($db = false, $server = 'localhost', $user = 'root', $pass = ''){

		$db_connect = mysql_connect($server, $user,  $pass);
		
		if($db):
			$db_select = mysql_select_db($db, $db_connect);
			if(!$db_select) return false;
		endif;

		return $db_connect;

	}

	function create_db($name){

		$sql = "CREATE DATABASE  `$name`";
		return mysql_query($sql);

	}

	function create_tbl($name, $field_name = 'id', $fields){

		$sql = "CREATE TABLE  `$name` (
		`$field_name` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , $fields)";

		return mysql_query($sql);

	}

	function db_insert($tbl, $data, $show_sql = false, $is_html = true){

		$fields = array();
		$value = array();

		foreach($data as $field_name => $v):

			$fields[] = "`$field_name`";
			if(!$is_html)
			$value[] = "'".htmlentities($v, ENT_QUOTES)."'";
			else
			$value[] = "'".$v."'";

		endforeach;

		$sql = "INSERT INTO `$tbl` (".implode(',',$fields).") VALUES (".implode(',',$value).")";

		if($show_sql) echo $sql;
		else return mysql_query($sql) or die(mysql_error());

	}

	function insert_id(){
		return mysql_insert_id();
	}

	function db_update($tbl, $data, $field_name, $value, $ext_sql = ""){

		$set = array();

		foreach($data as $fname => $v):

			$set[] = "`$fname` = '".htmlentities($v, ENT_QUOTES)."'";

		endforeach;

		$sql = "UPDATE `$tbl` SET ".implode(',',$set)." WHERE $field_name = $value ".$ext_sql;
		// echo $sql;
		return mysql_query($sql);

	}

	function db_select($tbl, $fields = '*', $ext_sql = "", $single = false){

		$sql = "SELECT $fields FROM `$tbl` ".$ext_sql;
		if(!$single):
			$datas = array(); 
			$qry = mysql_query($sql) or die(mysql_error());
			if($qry):
				while($row = mysql_fetch_object($qry)):
					$datas[] = $row;
				endwhile;
				return $datas;
			endif;
		else:
			$qry = mysql_query($sql) or die(mysql_error());
			if($qry) return mysql_fetch_object($qry);
		endif;

		return false;
	}

	function db_num_rows($qry){
		return mysql_num_rows($qry);
	}

	function db_delete_row($tbl, $field_name = 'id', $value){

		$sql = "DELETE FROM `$tbl` WHERE `$field_name` = $value";
		return mysql_query($sql);

	}