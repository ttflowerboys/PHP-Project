/********** 所有ajaxForm提交 ************/
/* 通用表单不带检查操作，失败不跳转 */
$(function () {
    $('.ajaxForm').ajaxForm({
        success: complete2, // 这是提交后的方法
        dataType: 'json'
    });
});
/* 通用表单不带检查操作，失败跳转 */
$(function () {
    $('.ajaxForm2').ajaxForm({
        success: complete, // 这是提交后的方法
        dataType: 'json'
    });
});
/* 通用含验证码表单不带检查操作，失败不跳转 */
$(function () {
    $('.ajaxForm3').ajaxForm({
        success: complete3, // 这是提交后的方法
        dataType: 'json'
    });
});


//失败跳转
function complete(data) {
    if (data.status == 1) {
        layer.alert(data.info, {icon: 6}, function (index) {
            layer.close(index);
            window.location.href = data.url;
        });
    } else {
        layer.alert(data.info, {icon: 5}, function (index) {
            layer.close(index);
            window.location.href = data.url;
        });
        return false;
    }
}
//失败不跳转
function complete2(data) {
    if (data.status == 1) {
        layer.alert(data.info, {icon: 6}, function (index) {
            layer.close(index);
            window.location.href = data.url;
        });
    } else {
        layer.alert(data.info, {icon: 5}, function (index) {
            layer.close(index);
        });
    }
}
//失败不跳转,验证码刷新
function complete3(data) {
    if (data.status == 1) {
        window.location.href = data.url;
    } else {
        $("#veriCode").val('');
        $("#verify_img").click();
        layer.msg(data.info);
    }
}


  function loginout(url){
    layer.confirm('您确定要退出系统吗？', {icon: 3,btn: ['确定','取消']}, function(){
      $.post(url, function(data) {
        var data ={"info":"\u9000\u51fa\u6210\u529f\uff01","url":"\/index.php\/login","status":1};
        if (data.status==1) {
            layer.msg(data.info, {icon: 1},function(){
                window.location.href=data.url;
            });
        }
      });      
    });
  }


$(function(){
    
    $(".upBox").on("click",".J_checkPrice",function(){

        var $this = $(this),allPriceValue = 0;

        if ($this.hasClass("check_on")) {
            // 失分
            $this.removeClass("check_on");
            var checkbox = $this.closest(".checkbox");
            checkbox.find('.J_defen').val(0).removeClass("t-green");
            checkbox.find('.J_lostmsg').removeAttr("readonly");
            checkbox.find('.J_lostpic').val('');
            checkbox.find('.J_upload').removeAttr('onmouseover onmouseout thumb');
            checkbox.find('.J_upload').attr({'class':'J_upload','onclick':'Upload(this)'});
        }else{
            $this.addClass("check_on");
            var checkbox = $this.closest(".checkbox");
            checkbox.find('.J_defen').val($this.data('price')).addClass("t-green");
            checkbox.find('.J_lostmsg').val('').attr('readonly','readonly');
            checkbox.find('.J_lostpic').val('');
            checkbox.find('.J_upload').children('i').attr({'class':'icon-camera','title':'图片上传成功，点我重新上传'});
            checkbox.find('.J_upload').removeAttr('onmouseover onmouseout thumb');
            checkbox.find('.J_upload').attr({'class':'J_upload J_upload_no','onclick':'return false'});
            
        }

        $this.closest(".upBox").find(".check_on").each(function(){

            allPriceValue += parseFloat($(this).data('price'));

        });

        $this.closest(".upBox").find(".J_score").val(allPriceValue);
        $this.closest(".upBox").find(".J_CurPirce").text(allPriceValue);

    });

    $(".J_zfuser").on('click',function(){
        $("#tipsInfo").show();
    })
})


// 表单上传

function Upload(obj){
    $('body').find('.J_upload').removeClass('J_uploads_cur');
    $(obj).addClass('J_uploads_cur');
    $('#fileupload').trigger('click');

    'use strict';
    var url = '/upload/201703/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) { // 上传成功后
            $(".J_uploads_cur").prev('.J_lostpic').val(data.result.files[0].url);
            $(".J_uploads_cur").children('i').attr({'class':'icon-pic'});
            $(".J_uploads_cur").children('i').removeAttr('title');
            $(".J_uploads_cur").attr({'class':'J_upload J_uploads_cur','onclick':'Upload(this)','onmouseover':'showImg(this)','onmouseout':'hideImg(this)','thumb':data.result.files[0].url});
            $('#uploadUI').hide();
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#uploadUI').show();
            $('#uploadUI .progress').text(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

}


function showImg(_this) {   
    var thumb = $(_this).attr('thumb');
    if (!thumb) {
        return false
    }
    $("body").append("<div id='Previewthumb' style='position: absolute; z-index:2; '><img src=" + thumb + " style='width:100px;min-width:100px;border:1px solid #00d49a;'></div>");
    $(_this).mousemove(function(e) {
        $("#Previewthumb").css({
            "top": (e.pageY + 20) + "px",
            "left": (e.pageX -50) + "px"
        })
    })
}
function hideImg(_this) {
    $("#Previewthumb").remove()
}
    