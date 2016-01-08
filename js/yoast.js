/* -- Yoast.js -- */

function loadCSS(a,b,c,d){"use strict";var e=window.document.createElement("link"),f=b||window.document.getElementsByTagName("script")[0],g=window.document.styleSheets;return e.rel="stylesheet",e.href=a,e.media="only x",d&&(e.onload=d),f.parentNode.insertBefore(e,f),e.onloadcssdefined=function(b){for(var c,d=0;d<g.length;d++)g[d].href&&g[d].href.indexOf(a)>-1&&(c=!0);c?b():setTimeout(function(){e.onloadcssdefined(b)})},e.onloadcssdefined(function(){e.media=c||"all"}),e}function testFilter(){var a=" -webkit- -moz- -o- -ms- ".split(" "),b=document.createElement("a");return b.style.cssText=a.join("filter:blur(2px); "),!!b.style.length&&(void 0===document.documentMode||document.documentMode>9)}function getOuterHeight(a){if("undefined"==typeof a)return 0;var b=a.offsetHeight,c=getComputedStyle(a);return b+=parseInt(c.marginTop)+parseInt(c.marginBottom)}function toggleElement(a){return"undefined"==typeof a?!1:(body=document.querySelector("body"),void(body.hasAttribute(a)?body.removeAttribute(a):body.setAttribute(a,!0)))}function setHomeBannerHeight(){bannerHome=document.querySelector("[data-banner-home]"),headerHome=document.querySelector("[data-header-home]"),headerHeight=headerHome.offsetHeight,bannerHome.style.height=headerHeight+20+"px"}function setStickyElements(){for(var a=0;a<window.stickyEls.length;a++)stickyEl=window.stickyEls[a],window.matchMedia&&(window.matchMedia("(min-width: 50em)").matches&&(stickyEl.hasAttribute("data-sticky-desktop")?setToSticky(stickyEl,a):resetSticky(stickyEl,a)),window.matchMedia("(max-width: 48em)").matches&&(stickyEl.hasAttribute("data-sticky-mobile")?setToSticky(stickyEl,a):resetSticky(stickyEl,a)))}function setToSticky(a,b){var c;return"pushup"==a.getAttribute("data-sticky")&&(pushEl=document.querySelector("[data-push-sticky]"),topPos=0),"stacked"!=a.getAttribute("data-sticky")&&"pushup"!=a.getAttribute("data-sticky")&&(topPos=0),a.hasAttribute("data-sticky-stacked")&&(prevPos=document.querySelector(".subnav").getBoundingClientRect(),topPos=prevPos.bottom),stickyAnchor=a.previousElementSibling,a.hasAttribute("data-sticky-keep")&&(stickyAnchor=!1),stickyAnchor&&(elOffset=stickyAnchor.getBoundingClientRect(),elOffset.top<=topPos?(stickyAnchor.style.height=getOuterHeight(a)+"px",a.classList.add("is-sticky"),a.style.top=topPos+"px"):(a.classList.remove("is-sticky"),a.style.top="",stickyAnchor.style.height="0")),"undefined"!=typeof pushEl&&"pushup"==a.getAttribute("data-sticky")&&(pushOffset=pushEl.getBoundingClientRect(),c=pushOffset.top-getOuterHeight(a),pushOffset.top<a.offsetHeight&&c>0&&(a.style.webkitTransform="translateY("+c+"px)",a.style.transform="translateY("+c+"px)")),a}function resetSticky(a){return a.classList.remove("is-sticky"),a.style.top="",a.previousElementSibling.style.height="0",a}function initStickyElements(){window.stickyEls=document.querySelectorAll("[data-sticky]");for(var a=0;a<stickyEls.length;a++)stickyEl=stickyEls[a],stickyEl.hasAttribute("data-sticky-keep")||stickyEl.insertAdjacentHTML("beforebegin","<div data-sticky-anchor></div>");window.addEventListener&&(setStickyElements(),window.addEventListener("scroll",function(){setStickyElements()}),window.addEventListener("resize",function(){setStickyElements(!1)}))}function initToggle(){window.toggleEls=document.querySelectorAll("[data-toggle]");for(var a=0;a<window.toggleEls.length;a++)window.toggleEls[a].addEventListener("click",function(a){this.classList.toggle("is-active"),a.preventDefault(),toggleElement(this.getAttribute("data-toggle"))})}!function(a){"use strict";function b(){f=a(document.body),c(),e()}function c(){a.getJSON(YoastAjax.ajaxurl,{action:"cart_item_number"},d)}function d(b){"success"===b.status&&a(".cart .num-items").html(b.data.cartItems)}function e(){var a=document.location.search;"?show_coupon"===a&&(document.cookie="yst_edd_discount=1; path=/",document.location.href=document.location.href.replace(document.location.search,"").replace(document.location.hash,""))}var f;a(b)}(jQuery),jQuery(document).ready(function(a){a(".socialbox a").click(function(b){b.preventDefault(),"undefined"!=typeof __gaTracker&&__gaTracker("send","social",a(this).data("name"),a(this).data("action"),document.querySelector("link[rel='canonical']").getAttribute("href")),ystWindow=window.open(a(this).attr("href"),a(this).data("name"),"height=550,width=500"),window.focus&&ystWindow.focus()}),a(".social.promoblock a").on("mousedown",function(){"undefined"!=typeof __gaTracker&&__gaTracker("send","social",a(this).data("name"),a(this).data("action"),a(this).attr("href"))}),a(".readmore a").on("mousedown",function(){"undefined"!=typeof __gaTracker&&__gaTracker("send","read-more",a(this).attr("title"))})}),function(a,b,c){"use strict";function d(){var b=a.getElementsByTagName("iframe"),c=a.getElementsByTagName("embed");e(b),e(c)}function e(a){var b;for(b=0;b<a.length;b++){var c=f(a[b]);if(c){var d=g(a[b]);h(d)}}}function f(a){var b=a.src||"";return b.indexOf("youtube.com/embed/")>-1||b.indexOf("youtube.com/v/")>-1?!0:!1}function g(c){var d=a.createElement("a");d.href=c.src,d.hostname="www.youtube.com",d.protocol=a.location.protocol;var e="/"===d.pathname.charAt(0)?d.pathname:"/"+d.pathname,f=b.location.protocol+"%2F%2F"+b.location.hostname+(b.location.port?":"+b.location.port:"");if(-1===d.search.indexOf("enablejsapi")&&(d.search=(d.search.length>0?d.search+"&":"")+"enablejsapi=1"),-1===d.search.indexOf("origin")&&-1===b.location.hostname.indexOf("localhost")&&(d.search=d.search+"&origin="+f),"application/x-shockwave-flash"===c.type){var g=a.createElement("iframe");g.height=c.height,g.width=c.width,e=e.replace("/v/","/embed/"),c.parentNode.parentNode.replaceChild(g,c.parentNode),c=g}return d.pathname=e,c.src!==d.href+d.hash&&(c.src=d.href+d.hash),c}function h(a){a.pauseFlag=!1,new YT.Player(a,{events:{onStateChange:function(b){k(b,a)}}})}function i(a){var b={};if(n.events["Watch to End"]&&(b["Watch to End"]=99*a/100),n.percentageTracking){var c,d=[];if(n.percentageTracking.each&&(d=d.concat(n.percentageTracking.each)),n.percentageTracking.every){var e=parseInt(n.percentageTracking.every,10),f=100/e;for(c=1;f>c;c++)d.push(c*e)}for(c=0;c<d.length;c++){var g=d[c],h=g+"%",i=a*g/100;b[h]=Math.floor(i)}}return b}function j(a,b,c){var d=(a.getDuration(),a.getCurrentTime());a.getPlaybackRate();a[c]=a[c]||{};var e;for(e in b)b[e]<=d&&!a[c][e]&&(a[c][e]=!0,l(c,e))}function k(a,b){var c=a.data,d=a.target,e=d.getVideoUrl(),f=e.match(/[?&]v=([^&#]*)/)[1],g=d.getPlayerState(),h=d.getDuration(),k=i(h),m={1:"Play",2:"Pause"},n=m[c];if(b.playTracker=b.playTracker||{},1!==g||b.timer?(clearInterval(b.timer),b.timer=!1):(clearInterval(b.timer),b.timer=setInterval(function(){j(d,k,b.videoId)},1e3)),1===c&&(b.playTracker[f]=!0,b.videoId=f,b.pauseFlag=!1),!b.playTracker[b.videoId])return!1;if(2===c){if(b.pauseFlag)return!1;b.pauseFlag=!0}o[n]&&l(b.videoId,n)}function l(a,b){var c="https://www.youtube.com/watch?v="+a;__gaTracker("send","event","Video",b,c)}b.onYouTubeIframeAPIReady=function(){var a=b.onYouTubeIframeAPIReady;return function(){a&&a.apply(this,arguments),navigator.userAgent.match(/MSIE [67]\./gi)||d()}}();var m,n=c||{},o=(n.forceSyntax||0,n.dataLayerName||"dataLayer",{Play:!0,Pause:!0,"Watch to End":!0});for(m in n.events)n.events.hasOwnProperty(m)&&(o[m]=n.events[m]);var p=a.createElement("script");p.src="//www.youtube.com/iframe_api";var q=a.getElementsByTagName("script")[0];q.parentNode.insertBefore(p,q)}(document,window,{events:{Play:!0,Pause:!0,"Watch to End":!0},percentageTracking:{every:25,each:[10,90]}}),function(){return}(),loadCSS("https://fonts.googleapis.com/css?family=Merriweather:300,700,300italic|Open+Sans:400italic,400,300"),loadCSS("//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"),document.onreadystatechange=function(){"complete"==document.readyState&&document.querySelector&&(testFilter()&&document.querySelector("html").classList.add("supports-filter"),document.querySelector("[data-header-home]")&&setHomeBannerHeight(),initStickyElements(),initToggle(),document.addEventListener("click",function(){document.querySelector("body[data-show-mobile-search]")&&document.querySelector("[data-mobile-search] input").focus()}))};
//# sourceMappingURL=yoast.js.map