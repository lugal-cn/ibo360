<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	user.config.inc.php kylefu $
 *	http://www.kylefu.com 
*/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
$perpage = 50;
$page = max(1, intval($_GET['page']));
$order=$_GET['order'] ? $_GET['order'] :'id';
$start=($page - 1) * $perpage;
showtableheader($_lang['user_tips']);
showformheader('plugins&identifier=kylefu_qrcode_login&pmod=user&operation=config');
showtablerow('',array('width="60px"','width="220px"'),array(
		 '<script>function yesno() {if(confirm("'.$_lang['confirm_delete'].'")){ return true;} else return false;}</script><font style="font-size: 14px;font-weight: bold;">'.$_lang['user_list'].'</font>',
		$lang['search'].': <input type="text" name="keys" style="width:170px;" value="'.$_GET['keys'].'"/>','<input type="submit" class="btn" value="'.$lang['search'].'" />',
		'',
		),false);			

echo '<tr class="header">';	
echo '<th><a href="'.$pluginurl.'operation=config&order=id">ID</a></th>';	
echo '<th>fakeid</th>';
echo '<th>'.$_lang['nick_name'].'</th>';
echo '<th>'.$_lang['user_name'].'</th>';
echo '<th><a href="'.$pluginurl.'operation=config&order=gender">'.$_lang['gender'].'</a></th>';
echo '<th>'.$_lang['username'].'</th>';
echo '<th>UID</th>';
echo '<th>'.$_lang['create_time'].'</th>';
echo '<th>'.$_lang['operation'].'</th>';
echo '</tr>';
$list=C::t('#kylefu_qrcode_login#bind')->fetch_all($start,$perpage,$order,dhtmlspecialchars($_GET['keys']));
	foreach($list as $val){
		showtablerow('','',array(
			$val['id'],
			$val['fake_id'],
			$val['nick_name'],
			$val['user_name'],
			$_lang['gender_'.$val['gender']],
			'<a href="home.php?mod=space&uid='.$val['uid'].'" target="_blank">'.$val['username'].'</a>',
			$val['uid'],
			dgmdate($val['createtime']),
			'<a href="'.$pluginurl.'operation=del&id='.$val['id'].'" onclick="return yesno();">'.$_lang['delete'].'</a>'
		),false);
	}

showformfooter();
showtablefooter();
echo multi(C::t('#kylefu_qrcode_login#bind')->count_all(dhtmlspecialchars($_GET['keys'])), $perpage, $page, $pluginurl.'operation=config&order='.$order.'&keys='.$_GET['keys']);
?>