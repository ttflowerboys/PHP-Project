<?php if(!defined('ROOT')) die('Access denied.');

class c_areas extends SAdmin{

	public function __construct($path){
		parent::__construct($path);

	}

	//分类下拉菜单函数
	private function GetCategorySelect($currentid, $selectedid =0, $showzerovalue = 1, $selectname = 'p_id'){
		$sReturn = '<select name="' . $selectname . '">';

		if($showzerovalue){
			$sReturn .= '<option value="0">无</option>';
		}

		$categories = $this->db->getAll("SELECT cat_id, p_id, name  FROM " . TABLE_PREFIX . "areas ORDER BY cat_id");

		$sReturn .= $this->GetOptions($categories, $currentid, $selectedid);
		$sReturn .= '</select>';

		return $sReturn;
	}

	//分类选项列表函数
	private function GetOptions($categories, $currentid = 0, $selectedid = 0, $parentid = 0, $sublevelmarker = ''){
		if($parentid) $sublevelmarker .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		foreach($categories as $value){
			if($parentid == $value['p_id'] AND $value['cat_id'] != $currentid){
				$sReturn .= '<option '. Iif(!$parentid, 'style="color:#cc4911;font-weight:bold;"') . ' value="' . $value['cat_id'] . '" ' . Iif($selectedid == $value['cat_id'], 'SELECTED', '') . '>' . $sublevelmarker . $value['name'] . '</option>';

				$sReturn .= $this->GetOptions($categories, $currentid, $selectedid, $value['cat_id'], $sublevelmarker);
			}
		}

		return $sReturn;
	}

