<?php if(!defined('ROOT')) die('Access denied.');

include(ROOT . 'includes/functions.global.php');

//前台模板中输出伪静态PURL
function PURL($url = ''){
	global $_CFG;

	echo SYSDIR . Iif($url, Iif(!$_CFG['siteRewrite'], 'index.php/') . $url);
}
//前台模板中输出伪静态PURL
function PURL1($url = ''){
	global $_CFG;

	return SYSDIR . Iif($url, Iif(!$_CFG['siteRewrite'], 'index.php/') . $url);
}

//立即跳转函数 redirect
function Redirect($url = ''){
	echo '<script type="text/javascript">window.location="' . URL($url) . '";</script>';
	exit();
}
// 区域类型
function areaType($id){
	global $DB;
	$id = ForceInt($id);
	if ($id) {
    	$content = $DB->getOne("SELECT * FROM " . TABLE_PREFIX . "areas WHERE cat_id = '$id'");
    	return $content['name'];
	}
}
//
function explodeInfo($v){
	return explode(':', $v);
}
// 用户类型
function PrintUserType($type){
	$usertype = array(
		'1'=>'系统管理员',
		'2'=>'调查员',
		'3'=>'客户'
	);
	echo $usertype[$type];
}

// 提交函数（成功）
function tp_success($info,$url=''){
	$data = array(
		'info' => $info,
		'status' => 1,
		'url' => $url
	);
	echo json_encode($data);
	exit();
}
// 提交函数（失败）
function tp_error($info,$url=''){
	$data = array(
		'info' => $info,
		'status' => 0,
		'url' => $url
	);
	echo json_encode($data);
	exit();
}



//输出debug信息
function Debug() {
	global $DB, $sys_starttime;

	$mtime = explode(' ', microtime());
	$sys_runtimie = number_format(($mtime[1] + $mtime[0] - $sys_starttime), 3);

	echo 'Done in '. $sys_runtimie.' seconds, '. $DB->query_nums.' queries';
}

//前台模板中输出图片的URL
function PrintImageURL($path, $filename, $size = 1){
	switch($size){
		case 1:
			$size = '_s.jpg';
			break;
		case 2:
			$size = '_m.jpg';
			break;
		case 3:
			$size = '_l.jpg';
			break;
	}

	echo SYSDIR  . "uploads/$path/$filename$size";
}

//根据调用ID号获取常态内容
function GetContent($id) {
	global $DB;
	$content = array();

	$id = ForceInt($id);
	if($id){

		if(IS_CHINESE){
			$sql = "SELECT r_id, title, content, keywords, created ";
		}else{
			$sql = "SELECT r_id, title_en AS title, content_en AS content, keywords_en AS keywords, created ";
		}

		$content = $DB->getOne($sql ." FROM " . TABLE_PREFIX . "content WHERE r_id = '$id'");

		if($content){
			$content['content'] = html($content['content']);//内容正文部分转换成html
			$content['created'] = DisplayDate($content['created']);//时间截转换日期时间
		}
	}

	return $content;
}

