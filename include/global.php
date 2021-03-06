<?php
/*
 * ============================================================================
 * 版权所有 114mps研发团队，保留所有权利。
 * 网站地址: http://my.roebx.com；
 * 博客教程：http://blog.csdn.net/qq_35921430；
 * ----------------------------------------------------------------------------
 * 这是一个自由软件！您可以对程序代码进行修改和使用。
 * ============================================================================
 * 程序交流QQ：3479015851
 * QQ群 ：625621054  [入群提供技术支持]
`*/
if (!(defined('QQ3479015851'))) {
	exit('FORBIDDEN');
}

error_reporting(0);
@header('Content-Type: text/html; charset=utf-8');
@set_magic_quotes_runtime(0);
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
require_once dirname(__FILE__) . '/global.inc.php';
require QQ3479015851_DATA . '/config.inc.php';

if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('Hongkong');
}

$mtime = explode(' ', microtime());
$qq3479015851_starttime = $mtime[1] + $mtime[0];
$timestamp = time();
@ini_set('memory_limit', '640M');
@ini_set('session.cache_expire', 180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies', 1);
@ini_set('session.auto_start', 0);
@ini_set('display_errors', 1);

if (!(function_exists('file_put_contents'))) {
function file_put_contents($file, $data, $flags = '')
{
	$contents = (is_array($data) ? implode('', $data) : $data);

	if ($flags == 'FILE_APPEND') {
		$mode = 'ab+';
	}
	else {
		$mode = 'wb';
	}

	if (($fp = @fopen($file, $mode)) === false) {
		return false;
	}
	else {
		$bytes = fwrite($fp, $contents);
		fclose($fp);
		return $bytes;
	}
}
	define('FILE_APPEND', 'FILE_APPEND');
}

if (PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
	unset($HTTP_GET_VARS);
	unset($HTTP_POST_VARS);
	unset($HTTP_COOKIE_VARS);
	unset($HTTP_ENV_VARS);
	unset($HTTP_POST_FILES);
	unset($HTTP_SERVER_VARS);
}

require_once QQ3479015851_INC . '/common.fun.php';
require_once QQ3479015851_INC . '/template.fun.php';
require_once QQ3479015851_INC . '/custom.fun.php';

if (!(defined('IN_MEMBERADMIN'))) {
	if (!(defined('IN_MANAGE'))) {
		foreach (array('_COOKIE', '_POST', '_GET') as $_request ) {
			foreach ($$_request as $_key => $_value ) {
				($_key[0] != '_') && ($$_key = mhtmlspecialchars(maddslashes($_value)));
			}
		}
	}
	else {
		foreach (array('_COOKIE', '_POST', '_GET') as $_request ) {
			foreach ($$_request as $_key => $_value ) {
				($_key[0] != '_') && ($$_key = maddslashes($_value));
			}
		}
	}

	require_once QQ3479015851_INC . '/class.fun.php';
	require_once QQ3479015851_INC . '/cache.fun.php';
	require_once QQ3479015851_ROOT . '/version.php';
}

if (__FILE__ == '') {
	exit('Fatal error code: 0');
}

if (DIRECTORY_SEPARATOR == '\\') {
	@ini_set('include_path', '.;' . ROOT_PATH);
}
else {
	@ini_set('include_path', '.:' . ROOT_PATH);
}

if (defined('DEBUG_MODE') == false) {
	define('DEBUG_MODE', 0);
}

if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) {
	exit('Request tainting attempted.');
}

if (is_array($_FILES)) {
	foreach ($_FILES as $_name => $_value ) {
		$$_name = $_value['tmp_name'];
		$_fp = @fopen($$_name, 'r');
		$_fstr = @fread($_fp, filesize($$_name));
		@fclose($_fp);
		if (($_fstr != '') && @ereg('<(\\?|%)', $_fstr)) {
			echo '你上传的文件中含有危险内容，程序终止处理';
			exit();
		}
	}
}

$php_self = (isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);

if ('/' == substr($php_self, -1)) {
	$php_self .= 'index.php';
}

session_save_path(QQ3479015851_DATA . '/sessions');
function maddslashes($string, $force = 0)
{
	!(defined('MAGIC_QUOTES_GPC')) && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if (!(MAGIC_QUOTES_GPC) || $force) {
		if (is_array($string)) {
			foreach ($string as $key => $val ) {
				$string[$key] = maddslashes($val, $force);
			}
		}
		else {
			$string = addslashes($string);
		}
	}

	return $string;
}


?>
