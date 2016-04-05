$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    if(!getCookie("admin_cookie")){
        window.location.href="login.php";
    }
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

function submitLogin() {
    var user_name = jQuery('input#username').val();
    var user_pwd = jQuery('input#password').val();
    if (user_name.length > 0 && user_pwd.length > 0){
        login(user_name,user_pwd);
    } else {
        $('p#message').html('请输入帐号或密码！');
        $('p#message').addClass('error');
        $('.overlay').fadeIn();
        setTimeout(function(){
            $('.overlay').fadeOut();
            $('p#message').removeClass('error');
        }, 1500);
    }
}

function login(username,userpass) {
    url = "../generate_auth_cookie.php?username="+username+"&password="+userpass;
    $('#login-button').html('<i class="fa fa-spin fa-spinner"></i>');
    jQuery.ajax({ 
        url: url, 
        dataType: "json", 
        success: function(results) { 
            $('#login-button').html('登');
            if (results["status"] == "ok"){
                checkAdmin(results["user"]["username"]);
            } else {
                $('p#message').html('<i class="fa fa-times-circle-o"></i> 帐号或密码错误！');
                $('p#message').addClass('error');
                $('.overlay').fadeIn();
                setTimeout(function(){
                    $('.overlay').fadeOut();
                    $('p#message').removeClass('error');
                }, 1500);
            }
        }
    });
}

function checkAdmin(username){
    admin_url = "admindetect.php?username="+username;
    jQuery.ajax({
        url: admin_url,
        dataType: "text",
        success: function(result){
            switch(result){
                case "1":
                    // Success
                    setCookie("admin_cookie",username,360);
                    window.location.href = 'index.php';
                    break;
                case "-1":
                    // Not admin
                    $('p#message').html('<i class="fa fa-times-circle-o"></i> 您无权限！');
                    $('p#message').addClass('error');
                    $('.overlay').fadeIn();
                    setTimeout(function(){
                        $('.overlay').fadeOut();
                        $('p#message').removeClass('error');
                    }, 1500);
                    break;
                case "-2":
                    // Unknown error
                    $('p#message').html('<i class="fa fa-times-circle-o"></i> 未知错误！');
                    $('p#message').addClass('error');
                    $('.overlay').fadeIn();
                    setTimeout(function(){
                        $('.overlay').fadeOut();
                        $('p#message').removeClass('error');
                    }, 1500);
                    break;
            }
        }
    })
}

function setCookie(c_name, value, expiredays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = c_name + "=" + escape(value) +
        ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=")
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1
            c_end = document.cookie.indexOf(";", c_start)
            if (c_end == -1) c_end = document.cookie.length
            return unescape(document.cookie.substring(c_start, c_end))
        }
    }
}

function logout(){
    delCookie("admin_cookie");
    window.location.href = "login.php";
}

function delCookie(name){
   var date = new Date();
   date.setTime(date.getTime() - 10000);
   document.cookie = name + "=a; expires=" + date.toGMTString();
}
