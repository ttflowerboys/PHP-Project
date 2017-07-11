<?php if(!defined('ROOT')) die('Access denied.');

class c_from2 extends SWeb{

	public function __construct(){
		parent::__construct();
		$this->action=ForceStringFrom('action');
		$this->id = ForceIntFrom('id'); // ID
	}


    public function index(){
    	$this->assign('menu', 'from'); //菜单样式
    	if($_SESSION['isjc']!=1){
    		$this->assign('msg','对不起，您无权操作！');
			$this->display('goback.tpl');exit();
    	}
		// 店铺信息
		$dp_id = $this->id;
		$dp_info = $this->db->getOne("SELECT * FROM ".TABLE_PREFIX."dp where id=$dp_id");
		$this->assign('dp_info',$dp_info);
		// 店铺描述
		$dp_desc = $this->db->getOne("SELECT dp_desc FROM ".TABLE_PREFIX."dpinfo WHERE id=$dp_id");
		$this->assign('dp_desc',$dp_desc);
		// 经纪人
		$jjr_info = $this->db->getAll("SELECT id,username,mobile,no,level,type FROM ".TABLE_PREFIX."jjr where dp_id=$dp_id");
		$this->assign('jjr_info',$jjr_info);
		$this->display('from2.tpl');
	}


	public function jjrAddDo(){
		if (!IS_POST) {
			$this->assign('msg','对不起，您无权操作！');
			$this->display('goback.tpl');exit();
		}
		if($_SESSION['isjc']!=1){
			tp_error('对不起，您无权操作！');
		}
			$dp_id     = $_POST['dp_id'];
			$username  = $_POST['username'];
			$mobile    = $_POST['mobile'];
			$no        = $_POST['no'];
			$level     = $_POST['level'];
			$descscore = $_POST['descscore'];
			$impressions = $_POST['impressions'];
			$exinfo    = $_POST['exinfo'];
			$type      = $_POST['type'];
			$score     = $_POST['score'];
			$outareaarr= $_POST['outarea'];
			$outarea_r = $_POST['outarea_r'];
			$outarea_w = $_POST['outarea_w'];
			$iswinter  = $this->iswinter;

			$jjr_details="";
	        if(is_array($outareaarr)){
	            foreach ($outareaarr as $key => $value) {
	               $a=$outareaarr[$key].":".$outarea_r[$key].":".$outarea_w[$key];
	               if($jjr_details==''){
	                    $jjr_details=$a;
	               }else{
	                  $jjr_details=$jjr_details.','.$a;
	               }  
	            }
	        }

	        $isexist=$this->db->getOne("SELECT id FROM " . TABLE_PREFIX . "dp where id='$dp_id'");
	        if(!empty($isexist)){
	        	$jjrexist=$this->db->getOne("SELECT no FROM " . TABLE_PREFIX . "jjr where no='$no' and dp_id='$dp_id'");
	        	if (empty($jjrexist)) {
		        	// 主体信息添加到 dp				
					$this->db->exe("INSERT INTO " . TABLE_PREFIX . "jjr (dp_id,username,mobile,no,level,descscore,impressions,exinfo,type,score,details,iswinter) values('$dp_id','$username','$mobile','$no','$level','$descscore','$impressions','$exinfo','$type','$score','$jjr_details','$iswinter') ");
					$jjr_id=$this->db->insert_id;
					
					if($jjr_id){		
						tp_success('恭喜，经纪人添加成功！');
					}else{
						tp_error('糟糕，经纪人添加失败！');
					}
				}else{
					tp_error('糟糕，经纪人就已存在！');
	        	}
			}else{
				tp_error('糟糕，该店铺不存在！');
			}
	


	}
	
	


}

?>