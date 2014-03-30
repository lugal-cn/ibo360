<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_plugin_lj_qqqun.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_plugin_ljcaiji_log extends discuz_table
{
	public function __construct() {

		$this->_table = 'plugin_ljcaiji_log';
		$this->_pk    = 'id';

		parent::__construct();
	}
	/*public function range_by_guesstime($con,$start,$perpage,$sort){
		return DB::fetch_all('select * from '.DB::table($this->_table)." $con order by timestamp $sort limit $start,$perpage");
	}
	public function count_by_uid_username($con){
		return DB::result_first('select count(*) from '.DB::table($this->_table)." $con ");
	}*/
}

?>