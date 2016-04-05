$('a#del-button').on('click',function(){
    setupModal(jQuery(this).attr('data-id'));
});

$('a#user-del-button').on('click',function(){
    setupUserModal(jQuery(this).attr('data-id'));
});

$('a#vote-del-button').on('click',function(){
    setupVoteModal(jQuery(this).attr('data-id'));
});

function setupModal(id){
    $('p#message').html('<i class="fa fa-info"></i> 确定要删除#'+id+'吗?');
    $('p#message').append('<a href="#" id="cancel-btn" onclick="dismissModal()">放弃</a><a href="#" id="confirm-btn" onclick="confirmDel('+id+')">确定</a>');
    $('.overlay').fadeIn();
}

function setupUserModal(id){
    $('p#message').html('<i class="fa fa-info"></i> 确定要删除#'+id+'吗?');
    $('p#message').append('<a href="#" id="cancel-btn" onclick="dismissModal()">放弃</a><a href="#" id="confirm-btn" onclick="confirmUserDel('+id+')">确定</a>');
    $('.overlay').fadeIn();
}

function setupVoteModal(id){
    $('p#message').html('<i class="fa fa-info"></i> 确定要删除该投票吗?');
    $('p#message').append('<a href="#" id="cancel-btn" onclick="dismissModal()">放弃</a><a href="#" id="confirm-btn" onclick="confirmVoteDel('+id+')">确定</a>');
    $('.overlay').fadeIn();
}

function dismissModal(){
    $('.overlay').fadeOut();
    setTimeout(function(){
        $('p#message').html('');
        $('.message-box a').remove();
    },500);
}

function confirmDel(id){
    deleteRow(id);
}

function confirmUserDel(id){
    deleteUser(id);
}

function confirmVoteDel(id){
    deleteVote(id);
}

function deleteRow(id){
    var url = "delRow.php?id="+id;
    jQuery.ajax({
        url: url,
        dataType: "text",
        success: function(result){
            if (result == "1"){
                showMessageBox('<i class="fa fa-check-o"></i> 删除成功！',1500,'success');
                sel = 'tr#row-'+id;
                $(sel).fadeOut();
            } else {
                showMessageBox('<i class="fa fa-times-circle-o"></i> 删除失败！',1500,'error');
            }
        }
    });
}

function deleteUser(id){
    var delete_url = "deleteUser.php?id="+id;
    jQuery.ajax({
        url: delete_url,
        dataType: "text",
        success: function(result){
            if (result == "1"){
                showMessageBox('<i class="fa fa-check-o"></i> 删除成功！',1500,'success');
                sel = 'tr#row-'+id;
                $(sel).fadeOut();
            } else {
                showMessageBox('<i class="fa fa-times-circle-o"></i> 删除失败！',1500,'error');
            }
        }
    });
}

function deleteVote(id){
    var delete_url = "deleteVote.php?id="+id;
    jQuery.ajax({
        url: delete_url,
        dataType: "text",
        success: function(result){
            if (result == "1"){
                showMessageBox('<i class="fa fa-check-o"></i> 删除成功！',1500,'success');
                sel = 'tr#row-'+id;
                $(sel).fadeOut();
            } else {
                showMessageBox('<i class="fa fa-times-circle-o"></i> 删除失败！',1500,'error');
            }
        }
    });
}

function addUser(){
    $('tbody').append('<tr class="warning"><th></th><th><input type="text" value="" placeholder="用户名..." class="col-lg-12" id="user_login" autofocus></th><th><a class="btn btn-warning" id="confirm-add-button" onclick="confirmAddAdmin()">确定</a></th></tr>');
    $('a#add-admin').fadeOut();
}

function confirmAddAdmin(){
    var user_login = $('input#user_login').val();
    if (user_login.length == 0){
        return;
    }
    full_url = "addAdmin.php?user_login="+user_login;
    
    jQuery.ajax({
        url: full_url,
        dataType: "text",
        success: function(result){
            switch(result){
                case "1":
                    showMessageBox('<i class="fa fa-check-o"></i> 添加成功！',1500,'success',function(){window.location.reload()});
                    break;
                case "-1":
                    showMessageBox('<i class="fa fa-times-circle-o"></i> 添加重复！',1500,'error');
                    break;
                default:
                    showMessageBox('<i class="fa fa-frown-o"></i> 未知错误，重试',1500,'error');
                    break;
            }
        }
    })
}

function showMessageBox(message,time,className,callback){
    $('p#message').html(message);
    $('p#message').addClass(className);
    $('.overlay').fadeIn();
    setTimeout(function(){
        $('.overlay').fadeOut();
        $('p#message').removeClass(className);
        if (callback)
            callback();
    }, time);
}