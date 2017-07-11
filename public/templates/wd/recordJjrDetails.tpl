{include header.tpl}
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
            	<input type="text"  name="dpno" class="input-text" value="{$record.dp_no}" readonly>
            </div>
			<div class="form-items">
				<span class="input-group-addon">营销大区</span>
				<input type="text" class="input-text" value="{echo areaType($record.yx_catid)}" readonly>
			</div>
			<div class="form-items">
            	<span class="input-group-addon">业务区域</span>
            	<input type="text" class="input-text" value="{echo areaType($record.qy_catid)}" readonly>
            </div>				
			<div class="form-items">
				<span class="input-group-addon">店面名称</span>
				<input type="text" class="input-text" value="{$record.name}" readonly>
			</div>
            <div class="form-items">
				<span class="input-group-addon">店面地址</span>
				<input type="text" class="input-text" value="{$record.address}"  readonly title="{$record.address}">
			</div>				
        </div>
        <div class="w-md-3_5p">            	                
            <div class="form-items">
            	<span class="input-group-addon">走访日期</span>
            	<input type="text" class="input-text" value="{echo DisplayDate($record.zftime)}" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">走访时间</span>
            	<input type="text" class="input-text" value="{$record.zfintime}" readonly style="width:41%"> ~ <input type="text" class="input-text" value="{$record.zfouttime}" readonly style="width:41%">	
            </div>
            <div class="form-items">
            	<span class="input-group-addon">审核经纪人数量</span>
            	<input type="text" class="input-text" value="{$record.check_num}" readonly style="width:73%">
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店内顾客人数量</span>
            	<input type="text" class="input-text" value="{$record.gk_num}" readonly style="width:73%">
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店内经纪人数量</span>
            	<input type="text" class="input-text" value="{$record.jj_num}" readonly style="width:74%">
            </div>
        </div>
        <div class="w-md-30p">
        	<div class="form-items">
            	<span class="input-group-addon">男经纪人得分</span>
            	<input type="text" class="input-text" value="{$record.manfen}" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">女经纪人得分</span>
            	<input type="text" class="input-text" value="{$record.womanfen}" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店面环境得分</span>
            	<input type="text" class="input-text" value="{$record.storefen}" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">店铺总体得分</span>
            	<input type="text" class="input-text" value="{$record.totalfen}" readonly>
            </div>
            <div class="form-items">
            	<span class="input-group-addon">审计员姓名：</span>
            	<input type="text" class="input-text" value="{$record.zfuser}" readonly>
            </div>
        </div>
    </div> <!-- form-horizontal end -->
    <hr class="hr">
    <div class="clearfix">
        <div class="w-md-3">
    		<div class="detailsItems"><a href="{PURL('record?id=' . $record.id.'&show=1')}">
    			<i class="icon-store"></i>
    			<div class="info">店面环境得分：<b class="t-red">{$record.storefen}</b> 分<br>查看更多 ></div></a>
    		</div>
    	</div>
    	<div class="w-md-3">
    		<div class="detailsItems"><a href="{PURL('record?id=' . $record.id.'&show=2')}">
    			<i class="icon-man"></i>
    			<div class="info">男经纪人得分：<b class="t-red">{$record.manfen}</b> 分<br>女经纪人得分：<b class="t-red">{$record.womanfen}</b> 分</div></a>
    		</div>
    	</div>
    	<div class="w-md-3">
    		<div class="detailsItems"><a href="{PURL('record?id=' . $record.id)}">
    			<i class="icon-main"></i>
    			<div class="info">总分：<b class="t-red">{$record.totalfen}</b> 分 <br>店名：{$record.name}</div></a>
    		</div>
    	</div> 
    </div> <!-- end -->
    <hr class="hr">
    <h2 class="spreadHd">店铺经纪人列表</h2>
    <div class="User clearfix">
    {if !$jjr_info}
		<div class="NoInfo">暂时还没有相关经纪人信息！</div>
    {else}
    	{foreach $jjr_info AS $rs}
    	  
    	  <div class="w-md-4">
    	  	<a class="info {if $rs.id==$cur_jjr.id}infoCur{/if} " href="{PURL('record?id=' . $record.id.'&show=2&jjr='.$rs.id)}" title="点我查看～">
          	    {if $rs.type==0}<i class="icon-man"></i>{else}<i class="icon-woman"></i>{/if}
          		<div class="userInfo"><strong>姓名：</strong>{$rs.username}<span class="t-green">（{$rs.level}）</span><br>电话：<span class="t-green">{$rs.mobile}</span> <br>工号：<span class="t-green">{$rs.no}</span></div>
          	</a>
          </div>          	
        {/foreach}
    {/if}
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


