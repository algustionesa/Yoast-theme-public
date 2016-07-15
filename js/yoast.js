/* -- Yoast.js -- */

function loadCSS(a,b,c,d){"use strict";var e=window.document.createElement("link"),f=b||window.document.getElementsByTagName("script")[0],g=window.document.styleSheets;return e.rel="stylesheet",e.href=a,e.media="only x",d&&(e.onload=d),f.parentNode.insertBefore(e,f),e.onloadcssdefined=function(b){for(var c,d=0;d<g.length;d++)g[d].href&&g[d].href.indexOf(a)>-1&&(c=!0);c?b():setTimeout(function(){e.onloadcssdefined(b)})},e.onloadcssdefined(function(){e.media=c||"all"}),e}function testFilter(){var a=" -webkit- -moz- -o- -ms- ".split(" "),b=document.createElement("a");return b.style.cssText=a.join("filter:blur(2px); "),!!b.style.length&&(void 0===document.documentMode||document.documentMode>9)}function getOuterHeight(a){if("undefined"==typeof a)return 0;var b=a.offsetHeight,c=getComputedStyle(a);return b+=parseInt(c.marginTop)+parseInt(c.marginBottom)}function toggleElement(a){return"undefined"==typeof a?!1:(body=document.querySelector("body"),void(body.hasAttribute(a)?body.removeAttribute(a):body.setAttribute(a,!0)))}function removeAttribute(a){var b=document.querySelector("body");b.removeAttribute(a)}function setHomeBannerHeight(){bannerHome=document.querySelector("[data-banner-home]"),headerHome=document.querySelector("[data-header-home]"),headerHeight=headerHome.offsetHeight,bannerHome.style.height=headerHeight+20+"px"}function setStickyElements(){for(var a=0;a<window.stickyEls.length;a++)stickyEl=window.stickyEls[a],window.matchMedia&&(window.matchMedia("(min-width: 56em)").matches&&(stickyEl.hasAttribute("data-sticky-desktop")?setToSticky(stickyEl,a):resetSticky(stickyEl,a)),window.matchMedia("(max-width: 48em)").matches&&(stickyEl.hasAttribute("data-sticky-mobile")?setToSticky(stickyEl,a):resetSticky(stickyEl,a)))}function setToSticky(a,b){var c;return"pushup"==a.getAttribute("data-sticky")&&(pushEl=document.querySelector("[data-push-sticky]"),topPos=0),"stacked"!=a.getAttribute("data-sticky")&&"pushup"!=a.getAttribute("data-sticky")&&(topPos=0),a.hasAttribute("data-sticky-stacked")&&(prevPos=document.querySelector(".subnav").getBoundingClientRect(),topPos=prevPos.bottom),stickyAnchor=a.previousElementSibling,a.hasAttribute("data-sticky-keep")&&(stickyAnchor=!1),stickyAnchor&&(elOffset=stickyAnchor.getBoundingClientRect(),elOffset.top<=topPos?(stickyAnchor.style.height=getOuterHeight(a)+"px",a.classList.add("is-sticky"),a.style.top=topPos+"px"):(a.classList.remove("is-sticky"),a.style.top="",stickyAnchor.style.height="0")),"undefined"!=typeof pushEl&&"pushup"==a.getAttribute("data-sticky")&&(pushOffset=pushEl.getBoundingClientRect(),c=pushOffset.top-getOuterHeight(a),pushOffset.top<a.offsetHeight&&c>0&&(a.style.webkitTransform="translateY("+c+"px)",a.style.transform="translateY("+c+"px)")),a}function resetSticky(a){return a.classList.remove("is-sticky"),a.style.top="",a.previousElementSibling.style.height="0",a}function initStickyElements(){window.stickyEls=document.querySelectorAll("[data-sticky]");for(var a=0;a<stickyEls.length;a++)stickyEl=stickyEls[a],stickyEl.hasAttribute("data-sticky-keep")||stickyEl.insertAdjacentHTML("beforebegin","<div data-sticky-anchor></div>");window.addEventListener&&(setStickyElements(),window.addEventListener("scroll",function(){setStickyElements()}),window.addEventListener("resize",function(){setStickyElements(!1)}))}function initToggle(){window.toggleEls=document.querySelectorAll("[data-toggle]");for(var a=0;a<window.toggleEls.length;a++)window.toggleEls[a].addEventListener("click",function(a){if(!this.classList.contains("is-active")){var b=this.getAttribute("data-hide-on-active"),c=document.querySelector('[data-toggle="'+b+'"]');removeAttribute(b),c.classList.remove("is-active")}a.preventDefault(),toggleElement(this.getAttribute("data-toggle"))})}!function(a){"use strict";function b(){f=a(document.body),c(),e()}function c(){a.getJSON(YoastAjax.ajaxurl+"?callback=?",{action:"cart_item_number"},d)}function d(b){"success"===b.status&&a(".cart .num-items").html(b.data.cartItems)}function e(){var a=document.location.search;"?show_coupon"===a&&(document.cookie="yst_edd_discount=1; path=/",document.location.href=document.location.href.replace(document.location.search,"").replace(document.location.hash,""))}var f;a(b)}(jQuery),jQuery(document).ready(function(a){a(".socialbox a").click(function(b){b.preventDefault(),"undefined"!=typeof __gaTracker&&__gaTracker("send","social",a(this).data("name"),a(this).data("action"),document.querySelector("link[rel='canonical']").getAttribute("href")),a(this).data("popup")!==!1&&(ystWindow=window.open(a(this).attr("href"),a(this).data("name"),"height=550,width=500"),window.focus&&ystWindow.focus())}),a(".social.promoblock a").on("mousedown",function(){"undefined"!=typeof __gaTracker&&__gaTracker("send","social",a(this).data("name"),a(this).data("action"),a(this).attr("href"))}),a(".readmore a").on("mousedown",function(){"undefined"!=typeof __gaTracker&&__gaTracker("send","event","read-more",a(this).attr("title"),a(this).data("prefix"))}),a("section.show-off button").on("mousedown",function(){"undefined"!=typeof __gaTracker&&__gaTracker("send","event","banner-buy-click",a(this).data("download-id"))}),a("section.show-off a").on("mousedown",function(){"undefined"!=typeof __gaTracker&&__gaTracker("send","event","banner-read-more-click",a(this).attr("href"))})}),function(a,b,c){"use strict";function d(a){var b;for(b=0;b<a.length;b++){var c=e(a[b]);if(c){var d=f(a[b]);g(d)}}}function e(a){var b=a.src||"";return b.indexOf("youtube.com/embed/")>-1||b.indexOf("youtube.com/v/")>-1}function f(c){var d=a.createElement("a");d.href=c.src,d.hostname="www.youtube.com",d.protocol=a.location.protocol;var e="/"===d.pathname.charAt(0)?d.pathname:"/"+d.pathname,f=b.location.protocol+"%2F%2F"+b.location.hostname+(b.location.port?":"+b.location.port:"");if(-1===d.search.indexOf("enablejsapi")&&(d.search=(d.search.length>0?d.search+"&":"")+"enablejsapi=1"),-1===d.search.indexOf("origin")&&-1===b.location.hostname.indexOf("localhost")&&(d.search=d.search+"&origin="+f),"application/x-shockwave-flash"===c.type){var g=a.createElement("iframe");g.height=c.height,g.width=c.width,e=e.replace("/v/","/embed/"),c.parentNode.parentNode.replaceChild(g,c.parentNode),c=g}return d.pathname=e,c.src!==d.href+d.hash&&(c.src=d.href+d.hash),c}function g(a){a.pauseFlag=!1,new YT.Player(a,{events:{onStateChange:function(b){j(b,a)}}})}function h(a){var b={};if(m.events["Watch to End"]&&(b["Watch to End"]=99*a/100),m.percentageTracking){var c,d=[];if(m.percentageTracking.each&&(d=d.concat(m.percentageTracking.each)),m.percentageTracking.every){var e=parseInt(m.percentageTracking.every,10),f=100/e;for(c=1;f>c;c++)d.push(c*e)}for(c=0;c<d.length;c++){var g=d[c],h=g+"%",i=a*g/100;b[h]=Math.floor(i)}}return b}function i(a,b,c){var d=(a.getDuration(),a.getCurrentTime());a.getPlaybackRate();a[c]=a[c]||{};var e;for(e in b)b[e]<=d&&!a[c][e]&&(a[c][e]=!0,k(c,e))}function j(a,b){var c=a.data,d=a.target,e=d.getVideoUrl(),f=e.match(/[?&]v=([^&#]*)/)[1],g=d.getPlayerState(),j=d.getDuration(),l=h(j),m={1:"Play",2:"Pause"},o=m[c];if(b.playTracker=b.playTracker||{},1!==g||b.timer?(clearInterval(b.timer),b.timer=!1):(clearInterval(b.timer),b.timer=setInterval(function(){i(d,l,b.videoId)},1e3)),1===c&&(b.playTracker[f]=!0,b.videoId=f,b.pauseFlag=!1),!b.playTracker[b.videoId])return!1;if(2===c){if(b.pauseFlag)return!1;b.pauseFlag=!0}n[o]&&k(b.videoId,o)}function k(a,b){var c="https://www.youtube.com/watch?v="+a;__gaTracker("send","event","Video",b,c)}b.onYouTubeIframeAPIReady=function(){var a=b.onYouTubeIframeAPIReady;return function(){a&&a.apply(this,arguments),navigator.userAgent.match(/MSIE [67]\./gi)||(d(p),console.log("init"))}}();var l,m=c||{},n=(m.forceSyntax||0,m.dataLayerName||"dataLayer",{Play:!0,Pause:!0,"Watch to End":!0});for(l in m.events)m.events.hasOwnProperty(l)&&(n[l]=m.events[l]);var o=!1,p=a.getElementsByTagName("iframe");if([].forEach.call(p,function(a){e(a)&&(o=!0)}),o){var q=a.createElement("script");q.src="//www.youtube.com/iframe_api";var r=a.getElementsByTagName("script")[0];r.parentNode.insertBefore(q,r)}}(document,window,{events:{Play:!0,Pause:!0,"Watch to End":!0},percentageTracking:{every:25,each:[10,90]}}),function(){return}(),document.onreadystatechange=function(){"complete"==document.readyState&&document.querySelector&&(testFilter()&&document.querySelector("html").classList.add("supports-filter"),document.querySelector("[data-header-home]")&&setHomeBannerHeight(),document.addEventListener("click",function(){document.querySelector("body[data-show-mobile-search]")&&document.querySelector(".searchbar input").focus()}))},function(a){a(document).ready(function(){initStickyElements(),initToggle(),a(".js-random-show-items").each(function(){for(var b=a(this),c=b.data("show-items"),d=0;c>d;d++){var e=b.find(".js-random-show-item.hidden"),f=Math.floor(Math.random()*e.length);e.eq(f).removeClass("hidden")}}),a(".toc .content h2, .toc .content h3").prepend('<a class="toplink" href="#top"><i class="fa fa-level-up"></i></a>')})}(jQuery);
//# sourceMappingURL=yoast.js.map