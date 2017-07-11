<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->_tpl_vars['title']; ?></title>
    <meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>">
    <meta name="Keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>">
    <link rel="stylesheet" href="http://oidnhhjfl.bkt.clouddn.com/static/tpl/css/fonts.css">
	<link rel="stylesheet" href="http://oidnhhjfl.bkt.clouddn.com/static/tpl/css/style.css">
	<!--[if lt IE 9]>
      <script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js" type="text/javascript"></script>
      <script src="http://apps.bdimg.com/libs/respond.js/1.4.2/respond.js" type="text/javascript"></script>
    <![endif]-->

</head>

<body>
<div class="top">
    <div class="w">
        <div class="fl"><?php echo $this->_tpl_vars['title']; ?></div>
        <div class="fr">您好，<a href="<?php PURL('user'); ?>"><?php echo $this->_tpl_vars['username']; ?></a>，<a href="javascript:;" onclick="loginout('<?php PURL('user/logout'); ?>')" class="t-gray">退出</a>！</div></div></div>
	<div class="navBox">
	  <div class="w">
	    <a href="<?php PURL(); ?>" class="logo"  title="<?php echo $this->_tpl_vars['sitename']; ?>"><img src="http://oidnhhjfl.bkt.clouddn.com/static/tpl/images/logo.gif" alt="<?php echo $this->_tpl_vars['sitename']; ?>"></a>
	    <ul class="nav fl">
			<a  <?php if($this->_tpl_vars['menu']=='home'){; ?>class="cur"<?php }; ?> href="<?php PURL(); ?>">主页</a>
			<a  <?php if($this->_tpl_vars['menu']=='record'){; ?>class="cur"<?php }; ?> href="<?php PURL('record'); ?>">走访记录</a>
			<a  <?php if($this->_tpl_vars['menu']=='report'){; ?>class="cur"<?php }; ?> href="<?php PURL('report'); ?>">秋冬着装标准</a>
			<a  <?php if($this->_tpl_vars['menu']=='from'){; ?>class="cur"<?php }; ?> href="<?php PURL('from'); ?>">空白调查表格</a>
		</ul>
	  </div>
	</div>