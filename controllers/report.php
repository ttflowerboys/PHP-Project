<?php if(!defined('ROOT')) die('Access denied.');

class c_report extends SWeb{

    public function index(){
        $this->assign('menu', 'report'); //菜单样式
		
		$this->display('report.tpl');
	} 


}

?>