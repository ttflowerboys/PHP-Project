<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>{$title}</title>
    <meta name="description" content="{$description}">
    <meta name="Keywords" content="{$keywords}">
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
        <div class="fl">{$title}</div>
        <div class="fr">您好，<a href="{PURL('user')}">{$username}</a>，<a href="javascript:;" onclick="loginout('{PURL('user/logout')}')" class="t-gray">退出</a>！</div></div></div>
	<div class="navBox">
	  <div class="w">
	    <a href="{PURL()}" class="logo"  title="{$sitename}"><img src="http://oidnhhjfl.bkt.clouddn.com/static/tpl/images/logo.gif" alt="{$sitename}"></a>
	    <ul class="nav fl">
			<a  {if $menu=='home'}class="cur"{/if} href="{PURL()}">主页</a>
			<a  {if $menu=='record'}class="cur"{/if} href="{PURL('record')}">走访记录</a>
			<a  {if $menu=='report'}class="cur"{/if} href="{PURL('report')}">秋冬着装标准</a>
			<a  {if $menu=='from'}class="cur"{/if} href="{PURL('from')}">空白调查表格</a>
		</ul>
	  </div>
	</div>