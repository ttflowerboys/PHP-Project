<?php if(!defined('ROOT')) die('Access denied.');

class c_list extends SWeb{
	
	public function __construct(){
		parent::__construct();

		$this->id = ForceIntFrom('id'); //当前新闻ID

	}

    public function index(){
		//如果有新闻ID则显示新闻, 其它情况所有新闻
		if($this->id){

			$this->show_list();
		}
	}
    private function show_list(){
		
		$id = $this->id;
		$page = ForceIntFrom('p', 1); //当前页
		$NumPerPage = 20;   //每页显示的新闻数量
		$start = $NumPerPage * ($page-1);  //分页的每页起始位置


		
		$actfl_sql="select cat_id,p_id,name";
		$actfl=$this->db->getOne($actfl_sql . " FROM " . TABLE_PREFIX . "acat WHERE is_show = 1 and cat_id='$id'");
		
		$this->assign('title',$actfl['name']); //分配标题

		
		if($actfl['p_id']==0){
			
			$nav=$actfl;

			$acts_sql="SELECT a_id,cat_id,title ,keywords, content, created FROM " . TABLE_PREFIX . "article WHERE is_show = 1 and cat_id in (select cat_id from " . TABLE_PREFIX ."acat where p_id='$actfl[cat_id]') or cat_id='$actfl[cat_id]' ORDER BY sort DESC LIMIT $start, $NumPerPage";
			$count_sql="SELECT COUNT(a_id) AS value FROM " . TABLE_PREFIX . "article WHERE is_show = 1 and cat_id in (select cat_id from " . TABLE_PREFIX ."acat where p_id='$actfl[cat_id]') or cat_id='$actfl[cat_id]'";
		}else{
	
			$navsql="select cat_id,name from ". TABLE_PREFIX ."acat where cat_id='$actfl[p_id]'";
			
			$nav=$this->db->getOne($navsql);

			$acts_sql="SELECT a_id,cat_id,title ,keywords, content, created FROM " . TABLE_PREFIX . "article WHERE is_show = 1 and cat_id='$id' ORDER BY sort DESC LIMIT $start, $NumPerPage";
		
			$count_sql="SELECT COUNT(a_id) AS value FROM " . TABLE_PREFIX . "article WHERE is_show = 1 and cat_id='$id'";
		}
		
		
		$huodong_sql="select a_id,title,content,created ";
		$gethuodong=$this->db->getAll($huodong_sql . " FROM " . TABLE_PREFIX . "article  WHERE is_show=1 and cat_id=31 order by sort desc limit 3");
		$this->assign('huodongs',$gethuodong);
		


		$acts = $this->db->getAll($acts_sql);
		$maxrows = $this->db->getOne($count_sql);
		$totalpages = ceil($maxrows['value'] / $NumPerPage);
		
		if(!$acts){
			$this->assign('errorinfo', $this->langs['er_nonews']); //错误信息
		}
		
		
		$this->assign('navdh', $nav);
		$this->assign('actfl', $actfl);
		$this->assign('acts', $acts);
		$this->assign('start', $start);
		$this->assign('pagelist', GetPageList(URL('list'), $totalpages, $page, 6,"id",$id)); //类别分页


		$this->display('list.tpl');
	} 

}

?>