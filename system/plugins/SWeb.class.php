<?php if(!defined('ROOT')) die('Access denied.');

//前台基础类继承模板类
class SWeb extends STpl{
	/**
	 * 前台用户
	 * @var array
	 */
	protected $user;
	public $title;
	public $description;
	public $keywords;
	public $pcategories = array(); //产品分类数组
	public $pcat_ids = array(); //产品分类cat_id - 父p_id数组
	public $pcats_ok = array(); //有效(未隐藏)的产品分类cat_id - 父p_id数组
	public $langs = array(); //语言数组成员, 在子类中调用

	public function __construct(){

		

		global $_CFG, $DB, $IS_CHINESE,$_dpinfo,$_dpwoman,$_dpman,$_w_dpman,$_w_dpwoman;

		include(ROOT . 'includes/functions.common.php'); //加载函数库(包括公共函数库)
		
		$this->config = & $_CFG;  //引用全局配置
		$this->dpinfo = & $_dpinfo;  //引用全局配置
		$this->dpwoman = & $_dpwoman;  //引用全局配置
		$this->dpman = & $_dpman;  //引用全局配置
		$this->w_dpwoman = & $_w_dpwoman;  //引用全局配置
		$this->w_dpman = & $_w_dpman;  //引用全局配置
		$this->db = & $DB;  //引用全局数据库连接实例
		
		//着装标准
		$this->iswinter = $this->config['isWinter']?1:0;
		$this->assign('iswinterType',$this->iswinter);

		//$this->langs = require(ROOT . 'public/languages/Chinese.php'); //将语言数组赋值给类成员
		$this->title = $this->config['siteTitle'];
		$this->description = $this->config['siteKeywords'];
		$sitename = $this->config['siteCopyright'];

		$c_sql = "SELECT cat_id, p_id, is_show, show_sub, name, keywords, counts ";
	
	
		

		$this->keywords = $this->description;

		$this->tpl_compile_dir = T_CACHEPATH;  //定义STpl模板缓存路径
		$this->tpl_template_dir = T_PATH;  //定义STpl模板路径
		$this->tpl_check = $this->config['siteTemplateCheck'];  //定义STpl模板是否检测文件更新
		
		//常用变量模板赋值
		
		$this->assign('IS_CHINESE', $IS_CHINESE); //将语言数组分配给模板
		$this->assign('baseurl',  BASEURL); //网址URL
		$this->assign('public',  SYSDIR . 'public/'); //公共文件URL
		$this->assign('t_url',  T_URL); //当前模板URL
		$this->assign('title',  $this->title); //默认网站标题名称
		$this->assign('description',  $this->description);
		$this->assign('keywords',  $this->keywords);
		$this->assign('sitename',  $sitename); //版权名称
		$this->assign('sitebeian',  $this->config['siteBeian']); //备案信息
		$this->assign('username',$_SESSION['name']);        // 用户名
		$this->assign('userid',$_SESSION['userid']);        // 用户名
		$this->assign('isjc',$_SESSION['isjc']);        // 用户名
		$this->assign('qy_cartid',$_SESSION['qy_cartid']);        // 用户名
		$this->assign('yx_cartid',$_SESSION['yx_cartid']);        // 用户名
		$this->assign('dp_id',$_SESSION['dp_id']);        // 用户名


		//判断网站是否关闭
		if(!$this->config['siteActived']){
			$this->assign('errorinfo', $this->config['siteOffTitle'] . '<br>' . $this->config['siteOffTitleEn']); //错误信息
			$this->display('offline.tpl');

			exit();
		}

		



	}



	/**
	 * protected 前台授权函数 auth
	 */
	protected function auth(){}

	/**
	 * protected 操作权限验证函数 CheckAccess 无输出
	 */
	protected function CheckAccess($action = '') {}

	/**
	 * protected 操作授权验证输出并输出错误信息 CheckAction
	 */
	protected function CheckAction($action = '') {}

	/**
	 * 析构函数
	 */
	public function __destruct(){}

}

?>