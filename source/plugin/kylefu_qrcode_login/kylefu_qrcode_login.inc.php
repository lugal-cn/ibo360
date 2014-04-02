<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	kylefu_qrcode_login.inc.php kylefu $
 *	http://www.kylefu.com 
*/
function logdebug($text,$file = 'log'){
	file_put_contents('./'.$file.'.txt',$text."\n",FILE_APPEND);		
}
require_once DISCUZ_ROOT.'./source/plugin/kylefu_qrcode_login/function/function.qrcode.login.php';
if (isset($_POST['code'])) {
	$result = file_get_contents(KYLEFU_API_URL.'index.php?m=login&code='.$_POST['code']);
	$json_data = json_decode($result);
	if($json_data->info->User->Uin){
		$data['fakeid']   = $json_data->info->User->Uin;
		$data['nickname'] = $json_data->info->User->NickName;
		$data['username'] = $json_data->info->User->UserName;
		$data['gender']= $json_data->info->User->Sex;
		$data = urlencode(base64_encode(serialize($data)));
	}
	exit(json_encode(array("status"=>$json_data->status,"data"=>$data)));
}else{
	$qrcode = json_decode(file_get_contents(KYLEFU_API_URL));
	$logincode =  $qrcode->code;
	$qrimg = $qrcode->img;
	include template("kylefu_qrcode_login:index");
}
?>