<div class="spread2">
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
	                <span class="input-group-addon">姓名</span><input type="text" class="input-text" value="{$cur_jjr.username}" readonly>
	            </div>
            </div>	            
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">电话</span><input type="text" class="input-text"  value="{$cur_jjr.mobile}" readonly>      
	            </div>
            </div>
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">工号</span><input type="text" class="input-text"  value="{$cur_jjr.no}" readonly>
	            </div>
            </div>
            <div class="w-md-4">
            	<div class="form-items">
	                <span class="input-group-addon">级别</span><input type="text" class="input-text" value="{$cur_jjr.level}" readonly>
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
 						 echo '<div class="Checkbox Checkboxed ace"></div>';
 					}else{
 						 echo '<div class="Checkbox ace"></div>';
 					}
 					echo '<span class="lbl">'.$val[0].'</span></label>

 					<span class="w-md-08p tac t-red">'.$val[1].'分</span>
 					<input type="text" class="input-text input-text-min J_defen w-md-06p tac" readonly name="outarea[]" value="'.$temparr2[0].'" readonly>
                    <input type="text" name="outarea_r[]" class="input-text input-text-min w-md-15 m01p" value="'.$temparr2[1].'" readonly>


                    <div class="w-md-08p tac">
					 	<input type="hidden" name="outarea_w[]" class="J_lostpic" value="'.$temparr2[2].'">';

					 	if($temparr2[2]){
						    echo'<a rel="fancybox-button" href="'.$temparr2[2].'" title="'.$temparr2[1].' - 扣分取证" class="J_upload J_fancybox" thumb="'.$temparr2[2].'" onmouseover="showImg(this)" onmouseout="hideImg(this)">
						 	<i class="icon-pic"></i></a>';					 
					 	}else{
							echo'<a href="javascript:;" class="J_upload_no"><i class="icon-camera"></i></a>';
					 	}
					 	
					echo'</div></div>';
			}
			echo'</div></div><hr class="hr">';
			}
		?>
		<div class="clearfix">
		  	<div class="w-md-4"><div class="FromHd"><span>您对此名经纪人第一印象<strong class="count">总得分：<b class="t-red J_CurPirce">{$cur_jjr.score}</b></strong></span></div></div>
		  	<input type="hidden" name="score" value="{$cur_jjr.score}" class="J_score">
		  	<div class="w-md-7_5p">
		  	  <textarea name="impressions" class="textarea input-textarea" placeholder="请描述该经纪人给您的第一印象如何？"  readonly>{$cur_jjr.impressions}</textarea>
		  	  <p class="tipsMsg">请描述该经纪人给您的第一印象如何？您觉得他的仪容仪表专业程度如何？哪些环节表现优秀？哪些环节需要改善？</p>
		  	</div>
		</div>
		  <hr class="hr">
		  <div class="clearfix">
		  	<div class="w-md-4">
		  		<div class="FromHd"><span>举例说明</span><input type="text" class="input-text input-text-descscore" value="{$cur_jjr.descscore}" readonly></div>
		  	</div>
		  	<div class="w-md-7_5p">
		  	  <textarea class="textarea input-textarea" placeholder="那么请您描述此名经纪人哪些方面不符合商务人士的形象"  readonly>{$cur_jjr.exinfo}</textarea>
		  	  <p class="tipsMsg"> 针对此名经纪人，您是否认为他符合链家经纪人商务人士的形象定位呢？<br>（回答1-7分询问）那么请您描述此名经纪人哪些方面不符合商务人士的形象（至少列举1点）<br>（回答8-10分询问）那么请您描述此名经纪人哪些方面符合商务人士的形象（至少列举1点）</p>
		  	</div>
		  </div>
	  </div> <!-- spread end --> 

	</div>
</div>

{include footer.tpl}
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
