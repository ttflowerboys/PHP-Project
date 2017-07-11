<?php if(!defined('ROOT')) die('Access denied.');

class c_index extends SWeb{



    public function index(){
        $this->assign('menu', 'home'); //菜单样式
		$this->display('index.tpl');

		if($action=="topdp")
		{
            $this->topdplist();
		}else if($action == "toparea"){
			$this->toparealist();
		}
	}



	public function topdplist(){
		$wheresql = '';
		$listsql="select * from " . TABLE_PREFIX . "dp where ".$wheresql." order by precent desc LIMIT 0, 10";
				
		$getlist = $this->db->getAll($listsql);
		$listhtml='';
		foreach($getlist as $key =>$value)
		{
			
			$listhtml.='<tr><td>'.($key+1).'</td><td>'.$value['name'].'-'.$value['manprecent'].'</td><td>'.$value['womanpercent'].'%</td><td>'.$value['percent'].'</td></tr>';

		}

		die($listhtml);
	}


}

?>