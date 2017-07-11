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
      <h2 class="asideDt">我的资料</h2>
      <div class="areaRcont">
		  <div class="form-group"><label class="label">用户名<span></span></label><input type="text" name="password" placeholder="用户名" readonly class="text-ipt" value="{$username}"></div>
		  <div class="form-group"><label class="label">角色<span></span></label><input type="text" name="cpassword" placeholder="角色" class="text-ipt" value="{PrintUserType($usertype)}" readonly></div>
      </div>
    </div>
  </div>
</div>
</div>

{include footer.tpl}
