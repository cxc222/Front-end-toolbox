<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__));
define('APP_NAME','app');
define('APP_PATH','./app/');

define('THINK_PATH', './code/ThinkPHP/');
define('APP_DEBUG', true);

require( THINK_PATH."ThinkPHP.php");