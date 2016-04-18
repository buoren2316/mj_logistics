<?php
/*
 * func: submit user info
 * auth: buoren
 * date: 2016/4/19
 */

	include('config/global.php');

	foreach($_POST as $key => $value) {
		if($value) {
			$post[$key] = $value;
		} else {
			print('<script>alert("error '.$key.' empty");</script>');
			print('<script>history.back(-1);</script>');
		}
	}
	
	$conn = new DBSQL();
	$k = $v = '';
	foreach ($post as $key => $value) {
		if ($key <> 'submit') {
			$k .= $key . ',';
			$v .= "'".$value."',";
		}
	}
	$k = substr($k,0,-1);
	$v = substr($v,0,-1);
	$sql = "INSERT INTO `logistics`.`user` (".$k.") VALUES (".$v.");";
	$rs = $conn->insert($sql);
	if ($rs) {
		print('<script>alert("sucess!");</script>');
		print('<script>history.back(-1);</script>');
	} else {
		die('error');
	}

	//dump($post);
	//echo 'bb';