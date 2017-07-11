<?php if(!defined('ROOT')) die('Access denied.');

class c_user extends SAdmin{

	public function __construct($path){
		parent::__construct($path);

	}



	//保存
	public function save(){
		$userid          = ForceIntFrom('userid');
		$username        = ForceStringFrom('username');
		$password        = ForceStringFrom('password');
		$passwordconfirm = ForceStringFrom('passwordconfirm');
		$activated       = ForceIntFrom('activated');
		$isjc            = $_POST['isjc'];
		$qy              = $_POST['qy'];
		$yx              = $_POST['yx'];
		$dpid            = $_POST['dpid'];
		$note            = $_POST['note'];
		


		//$usertype        = ForceIntFrom('usertype');
		

		$deleteuser       = ForceIntFrom('deleteuser');
		$deleteuserpublish       = ForceIntFrom('deleteuserpublish');

		if($deleteuserpublish){

			//管理员用户不需要此功能
		}

		if($deleteuser){//删除用户
			/*if($userid != $this->admin->data['id']){*/
				$this->db->exe("DELETE FROM " . TABLE_PREFIX . "user WHERE id = '$userid' ");

				//CMS需要时, 删除好友、头像等
			/*}*/

			Success('user');
		}

		if(strlen($username) == 0){
			$errors[] = '请输入用户名!';
		}elseif($this->db->getOne("SELECT id FROM " . TABLE_PREFIX . "user WHERE username = '$username'  AND id != '$userid'")){
			$errors[] = '用户名已存在!';
		}

		if($userid){
			/*if(strlen($password) OR strlen($passwordconfirm)){
				if(strcmp($password, $passwordconfirm)){
					$errors[] = '两次输入的密码不相同!';
				}
			}*/
		}else{
			if(strlen($password) == 0){
				$errors[] = '请输入密码!';
			}/*elseif($password != $passwordconfirm){
				$errors[] = '两次输入的密码不相同!';
			}*/
		}

		if(isset($errors)){
			Error($errors, Iif($userid, '编辑用户错误', '添加用户错误'));
		}else{
			if($userid){
		
				$this->db->exe("UPDATE " . TABLE_PREFIX . "user SET username    = '$username', 
				".Iif($password, ",password = '" . md5($password) . "'")."
				WHERE id      = '$userid'");

			}else{
				$this->db->exe("INSERT INTO " . TABLE_PREFIX . "user (username, password, addtime, lastip,qy_cartid,yx_cartid,dp_id,isjc,note) VALUES ('$username', '".md5($password)."',  '".time()."', '".GetIP()."', '$qy','$yx','$dpid','$isjc','$note')");

			}

			Success('user');
		}
	}

	//批量更新用户
	public function updateusers(){
		if(IsPost('updateusers')){
			// $userids   = $_POST['updateuserids'];
			// for($i = 0; $i < count($userids); $i++){
				// if($userids[$i] != $this->admin->data['userid']){
					// $this->db->exe("UPDATE " . TABLE_PREFIX . "admin SET activated = '".ForceInt($activateds[$i])."' WHERE userid = '".ForceInt($userids[$i])."'");
				// }
			// }

		}else{
			$deleteuserids = $_POST['deleteuserids'];
			for($i = 0; $i < count($deleteuserids); $i++){
				$userid = ForceInt($deleteuserids[$i]);
					$this->db->exe("DELETE FROM " . TABLE_PREFIX . "user WHERE id = '$userid'");
			}
		}

		Success('user');
	}

	//编辑调用add
	public function edit(){
		$this->add();
	}

	//添加页面
	public function add(){
		$userid = ForceIntFrom('id');

		if($userid){
			SubMenu('管理用户', array(array('添加用户', 'user/add'),array('编辑用户', 'user/edit?userid='.$userid, 1),array('用户列表', 'user')));
			
			$user = $this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "user WHERE id = '$userid'");
		}else{
			SubMenu('添加用户', array(array('添加用户', 'user/add', 1),array('用户列表', 'user')));

			$user = array('userid' => 0, 'groupid' => 2, 'activated' => 1);
		}

		$need_info = '&nbsp;&nbsp;<font class=red>* 必填项</font>';
		$pass_info = Iif($userid, '&nbsp;&nbsp;<font class=grey>不修改请留空</font>', $need_info);


		$clist=$this->db->getAll("select * from " . TABLE_PREFIX . "areas order by cat_id asc");
		$qyhtml='<select name="qy" id="qy"><option value="0">请选择</option>';
		foreach ($clist as $key => $value) {
			if($value['p_id']==0)
			{
			$qyhtml.='<option value="'.$value[cat_id].'">'.$value['name'].'</option>';
			}
			
		}
		$qyhtml.='</select>';

		echo '<form method="post" action="'.BURL('user/save').'">
		<input type="hidden" name="id" value="' . $user['id'] . '" />';

		if($userid){
			TableHeader('编辑用户信息: <span class=note>' . $user['username'] . '</span>');
		}else{
			TableHeader('填写用户信息');
		}

		TableRow(array('<b>用户名:</b>', '<input type="text" name="username" value="'.$user['username'].'" size="20" />' .$need_info));
		TableRow(array('<b>密码:</b>', '<input type="text" name="password" size="20" />'.$pass_info));
		/*TableRow(array('<b>确认密码:</b>', '<input type="text" name="passwordconfirm" size="20" />'.$pass_info));*/
		TableRow(array('<b>备注:</b>', '<input type="text" name="note" value="'.$user['note'].'" size="20" />'));

		TableRow(array('<b>调查员:</b>', '<select name="isjc" id="isjc"><option value="">--请选择--</option><option value="1">是</option><option value="0">否</option></select>'));

		TableRow(array('<b>大区选择:</b>', $qyhtml));
		TableRow(array('<b>区域选择:</b>', '<select name="yx" id="yx"><option value="0">请选择</option></select>'));
		TableRow(array('<b>店铺选择:</b>', '<select name="dpid" id="dpid"><option value="0">请选择</option></select>'));
		if($userid){
			TableRow(array('<b>是否激活?</b>', '<input type="checkbox" ' . Iif($userid == $this->admin->data['userid'], 'disabled') .' name="activated" value="1" ' . Iif($user['activated'] == 1, ' checked="checked"') .' />'));

			TableRow(array('<b>删除此用户?</b>', '<input type="checkbox" ' . Iif($userid == $this->admin->data['userid'], 'disabled') .' name="deleteuser" value="1" />&nbsp;<font class=redb>慎选!</font> <span class=light>删除此用户.</span>'));

			TableRow(array('<b>删除此用户发表的信息?</b>', '<input type="checkbox" name="deleteuserpublish" value="1" />&nbsp;<font class=redb>慎选!</font> <span class=light>删除此用户发表的所有信息.</span>'));
		}

		echo"<script>
			$(function(){

				$('#qy').change(function(){ 
					var area_id=$(this).children('option:selected').val();
					if(area_id!=0 && area_id!=null)
					{
						 $.ajax({
							type:'POST',
							 dataType:'html',
							 url:'/index.php/from/?action=getareas&area_id='+area_id,
							 success: function(data){
								$('#yx').html(data);
								
							},error:function(data)
							{
								alert('获取错误！');
							}
						})
					}else{
					
					}

				}) 

				$('#isjc').change(function(){
					var jc_id=$(this).children('option:selected').val();
					if(jc_id==1)
					{
						$('#qy').css('display','none');
						$('#yx').css('display','none');
						$('#dpid').css('display','none');
					}else{
						$('#qy').css('display','block');
						$('#yx').css('display','block');
						$('#dpid').css('display','block');
					}
				})
	


			$('#yx').change(function(){ 
					var yx_id=$(this).children('option:selected').val();
					if(yx_id!=0 && yx_id!=null)
					{
						 $.ajax({
							type:'POST',
							 dataType:'html',
							 url:'/index.php/from/?action=getdp&yx_id='+yx_id,
							 success: function(data){
								$('#dpid').html(data);
								
							},error:function(data)
							{
								alert('获取错误！');
							}
						})
					}else{
					
					}

				}) 


			})



			</script>";

		TableFooter();

		PrintSubmit(Iif($userid, '保存更新', '添加用户'));
	}


public function checku($jc,$qyid,$yxid,$dpid)
{

	if($jc==1)
	{
		return '调查员' ;	
	}else if($dpid>0)
	{
		return '店铺负责人' ;

	}else if($yxid>0)
	{
		return '区域负责人' ;
	}else if($qyid>0)
	{
		return '大区负责人' ;
	}
}


