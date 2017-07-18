## xiaocms增加会员级别

### 配置会员级别
* 修改配置文件
 ```php
 /* data/config/config.ini.php 增加配置*/

 'member_level' =>'1|A级会员
	2|B级会员
	3|C级会员
	4|D级会员
	5|E级会员
	6|F级会员'
```

* 后台可编辑
 ```php
 /* admin/template/config.tpl.php */

 <tr>
	<th width="100">会员级别类型：</th>
	<td>
		<textarea name="data[member_level]" rows="7" cols="55" class="text">
			<?php echo $data['member_level']; ?>
		</textarea>
		<br/>
		<div class="onShow">格式为 数字|名称 </div>
	</td>
</tr>
```

* 提交
 ```php
 /* admin/controller/index.php */

 public function configAction(){ }
```

### 文章增加相关会员权限
* 设置level_arr
 ```php
 /* admin/controller/content.php */
 class content extends Admin {
 private $level_arr;
 private $member_level;
 
 /* member level */
	$this->member_level  = explode(chr(13), $this->site_config['member_level']);
	foreach ($this ->member_level as $val) {
		if ($val =='') continue;
		list($levelid, $leveltype) = explode('|', $val);	
		$this ->level_arr[trim($levelid)] = trim($leveltype);
	}

 }
 ```

* 文章属性
 ```php
 /* admin/tmplate/content_add.tpl.php */
 
 <tr>
 	<th>会员级别：</th>
	<td>
		<?php if (is_array($this->level_arr)) foreach ($this->level_arr  as $key=>$t) { ?>
		<input type="radio" <?php if (isset($data['level']) && $data['level']==$key) { ?>checked<?php } ?> value="<?php echo $key; ?>" name="data[level]" > <?php echo $t; ?> &nbsp;<div class="onShow">默认开放，不需要选择会员级别！ </div>
		<?php } ?>
	</td>
 </tr>
 ```

* 数据库添加字段
`content -> level`,默认为0

* 发布文章
```php
 /* admin/controller/content.php */
 public function addAction(){
    $data['level'] = isset($data['level']) ? $data['level']:0;
 }
```

### 会员级别 - 只能在后台手动设置
* 会员注册
 `member -> level` 会员表增加级别，默认为0，代表游客

* 会员注册登录模版
`member/regist.php`


* 后台会员列表
 * 后台会员列表-模板: `admin/template/member_list.tpl.php`
  ```html
  <th>会员级别</th>
  <td align="center">
  	<?php if(!$t['level']){ ?>
    	<font color="#f00">未分配权限</font>
    <?php }else{ echo $level_arr[$t['level']];  } ?>
    </td>
  ```

 * 后台会员列表-控制器：`admin/controller/member.php`
 ```php
 	// indexAction(){}
    $level_arr = [];
    $member_level  = explode(chr(13), $this->site_config['member_level']);
    foreach ($member_level as $val) {
        if ($val =='') continue;
        list($levelid, $leveltype) = explode('|', $val);
        $level_arr[trim($levelid)] = trim($leveltype);
    }
 ```

* 后台编辑会员权限
 * 后台会员编辑-模板：`admin/template/member_edit.tpl.php`
 ```php
 <tr>
    <th>会员级别：</th>
    <td>
        <select name="data[level]">
            <option value="0">未分配权限</option>
            <?php if (is_array($level_arr)) foreach ($level_arr  as $key=>$t) { ?>
                <option <?php if (isset($data['level']) && $data['level']==$key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $t; ?></option>
            <?php } ?>
        </select>		
    </td>
</tr>
 ```

 * 后台会员编辑-控制器：`admin/template/member.php`
 ```php
 	// editAction()
 	$level_arr = [];
    $member_level  = explode(chr(13), $this->site_config['member_level']);
    foreach ($member_level as $val) {
        if ($val =='') continue;
        list($levelid, $leveltype) = explode('|', $val);	
        $level_arr[trim($levelid)] = trim($leveltype);
    }
 ```

* 前台判断会员级别
```html
<a {xiao:if $xiao['level'] == 0 || $xiao['level'] == $member['level']}href="{xiao:$xiao['download']}"{xiao:else} href="javascript:;" class="J_tips"{/xiao:if}>
	<i class="icon-download"></i>
</a>
```

***

### 班级
* 添加配置-参考《配置会员级别》
* 管理后台会员列表
```php
<?php if (is_array($class_arr)) { ?>
	按班级排序：
    <select class="select"  name="pageselect" onchange="self.location.href=options[selectedIndex].value" >
		<option  value="<?php echo url('member/index'); ?>" <?php if (!isset($class)) { ?>selected<?php } ?>>全部</option>
		<?php foreach ($class_arr  as $key=>$t) { ?>
			<option value="<?php echo url('member/index', array('class'=>$key)); ?>"  <?php if (isset($class) && $class==$key) { ?>selected<?php } ?>><?php echo $t; ?></option>
		<?php } ?>
     </select>
<?php } ?>
```

* 会员列表-控制器
```php
# search order by member class
$class    = $this->get('class');
if (isset($class) && empty($class)) $this->db->where('memberclass=?', '0');
if (!empty($class)) $this->db->where('memberclass=?', $class);
if (!empty($class)) $urlparam['class'] = $class;
```

## 自定义函数
```php
// core/controller/Base.class.php

// 提交函数（成功）
public function tp_success($info,$url=''){
    $data = array( 'info' => $info, 'status' => 1, 'url' => $url );
    echo json_encode($data);
    exit();
}
// 提交函数（失败）
public function tp_error($info,$url=''){
    $data = array( 'info' => $info, 'status' => 0, 'url' => $url );
    echo json_encode($data);
    exit();
}
```

***

## 技术支持
>[三镇网络技术有限公司](http://www.threetowns.cn)，专注于网络营销、电子商务和企业定制化建站服务，把正确的营销方向当作一种使命，帮助客户提供专业的网络营销方案。其雄厚的实力，专业的营销团队一直活跃于各大电子商务平台的前线。
>* 营销官网：`http://www.threetowns.cn`
>* 技术支持：`http://www.flowerboys.cn`
***

## 联系方式

* EMAIL联系方式：`threetowns@163.com`

| 官方网站 | 技术微信 | 技术QQ | QQ交流群 |
|--------|--------|--------|--------|
|![qq-1209445709](https://github.com/threetowns/About/raw/master/qrCode/website_threetowns.cn.jpg)|![wechat-433238694](https://github.com/threetowns/About/raw/master/qrCode/wechat_yonger_lei.jpg)|   ![qq-1209445709](https://github.com/threetowns/About/raw/master/qrCode/qq_1209445709.jpg)     |    ![qq-433238694](https://github.com/threetowns/About/raw/master/qrCode/qqGroup_433238694.jpg)    |
