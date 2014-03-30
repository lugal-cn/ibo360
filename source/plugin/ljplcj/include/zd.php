<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(submitcheck('addsubmit')){
		if($_FILES['logonew']['tmp_name']) {
			$upload = new discuz_upload();
			$upload->init($_FILES['logonew']);
			if($upload->init($_FILES['logonew']) && $upload->save()) {
				$logonew = $upload->attach['attachment'];
			}
			$tmpaddr=$_G['setting']['attachurl'].'temp/'.$logonew;
			$str=file_get_contents($tmpaddr);
			if($_G['charset']=='utf-8'){
				if(!is_utf8($str)){
					if(function_exists('mb_convert_encoding')) {
						$str=mb_convert_encoding($str, 'UTF-8', 'gbk');
					} else {
						$str=iconv('gbk','utf-8',$str);
					}
				}
			}
			$array = explode("\r\n", $str);  
			$mingcheng=$array['0'];
			$zdarr=array(
				'mingcheng'=>$mingcheng,	
				'zdurl'=>$array['1'],	
				'bkfid'=>$array['2'],	
				'bkgz'=>$array['3'],	
				'btgz'=>$array['4'],	
				'nrgz'=>$array['5'],	
				'fuid'=>$array['6'],	
				'bm'=>$array['7'],	
			);	
		}else{
			$mingcheng=addslashes($_GET['mingcheng']);
			$zdarr=array(
				'mingcheng'=>$mingcheng,	
				'zdurl'=>$_GET['zdurl'],	
				'bkfid'=>$_GET['bkfid'],	
				'bkgz'=>$_GET['bkgz'],	
				'btgz'=>$_GET['btgz'],	
				'nrgz'=>$_GET['nrgz'],	
				'fuid'=>$_GET['fuid'],	
				'bm'=>$_GET['bm'],	
			);
		}
		$che=C::t('#ljplcj#plugin_ljcaiji')->fetch_by_mingcheng($mingcheng);
		$id=intval($_GET['id']);
		if($id||$che){
			if($id){
				DB::update('plugin_ljcaiji',$zdarr," id='$id'");
			}else{
				DB::update('plugin_ljcaiji',$zdarr," mingcheng='$mingcheng'");
			}
			cpmsg(lang('plugin/ljplcj', 'ljcj6'), 'action=plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize', 'succeed');
		}else{
			C::t('#ljplcj#plugin_ljcaiji')->insert($zdarr);
			cpmsg(lang('plugin/ljplcj', 'ljcj7'), 'action=plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize', 'succeed');
		}
		
	}else{
		if($_GET['id']){
			$row=C::t('#ljplcj#plugin_ljcaiji')->fetch($_GET['id']);
		}
	}
	include template('ljplcj:zd');
?>