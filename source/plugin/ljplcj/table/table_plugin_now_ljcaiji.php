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

class table_plugin_now_ljcaiji extends discuz_table
{
	public function __construct() {

		$this->_table = 'plugin_now_ljcaiji';
		$this->_pk    = 'id';

		parent::__construct();
	}
	
	
}

?>