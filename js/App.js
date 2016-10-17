// TODO;
$(document).ready(function(){
    $(window).on('resize',function(){
    var winWidth =  $(window).width();
    if(winWidth < 768 ){
        document.getElementById('navTab').style.marginTop="105px";
    }else{
        document.getElementById('navTab').style.marginTop="70px";
    }
    });
});
