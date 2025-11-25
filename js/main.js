const mql = window.matchMedia('(min-width: 641px)');
const pcNavHeight = 80;
const spNavHeight = 105;
const handleMediaQuery = function(mql) {
  if (mql.matches) {
    // 641px以上の場合の処理
    /******************************
    アンカーリンク（外部からのアンカーリンク）
    ******************************/
    // DOMの全てが読み込まれてから0.2秒後に実行
    $(window).on('load',function(){
      var urlHash = location.hash;
      if(urlHash) {
        $('body,html').stop().scrollTop(0);
        setTimeout(function(){
          var target = $(urlHash);
          var position = target.offset().top - pcNavHeight;
          $('body,html').stop().animate({scrollTop:position}, 500);
          return false;
        }, 200);
      }
    });

    /******************************
    アンカーリンク
    ******************************/
    $(function () {
      $('[href^="#"]').click(function(){
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top- pcNavHeight;
        $("html, body").animate({scrollTop:position}, 600, "swing");
        return false;
      });
    });
    
  $(function () {
    // ナビにマウスオーバーした時の演出用
    $("nav li").hover(
      function () {
        $(this).addClass("active");
      },
      function () {
        $(this).removeClass("active");
    });
  });
  } else {
    // 641px未満の場合の処理

    /******************************
    アンカーリンク（外部からのアンカーリンク）
    ******************************/
    // DOMの全てが読み込まれてから0.2秒後に実行
    $(window).on('load',function(){
      var urlHash = location.hash;
      if(urlHash) {
        $('body,html').stop().scrollTop(0);
        setTimeout(function(){
          var target = $(urlHash);
          var position = target.offset().top - spNavHeight;
          $('body,html').stop().animate({scrollTop:position}, 500);
          return false;
        }, 200);
      }
    });

    /******************************
    アンカーリンク
    ******************************/
    $(function () {
      $('[href^="#"]').click(function(){
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top- spNavHeight;
        $("html, body").animate({scrollTop:position}, 600, "swing");
        return false;
      });
    });

  
  }
};

mql.addListener(handleMediaQuery);
handleMediaQuery(mql);

/******************************
 同ページ内のリンクの場合
******************************/
$(function() {
  $('.innerNav a').click(function () {
    var targetLink = $(this).attr('href');
    var linkHash = targetLink.indexOf('#');
    if (linkHash) {
      var targetURL = targetLink.split('#');
      var nowPageURL = location.pathname;
      nowPageURL = nowPageURL.split('/');
      if (targetURL[0] == nowPageURL.pop() ) {
        var position = $('#' + targetURL[1]).offset().top- spNavHeight;
        $("html, body").animate({scrollTop:position}, 600, "swing");
        return false;
      }
    }
  })
});

/******************************
target="_blank"のリンクにrel="noopener"を付与
******************************/
window.addEventListener('DOMContentLoaded', function(){
// ページにあるa要素から「target=_blank」が設定された要素を取得
var a_elements = document.querySelectorAll("a[target=_blank]");
for(var i=0; i<a_elements.length; i++) {
	// rel属性を設定
	a_elements[i].setAttribute("rel","noopener");
}

});
/******************************
telリンク処理
******************************/
$(function() {
  var ua = navigator.userAgent.toLowerCase();
  var isMobile = /iphone/.test(ua)||/android(.+)?mobile/.test(ua);

  if (!isMobile) {
    $('a[href^="tel:"]').on('click', function(e) {
      e.preventDefault();
    });
  }
});
/******************************
pagetop
******************************/
$(function () {
	var topBtn = $('.pagetop img, .pagetop span');
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
	//スクロールしてトップ
	topBtn.click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
	});
});
/******************************
fixHeader
******************************/
$(function () {
	var $nav = $('.nav_wrap'),
			navHead = $nav.offset().top;
	$(window).on("scroll", function () {
			//scrollTopの値の分スクロールしたらナビに.fixedが追加される。
			if ($(this).scrollTop() > navHead) {
					$nav.addClass('fixed');
                    $('header').addClass('fixed');
			} else {
					$nav.removeClass('fixed');
                    $('header').removeClass('fixed');
			}
	});
});
/******************************
slideNavi
******************************/
$(function () {
	//メニューの開閉
	$(document).on('click', '.btn_tgl_menu', function(){
		$('.btn_tgl_menu').toggleClass('active');
		$('body').toggleClass('nav-open')
	});

	// メニュー外をタップした時に閉じる
	$('.nav_overlay').on('click', function(){
		$('.btn_tgl_menu').toggleClass('active');
		$('body').toggleClass('nav-open')
	});

	// ナビにマウスオーバーした時の演出用
  $(function () {
    if(window.matchMedia("(min-width:641px)").matches){
      $("nav li").hover(
        function () {
          $(this).addClass("active");
        },
        function () {
          $(this).removeClass("active");
      });
    }else{
      return false;
    }
  });

	// スマホ表示のメガメニューをタップして展開
	$('.nav_mega_menu').on('click', function () {
		var parent_menu = $(this);
    if(window.matchMedia("(min-width:641px)").matches){
      return;
    }else{
      parent_menu.children(".child_menu").slideToggle(300, function () {
        if ($(this).is(':hidden')) {
          parent_menu.removeClass("active");
        } else {
          parent_menu.addClass("active");
        }
      });
    }
	});
});
	// ページロード時はナビのスライドメニューを非表示。読み込みが終わったら解除
	$('.mega_menu_wrap').hide();
	$('.nav_single_menu div').hide();
