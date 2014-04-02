<?php
/**
 * [kylefu_qrcode_login] 2013
 * function.qrcode.login.php
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('KYLEFU_API_URL' , 'http://wechat.kylefu.com/api/');
define('WECHAT_KEY','KYLEFU');
if(!isset($_G['cache']['plugin'])){
	loadcache('plugin');
}
$_lang = lang('plugin/kylefu_qrcode_login');
$operation = trim($_GET['operation']);
?>