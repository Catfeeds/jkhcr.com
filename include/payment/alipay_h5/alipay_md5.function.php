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
function md5Sign($prestr, $key)
{
	$prestr = $prestr . $key;
	return md5($prestr);
}

function md5Verify($prestr, $sign, $key)
{
	$prestr = $prestr . $key;
	$mysgin = md5($prestr);

	if ($mysgin == $sign) {
		return true;
	}
	else {
		return false;
	}
}


?>