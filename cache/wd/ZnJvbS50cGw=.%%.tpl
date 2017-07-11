	<?php $this->display('header.tpl'); ?>

<div class="w">
    <form class="ajaxForm form-horizontal" action="<?php PURL('from?action=updpinfo'); ?>" enctype="multipart/form-data" method="post">

        <div class="spread">
            <h2 class="tit"><i class="icon-feedback"></i>LIAN JIA 公开审计问卷</h2>

			<div class="clearfix form-horizontal">
				<div class="w-md-3_5p">
					<div class="form-items"><span class="input-group-addon">店面编码</span><input type="text" name="dpno" class="input-text" required></div>
					<div class="form-items"><span class="input-group-addon">营销大区</span><?php echo $this->_tpl_vars['navs']; ?></div>
					<div class="form-items"><span class="input-group-addon">业务区域</span><select name="careas" id="careas" class="input-text" required><option value="">--请选择--</option></select></div>					
					<div class="form-items"><span class="input-group-addon">店面名称</span><input type="text" name="dpname" class="input-text" required></div>
					<div class="form-items"><span class="input-group-addon">店面地址</span><input type="text" name="address" class="input-text" required></div>
				</div>
				<div class="w-md-3_5p">					
					<div class="form-items"><span class="input-group-addon">走访日期</span><input type="text" name="zftime" class="input-text input-text-time"  onclick="laydate()" required readonly></div>
					<div class="form-items"><span class="input-group-addon">走访时间</span><input class="input-text" name="zfintime" style="width:41%" required> ~ <input class="input-text" name="zfouttime" style="width:41%" required></div>
					<div class="form-items">
	            		<span class="input-group-addon">店内经纪人数量</span>
	            		<input name="jj_num" type="text" class="input-text" style="width:73%">
	            	</div>
	            	<div class="form-items">
	            		<span class="input-group-addon">审核经纪人数量</span>
	            		<input name="check_num" type="text" class="input-text" style="width:73%">
	            	</div>
	            	<div class="form-items">
	            		<span class="input-group-addon">店内顾客人数量</span>
	            		<input name="gk_num" type="text" class="input-text" style="width:73%">
	            	</div>
				</div>
				<div class="w-md-30p">
					<div class="form-items">
		            	<span class="input-group-addon">男经纪人得分</span>
		            	<input name="manfen" type="text" class="input-text">
		            </div>
		            <div class="form-items">
		            	<span class="input-group-addon">女经纪人得分</span>
		            	<input name="womanfen" type="text" class="input-text">
		            </div>		            
		            <div class="form-items">
		            	<span class="input-group-addon">店面环境得分 </span>
		            	<input name="storefen" type="text" class="input-text">
		            </div>
		            <div class="form-items">
		            	<span class="input-group-addon">店铺总体得分</span>
		            	<input name="totalfen" type="text" class="input-text">
		            </div>
		            <div class="form-items">
		            	<span class="input-group-addon">审计员姓名：</span>
		            	<input name="zfuser" type="text" class="input-text J_zfuser" required>
		            </div>
				</div>
			</div> <!-- end -->

            <div id="tipsInfo"><strong>审计员承诺：</strong><br>我保证在进行此次访问之前，不认识下列提到的任何链家工作人员。<br>我保证在寄回调查表之前，已遵照行为指南和准则并完整地填写完毕。<br>我保证在任何情况下，都不会将项目相关的任何信息和资料，泄漏给除瑞凯德项目负责人之外的任何个人和组织，我知道如果违规所应负的法律责任。</div>
	    </div>


	<input id="fileupload" type="file" name="files[]" multiple="" style="display:none;">
	<div class="spread2">
		<div class="upBox">

     	  <div class="clearfix titSecond">
		  	<div class="w-md-15 tac">店面环境</div>
		  	<div class="w-md-85p smalltit">
			  	<div class="w-md-6p">&nbsp;</div>
			  	<div class="w-md-08p">标准分</div>
			  	<div class="w-md-06p">得分</div>
			  	<div class="w-md-15 m01p">失分原因</div>
			  	<div class="w-md-08p">取证位置</div>
		  	</div>
		  </div>

	
			<?php
		
				foreach($this->dpinfo as $key =>$value){
			
			
			echo'<div class="clearfix">

		  	<div class="w-md-15"><div class="FromHd"><span>'.$value['name'].'</span></div></div>

		  	<div class="w-md-85p">';
				foreach($value['arr'] as $vvalue =>$val)
			{
				echo'<div class="checkbox">

					<label class="w-md-6p">
						 <input checked type="checkbox" class="ace J_checkPrice  check_on" data-price="'.$val[1].'" value="'.$val[1].'">
						 <span class="lbl">'.$val[0].'</span>
					</label>

					<span class="w-md-08p tac t-red">'.$val[1].'分</span>
					<input type="text" class="input-text input-text-min J_defen w-md-06p tac t-green" readonly value="'.$val[1].'"  name="outarea[]">

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
		  	<div class="w-md-15">
		  		<div class="FromHd"><span>店铺评价<strong class="count">总得分：<b class="t-red J_CurPirce">20</b></strong></span></div>
		  	</div>
		  	<input type="hidden" name="score" value="20" class="J_score">
		  	<div class="w-md-8p">
		  	  <textarea name="dp_desc" class="textarea input-textarea" placeholder="请描述该店面给您的第一印象如何？" required></textarea>
		  	  <p class="tipsMsg">请描述该店面给您的第一印象如何？哪些环节表现优秀？哪些环节需要改善？</p>
		  	</div>
		</div>

		<hr class="hr">

			<div class="form-group-bottom clearfix tac">
			    <button type="submit" class="text-submit"><i class="ace-icon icon-right"></i>确认提交</button>
			    <button class="text-reset" type="reset"><i class="ace-icon icon-back"></i>重置</button>
			</div>
		</div>
	</div> <!-- spread end -->	  

	</form>
</div>


<?php $this->display('footer.tpl'); ?>
<script>
$(function(){

	$('#areas').change(function(){ 
		var area_id=$(this).children('option:selected').val();
		if(area_id!=0 && area_id!=null)
		{
			 $.ajax({
				type:"POST",
				 dataType:"html",
				 url: "?action=getareas&area_id="+area_id,
				 success: function(data){
					$("#careas").html(data);
					
				},error:function(data)
				{
					alert('获取错误！');
				}
			})
		}else{
			$("#careas").html('<option value="0">--请选择--</option>');
		}

	}) 


})

</script>

