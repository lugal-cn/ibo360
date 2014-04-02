<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	uninstall.inc.php kylefu
 */
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
if (!file_exists(DISCUZ_ROOT.'./source/plugin/kylefu_wechat/kylefu_wechat.inc.php')){
$sql =<<<EOF
DROP TABLE IF EXISTS `pre_kylefu_wechat_bind`;
EOF;
}
runquery($sql);
$finish = true;
?>