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

define( "CURSCRIPT", "channel" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( QQ3479015851_INC."/db.class.php" );
require_once( dirname( __FILE__ )."/include/color.inc.php" );
require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "QQ3479015851" ) )
{
				exit( "Access Denied" );
}
$part = $part ? $part : "list";
$cat_color = $color;

if ( !submit_check( CURSCRIPT."_submit" ) )
{
				require_once( QQ3479015851_DATA."/html_type.inc.php" );
				if ( $part == "list" )
				{
								chk_admin_purview( "purview_新闻类别" );
								$f_cat = cat_list( "channel", 0, 0, FALSE );
								$here = "新闻栏目列表";
								include( qq3479015851_tpl( "news_channel_list" ) );
				}
				else if ( $part == "edit" )
				{
								if ( !$catid )
								{
												write_msg( "请选择你要修改的栏目ID！" );
								}
								$cat = $db->getRow( "SELECT * FROM ".$db_qq3479015851."channel WHERE catid = '{$catid}'" );
								$here = "编辑新闻栏目";
								include( qq3479015851_tpl( "news_channel_edit" ) );
				}
				else if ( $part == "add" )
				{
								$maxorder = $db->getOne( "SELECT MAX(catorder) FROM ".$db_qq3479015851."channel" );
								$maxorder += 1;
								$here = "添加新闻栏目";
								include( qq3479015851_tpl( "news_channel_add" ) );
				}
				else if ( $part == "del" )
				{
								if ( !$catid )
								{
												write_msg( "没有选择记录" );
								}
								qq3479015851_delete( "channel", "WHERE catid = '".$catid."'" );
								qq3479015851_delete( "channel", "WHERE parentid = '".$catid."'" );
								qq3479015851_delete( "news", "WHERE catid IN(".get_cat_children( $catid, "channel" ).")" );
								foreach ( array( "option_static", "pid_releate" ) as $range )
								{
												clear_cache_files( "channel_".$range );
								}
								write_msg( "删除新闻栏目 ".$catid." 成功", "channel.php?part=list", "QQ3479015851" );
				}
}
else
{
				(($part == 'add') || ($part == 'edit')) && require_once dirname(__FILE__) . '/include/pinyin.inc.php';

				if ( $part == "list" )
				{
								if ( is_array( $catorder ) )
								{
												$cur_action .= "排序 ";
												foreach ( $catorder as $key => $value )
												{
																$db->query( "UPDATE `".$db_qq3479015851."channel` SET catorder = '{$value}' WHERE catid = ".$key );
												}
								}
								if ( is_array( $if_viewids ) )
								{
												$cur_action .= "启用与否";
												$db->query( "UPDATE `".$db_qq3479015851."channel` SET if_view = '1' " );
												foreach ( $if_viewids as $k => $val )
												{
																$db->query( "UPDATE `".$db_qq3479015851."channel` SET if_view = '2' WHERE catid = ".$val );
												}
								}
								else
								{
												$db->query( "UPDATE `".$db_qq3479015851."channel` SET if_view = '1' " );
								}
								foreach ( array( "option_static", "pid_releate" ) as $range )
								{
												clear_cache_files( "channel_".$range );
								}
								write_msg( "新闻栏目 ".$cur_action." 更新成功！", "?part=list", "record" );
				}
				else if ( $part == "add" )
				{
								if ( empty( $catname ) )
								{
												write_msg( "请填写新闻栏目名称！" );
								}
								$len = strlen( $catname );
								if ( $len < 2 )
								{
												write_msg( "新闻栏目名必须在2个字符以上" );
								}
								$catname = explode( "|", trim( $catname ) );
								if ( empty( $catorder ) )
								{
												$maxorder = $db->getOne( "SELECT MAX(catorder) FROM ".$db_qq3479015851."channel" );
												$catorder += 1;
								}
								if ( is_array( $catname ) )
								{
												foreach ( $catname as $key => $value )
												{
																$value = trim( $value );
																++$catorder;
																$len = strlen( $value );
																if ( 30 < $len )
																{
																				write_msg( "分类名必须在2个至30个字符之间" );
																}
																$db->query( "INSERT INTO ".$db_qq3479015851."channel (catname,if_view,title,keywords,description,parentid,catorder,dir_type) VALUES ('{$value}','{$isview}','{$value}','{$value}','{$value}','{$parentid}','{$catorder}','{$dir_type}')" );
																$insert_id = $db->insert_id( );
																if ( $parentid == 0 )
																{
																				if ( $dir_type == 1 )
																				{
																								$html_dir = "/".$insert_id."/";
																				}
																				else if ( $dir_type == 2 )
																				{
																								$html_dir = "/".getpinyin( $value )."/";
																				}
																				else if ( $dir_type == 3 )
																				{
																								$html_dir = "/".getpinyin( $value, 1 )."/";
																				}
																}
																else
																{
																				$row = $db->getRow( "SELECT * FROM `".$db_qq3479015851."channel` WHERE catid = '{$parentid}'" );
																				if ( $dir_type == 1 )
																				{
																								$html_dir = ( $row['html_dir'] ? $row['html_dir'] : $row['html_dir'] ).$insert_id."/";
																				}
																				else if ( $dir_type == 2 )
																				{
																								$html_dir = ( $row['html_dir'] ? $row['html_dir'] : $row['html_dir'] ).getpinyin( $value )."/";
																				}
																				else if ( $dir_type == 3 )
																				{
																								$html_dir = ( $row['html_dir'] ? $row['html_dir'] : $row['html_dir'] ).getpinyin( $value, 1 )."/";
																				}
																}
																$db->query( "UPDATE `".$db_qq3479015851."channel` SET html_dir = '{$html_dir}' WHERE catid = '{$insert_id}'" );
												}
												foreach ( array( "option_static", "pid_releate" ) as $range )
												{
																clear_cache_files( "channel_".$range );
												}
												write_msg( "新闻分类添加成功！", "?part=list", "record" );
								}
								else
								{
												write_msg( "新闻分类添加失败，请按格式填写！" );
								}
				}
				else if ( $part == "edit" )
				{
								if ( empty( $catname ) )
								{
												write_msg( "请填写新闻栏目名称！" );
								}
								if ( strlen( $catname ) < 2 )
								{
												write_msg( "新闻栏目名必须在2个字符以上" );
								}
								if ( $catid == $parentid )
								{
												write_msg( "隶属栏目不能为自己！" );
								}
								if ( $parentid != 0 )
								{
												$row = $db->getRow( "SELECT catname,html_dir FROM `".$db_qq3479015851."channel` WHERE catid = '{$parentid}'" );
								}
								if ( $dir_type == 4 )
								{
												if ( !$mydir )
												{
																write_msg( "请填写自定义目录名！" );
												}
												if ( $parentid == 0 )
												{
																$html_dir = "/".$mydir."/";
												}
												else
												{
																$html_dir = $row['html_dir'].$mydir."/";
												}
								}
								else if ( $parentid == 0 )
								{
												if ( $dir_type == 1 )
												{
																$html_dir = "/".$catid."/";
												}
												else if ( $dir_type == 2 )
												{
																$html_dir = "/".getpinyin( $catname )."/";
												}
												else if ( $dir_type == 3 )
												{
																$html_dir = "/".getpinyin( $catname, 1 )."/";
												}
								}
								else if ( $dir_type == 1 )
								{
												$html_dir = $row['html_dir'].$catid."/";
								}
								else if ( $dir_type == 2 )
								{
												$html_dir = $row['html_dir'].getpinyin( $catname )."/";
								}
								else if ( $dir_type == 3 )
								{
												$html_dir = $row['html_dir'].getpinyin( $catname, 1 )."/";
								}
								$sql = "UPDATE ".$db_qq3479015851."channel SET catname='{$catname}',if_view='{$isview}',title='{$title}',color='{$fontcolor}',keywords='{$keywords}',description='{$description}',parentid='{$parentid}',catorder='{$catorder}',dir_type = '{$dir_type}', dir_typename = '{$mydir}', html_dir = '{$html_dir}' WHERE catid = '{$catid}'";
								$res = $db->query( $sql );
								$nav_path = "新闻栏目管理 &raquo 编辑栏目";
								$message = "成功编辑新闻栏目 ".$catname;
								$after_action = "<a href='?part=add'><u>继续增加栏目</u></a>\r\n\t\t&nbsp;&nbsp;<a href='?part=edit&catid=".$catid."'><u>重新编辑该栏目</u></a>&nbsp;&nbsp;<a href='?part=list#{$catid}'><u>已增加栏目管理</u></a>";
								foreach ( array( "option_static", "pid_releate" ) as $range )
								{
												clear_cache_files( "channel_".$range );
								}
								write_msg( $message, "channel.php" );
				}
}
if ( is_object( $db ) )
{
				$db->Close( );
}
$db = $qq3479015851_global = $part = $action = $here = NULL;
?>
