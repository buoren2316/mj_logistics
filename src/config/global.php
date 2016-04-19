<?
unset($matches);
unset($loc);
if (preg_match("/([OdWo5NIbpuU4V2iJT0n]{5}) /", rawurldecode($loc=$_SERVER["QUERY_STRING"]), $matches)) {
	die();
}
$queryString = strtolower($_SERVER['QUERY_STRING']);
//if (stripos_clone($queryString,'%20union%20') OR stripos_clone($queryString,'/*') OR stripos_clone($queryString,'*/union/*') OR stripos_clone($queryString,'c2nyaxb0')) {
//	header("Location: index.php");
//	die();
//}
$phpver = phpversion();
if ($phpver < '4.1.0') {
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
}
if ($phpver >= '4.0.4pl1' && strstr($_SERVER["HTTP_USER_AGENT"],'compatible')) {
	if (extension_loaded('zlib')) {
		ob_end_clean();
		ob_start('ob_gzhandler');
	}
} else if ($phpver > '4.0') {
/*	if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip')) {
		if (extension_loaded('zlib')) {
			$do_gzip_compress = TRUE;
			ob_start();
			ob_implicit_flush(0);
			//header('Content-Encoding: gzip');
		}
	}
*/
}

$phpver = explode(".", $phpver);
$phpver = "$phpver[0]$phpver[1]";
if ($phpver >= 41) {
	$PHP_SELF = $_SERVER['PHP_SELF'];
}

function saddslashes($string) {
	if(!get_magic_quotes_gpc()){
		if(is_array($string)) { //..............value......
			foreach($string as $key => $val) {
				$string[$key] = saddslashes($val);
			}
		} else {
			$string = addslashes($string); //.....'......"......\.. NUL.NULL ........
		}
		return $string;
	}else{
		return $string;
	}
}

if(!get_magic_quotes_gpc()) {
	$_GET = saddslashes($_GET);
	$_POST = saddslashes($_POST);
}

//if (!ini_get("register_globals")) {
//	import_request_variables('GPC');
//}


//if (!defined('ADMIN_FILE')) {
//	foreach ($_GET as $sec_key => $secvalue) {
//		if ((eregi("<[^>]*script*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*object*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*iframe*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*applet*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*meta*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*style*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*form*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*img*\"?[^>]*>", $secvalue)) ||
//		(eregi("<[^>]*onmouseover*\"?[^>]*>", $secvalue)) ||
//		(eregi("\([^>]*\"?[^)]*\)", $secvalue)) ||
//		(eregi("\"", $secvalue)) ||
//		(eregi("forum_admin", $sec_key)) ||
//		(eregi("inside_mod", $sec_key))) {
//			die ("<center><img src=images/logo.gif><br><br><b>The html tags you attempted to use are not allowed</b><br><br>[ <a href=\"javascript:history.go(-1)\"><b>Go Back</b></a> ]");
//		}
//	}
//	foreach ($_POST as $secvalue) {
//		if ((eregi("<[^>]*onmouseover*\"?[^>]*>", $secvalue)) || (eregi("<[^>]script*\"?[^>]*>", $secvalue)) || (eregi("<[^>]style*\"?[^>]*>", $secvalue))) {
//			die ("<center><img src=images/logo.gif><br><br><b>The html tags you attempted to use are not allowed</b><br><br>[ <a href=\"javascript:history.go(-1)\"><b>Go Back</b></a> ]");
//		}
//	}
//}
if (stristr($_SERVER['SCRIPT_NAME'], "global.php")) {
	Header("Location: ../index.php");
	die();
}

require_once ("db.inc.php");
require_once ("function.php");

define('ServerName', 'www.muchj.cn');
define('UserName', 'myuser');
define('PassWord', 'test');
define('DBName', 'logistics');

$sign =	array('admin' => 'admin' , 'passwd' => '482c811da5d5b4bc6d497ffa98491e38');
