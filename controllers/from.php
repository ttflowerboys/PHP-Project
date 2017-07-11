<?php if(!defined('ROOT')) die('Access denied.');

class c_from extends SWeb{

	public function __construct(){
		parent::__construct();
		$this->area_id = ForceIntFrom('area_id'); //当前新闻ID
		$this->yx_id = ForceIntFrom('yx_id'); 
		$this->action=ForceStringFrom('action');
	}


    public function index(){
    	$this->assign('menu', 'from'); //菜单样式

		$userqx=checku($_SESSION['userid']);

		

		
		$action=$this->action;
		if($action=="getareas"){
			$area_id=$this->area_id;
			if($area_id > 0)
			{
				$getareas=$this->db->getAll("SELECT cat_id, p_id, name   FROM " . TABLE_PREFIX . "areas where p_id=$area_id  order by cat_id asc");
				$areas='<option value="0">--请选择--</option>';
				foreach($getareas as $key){
					$areas.='<option value="'.$key['cat_id'].'">'.$key['name'].'</option>';
				}
				die($areas);

			}
			
		}else if($action=='getdp')
		{

			$yx_id=$this->yx_id;
			if($yx_id > 0)
			{
				$getareas=$this->db->getAll("SELECT id, name   FROM " . TABLE_PREFIX . "dp where qy_catid=$yx_id  order by id asc");
				$dps='<option value="0">--请选择--</option>';
				foreach($getareas as $key){
					$dps.='<option value="'.$key['id'].'">'.$key['name'].'</option>';
				}
				die($dps);

			}

		}else if($action=="updpinfo"){
			if($_SESSION['isjc']==1){
			
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
				$addtime   = time();

				/*$isexist=$this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "dp WHERE dp_no='$dpno'");
				if(empty($isexist)){*/	
					// 主体信息添加到 dp
				
					$this->db->exe("INSERT INTO " . TABLE_PREFIX . "dp (name,dp_no,yx_catid,qy_catid,address,zftime,zfintime,zfouttime,jj_num,check_num,gk_num,manfen,womanfen,storefen,totalfen,zfuser,addtime) values('$name','$dpno','$areasid','$careas','$address','$zftime','$zfintime','$zfouttime','$jj_num','$check_num','$gk_num','$manfen','$womanfen','$storefen','$totalfen','$zfuser','$addtime') ");

					$dpid=$this->db->insert_id;
					if($dpid){
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

				        $isext=$this->db->getOne("SELECT dp_id FROM " . TABLE_PREFIX . "dpinfo where dp_id=$dpid");

				        if(empty($isext)){
				        	$this->db->exe("INSERT INTO " . TABLE_PREFIX . "dpinfo (dp_id,dp_details,dp_desc) values($dpid,'$dp_details','$dp_desc') ");

							$dpid=$this->db->insert_id();
							tp_success('恭喜，添加成功！',PURL1('from2?id='.$dpid));
							}
						}else{
							tp_error('糟糕，出错了！');
						}
				/*}else{
					tp_error('店铺已存在，不能重复添加！');
				}*/
			}else{
				tp_error('对不起，您无权操作！');
			}	
		}
		
		
		
		// 
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
		
		$this->display('from.tpl');


	} 
	
	


}

?>