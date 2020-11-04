function resize_video(obj) {
    $(window).resize(function() {
        var w = $(window).width();
        if (w >= 560) {
            $(obj).width(560).height(315);
        } else {
            $(obj).width(w).height(w*0.563);
        }

    }).resize();
}

$(window).on('load', function(){
    resize_video($('.youtube iframe'));
});