	//删除分类
	public function delete(){
		$cat_id = ForceIntFrom('cat_id');
		$p_id = ForceIntFrom('p_id');
		$cats = ForceIntFrom('cats');

		if(IsPost('confirmdelete'))	{
			if($p_id){
				//$getcounts = $this->db->getOne("SELECT counts FROM " . TABLE_PREFIX . "areas WHERE cat_id = '$cat_id'");
				$this->db->exe("DELETE FROM " . TABLE_PREFIX . "areas WHERE p_id = '$p_id'");
				$this->db->exe("DELETE FROM " . TABLE_PREFIX . "areas WHERE cat_id = '$cat_id'");
			//	$this->db->exe("UPDATE " . TABLE_PREFIX . "article SET cat_id = '$p_id' WHERE cat_id = '$cat_id' ");
			//	$this->db->exe("UPDATE " . TABLE_PREFIX . "acat SET counts = (counts +$getcounts[counts]) WHERE cat_id = '$p_id'");
			}else{
				$this->db->exe("DELETE FROM " . TABLE_PREFIX . "areas WHERE cat_id = '$cat_id'");
				//$this->db->exe("DELETE FROM " . TABLE_PREFIX . "article WHERE cat_id = '$cat_id'");
			}

			Success('areas');

		}else{
			$parent_cat = $this->db->getOne("SELECT cat_id  FROM " . TABLE_PREFIX . "areas WHERE p_id = '$cat_id'");
			if($parent_cat) {
				Error('当前大区有下级区域, 请先删除其下级区域!', '删除区域错误');
			}

			SubMenu('区域管理', array(array('添加区域', 'areas/add'),array('删除区域', 'areas/delete?cat_id='.$cat_id . '&cats=' . $cats, 1),array('全部区域', 'areas')));

			$category = $this->db->getOne("SELECT cat_id, p_id, name  FROM " . TABLE_PREFIX . "areas WHERE cat_id = '$cat_id'");


			echo '<form method="post" action="'.BURL('areas/delete').'">
			<input type="hidden" name="cat_id" value="' . $cat_id . '" />';

			TableHeader('删除区域: <span class=note>' . $category['name'] . '</span>');
			TableRow(array('<BR><b>确定删除区域: "<font class=redb>' . $category['name']  . '</font>" 吗?</b><BR><BR>' . 
			Iif($cats > 1, '<span class=note>此分类下所有的走访记录将自动转入</span>: ' . $this->GetCategorySelect($cat_id, $category['p_id'], 0), '<span class=note>注: 此分类下所有的走访记录将被删除!</span>') . '<BR><BR>', '<input type="submit" name="confirmdelete" value="确定删除" class="save">
			<input type="submit" value="取 消" class="cancel" onclick="history.back();return false;">'));

			TableFooter();
			echo '</form>';
		}
	}

	//保存分类
	public function save(){
		$cat_id = ForceIntFrom('cat_id');
		$p_id = ForceIntFrom('p_id');


		$name = ForceStringFrom('name');
		$keywords = ForceStringFrom('keywords');


		if(!$name){
			$errors = "名称不能为空!";
		}

		if(isset($errors)){
			Error($errors, Iif($cat_id, '编辑错误', '添加错误'));
		}else{
			if($cat_id){
				$this->db->exe("UPDATE " . TABLE_PREFIX . "areas SET 
				p_id= '$p_id',
				name     = '$name',
				keywords     = '$keywords'
				WHERE cat_id = '$cat_id' ");
			}else{
				$this->db->exe("INSERT INTO " . TABLE_PREFIX . "areas (p_id, name, keywords) VALUES ('$p_id',  '$name', '$keywords') ");

				//$cat_id = $this->db->insert_id;
				
			}

			Success('areas');
		}
	}

	//批量更新分类
	public function updatecategories(){
		$cat_ids   = $_POST['cat_ids'];
		$names   = $_POST['names'];


		for($i = 0; $i < count($cat_ids); $i++){
			$this->db->exe("UPDATE " . TABLE_PREFIX . "areas SET name = '". ForceString($names[$i])."'
			WHERE cat_id = '".ForceInt($cat_ids[$i])."'");
		}

		Success('areas');
	}

	//编辑分类调用add
	public function edit(){
		$this->add();
	}

	//添加分类的表单页面
	public function add(){
		$cat_id = ForceIntFrom('cat_id');
		if($cat_id){
			SubMenu('营销大区管理', array(array('添加区域', 'areas/add'),array('编辑区域', 'areas/add?cat_id='.$cat_id, 1),array('全部区域', 'areas')));

			$category = $this->db->getOne("SELECT * FROM " . TABLE_PREFIX . "areas WHERE cat_id = '$cat_id'");
		}else{
			SubMenu('营销大区管理', array(array('添加区域', 'areas/add', 1),array('全部区域','areas')));

			$category = array('p_id' => 0, 'is_show' => 1);
		}

		echo '<form id="editorform88" name="editorform88" method="post" action="'.BURL('areas/save').'">
		<input type="hidden" name="cat_id" value="' . $cat_id . '" />';

		if($cat_id){
			TableHeader('编辑区域: <span class=note>' . Iif($category['name'], $category['name'], '未命名') . '</span>');
		}else{
			TableHeader('添加区域');
		}

		TableRow(array('<B>名称:</B>', '<input type="text" name="name" value="' . $category['name'] . '"  size="30" /> <font class=red>* 必填项</font>'));

		TableRow(array('<B>营销大区:</B>', $this->GetCategorySelect($cat_id, $category['p_id']) . '&nbsp;&nbsp;<span class=light>注: 选择当前分类的上级分类.</span>' ));


		TableRow(array('<B>简介:</B>', '<input type="text" name="keywords" value="' . $category['keywords'] . '" size="30" /> '));


		TableFooter();

		PrintSubmit(Iif($cat_id, '保存更新', '创建区域'));
	}

	public function index(){
		SubMenu('营销大区管理', array(array('添加区域', 'areas/add'), array('区域列表', 'areas')));

		$getcategories = $this->db->query("SELECT cat_id,p_id,name,keywords FROM " . TABLE_PREFIX . "areas ORDER BY cat_id");
		$this->cats = $this->db->result_nums;

		echo '<form method="post" action="'.BURL('areas/updatecategories').'">';

		TableHeader('添加列表('.$this->cats.'个)');
		TableRow(array('区域名称', '简介', '编辑', '删除'), 'tr0');

		if($this->cats < 1){
			TableRow('<center><BR><font class=redb>暂无任何区域!</font><BR><BR></center>');
		}else{

			$this->categories = array();
			$this->parentids = array();

			while($category = $this->db->fetch($getcategories)){
				$this->categories[$category['cat_id']] = $category;
				$this->parentids[$category['cat_id']] = $category['p_id'];
			}

			$this->ShowCategories();
		}

		TableFooter();

		PrintSubmit('保存更新');
	}


	private function ShowCategories ($parentid = 0, $sublevelmarker = '') {
		if($parentid) $sublevelmarker .= '<img src="' . SYSDIR . 'public/admin/images/sub.gif" align="absmiddle">';

		$allcategories = $this->parentids;

		foreach($allcategories as $key => $value){
			if($parentid == $value){
				TableRow(array($sublevelmarker .'<input type="hidden" name="cat_ids[]" value="' . $key . '" /><input type="text" name="names[]" value="' . $this->categories[$key]['name'] . '" size="22" />',
				'<input type="text" name="keywords" value="' . $this->categories[$key]['keywords'] . '" size="22" />',
				'<a href="' . BURL('areas/edit?cat_id=' . $key) . '"><img src="' . SYSDIR . 'public/admin/images/edit.png" /></a>',
				'<a href="' . BURL('areas/delete?cat_id=' . $key . '&cats=' . $this->cats) . '"><img src="' . SYSDIR . 'public/admin/images/trash.png"></a>'));

				$this->ShowCategories($key, $sublevelmarker);
			}
		}
	}
} 

?>