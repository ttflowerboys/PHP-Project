<?php $this->display('header.tpl'); ?>
<style>.input-text{ padding:4px 8px; }
input[readonly] {
    color: #57c5a0;font-weight: bold;
    background: #fafafa!important;
}</style>

<div class="w">

<input id="fileupload" type="file" name="files[]" multiple="" style="display:none;">
<div class="spread">
    <h2 class="tit"><i class="icon-feedback"></i>走访记录</h2>


    <h2 class="spreadHd">店铺经纪人列表</h2>
    <div class="User clearfix">
    <?php if(!$this->_tpl_vars['cur_jjr']){; ?>
		<div class="NoInfo">对不起，您访问的经纪人信息不存在！</div>
    <?php }else{; ?> 
    	  <div class="w-md-4">
    	  	<a class="info" href="<?php PURL('record?id=' . $this->_tpl_vars['cur_jjr']['dp_id'].'&show=2&jjr='.$this->_tpl_vars['cur_jjr']['id']); ?>" title="点我查看～">
          	    <?php if($this->_tpl_vars['cur_jjr']['type']==0){; ?><i class="icon-man"></i><?php }else{; ?><i class="icon-woman"></i><?php }; ?>
          		<div class="userInfo"><strong>姓名：</strong><?php echo $this->_tpl_vars['cur_jjr']['username']; ?><span class="t-green">（<?php echo $this->_tpl_vars['cur_jjr']['level']; ?>）</span><br>电话：<span class="t-green"><?php echo $this->_tpl_vars['cur_jjr']['mobile']; ?></span> <br>工号：<span class="t-green"><?php echo $this->_tpl_vars['cur_jjr']['no']; ?></span></div>
          	</a>
          </div>
    <?php }; ?>
    </div>

</div>
<?php 
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

