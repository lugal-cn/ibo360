<?php
 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	if(!submitcheck('submit')) {
		showformheader('');
		showtableheader();
		showsubtitle(array('',lang('plugin/ljplcj','log_1'),lang('plugin/ljplcj','log_2'),lang('plugin/ljplcj','log_3'),lang('plugin/ljplcj','log_4'),lang('plugin/ljplcj','log_5')));
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=25;
		$start=($currpage-1)*$perpage;
		//$con=" where 1";
		$num=C::t('#ljplcj#plugin_ljcaiji_log')->count();
		//debug($con);
		$counts=C::t('#ljplcj#plugin_ljcaiji_log')->range($start,$perpage,'desc');
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=ljplcj&pmod=guize&op=log', 0, 10, false, false);
		$forums=C::t('forum_forum')->range();
		foreach($counts as $tongji){
			$timestamp=date('Y-m-d H:i:s',$tongji['timestamp']);
			showtablerow('', array('', 'class="td_m"', 'class="td_k"', 'class="td_l"','class="td_l"','class="td_l"'), array(
							'',
							$tongji['uid'],	
							$forums[$tongji['fid']]['name'],	
							$tongji['subject'],
							$timestamp,
							'<a target="_blank" href="forum.php?mod=viewthread&tid='.$tongji['tid'].'">'.lang('plugin/ljplcj','log_6').'</a>',		
									
							));
			
		}
		showsubmit('', '', '','',$paging);
		showtablefooter();
		showformfooter();
		
		
	}

?>
