<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	table_bind.php
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_bind extends discuz_table {

	public function __construct() {
		$this->_table = 'kylefu_wechat_bind';
		$this->_pk = 'id';

		parent::__construct();
	}

	public function count_all($keys='') {
		if($keys)
		{
			$wheresql=' where '.DB::field('nick_name', '%'.$keys.'%', 'like');
			return (int) DB::result_first('SELECT count(*) FROM %t %i', array($this->_table,$wheresql), $this->_pk);
		}
		return (int) DB::result_first("SELECT count(*) FROM %t", array($this->_table));
	}
	
	public function fetch_all($start, $limit,$order='id',$keys='') {
		$searchsql='';
		if($keys)
		{
			$wheresql=' where '.DB::field('nick_name', '%'.$keys.'%', 'like');
			return DB::fetch_all('SELECT * FROM %t %i ORDER BY '.$order.' desc ' . DB::limit($start, $limit), array($this->_table,$wheresql), $this->_pk);
		}
		return DB::fetch_all('SELECT * FROM %t ORDER BY '.$order.' desc ' . DB::limit($start, $limit), array($this->_table), $this->_pk);
	}
	public function fetch_by_id($id) {
		return DB::fetch_first('SELECT * FROM %t WHERE id=%d', array($this->_table, $id));
	}
	public function fetch_by_fake_id($id) {
		return DB::fetch_first('SELECT * FROM %t WHERE fake_id=%d', array($this->_table, $id));
	}
	public function fetch_by_uid($id) {
		return DB::fetch_first('SELECT * FROM %t WHERE uid=%d', array($this->_table, $id));
	}
	public function fetch_by_id_one($id,$field) {
		return DB::result_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
	public function update_by_id($data,$id) {
		return DB::update($this->_table,$data,"id=".$id);
	}
	public function insert($data) {
		return DB::insert($this->_table,$data,true);
	}
	public function delete_by_id($id) {
		return DB::delete($this->_table,"id=".$id,true);	
	}
}
