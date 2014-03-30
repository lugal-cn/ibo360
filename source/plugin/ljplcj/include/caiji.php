<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$id=intval($_GET['id']);
$row = C::t('#ljplcj#plugin_ljcaiji')->fetch_by_A_B_id($id);
$row1 = C::t('#ljplcj#plugin_lj_cjurl')->fetch_all_by_id($row['zid']);
$url=unserialize($row['url']);
$fuid=$row[fuid];
$thread=$row[thread];
$shenhe=$row[shenhe];
$zdurl=$row[zdurl];
$bm=$row[bm];
$to_threadcate=$row[to_threadcate];
$fuid = explode ( ',', $fuid );
$fuid = array_unique ( $fuid );
$fuid = array_filter ( $fuid );
$fuid = $fuid[array_rand ( $fuid )];
$tfid=$row[tfid];
if($thread){
	$check=C::t('#ljplcj#plugin_log_caiji')->fetch_by_count_url($thread);
}else{
	$check=C::t('#ljplcj#plugin_log_caiji')->fetch_by_count_url($row1[0]['curl'],$row1[0]['ctitle']);
}
//debug($row);
//采集代码
if($row1&&!$check){
	if($thread){
		$html =  file_get_html($thread,false,null,-1,-1,true,true,$bm);
	}else{
		$html = file_get_html(str_replace('&amp;','&',trim($row1[0]['curl'])),false,null,-1,-1,true,true,$bm);
	}
	if ($html === false || $html === null){
		C::t('#ljplcj#plugin_lj_cjurl')->delete_by_url($row1['0']['curl']);
	}
	if($zdurl=='http://www.qdjimo.com/bbs/'){
		$title=$row1[0]['ctitle'];
	}else{
		foreach($html->find($row['btgz']) as $e){
			$title=$e->innertext;
		}
	}
	foreach($html->find('.bbstext_photo') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('.aimg_tip') as $e)
	$e->outertext='';//途牛网
	foreach($html->find('.a_pr') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('.pstatus') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('.tatt') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('.news_cont_name') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('.news_cont_wx') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('.pstatus') as $e)
	$e->outertext='';//删除a_pr元素locked
	foreach($html->find('.locked') as $e)
	$e->outertext='';//删除a_pr元素locked
	foreach($html->find('a') as $e)
	$e->outertext =$e->plaintext;//将链接替换成文本
	foreach($html->find($row['nrgz']) as $e){
		$content.=$e->innertext; 
		break;
	}
	//debug($content);
	foreach($html->find ('.pct .t_f img' ) as $element){
		if($zdurl=='http://bbs.eelly.com/'||$zdurl=='http://www.smyuan.com/'||$zdurl=='http://www.haitaozj.com/'||$zdurl=='http://www.logclub.com/'||$zdurl=='http://www.bet999.com/'||$zdurl=='http://www.777b.com/'||$zdurl=='http://www.qd.sd.cn/'||$zdurl=='http://bbs.qianlong.com/'||$zdurl=='http://bbs.28tui.com/'){
			$tupian[]=$element->file ;
			foreach($tupian as $v){
				if($v){
					$img=str_replace('/','\/',$v);
					$content=preg_replace('/<ignore_js_op>.+?'.$img.'.+?<\/ignore_js_op>/is','<img width="600" border="0" alt="" src="'.$zdurl."/".$v.'" class="zoom" onclick="zoom(this, this.src, 0, 0, 0)" id="aimg_2ofMd" initialized="true">',$content);
				}
			}
		}
	}

	foreach($html->find ('.pct .t_f img' ) as $element){
		if($zdurl=='http://bbs.hiapk.com/'||$zdurl=='http://bbs.67.com/'||$zdurl=='http://bbs.tuniu.com/'){
			$content=preg_replace('/<img(.*?)file="(.*?)".*?>/is','<img src="$2">',$content);
			$tupian[]=$element->file ;
			foreach($tupian as $v){
				if($v){
					$img=str_replace('/','\/',$v);
					$content=preg_replace('/<ignore_js_op>.+?'.$img.'.+?<\/ignore_js_op>/is','<img  border="0" alt="" src="'.$v.'" class="zoom" onclick="zoom(this, this.src, 0, 0, 0)" id="aimg_2ofMd" initialized="true">',$content);
				}
			}
		}
	}

	if($zdurl=='http://xmwww.com/'){
		$content=str_replace('“','',$content);
		$content=str_replace('”','',$content);
		$content=str_replace('…','',$content);
	}

	if($zdurl=='http://life.letian.net/'){
		$content=preg_replace('/<img(.*?)src="(.*?)".*?>/is','<img src="http://www.letian.net/$2">',$content);
	}
						
	if($_G['charset']=='gbk'){
		if(is_utf8($title)){
			if(function_exists('mb_convert_encoding')) {
				$title=mb_convert_encoding($title, 'gbk', 'UTF-8');
			} else {
				$title=iconv('utf-8','gbk',$title);
			}
		}
		if(is_utf8($content)){
			if(function_exists('mb_convert_encoding')) {
				$content=mb_convert_encoding($content, 'gbk', 'UTF-8');
			} else {
				$content=iconv('utf-8','gbk',$content);
			}
		}
	}else if($_G['charset']=='utf-8'){
		if(!is_utf8($title)){
			if(function_exists('mb_convert_encoding')) {
				$title=mb_convert_encoding($title, 'UTF-8', 'gbk');
			} else {
				$title=iconv('gbk','utf-8',$title);
			}
		}
		if(!is_utf8($content)){
			if(function_exists('mb_convert_encoding')) {
				$content=mb_convert_encoding($content, 'UTF-8', 'gbk');
			} else {
				$content=iconv('gbk','utf-8',$content);
			}
		}
	}

	if(is_utf8($content)){
		$check=mb_strlen($content,'utf-8');
	}else{
		$check=mb_strlen($content,'gbk');
	}
	$content=html2bbcode($content);
	if($check>$config['zj']){		 
		if($shenhe){
			$yes=-2;
		}else{
			$yes=0;
		}
		$bbcodeoff = checkbbcodes($message, !empty($_GET['bbcodeoff']));
		$smileyoff = checksmilies($message, !empty($_GET['smileyoff']));
		$title=daddslashes($title);
		$content=daddslashes($content);
		$x_useip="202.".rand(96,184).".".rand(124,127).".".rand(9,200);
		$username=C::t('common_member')->fetch($fuid);
		$username=$username['username'];
		
		$synctid=C::t('forum_thread')->insert(array(
			'fid'=>$tfid,
			'posttableid'=>'0',
			'readperm'=>'0',
			'price'=>$coin,
			'typeid'=>$to_threadcate,
			'sortid'=>'0',
			'author'=>$username,
			'authorid'=>$fuid,
			'subject'=>$title,
			'dateline'=>$_G['timestamp'],
			'lastpost'=>$_G['timestamp'],
			'lastposter'=>$username,
			'displayorder'=>$yes,
			'digest'=>'0',
			'special'=>$special,
			'attachment'=>'0',
			'moderated'=>'0',
			'highlight'=>'0',
			'closed'=>'0',
			'status'=>'32',
			'isgroup'=>'0',
		),true);
		$syncpid = insertpost(array('fid' => $tfid,'tid' => $synctid,'first' => '1','author' => $username,'authorid' => $fuid,'subject' => $title,'dateline' => $_G['timestamp'],'message' => $content,'useip' => $x_useip,'invisible' => $yes,'anonymous' => '0','usesig' => '1','htmlon' => 1,'bbcodeoff' => 0,'smileyoff' => 0,'parseurloff' => '0','attachment' => '0',));
		C::t('#ljplcj#plugin_ljcaiji_log')->insert(array('tid'=>$synctid,'fid' => $tfid,'subject' => $title,'message' => $content,'timestamp' => $_G['timestamp'],'uid' => $fuid));
		updatepostcredits('+', $fuid, 'post', $tfid);
		$synclastpost = "$synctid\t".addslashes($title)."\t$_G[timestamp]\t$username";
		C::t('#ljplcj#plugin_forum_forum')->update_forum($synclastpost,$tfid);
		$feedcontent = array(
			'tid' => $synctid,
			'content' => $todaysay,
		);
		C::t('forum_threadpreview')->insert($feedcontent);
		$followfeed = array(
			'uid' => $fuid,
			'username' =>$username,
			'tid' => $synctid,
			'note' => '',
			'dateline' => TIMESTAMP
		);
		
		C::t('home_follow_feed')->insert($followfeed, true);
		C::t('common_member_count')->increase($fuid, array('feeds'=>1));
		if($shenhe){
			$arrsh=array(
				'id'=>$synctid,
				'status'=>'0',
				'dateline'=>$_G['timestamp'],
			);
			DB::insert('forum_thread_moderate',$arrsh);
		}
	}else{
		$content='';
	}

}
//采集代码
//采集后将url数组当前采集的链接从数组中T出，并重新写入数据库.同时将采集的url及采集状态入库  标题、链接、状态
if($content){
	$sign=lang('plugin/ljplcj', 'ljcj3');
}else{
	$sign=lang('plugin/ljplcj', 'ljcj4');
}
if($thread){
	$arr=array('did'=>$id,'title'=>$title,'url'=>$thread,'sign'=>$sign);
}else{
	$arr=array('did'=>$id,'title'=>$row1['0']['ctitle'],'url'=>$row1['0']['curl'],'sign'=>$sign);
}
if($row1){
	C::t('#ljplcj#plugin_lj_cjurl')->delete_by_url($row1['0']['curl']);
	DB::insert('plugin_log_caiji',$arr);
}else{
	C::t('#ljplcj#plugin_now_ljcaiji')->delete($id);
}
//把采集记录取出来

$log=C::t('#ljplcj#plugin_log_caiji')->fetch_all_by_id($id);
$allnum=C::t('#ljplcj#plugin_log_caiji')->fetch_by_count_id($id);
$cgsign=lang('plugin/ljplcj', 'ljcj3');
$sbsign=lang('plugin/ljplcj', 'ljcj4');
$cg=C::t('#ljplcj#plugin_log_caiji')->fetch_by_count_id($id,$cgsign);
$sb=C::t('#ljplcj#plugin_log_caiji')->fetch_by_count_id($id,$sbsign);
//把采集记录取出来
 include template('ljplcj:deal');
?>