	public function index(){
		$NumPerPage = 20;
		$page = ForceIntFrom('p', 1);
		$letter = ForceStringFrom('key');
		$search = ForceStringFrom('s');

		
		if(IsGet('s')){
			$search = urldecode($search);
		}

		$start = $NumPerPage * ($page-1);

		if($search OR $letter){
			SubMenu('用户列表', array(array('添加用户', 'user/add'), array('全部用户', 'user')));
		}else{
			SubMenu('用户列表', array(array('添加用户', 'user/add')));
		}

		TableHeader('快速查找用户');
		for($alphabet = 'a'; $alphabet != 'aa'; $alphabet++){
			$alphabetlinks .= '<a href="'.BURL('user?key=' . $alphabet) . '" title="' . strtoupper($alphabet) . '开头的用户">' . strtoupper($alphabet) . '</a> &nbsp;';
		}

		TableRow('<center><b><a href="'.BURL('users').'">[全部用户]</a>&nbsp;&nbsp;&nbsp;' . $alphabetlinks . '&nbsp;</center>');
		TableFooter();

		echo '<form method="post" action="'.BURL('users').'" name="searchusers">';

		TableHeader('搜索用户');
		TableRow('<center><label>ID, 用户名:</label>&nbsp;<input type="text" name="s" size="18">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="搜索用户" class="cancel"></center>');
		TableFooter();

		echo '</form>';

		if($letter){
			if($letter == 'Other'){
				$searchsql = " WHERE username NOT REGEXP(\"^[a-zA-Z]\") ";
				$title = '<span class=note>中文用户名</span> 的用户列表';
			}else if($letter == 'Neverlogin')	{
				$searchsql = " WHERE lastdate = 0 ";
				$title = '<span class=note>未登陆</span> 的用户列表';
			}else{
				$searchsql = " WHERE username LIKE '$letter%' ";
				$title = '<span class=note>'.strtoupper($letter) . '</span> 字母开头的用户列表';
			}
		}else if($search){
			if(preg_match("/^[1-9][0-9]*$/", $search)){
				$searchsql = " WHERE id = '".ForceInt($search)."' "; //按ID搜索
				$title = "搜索ID号为: <span class=note>$search</span> 的用户";
			}else{
				$searchsql = " WHERE (username LIKE '%$search%') "; //按ID搜索
				$title = "搜索: <span class=note>$search</span> 的用户列表";
			}
		}else{
			$searchsql = '';
			$title = '全部用户列表';
		}

		$getusers = $this->db->query("SELECT * FROM " . TABLE_PREFIX . "user ".$searchsql." ORDER BY id ASC, id DESC LIMIT $start,$NumPerPage");

		$maxrows = $this->db->getOne("SELECT COUNT(id) AS value FROM " . TABLE_PREFIX . "user ".$searchsql);

		echo '<form method="post" action="'.BURL('user/updateusers').'" name="usersform">';

		TableHeader($title.'('.$maxrows['value'].'个)');
		TableRow(array('ID', '用户名', '用户类型', '注册日期',  '注册IP', '最后登陆', '最后IP','备注','<input type="checkbox" id="checkAll" for="deleteuserids[]"> <label for="checkAll">删除</label>'), 'tr0');

		if($maxrows['value'] < 1){
			TableRow('<center><BR><font class=redb>未搜索到任何用户!</font><BR><BR></center>');
		}else{
			while($user = $this->db->fetch($getusers)){
				TableRow(array($user['id'], '<input type="hidden" name="updateuserids[]" value="'.$user['id'].'" /><a href="'.BURL('user/edit?userid='.$user['id']).'">'. $user['username'] .'</a>',
				$this->checku($user['isjc'],$user['qy_cartid'],$user['yx_cartid'],$user['dp_id']),
				DisplayDate($user['addtime']),
				$user['lastip'],
				Iif($user['lastdate'] == 0, '<span class="orange">从未登陆</span>', DisplayDate($user['lasttime'])),
				$user['lastip'],
				$user['note'],
				'<input type="checkbox" name="deleteuserids[]" value="' . $user['id'] . '" ' . Iif($user['userid'] == $this->admin->data['userid'], 'disabled') .'>'));
			}

			$totalpages = ceil($maxrows['value'] / $NumPerPage);

			if($totalpages > 1){
				TableRow(GetPageList(BURL('user'), $totalpages, $page, 10, 'key', $letter, 's', urlencode($search)));
			}

		}

		TableFooter();

		echo '<div class="submit"><input type="submit" name="updateusers" value="保存更新" class="save"><input type="submit" name="deleteusers" onclick="'.Confirm('确定删除所选用户吗?<br><br><span class=red>注: 这里删除用户, 用户发表的信息不会被删除!</span>', 'form').'" value="删除用户" class="cancel"></div></form>';
	}

} 




?>