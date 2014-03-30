<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$dal = htmlspecialchars($_GET['callback']);
	$requesturl=htmlspecialchars($_GET['u']);
	$host=htmlspecialchars($_GET['q']);
	preg_match('/(http\:\/\/.*?\.?.*?\..*?\/).*?/is',$requesturl,$rearr);
	$zdurl=$rearr[1];
	if(strpos($requesturl,"sina.com")!==false){
		$row = C::t('#ljplcj#plugin_ljcaiji')->fetch_by_zdurl('sina.com');
	}else if(strpos($requesturl,"qq.com")!==false){
		$row = C::t('#ljplcj#plugin_ljcaiji')->fetch_by_zdurl('qq.com');
	}else if(strpos($requesturl,"cngba.com")!==false){
		$row = C::t('#ljplcj#plugin_ljcaiji')->fetch_by_zdurl('cngba.com');
	}else{
		$row = C::t('#ljplcj#plugin_ljcaiji')->fetch_by_zdurl($zdurl);
	}
	$bm=$row[bm];
	$html =  file_get_html($requesturl,false,null,-1,-1,true,true,$bm);
	foreach($html->find($row['btgz']) as $e)
	$title=$e->innertext;
	foreach($html->find('.a_pr') as $e)
	$e->outertext='';//删除a_pr元素
	foreach($html->find('a') as $e)
	$e->outertext =$e->plaintext;//将链接替换成文本
	$i=1;
	foreach($html->find($row['nrgz']) as $e){
		if(strpos($requesturl,"war.163.com")!==false){
			if($i==2){
				$content=$e->innertext; 
				break;
			}
			$i++;
		}else{
			$content=$e->innertext; 
			break;
		}
	}
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
	$array = array("gp_subject" =>$title,"gp_message"=>$content); 
	echo $dal.'('.json_encode($array).')';
	exit;
?>