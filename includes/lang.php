<?php
//定义前台语言
$lang1=$_GET['lang'];


if(isset($_COOKIE['languages'])){


	$lang = $_COOKIE['languages'];

	
	if($lang1!=$lang && $lang1!=''){
		$lang=$lang1;
	
		setcookie('languages', $lang, time()+3600*24,'.ROOT.');
		
		$lang = $_COOKIE['languages'];
	}
	
	
	
}else{

		if($lang1=='' || $lang1=='cn'){
			$lang='cn';
		}else{
			$lang='en';
		}
		
		setcookie('languages', $lang, time()+3600*24,'.ROOT.');

}
if($lang == 'cn')
{
	define('IS_CHINESE',true );
}else{
	define('IS_CHINESE',false );
}
 //define('IS_CHINESE',($lang == 'cn') ? true : false);

 
?>