<input id="fileupload" type="file" name="files[]" multiple="" style="display:none;">
<div class="spread2">
  <form class="ajaxForm" action="<?php PURL('jjr/update'); ?>" enctype="multipart/form-data" method="post">
    <div class="upBox">
        <div class="clearfix titSecond">
		  	<div class="w-md-15 tac"><?php echo $wj_title; ?></div>
		  	<div class="w-md-85p smalltit">
			  	<div class="w-md-6p">&nbsp;</div>
			  	<div class="w-md-08p">标准分</div>
			  	<div class="w-md-06p">得分</div>
			  	<div class="w-md-15 m01p">失分原因</div>
			  	<div class="w-md-08p">取证位置</div>
		  	</div>
		</div>
		<div class="clearfix jjTit">
	  	  <div class="w-md-15"><div class="tit"><span>经纪人信息</span></div></div>
          <div class="w-md-85p userMain">
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">姓名</span><input type="text" class="input-text" value="<?php echo $this->_tpl_vars['cur_jjr']['username']; ?>" name="username" required>
	            </div>
            </div>	            
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">电话</span><input type="text" class="input-text"  value="<?php echo $this->_tpl_vars['cur_jjr']['mobile']; ?>" name="mobile">      
	            </div>
            </div>
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">工号</span><input type="text" class="input-text"  value="<?php echo $this->_tpl_vars['cur_jjr']['no']; ?>" name="no">
	            </div>
            </div>
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">级别</span><input type="text" class="input-text" value="<?php echo $this->_tpl_vars['cur_jjr']['level']; ?>" name="level">
	            </div>
            </div>           
        </div>
	</div> <!-- end -->
	  <hr class="hr">

		<?php
			$temparr=array();
			$temparr1=array();
			
			foreach($tpl_show as $key =>$value){

				if($key==0){
					$temparr[$key]=count($value['arr']);
				}else{
					$temparr[$key]=$temparr[$key-1]+count($value['arr']);
				}
				
				if($key>0){
					$count=$temparr[$key-1];
				}else{
					$count=0;
				}

				$j=0;

				for($i=$count;$i<$temparr[$key];$i++){
					$temparr1[$key][$j]=$this->_tpl_vars['jjrinfoArr'][$i];
					$j++;
				}

				echo'<div class="clearfix">
					<div class="w-md-15"><div class="FromHd"><span>'.$value['name'].'</span></div></div>

		  	<div class="w-md-85p">';
			foreach($value['arr'] as $vvalue =>$val){

				$temparr2=explode(':',$temparr1[$key][$vvalue]);			

				echo'<div class="checkbox"><label class="w-md-6p">';
					if($temparr2[0]!=0){
 						 echo '<input checked type="checkbox" class="ace J_checkPrice  check_on" id="outarea_'.$key.'_'.$vvalue.'" data-price="'.$val[1].'" value="'.$val[1].'">';
 					}else{
 						 echo '<input type="checkbox" class="ace J_checkPrice" id="outarea_'.$key.'_'.$vvalue.'" data-price="'.$val[1].'" value="'.$val[1].'">';
 					}

					echo '<span class="lbl">'.$val[0].'</span></label>

						<span class="w-md-08p tac t-red">'.$val[1].'分</span>
						<input type="text" class="input-text input-text-min J_defen w-md-06p tac t-green" readonly name="outarea[]" value="'.$temparr2[0].'">
					<input type="text" name="outarea_r[]" class="input-text input-text-min w-md-15 m01p J_lostmsg t-green" value="'.$temparr2[1].'" readonly>

					<div class="w-md-08p tac">
					<input type="hidden" name="outarea_w[]" class="J_lostpic" value="'.$temparr2[2].'">';
					
					if($temparr2[2]){
						echo'<a href="javascript:;" onclick="Upload(this)" class="J_upload J_uploads_cur"  thumb="'.$temparr2[2].'" onmouseover="showImg(this)" onmouseout="hideImg(this)"><i class="icon-pic"></i></a>';
					}else{
						 echo '<a href="javascript:;"  class="J_upload J_upload_no"><i class="icon-camera" title="上传取证图片"></i></a>';
					}
					echo'</div></div>';

			}
			echo'</div></div><hr class="hr">';
			}
		?>
		<div class="clearfix">
		  	<div class="w-md-4"><div class="FromHd"><span>您对此名经纪人第一印象<strong class="count">总得分：<b class="t-red J_CurPirce"><?php echo $this->_tpl_vars['cur_jjr']['score']; ?></b></strong></span></div></div>
		  	<input type="hidden" name="score" value="<?php echo $this->_tpl_vars['cur_jjr']['score']; ?>" class="J_score">
		  	<div class="w-md-7_5p">
		  	  <textarea name="impressions" class="textarea input-textarea" placeholder="请描述该经纪人给您的第一印象如何？" ><?php echo $this->_tpl_vars['cur_jjr']['impressions']; ?></textarea>
		  	  <p class="tipsMsg">请描述该经纪人给您的第一印象如何？您觉得他的仪容仪表专业程度如何？哪些环节表现优秀？哪些环节需要改善？</p>
		  	</div>
		</div> <!-- end -->
		  <hr class="hr">
		  <div class="clearfix">
		  	<div class="w-md-4">
		  		<div class="FromHd"><span>举例说明</span><input type="text" name="descscore" class="input-text input-text-descscore" value="<?php echo $this->_tpl_vars['cur_jjr']['descscore']; ?>"></div>
		  	</div>
		  	<div class="w-md-7_5p">
		  	  <textarea class="textarea input-textarea" name="exinfo" placeholder="那么请您描述此名经纪人哪些方面不符合商务人士的形象" ><?php echo $this->_tpl_vars['cur_jjr']['exinfo']; ?></textarea>
		  	  <p class="tipsMsg"> 针对此名经纪人，您是否认为他符合链家经纪人商务人士的形象定位呢？<br>（回答1-7分询问）那么请您描述此名经纪人哪些方面不符合商务人士的形象（至少列举1点）<br>（回答8-10分询问）那么请您描述此名经纪人哪些方面符合商务人士的形象（至少列举1点）</p>
		  	</div>
		  </div> <!-- end -->
		<hr class="hr">
		<input type="hidden" name="type" value="<?php echo $this->_tpl_vars['cur_jjr']['type']; ?>">
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['cur_jjr']['id']; ?>">
		<div class="form-group-bottom clearfix tac">
		    <button type="submit" class="text-submit"><i class="ace-icon icon-right"></i>确认提交</button>
		    <button class="text-reset" type="reset"><i class="ace-icon icon-back"></i>重置</button>
		</div>

	  </div> <!-- spread end --> 
</form>
	</div>
</div>

<?php $this->display('footer.tpl'); ?>
<script type="text/javascript" src="/static/plugin/fancyBox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/static/plugin/fancyBox/jquery.fancyBox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="/static/plugin/fancyBox/jquery.fancybox.css?v=2.1.5" media="screen" />
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
