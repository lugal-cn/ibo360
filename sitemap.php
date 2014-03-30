<?php
/*网站地图 网页版 UTF-8编码*/ 
define('APPTYPEID', 127);
define('CURSCRIPT', 'sitemap');
require './source/class/class_core.php';
$discuz = & discuz_core::instance();$discuz->cachelist = $cachelist;$discuz->init();
$urlnum=100;//网址数
$navtitle='网站地图';
$metakeywords=$_G['seokeywords']['forum'];
$metadescription=$_G['bbname'].$_G['seodescription']['forum'];
include template('common/header');
echo '<div style="height:1400px">';
echo '<style type="text/css">.newtid{width:100%;float:left}.newtid li{padding-left:2%;font-size: 14px;width:48%;float:left;line-height: 25px;}.newtid li a{color: #036;}.newtit strong a{position: absolute;bottom: 98765px;}.newtid h2{font-size: 16px;line-height: 45px;}</style><h2 class="newtit"><a href="">最新发表的帖子:</a></h2><ul class="newtid">';
$querys = DB::query("SELECT a.tid,a.subject,a.fid,b.name FROM ".DB::table('forum_thread')." a inner join ".DB::table('forum_forum')." b on a.fid=b.fid where a.displayorder!=-2 ORDER BY a.tid DESC  LIMIT 0,$urlnum");
$i=0;while($threadfid = DB::fetch($querys))
	{$i++;
	echo '<li class="newsitemap">'.$i.'、<a href="forum.php?mod=forumdisplay&fid='.$threadfid['fid'].'" title="'.$threadfid['name'].'" target="_blank">['.$threadfid['name'].']</a> <a href="forum.php?mod=viewthread&tid='.$threadfid['tid'].'" target="_blank" title="'.$threadfid['subject'].'">'.$threadfid['subject'].'</a></li>';
	}
echo '</ul>';
echo '</div>';
	include template('common/footer');
?>  