$(function () {
	$(document).ready(function(){
		if(window.matchMedia("(min-width:641px)").matches){
			setTimeout(function(){
				$('.mega_menu_wrap').show();
				$('.nav_single_menu div').show();
			},500);
		}else{
			$('.nav_single_menu div').show();
			return false;
		}
	});

	// リンクをタップしたらナビを閉じる（スマホ）
	$('.tgl_menu_list a').on('click' , function(){
		$('.btn_tgl_menu').toggleClass('active');
		$('body').toggleClass('nav-open')
	});
});
/******************************
Q&A
******************************/
$(function () {
	$('.js-toggle dt').click(function () {
    $(this).toggleClass('is-open');
		$(this).next('.js-toggle dd').slideToggle();
	});
});
/******************************
echo.js
******************************/
!function(t,e){"function"==typeof define&&define.amd?define(function(){return e(t)}):"object"==typeof exports?module.exports=e:t.echo=e(t)}(this,function(t){"use strict";var e,n,o,r,c,a={},u=function(){},d=function(t){return null===t.offsetParent},l=function(t,e){if(d(t))return!1;var n=t.getBoundingClientRect();return n.right>=e.l&&n.bottom>=e.t&&n.left<=e.r&&n.top<=e.b},i=function(){(r||!n)&&(clearTimeout(n),n=setTimeout(function(){a.render(),n=null},o))};return a.init=function(n){n=n||{};var d=n.offset||0,l=n.offsetVertical||d,f=n.offsetHorizontal||d,s=function(t,e){return parseInt(t||e,10)};e={t:s(n.offsetTop,l),b:s(n.offsetBottom,l),l:s(n.offsetLeft,f),r:s(n.offsetRight,f)},o=s(n.throttle,250),r=n.debounce!==!1,c=!!n.unload,u=n.callback||u,a.render(),document.addEventListener?(t.addEventListener("scroll",i,!1),t.addEventListener("load",i,!1)):(t.attachEvent("onscroll",i),t.attachEvent("onload",i))},a.render=function(n){for(var o,r,d=(n||document).querySelectorAll("[data-echo], [data-echo-background]"),i=d.length,f={l:0-e.l,t:0-e.t,b:(t.innerHeight||document.documentElement.clientHeight)+e.b,r:(t.innerWidth||document.documentElement.clientWidth)+e.r},s=0;i>s;s++)r=d[s],l(r,f)?(c&&r.setAttribute("data-echo-placeholder",r.src),null!==r.getAttribute("data-echo-background")?r.style.backgroundImage="url("+r.getAttribute("data-echo-background")+")":r.src!==(o=r.getAttribute("data-echo"))&&(r.src=o),c||(r.removeAttribute("data-echo"),r.removeAttribute("data-echo-background")),u(r,"load")):c&&(o=r.getAttribute("data-echo-placeholder"))&&(null!==r.getAttribute("data-echo-background")?r.style.backgroundImage="url("+o+")":r.src=o,r.removeAttribute("data-echo-placeholder"),u(r,"unload"));i||a.detach()},a.detach=function(){document.removeEventListener?t.removeEventListener("scroll",i):t.detachEvent("onscroll",i),clearTimeout(n)},a});