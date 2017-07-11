<?php $this->display('header.tpl'); ?>
<div class="w">

    <div class="spread">
       <h2 class="tit"><i class="icon-feedback"></i>走访记录</h2>
       <div class="clearfix">
	        <div class="w-md-2">
	          <div class="addr">
	          	<i class="icon-hotel"></i>
	          	<div class="info">
	          		<p><strong>店面编码：</strong><?php echo $this->_tpl_vars['dp_info']['dp_no']; ?></p>
	          		<p><strong>营销区域：</strong><?php echo areaType($this->_tpl_vars['dp_info']['yx_catid']); ?> - <?php echo areaType($this->_tpl_vars['dp_info']['qy_catid']); ?></p>          		
	          		<p><strong>店铺名称：</strong><?php echo $this->_tpl_vars['dp_info']['name']; ?></p>
	          		<p><strong>店面地址：</strong><?php echo $this->_tpl_vars['dp_info']['address']; ?></p>
	          		<p><strong>检测日期：</strong><?php echo DisplayDate($this->_tpl_vars['dp_info']['zftime']); ?> <?php echo $this->_tpl_vars['dp_info']['zfintime']; ?> ~ <?php echo $this->_tpl_vars['dp_info']['zfouttime']; ?></p>
	          	</div>
	          </div> <!-- addr end -->				
	        </div>
			<div class="w-md-2">
				<div class="defen">
					<div class="defenItems"><i class="icon-man"></i><b><?php echo $this->_tpl_vars['dp_info']['manfen']; ?></b><span>男经纪人得分</span></div>
					<div class="defenItems"><i class="icon-woman"></i><b><?php echo $this->_tpl_vars['dp_info']['womanfen']; ?></b><span>女经纪人得分</span></div>
					<div class="defenItems"><i class="icon-store"></i><b><?php echo $this->_tpl_vars['dp_info']['storefen']; ?></b><span>店面环境得分</span></div>
					<div class="defenItems"><i class="icon-main"></i><b><?php echo $this->_tpl_vars['dp_info']['totalfen']; ?></b><span>店铺总体得分</span></div>
				</div>
			</div>
	    </div> <!-- 店铺信息 end -->

	    <div class="clearfix">
	    	<div class="w-md-2">  
	        	<div class="User">
	        	  <?php foreach($this->_tpl_vars['jjr_info'] AS $this->_tpl_vars['rs']){; ?>
	        	  <?php if($this->_tpl_vars['rs']['type']==0){; ?>
	        	  <div class="w-md-2">
	              	<a class="info" href="<?php PURL('jjr?id='. $this->_tpl_vars['rs']['id']); ?>" target="_blank">
	              	    <i class="icon-man"></i>
	              		<div class="userInfo"><strong>姓名：</strong><?php echo $this->_tpl_vars['rs']['username']; ?><span class="t-green">（<?php echo $this->_tpl_vars['rs']['level']; ?>）</span><br>电话：<span class="t-green"><?php echo $this->_tpl_vars['rs']['mobile']; ?></span> <br>工号：<span class="t-green"><?php echo $this->_tpl_vars['rs']['no']; ?></span></div>
	              	</a>
	              </div>
	              	<?php }; ?>
	              <?php }; ?>
	              	<div class="infoAdd">
	              		<a href="javascript:;" class="text-submit" id="manBtn">添加男经纪人</a>
	              	</div>
	              </div>
	        </div>
	        <div class="w-md-2">        
	            <div class="User">
	            <?php foreach($this->_tpl_vars['jjr_info'] AS $this->_tpl_vars['rs']){; ?>
	        	  <?php if($this->_tpl_vars['rs']['type']==1){; ?>
	        	  <div class="w-md-2">
	              	<a class="info" href="<?php PURL('jjr?id=' . $this->_tpl_vars['rs']['id']); ?>" target="_blank">
	              	    <i class="icon-woman"></i>
	              		<div class="userInfo"><strong>姓名：</strong><?php echo $this->_tpl_vars['rs']['username']; ?><span class="t-green">（<?php echo $this->_tpl_vars['rs']['level']; ?>）</span><br>电话：<span class="t-green"><?php echo $this->_tpl_vars['rs']['mobile']; ?></span> <br>工号：<span class="t-green"><?php echo $this->_tpl_vars['rs']['no']; ?></span></div>
	              	</a>
	              </div>
	              	<?php }; ?>
	              <?php }; ?>
		          	<div class="infoAdd">
		          		<a href="javascript:;" class="text-submit" id="womanBtn">添加女经纪人</a>
		          	</div>
		          </div>
	        </div>
	    </div> <!-- 经纪人 end -->
	</div>


