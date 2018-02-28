$(document).ready(function () {
    
    $(document).on('scroll', function () {
        var scroll = $(document).scrollTop();
        if (scroll >= 150) {
            $(".header").addClass("header2");
        }
        else {
            $(".header").removeClass("header2");
        }
    });


    $(".bookingJS").focus(function () {
        $(this).parent().addClass("bookingJS2");
    });
    $(".loginBtn").click(function () {
        $(".login-container").addClass("login-container2");
        $(".bodyBlur").addClass("bodyBlur2")
    });
    $(".loginclose").click(function () {
            $(".login-container").removeClass("login-container2");
    $(".bodyBlur").removeClass("bodyBlur2");
    });
    $(".bodyBlur").click(function () {
            $(".login-container").removeClass("login-container2");
    $(".bodyBlur").removeClass("bodyBlur2");
    });
    mobileBanner();

});
$(window).resize(function () {
    mobileBanner();
     removeActiveLogin();    
});

$(window).scroll(function () {
    removeActiveLogin();
});

function removeActiveLogin(){
    var vw = $(window).width();
    if ( vw >= 768 ){
         $(".login-container").removeClass("login-container2");
    $(".bodyBlur").removeClass("bodyBlur2");
    }
}





function mobileBanner() {
    var windowW = $(window).width();
    var headerH = $(".header").height();
    if (windowW <= 767) {
        $(".banner-section ").css("margin-top", headerH);
    }
    else {
        $(".banner-section ").css("margin-top", 0);
    }
}