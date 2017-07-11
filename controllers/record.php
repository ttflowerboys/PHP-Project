<?php if(!defined('ROOT')) die('Access denied.');

class c_record extends SWeb{
	
	public function __construct(){
		parent::__construct();
		$this->area_id  = ForceIntFrom('area_id');
		$this->action   = ForceStringFrom('action');
		$this->carea_id = ForceIntFrom('careas');
		$this->dp_no    = ForceIntFrom('dp_no');
		$this->id       = ForceIntFrom('id');
		$this->hasid    = ForceStringFrom('id');
		$this->show     = ForceIntFrom('show');
		$this->hasshow  = ForceStringFrom('show');
		$this->jjr      = ForceIntFrom('jjr');
		$this->hasJjr   = ForceStringFrom('jjr');
		$this->starttime= ForceStringFrom('starttime');
	}

    public function index(){
    	$this->assign('menu', 'record');
		$action = $this->action;
		$hasid  = $this->hasid;
		$hasshow= $this->hasshow;
		$show   = $this->show;
		$hasJjr = $this->hasJjr;


		// 获取大区
		$nav_sql = "SELECT cat_id, p_id, name "; 
		$getnav=$this->db->getAll($nav_sql . " FROM " . TABLE_PREFIX . "areas  order by cat_id asc");		
		$dq='<select name="areas" id="areas" class="input-text"><option value="0">--请选择--</option>';		
		foreach($getnav as $key){
			if($key['p_id']==0){			
				$dq.='<option value="'.$key['cat_id'].'">'.$key['name'].'</option>';
			}
		}
		$dq.='</select>';		
		$this->assign('navs',$dq);

		if($action=="getareas"){
			$area_id=$this->area_id;
			if($area_id > 0){
				$getareas=$this->db->getAll("SELECT cat_id, p_id, name   FROM " . TABLE_PREFIX . "areas where p_id=$area_id  order by cat_id asc");
				$areas='<option value="0">--请选择--</option>';
				foreach($getareas as $key){
					$areas.='<option value="'.$key['cat_id'].'">'.$key['name'].'</option>';
				}				
				die($areas);
			}
			
		}else if($action=="getcareas"){
			$carea_id=$this->carea_id;
			
			if(intval($carea_id)>0){
				
				$getdp=$this->db->getAll("select * from " . TABLE_PREFIX . "dp where qy_catid=$carea_id");
				$dps='<option value="0">--请选择--</option>';
			
				foreach($getdp as $key){
					$dps.='<option value="'.$key['id'].'">'.$key['name'].'</option>';
				}
				die($dps);				
			}
				
		}else if($action=="getlist"){
			
			$this->showlist();
		}





		if($hasid){
			if (!$hasshow) {
				$this->showDetails();
			}else{
				switch ($show) {
				case '1':
					$this->showDpDetails();
					break;
				case '2':
					if ($hasJjr) {
						$this->showJjrDetails();
					}else{
						$this->showJjrList();
					}
					break;			
				default:
			   		$url=URL('index');
		    		Header("Location: $url"); exit;
					break;
				}

				
				
			}
		}else{
			$this->showAllList();
		}
		
	
	}
	
