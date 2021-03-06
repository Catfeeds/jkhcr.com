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
	exit('Access Denied');
}
function myparseTemplate($tplfile, $templateid, $tpldir)
{
	global $timestamp;
	global $mytemplates;
	$nest = 6;
	$file = basename($tplfile, '.html');
	$objfile = QQ3479015851_DATA . '/templates/' . $templateid . '_' . $file . '.tpl.php';

	if (!(@$fp = fopen($tplfile, 'r'))) {
		exit('Current template file \'./' . $tpldir . '/' . $file . '.html\' not found or have no access!');
	}

	$template = @fread($fp, filesize($tplfile));
	fclose($fp);
	$var_regexp = '((\\$[a-zA-Z_-' . "\xff" . '][a-zA-Z0-9_-' . "\xff" . ']*)(\\[[a-zA-Z0-9_\\-\\."\\\'\\[\\]$-' . "\xff" . ']+\\])*)';
	$const_regexp = '([a-zA-Z_-' . "\xff" . '][a-zA-Z0-9_-' . "\xff" . ']*)';
	$mytemplates = array();

	for ($i = 1; $i <= 3; $i++) {
		if (strexists($template, '{mytemplate')) {
			$template = preg_replace('/[' . "\n\r\t" . ']*\\{mytemplate\\s+([a-z0-9_]+)\\}[' . "\n\r\t" . ']*/ies', 'loadmytemplate(\'\\1\')', $template);
		}
	}

	$template = preg_replace('/([' . "\n\r" . ']+)' . "\t" . '+/s', '\\1', $template);
	$template = preg_replace('/\\<\\!\\-\\-\\{(.+?)\\}\\-\\-\\>/s', '{\\1}', $template);
	$template = str_replace('{LF}', '<?="\\n"?>', $template);
	$template = preg_replace('/\\{(\\$[a-zA-Z0-9_\\[\\]\\\'"$\\.-' . "\xff" . ']+)\\}/s', '<?=\\1?>', $template);
	$template = preg_replace('/' . $var_regexp . '/es', 'addquote(\'<?=\\1?>\')', $template);
	$template = preg_replace('/\\<\\?\\=\\<\\?\\=' . $var_regexp . '\\?\\>\\?\\>/es', 'addquote(\'<?=\\1?>\')', $template);
	$headeradd = '';

	if (!(empty($mytemplates))) {
		$headeradd .= "\n" . '0' . "\n";

		foreach ($mytemplates as $fname ) {
			$headeradd .= '|| chktplrefresh(\'' . $tplfile . '\', \'' . $fname . '\', ' . $timestamp . ', \'' . $templateid . '\', \'' . $tpldir . '\')' . "\n";
		}

		$headeradd .= ';';
	}

	$template = '<? if(!defined(\'QQ3479015851\')) exit(\'Access Denied\');' . "\r\n" . '/*分类信息系统' . "\r\n" . '联系QQ：3479015851*/?>' . "\r\n" . $template;
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{qq3479015851tag_([a-z0-9_]+)\\}[' . "\n\r\t" . ']*/is', "\n" . '<?php echo custom(\'\\1\'); ?>' . "\n", $template);
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{template\\s+([a-z0-9_]+)\\}[' . "\n\r\t" . ']*/is', "\n" . '<?php include qq3479015851_tpl(\'\\1\'); ?>' . "\n", $template);
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{php\\s+(.+?)\\}[' . "\n\r\t" . ']*/ies', 'stripvtags(\'<?php \\1 ?>\',\'\')', $template);
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{php\\}\\s*(\\<\\!\\-\\-)*(.+?)(\\-\\-\\>)*\\s*\\{\\/php\\}[' . "\n\r\t" . ']*/ies', 'stripvtags(\'<?php \\2 ?>\',\'\')', $template);
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{echo\\s+(.+?)\\}[' . "\n\r\t" . ']*/ies', 'stripvtags(\'<? echo \\1; ?>\',\'\')', $template);
	$template = preg_replace('/([' . "\n\r\t" . ']*)\\{if\\s+(.+?)\\}([' . "\n\r\t" . ']*)/ies', 'stripvtags(\'\\1<? if(\\2) { ?>\\3\')', $template);
	$template = preg_replace('/([' . "\n\r\t" . ']*)\\{elseif\\s+(.+?)\\}([' . "\n\r\t" . ']*)/ies', 'stripvtags(\'\\1<?php } elseif(\\2) { ?>\\3\',\'\')', $template);
	$template = preg_replace('/([' . "\n\r\t" . ']*)\\{else\\}([' . "\n\r\t" . ']*)/is', '\\1<?php } else { ?>\\2', $template);
	$template = preg_replace('/\\{\\/if\\}/i', '<?php } ?>', $template);
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{loop\\s+(\\S+)\\s+(\\S+)\\}[' . "\n\r\t" . ']*/ies', 'stripvtags(\'<?php if(is_array(\\1)){foreach(\\1 as \\2) { ?>\')', $template);
	$template = preg_replace('/[' . "\n\r\t" . ']*\\{loop\\s+(\\S+)\\s+(\\S+)\\s+(\\S+)\\}[' . "\n\r\t" . ']*/ies', 'stripvtags(\'<?php if(is_array(\\1)){foreach(\\1 as \\2 => \\3) { ?>\')', $template);
	$template = preg_replace('/([' . "\n\r\t" . ']*)\\{loopelse\\}([' . "\n\r\t" . ']*)/is', '\\1<?php }} else {{ ?>\\2', $template);
	$template = preg_replace('/\\{\\/loop\\}/i', '<?php }} ?>', $template);
	$template = preg_replace('/\\{' . $const_regexp . '\\}/s', '<?=\\1?>', $template);
	$template = preg_replace('/ \\?\\>[' . "\n\r" . ']*\\<\\? /s', ' ', $template);
	$template = str_replace('$db_qq3479015851', '{$db_qq3479015851}', $template);

	if (!(@$fp = fopen($objfile, 'w'))) {
		exit('Directory \'/data/templates/\' not found or have no access!');
	}

	flock($fp, 2);
	fwrite($fp, $template);
	fclose($fp);
}

