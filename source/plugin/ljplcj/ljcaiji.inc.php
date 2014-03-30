<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
ini_set ('memory_limit',-1);
ini_set ('max_execution_time',0);

include_once DISCUZ_ROOT.'source/plugin/ljplcj/simple_html_dom.php';
include_once DISCUZ_ROOT.'source/plugin/ljplcj/function.inc.php';
$forum_list = $forum_cate = $forum_type_list = $forum_arr =  array();
$query = C::t('#ljplcj#plugin_ljcaiji')->fetch_all_forum_forum_and_forum_forumfield();
foreach($query as $rt){
	if ($rt['type'] == 'group') {
		$forum_list[$rt['fid']]['name'] = $rt['name'];
	} elseif ($rt['type'] == 'forum') {
		$forum_arr[$rt['fid']] = $rt['name'];
		$forum_cate[$rt['fid']] = $rt['fup'];
		$forum_list[$rt['fup']]['list'][$rt['fid']]['name'] = $rt['name'];
		if (!empty($rt['threadtypes'])) {
			$forum_list[$rt['fup']]['list'][$rt['fid']]['threadtypes'] = unserialize($rt['threadtypes']);
		}
	} else {
		$forum_arr[$rt['fid']] = $rt['name'];
		$forum_list[$forum_cate[$rt['fup']]]['list'][$rt['fup']]['list'][$rt['fid']]['name'] = $rt['name'];
		if (!empty($rt['threadtypes'])) {
			$forum_list[$forum_cate[$rt['fup']]]['list'][$rt['fup']]['list'][$rt['fid']]['threadtypes'] = unserialize($rt['threadtypes']);
		}
	}
}
$forum_str = '<select name="tfid" onchange="changetypes(this.value)">';
$forumtypes_str = $type_info_json = '';
foreach($forum_list as $key=>$value) {
	if (count($value['list']) > 0) {
		$forum_str .= '<option value="'.$key.'">&gt;&gt; '.$value['name'].'</option>';
		foreach($value['list'] as $k=>$v) {
			$forum_str .= '<option value="'.$k.'"> &nbsp;|- '.$v['name'].'</option>';
			$forumtypes_str .= "<div id='type_$k'><option value='0'>".lang('plugin/ljplcj', 'ljcj1')."</option>";
			foreach($v['threadtypes']['types'] as $kt=>$vt) {
				$forum_type_list[$k][$kt] = $vt;
				$forumtypes_str .= '<option value="'.$kt.'">'.$vt.'</option>';
			}
			$forumtypes_str .= "</div>";
			if (count($v['list']) > 0) {
				foreach($v['list'] as $kk=>$vv) {
					$forum_str .= '<option value="'.$kk.'"> &nbsp;|-  &nbsp;|-  '.$vv['name'].'</option>';
					$forumtypes_str .= "<div id='type_$kk'><option value='0'>".lang('plugin/ljplcj', 'ljcj1')."</option>";
					foreach($vv['threadtypes']['types'] as $kkt=>$vvt) {
						$forum_type_list[$kk][$kkt] = $vvt;
						$forumtypes_str .= '<option value="'.$kkt.'">'.$vvt.'</option>';
					}
					$forumtypes_str .= "</div>";
				}
			}
		}
	}
}
if (CHARSET == 'gbk') {
	$forum_type_list = xkConvert($forum_type_list,'UTF8','GBK');
}
$type_info_json = json_encode($forum_type_list);
$forum_str .= '</select>';
include_once libfile('function/post');
include_once libfile('function/discuzcode');
if(submitcheck('submit')){
	$begin=addslashes($_GET['begin']);
	$end=addslashes($_GET['end']);
	$id=addslashes($_GET['id']);
	$gzarr=C::t('#ljplcj#plugin_ljcaiji')->fetch($_GET['id']);
	$zdurl=$gzarr['zdurl'];
	$bm=$gzarr['bm'];
	$tfid=addslashes($_GET['tfid']);
		$to_threadcate=addslashes($_GET['to_threadcate']);
		$fuid = addslashes($_GET['fuid']);
		DB::update('plugin_ljcaiji',array('fuid'=>$fuid),'id='.$id);
		$thread = addslashes($_GET['thread']);
		$shenhe = addslashes($_GET['shenhe']);
		$fuid = explode ( ',', $fuid );
		$fuid = array_unique ( $fuid );
		$fuid = array_filter ( $fuid );
		$fuid = $fuid[array_rand ( $fuid )];
		$newfid=addslashes($_GET['newfid']);
	if(!$thread){
		$k=0;
		FOR ($i = $begin; $i <= $end; $i++){
		
		$url=str_replace('{page}',$i,$newfid);
		
		$listhtml = file_get_html($url,false,null,-1,-1,true,true,$bm);
		
		$myurl=str_replace('http://','',$zdurl);
		
		foreach($listhtml->find($gzarr['bkgz']) as $e){
			
			if(!(strpos($e->href,$myurl)||strpos($e->href,$myurl)===0)){
				$e->href=$zdurl.$e->href;
			}
			$arr[$k]['url']=$e->href;
			
		if($_G['charset']=='gbk'){
				
			if(is_utf8($e->plaintext)){
				
				if(function_exists('mb_convert_encoding')) {
					
					$e->plaintext=mb_convert_encoding($e->plaintext, 'gbk', 'UTF-8');
					//
				} else {
					$e->plaintext=iconv('utf-8','gbk',$e->plaintext);
				}
				//$title=iconv('utf-8','gbk',$e->plaintext);
			}
			
		}else if($_G['charset']=='utf-8'){
			if(!is_utf8($e->plaintext)){
				if(function_exists('mb_convert_encoding')) {
					$e->plaintext=mb_convert_encoding($e->plaintext, 'UTF-8', 'gbk');
				} else {
					$e->plaintext=iconv('gbk','utf-8',$e->plaintext);
				}
				//$title=iconv('gbk','utf-8',$e->plaintext);
			}
		}
		
			
			C::t('#ljplcj#plugin_lj_cjurl')->insert(array('cid'=>$id,'curl'=>$e->href,'ctitle'=>daddslashes($e->plaintext)));
		
			$arr[$k]['title']=$e->plaintext;
			$k++;
		}
		
	}
	//debug($e->plaintext);
	//debug($arr);
	$allnum=count($arr);
}else{
	C::t('#ljplcj#plugin_lj_cjurl')->insert(array('cid'=>$id,'curl'=>$thread,'ctitle'=>daddslashes($e->plaintext)));
	$allnum=1;
}
	$urlarray=serialize($arr);
	$nowarr=array(
		'begin'=>$begin,
		'end'=>$end,
		'zid'=>$id,
		'newfid'=>$newfid,
		'tfid'=>$tfid,
		'to_threadcate'=>$to_threadcate,
		'fuid'=>$fuid,
		'url'=>$urlarray,	
		'allnum'=>$allnum,
		'thread'=>$thread,
		'shenhe'=>$shenhe,
	);
	C::t('#ljplcj#plugin_now_ljcaiji')->insert($nowarr);
	//DB::insert('plugin_now_ljcaiji',$nowarr);
	cpmsg(lang('plugin/ljplcj', 'ljcj2'),"action=plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize&op=cj");
}
$id=addslashes($_GET['id']);
if($id){
	$row=C::t('#ljplcj#plugin_ljcaiji')->fetch($_GET['id']);
	$bkfid=explode("#", $row['bkfid']);
	foreach($bkfid as $key => $value) {
		$value=explode('|', $value);
		$newfid[] = $value;		
	}
}
$begin=addslashes($_GET['begin']);
$end=addslashes($_GET['end']);
if(!$begin){
	$begin=1;
}
if(!$end){
	$end=1;
}
include template('ljplcj:caiji');

?> 