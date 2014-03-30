<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once libfile('function/post');
include_once libfile('function/editor');
include_once libfile('function/discuzcode');
include_once DISCUZ_ROOT.'source/plugin/ljplcj/simple_html_dom.php';
include_once DISCUZ_ROOT.'source/plugin/ljplcj/function.inc.php';
$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];	
}
$op=$_GET['op'];
if(!$op){
	$op='seo';
}
if($op!='z'){
	include template('ljplcj:nav');
}
if($op=='zd'){
	include_once DISCUZ_ROOT.'source/plugin/ljplcj/include/zd.php';
}else if($op=='log'){
	include_once DISCUZ_ROOT.'source/plugin/ljplcj/include/log.php';
}else if($op=='seo'){
	$key=$_GET['key'];
	$perpage=10;
	$curpage=$_GET['page'];
	if(!$curpage){
		$curpage=1;
	}
	$curnum=($curpage-1)*$perpage;
	$sign=1;
	$num =C::t('#ljplcj#plugin_ljcaiji')->fetch_by_count_num($key);
	$seoarr=C::t('#ljplcj#plugin_ljcaiji')->fetch_all_by_con($key,$curnum,$perpage);
	include template('ljplcj:seoeye');
}else if($op=='delete'){//删除规则
	 include_once DISCUZ_ROOT.'source/plugin/ljplcj/include/delete.php';
}else if($op=='del'){//删除规则
	 if($_GET['id']&&$_GET['formhash']==formhash()){
		C::t('#ljplcj#plugin_ljcaiji')->delete($_GET['id']);
		cpmsg(lang('plugin/ljplcj','xx2'), 'action=plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize', 'succeed');
	 }else{
		cpmsg(lang('plugin/ljplcj', 'ljcj8'));
	 }
}else if($op=='caiji'){ 
	include_once DISCUZ_ROOT.'source/plugin/ljplcj/ljcaiji.inc.php';
}else if($op=='now'){ 
	include template('ljplcj:now');
}else if($op=='cj'){ 
	$perpage=10;
	$curpage=$_GET['page'];
	if(!$curpage){
		$curpage=1;
	}
	$curnum=($curpage-1)*$perpage;
	$sign=1;
	$num = C::t('#ljplcj#plugin_ljcaiji')->fetch_by_A_B_count_num();
	$numarr = C::t('#ljplcj#plugin_ljcaiji')->fetch_all_by_A_B_con($curnum,$perpage);
	$forumarray=C::t('forum_forum')->range();
	include template('ljplcj:cj');
}else if($op=='deal'){
	include_once DISCUZ_ROOT.'source/plugin/ljplcj/include/caiji.php';
}else if($op=='cs'){
	include_once DISCUZ_ROOT.'source/plugin/ljplcj/include/cs.php';
}else if($op=='sc'){
	if($_GET['id']&&$_GET['formhash']==formhash()){
		C::t('#ljplcj#plugin_now_ljcaiji')->delete($_GET['id']);
		cpmsg(lang('plugin/ljplcj', 'ljcj5'),"action=plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize&op=cj");
	 }else{
		cpmsg(lang('plugin/ljplcj', 'ljcj8'));
	 }
}else if($op=='z'){
	include_once DISCUZ_ROOT.'source/plugin/ljplcj/include/yun.php';						
}
?> 