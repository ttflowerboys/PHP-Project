<?php if(!defined('ROOT')) die('Access denied.');

class c_edit extends SWeb{
	
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
	}

    public function index(){
    	$this->assign('menu', 'from');
		$action = $this->action;
		$hasid  = $this->hasid;
		$id     = $this->id;
		$hasshow= $this->hasshow;
		$show   = $this->show;
		$hasJjr = $this->hasJjr;
		if($_SESSION['isjc']!=1){
			$this->assign('msg','对不起，您无权操作！');
			$this->display('goback.tpl');exit();
		}
		// 查询
		$dp_select = $this->db->getOne("SELECT yx_catid,qy_catid FROM ".TABLE_PREFIX."dp WHERE id='$id'");
		// 获取大区
		$nav_sql = "SELECT cat_id, p_id, name "; 
		$getnav=$this->db->getAll($nav_sql . " FROM " . TABLE_PREFIX . "areas  order by cat_id asc");		
		$dq='<select name="areas" id="areas" class="input-text"><option value="0">--请选择--</option>';
		foreach($getnav as $key){
			if($key['p_id']==0){
				if($key['cat_id']==$dp_select['yx_catid']){
					$dq.='<option selected value="'.$key['cat_id'].'">'.$key['name'].'</option>';
				}else{



				$dq.='<option value="'.$key['cat_id'].'">'.$key['name'].'</option>';
				}
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
		$getrecord = $this->db->getAll("SELECT * FROM  " . TABLE_PREFIX . "dp  ORDER BY id DESC  LIMIT $start, $NumPerPage");

		$maxrows = $this->db->getOne("SELECT COUNT(id) AS value FROM " . TABLE_PREFIX . "dp ");
		$totalpages = ceil($maxrows['value'] / $NumPerPage);
		$this->assign('getarea',$getnav);
		$this->assign('getrecord', $getrecord); //分配公司新闻
		$this->assign('pagelist', GetPageList(URL('record'), $totalpages, $page, 20, 'id', $id));
		$this->assign('maxrows',$maxrows['value']);
		$this->assign('NumPerPage',$NumPerPage);
		$this->display('record.tpl');
	}

	public function showDetails(){
		$id = $this->id; //当前产品ID
		$this->assign('menu', 'from'); //菜单样式
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
		$this->display('edit.tpl');
	}

	public function showDpDetails(){
		$id = $this->id; //当前产品ID
		$this->assign('menu', 'from'); //菜单样式
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
		$this->assign('menu', 'from'); //菜单样式
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
		$this->assign('menu', 'from'); //菜单样式
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

	public function editDo(){
		if (!IS_POST) {
			$this->assign('msg','页面不存在，请返回！');
			$this->display('goback.tpl');exit();
		}
		if($_SESSION['isjc']!=1){
			tp_error('对不起，您无权操作！');
		}
			$id        = $_POST['id'];
			$areasid   = $_POST['areas']; 
			$careas    = $_POST['careas'];
			$name      = $_POST['dpname'];
			$dpno      = $_POST['dpno'];
			$address   = $_POST['address'];
			$zftime    = strtotime($_POST['zftime']);
			$zfintime  = $_POST['zfintime'];
			$zfouttime = $_POST['zfouttime'];
			$gk_num    = $_POST['gk_num'];
			$jj_num    = $_POST['jj_num'];
			$check_num = $_POST['check_num'];
			$manfen    = $_POST['manfen'];
			$womanfen  = $_POST['womanfen'];
			$storefen  = $_POST['storefen'];
			$totalfen  = $_POST['totalfen'];
			$zfuser    = $_POST['zfuser'];
			$dp_desc   = $_POST['dp_desc'];
			$outareaarr= $_POST['outarea'];
			$outarea_r = $_POST['outarea_r'];
			$outarea_w = $_POST['outarea_w'];
			//$addtime   = time();

			$isexist=$this->db->getOne("SELECT id FROM " . TABLE_PREFIX . "dp WHERE id='$id'");

			if(!empty($isexist)){	
				// 主体信息添加到 dp
				
				$updp = $this->db->exe("UPDATE " . TABLE_PREFIX . "dp SET 
				name = '$name',
				dp_no = '$dpno',
				yx_catid = '$areasid',
				qy_catid = '$careas',
				address = '$address',
				zftime = '$zftime',
				zfintime = '$zfintime',
				zfouttime = '$zfouttime',
				jj_num = '$jj_num',
				check_num = '$check_num',
				gk_num = '$gk_num',
				manfen = '$manfen',
				womanfen = '$womanfen',
				storefen = '$storefen',
				totalfen = '$totalfen',
				zfuser = '$zfuser'
				WHERE id = ".$isexist['id']);
				
				// 店铺环境
				$dp_details="";
		        if(is_array($outareaarr)){
		            foreach ($outareaarr as $key => $value) {
		               $a=$outareaarr[$key].":".$outarea_r[$key].":".$outarea_w[$key];
		               if($dp_details==''){
		                    $dp_details=$a;
		               }else{
		                  $dp_details=$dp_details.','.$a;
		               }  
		            }
		        }

                
			        $isext=$this->db->getOne("SELECT dp_id FROM " . TABLE_PREFIX . "dpinfo where dp_id=".$isexist['id']);
			        if($isext){
			        	$updpinfo = $this->db->exe("UPDATE " . TABLE_PREFIX . "dpinfo SET 
			        		dp_details = '$dp_details',
			        		dp_desc='$dp_desc'
			        		WHERE dp_id = ".$isext['dp_id']);
			        }else{
			        	tp_error('请先添加店铺环境！');
			        }

					
					tp_success('恭喜，修改成功！');
			}else{
				tp_error('糟糕，店铺不存在，请先添加店铺！');
			}
		}
  

}

?>