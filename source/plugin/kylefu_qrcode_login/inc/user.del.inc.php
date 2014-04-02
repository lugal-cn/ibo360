<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	user.del.inc.php kylefu $
 *	http://www.kylefu.com 
*/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
$id = intval($_GET["id"]);
if(empty($id))
	cpmsg('id'.$_lang['no_exists'], '', 'error');
C::t('#kylefu_qrcode_login#bind')->delete_by_id($id);
cpmsg($_lang['delete'].$_lang['success'],'action=plugins&operation=config&identifier=kylefu_qrcode_login&pmod=user','succeed');
?>