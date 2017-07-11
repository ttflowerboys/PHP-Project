经纪人着装：春夏装和秋冬装
秋冬装（0,春夏$_dpman、$_dpwoman;1,秋冬$_w_dpman、$_w_dpwoman）


 1. 配置( config/settings.php )
12  $_w_dpman=array();
13  $_w_dpwoman=array();
833 $_CFG['isWinter'] = "1";
 2. 网址入口文件配置(system/plugins/SWeb.class.php)
22  global $_CFG, $DB, $IS_CHINESE,$_dpinfo,$_dpwoman,$_dpman,$_w_dpman,$_w_dpwoman;
35  $this->iswinter = $this->config['isWinter']?1:0;
36  $this->assign('iswinterType',$this->iswinter);

 3. 添加经纪人（from2.tpl）
112 $zzType =  $this->iswinter?$this->w_dpman:$this->dpman;
113 foreach( $zzType as $key =>$value){
 3.2 添加经纪人函数(from2.php)
	public function jjrAddDo(){
		...
		// 72 line, add inwinter
		$this->db->exe("INSERT INTO " . TABLE_PREFIX . "jjr (dp_id,username,mobile,no,level,descscore,impressions,exinfo,type,score,details,iswinter) values('$dp_id','$username','$mobile','$no','$level','$descscore','$impressions','$exinfo','$type','$score','$jjr_details','$iswinter') ");

		...
	}
 3.3 数据库jjr表，添加字段(iswinter|tinyint|2|0)

 3. 查看经纪人 (recordJjrDetails.tpl)
122 <?php 
		$tpl_show = "";
		$wj_title = "仪容仪表";
		if($this->_tpl_vars['cur_jjr']['type']==1){
			$wj_title = "仪容仪表(女士)";
			$tpl_show = $this->_tpl_vars['cur_jjr']['iswinter']?$this->w_dpwoman:$this->dpwoman;
		}else if($this->_tpl_vars['cur_jjr']['type']==0){
			$wj_title = "仪容仪表(男士)";
			$tpl_show = $this->_tpl_vars['cur_jjr']['iswinter']?$this->w_dpman:$this->dpman;
		}
	?>
 4. 编辑经纪人 (editJjr.tpl)
30  <?php
		$tpl_show = "";
		$wj_title = "仪容仪表";
		if($this->_tpl_vars['cur_jjr']['type']==1){
			$wj_title = "仪容仪表(女士)";
			$tpl_show = $this->_tpl_vars['cur_jjr']['iswinter']?$this->w_dpwoman:$this->dpwoman;
		}else if($this->_tpl_vars['cur_jjr']['type']==0){
			$wj_title = "仪容仪表(男士)";
			$tpl_show = $this->_tpl_vars['cur_jjr']['iswinter']?$this->w_dpman:$this->dpman;
		}
	?>


6. 后台参数设置（admin/controllerss/settings.php）
76		$Radio = new SRadio;
		$Radio->Name = 'settings[isWinter]';
		$Radio->SelectedID = $this->config['isWinter'];
		$Radio->AddOption(0, '春夏装', '&nbsp;&nbsp;');
		$Radio->AddOption(1, '秋冬装', '&nbsp;&nbsp;&nbsp;&nbsp;');
		TableRow(array('<B>经纪人着装</B><BR>经纪人着装标准分春夏装和秋冬装，默认为<span class=note>春夏装</span>.', $Radio->Get()));

7. 上传文件路径配置
/static/tpl/js/common.js 131 line search ' var url'
