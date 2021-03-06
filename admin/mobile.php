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
 * QQ群 ：625621054  [入群提供技术支持,升级新功能]
`*/
function get_target_options( $zym_10 = "" )
{
				global $target;
				foreach ( $target as $zym_11 => $zym_13 )
				{
								$zym_8 .= "<option value=".$zym_11;
								$zym_8 .= $zym_10 == $zym_11 ? " style = \"background-color:#6EB00C;color:white\" selected>" : ">";
								$zym_8 .= $zym_13."</option>";
				}
				return $zym_8;
}

function restore_url( )
{
				global $db;
				global $db_qq3479015851;
				$db->query( "DELETE FROM `".$db_qq3479015851."mobile_nav` WHERE typeid = '2'" );
				$zym_7 = $db->query( "SELECT * FROM `".$db_qq3479015851."category` WHERE parentid = '0'" );
				while ( $zym_2 = $db->fetchRow( $zym_7 ) )
				{
								$zym_1[$zym_2['catid']]['catid'] = $zym_2['catid'];
								$zym_1[$zym_2['catid']]['name'] = $zym_2['catname'];
								$zym_1[$zym_2['catid']]['color'] = $zym_2['color'];
								$zym_1[$zym_2['catid']]['uri'] = "index.php?mod=category&catid=".$zym_2['catid'];
								$zym_1[$zym_2['catid']]['ico'] = $zym_2['icon'];
				}
				$zym_3 = 0;
				if ( is_array( $zym_1 ) )
				{
								foreach ( $zym_1 as $zym_4 => $zym_6 )
								{
												$zym_3 += 1;
												$db->query( "INSERT INTO `".$db_qq3479015851."mobile_nav` (url,color,title,ico,typeid,isview,displayorder,createtime)VALUES('{$zym_6['uri']}','{$zym_6['color']}','{$zym_6['name']}','{$zym_6['ico']}','2','2','{$zym_3}','{$zym_5}')" );
								}
				}
				clear_cache_files( "mobile_nav" );
}

define( "CURSCRIPT", "mobile" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( QQ3479015851_INC."/db.class.php" );
require_once( QQ3479015851_INC."/upfile.fun.php" );
if ( $admin_cityid )
{
				write_msg( "您没有权限访问该页！" );
}
$type = isset( $type ) ? $type : "";
if ( !in_array( $type, array( "default", "nav", "nav_ico", "restore", "gg" ) ) )
{
				$type = "default";
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
				chk_admin_purview( "purview_手机访问设置" );
				if ( $type == "default" )
				{
								$here = "手机版访问设置";
								$mobile = $db->getOne( "SELECT value FROM `".$db_qq3479015851."config` WHERE type='mobile' AND description = 'mobile'" );
								$mobile = $mobile ? $charset == "utf-8" ? utf8_unserialize( $mobile ) : unserialize( $mobile ) : array( );
								include( qq3479015851_tpl( CURSCRIPT ) );
				}
				else if ( $type == "nav" )
				{
								require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
								require_once( dirname( __FILE__ )."/include/color.inc.php" );
								$target = array( "_self" => "当前窗口", "_blank" => "新窗口" );
								$here = "手机版导航设置";
								$where = " WHERE typeid = '1'";
								$rows_num = qq3479015851_count( "mobile_nav", $where );
								$param = setparam( array( "type", "typeid" ) );
								$url = array( );
								$url = page1( "SELECT * FROM ".$db_qq3479015851."mobile_nav {$where} ORDER BY displayorder ASC" );
								include( qq3479015851_tpl( CURSCRIPT."_nav" ) );
				}
				else if ( $type == "nav_ico" )
				{
								require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
								require_once( dirname( __FILE__ )."/include/color.inc.php" );
								$target = array( "_self" => "当前窗口", "_blank" => "新窗口" );
								$here = "手机版导航设置";
								$where = " WHERE typeid = '2'";
								$rows_num = qq3479015851_count( "mobile_nav", $where );
								$param = setparam( array( "type", "typeid" ) );
								$url = array( );
								$url = page1( "SELECT * FROM ".$db_qq3479015851."mobile_nav {$where} ORDER BY displayorder ASC" );
								include( qq3479015851_tpl( CURSCRIPT."_nav_ico" ) );
				}
				else if ( $type == "restore" )
				{
								restore_url( );
								write_msg( "手机图标导航已成功应用默认设置！", "mobile.php?type=nav_ico", "Mym_psRecord" );
				}
				else if ( $type == "gg" )
				{
								$here = "手机版广告设置";
								$target = array( "1" => "首页头部", "2" => "新闻首页头部" );
								$where = $typeid ? " WHERE typeid = '".$typeid."'" : "";
								$rows_num = qq3479015851_count( "mobile_gg", $where );
								$param = setparam( array( "type", "typeid" ) );
								$row = page1( "SELECT * FROM `".$db_qq3479015851."mobile_gg` {$where} ORDER BY displayorder ASC" );
								if ( $id )
								{
												$edit = $db->getRow( "SELECT * FROM `".$db_qq3479015851."mobile_gg` WHERE id ='{$id}'" );
												if ( !$edit )
												{
																$id = "";
												}
								}
								else
								{
												$edit['displayorder'] = $db->getOne( "SELECT max(displayorder) FROM `".$db_qq3479015851."mobile_gg`" );
												$edit['displayorder'] = $edit['displayorder'] + 1;
								}
								include( qq3479015851_tpl( CURSCRIPT."_gg" ) );
				}
}
else if ( $type == "default" )
{
				$db->query( "DELETE FROM `".$db_qq3479015851."config` WHERE description = 'mobile' AND type = 'mobile'" );
				$db->query( "INSERT INTO `".$db_qq3479015851."config` (description,value,type) values ('mobile','".serialize( $settings )."','mobile')" );
				clear_cache_files( "mobile" );
				write_msg( "手机基本设置更新成功！", "mobile.php", "WriteRecord" );
}
else if ( $type == "nav" )
{
				if ( is_array( $navtitle ) )
				{
								foreach ( $navtitle as $key => $v )
								{
												$db->query( "UPDATE `".$db_qq3479015851."mobile_nav` SET title = '{$v}',displayorder = '{$displayorder[$key]}',url='{$navurl[$key]}',isview='{$isviewids[$key]}',target='{$target[$key]}',flag='{$flag[$key]}',color='{$showcolor[$key]}',typeid='1' WHERE id = ".$key );
								}
				}
				if ( is_array( $newtitle ) && is_array( $newurl ) )
				{
								foreach ( $newtitle as $key => $q )
								{
												$title = trim( $q );
												$url = mhtmlspecialchars( trim( $newurl[$key] ) );
												$displayorder = mhtmlspecialchars( trim( $newdisplayorder[$key] ) );
												$isview = mhtmlspecialchars( trim( $newisview[$key] ) );
												$target = $newtarget[$key] ? mhtmlspecialchars( trim( $newtarget[$key] ) ) : "_blank";
												$showcolor = mhtmlspecialchars( trim( $newshowcolor[$key] ) );
												$flag = mhtmlspecialchars( trim( $newflag[$key] ) );
												$flag = $flag ? $flag : "outlink";
												if ($title && $url )
												{
																$db->query( "INSERT INTO `".$db_qq3479015851."mobile_nav` (url,title,isview,target,flag,color,displayorder,createtime,typeid) VALUES ('{$url}','{$title}','{$isview}','{$target}','{$flag}','{$showcolor}','{$displayorder}','{$timestamp}','1')" );
												}
								}
				}
				if ( is_array( $delids ) )
				{
								foreach ( $delids as $kids => $vids )
								{
												qq3479015851_delete( "mobile_nav", "WHERE id = ".$vids );
								}
				}
				clear_cache_files( "mobile_nav" );
				write_msg( "手机文字导航设置更新成功！", "mobile.php?type=nav", "QQ3479015851Record" );
}
else if ( $type == "nav_ico" )
{
				if ( is_array( $navtitle ) )
				{
								foreach ( $navtitle as $key => $v )
								{
												$db->query( "UPDATE `".$db_qq3479015851."mobile_nav` SET title = '{$v}',displayorder = '{$displayorder[$key]}',url='{$navurl[$key]}',isview='{$isviewids[$key]}',target='_self',ico='{$navico[$key]}',color='{$showcolor[$key]}',typeid='2' WHERE id = ".$key );
								}
				}
				if ( is_array( $newtitle ) && is_array( $newurl ) )
				{
								foreach ( $newtitle as $key => $q )
								{
												$title = trim( $q );
												$ico = trim( $newico[$key] );
												$url = trim( $newurl[$key] );
												$displayorder = trim( $newdisplayorder[$key] );
												$isview = trim( $newisview[$key] );
												$target = "_self";
												$showcolor = trim( $newshowcolor[$key] );
												$flag = "";
												if ($title && $url )
												{
																$db->query( "INSERT INTO `".$db_qq3479015851."mobile_nav` (url,ico,title,isview,target,flag,color,displayorder,createtime,typeid) VALUES ('{$url}','{$ico}','{$title}','{$isview}','{$target}','{$flag}','{$showcolor}','{$displayorder}','{$timestamp}','2')" );
												}
								}
				}
				if ( is_array( $delids ) )
				{
								foreach ( $delids as $kids => $vids )
								{
												qq3479015851_delete( "mobile_nav", "WHERE id = ".$vids );
								}
				}
				clear_cache_files( "mobile_nav" );
				write_msg( "手机图标导航设置更新成功！", "mobile.php?type=nav_ico", "Mym_psRecord" );
}
else if ( $type == "gg" )
{
				if ( is_array( $delids ) )
				{
								foreach ( $delids as $kids => $vids )
								{
												$delrow = $db->getRow( "SELECT image FROM `".$db_qq3479015851."mobile_gg` WHERE id = '{$vids}'" );
												@unlink( QQ3479015851_ROOT.$delrow['image'] );
												qq3479015851_delete( "mobile_gg", "WHERE id = ".$vids );
								}
								clear_cache_files( "mobile_gg" );
								write_msg( "幻灯片广告更新成功！", "mobile.php?type=gg" );
								exit( );
				}
				if ( is_array( $displayorder ) )
				{
								foreach ( $displayorder as $key => $val )
								{
												$db->query( "UPDATE `".$db_qq3479015851."mobile_gg` SET displayorder = '{$val}' WHERE id = ".$key );
								}
								clear_cache_files( "mobile_gg" );
								write_msg( "幻灯片广告更新成功！", "mobile.php?type=gg" );
				}
				if ( $id )
				{
								$name_file = "qq3479015851_focus";
								if ( $_FILES[$name_file]['name'] )
								{
												check_upimage( $name_file );
												$destination = "/mobile_gg/";
												$qq3479015851_image = start_upload( $name_file, $destination, 0, "", "", $image );
												unset( $limit );
												$image = $qq3479015851_image;
								}
								$res = $db->query( "UPDATE `".$db_qq3479015851."mobile_gg` SET image='{$image}',words='{$words}',typeid='{$typeid}',url='{$url}',displayorder='{$displayorder}' WHERE id = '{$id}'" );
								clear_cache_files( "mobile_gg" );
								write_msg( "幻灯片广告更新成功！", "mobile.php?type=gg" );
				}
				else
				{
								$name_file = "qq3479015851_focus";
								if ( $_FILES[$name_file]['name'] )
								{
												check_upimage( $name_file );
												$destination = "/mobile_gg/";
												$qq3479015851_image = start_upload( $name_file, $destination, 0 );
												unset( $limit );
												$db->query( "INSERT INTO `".$db_qq3479015851."mobile_gg` (id,image,words,url,pubdate,displayorder,typeid)\r\n\t\t\t\t\t\tVALUES('','{$qq3479015851_image}','{$words}','{$url}','{$timestamp}','{$displayorder}','{$typeid}')" );
												clear_cache_files( "mobile_gg" );
												write_msg( "幻灯片广告上传成功！", "mobile.php?type=gg" );
								}
				}
}
if ( is_object( $db ) )
{
				$db->Close( );
}
$qq3479015851_global = $db = $db_qq3479015851 = $part = NULL;
?>
