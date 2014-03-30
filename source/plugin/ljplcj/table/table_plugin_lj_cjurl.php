<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_plugin_lj_qqqun_type.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_plugin_lj_cjurl extends discuz_table
{
	public function __construct() {

		$this->_table = 'plugin_lj_cjurl';
		$this->_pk    = 'cid';

		parent::__construct();
	}
	function fetch_all_by_id($zid){
		return DB::fetch_all ( "select * from %t  where cid=%d",array($this->_table,$zid));
	}
	function delete_by_url($url){
		return DB::query("delete from %t where curl=%s",array($this->_table,$url));
	}
}

?>