<style>.spread2{ display: none; }</style>
<input id="fileupload" type="file" name="files[]" multiple="" style="display:none;">
<div class="spread2" id="manBox">
    <form class="ajaxForm" action="<?php PURL('from2/jjrAddDo'); ?>" enctype="multipart/form-data" method="post">
	<div class="upBox">
		  <div class="clearfix titSecond">
		  	<div class="w-md-15 tac">仪容仪表(男士)</div>
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
		                <span class="input-group-addon">姓名</span><input type="text" class="input-text" name="username" required>
		            </div>
	            </div>	            
	            <div class="w-md-4">
	            	<div class="form-items">
		                <span class="input-group-addon">电话</span><input type="text" class="input-text" name="mobile">      
		            </div>
	            </div>
	            <div class="w-md-4">
	            	<div class="form-items">
		                <span class="input-group-addon">工号</span><input type="text" class="input-text" name="no">
		            </div>
	            </div>
	            <div class="w-md-4">
	            	<div class="form-items">
		                <span class="input-group-addon">级别</span><input type="text" class="input-text" name="level">
		            </div>
	            </div>           
	        </div>
		  </div>
		  <hr class="hr">
	
				<?php
				$zzType =  $this->iswinter?$this->w_dpman:$this->dpman;
				foreach( $zzType as $key =>$value){			
			
			echo'<div class="clearfix">
		  	<div class="w-md-15"><div class="FromHd"><span>'.$value['name'].'</span></div></div>

		  	<div class="w-md-85p" id="outarea">';
				foreach($value['arr'] as $vvalue =>$val)
			{
				echo'<div class="checkbox">
					<label class="w-md-6p">
						 <input checked type="checkbox" class="ace J_checkPrice  check_on" data-price="'.$val[1].'" value="'.$val[1].'">
						 <span class="lbl">'.$val[0].'</span>
					</label>

					<span class="w-md-08p tac t-red">'.$val[1].'分</span>
					<input type="text" class="input-text input-text-min J_defen w-md-06p tac t-green" readonly value="'.$val[1].'" name="outarea[]">

					<input type="text" name="outarea_r[]" class="input-text input-text-min w-md-15 m01p J_lostmsg" readonly>

					<div class="w-md-08p tac">
					 	<input type="hidden" name="outarea_w[]" class="J_lostpic">
					 	<a href="javascript:;" class="J_upload J_upload_no">
						 	<i class="icon-camera" title="上传取证图片"></i>
						 </a>
					</div>
				</div>';
			}
			
		  	echo'</div></div><hr class="hr">';
			}
		?>

		
		<div class="clearfix">
		  	<div class="w-md-4"><div class="FromHd"><span>您对此名经纪人第一印象<strong class="count">总得分：<b class="t-red J_CurPirce">40</b></strong></span></div></div>
		  	<input type="hidden" name="score" value="40" class="J_score">
		  	<div class="w-md-7_5p">
		  	  <textarea name="impressions" class="input-text input-textarea" placeholder="请描述该经纪人给您的第一印象如何？" required></textarea>
		  	  <p class="tipsMsg">请描述该经纪人给您的第一印象如何？您觉得他的仪容仪表专业程度如何？哪些环节表现优秀？哪些环节需要改善？</p>
		  	</div>
		</div>
		  <hr class="hr">
		  <div class="clearfix">
		  	<div class="w-md-4">
		  		<div class="FromHd"><span>举例说明</span><input type="text" name="descscore" class="input-text input-text-descscore" required></div>
		  	</div>
		  	<div class="w-md-7_5p">
		  	  <textarea name="exinfo" class="input-text input-textarea" placeholder="那么请您描述此名经纪人哪些方面不符合商务人士的形象" required></textarea>
		  	  <p class="tipsMsg"> 针对此名经纪人，您是否认为他符合链家经纪人商务人士的形象定位呢？<br>（回答1-7分询问）那么请您描述此名经纪人哪些方面不符合商务人士的形象（至少列举1点）<br>（回答8-10分询问）那么请您描述此名经纪人哪些方面符合商务人士的形象（至少列举1点）</p>
		  	</div>
		  </div>
		<hr class="hr">
		<input type="hidden" name="dp_id" value="<?php echo $this->_tpl_vars['dp_info']['id']; ?>">
		<input type="hidden" name="type" value="0">
		<div class="form-group-bottom clearfix tac">
		    <button type="submit" class="text-submit"><i class="ace-icon icon-right"></i>确认提交</button>
		    <button class="text-reset" type="reset"><i class="ace-icon icon-back"></i>重置</button>
		</div>
    </div>
    </form>
</div> <!-- spread end -->	  


