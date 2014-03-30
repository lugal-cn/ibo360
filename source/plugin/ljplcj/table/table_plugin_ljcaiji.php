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

class table_plugin_ljcaiji extends discuz_table
{
	public function __construct() {

		$this->_table = 'plugin_ljcaiji';
		$this->_pk    = 'id';

		parent::__construct();
	}
	function fetch_by_mingcheng($mingcheng){
		return DB::result_first("select mingcheng from %t where mingcheng=%s",array($this->_table,$mingcheng));
	}
	function fetch_by_count_num($key){
		$carray[]=$this->_table;
		if($key){
			$carray[]='%'.addcslashes($key, '%_').'%';
			$con=" and mingcheng like %s";
		}
		return DB::result_first('select count(*) from %t where 1'.$con,$carray);
	}
	function fetch_all_by_con($key,$curnum,$perpage){
		$carray[]=$this->_table;
		if($key){
			$carray[]='%'.addcslashes($key, '%_').'%';
			$con=" and mingcheng like %s";
		}
		$carray[]=$curnum;
		$carray[]=$perpage;
		return DB::fetch_all("select * from %t where 1 $con order by id desc limit %d,%d",$carray);
	}
	function fetch_by_A_B_count_num(){
		return DB::result_first(" select count(*) from %t a left join %t b on a.zid=b.id order by a.id desc",array('plugin_now_ljcaiji',$this->_table));
	}
	function fetch_all_by_A_B_con($curnum,$perpage){
		return DB::fetch_all ( "select a.*,b.mingcheng from %t a left join %t b on a.zid=b.id order by a.id desc limit %d,%d",array('plugin_now_ljcaiji',$this->_table,$curnum,$perpage));
	}
	function fetch_by_A_B_id($id){
		return DB::fetch_first ( "select a.*,b.mingcheng,b.bkgz,b.btgz,b.nrgz,b.fuid,b.zdurl,b.bm from %t a left join %t b on a.zid=b.id where a.id=%d",array('plugin_now_ljcaiji',$this->_table,$id));
	}
	function fetch_by_zdurl($zdurl){
		return DB::fetch_first ( "select * from %t where zdurl=%s",array($this->_table,$zdurl));
	}
	function fetch_all_forum_forum_and_forum_forumfield($zdurl){
		return DB::fetch_all ( "select f.fid,f.name,f.fup,f.type,ff.threadtypes from %t f left join %t ff using(fid) where f.status = '1'",array('forum_forum','forum_forumfield'));
	}
}

?>