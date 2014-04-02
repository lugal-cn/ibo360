<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	user.inc.php kylefu $
 *	http://www.kylefu.com 
*/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/kylefu_qrcode_login/function/function.qrcode.login.php';
$pluginurl = ADMINSCRIPT.'?action=plugins&identifier=kylefu_qrcode_login&pmod=user&';
$op = array('config','del');
if(in_array($operation,$op)){
	include_once DISCUZ_ROOT.'./source/plugin/kylefu_qrcode_login/inc/user.'.$operation.'.inc.php';
}
?>