<div class="spread2" id="womanBox">
  <form class="ajaxForm" action="<?php PURL('from2/jjrAddDo'); ?>" enctype="multipart/form-data" method="post">
	<div class="upBox">
		  <div class="clearfix titSecond">
		  	<div class="w-md-15 tac">仪容仪表(女士)</div>
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
		                <span class="input-group-addon">姓名</span><input type="text" class="input-text" name="username">
		            </div>
	            </div>	            
	            <div class="w-md-4">
	            	<div class="form-items">
		                <span class="input-group-addon">电话</span><input type="text" class="input-text" name="mobile">      
		            </div>
	            </div>
	            <div class="w-md-4">
	            	<div class="form-items">
		                <span class="input-group-addon">工号</span><input type="text" class="input-text" name="no">
		            </div>
	            </div>
	            <div class="w-md-4">
	            	<div class="form-items">
		                <span class="input-group-addon">级别</span><input type="text" class="input-text" name="level">
		            </div>
	            </div>           
	        </div>
		  </div>
		  <hr class="hr">
	
				<?php
				$zzType =  $this->iswinter?$this->w_dpwoman:$this->dpwoman;	
				foreach($zzType as $key =>$value){			
			
			echo'<div class="clearfix">
		  	<div class="w-md-15"><div class="FromHd"><span>'.$value['name'].'</span></div></div>

		  	<div class="w-md-85p" id="outarea">';
				foreach($value['arr'] as $vvalue =>$val)
			{
				echo'<div class="checkbox">
					<label class="w-md-6p">
						 <input checked type="checkbox" class="ace J_checkPrice  check_on" data-price="'.$val[1].'" value="'.$val[1].'">
						 <span class="lbl">'.$val[0].'</span>
					</label>

					<span class="w-md-08p tac t-red">'.$val[1].'分</span>
					<input type="text" class="input-text input-text-min J_defen w-md-06p tac t-green" readonly value="'.$val[1].'" name="outarea[]">

					<input type="text" name="outarea_r[]" class="input-text input-text-min w-md-15 m01p J_lostmsg" readonly>

					<div class="w-md-08p tac">
					 	<input type="hidden" name="outarea_w[]" class="J_lostpic">
					 	<a href="javascript:;" class="J_upload J_upload_no">
						 	<i class="icon-camera" title="上传取证图片"></i>
						 </a>
					</div>
				</div>';
			}
			
		  	echo'</div></div><hr class="hr">';
			}
		?>

		
		<div class="clearfix">
		  	<div class="w-md-4"><div class="FromHd"><span>您对此名经纪人第一印象<strong class="count">总得分：<b class="t-red J_CurPirce">40</b></strong></span></div></div>
		  	<input type="hidden" name="score" value="40" class="J_score">
		  	<div class="w-md-7_5p">
		  	  <textarea name="impressions" class="input-text input-textarea" placeholder="请描述该经纪人给您的第一印象如何？" required></textarea>
		  	  <p class="tipsMsg">请描述该经纪人给您的第一印象如何？您觉得他的仪容仪表专业程度如何？哪些环节表现优秀？哪些环节需要改善？</p>
		  	</div>
		</div>
		  <hr class="hr">
		  <div class="clearfix">
		  	<div class="w-md-4">
		  		<div class="FromHd"><span>举例说明</span><input type="text" name="descscore" class="input-text input-text-descscore" required></div>
		  	</div>
		  	<div class="w-md-7_5p">
		  	  <textarea name="exinfo" class="input-text input-textarea" placeholder="那么请您描述此名经纪人哪些方面不符合商务人士的形象" required></textarea>
		  	  <p class="tipsMsg"> 针对此名经纪人，您是否认为他符合链家经纪人商务人士的形象定位呢？<br>（回答1-7分询问）那么请您描述此名经纪人哪些方面不符合商务人士的形象（至少列举1点）<br>（回答8-10分询问）那么请您描述此名经纪人哪些方面符合商务人士的形象（至少列举1点）</p>
		  	</div>
		  </div>
		<hr class="hr">
		<input type="hidden" name="dp_id" value="<?php echo $this->_tpl_vars['dp_info']['id']; ?>">
		<input type="hidden" name="type" value="1">
		<div class="form-group-bottom clearfix tac">
		    <button type="submit" class="text-submit"><i class="ace-icon icon-right"></i>确认提交</button>
		    <button class="text-reset" type="reset"><i class="ace-icon icon-back"></i>重置</button>
		</div>
    </div>
    </form>
</div> <!-- spread end -->	

</div>


<script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>


<script>

	function updpinfo(){
	
	
		 $.ajax({
				type:"POST",
				 dataType:"html",
				 url: "?action=updpinfo",
				 data:data,
				 cache: false,  
				 processData: false,  
                 contentType: false, 
				 success: function(data){
					if(data=='ok')
					{
						alert('添加完成');
						//loaction.href='';

					}else if(data=='ok1' || data=='ok2'){
						alert('已存在该店铺信息');
					}else if(data=="err1"){
						alert('未上传店铺图片');
					}else if(data=="err2"){
						alert('文件上传错误');
					}else if(data=="err3"){
						alert('文件格式错误,请上传jpg,png,gif格式图片');
					}
				
				
					return false;
				},error:function(data)
				{
					alert('获取错误！');
					return false;
				}
			})
			
			return false;
		
	}


$(function(){
		var manBtn = $("#manBtn"),
		womanBtn = $("#womanBtn"),
		womanBox = $("#womanBox"),
		manBox = $("#manBox"),
		spread2 = $(".spread2");
		manBtn.on("click",function(){
			spread2.hide();
			manBox.show();
		});
		womanBtn.on("click",function(){
			spread2.hide();
			womanBox.show();
		})
	})
</script>
<?php $this->display('footer.tpl'); ?>

