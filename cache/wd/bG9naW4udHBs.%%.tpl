<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->_tpl_vars['title']; ?>_用户登录</title>
	<meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>">
	<meta name="Keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>">
	<link rel="stylesheet" href="http://oidnhhjfl.bkt.clouddn.com/static/tpl/css/fonts.css">
	<link rel="stylesheet" href="http://oidnhhjfl.bkt.clouddn.com/static/tpl/css/style.css">
	<style>body{ background: #fff url(http://oidnhhjfl.bkt.clouddn.com/static/tpl/images/login.jpg) center top repeat;}</style>

</head>

<body>

	<div class="Login">

		<div class="LoginHd"><img src="http://oidnhhjfl.bkt.clouddn.com/static/tpl/images/logo.gif" alt=""></div>

		<div class="LoginBd">

		  <form class="ajaxForm" action="?action=login" method="post">
		  	<label class="label">

		  		<i class="icon-nicename"></i>

		  		<input type="text" name="username" class="login-text login-verity" placeholder="请输入用户名" required>

		  	</label>

		  	<label class="label"><i class="icon-pwd2"></i><input type="password" name="password" class="login-text" placeholder="请输入密码" required></label>

		  	<input type="submit" class="login-btn" value="登 录">

		  </form>

		</div>

	</div>

<script src="http://oidnhhjfl.bkt.clouddn.com/static/tpl/js/jquery.js"></script>
<script src="http://oidnhhjfl.bkt.clouddn.com/static/plugin/layer/layer.js"></script>
<script src="http://oidnhhjfl.bkt.clouddn.com/static/tpl/js/jquery.form.js"></script>
<script src="http://oidnhhjfl.bkt.clouddn.com/static/tpl/js/common.js"></script>
<script src="https://s11.cnzz.com/z_stat.php?id=1260596497&web_id=1260596497" language="JavaScript" async></script>

</body>

</html>