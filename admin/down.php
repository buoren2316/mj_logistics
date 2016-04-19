<?php
/*
 * func: submit user info
 * auth: buoren
 * date: 2016/4/19
 */

	include('../src/config/global.php');
	header('Content-Type: text/html; charset=utf-8');

	if (!$_POST) die ('no post');

	session_start();

	foreach($_POST as $key => $value) {
		if($value) {
			$post[$key] = $_SESSION[$key] = $value;
		} else {
			print('<script>alert("error '.$key.' empty");</script>');
			print('<script>history.back(-1);</script>');
		}
	}

	if ($_SESSION['uname'] <> $sign['admin'] || md5($_SESSION['passwd']) <> $sign['passwd']) {
		print('<script>alert("error username or password");</script>');
		print('<script>history.back(-1);</script>');
	}


	$today = $post['date'] ? $post['date'] : date("Y-m-d");

	
	if ($post['submit'] == '导出') {
		//判断日期格式
		if (!is_date($post['date'])) print('<script>alert("日期格式错误 YYYY-mm-dd");history.back(-1);</script>');

		$conn = new DBSQL();
		$sql  = 'select * from user where date(addtime) = "'.$today.'"';
		$data = $conn->select($sql);
		dump($data); 
	}

	print '
		<!DOCTYPE html>
		<html>
		<body>
		<form method="post">
			  <fieldset>
				<legend>导出记录</legend>
				请输入日期： <input type="text" name="date" value="'.$today.'"/>
				<input type="submit" name="submit" value="导出" style="width:70px"/>
			  </fieldset>
		</form>
		</body>
		</html>
	';
