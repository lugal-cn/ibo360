<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	if($_GET[opp]=='del'){
		if(submitcheck('editsubmit')){
			if($_GET['log_caiji']){
				C::t('#ljplcj#plugin_log_caiji')->truncate();
			}
			if($_GET['lj_cjurl']){
				C::t('#ljplcj#plugin_lj_cjurl')->truncate();
			}
			if($_GET['now_ljcaiji']){
				C::t('#ljplcj#plugin_now_ljcaiji')->truncate();
			}
			if($_GET['ljcaiji_log']){
				C::t('#ljplcj#plugin_ljcaiji_log')->truncate();
			}
		cpmsg(lang('plugin/ljplcj','xx2'),'action=plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize&op=delete', 'succeed');
		}
	}
showformheader("plugins&operation=config&do=$do&identifier=ljplcj&pmod=guize&op=delete&opp=del",'enctype');
		showtableheader('');
		showsetting(lang('plugin/ljplcj','del_5'), 'log_caiji', '', 'radio', 0, 1,lang('plugin/ljplcj','del_6'));
		showtagfooter('tbody');
		showsetting(lang('plugin/ljplcj','del_7'), 'lj_cjurl', '', 'radio', 0, 1,lang('plugin/ljplcj','del_8'));
		showtagfooter('tbody');
		showsetting(lang('plugin/ljplcj','del_9'), 'now_ljcaiji', '', 'radio', 0, 1,lang('plugin/ljplcj','del_10'));
		showtagfooter('tbody');
		showsetting(lang('plugin/ljplcj','del_1'), 'ljcaiji_log', '', 'radio', 0, 1,lang('plugin/ljplcj','del_2'));
		showtagfooter('tbody');
		showsubmit('editsubmit',lang('plugin/ljplcj','del_11'));
		showtablefooter();
		showformfooter();
?>