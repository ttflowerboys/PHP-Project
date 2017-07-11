	{include header.tpl}
<style>.input-text{ color: #009f95; }</style>
<div class="w">
    <form class="ajaxForm form-horizontal" action="{PURL('edit/editDo')}" enctype="multipart/form-data" method="post">

        <div class="spread">
            <h2 class="tit"><i class="icon-feedback"></i>LIAN JIA 公开审计问卷</h2>
		<input type="hidden" value="{$record.id}" name="id">
			<div class="clearfix form-horizontal">
				<div class="w-md-3_5p">
					<div class="form-items"><span class="input-group-addon">店面编码</span><input type="text" name="dpno" class="input-text" value="{$record.dp_no}" required></div>
					<div class="form-items"><span class="input-group-addon">营销大区</span>{echo $navs}</div>
					<div class="form-items"><span class="input-group-addon">业务区域</span><select name="careas" id="careas" class="input-text"  required><option value="{$record.qy_catid}">{echo areaType($record.qy_catid)}</option></select></div>					
					<div class="form-items"><span class="input-group-addon">店面名称</span><input type="text" name="dpname" class="input-text" value="{$record.name}" required></div>
					<div class="form-items"><span class="input-group-addon">店面地址</span><input type="text" name="address" class="input-text" value="{$record.address}" required title="{$record.address}"></div>
				</div>
				<div class="w-md-3_5p">					
					<div class="form-items"><span class="input-group-addon">走访日期</span><input type="text" name="zftime" class="input-text input-text-time"  value="{echo DisplayDate($record.zftime)}" onclick="laydate()" required></div>
					<div class="form-items"><span class="input-group-addon">走访时间</span><input class="input-text" name="zfintime" value="{$record.zfintime}" style="width:41%" required> ~ <input class="input-text" name="zfouttime" value="{$record.zfouttime}" style="width:41%" required></div>
					<div class="form-items">
	            		<span class="input-group-addon">店内经纪人数量</span>
	            		<input name="check_num" type="text" value="{$record.check_num}" class="input-text" style="width:73%">
	            	</div>
	            	<div class="form-items">
	            		<span class="input-group-addon">审核经纪人数量</span>
	            		<input name="jj_num" type="text" value="{$record.jj_num}" class="input-text" style="width:73%">
	            	</div>
	            	<div class="form-items">
	            		<span class="input-group-addon">店内顾客人数量</span>
	            		<input name="gk_num" type="text" value="{$record.gk_num}" class="input-text" style="width:73%">
	            	</div>
	            	
				</div>
				<div class="w-md-30p">
					<div class="form-items">
		            	<span class="input-group-addon">男经纪人得分</span>
		            	<input name="manfen" type="text" value="{$record.manfen}" class="input-text">
		            </div>
		            <div class="form-items">
		            	<span class="input-group-addon">女经纪人得分</span>
		            	<input name="womanfen" type="text" value="{$record.womanfen}" class="input-text">
		            </div>		            
		            <div class="form-items">
		            	<span class="input-group-addon">店面环境得分 </span>
		            	<input name="storefen" type="text" value="{$record.storefen}" class="input-text">
		            </div>
		            <div class="form-items">
		            	<span class="input-group-addon">店铺总体得分</span>
		            	<input name="totalfen" type="text" value="{$record.totalfen}" class="input-text">
		            </div>
		            <div class="form-items">
		            	<span class="input-group-addon">审计员姓名：</span>
		            	<input name="zfuser" type="text" value="{$record.zfuser}" class="input-text" required>
		            </div>

				</div>
			</div> <!-- end -->
			<hr class="hr">
				    <div class="clearfix">
				        <div class="w-md-3">
				    		<div class="detailsItems"><a href="{PURL('edit?id=' . $record.id)}">
				    			<i class="icon-store"></i>
				    			<div class="info">店面环境得分：<b class="t-red">{$record.storefen}</b> 分<br>查看更多 ></div></a>
				    		</div>
				    	</div>
				    	<div class="w-md-3">
				    		<div class="detailsItems"><a href="{PURL('from2?id=' . $record.id)}">
				    			<i class="icon-man"></i>
				    			<div class="info">男经纪人得分：<b class="t-red">{$record.manfen}</b> 分<br>女经纪人得分：<b class="t-red">{$record.womanfen}</b> 分</div></a>
				    		</div>
				    	</div>
				    	<div class="w-md-3">
				    		<div class="detailsItems"><a href="{PURL('edit?id=' . $record.id)}">
				    			<i class="icon-main"></i>
				    			<div class="info">总分：<b class="t-red">{$record.totalfen}</b> 分 <br>店名：{$record.name}</div></a>
				    		</div>
				    	</div> 
				    </div> <!-- end -->


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
			$temparr=array();
			$temparr1=array();
			foreach($this->dpinfo as $key =>$value){

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
					$temparr1[$key][$j]=$this->_tpl_vars['dpinfoArr'][$i];
					$j++;
				}

				echo'<div class="clearfix">
					<div class="w-md-15"><div class="FromHd"><span>'.$value['name'].'</span></div></div>

		  	<div class="w-md-85p">';
			foreach($value['arr'] as $vvalue =>$val){

				$temparr2=explode(':',$temparr1[$key][$vvalue]);			

				echo'<div class="checkbox"><label class="w-md-6p">';

					if($temparr2[0]!=0){
						echo '<input checked type="checkbox" class="ace J_checkPrice check_on" id="outarea_'.$key.'_'.$vvalue.'" data-price="'.$val[1].'" value="'.$val[1].'">';
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
						echo '<a href="javascript:;" onclick="Upload(this)" class="J_upload J_uploads_cur" thumb="'.$temparr2[2].'" onmouseover="showImg(this)" onmouseout="hideImg(this)"><i class="icon-pic" ></i></a>';
					}else{
						echo '<a href="javascript:;"  class="J_upload J_upload_no"><i class="icon-camera" title="上传取证图片"></i></a>';
					}
					echo'</div></div>';

			}
			echo'</div></div><hr class="hr">';
			}
		?>
		<div class="clearfix">
		  	<div class="w-md-15">
		  		<div class="FromHd"><span>店铺评价<strong class="count">总得分：<b class="t-red J_CurPirce">{$record.storefen}</b></strong></span></div>
		  	</div>
		  	<input type="hidden" name="score" value="{$record.storefen}" class="J_score">
		  	<div class="w-md-8p">
		  	  <textarea name="dp_desc" class="textarea input-textarea" placeholder="请描述该店面给您的第一印象如何？">{$dpinfoDesc}</textarea>
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

	</div>
</div>


	</form>
</div>


{include footer.tpl}
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

