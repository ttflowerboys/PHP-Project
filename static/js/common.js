$(function(){
    $('.banner').slide({'autoPlay':true,'autoPage':true})
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $(this).closest('li').addClass('cur').siblings().removeClass('cur')
                $('html,body').animate({ scrollTop: target.offset().top    }, 1000);
                return false;
            }
        }
    });
    $("#scrollToTop").on("click",function(){
        $("html,body").animate({scrollTop:0},1000);
    })

    $('[data-fn=checkColNum]').each(function(){
        $(this).addClass('col-'+ checkColNum())
    })
})




Fixed()
$(window).scroll(function(){
    Fixed()
})
/* 导航固定 */
function Fixed(){
    if ($(window).scrollTop()>488){
        $('.subColumn').addClass('subColumnFixed')
    }else{
        $('.subColumn').removeClass('subColumnFixed')
    }
}

function formatTitle(str,length){
    var length = length ? length : 4;
    var l = str.length;
    var title = l>length ?(str.substring(0,l-4)+'<br>'+str.substring(l-4,l)) : str;
    return title;
}

function checkColNum(obj,childElm){
    var obj = obj ? obj : $('[data-fn=checkColNum]');
    child = childElm ? childElm : 'li';
    return obj.children(child).length;
}