function loadmytemplate($file, $templateid = 0, $tpldir = '')
{
	global $mytemplates;
	$tpldir = ($tpldir ? $tpldir : TPLDIR);
	$templateid = ($templateid ? $templateid : TEMPLATEID);
	$tplfile = QQ3479015851_ROOT . '/template/' . $tpldir . '/' . $file . '.html';
	if (($templateid != 1) && !(file_exists($tplfile))) {
		$tplfile = QQ3479015851_ROOT . '/template/default/' . $file . '.html';
	}

	$content = @implode('', file($tplfile));
	$mytemplates[] = $tplfile;
	return $content;
}

function transamp($str)
{
	$str = str_replace('&', '&amp;', $str);
	$str = str_replace('&amp;amp;', '&amp;', $str);
	$str = str_replace('\\"', '"', $str);
	return $str;
}

function addquote($var)
{
	return str_replace('\\"', '"', preg_replace('/\\[([a-zA-Z0-9_\\-\\.-' . "\xff" . ']+)\\]/s', '[\'\\1\']', $var));
}

function stripvtags($expr, $statement)
{
	$expr = str_replace('\\"', '"', preg_replace('/\\<\\?\\=(\\$.+?)\\?\\>/s', '\\1', $expr));
	$statement = str_replace('\\"', '"', $statement);
	return $expr . $statement;
}

function stripscriptamp($s, $extra)
{
	$extra = str_replace('\\"', '"', $extra);
	$s = str_replace('&amp;', '&', $s);
	return '<script src="' . $s . '" type="text/javascript"' . $extra . '></script>';
}

function stripblock($var, $s)
{
	$s = str_replace('\\"', '"', $s);
	$s = preg_replace('/<\\?=\\$(.+?)\\?>/', '{$\\1}', $s);
	preg_match_all('/<\\?=(.+?)\\?>/e', $s, $constary);
	$constadd = '';
	$constary[1] = array_unique($constary[1]);

	foreach ($constary[1] as $const ) {
		$constadd .= '$__' . $const . ' = ' . $const . ';';
	}

	$s = preg_replace('/<\\?=(.+?)\\?>/', '{$__\\1}', $s);
	$s = str_replace('?>', "\n" . '$' . $var . ' .= <<<EOF' . "\n", $s);
	$s = str_replace('<?', "\n" . 'EOF;' . "\n", $s);
	return '<?' . "\n" . $constadd . '$' . $var . ' = <<<EOF' . "\n" . $s . "\n" . 'EOF;' . "\n" . '?>';
}

function chktplrefresh($maintpl, $subtpl, $timecompare, $templateid, $tpldir)
{
	global $qq3479015851_qq3479015851;
	
	
	if($qq3479015851_qq3479015851['tplrefresh'] == 0){
		myparsetemplate($subtpl,$templateid, $tpldir);
		return true;
	}
	
	if (empty($timecompare) || ($qq3479015851_qq3479015851['tplrefresh'] == 1)) {
		if ($timecompare < @filemtime($subtpl)) {
			myparsetemplate($subtpl, $templateid, $tpldir);
			return true;
		}
	}

	return false;
}


?>
