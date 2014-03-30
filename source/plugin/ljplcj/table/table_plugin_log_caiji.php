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

class table_plugin_log_caiji extends discuz_table
{
	public function __construct() {

		$this->_table = 'plugin_log_caiji';
		$this->_pk    = 'id';

		parent::__construct();
	}
	function fetch_by_count_url($url,$subject){
		if($subject){
			return DB::result_first("select count(*) from %t where url=%s or title=%s",array($this->_table,$url,$subject));
		}else{
			return DB::result_first("select count(*) from %t where url=%s",array($this->_table,$url));
		}
	}
	function fetch_all_by_id($id){
		return DB::fetch_all("select * from %t where did=%d",array($this->_table,$id));
	}
	function fetch_by_count_id($id,$sign){
		if($sign){
			return DB::result_first("select count(*) from %t where did=%d and sign=%s",array($this->_table,$id,$sign));
		}else{
			return DB::result_first("select count(*) from %t where did=%d",array($this->_table,$id));
		}
	}
}

?>