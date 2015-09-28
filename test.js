$("textarea").mousemove(function(e) {
    var myPos = $(this).offset();
    myPos.bottom = $(this).offset().top + $(this).outerHeight();
    myPos.right = $(this).offset().left + $(this).outerWidth();
    
    if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16) {
        $(this).addClass('resize');
    }
    else {
        $(this).removeClass('resize');
    }
});