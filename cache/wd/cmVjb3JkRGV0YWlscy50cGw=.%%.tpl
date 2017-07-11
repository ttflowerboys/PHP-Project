<?php $this->display('header.tpl'); ?>
<style>.input-text{ padding:4px 8px; }
input[readonly] {
    color: #57c5a0;font-weight: bold;
    background: #fafafa!important;
}</style>

<div class="w">


<div class="spread">
    <h2 class="tit"><i class="icon-feedback"></i>走访记录</h2>

    <div class="clearfix form-horizontal">
        <div class="w-md-3_5p">
            <div class="form-items">
            	<span class="input-group-addon">店面编码</span>
            	<input type="text"  name="dpno" class="input-text" value="<?php echo $this->_tpl_vars['record']['dp_no']; ?>" readonly>
            </div>
			<div class="form-items">
				<span class="input-group-addon">营销大区</span>
				<input type="text" class="input-text" value="<?php echo areaType($this->_tpl_vars['record']['yx_catid']); ?>" readonly>
			</div>
			<div class="form-items">
            	<span class="input-group-addon">业务区域</span>
            	<input type="text" class="input-text" value="<?php echo areaType($this->_tpl_vars['record']['qy_catid']); ?>" readonly>
            </div>				
			<div class="form-items">
				<span class="input-group-addon">店面名称</span>
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['name']; ?>" readonly>
			</div>
            <div class="form-items">
				<span class="input-group-addon">店面地址</span>
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['address']; ?>"  readonly title="<?php echo $this->_tpl_vars['record']['address']; ?>">
			</div>				
        </div>
        <div class="w-md-3_5p">            	                
            <div class="form-items">
            	<span class="input-group-addon">走访日期</span>
            	<input type="text" class="input-text" value="<?php echo DisplayDate($this->_tpl_vars['record']['zftime']); ?>" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">走访时间</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['zfintime']; ?>" readonly style="width:41%"> ~ <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['zfouttime']; ?>" readonly style="width:41%">	
            </div>
            <div class="form-items">
            	<span class="input-group-addon">审核经纪人数量</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['check_num']; ?>" readonly style="width:73%">
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店内顾客人数量</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['gk_num']; ?>" readonly style="width:73%">
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店内经纪人数量</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['jj_num']; ?>" readonly style="width:74%">
            </div>
        </div>
        <div class="w-md-30p">
        	<div class="form-items">
            	<span class="input-group-addon">男经纪人得分</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['manfen']; ?>" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">女经纪人得分</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['womanfen']; ?>" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店面环境得分</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['storefen']; ?>" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店铺总体得分</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['totalfen']; ?>" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">审计员姓名：</span>
            	<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['record']['zfuser']; ?>" readonly>
            </div>
        </div>
    </div> <!-- form-horizontal end -->
    <hr class="hr">
    <div class="clearfix">
        <div class="w-md-3">
    		<div class="detailsItems"><a href="<?php PURL('record?id=' . $this->_tpl_vars['record']['id'].'&show=1'); ?>" target="_blank">
    			<i class="icon-store"></i>
    			<div class="info">店面环境得分：<b class="t-red"><?php echo $this->_tpl_vars['record']['storefen']; ?></b> 分<br>查看更多 ></div></a>
    		</div>
    	</div>
    	<div class="w-md-3">
    		<div class="detailsItems"><a href="<?php PURL('record?id=' . $this->_tpl_vars['record']['id'].'&show=2'); ?>" target="_blank">
    			<i class="icon-man"></i>
    			<div class="info">男经纪人得分：<b class="t-red"><?php echo $this->_tpl_vars['record']['manfen']; ?></b> 分<br>女经纪人得分：<b class="t-red"><?php echo $this->_tpl_vars['record']['womanfen']; ?></b> 分</div></a>
    		</div>
    	</div>
    	<div class="w-md-3">
    		<div class="detailsItems"><a href="<?php PURL('record?id=' . $this->_tpl_vars['record']['id']); ?>">
    			<i class="icon-main"></i>
    			<div class="info">总分：<b class="t-red"><?php echo $this->_tpl_vars['record']['totalfen']; ?></b> 分 <br>店名：<?php echo $this->_tpl_vars['record']['name']; ?></div></a>
    		</div>
    	</div> 
    </div> <!-- end -->

</div>


</div>

<?php $this->display('footer.tpl'); ?>
<script type="text/javascript" src="http://oidnhhjfl.bkt.clouddn.com/static/plugin/fancyBox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="http://oidnhhjfl.bkt.clouddn.com/static/plugin/fancyBox/jquery.fancyBox.js"></script>
<link rel="stylesheet" type="text/css" href="http://oidnhhjfl.bkt.clouddn.com/static/plugin/fancyBox/jquery.fancybox.css" media="screen" />
<script>
$(function(){
	$("a.J_fancybox").fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			title	: {
				type: 'inside'
			}
		}
	});
})
</script>
