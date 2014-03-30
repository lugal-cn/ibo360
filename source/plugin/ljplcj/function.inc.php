<?php
function htmltoubb($str) {
	$str=str_replace("\n",'',$str);
	$str=str_replace(array('<br />','<br>','<BR>'),"\r\n",$str);
	$str=str_replace(array('</p>','</P>'),"\r\n",$str);
	$str=preg_replace('/&[A-Za-z]+;/','',$str);
	$str=preg_replace('/&#[0-9]+;/','',$str);
	$str=preg_replace("/<a[^>]+href=\"([^\"]+)\"[^>]*>(.*?)<\/a>/i","[url=$1]$2[/url]",$str);
	$str=preg_replace("/<font(.*?)color=\"#([^ >]+)\"(.*?)>(.*?)<\/font>/i","<font$1$3>[color=$2]$4[/color]</font>",$str);
	$str=preg_replace("/<font(.*?)face=\"([^ >]+)\"(.*?)>(.*?)<\/font>/i","<font$1$3>[face=$2]$4[/face]</font>",$str);
	$str=preg_replace("/<font(.*?)size=\"([^ >]+)\"(.*?)>(.*?)<\/font>/i","[size=$2]$4[/size]",$str);
	$str=preg_replace("/<img[^>]+src=\"([^\"]+)\"[^>]*>/i","[img]$1[/img]",$str);
	$str=preg_replace("/<div[^>]+align=\"([^\"]+)\"[^>]*>(.*?)<\/div>/i","[align=$1]$2[/align]",$str);
	$str=preg_replace("/<([\/]?)u>/i","[$1u]",$str);
	$str=preg_replace("/<([\/]?)em>/i","[$1I]",$str);
	$str=preg_replace("/<([\/]?)strong>/i","[$1b]",$str);
	$str=preg_replace("/<([\/]?)b(.*?)>/i","[$1b]",$str);
	$str=preg_replace("/<([\/]?)i>/i","[$1i]",$str);
	$str=preg_replace("/<[^>]*?>/i","",$str);
	return $str;
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
function xkConvert($str,$to_encoding,$from_encoding,$ifmb=true) {
	if (strtolower($to_encoding) == strtolower($from_encoding)) {
		return $str;
	}
	if (is_array($str)) {
		foreach ($str as $key=>$value) {
			$str[$key] = xkConvert($value,$to_encoding,$from_encoding,$ifmb);
		}
		return $str;
	} else {
		if (function_exists('mb_convert_encoding') && $ifmb) {
			return mb_convert_encoding($str,$to_encoding,$from_encoding);
		} else {
			require_once libfile('class/chinese');
			$chinese = new Chinese($from_encoding, $to_encoding, true);
			$str = $chinese->Convert($str);
		}
	}
}
//²É¼¯html 
function getwebcontent($url){ 
$ch = curl_init(); 
$timeout = 10; 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
$contents = trim(curl_exec($ch)); 
curl_close($ch); 
return $contents; 
} 
?>