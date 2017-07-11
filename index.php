<?php  

define('ROOT', dirname(__FILE__).'/');  //系统程序根路径, 必须定义, 用于防翻墙
header("Content-type:text/html;charset=utf-8");
require(ROOT . 'includes/core.php');  //加载核心文件

APP::run();

?> 