	public function showAllList(){
		// 获取record
		$page = ForceIntFrom('p', 1); //当前页
		$NumPerPage = 20;   //每页显示的产品数量
		$start = $NumPerPage * ($page-1);  //分页的每页起始位置

		$careas     = $_GET['careas'];
		$dpno       = $_GET['dpno'];
		$dpname     = $_GET['dpname'];
		$percent1   = $_GET['percent1'];
		$percent2   = $_GET['percent2'];
		$starttime  = $_GET['starttime'];
		$endtime    = $_GET['endtime'];

		
		
		$where='where 1=1';
		if($starttime){
			$where.=" and zftime>".(strtotime($starttime)-(24*3600));
		}
        if($endtime){
        	$where.=" and zftime<".(strtotime($endtime)+ (24 * 3600));
        }
        if ($percent1) {
        	$where.=" and totalfen>".$percent1;
        }
        if ($percent2) {
        	$where.=" and totalfen<".$percent2;
        }

        if ($dpno) {
        	$where.=" and dp_no LIKE '%".$dpno."%'";
        }
        if ($dpname) {
        	$where.=" and name LIKE '%".$dpname."%'";
        }
        
		if($_SESSION['dp_id']>0)
		{
			$where.=" and id=".$_SESSION['dp_id'];
		}else if($_SESSION['yx_cartid']>0)
		{
			$where.=" and qy_catid=".$_SESSION['yx_cartid'];
		}else if($_SESSION['qy_cartid']>0)
		{
			$where.=" and yx_catid=".$_SESSION['qy_cartid'];
		}


		$getrecord = $this->db->getAll("SELECT * FROM  " . TABLE_PREFIX . "dp ".$where." ORDER BY id DESC  LIMIT $start, $NumPerPage");

		$maxrows = $this->db->getOne("SELECT COUNT(id) AS value FROM " . TABLE_PREFIX . "dp ".$where);
		$totalpages = ceil($maxrows['value'] / $NumPerPage);
		$this->assign('getarea',$getnav);
		$this->assign('getrecord', $getrecord); //分配公司新闻
		$this->assign('pagelist', GetPageList(URL('record'), $totalpages, $page, 20,'starttime',$starttime,'endtime',$endtime));
		$this->assign('maxrows',$maxrows['value']);
		$this->assign('NumPerPage',$NumPerPage);
		$searchArr = array(
			'dpno'=>$dpno,
			'dpname'=>$dpname,
			'percent1'=>$percent1,
			'percent2'=>$percent2,
			'starttime'=>$starttime,
			'endtime'=>$endtime
		);
		$this->assign('searchArr',$searchArr);


		// 10月
		$wherem='where 1=1';
		if($_SESSION['dp_id']>0)
		{
			$wherem.=" and id=".$_SESSION['dp_id'];
		}else if($_SESSION['yx_cartid']>0)
		{
			$wherem.=" and qy_catid=".$_SESSION['yx_cartid'];
		}else if($_SESSION['qy_cartid']>0)
		{
			$wherem.=" and yx_catid=".$_SESSION['qy_cartid'];
		}
		
   		$where11.=$wherem;
		$where11.=" and zftime>".(strtotime('2016-11-01')-(24*3600));
        $where11.=" and zftime<".(strtotime('2016-11-20')+ (24 * 3600));

		$maxrows11 = $this->db->getOne("SELECT COUNT(id) AS value FROM " . TABLE_PREFIX . "dp ".$where11);
		$this->assign('maxrows11',$maxrows11['value']);

		$where12.=$wherem;
		$where12.=" and zftime>".(strtotime('2016-11-21')-(24*3600));
        $where12.=" and zftime<".(strtotime('2016-12-31')+ (24 * 3600));

		$maxrows12 = $this->db->getOne("SELECT COUNT(id) AS value FROM " . TABLE_PREFIX . "dp ".$where12);
		$this->assign('maxrows12',$maxrows12['value']);
         

		$this->display('record.tpl');

	}

	public function showDetails(){
		$id = $this->id; //当前产品ID
		$this->assign('menu', 'record'); //菜单样式
		// 店铺总体信息
		$record = $this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "dp WHERE id = '$id'");
		if (empty($record)) {
			if (empty($getrecord)) {
				//echo "<script>alert('页面不存在，请返回！');</script>";exit();
				echo "页面不存在，请返回！";exit();
				//$url=URL('index');
				//Header("Location: $url"); exit;
			}
		}
		// 店铺环境
		$dp_details = $this->db->getOne("SELECT * FROM ".TABLE_PREFIX."dpinfo WHERE dp_id = '$id'");


		$dp_detailsArr = explode(',', $dp_details['dp_details']);
		$dp_outarr = explode(',', string);
		
