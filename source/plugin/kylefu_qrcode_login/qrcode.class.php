<?php
/**
 *  [kylefu_qrcode_login] 2013
 *	qrcode.class.php kylefu $
 *	http://www.kylefu.com 
*/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
class plugin_kylefu_qrcode_login {
	public $qrcode;
	public $_lang;
	public function __construct() {
		global $_G;
		$this->qrcode = $_G['cache']['plugin']['kylefu_qrcode_login'];
		$this->_lang = lang('plugin/kylefu_qrcode_login');
	}
	
	function global_cpnav_top() {
		return $this->icon_form(1);
	}
	
	function global_cpnav_extra1() {
		return $this->icon_form(2);
	}

	function global_cpnav_extra2() {
		return $this->icon_form(3);
	}

	function global_nav_extra() {
		return $this->icon_form(4);
	}
	
	function global_header() {
		return $this->icon_form(5);
	}
	
	function global_footerlink(){
		return $this->icon_form(6);
	}
	
	function global_usernav_extra1() {
		return $this->icon_form(7) ? '<span class="pipe">|</span>'.$this->icon_form(7) : '';
	}
	
	function global_usernav_extra2() {
		return $this->icon_form(8) ? '<span class="pipe">|</span>'.$this->icon_form(8) : '';
	}
	
	function global_login_extra() {
		return $this->icon_form(9) ? '<div class="fastlg_fm y">'.$this->icon_form(9).'<p class="hm xg1">'.$this->_lang['display_text'].'</p></div>' : '';
	}
	
	function global_footer() {
		return $this->icon_form(10);
	}
	
	public function icon_form($place){
		$html = '<a href="plugin.php?id=kylefu_qrcode_login">';
		switch($this->qrcode['icon_form']){
			case 1:
				$html .= $this->bind('<img src="'.($this->qrcode['icon_url']?$this->qrcode['icon_url']:$this->_lang['icon_url']).'" align="absmiddle">');
			break;
			case 2:
			default:
				$html .= $this->bind($this->qrcode['display_text']?$this->qrcode['display_text']:$this->_lang['display_text']);
			break;
		}
		$html .= '</a>';
		if(in_array($place,dunserialize($this->qrcode['qrcode_place']))){
			return $html;
		}else return NULL;
	}
	
	public function bind($html,$type = 'text'){
		global $_G;
		if($_G['uid']){
			if(C::t('#kylefu_qrcode_login#bind')->fetch_by_uid($_G['uid'])){
				return NULL;
			}else return $type == 'text' ? $this->_lang['bind'] : $html;
		}
		return $html;
	}
}

class plugin_kylefu_qrcode_login_forum extends plugin_kylefu_qrcode_login {
	function index_status_extra() {
		return parent::icon_form(13);
	}
	function index_nav_extra() {
		return parent::icon_form(14);
	}
}
?>