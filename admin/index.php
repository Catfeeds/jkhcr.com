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
error_reporting( 32759 );
$do = isset( $_GET['do'] ) ? htmlspecialchars( trim( $_GET['do'] ) ) : "login";
$go = isset( $_GET['go'] ) ? htmlspecialchars( trim( $_GET['go'] ) ) : "qq3479015851_right";
$part = isset( $_GET['part'] ) ? htmlspecialchars( trim( $_GET['part'] ) ) : "default";
switch ( $do )
{
case "login" :
				define( "QQ3479015851", TRUE );
				include( dirname( __FILE__ )."/../include/global.php" );
				require_once( QQ3479015851_DATA."/config.php" );
				require_once( QQ3479015851_DATA."/config.db.php" );
				require_once( QQ3479015851_INC."/db.class.php" );
				require_once( QQ3479015851_INC."/admin.class.php" );
				@include( QQ3479015851_DATA."/caches/authcodesettings.php" );
				$authcodesettings = $data;
				$data = NULL;
				$url = trim( $url );
				if ( $part == "chk" )
				{
								define( CURSCRIPT, "admin_login" );
								$url = $url ? $url : "index.php?do=manage&go=".$go;
								if ( $authcodesettings['adminlogin'] == 1 && !( $randcode = qq3479015851_chk_randcode( $checkcode ) ) )
								{
												write_msg( "验证码输入错误，请返回重新输入" );
												exit( );
								}
								$username = trim( $username );
								$password = trim( $password );
								$pubdate = $timestamp ? $timestamp : time( );
								$ip = getip( );
								$row = $db->getRow( "SELECT id,userid,cityid,pwd,uname FROM ".$db_qq3479015851."admin WHERE userid='".$username."' AND pwd='".md5( $password )."'" );
								if ( $row )
								{
												$admin_id = $row['userid'];
												$admin_name = $row['uname'];
												$admin_cityid = $row['cityid'];
												$qq3479015851_admin->qq3479015851_admin_login( $admin_id, $admin_name, $admin_cityid );
												$db->query( "UPDATE ".$db_qq3479015851."admin SET loginip='".getip( )."',logintime='".$timestamp."' WHERE userid='".$row['userid']."'" );
												$db->query( "INSERT INTO `".$db_qq3479015851."admin_record_login` (id,adminid,adminpwd,pubdate,ip,result) VALUES ('','".$username."','".md5( $password )."','".$pubdate."','".$ip."','1')" );
												write_msg( $admin_name."您已成功登陆系统管理中心", $url );
								}
								else
								{
												$db->query( "INSERT INTO `".$db_qq3479015851."admin_record_login` (id,adminid,adminpwd,pubdate,ip,result) VALUES ('','".$username."','".$password."','".$pubdate."','".$ip."','0')" );
												write_msg( "您输入的用户名或密码错误，请返回重新输入" );
								}
				}
				else if ( $part == "out" )
				{
								define( "QQ3479015851", TRUE );
								$qq3479015851_admin->qq3479015851_admin_logout( );
								write_msg( "您已经安全退出系统管理中心", "index.php" );
				}
				else if ( $part == "default" )
				{
								define( "QQ3479015851", TRUE );
								$url = trim( $_GET['url'] );
								if ( $qq3479015851_admin->qq3479015851_admin_chk_getinfo( ) )
								{
												write_msg( "", "index.php?do=manage" );
								}
								else
								{
												include( qq3479015851_tpl( "login" ) );
								}
				}
				else
				{
								define( "QQ3479015851", TRUE );
								write_msg( "", "index.php?do=manage" );
				}
				break;
case "manage" :
				require_once( dirname( __FILE__ )."/global.php" );
				if ( $part == "left" )
				{
								require_once( dirname( __FILE__ )."/include/".( $admin_cityid ? "qq3479015851.citymenu.inc.php" : "qq3479015851.menu.inc.php" ) );
								$part = trim( $_GET['part'] );
								$part = $part ? $part : "info";
								$qq3479015851_admin_menu = qq3479015851_admin_menu( "left" );
								include( qq3479015851_tpl( "admin_left" ) );
				}
				else if ( $part == "default" )
				{
								include( qq3479015851_tpl( "admin_default" ) );
				}
				else
				{
								if ( $part == "top" )
								{
												require_once( QQ3479015851_INC."/db.class.php" );
												require_once( dirname( __FILE__ )."/include/".( $admin_cityid ? "qq3479015851.citymenu.inc.php" : "qq3479015851.menu.inc.php" ) );
												$qq3479015851_admin_menu = qq3479015851_admin_menu( "top" );
												$admindir = getcwdol( );
												$admin = get_admin_info();
											
												include( qq3479015851_tpl( "admin_top" ) );
								}
								else
								{
												if ( !( $part == "right" ) )
												{
																break;
												}
												$go = trim( $_GET['go'] );
												require_once( QQ3479015851_INC."/db.class.php" );
												require_once( QQ3479015851_DATA."/config.inc.php" );
												require_once( dirname( __FILE__ ).( $admin_cityid ? "/include/qq3479015851.citycount.inc.php" : "/include/qq3479015851.count.inc.php" ) );
												foreach ( $ele as $w => $v )
												{
																$qq3479015851_count_str .= $w == "siteabout" ? "<div class=\"clear\"></div>" : "";
																$qq3479015851_count_str .= "<div class=\"countsquare\">\r\n\t\t\t\t<div class=\"ab\">\r\n\t\t\t\t";
																foreach ( $element[$w] as $k => $u )
																{
																				$qq3479015851_count_str .= "<div class=\"b\">";
																				$qq3479015851_count_str .= $u[where] ? "<a href=\"#\" onclick=\"parent.framRight.location='".$u['url']."';\">".$k."<br><div class=\"c\">".qq3479015851_count( $u[table], $u[where] )."</div></a>" : "<a href=\"#\" onclick=\"parent.framRight.location='".$u['url']."';\">".$k."<br><div class=\"c\">".qq3479015851_count( $u[table] )."</div></a>";
																				$qq3479015851_count_str .= "</div>";
																}
																$qq3479015851_count_str .= "</div>\r\n\t\t\t\t<div class=\"a\">".$v."</div>\r\n\t\t\t\t</div>";
												}
												require_once( dirname( __FILE__ )."/include/wel.inc.php" );
												foreach ( $welcome as $k => $value )
												{
																$qq3479015851_welcome_str .= "<tr bgcolor=\"#f5fbff\"><td width=\"15\" bgcolor=\"#F6FBFF\" style=\"\">".$k."</td><td bgcolor=\"white\" style=\"padding:15px;\" class=\"other\">".$value."</td></tr>";
												}
												$here = "系统管理首页";
												echo qq3479015851_admin_tpl_global_head( $go );
												include( qq3479015851_tpl( "admin_index" ) );
												unset( $ele );
												unset( $element );
												echo qq3479015851_admin_tpl_global_foot( );
								}
				}
				break;
case "power" :
				require_once( dirname( __FILE__ )."/global.php" );
				require_once( QQ3479015851_INC."/member.class.php" );
				$s_uid = trim( $_GET['userid'] );
				$s_pwd = trim( $_GET['password'] );
				$member_log->in( $s_uid, $s_pwd, "off", $url );
				break;
				define( "QQ3479015851", TRUE );
				write_msg( "未知错误，请重新登录后台操作", "index.php?do=login&part=out" );
}
if ( is_object( $db ) )
{
				$db->Close( );
}
$db = $qq3479015851_global = $part = $action = $here = NULL;
?>
