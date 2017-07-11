<?php if(!defined('ROOT')) die('Access denied.');

class c_user extends SWeb{



    public function index(){
		$this->display('user.tpl');
	} 


	public function changepwd(){
		$this->display('changepwd.tpl');
	}
	// 修改密码
	public function changepwdDo(){
		$username = ForceStringFrom('username');
		$oldpassword = ForceStringFrom('oldpassword');
		$password = ForceStringFrom('password');
		$cpassword = ForceStringFrom('cpassword');
		if (empty($oldpassword)) {tp_error('原密码不能为空');}
		if (empty($password)) {tp_error('新密码不能为空');}
		if (empty($cpassword)) {tp_error('确认密码不能为空');}
		
		$rs = $this->db->getOne("SELECT id,username,password FROM " . TABLE_PREFIX . "user WHERE username = '$username' AND password='".md5($oldpassword)."'");
			
		if (!$rs) { tp_error('原密码输入不正确'); }

		if ($password == $cpassword) {
			$uprs = $this->db->exe("UPDATE " . TABLE_PREFIX . "user SET password  = '".md5($password)."' WHERE id = '".$rs['id']."'");
			tp_success('恭喜，密码修改成功！');
		}else{
			tp_error('确认密码不一致！');
		}
			
	}


	/**
	 * public 退出登录函数logout
	 */
    public function logout(){
        session_destroy();
		tp_success('恭喜，退出成功！','/index.php/login');exit();
	} 
	
	


}

?>