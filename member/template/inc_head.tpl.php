<?php if($box != 1){?>
<?php
$citydomain = $db ->getOne("SELECT domain FROM `{$db_qq3479015851}city` WHERE cityid = '$cityid'");
$citydomain = $citydomain ? $citydomain : "../index.php?cityid=".$cityid;
?>
<div class="toolbar">
    <div class="clearfix toolbar-inner">
        <div class="quicklink">
            <ul id="qq3479015851_website_links" class="accesslink">
				<a href="<?=$citydomain?>" target="_blank">返回<?php echo $qq3479015851_global['SiteName']?>首页</a>
            </ul>
        </div>
        <div class="userbar">
            <a class="username" href="index.php"><?php echo $s_uid; ?></a>
            <a href="index.php?m=pm" style="margin-top:1px">短消息<?php if($pm_total > 0){?><span class="counts"><?=$pm_total?></span><?php }?></a>
            <a href="../<?php echo $qq3479015851_global['cfg_member_logfile']?>?mod=out" style="margin-top:1px">退出</a>
        </div>
    </div>
</div>
<div class="header">
    <div class="clearfix header-inner">
        <div class="brand">
            <h1><a href="<?php echo $qq3479015851_global[SiteUrl]?>" title="<?php echo $qq3479015851_global[SiteName]?>" target="_blank"><img src="<?php echo $qq3479015851_global[SiteUrl]?><?php echo $qq3479015851_global[SiteLogo]?>" max-height="100"/></a></h1>
            <h2><a href="?">用户中心</a></h2>
        </div>
    </div>
</div>

<div class="clearfix siteportalnav">
    <ul>
        <?php if($qq3479015851_global['head_style'] == 'new'){?><li><a href="<?=$citydomain?>" target="_blank"><span><strong>网站首页</strong></span></a></li><?php }?>
		<li class="usercenter"><a <?php if($type == 'user'){?>class="current"<?php }?> href="index.php?type=user"><span><strong>用户中心</strong></span></a></li>
        <?php if($if_corp == 1 && $qq3479015851_global[cfg_if_corp] == 1){?><li><a <?php if($type == 'corp'){?>class="current"<?php }?> href="index.php?type=corp&m=shop"><span><strong><font color="<?php echo $qq3479015851_global['head_style'] == 'new' ? "" : "red";?>">店铺管理</font></strong></span></a></li><?php }?>
    </ul>
</div>

<div class="subnav">
    <div class="clearfix subnav-inner">
        <div class="crumbnav">
             <?php echo $location; ?>
        </div>
    </div>
</div>

<?php }?>