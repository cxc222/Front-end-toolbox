<?php
if (!defined('THINK_PATH'))	exit();
$config = require("config.inc.php");

$array = array(
		'URL_MODEL' => 0,
		'LANG_SWITCH_ON' => true,
		'DEFAULT_LANG' => 'zh-cn', // 默认语言
		'LANG_AUTO_DETECT' => true,  // 自动侦测语言
		'DEFAULT_THEME' => 'default',
		'default_module'   => 'index', //默认模块
		'yuicompressor'	=> array(
				'java_home'	=> ROOT_PATH.'/jar/jdk1.7.0_09/bin/java',
				'jar_file'	=> ROOT_PATH.'/jar/yuicompressor-2.4.7.jar',
				
		),//yuicompressor 路径配置
	);
return array_merge($config,$array);
?>