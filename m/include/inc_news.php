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
function get_root_channel( )
{
				global $db;
				global $db_qq3479015851;
				$query = $db->query( "SELECT catid,catname FROM `".$db_qq3479015851."channel` WHERE parentid = '0' AND if_view = '2' ORDER BY catorder ASC" );
				while ( $queryrow = $db->fetchRow( $query ) )
				{
								$_array['catid'] = $queryrow['catid'];
								$_array['catname'] = $queryrow['catname'];
								$channel[] = $_array;
				}
				return $channel;
}

if ( CURSCRIPT != "wap" )
{
				exit( "FORBIDDEN" );
}
$id = isset( $id ) ? intval( $id ) : "";
$catid = isset( $catid ) ? intval( $catid ) : "";
$page = isset( $page ) ? intval( $page ) : 1;
if ( $id )
{
				if ( !$id )
				{
								errormsg( "新闻ID不能为空！" );
				}
				if ( !( $news = $db->getRow( "SELECT * FROM ".$db_qq3479015851."news WHERE id = '".$id."'" ) ) )
				{
								errormsg( "当前新闻不存在或者已经被删除！" );
				}
				$db->query( "UPDATE `".$db_qq3479015851."news` SET hit = hit +1 WHERE id = '".$id."';" );
				$news['catname'] = $db->getOne( "SELECT catname FROM `".$db_qq3479015851."channel` WHERE catid = '".$news['catid']."'" );
				$cityid = $news['cityid'];
				$city = get_city_caches( $cityid );
				include( qq3479015851_tpl( "news" ) );
}
else if ( $catid )
{
				$cat = get_cat_info( $catid, "channel" );
				if ( !$cat )
				{
								errormsg( "您所指定的新闻栏目不存在或者已经删除！" );
				}
				$rootchannel = get_categories_tree( $catid, "channel" );
				$cat_children = get_cat_children( $catid, "channel" );
				$perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
				$param = setparams( array( "mod", "catid" ) );
				$rows_num = $db->getOne( "SELECT COUNT(*) FROM `".$db_qq3479015851."news` AS a WHERE catid IN(".$cat_children.")" );
				$totalpage = ceil( $rows_num / $perpage );
				$num = intval( $page - 1 ) * $perpage;
				$page1 = page1( "SELECT * FROM ".$db_qq3479015851."news WHERE catid IN(".$cat_children.") ".$city_limit." ORDER BY id DESC", $perpage );
				foreach ( $page1 as $kr => $r )
				{
								$arr['begintime'] = $r['begintime'];
								$arr['hit'] = $r['hit'];
								$arr['title'] = $r['title'];
								$arr['iscommend'] = $r['iscommend'];
								$arr['content'] = clear_html( $r['content'] );
								$arr['uri'] = $r['isjump'] ? $r['redirect_url'] : "index.php?mod=news&id=".$r['id'];
								$arr['imgpath'] = $r['imgpath'];
								$news[] = $arr;
				}
				$pageview = pager( );
				$parentcats = get_parent_cats( "channel", $catid );
				$parentcats = is_array( $parentcats ) ? array_reverse( $parentcats ) : "";
				include( qq3479015851_tpl( "news_list" ) );
}
else
{
				$rootchannel = get_root_channel( );
				$perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
				$param = setparams( array( "mod", "cityid" ) );
				$rows_num = $db->getOne( "SELECT COUNT(*) FROM `".$db_qq3479015851."news` AS a ORDER BY id DESC" );
				$totalpage = ceil( $rows_num / $perpage );
				$num = intval( $page - 1 ) * $perpage;
				$page1 = page1( "SELECT * FROM ".$db_qq3479015851."news WHERE 1 ".$city_limit." ORDER BY id DESC", $perpage );
				foreach ( $page1 as $kr => $r )
				{
								$arr['begintime'] = $r['begintime'];
								$arr['hit'] = $r['hit'];
								$arr['title'] = $r['title'];
								$arr['iscommend'] = $r['iscommend'];
								$arr['content'] = clear_html( $r['content'] );
								$arr['uri'] = $r['isjump'] ? $r['redirect_url'] : "index.php?mod=news&id=".$r['id'];
								$arr['imgpath'] = $r['imgpath'];
								$news[] = $arr;
				}
				$pageview = pager( );
				include( qq3479015851_tpl( "news_index" ) );
}
?>
