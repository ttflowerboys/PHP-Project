	{include header.tpl}


<div class="container ptb42">
 <div class="clearfix">
  <div class="w-md-5">
    <div class="asideItems">
        <h2 class="asideDt">我的资料</h2>
        <div class="asideCont">
            帐号：<span class="t-green">{$username}</span><br>
            角色：<span class="t-green">{PrintUserType($usertype)}</span>
        </div>
    </div>
    <dl class="asideItems">
      <dt class="asideDt">资料列表</dt>
      <dd class="asideDd">
        <a href="{PURL('user')}"><i class="icon-user-edit"></i>我的资料</a>
        <a href="{PURL('user/changepwd')}"><i class="icon-verity"></i>修改密码</a>
      </dd>
    </dl>
  </div>
  <div class="w-md-8p">
    <div class="areaR">
      <h2 class="asideDt">修改密码</h2>
      <div class="areaRcont">
		<form class="ajaxForm" action="{PURL('user/changepwdDo')}" method="post">
		  <div class="form-group"><label class="label">原密码<span>（此处必须填写!）</span></label><input type="password" name="oldpassword" placeholder="原密码" class="text-ipt" required></div>
		  <div class="form-group"><label class="label">新密码<span>（此处必须填写!）</span></label><input type="password" name="password" placeholder="新密码" class="text-ipt" required></div>
		  <div class="form-group"><label class="label">确认新密码<span>（此处必须填写!）</span></label><input type="password" name="cpassword" placeholder="确认新密码" class="text-ipt" required></div>
		  <input type="hidden" name="username" value="{$username}">
		  <div class="form-group-bottom clearfix tac">
		    <button type="submit" class="text-submit"><i class="ace-icon icon-right"></i>提交修改</button>
		    <button class="text-reset" type="reset"><i class="ace-icon icon-back"></i>重置</button>
		  </div>
		</form>
      </div>
    </div>
  </div>
  </div>
</div>


{include footer.tpl}