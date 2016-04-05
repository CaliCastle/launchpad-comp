$(window).load(function () {

    if ($('#competitorSlider').length > 0){
        $('#competitorSlider').flexslider({
            animation: "slide",
            directionNav: false,
            controlNav: true,
            touch: true,
            pauseOnHover: true
        });
        full_url = "get_avatar.php?user_id=";
        $('#competitorSlider .img-circle').each(function(i,e){
            var user_id = jQuery(this).attr('data-id');
            var self = $(this);
            jQuery.ajax({
                url: full_url+user_id,
                context: self,
                dataType: "json",
                success: function(results) {
                    if (results["status"] == "ok"){
                        imageURL = getImageURL(results["avatar"]);
                        self.attr("src",imageURL);
                    }
                }
            });
        });
    } else {
        $('#vote-button').css('display','none');
    }
});

function getImageURL(avatar){
    thumbnailPrefix = "timthumb.php?w=200&h=200&src=";
    if (avatar.indexOf('src=') > 0){
        newURL = avatar.substring(avatar.indexOf('src=')+5,avatar.indexOf('" '));
        return thumbnailPrefix + newURL;
    } else {
        return thumbnailPrefix + avatar;
    }
}

$('#wechat-button').on('click',function() {
    $('#wechat-share').fadeToggle();
    if ($('#wechat-share').hasClass('flipInX')){
        jQuery('#wechat-share').removeClass('flipInX');
        jQuery('#wechat-share').addClass('flipOutX');
    } else {
        jQuery('#wechat-share').addClass('flipInX');
        jQuery('#wechat-share').removeClass('flipOutX');
    }
});