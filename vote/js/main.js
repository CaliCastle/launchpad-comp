
$(window).load(function(){
    if ($('#login').length > 0){
        $('#login #password').focus(function () {
            $('#owl-login').addClass('password');
        }).blur(function () {
            $('#owl-login').removeClass('password');
        });
    }

    full_url = "../get_avatar.php?user_id=";
    $('.preview img').each(function(i,e){
        var user_id = jQuery(this).attr('data-id');
        var self = $(this);
        jQuery.ajax({
            url: full_url+user_id,
            context: self,
            dataType: "json",
            success: function(results) {
                if (results["status"] == "ok"){
                    imageURL = getImageURL(results["avatar"],230);
                    self.attr("src",imageURL);
                }
            }
        });
    });
    $('.content__item-img').each(function(i,e){
        var user_id = jQuery(this).attr('data-id');
        var self = $(this);
        jQuery.ajax({
            url: full_url+user_id,
            context: self,
            dataType: "json",
            success: function(results) {
                if (results["status"] == "ok"){
                    imageURL = getImageURL(results["avatar"],280);
                    self.attr("src",imageURL);
                }
            }
        });
    });
});

$(document).ready(function () {
   document.onkeydown=function(event){
    var e = event || window.event || arguments.callee.caller.arguments[0];          
    if(e && e.keyCode==13){ // enter key
         submitLogin();
    }
   };
    // Query specific
    user_id = window.location.href.split("?id=")[1];
    $('.content__item').each(function(){
        if (jQuery(this).attr('id') == user_id){
            $('.content').addClass('content--open');
            jQuery(this).addClass('content__item--current content__item--reset');
        }
    });
    
});

$('a.weibo-share').on('click',function(){
    u = window.location.href + "?id=" + $('.content__item--current').attr('id');
    n = encodeURIComponent($('.content__item--current h2').text());
    t = encodeURIComponent($('.content__item--current h3').text());
    i = encodeURIComponent($('.content__item--current').attr('id'));
    
    weibo_share_url = "http://service.weibo.com/share/share.php?url="+u+"&title=Abletive首届Launchpad工程大赛"+i+"号选手【"+n+"】的《"+t+"》我很喜欢，大家来给ta投一票吧%20%40Abletive音乐社区%20%23Launchpad大赛%23&appkey=847311452&searchPic=true";
    window.showModalDialog(weibo_share_url,'分享到微博');
});

$('a.qq-share').on('click',function(){
    u = window.location.href + "?id=" + $('.content__item--current').attr('id');
    n = encodeURIComponent($('.content__item--current h2').text());
    t = encodeURIComponent($('.content__item--current h3').text());
    i = encodeURIComponent($('.content__item--current').attr('id'));
    
    qq_share_url = "http://connect.qq.com/widget/shareqq/index.html?url="+u+"&title=给Launchpad工程大赛"+i+"号选手投票&desc=Abletive首届Launchpad工程"+i+"号选手【"+n+"】的《"+t+"》我很喜欢，大家来给ta投一票吧&site=Abletive首届Launchpad工程大赛";
    window.open(qq_share_url);
});

$('a.tieba-share').on('click',function(){
    u = window.location.href + "?id=" + $('.content__item--current').attr('id');
    n = encodeURIComponent($('.content__item--current h2').text());
    t = encodeURIComponent($('.content__item--current h3').text());
    i = encodeURIComponent($('.content__item--current').attr('id'));
    
    tieba_share_url = "http://tieba.baidu.com/f/commit/share/openShareApi?url="+u+"&title=给Launchpad工程大赛"+i+"号选手投票&desc=Abletive首届Launchpad工程"+i+"号选手【"+n+"】的《"+t+"》我很喜欢，大家来给Ta投一票吧";
    window.showModalDialog(tieba_share_url,'分享到贴吧');
});

