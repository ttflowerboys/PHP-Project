<?php if(!defined('ROOT')) die('Access denied.');

class c_jjr extends SWeb{
	
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
	}


    public function index(){
    	if($_SESSION['isjc']!=1){
			$this->assign('msg','对不起，您无权操作！');
			$this->display('goback.tpl');exit();
		}
    	$this->assign('menu', 'from');
    	$hasid  = $this->hasid;
		if($hasid){
			$this->editJjr();
		}else{
			$url=URL('index');
			Header("Location: $url");exit();
		}

		
	}


	public function editJjr(){
		$id = $this->id; //当前店铺ID
		$this->assign('menu', 'from'); //菜单样式
		if($_SESSION['isjc']!=1){
			$this->assign('msg','对不起，您无权操作！');
    		$this->display('goback.tpl');exit();
		}
		// 当前经纪人信息
		$cur_jjr = $this->db->getOne("SELECT * FROM ".TABLE_PREFIX."jjr WHERE id='$id'");
		$this->assign('cur_jjr',$cur_jjr);
		$cur_jjrArr = explode(',', $cur_jjr['details']);
		//$this->assign('record', $record);
		$this->assign('jjrinfoArr',$cur_jjrArr);
		$this->display('editJjr.tpl');
	}


	public function update(){
		if (!IS_POST) {
			$this->assign('msg','糟糕，您访问的页面不存在！');
    		$this->display('goback.tpl');exit();
		}
		if($_SESSION['isjc']!=1){
			tp_error('对不起，您无权操作！');
		}
		$id = $_POST['id'];
		$username = $_POST['username'];
		$mobile = $_POST['mobile'];
		$no = $_POST['no'];
		$level = $_POST['level'];
		$descscore = $_POST['descscore'];
		$impressions = $_POST['impressions'];
		$exinfo = $_POST['exinfo'];
		$type = $_POST['type'];
		$score = $_POST['score'];
		$outareaarr=$_POST['outarea'];
		$outarea_r=$_POST['outarea_r'];
		$outarea_w=$_POST['outarea_w'];

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


    	$jjrexist=$this->db->getOne("SELECT id FROM " . TABLE_PREFIX . "jjr where id='$id'");
    	if ($jjrexist) {
        	
    		$upjjr = $this->db->exe("UPDATE " . TABLE_PREFIX . "jjr SET 
				username ='$username',
				mobile ='$mobile',
				no ='$no',
				level ='$level',
				descscore ='$descscore',
				impressions ='$impressions',
				exinfo ='$exinfo',
				type ='$type',
				score ='$score',
				details ='$jjr_details'
				WHERE id = '$id'");
			
			if($upjjr){		
				tp_success('恭喜，经纪人修改成功！');
			}else{
				tp_error('额，您好像并没有修改什么～～');
			}
		}else{
			tp_error('糟糕，您编辑的经纪人不存在！');
    	}


	}

	
	

  

}

?>