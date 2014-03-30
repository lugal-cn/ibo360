<?php
	if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
function g2u($a) { 
		return is_array($a) ? array_map('g2u', $a) : iconv('GBK', 'UTF-8', $a);
	}
	function u2g($a) { 
		return is_array($a) ? array_map('u2g', $a) : iconv('UTF-8', 'GBK', $a);
	}
	
function is_utf8($word) 
{ 
if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true) 
{ 
return true; 
} 
else
{ 
return false; 
} 

} // function is_utf8

$op=addslashes($_GET['op']);
if(!$op){
	$op='seo';
}
if($op=='seo'){
	$seoarr=C::t('plugin_ljcaiji')->range();
	$seoarr=g2u($seoarr);
	$test=json_encode($seoarr);
	$test=g2u($test);
	echo $test;
}

?>