<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_plugin_ljbrand_region.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_plugin_forum_forum extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_forum';
		$this->_pk    = 'fid';

		parent::__construct();
	}
	public function update_forum($synclastpost,$bkfid,$x_lastpost){
		if($synclastpost){
			return DB::query("UPDATE %t SET lastpost=%s, threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid=%d",array('forum_forum',$synclastpost,$bkfid));		
		}
		if($x_lastpost){
			return DB::query("UPDATE %t SET lastpost=%s, posts=posts+1, todayposts=todayposts+1 WHERE fid=%d",array('forum_forum',$x_lastpost,$bkfid));
		}
	}

}


?>