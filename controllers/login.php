<?php if(!defined('ROOT')) die('Access denied.');

class c_login extends SWeb{
	
	public function __construct(){
		parent::__construct();
		$this->action=ForceStringFrom('action');
	}

	/*public function __construct(){
	 
	}
*/
    public function index(){
    	$action=$this->action;
    	if($action=='login')
    	{
    		$this->check();
    	}
		
		$this->display('login.tpl');
	} 




	/**
	 * 登录验证
	 */
   private function check(){

		$username = ForceStringFrom('username');
		$password = ForceStringFrom('password');
		$usertype = ForceIntFrom('usertype');


    	if(!strlen($username) OR !strlen($password)){
			tp_error('请输入用户名和密码！');exit();
		}else{
			$password = md5($password);

			$user = $this->db->getOne("SELECT id,qy_cartid,yx_cartid,isjc,dp_id FROM " . TABLE_PREFIX . "user  WHERE username = '$username' AND password = '$password'");

			if(!$user['id']){
				tp_error('用户不存在或密码错误！');exit();
			}else{//授权成功, 执行相关操作
				$userip = GetIP();
				$timenow = time();
				$sessionid = md5(uniqid($user['userid'] . COOKIE_KEY));
				$useragent = substr(ForceString($_SERVER['HTTP_USER_AGENT']), 0, 252);

				$this->db->exe("INSERT INTO " . TABLE_PREFIX . "sessions (sessionid, userid, ipaddress, useragent, created, admin)
						  VALUES ('$sessionid', '$user[userid]', '$userip', '$useragent', '$timenow', 1) ");
				$this->db->exe("UPDATE " . TABLE_PREFIX . "admin SET lastdate = '$timenow', lastip = '$userip', loginnum = (loginnum + 1)  WHERE userid = '$user[userid]' ");

				$time = time()+3600*24*30;

				//setcookie(COOKIE_ADMIN, $sessionid, $time, '/');

				//setcookie("userid", $user['userid'], $time, '/');
				//setcookie("name", $username, $time, '/');
				//setcookie("usertype", $user['usertype'], $time, '/');
				$_SESSION["userid"]=$user['id'];
				$_SESSION["name"]=$username;
				$_SESSION["isjc"]=$user['isjc'];
				$_SESSION["qy_cartid"]=$user['qy_cartid'];
				$_SESSION["yx_cartid"]=$user['yx_cartid'];
				$_SESSION["dp_id"]=$user['dp_id'];
				//Redirect('index'); //登录验证成功后跳转到首页
				tp_success('登录成功，欢迎回来！','/index.php/index');
			}
		}

		/*echo json_encode($data);
		exit();*/
	}


}

?>