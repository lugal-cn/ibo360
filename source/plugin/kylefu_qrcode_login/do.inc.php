<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	do.inc.php kylefu $
 *	http://www.kylefu.com 
*/
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/kylefu_qrcode_login/function/function.qrcode.login.php';
dsetcookie('kylefu_qrcode_login_data',$_GET['data']);
$data = unserialize(base64_decode(dhtmlspecialchars($_GET['data'])));
if(!empty($data)){
	$bind = C::t('#kylefu_qrcode_login#bind')->fetch_by_fake_id($data['fakeid']);
	require libfile('function/member');
	require libfile('class/member');
	$_GET['loginsubmit'] = $_GET['infloat'] = 'yes'; 
	if($bind){
		if(!$_G['uid']){
			dsetcookie('kylefu_qrcode_login_data','');
			dreferer('./');
			list($_GET['password'],$_GET['questionid'],$_GET['answer']) = explode(',',authcode($bind['authcode'],'DECODE',WECHAT_KEY));
			$_GET['username'] = $bind['username'];
			$ctl_obj = new logging_ctl();
			$_G['setting']['seccodestatus'] = 0;
			$ctl_obj->setting = $_G['setting'];
			$ctl_obj->on_login();
		}else{
			showmessage($_lang['login_ok'],'forum.php');
		}
	}else{
		if(!submitcheck('submit')){
			if(C::t('#kylefu_qrcode_login#bind')->fetch_by_uid($_G['uid'])){
				showmessage($_lang['yes_bind']);
			}else{
				if(!empty($_G['cache']['plugin']['kylefu_qrcode_login']['plc_username']) || !empty($_G['cache']['plugin']['kylefu_qrcode_login']['plc_password'])|| !empty($_G['cache']['plugin']['kylefu_qrcode_login']['qrcode_url'])){
					$attention = file_get_contents(KYLEFU_API_URL.'index.php?g=auth&account='.$_G['cache']['plugin']['kylefu_qrcode_login']['plc_username'].'&password='.$_G['cache']['plugin']['kylefu_qrcode_login']['plc_password'].'&m=getInfo&id='.$data['fakeid']);
					if($_POST['code']){
						if($attention){
							die(json_encode(array('status'=>'ok')));
						}else die(json_encode(array('status'=>'no')));
					}else{
						if(!$attention){
							include template("kylefu_qrcode_login:attention");exit;
						}
					}
				}
				include template("kylefu_qrcode_login:bind");
			}
		}else{
			if(empty($_GET['username']))showmessage($_lang['username_empty']);
			if(empty($_GET['password']))showmessage($_lang['password_empty']);
			$result = userlogin($_GET['username'], $_GET['password'], $_GET['questionid'], $_GET['answer'], $_G['setting']['autoidselect'] ? 'auto' : $_GET['loginfield'], $_G['clientip']);
			if($result['ucresult']['uid'] <= 0) {
				showmessage($_lang['no_user']);
			}else{
				dsetcookie('kylefu_qrcode_login_data','');
				$data_new['fake_id']	= dhtmlspecialchars($data['fakeid']);
				$data_new['nick_name']	= diconv(dhtmlspecialchars($data['nickname']),'utf-8',CHARSET);
				$data_new['user_name']	= diconv(dhtmlspecialchars($data['username']),'utf-8',CHARSET);
				$data_new['gender']		= $data['gender'];
				$data_new['username']	= $result['ucresult']['username'];
				$data_new['uid']		= $result['ucresult']['uid'];
				$data_new['authcode']	= authcode($_GET['password'].','.$_GET['questionid'].','.$_GET['answer'],'ENCODE',WECHAT_KEY);
				$data_new['createtime'] = time();
				if(!empty($_G['cache']['plugin']['kylefu_qrcode_login']['plc_username']) || !empty($_G['cache']['plugin']['kylefu_qrcode_login']['plc_password'])){
					@file_get_contents(KYLEFU_API_URL.'index.php?g=auth&account='.$_G['cache']['plugin']['kylefu_qrcode_login']['plc_username'].'&password='.$_G['cache']['plugin']['kylefu_qrcode_login']['plc_password'].'&m=send&id='.$data['fakeid'].'&content='.diconv(($_G['cache']['plugin']['kylefu_qrcode_login']['bind_success'] ? $_G['cache']['plugin']['kylefu_qrcode_login']['bind_success'] : $_lang['success'].$_lang['bind']),CHARSET,'utf-8'));
				}
				C::t('#kylefu_qrcode_login#bind')->insert($data_new);
				if(!$_G['uid']){
					dreferer('./');
					$_GET['username'] = $data_new['username'];
					$_GET['password'] = $_GET['password'];
					$ctl_obj = new logging_ctl();
					$_G['setting']['seccodestatus'] = 0;
					$ctl_obj->setting = $_G['setting'];
					$ctl_obj->on_login();
				}else{
					showmessage($_lang['success'].$_lang['bind'],'forum.php');
				}
			}
		}
	}
}else showmessage($_lang['no_exists']);
?>