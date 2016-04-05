$(window).load(function(){
    $('#login #password').focus(function () {
        $('#owl-login').addClass('password');
    }).blur(function () {
        $('#owl-login').removeClass('password');
    });
});

$(document).ready(function () {
   document.onkeydown=function(event){
    var e = event || window.event || arguments.callee.caller.arguments[0];          
    if(e && e.keyCode==13){ // enter key
         submitLogin();
    }
   }; 
    if ($('#submitform')[0].length > 0){
        var cookie = getCookie('user_cookie');
        var url = "get_currentuserinfo.php?cookie="+cookie;
        jQuery.ajax({
            url: url,
            dataType: 'json',
            success: function(results) {
                $('#submitform').append('<input type="hidden" value="'+results["user"]["id"]+'" name="user_id"><input type="hidden" value="'+results["user"]["username"]+'" name="user_name">');
                $('#submitform #user_nickname').val(results["user"]["displayname"]);
                $('#submitform #user_email').val(results["user"]["email"]);
            }
        });
    }
});

$('#login-button').on('click',function(){
    submitLogin();
});

$('#signup-button').on('click',function() {
    signUp();
});

$('#submit-button').on('click',function() {
    submitProject();
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
    url = "generate_auth_cookie.php?username="+username+"&password="+userpass;
    $('#login-button').html('<i class="fa fa-spin fa-spinner"></i>');
    jQuery.ajax({ 
        url: url, 
        dataType: "json", 
        success: function(results) { 
            $('#login-button').html('登');
            if (results["status"] == "ok"){
                setCookie("user_cookie",results["cookie"],60);
                $('p#message').html('<i class="fa fa-check-circle-o"></i> 登录成功！');
                $('p#message').addClass('success');
                $('.overlay').fadeIn();
                setTimeout(function(){
                    $('.overlay').fadeOut();
                    $('p#message').removeClass('error');
                }, 1500);
                setTimeout(function(){
                    window.location.reload();
                },1600);
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

function signUp() {
    var user_cookie = getCookie("user_cookie");
    var user_login = user_cookie.substr(0,user_cookie.indexOf("|"));
    signup_url = "signup_auth.php?user_login="+user_login;
    jQuery.ajax({
        url: signup_url,
        dataType: "text",
        success: function(code) {
            if (code == '2') {
                // Success
                $('p#message').html('<i class="fa fa-check-circle-o"></i> 恭喜，报名成功！记得尽快提交作品哦，祝你第一名');
                $('p#message').addClass('success');
                $('.overlay').fadeIn();
                setTimeout(function(){
                    $('.overlay').fadeOut();
                    $('p#message').removeClass('success');
                }, 2500);
                setTimeout(function(){
                    window.location.reload();
                },2700);
            } else if (code == '1') {
                // Already exists
                $('p#message').html('<i class="fa fa-times-circle-o"></i> 已经报名了！');
                $('p#message').addClass('error');
                $('.overlay').fadeIn();
                setTimeout(function(){
                    $('.overlay').fadeOut();
                    $('p#message').removeClass('error');
                }, 1500);
            } else {
                // Failure
                $('p#message').html('<i class="fa fa-times-circle-o"></i> 服务器出错，稍后重试！');
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

function submitProject() {
    var count = 0;
    $("input").each(function(a,b){
        var id = $(b).attr("id");//获取id属性
        var name = $(b).attr("name");//获取name属性
        var value = $(b).val();
        if(value.length == 0){
            jQuery(this).parent().parent().addClass('has-error');
            var text = jQuery(this).parent().parent().find('label').text();
            jQuery(this).parent().parent().find('label').html('<span>请输入</span>');
            count++;
        }
    });
    if (count > 0){
        return;
    }
    $('.overlay').fadeIn();
    $('p#message').html('<i class="fa fa-spin fa-spinner"></i> 正在提交中...');
    var params = $('#submitform').serialize();
    var full_url = "submit.php?"+params;
    jQuery.ajax({
        url: full_url,
        dataType: 'text',
        success: function(result) {
            if (result == '2'||result == '1'){
                $('p#message').html('<i class="fa fa-check-circle"></i> 作品提交成功！');
                $('p#message').addClass('success');
                setTimeout(function(){
                    $('.overlay').fadeOut();
                },1500);
                setTimeout(function(){
                    window.location.reload();
                },1650);
//            } else if (result == '1') {
//                $('p#message').html('<i class="fa fa-times-circle"></i> 你已经提交过作品了！');
//                $('p#message').addClass('error');
//                setTimeout(function(){
//                    window.location.reload();
//                },1500);
            } else {
                $('p#message').html('<i class="fa fa-times-circle"></i> 服务器出错，稍后重试！');
                $('p#message').addClass('error');
                setTimeout(function(){
                    $('.overlay').fadeOut();
                    $('p#message').removeClass('error');
                },1500);
            }
        }
    });
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
    return "";
}