//分页函数
function GetPageList($FileName, $PageCount, $CurrentPage = 1, $PagesToDisplay = 10, $PN01 = '', $PNV01 = '', $PN02 = '', $PNV02 = '', $PN03 = '', $PNV03 = '', $PN04 = '', $PNV04 = '', $PN05 = '', $PNV05 = '') {

	if($PageCount < 2) return '';

	if(IS_CHINESE){
		$PreviousText =  '上一页';
		$NextText = '下一页';
	}else{
		$PreviousText =  'Prev';
		$NextText = 'Next';
	}

	$Params = '';
	$Params .= Iif($PN01 AND $PNV01, '&'.$PN01.'='.$PNV01);
	$Params .= Iif($PN02 AND $PNV02, '&'.$PN02.'='.$PNV02);
	$Params .= Iif($PN03 AND $PNV03, '&'.$PN03.'='.$PNV03);
	$Params .= Iif($PN04 AND $PNV04, '&'.$PN04.'='.$PNV04);
	$Params .= Iif($PN05 AND $PNV05, '&'.$PN05.'='.$PNV05);

	$iPagesToDisplay = $PagesToDisplay - 2;      
	if ($iPagesToDisplay <= 8) $iPagesToDisplay = 8;

	$MidPoint = ($iPagesToDisplay / 2);

	$FirstPage = $CurrentPage - $MidPoint;
	if ($FirstPage < 1) $FirstPage = 1;

	$LastPage = $FirstPage + ($iPagesToDisplay - 1);

	if ($LastPage > $PageCount) {
		$LastPage = $PageCount;
		$FirstPage = $PageCount - $iPagesToDisplay;
		if ($FirstPage < 1) $FirstPage = 1;
	}

	$Loop = 0;
	$iTmpPage = 0;

	$sReturn = '<div class="pageNav">';

	if ($CurrentPage > 1) {
		$iTmpPage = $CurrentPage - 1;
		$sReturn .= '<a href="' . $FileName . '?p=' . $iTmpPage . $Params . '" class="PagePrev" >'.$PreviousText.'</a>';
	} else {
		$sReturn .= '<span class="NoPagePrev">'.$PreviousText.'</span>';
	}

	if ($FirstPage > 2) {
		$sReturn .= '<a href="' . $FileName . '?p=1' . $Params . '">1</a><span>...</span>';
	} elseif ($FirstPage == 2) {
		$sReturn .= '<a href="' . $FileName . '?p=1' . $Params . '">1</a>';
	}

	$Loop = 0;

	for ($Loop = 1; $Loop <= $PageCount; $Loop++) {
		if (($Loop >= $FirstPage) && ($Loop <= $LastPage)) {
			if ($Loop == $CurrentPage) {
				$sReturn .= '<span class="current">'.$Loop.'</span>';
			} else {
				$sReturn .= '<a href="' .  $FileName . '?p=' . $Loop . $Params . '">'.$Loop.'</a>';
			}
		}
	}

	if ($CurrentPage < ($PageCount - $MidPoint) && $PageCount > $PagesToDisplay - 1) {
		$sReturn .= '<span>...</span><a href="' . $FileName . '?p=' . $PageCount . $Params . '">'.$PageCount.'</a>';
	} else if ($CurrentPage == ($PageCount - $MidPoint) && ($PageCount > $PagesToDisplay)) {
		$sReturn .= '<a href="' . $FileName . '?p=' . $PageCount . $Params . '">'.$PageCount.'</a>';
	}

	if ($CurrentPage != $PageCount) {
		$iTmpPage = $CurrentPage + 1;
		$sReturn .= '<a href="' . $FileName . '?p=' . $iTmpPage . $Params . '" class="PageNext">'.$NextText.'</a>';
	} else {
		$sReturn .= '<span class="NoPageNext">'.$NextText.'</span>';
	}

	$sReturn .= '</div>';

	return $sReturn;
}

//输出系统提示信息, $type值0表示错误信息, 1表示成功信息
function PrintInfo($infos, $type = 0){
	if(empty($infos)) return; //无信息时什么也不输出, 仅返回;

	if(IS_CHINESE){
		$title =  '提示信息';
	}else{
		$title =  'Information';
	}

	if(is_array($infos)){
		for($i = 0; $i < count($infos); $i++)
			$info_str .= ($i + 1) . ') ' . $infos[$i] . '<br />';
	}else {
		$info_str = $infos . '<br />';
	}

	if($type){
		echo '<div id="system_info"><div class="s_lborder"><div class="s_rborder"><div class="s_bborder"><div class="s_blcorner"><div class="s_brcorner"><div class="s_tborder"><div class="s_tlcorner"><div class="s_trcorner"><B><U>' . $title . ':</U></B><BR><BR>' . $info_str . '</div></div></div></div></div></div></div></div></div>';
	}else{
		echo '<div id="system_info"><div class="e_lborder"><div class="e_rborder"><div class="e_bborder"><div class="e_blcorner"><div class="e_brcorner"><div class="e_tborder"><div class="e_tlcorner"><div class="e_trcorner"><B><U>' . $title . ':</U></B><BR><BR>' . $info_str . '</div></div></div></div></div></div></div></div></div>';
	}
}

//增加点击次数
function add_clicks($id, $type = 'product'){
	global $DB;

	if(!ForceInt($id)) return; //非法id返回

	$cookiename = COOKIE_KEY . $type; //根据类型确定cookie名称

	$ids = ForceCookieFrom($cookiename);
	$arrIds = explode(',', $ids);

	if(!in_array($id, $arrIds)){
		switch($type){
			case 'product': //产品
				$DB->exe("UPDATE " . TABLE_PREFIX . "product SET clicks = (clicks + 1)  WHERE pro_id='$id'");
				break;
			case 'news': //新闻
				$DB->exe("UPDATE " . TABLE_PREFIX . "news SET clicks = (clicks + 1)  WHERE n_id='$id'");
				break;
			case 'article': //文章
				$DB->exe("UPDATE " . TABLE_PREFIX . "article SET clicks = (clicks + 1)  WHERE a_id='$id'");
				break;

		}

		//将新id保存cookie, 24小时过期
		$ids .= Iif($ids, ',') . $id; 
		setcookie($cookiename, $ids, time() + 24*3600, "/");
	}
}


function checku($userid)
{
	global $DB;
	$userinfo=$DB->getOne("select * from " . TABLE_PREFIX . "user where id=$userid");

	if ($userinfo) {
	
		$data=array(

		'isjc'=>$userinfo['isjc'],
		'dpid'=>$userinfo['dp_id'],
		'qy_catid'=>$userinfo['qy_catid'],
		'yx_catid'=>$userinfo['yx_catid'],
		);	

		return $data;
	
	}

	
}



?>