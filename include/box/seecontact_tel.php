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
!(defined('QQ3479015851')) && exit('FORBIDDEN');
$id = ($_REQUEST['id'] ? intval($_REQUEST['id']) : '');
$tel_base64 = ($_REQUEST['tel_base64'] ? mhtmlspecialchars($_REQUEST['tel_base64']) : '');
$tel = base64_decode($tel_base64);
$url = base64_encode($qq3479015851_global[SiteUrl] . '/m/index.php?mod=information&id=' . $id);
include QQ3479015851_ROOT . '/template/box/seecontact_tel.html';
$row = $infoid = $db = $qq3479015851_global = $if_view = NULL;

?>
