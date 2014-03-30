<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
drop table IF EXISTS `pre_plugin_lj_cjurl`;
drop table IF EXISTS `pre_plugin_ljcaiji_log`;
drop table IF EXISTS `pre_plugin_now_ljcaiji`;
drop table IF EXISTS `pre_plugin_log_caiji`;
drop table IF EXISTS `pre_plugin_ljcaiji`;
EOF;
runquery($sql);

$finish = TRUE;
?>