		$this->assign('record', $record);
		$this->assign('dpinfoArr',$dp_detailsArr);
		$this->assign('dpinfoDesc',$dp_details['dp_desc']);
		$this->display('recordDetails.tpl');
	}

	public function showDpDetails(){
		$id = $this->id; //当前产品ID
		$this->assign('menu', 'record'); //菜单样式
		// 店铺总体信息
		$record = $this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "dp WHERE id = '$id'");
		// 店铺环境
		$dp_details = $this->db->getOne("SELECT * FROM ".TABLE_PREFIX."dpinfo WHERE dp_id = '$id'");
		$dp_detailsArr = explode(',', $dp_details['dp_details']);
		$dp_outarr = explode(',', string);
		
		$this->assign('record', $record);
		$this->assign('dpinfoArr',$dp_detailsArr);
		$this->assign('dpinfoDesc',$dp_details['dp_desc']);
		$this->display('recordDpDetails.tpl');
	}

	public function showJjrList(){
		$id = $this->id; //当前产品ID
		$jjr = $this->jjr; //当前产品ID
		$this->assign('menu', 'record'); //菜单样式
		// 店铺总体信息
		$record = $this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "dp WHERE id = '$id'");
		// 店铺环境
		$jjr_info = $this->db->getAll("SELECT id,username,mobile,no,level,type FROM ".TABLE_PREFIX."jjr where dp_id=$id");
		$this->assign('jjr_info',$jjr_info);
		// 当前经纪人信息
		$this->assign('record', $record);
		$this->display('recordJjrList.tpl');
	}

	public function showJjrDetails(){
		$id = $this->id; //当前产品ID
		$jjr = $this->jjr; //当前产品ID
		$this->assign('menu', 'record'); //菜单样式
		// 店铺总体信息
		$record = $this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "dp WHERE id = '$id'");
		// 店铺环境
		$jjr_info = $this->db->getAll("SELECT id,username,mobile,no,level,type FROM ".TABLE_PREFIX."jjr where dp_id=$id");
		$this->assign('jjr_info',$jjr_info);
		// 当前经纪人信息
		$cur_jjr = $this->db->getOne("SELECT * FROM ".TABLE_PREFIX."jjr WHERE id='$jjr' and dp_id='$id'");
		$this->assign('cur_jjr',$cur_jjr);
		$cur_jjrArr = explode(',', $cur_jjr['details']);
		$this->assign('record', $record);
		$this->assign('jjrinfoArr',$cur_jjrArr);
		$this->display('recordJjrDetails.tpl');
	}
	
	public function showlist()
	{
		$area_id = $this->area_id;
		$carea_id = $this->carea_id;
	
		$page = ForceIntFrom('p', 1); //当前页
		
		$dpno=ForceStringFrom('dpno');
		$starttime=ForceStringFrom('starttime');
		$endtime=ForceStringFrom('endtime');
		
		$percent1=ForceStringFrom('percent1');
		$percent2=ForceStringFrom('percent2');
		
		
		
		$NumPerPage = 20;   //每页显示的新闻数量
		$start = $NumPerPage * ($page-1);  //分页的每页起始位置
		
		$wheresql='1=1 ';
		if($area_id>0){
			
			$wheresql.='and yx_catid='.$area_id;
		}else if($carea_id){
			$wheresql.='and qy_catid='.$carea_id;
		}else if($dpno!=''){
			$wheresql.="and dp_no='$dpno'";
		}else if($starttime!='' && $endtime!=''){
			$wheresql.="and checktime>='$starttime' and checktime<='$endtime'";
		}else if($percent1!='' && $percent2!='')
		{
			$wheresql.="and percent>='$percent1' and percent<='$percent2'";
		}
		
		
		$listsql="select * from " . TABLE_PREFIX . "dp where ".$wheresql." order by id desc LIMIT $start, $NumPerPage";
		$countsql="select count(id) as value from " . TABLE_PREFIX . "dp where ".$wheresql."";
		
		
		
		$getlist = $this->db->getAll($listsql);
		//$maxrows = $this->db->getOne($countsql);
		//$totalpages = ceil($maxrows['value'] / $NumPerPage);
		$listhtml='';
		foreach($getlist as $key =>$value)
		{
			
			$listhtml.='<tr><td>'.DisplayDate($value['addtime']).'</td><td>'.$value['dp_no'].'-'.$value['name'].'</td><td>'.$value['percent'].'%</td><td><a href="">查看详情</a></td></tr>';

		}
		die($listhtml);
		
		
				
	}
  

}

?>