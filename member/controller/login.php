<?php

class login extends Member {
    
    public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 登录
	 */
	public function indexAction() {
	    if ($this->member_info)  $this->show_message('您已经登录了。',1, url('index/'));
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $data   = $this->post('data');
			if ($this->site_config['member_logincode'] && !$this->checkCode($this->post('code'))) $this->tp_error('验证码不正确');
			$phone = trim($data['phone']);
			$password = trim($data['password']);
			if (empty($phone) || empty($password)) $this->tp_error('手机号或密码不能为空');
			$member = $this->db->setTableName('member')->getOne('phone=?', $phone);
			$gobackurl= $data['gobackurl'] ? urldecode($data['gobackurl']) : url('index');
			if (empty($member)) $this->tp_error('会员名不存在');
			if ($member['password'] != md5(md5($password))) $this->tp_error('密码错误');
			cookie::set('member_id', $member['id']);
			cookie::set('member_code', substr(md5($this->site_config['rand_code'] . $member['id']), 5, 20));
			$this->tp_success('登录成功', $gobackurl);
		}
		$gobackurl = $this->get('gobackurl') ? $this->get('gobackurl') : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('index'));
	    $this->view->assign(array(
		    'config' => $this->site_config,
			'site_title' => '会员登录 - ' . $this->site_config['site_name'],
			'site_keywords'    => $this->site_config['site_keywords'], 
			'site_description' => $this->site_config['site_description'],
			'gobackurl'    => urlencode($gobackurl),
		));
		$this->view->display('member/login.html');
	}
	/**
	 * QQ登录
	 */
	public function qqloginAction() {
	    if (!$this->site_config['qq_login']) $this->show_message('系统未开放QQ登录功能');
		$qc = xiaocms::load_class('QC');
		$qc->qq_login();
	}

	/**
	 * 回调地址
	 */
	public function callbackAction() {
		$qc = new QC();
		$acs = $qc->qq_callback();
		$oid = $qc->get_openid();
		$qc = new QC($acs,$oid);
		$uinfo = $qc->get_user_info();
		$u = $this->db->setTableName('member_connect')->getOne('openid=?', $oid);
		if (empty($u)){
			$data = array();
			$data['avatar'] = $uinfo['figureurl'];
			$data['username'] = $uinfo['nickname'];
			$data['username'] = $uinfo['nickname'];
			$data['password'] = rand(111111, 999979799);
			$data['email'] = time().'@xiaocms.com';
	    	$data['regdate']  = time(); 
	    	$data['regip']    = $this->get_user_ip();
	    	$data['status']	  = $this->site_config['member_status']  ? 0 : 1;
	    	$data['modelid']  = (!isset($data['modelid']) || empty($data['modelid'])) ? $this->site_config['member_modelid'] : $data['modelid'];
	    	if (!isset($this->member_model[$data['modelid']])) $this->show_message('会员模型不存在',2,1);
	    	$data['id'] = $this->db->setTableName('member')->insert($data,true);
	    	if ($data['id']) {
	    	    $this->db->setTableName($this->member_model[$data['modelid']]['tablename'])->insert($data);
	    	    $u['uid'] = $data['id'];
	    	    $u['openid'] = $oid;
	    	    $this->db->setTableName('member_connect')->insert($u);
	    	}else {
	         	$this->show_message('注册失败',2,1);
	    	}
			cookie::set('member_id', $data['id']);
			cookie::set('member_code', substr(md5($this->site_config['rand_code'] . $data['id']), 5, 20));
			$this->show_message('注册成功',1, url('index'));

		} else {
			$data = $this->db->setTableName('member')->getOne('id=?', $u['uid']);
			cookie::set('member_id', $data['id']);
			cookie::set('member_code', substr(md5($this->site_config['rand_code'] . $data['id']), 5, 20));
			$this->show_message('注册成功',1, url('index'));
		}
	}
	/**
	 * 退出登录
	 */
	public function outAction() {
		if (session::get('member_id'))           session::delete('member_id');
		if (cookie::get('member_id'))            cookie::delete('member_id');
		if (cookie::get('member_code'))          cookie::delete('member_code');
		$this->show_message('退出成功', 1, '/');
	}
	
}