$('a#wechat-button').on('click',function(){
    wechat_img = jQuery(this).parent().children('img');
 
    wechat_img.fadeToggle();
    if (wechat_img.hasClass('flipInX')){
        wechat_img.removeClass('flipInX');
        wechat_img.addClass('flipOutX');
    } else {
        wechat_img.addClass('flipInX');
        wechat_img.removeClass('flipOutX');
    }
});

function getImageURL(avatar,size){
    thumbnailPrefix = "../timthumb.php?w="+size+"&h="+size+"&src=";
    if (avatar.indexOf('src=') > 0){
        newURL = avatar.substring(avatar.indexOf('src=')+5,avatar.indexOf('" '));
        return thumbnailPrefix + newURL;
    } else {
        return thumbnailPrefix + avatar;
    }
}

$('#login-button').on('click',function(){
    submitLogin();
});

function submitLogin() {
    var user_name = jQuery('input#username').val();
    var user_pwd = jQuery('input#password').val();
    if (user_name.length > 0 && user_pwd.length > 0){
        login(user_name,user_pwd);
    } else {
        showMessage("请输入内容!",1500,'error');
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
                setCookie("user_cookie",results["cookie"],60);
                showMessage('<i class="fa fa-check-circle-o"></i> 登录成功!',1500,'success');
                setTimeout(function(){
                    window.location.reload();
                },1600);
            } else {
                showMessage('<i class="fa fa-times-o"></i> 帐号或密码错误！',1500,'error');
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
(function(window) {

	'use strict';

	var bodyEl = document.body, 
		docElem = window.document.documentElement,
		support = { transitions: Modernizr.csstransitions },
		// transition end event name
		transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		onEndTransition = function( el, callback ) {
			var onEndCallbackFn = function( ev ) {
				if( support.transitions ) {
					if( ev.target != this ) return;
					this.removeEventListener( transEndEventName, onEndCallbackFn );
				}
				if( callback && typeof callback === 'function' ) { callback.call(this); }
			};
			if( support.transitions ) {
				el.addEventListener( transEndEventName, onEndCallbackFn );
			}
			else {
				onEndCallbackFn();
			}
		},
		// window sizes
		win = {width: window.innerWidth, height: window.innerHeight},
		// some helper vars to disallow scrolling
		lockScroll = false, xscroll, yscroll,
		scrollContainer = document.querySelector('.container'),
		// the main slider and its items
		sliderEl = document.querySelector('.slider'),
		items = [].slice.call(sliderEl.querySelectorAll('.slide')),
		// total number of items
		itemsTotal = items.length,
		// navigation controls/arrows
		navRightCtrl = sliderEl.querySelector('.button--nav-next'),
		navLeftCtrl = sliderEl.querySelector('.button--nav-prev'),
		zoomCtrl = sliderEl.querySelector('.button--zoom'),
		// the main content element
		contentEl = document.querySelector('.content'),
		// close content control
		closeContentCtrl = contentEl.querySelector('button.button--close'),
		// index of current item
		current = 0,
		// check if an item is "open"
		isOpen = false,
		isFirefox = typeof InstallTrigger !== 'undefined',
		// scale body when zooming into the items, if not Firefox (the performance in Firefox is not very good)
		bodyScale = isFirefox ? false : 3;

	// some helper functions:
	function scrollX() { return window.pageXOffset || docElem.scrollLeft; }
	function scrollY() { return window.pageYOffset || docElem.scrollTop; }
	// from http://www.sberry.me/articles/javascript-event-throttling-debouncing
	function throttle(fn, delay) {
		var allowSample = true;

		return function(e) {
			if (allowSample) {
				allowSample = false;
				setTimeout(function() { allowSample = true; }, delay);
				fn(e);
			}
		};
	}

	function init() {
		initEvents();
	}

	// event binding
	function initEvents() {
		// open items
		zoomCtrl.addEventListener('click', function() {
			openItem(items[current]);
		});

		// close content
		closeContentCtrl.addEventListener('click', closeContent);

		// navigation
		navRightCtrl.addEventListener('click', function() { navigate('right'); });
		navLeftCtrl.addEventListener('click', function() { navigate('left'); });
        
		// window resize
		window.addEventListener('resize', throttle(function(ev) {
			// reset window sizes
			win = {width: window.innerWidth, height: window.innerHeight};

			// reset transforms for the items (slider items)
			items.forEach(function(item, pos) {
				if( pos === current ) return;
				var el = item.querySelector('.slide__mover');
				dynamics.css(el, { translateX: el.offsetWidth });
			});
		}, 10));

		// keyboard navigation events
		document.addEventListener( 'keydown', function( ev ) {
			var keyCode = ev.keyCode || ev.which;
            if (keyCode == 27 && isOpen)
                closeContent();
            if( isOpen ) return; 
			switch (keyCode) {
				case 37:
					navigate('left');
					break;
				case 39:
					navigate('right');
					break;
                case 13:
                    // details
                    openItem(items[current]);
                    break;
                case 27:
                    // close
                    closeContent();
                    break;
                case 86:
                    // vote
                    showMyModal(items[current]);
                    break;
			}
		} );
	}
    
    $('#vote-button').on('click',function(){
        showMyModal(items[current]);
    });
    
    function showMyModal(item){
        var current_item = item.querySelector('.zoomer');
        var current_name = current_item.getAttribute('data-name');
        var current_id = current_item.getAttribute('data-id');
        setupModal(current_name,current_id);
    }
    
	// opens one item
	function openItem(item) {
		if( isOpen ) return;
		isOpen = true;

		// the element that will be transformed
		var zoomer = item.querySelector('.zoomer');
		// slide screen preview
		classie.add(zoomer, 'zoomer--active');
		// disallow scroll
		scrollContainer.addEventListener('scroll', noscroll);
		// apply transforms
		applyTransforms(zoomer);
		// also scale the body so it looks the camera moves to the item.
		if( bodyScale ) {
			dynamics.animate(bodyEl, { scale: bodyScale }, { type: dynamics.easeInOut, duration: 500 });
		}
		// after the transition is finished:
		onEndTransition(zoomer, function() {
			// reset body transform
			if( bodyScale ) {
				dynamics.stop(bodyEl);
				dynamics.css(bodyEl, { scale: 1 });
				
				// fix for safari (allowing fixed children to keep position)
				bodyEl.style.WebkitTransform = 'none';
				bodyEl.style.transform = 'none';
			}
			// no scrolling
			classie.add(bodyEl, 'noscroll');
			classie.add(contentEl, 'content--open');
			var contentItem = document.getElementById(item.getAttribute('data-content'))
			classie.add(contentItem, 'content__item--current');
			classie.add(contentItem, 'content__item--reset');


			// reset zoomer transform - back to its original position/transform without a transition
			classie.add(zoomer, 'zoomer--notrans');
			zoomer.style.WebkitTransform = 'translate3d(0,0,0) scale3d(1,1,1)';
			zoomer.style.transform = 'translate3d(0,0,0) scale3d(1,1,1)';
		});
	}

	// closes the item/content
	function closeContent() {
		var contentItem = contentEl.querySelector('.content__item--current'),
			zoomer = items[current].querySelector('.zoomer');

		classie.remove(contentEl, 'content--open');
		classie.remove(contentItem, 'content__item--current');
		classie.remove(bodyEl, 'noscroll');
				
		if( bodyScale ) {
			// reset fix for safari (allowing fixed children to keep position)
			bodyEl.style.WebkitTransform = '';
			bodyEl.style.transform = '';
		}

		/* fix for safari flickering */
		var nobodyscale = true;
		applyTransforms(zoomer, nobodyscale);
		/* fix for safari flickering */

		// wait for the inner content to finish the transition
		onEndTransition(contentItem, function(ev) {
			classie.remove(this, 'content__item--reset');
			
			// reset scrolling permission
			lockScroll = false;
			scrollContainer.removeEventListener('scroll', noscroll);

			/* fix for safari flickering */
			zoomer.style.WebkitTransform = 'translate3d(0,0,0) scale3d(1,1,1)';
			zoomer.style.transform = 'translate3d(0,0,0) scale3d(1,1,1)';
			/* fix for safari flickering */
			
			// scale up - behind the scenes - the item again (without transition)
			applyTransforms(zoomer);
			
			// animate/scale down the item
			setTimeout(function() {	
				classie.remove(zoomer, 'zoomer--notrans');
				classie.remove(zoomer, 'zoomer--active');
				zoomer.style.WebkitTransform = 'translate3d(0,0,0) scale3d(1,1,1)';
				zoomer.style.transform = 'translate3d(0,0,0) scale3d(1,1,1)';
			}, 25);

			if( bodyScale ) {
				dynamics.css(bodyEl, { scale: bodyScale });
				dynamics.animate(bodyEl, { scale: 1 }, {
					type: dynamics.easeInOut,
					duration: 500
				});
			}

			isOpen = false;
		});
	}

	// applies the necessary transform value to scale the item up
	function applyTransforms(el, nobodyscale) {
		// zoomer area and scale value
		var zoomerArea = el.querySelector('.zoomer__area'), 
			zoomerAreaSize = {width: zoomerArea.offsetWidth, height: zoomerArea.offsetHeight},
			zoomerOffset = zoomerArea.getBoundingClientRect(),
			scaleVal = zoomerAreaSize.width/zoomerAreaSize.height < win.width/win.height ? win.width/zoomerAreaSize.width : win.height/zoomerAreaSize.height;

		if( bodyScale && !nobodyscale ) {
			scaleVal /= bodyScale; 
		}

		// apply transform
		el.style.WebkitTransform = 'translate3d(' + Number(win.width/2 - (zoomerOffset.left+zoomerAreaSize.width/2)) + 'px,' + Number(win.height/2 - (zoomerOffset.top+zoomerAreaSize.height/2)) + 'px,0) scale3d(' + scaleVal + ',' + scaleVal + ',1)';
		el.style.transform = 'translate3d(' + Number(win.width/2 - (zoomerOffset.left+zoomerAreaSize.width/2)) + 'px,' + Number(win.height/2 - (zoomerOffset.top+zoomerAreaSize.height/2)) + 'px,0) scale3d(' + scaleVal + ',' + scaleVal + ',1)';
	}

	// navigate the slider
	function navigate(dir) {
		var itemCurrent = items[current],
			currentEl = itemCurrent.querySelector('.slide__mover'),
			currentTitleEl = itemCurrent.querySelector('.slide__title');

		// update new current value
		if( dir === 'right' ) {
			current = current < itemsTotal-1 ? current + 1 : 0;
		}
		else {
			current = current > 0 ? current - 1 : itemsTotal-1;
		}

		var itemNext = items[current],
			nextEl = itemNext.querySelector('.slide__mover'),
			nextTitleEl = itemNext.querySelector('.slide__title');
		
		// animate the current element out
		dynamics.animate(currentEl, { opacity: 0, translateX: dir === 'right' ? -1*currentEl.offsetWidth/2 : currentEl.offsetWidth/2, rotateZ: dir === 'right' ? -10 : 10 }, {
			type: dynamics.spring,
			duration: 2000,
			friction: 600,
			complete: function() {
				dynamics.css(itemCurrent, { opacity: 0, visibility: 'hidden' });
			}
		});

		// animate the current title out
		dynamics.animate(currentTitleEl, { translateX: dir === 'right' ? -250 : 250, opacity: 0 }, {
			type: dynamics.bezier,
			points: [{"x":0,"y":0,"cp":[{"x":0.2,"y":1}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
			duration: 450
		});

		// set the right properties for the next element to come in
		dynamics.css(itemNext, { opacity: 1, visibility: 'visible' });
		dynamics.css(nextEl, { opacity: 0, translateX: dir === 'right' ? nextEl.offsetWidth/2 : -1*nextEl.offsetWidth/2, rotateZ: dir === 'right' ? 10 : -10 });

		// animate the next element in
		dynamics.animate(nextEl, { opacity: 1, translateX: 0 }, {
			type: dynamics.spring,
			duration: 2000,
			friction: 600,
			complete: function() {
				items.forEach(function(item) { classie.remove(item, 'slide--current'); });
				classie.add(itemNext, 'slide--current');
			}
		});

		// set the right properties for the next title to come in
		dynamics.css(nextTitleEl, { translateX: dir === 'right' ? 250 : -250, opacity: 0 });
		// animate the next title in
		dynamics.animate(nextTitleEl, { translateX: 0, opacity: 1 }, {
			type: dynamics.bezier,
			points: [{"x":0,"y":0,"cp":[{"x":0.2,"y":1}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
			duration: 650
		});
	}

	// disallow scrolling (on the scrollContainer)
	function noscroll() {
		if(!lockScroll) {
			lockScroll = true;
			xscroll = scrollContainer.scrollLeft;
			yscroll = scrollContainer.scrollTop;
		}
		scrollContainer.scrollTop = yscroll;
		scrollContainer.scrollLeft = xscroll;
	}

	init();

})(window);

var vote_to = new String();

function setupModal(name,id){
    vote_to = id;
    $('p#message').html('<i class="fa fa-info"></i> 确定要投给'+name+'吗?');
    $('p#message').append('<a href="#" id="cancel-btn" onclick="dismissModal()">放弃</a><a href="#" id="confirm-btn" onclick="confirmVote()">确定</a>');
    $('.overlay').fadeIn();
}

function dismissModal(){
    $('.overlay').fadeOut();
    setTimeout(function(){
        $('p#message').html('');
        $('.message-box a').remove();
    },500);
}

function confirmVote(){
    $('.overlay').hide();
    $('p#message').html('');
    $('.message-box a').remove();
    vote();
}

function showMessage(message,dismissTime,color){
    $('p#message').html(message);
    $('p#message').addClass(color);
    $('.overlay').fadeIn();
    setTimeout(function(){
        $('.overlay').fadeOut();
        $('p#message').removeClass(color);
    }, dismissTime);
}

function vote() {
    var my_name = getCookie('user_cookie');
    my_name = my_name.substring(0,my_name.indexOf('|'));

    var vote_url = "vote.php?from="+my_name+"&to="+vote_to;

    jQuery.ajax({
        url: vote_url,
        dataType: "text",
        success: function (result) {
            switch(result){
                case "1":
                    // Success
                    showMessage('<i class="fa fa-check-circle-o"></i> 投票成功',1500,'success');
                    addVoteNum();
                    break;
                case "-1":
                    // Database insert error
                    showMessage('<i class="fa fa-times-o"></i> 投票失败，请重试',1500,'error');
                    break;
                case "-2":
                    // Vote has reached 3 (Maximum)
                    showMessage('<i class="fa fa-times-o"></i> 您不能再投了',1500,'error');
                    break;
                case "-3":
                    // No such item
                    showMessage('<i class="fa fa-times-o"></i> 你在搞笑吧',1500,'error');
                    break;
                default:
                    showMessage('<i class="fa fa-times-o"></i> 投票失败，请重试',1500,'error');
                    break;
            }
        }
    });
}

function addVoteNum(){
    var votes = $('b#current-votes').text();
    votes++;
    $('b#current-votes').text(votes);
    
    $('.slide').each(function(i,e){
        var data_id = jQuery(this).attr('data-content');
        if (data_id == vote_to){
            var text = jQuery(this).find('.slide__title b').text();
            text++;
            jQuery(this).find('.slide__title b').text(text);
        }
    });
}