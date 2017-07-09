<?php

class register extends Member {
    
    public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 注册
	 */
	public function indexAction() {
	    if (!$this->site_config['member_register']) $this->show_message('系统未开放会员注册功能');
	    if ($this->member_info)  $this->show_message('您已经登录了，不能再次注册。',1, url('index/'));
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $data = $this->post('data');
	        unset($data['id']);
			if ($this->site_config['member_regcode'] && !$this->checkCode($this->post('code'))) $this->tp_error('验证码不正确');
			$username = trim($data['username']);
	        if (empty($username)) $this->tp_error('请填写姓名');
			if (!$this->is_realname($username)) $this->tp_error('姓名还是填中文的吧');

			$phone = trim($data['phone']);
			if (empty($phone)) $this->tp_error('手机号不能为空');
			if(!$this->is_phone($phone)) $this->tp_error('手机号格式不正确');

			$password = trim($data['password']);
    		if (empty($password)) $this->tp_error('密码不能为空');
    		if (strlen($password)<6) $this->tp_error('密码不能少于6位数');
    		if ($password != trim($data['password2'])) $this->tp_error('两次输入密码不一致');

    		$email = trim($data['email']);
	    	if (!empty($email) && !is_email($email)) $this->tp_error('邮箱格式不正确');

	    	if ($this->db->setTableName('member')->getOne('phone=?', $phone, 'id')) $this->tp_error('手机号已经存在!');
	    	#if ($this->db->setTableName('member')->getOne('email=?', $data['email'], 'id')) $this->tp_error('邮箱已经存在，请重新选择邮箱');
	    	#if ($this->db->setTableName('member')->getOne('username=?', $username, 'id')) $this->tp_error('该姓名已经存在，请重新选择');

	    	$data['phone']    = $phone;
	    	$data['username'] = $username;
	    	$data['email']    = $email;
	    	$data['regdate']  = time(); 
	    	$data['regip']    = $this->get_user_ip();
	    	$data['status']	  = $this->site_config['member_status']  ? 0 : 1;
	    	$data['modelid']  = (!isset($data['modelid']) || empty($data['modelid'])) ? $this->site_config['member_modelid'] : $data['modelid'];
	    	if (!isset($this->member_model[$data['modelid']])) $this->tp_error('会员模型不存在');
	    	$data['password'] = md5(md5($data['password']));
	    	$data['id'] = $this->db->setTableName('member')->insert($data,true);
	    	if ($data['id']) {
	    	    $this->db->setTableName($this->member_model[$data['modelid']]['tablename'])->insert($data);	    	    
	    	}else {
	         	$this->tp_error('注册失败');
	    	}
			cookie::set('member_id', $data['id']);
			cookie::set('member_code', substr(md5($this->site_config['rand_code'] . $data['id']), 5, 20));
			$this->tp_success('注册成功', url('index'));
		}
		$modelid	= (int)$this->get('modelid') ? (int)$this->get('modelid') : (int)$this->site_config['member_modelid'];
		$this->view->assign(array(
			'fields'	=> $this->get_data_fields($this->member_model[$modelid]['fields']),
		    'config' => $this->site_config,
			'site_title'  => '会员注册 - ' . $this->site_config['site_name'],
			'site_keywords'    => $this->site_config['site_keywords'], 
			'site_description' => $this->site_config['site_description'],
			'member_model' => $this->member_model,
			'member_default_modelid' => $this->site_config['member_modelid'],
		));
		$this->view->display('member/register.html');
	}

	/**
	 * 检查会员名是否符合规定
	 */
	private function is_username($username) {
		$strlen = strlen($username);
		if(!preg_match('/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/', $username)){
			return false;
		} elseif ( 20 < $strlen || $strlen < 2 ) {
			return false;
		}
		return true;
    }

    /**
     * 中文姓名
     */
    private function is_realname($realname){
    	if(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $realname)){
    		return false;
    	}
    	return true;
    }

    /**
     * 手机号
     */
    private function is_phone($phone){
    	if($phone<13000000000||$phone>18999999999){
    		return false;
    	}
    	return true;
    }
	
}