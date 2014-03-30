<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(submitcheck('bk_submit')) {//http://channel.chinanews.com/cns/cl/ty-ltzh.shtml?pager={page}|.color065590 a|GBK
		$gj=$_GET['bk_gj'];
		$bk_gj=explode('|',$_GET['bk_gj']);
		if($bk_gj){
			FOR ($i = 1; $i <= 1; $i++){
				$url=str_replace('{page}',$i,$bk_gj['0']);
				$listhtml = file_get_html($url,false,null,-1,-1,true,true,$bk_gj['2']);
				foreach($listhtml->find($bk_gj['1']) as $e){
					$arr[$k]['url']=$e->href;
					if($_G['charset']=='gbk'){
						if(is_utf8($e->plaintext)){
							if(function_exists('mb_convert_encoding')) {
								$e->plaintext=mb_convert_encoding($e->plaintext, 'gbk', 'UTF-8');
							} else {
								$e->plaintext=iconv('utf-8','gbk',$e->plaintext);
							}
						}
					}else if($_G['charset']=='utf-8'){
						if(!is_utf8($e->plaintext)){
							if(function_exists('mb_convert_encoding')) {
								$e->plaintext=mb_convert_encoding($e->plaintext, 'UTF-8', 'gbk');
							} else {
								$e->plaintext=iconv('gbk','utf-8',$e->plaintext);
							}
						}
					}
					$arr[$k]['title']=$e->plaintext;
					$k++;
				}
			}
			$allnum=count($arr);
		}
	}
	if(submitcheck('bt_submit')) {
		$bt=$_GET['bt_gj'];
		$bt_gj=explode('|',$_GET['bt_gj']);
		if($bt_gj){
			$html = file_get_html(trim($bt_gj['0']),false,null,-1,-1,true,true,$bt_gj['2']);
			foreach($html->find($bt_gj['1']) as $e){
				$title=$e->innertext;
			}

			if($_G['charset']=='gbk'){
				if(is_utf8($title)){
					if(function_exists('mb_convert_encoding')) {
						$title=mb_convert_encoding($title, 'gbk', 'UTF-8');
					} else {
						$title=iconv('utf-8','gbk',$title);
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
			}
		}
	}
	if(submitcheck('nr_submit')) {
		$nr=$_GET['nr_gj'];
		$nr_gj=explode('|',$_GET['nr_gj']);
		if($nr_gj){
			$html = file_get_html(trim($nr_gj['0']),false,null,-1,-1,true,true,$nr_gj['2']);
			foreach($html->find($nr_gj['1']) as $e){
				$content.=$e->innertext; 
				break;
			}					
			if($_G['charset']=='gbk'){
				if(is_utf8($content)){
					if(function_exists('mb_convert_encoding')) {
						
						$content=mb_convert_encoding($content, 'gbk', 'UTF-8');
					} else {
						$content=iconv('utf-8','gbk',$content);
					}
				}
			}else if($_G['charset']=='utf-8'){
				if(!is_utf8($content)){
					if(function_exists('mb_convert_encoding')) {
						$content=mb_convert_encoding($content, 'UTF-8', 'gbk');
					} else {
						$content=iconv('gbk','utf-8',$content);
					}
				}
			}
		}
	}
	if(submitcheck('submit')) {
		$url=$_GET['mbwz'];
		if($url){
			$mbwz=file_get_contents($url);
		}
	}
	include template('ljplcj:cs');
?>