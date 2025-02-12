/**
 * plugin: orgTree
 * author: joinFisher
 * require: jquery.js  ztree.js 
 */
/*! layer-v3.1.1 Web弹层组件 MIT License  http://layer.layui.com/  By 贤心 */
 ;!function(e,t){"use strict";var i,n,a=e.layui&&layui.define,o={getPath:function(){var e=document.currentScript?document.currentScript.src:function(){for(var e,t=document.scripts,i=t.length-1,n=i;n>0;n--)if("interactive"===t[n].readyState){e=t[n].src;break}return e||t[i].src}();return e.substring(0,e.lastIndexOf("/")+1)}(),config:{},end:{},minIndex:0,minLeft:[],btn:["&#x786E;&#x5B9A;","&#x53D6;&#x6D88;"],type:["dialog","page","iframe","loading","tips"],getStyle:function(t,i){var n=t.currentStyle?t.currentStyle:e.getComputedStyle(t,null);return n[n.getPropertyValue?"getPropertyValue":"getAttribute"](i)},link:function(t,i,n){if(r.path){var a=document.getElementsByTagName("head")[0],s=document.createElement("link");"string"==typeof i&&(n=i);var l=(n||t).replace(/\.|\//g,""),f="layuicss-"+l,c=0;s.rel="stylesheet",s.href=r.path+t,s.id=f,document.getElementById(f)||a.appendChild(s),"function"==typeof i&&!function u(){return++c>80?e.console&&console.error("orgTree.css: Invalid"):void(1989===parseInt(o.getStyle(document.getElementById(f),"width"))?i():setTimeout(u,100))}()}}},r={v:"3.1.1",ie:function(){var t=navigator.userAgent.toLowerCase();return!!(e.ActiveXObject||"ActiveXObject"in e)&&((t.match(/msie\s(\d+)/)||[])[1]||"11")}(),index:e.layer&&e.layer.v?1e5:0,path:o.getPath,config:function(e,t){return e=e||{},r.cache=o.config=i.extend({},o.config,e),r.path=o.config.path||r.path,"string"==typeof e.extend&&(e.extend=[e.extend]),o.config.path&&r.ready(),e.extend?(a?layui.addcss("modules/layer/"+e.extend):o.link("theme/"+e.extend),this):this},ready:function(e){var t="layer",i="",n=(a?"modules/layer/":"")+"default/orgTree.css?v="+r.v+i;return a?layui.addcss(n,e,t):o.link(n,e,t),this},alert:function(e,t,n){var a="function"==typeof t;return a&&(n=t),r.open(i.extend({content:e,yes:n},a?{}:t))},confirm:function(e,t,n,a){var s="function"==typeof t;return s&&(a=n,n=t),r.open(i.extend({content:e,btn:o.btn,yes:n,btn2:a},s?{}:t))},msg:function(e,n,a){var s="function"==typeof n,f=o.config.skin,c=(f?f+" "+f+"-msg":"")||"layui-layer-msg",u=l.anim.length-1;return s&&(a=n),r.open(i.extend({content:e,time:3e3,shade:!1,skin:c,title:!1,closeBtn:!1,btn:!1,resize:!1,end:a},s&&!o.config.skin?{skin:c+" layui-layer-hui",anim:u}:function(){return n=n||{},(n.icon===-1||n.icon===t&&!o.config.skin)&&(n.skin=c+" "+(n.skin||"layui-layer-hui")),n}()))},load:function(e,t){return r.open(i.extend({type:3,icon:e||0,resize:!1,shade:.01},t))},tips:function(e,t,n){return r.open(i.extend({type:4,content:[e,t],closeBtn:!1,time:3e3,shade:!1,resize:!1,fixed:!1,maxWidth:210},n))}},s=function(e){var t=this;t.index=++r.index,t.config=i.extend({},t.config,o.config,e),document.body?t.creat():setTimeout(function(){t.creat()},30)};s.pt=s.prototype;var l=["layui-layer",".layui-layer-title",".layui-layer-main",".layui-layer-dialog","layui-layer-iframe","layui-layer-content","layui-layer-btn","layui-layer-close"];l.anim=["layer-anim-00","layer-anim-01","layer-anim-02","layer-anim-03","layer-anim-04","layer-anim-05","layer-anim-06"],s.pt.config={type:0,shade:.3,fixed:!0,move:l[1],title:"&#x4FE1;&#x606F;",offset:"auto",area:"auto",closeBtn:1,time:0,zIndex:19891014,maxWidth:360,anim:0,isOutAnim:!0,icon:-1,moveType:1,resize:!0,scrollbar:!0,tips:2},s.pt.vessel=function(e,t){var n=this,a=n.index,r=n.config,s=r.zIndex+a,f="object"==typeof r.title,c=r.maxmin&&(1===r.type||2===r.type),u=r.title?'<div class="layui-layer-title" style="'+(f?r.title[1]:"")+'">'+(f?r.title[0]:r.title)+"</div>":"";return r.zIndex=s,t([r.shade?'<div class="layui-layer-shade" id="layui-layer-shade'+a+'" times="'+a+'" style="'+("z-index:"+(s-1)+"; ")+'"></div>':"",'<div class="'+l[0]+(" layui-layer-"+o.type[r.type])+(0!=r.type&&2!=r.type||r.shade?"":" layui-layer-border")+" "+(r.skin||"")+'" id="'+l[0]+a+'" type="'+o.type[r.type]+'" times="'+a+'" showtime="'+r.time+'" conType="'+(e?"object":"string")+'" style="z-index: '+s+"; width:"+r.area[0]+";height:"+r.area[1]+(r.fixed?"":";position:absolute;")+'">'+(e&&2!=r.type?"":u)+'<div id="'+(r.id||"")+'" class="layui-layer-content'+(0==r.type&&r.icon!==-1?" layui-layer-padding":"")+(3==r.type?" layui-layer-loading"+r.icon:"")+'">'+(0==r.type&&r.icon!==-1?'<i class="layui-layer-ico layui-layer-ico'+r.icon+'"></i>':"")+(1==r.type&&e?"":r.content||"")+'</div><span class="layui-layer-setwin">'+function(){var e=c?'<a class="layui-layer-min" href="javascript:;"><cite></cite></a><a class="layui-layer-ico layui-layer-max" href="javascript:;"></a>':"";return r.closeBtn&&(e+='<a class="layui-layer-ico '+l[7]+" "+l[7]+(r.title?r.closeBtn:4==r.type?"1":"2")+'" href="javascript:;"></a>'),e}()+"</span>"+(r.btn?function(){var e="";"string"==typeof r.btn&&(r.btn=[r.btn]);for(var t=0,i=r.btn.length;t<i;t++)e+='<a class="'+l[6]+t+'">'+r.btn[t]+"</a>";return'<div class="'+l[6]+" layui-layer-btn-"+(r.btnAlign||"")+'">'+e+"</div>"}():"")+(r.resize?'<span class="layui-layer-resize"></span>':"")+"</div>"],u,i('<div class="layui-layer-move"></div>')),n},s.pt.creat=function(){var e=this,t=e.config,a=e.index,s=t.content,f="object"==typeof s,c=i("body");if(!t.id||!i("#"+t.id)[0]){switch("string"==typeof t.area&&(t.area="auto"===t.area?["",""]:[t.area,""]),t.shift&&(t.anim=t.shift),6==r.ie&&(t.fixed=!1),t.type){case 0:t.btn="btn"in t?t.btn:o.btn[0],r.closeAll("dialog");break;case 2:var s=t.content=f?t.content:[t.content||"http://layer.layui.com","auto"];t.content='<iframe scrolling="'+(t.content[1]||"auto")+'" allowtransparency="true" id="'+l[4]+a+'" name="'+l[4]+a+'" onload="this.className=\'\';" class="layui-layer-load" frameborder="0" src="'+t.content[0]+'"></iframe>';break;case 3:delete t.title,delete t.closeBtn,t.icon===-1&&0===t.icon,r.closeAll("loading");break;case 4:f||(t.content=[t.content,"body"]),t.follow=t.content[1],t.content=t.content[0]+'<i class="layui-layer-TipsG"></i>',delete t.title,t.tips="object"==typeof t.tips?t.tips:[t.tips,!0],t.tipsMore||r.closeAll("tips")}if(e.vessel(f,function(n,r,u){c.append(n[0]),f?function(){2==t.type||4==t.type?function(){i("body").append(n[1])}():function(){s.parents("."+l[0])[0]||(s.data("display",s.css("display")).show().addClass("layui-layer-wrap").wrap(n[1]),i("#"+l[0]+a).find("."+l[5]).before(r))}()}():c.append(n[1]),i(".layui-layer-move")[0]||c.append(o.moveElem=u),e.layero=i("#"+l[0]+a),t.scrollbar||l.html.css("overflow","hidden").attr("layer-full",a)}).auto(a),i("#layui-layer-shade"+e.index).css({"background-color":t.shade[1]||"#000",opacity:t.shade[0]||t.shade}),2==t.type&&6==r.ie&&e.layero.find("iframe").attr("src",s[0]),4==t.type?e.tips():e.offset(),t.fixed&&n.on("resize",function(){e.offset(),(/^\d+%$/.test(t.area[0])||/^\d+%$/.test(t.area[1]))&&e.auto(a),4==t.type&&e.tips()}),t.time<=0||setTimeout(function(){r.close(e.index)},t.time),e.move().callback(),l.anim[t.anim]){var u="layer-anim "+l.anim[t.anim];e.layero.addClass(u).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",function(){i(this).removeClass(u)})}t.isOutAnim&&e.layero.data("isOutAnim",!0)}},s.pt.auto=function(e){var t=this,a=t.config,o=i("#"+l[0]+e);""===a.area[0]&&a.maxWidth>0&&(r.ie&&r.ie<8&&a.btn&&o.width(o.innerWidth()),o.outerWidth()>a.maxWidth&&o.width(a.maxWidth));var s=[o.innerWidth(),o.innerHeight()],f=o.find(l[1]).outerHeight()||0,c=o.find("."+l[6]).outerHeight()||0,u=function(e){e=o.find(e),e.height(s[1]-f-c-2*(0|parseFloat(e.css("padding-top"))))};switch(a.type){case 2:u("iframe");break;default:""===a.area[1]?a.maxHeight>0&&o.outerHeight()>a.maxHeight?(s[1]=a.maxHeight,u("."+l[5])):a.fixed&&s[1]>=n.height()&&(s[1]=n.height(),u("."+l[5])):u("."+l[5])}return t},s.pt.offset=function(){var e=this,t=e.config,i=e.layero,a=[i.outerWidth(),i.outerHeight()],o="object"==typeof t.offset;e.offsetTop=(n.height()-a[1])/2,e.offsetLeft=(n.width()-a[0])/2,o?(e.offsetTop=t.offset[0],e.offsetLeft=t.offset[1]||e.offsetLeft):"auto"!==t.offset&&("t"===t.offset?e.offsetTop=0:"r"===t.offset?e.offsetLeft=n.width()-a[0]:"b"===t.offset?e.offsetTop=n.height()-a[1]:"l"===t.offset?e.offsetLeft=0:"lt"===t.offset?(e.offsetTop=0,e.offsetLeft=0):"lb"===t.offset?(e.offsetTop=n.height()-a[1],e.offsetLeft=0):"rt"===t.offset?(e.offsetTop=0,e.offsetLeft=n.width()-a[0]):"rb"===t.offset?(e.offsetTop=n.height()-a[1],e.offsetLeft=n.width()-a[0]):e.offsetTop=t.offset),t.fixed||(e.offsetTop=/%$/.test(e.offsetTop)?n.height()*parseFloat(e.offsetTop)/100:parseFloat(e.offsetTop),e.offsetLeft=/%$/.test(e.offsetLeft)?n.width()*parseFloat(e.offsetLeft)/100:parseFloat(e.offsetLeft),e.offsetTop+=n.scrollTop(),e.offsetLeft+=n.scrollLeft()),i.attr("minLeft")&&(e.offsetTop=n.height()-(i.find(l[1]).outerHeight()||0),e.offsetLeft=i.css("left")),i.css({top:e.offsetTop,left:e.offsetLeft})},s.pt.tips=function(){var e=this,t=e.config,a=e.layero,o=[a.outerWidth(),a.outerHeight()],r=i(t.follow);r[0]||(r=i("body"));var s={width:r.outerWidth(),height:r.outerHeight(),top:r.offset().top,left:r.offset().left},f=a.find(".layui-layer-TipsG"),c=t.tips[0];t.tips[1]||f.remove(),s.autoLeft=function(){s.left+o[0]-n.width()>0?(s.tipLeft=s.left+s.width-o[0],f.css({right:12,left:"auto"})):s.tipLeft=s.left},s.where=[function(){s.autoLeft(),s.tipTop=s.top-o[1]-10,f.removeClass("layui-layer-TipsB").addClass("layui-layer-TipsT").css("border-right-color",t.tips[1])},function(){s.tipLeft=s.left+s.width+10,s.tipTop=s.top,f.removeClass("layui-layer-TipsL").addClass("layui-layer-TipsR").css("border-bottom-color",t.tips[1])},function(){s.autoLeft(),s.tipTop=s.top+s.height+10,f.removeClass("layui-layer-TipsT").addClass("layui-layer-TipsB").css("border-right-color",t.tips[1])},function(){s.tipLeft=s.left-o[0]-10,s.tipTop=s.top,f.removeClass("layui-layer-TipsR").addClass("layui-layer-TipsL").css("border-bottom-color",t.tips[1])}],s.where[c-1](),1===c?s.top-(n.scrollTop()+o[1]+16)<0&&s.where[2]():2===c?n.width()-(s.left+s.width+o[0]+16)>0||s.where[3]():3===c?s.top-n.scrollTop()+s.height+o[1]+16-n.height()>0&&s.where[0]():4===c&&o[0]+16-s.left>0&&s.where[1](),a.find("."+l[5]).css({"background-color":t.tips[1],"padding-right":t.closeBtn?"30px":""}),a.css({left:s.tipLeft-(t.fixed?n.scrollLeft():0),top:s.tipTop-(t.fixed?n.scrollTop():0)})},s.pt.move=function(){var e=this,t=e.config,a=i(document),s=e.layero,l=s.find(t.move),f=s.find(".layui-layer-resize"),c={};return t.move&&l.css("cursor","move"),l.on("mousedown",function(e){e.preventDefault(),t.move&&(c.moveStart=!0,c.offset=[e.clientX-parseFloat(s.css("left")),e.clientY-parseFloat(s.css("top"))],o.moveElem.css("cursor","move").show())}),f.on("mousedown",function(e){e.preventDefault(),c.resizeStart=!0,c.offset=[e.clientX,e.clientY],c.area=[s.outerWidth(),s.outerHeight()],o.moveElem.css("cursor","se-resize").show()}),a.on("mousemove",function(i){if(c.moveStart){var a=i.clientX-c.offset[0],o=i.clientY-c.offset[1],l="fixed"===s.css("position");if(i.preventDefault(),c.stX=l?0:n.scrollLeft(),c.stY=l?0:n.scrollTop(),!t.moveOut){var f=n.width()-s.outerWidth()+c.stX,u=n.height()-s.outerHeight()+c.stY;a<c.stX&&(a=c.stX),a>f&&(a=f),o<c.stY&&(o=c.stY),o>u&&(o=u)}s.css({left:a,top:o})}if(t.resize&&c.resizeStart){var a=i.clientX-c.offset[0],o=i.clientY-c.offset[1];i.preventDefault(),r.style(e.index,{width:c.area[0]+a,height:c.area[1]+o}),c.isResize=!0,t.resizing&&t.resizing(s)}}).on("mouseup",function(e){c.moveStart&&(delete c.moveStart,o.moveElem.hide(),t.moveEnd&&t.moveEnd(s)),c.resizeStart&&(delete c.resizeStart,o.moveElem.hide())}),e},s.pt.callback=function(){function e(){var e=a.cancel&&a.cancel(t.index,n);e===!1||r.close(t.index)}var t=this,n=t.layero,a=t.config;t.openLayer(),a.success&&(2==a.type?n.find("iframe").on("load",function(){a.success(n,t.index)}):a.success(n,t.index)),6==r.ie&&t.IE6(n),n.find("."+l[6]).children("a").on("click",function(){var e=i(this).index();if(0===e)a.yes?a.yes(t.index,n):a.btn1?a.btn1(t.index,n):r.close(t.index);else{var o=a["btn"+(e+1)]&&a["btn"+(e+1)](t.index,n);o===!1||r.close(t.index)}}),n.find("."+l[7]).on("click",e),a.shadeClose&&i("#layui-layer-shade"+t.index).on("click",function(){r.close(t.index)}),n.find(".layui-layer-min").on("click",function(){var e=a.min&&a.min(n);e===!1||r.min(t.index,a)}),n.find(".layui-layer-max").on("click",function(){i(this).hasClass("layui-layer-maxmin")?(r.restore(t.index),a.restore&&a.restore(n)):(r.full(t.index,a),setTimeout(function(){a.full&&a.full(n)},100))}),a.end&&(o.end[t.index]=a.end)},o.reselect=function(){i.each(i("select"),function(e,t){var n=i(this);n.parents("."+l[0])[0]||1==n.attr("layer")&&i("."+l[0]).length<1&&n.removeAttr("layer").show(),n=null})},s.pt.IE6=function(e){i("select").each(function(e,t){var n=i(this);n.parents("."+l[0])[0]||"none"===n.css("display")||n.attr({layer:"1"}).hide(),n=null})},s.pt.openLayer=function(){var e=this;r.zIndex=e.config.zIndex,r.setTop=function(e){var t=function(){r.zIndex++,e.css("z-index",r.zIndex+1)};return r.zIndex=parseInt(e[0].style.zIndex),e.on("mousedown",t),r.zIndex}},o.record=function(e){var t=[e.width(),e.height(),e.position().top,e.position().left+parseFloat(e.css("margin-left"))];e.find(".layui-layer-max").addClass("layui-layer-maxmin"),e.attr({area:t})},o.rescollbar=function(e){l.html.attr("layer-full")==e&&(l.html[0].style.removeProperty?l.html[0].style.removeProperty("overflow"):l.html[0].style.removeAttribute("overflow"),l.html.removeAttr("layer-full"))},e.layer=r,r.getChildFrame=function(e,t){return t=t||i("."+l[4]).attr("times"),i("#"+l[0]+t).find("iframe").contents().find(e)},r.getFrameIndex=function(e){return i("#"+e).parents("."+l[4]).attr("times")},r.iframeAuto=function(e){if(e){var t=r.getChildFrame("html",e).outerHeight(),n=i("#"+l[0]+e),a=n.find(l[1]).outerHeight()||0,o=n.find("."+l[6]).outerHeight()||0;n.css({height:t+a+o}),n.find("iframe").css({height:t})}},r.iframeSrc=function(e,t){i("#"+l[0]+e).find("iframe").attr("src",t)},r.style=function(e,t,n){var a=i("#"+l[0]+e),r=a.find(".layui-layer-content"),s=a.attr("type"),f=a.find(l[1]).outerHeight()||0,c=a.find("."+l[6]).outerHeight()||0;a.attr("minLeft");s!==o.type[3]&&s!==o.type[4]&&(n||(parseFloat(t.width)<=260&&(t.width=260),parseFloat(t.height)-f-c<=64&&(t.height=64+f+c)),a.css(t),c=a.find("."+l[6]).outerHeight(),s===o.type[2]?a.find("iframe").css({height:parseFloat(t.height)-f-c}):r.css({height:parseFloat(t.height)-f-c-parseFloat(r.css("padding-top"))-parseFloat(r.css("padding-bottom"))}))},r.min=function(e,t){var a=i("#"+l[0]+e),s=a.find(l[1]).outerHeight()||0,f=a.attr("minLeft")||181*o.minIndex+"px",c=a.css("position");o.record(a),o.minLeft[0]&&(f=o.minLeft[0],o.minLeft.shift()),a.attr("position",c),r.style(e,{width:180,height:s,left:f,top:n.height()-s,position:"fixed",overflow:"hidden"},!0),a.find(".layui-layer-min").hide(),"page"===a.attr("type")&&a.find(l[4]).hide(),o.rescollbar(e),a.attr("minLeft")||o.minIndex++,a.attr("minLeft",f)},r.restore=function(e){var t=i("#"+l[0]+e),n=t.attr("area").split(",");t.attr("type");r.style(e,{width:parseFloat(n[0]),height:parseFloat(n[1]),top:parseFloat(n[2]),left:parseFloat(n[3]),position:t.attr("position"),overflow:"visible"},!0),t.find(".layui-layer-max").removeClass("layui-layer-maxmin"),t.find(".layui-layer-min").show(),"page"===t.attr("type")&&t.find(l[4]).show(),o.rescollbar(e)},r.full=function(e){var t,a=i("#"+l[0]+e);o.record(a),l.html.attr("layer-full")||l.html.css("overflow","hidden").attr("layer-full",e),clearTimeout(t),t=setTimeout(function(){var t="fixed"===a.css("position");r.style(e,{top:t?0:n.scrollTop(),left:t?0:n.scrollLeft(),width:n.width(),height:n.height()},!0),a.find(".layui-layer-min").hide()},100)},r.title=function(e,t){var n=i("#"+l[0]+(t||r.index)).find(l[1]);n.html(e)},r.close=function(e){var t=i("#"+l[0]+e),n=t.attr("type"),a="layer-anim-close";if(t[0]){var s="layui-layer-wrap",f=function(){if(n===o.type[1]&&"object"===t.attr("conType")){t.children(":not(."+l[5]+")").remove();for(var a=t.find("."+s),r=0;r<2;r++)a.unwrap();a.css("display",a.data("display")).removeClass(s)}else{if(n===o.type[2])try{var f=i("#"+l[4]+e)[0];f.contentWindow.document.write(""),f.contentWindow.close(),t.find("."+l[5])[0].removeChild(f)}catch(c){}t[0].innerHTML="",t.remove()}"function"==typeof o.end[e]&&o.end[e](),delete o.end[e]};t.data("isOutAnim")&&t.addClass("layer-anim "+a),i("#layui-layer-moves, #layui-layer-shade"+e).remove(),6==r.ie&&o.reselect(),o.rescollbar(e),t.attr("minLeft")&&(o.minIndex--,o.minLeft.push(t.attr("minLeft"))),r.ie&&r.ie<10||!t.data("isOutAnim")?f():setTimeout(function(){f()},200)}},r.closeAll=function(e){i.each(i("."+l[0]),function(){var t=i(this),n=e?t.attr("type")===e:1;n&&r.close(t.attr("times")),n=null})};var f=r.cache||{},c=function(e){return f.skin?" "+f.skin+" "+f.skin+"-"+e:""};r.prompt=function(e,t){var a="";if(e=e||{},"function"==typeof e&&(t=e),e.area){var o=e.area;a='style="width: '+o[0]+"; height: "+o[1]+';"',delete e.area}var s,l=2==e.formType?'<textarea class="layui-layer-input"'+a+">"+(e.value||"")+"</textarea>":function(){return'<input type="'+(1==e.formType?"password":"text")+'" class="layui-layer-input" value="'+(e.value||"")+'">'}(),f=e.success;return delete e.success,r.open(i.extend({type:1,btn:["&#x786E;&#x5B9A;","&#x53D6;&#x6D88;"],content:l,skin:"layui-layer-prompt"+c("prompt"),maxWidth:n.width(),success:function(e){s=e.find(".layui-layer-input"),s.focus(),"function"==typeof f&&f(e)},resize:!1,yes:function(i){var n=s.val();""===n?s.focus():n.length>(e.maxlength||500)?r.tips("&#x6700;&#x591A;&#x8F93;&#x5165;"+(e.maxlength||500)+"&#x4E2A;&#x5B57;&#x6570;",s,{tips:1}):t&&t(n,i,s)}},e))},r.tab=function(e){e=e||{};var t=e.tab||{},n="layui-this",a=e.success;return delete e.success,r.open(i.extend({type:1,skin:"layui-layer-tab"+c("tab"),resize:!1,title:function(){var e=t.length,i=1,a="";if(e>0)for(a='<span class="'+n+'">'+t[0].title+"</span>";i<e;i++)a+="<span>"+t[i].title+"</span>";return a}(),content:'<ul class="layui-layer-tabmain">'+function(){var e=t.length,i=1,a="";if(e>0)for(a='<li class="layui-layer-tabli '+n+'">'+(t[0].content||"no content")+"</li>";i<e;i++)a+='<li class="layui-layer-tabli">'+(t[i].content||"no  content")+"</li>";return a}()+"</ul>",success:function(t){var o=t.find(".layui-layer-title").children(),r=t.find(".layui-layer-tabmain").children();o.on("mousedown",function(t){t.stopPropagation?t.stopPropagation():t.cancelBubble=!0;var a=i(this),o=a.index();a.addClass(n).siblings().removeClass(n),r.eq(o).show().siblings().hide(),"function"==typeof e.change&&e.change(o)}),"function"==typeof a&&a(t)}},e))},r.photos=function(t,n,a){function o(e,t,i){var n=new Image;return n.src=e,n.complete?t(n):(n.onload=function(){n.onload=null,t(n)},void(n.onerror=function(e){n.onerror=null,i(e)}))}var s={};if(t=t||{},t.photos){var l=t.photos.constructor===Object,f=l?t.photos:{},u=f.data||[],d=f.start||0;s.imgIndex=(0|d)+1,t.img=t.img||"img";var y=t.success;if(delete t.success,l){if(0===u.length)return r.msg("&#x6CA1;&#x6709;&#x56FE;&#x7247;")}else{var p=i(t.photos),h=function(){u=[],p.find(t.img).each(function(e){var t=i(this);t.attr("layer-index",e),u.push({alt:t.attr("alt"),pid:t.attr("layer-pid"),src:t.attr("layer-src")||t.attr("src"),thumb:t.attr("src")})})};if(h(),0===u.length)return;if(n||p.on("click",t.img,function(){var e=i(this),n=e.attr("layer-index");r.photos(i.extend(t,{photos:{start:n,data:u,tab:t.tab},full:t.full}),!0),h()}),!n)return}s.imgprev=function(e){s.imgIndex--,s.imgIndex<1&&(s.imgIndex=u.length),s.tabimg(e)},s.imgnext=function(e,t){s.imgIndex++,s.imgIndex>u.length&&(s.imgIndex=1,t)||s.tabimg(e)},s.keyup=function(e){if(!s.end){var t=e.keyCode;e.preventDefault(),37===t?s.imgprev(!0):39===t?s.imgnext(!0):27===t&&r.close(s.index)}},s.tabimg=function(e){if(!(u.length<=1))return f.start=s.imgIndex-1,r.close(s.index),r.photos(t,!0,e)},s.event=function(){s.bigimg.hover(function(){s.imgsee.show()},function(){s.imgsee.hide()}),s.bigimg.find(".layui-layer-imgprev").on("click",function(e){e.preventDefault(),s.imgprev()}),s.bigimg.find(".layui-layer-imgnext").on("click",function(e){e.preventDefault(),s.imgnext()}),i(document).on("keyup",s.keyup)},s.loadi=r.load(1,{shade:!("shade"in t)&&.9,scrollbar:!1}),o(u[d].src,function(n){r.close(s.loadi),s.index=r.open(i.extend({type:1,id:"layui-layer-photos",area:function(){var a=[n.width,n.height],o=[i(e).width()-100,i(e).height()-100];if(!t.full&&(a[0]>o[0]||a[1]>o[1])){var r=[a[0]/o[0],a[1]/o[1]];r[0]>r[1]?(a[0]=a[0]/r[0],a[1]=a[1]/r[0]):r[0]<r[1]&&(a[0]=a[0]/r[1],a[1]=a[1]/r[1])}return[a[0]+"px",a[1]+"px"]}(),title:!1,shade:.9,shadeClose:!0,closeBtn:!1,move:".layui-layer-phimg img",moveType:1,scrollbar:!1,moveOut:!0,isOutAnim:!1,skin:"layui-layer-photos"+c("photos"),content:'<div class="layui-layer-phimg"><img src="'+u[d].src+'" alt="'+(u[d].alt||"")+'" layer-pid="'+u[d].pid+'"><div class="layui-layer-imgsee">'+(u.length>1?'<span class="layui-layer-imguide"><a href="javascript:;" class="layui-layer-iconext layui-layer-imgprev"></a><a href="javascript:;" class="layui-layer-iconext layui-layer-imgnext"></a></span>':"")+'<div class="layui-layer-imgbar" style="display:'+(a?"block":"")+'"><span class="layui-layer-imgtit"><a href="javascript:;">'+(u[d].alt||"")+"</a><em>"+s.imgIndex+"/"+u.length+"</em></span></div></div></div>",success:function(e,i){s.bigimg=e.find(".layui-layer-phimg"),s.imgsee=e.find(".layui-layer-imguide,.layui-layer-imgbar"),s.event(e),t.tab&&t.tab(u[d],e),"function"==typeof y&&y(e)},end:function(){s.end=!0,i(document).off("keyup",s.keyup)}},t))},function(){r.close(s.loadi),r.msg("&#x5F53;&#x524D;&#x56FE;&#x7247;&#x5730;&#x5740;&#x5F02;&#x5E38;<br>&#x662F;&#x5426;&#x7EE7;&#x7EED;&#x67E5;&#x770B;&#x4E0B;&#x4E00;&#x5F20;&#xFF1F;",{time:3e4,btn:["&#x4E0B;&#x4E00;&#x5F20;","&#x4E0D;&#x770B;&#x4E86;"],yes:function(){u.length>1&&s.imgnext(!0,!0)}})})}},o.run=function(t){i=t,n=i(e),l.html=i("html"),r.open=function(e){var t=new s(e);return t.index}},e.layui&&layui.define?(r.ready(),layui.define("jquery",function(t){r.path=layui.cache.dir,o.run(layui.$),e.layer=r,t("layer",r)})):"function"==typeof define&&define.amd?define(["jquery"],function(){return o.run(e.jQuery),r}):function(){o.run(e.jQuery),r.ready()}()}(window);
/*tiny-pinyin 
* github: https://github.com/creeperyang/pinyin
* test-demo: https://creeperyang.github.io/pinyin/
*/
!function(N,A){"object"==typeof exports&&"object"==typeof module?module.exports=A():"function"==typeof define&&define.amd?define([],A):"object"==typeof exports?exports.Pinyin=A():N.Pinyin=A()}(this,function(){return function(N){function A(I){if(t[I])return t[I].exports;var U=t[I]={i:I,l:!1,exports:{}};return N[I].call(U.exports,U,U.exports,A),U.l=!0,U.exports}var t={};return A.m=N,A.c=t,A.i=function(N){return N},A.d=function(N,t,I){A.o(N,t)||Object.defineProperty(N,t,{configurable:!1,enumerable:!0,get:I})},A.n=function(N){var t=N&&N.__esModule?function(){return N.default}:function(){return N};return A.d(t,"a",t),t},A.o=function(N,A){return Object.prototype.hasOwnProperty.call(N,A)},A.p="",A(A.s=3)}([function(N,A,t){"use strict";function I(N){N&&("function"==typeof N&&(N=[N]),N.forEach&&N.forEach(function(N){"function"==typeof N&&N(o)}))}function U(N){return N||null===i?("object"===("undefined"==typeof Intl?"undefined":n(Intl))&&Intl.Collator?(f=new Intl.Collator(["zh-Hans-CN","zh-CN"]),i=1===Intl.Collator.supportedLocalesOf(["zh-CN"]).length):i=!1,i):i}function e(N){var A=o.UNIHANS,t=o.PINYINS,I=o.EXCEPTIONS,U={source:N};if(N in I)return U.type=E,U.target=I[N],U;var e=-1,r=void 0;if(N.charCodeAt(0)<256)return U.type=H,U.target=N,U;if((r=f.compare(N,G))<0)return U.type=u,U.target=N,U;if(0===r)U.type=E,e=0;else{if((r=f.compare(N,O))>0)return U.type=u,U.target=N,U;0===r&&(U.type=E,e=A.length-1)}if(U.type=E,e<0)for(var n=0,i=A.length-1;n<=i;){e=~~((n+i)/2);var S=A[e];if(0===(r=f.compare(N,S)))break;r>0?n=e+1:i=e-1}return r<0&&e--,U.target=t[e],U.target||(U.type=u,U.target=U.source),U}function r(N){if("string"!=typeof N)throw new Error("argument should be string.");if(!U())throw new Error("not support Intl or zh-CN language.");return N.split("").map(function(N){return e(N)})}var n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(N){return typeof N}:function(N){return N&&"function"==typeof Symbol&&N.constructor===Symbol&&N!==Symbol.prototype?"symbol":typeof N},o=t(2),G="阿",O="鿿",H=1,E=2,u=3,i=null,f=void 0;N.exports={isSupported:U,parse:r,patchDict:I,genToken:e,convertToPinyin:function(N,A,t){return r(N).map(function(N){return t&&N.type===E?N.target.toLowerCase():N.target}).join(A||"")}}},function(N,A,t){"use strict";A=N.exports=function(N){N.EXCEPTIONS={"嗲":"DIA","碡":"ZHOU","聒":"GUO","炔":"QUE","蚵":"KE","砉":"HUA","嬷":"MO","蹊":"XI","丬":"PAN","霰":"XIAN","豉":"CHI","饧":"XING","帧":"ZHEN","芎":"XIONG","谁":"SHUI","钶":"KE"},N.UNIHANS[91]="伕",N.UNIHANS[347]="仚",N.UNIHANS[393]="诌",N.UNIHANS[39]="婤",N.UNIHANS[50]="腠",N.UNIHANS[369]="攸",N.UNIHANS[123]="乯",N.UNIHANS[171]="刕",N.UNIHANS[102]="佝",N.UNIHANS[126]="犿",N.UNIHANS[176]="列",N.UNIHANS[178]="刢",N.UNIHANS[252]="娝",N.UNIHANS[330]="偸"},A.shouldPatch=function(N){return"function"==typeof N&&("FOU"===N("伕").target&&"XIA"===N("仚").target&&"ZHONG"===N("诌").target&&"CHONG"===N("婤").target&&"CONG"===N("腠").target&&"YONG"===N("攸").target&&"HOU"===N("乯").target&&"LENG"===N("刕").target&&"GONG"===N("佝").target&&"HUAI"===N("犿").target&&"LIAO"===N("列").target&&"LIN"===N("刢").target&&"E"===N("钶").target)}},function(N,A,t){"use strict";var I=["阿","哎","安","肮","凹","八","挀","扳","邦","勹","陂","奔","伻","屄","边","灬","憋","汃","冫","癶","峬","嚓","偲","参","仓","撡","冊","嵾","曽","叉","芆","辿","伥","抄","车","抻","阷","吃","充","抽","出","欻","揣","巛","刅","吹","旾","逴","呲","匆","凑","粗","汆","崔","邨","搓","咑","呆","丹","当","刀","嘚","扥","灯","氐","甸","刁","爹","丁","丟","东","吺","厾","耑","垖","吨","多","妸","诶","奀","鞥","儿","发","帆","匚","飞","分","丰","覅","仏","紑","夫","旮","侅","甘","冈","皋","戈","给","根","刯","工","勾","估","瓜","乖","关","光","归","丨","呙","哈","咍","佄","夯","茠","诃","黒","拫","亨","噷","叿","齁","乎","花","怀","欢","巟","灰","昏","吙","丌","加","戋","江","艽","阶","巾","坕","冂","丩","凥","姢","噘","军","咔","开","刊","忼","尻","匼","肎","劥","空","抠","扝","夸","蒯","宽","匡","亏","坤","扩","垃","来","兰","啷","捞","肋","勒","崚","哩","俩","奁","良","撩","毟","拎","伶","溜","囖","龙","瞜","噜","驴","娈","掠","抡","罗","呣","妈","埋","嫚","牤","猫","么","呅","门","甿","咪","宀","喵","乜","民","名","谬","摸","哞","毪","嗯","拏","腉","囡","囔","孬","疒","娞","恁","能","妮","拈","娘","鸟","捏","囜","宁","妞","农","羺","奴","女","奻","疟","黁","挪","喔","讴","妑","拍","眅","乓","抛","呸","喷","匉","丕","囨","剽","氕","姘","乒","钋","剖","仆","七","掐","千","呛","悄","癿","亲","靑","卭","丘","区","峑","缺","夋","呥","穣","娆","惹","人","扔","日","茸","厹","邚","挼","堧","婑","瞤","捼","仨","毢","三","桒","掻","閪","森","僧","杀","筛","山","伤","弰","奢","申","升","尸","収","书","刷","衰","闩","双","脽","吮","说","厶","忪","捜","苏","狻","夊","孙","唆","他","囼","坍","汤","夲","忑","熥","剔","天","旫","帖","厅","囲","偷","凸","湍","推","吞","乇","穵","歪","弯","尣","危","昷","翁","挝","乌","夕","虲","仙","乡","灱","些","心","星","凶","休","吁","吅","削","坃","丫","恹","央","幺","倻","一","囙","应","哟","佣","优","扜","囦","曰","晕","帀","災","兂","匨","傮","则","贼","怎","増","扎","捚","沾","张","佋","蜇","贞","争","之","中","州","朱","抓","拽","专","妆","隹","宒","卓","乲","宗","邹","租","钻","厜","尊","昨","兙"],U=["A","AI","AN","ANG","AO","BA","BAI","BAN","BANG","BAO","BEI","BEN","BENG","BI","BIAN","BIAO","BIE","BIN","BING","BO","BU","CA","CAI","CAN","CANG","CAO","CE","CEN","CENG","CHA","CHAI","CHAN","CHANG","CHAO","CHE","CHEN","CHENG","CHI","CHONG","CHOU","CHU","CHUA","CHUAI","CHUAN","CHUANG","CHUI","CHUN","CHUO","CI","CONG","COU","CU","CUAN","CUI","CUN","CUO","DA","DAI","DAN","DANG","DAO","DE","DEN","DENG","DI","DIAN","DIAO","DIE","DING","DIU","DONG","DOU","DU","DUAN","DUI","DUN","DUO","E","EI","EN","ENG","ER","FA","FAN","FANG","FEI","FEN","FENG","FIAO","FO","FOU","FU","GA","GAI","GAN","GANG","GAO","GE","GEI","GEN","GENG","GONG","GOU","GU","GUA","GUAI","GUAN","GUANG","GUI","GUN","GUO","HA","HAI","HAN","HANG","HAO","HE","HEI","HEN","HENG","HM","HONG","HOU","HU","HUA","HUAI","HUAN","HUANG","HUI","HUN","HUO","JI","JIA","JIAN","JIANG","JIAO","JIE","JIN","JING","JIONG","JIU","JU","JUAN","JUE","JUN","KA","KAI","KAN","KANG","KAO","KE","KEN","KENG","KONG","KOU","KU","KUA","KUAI","KUAN","KUANG","KUI","KUN","KUO","LA","LAI","LAN","LANG","LAO","LE","LEI","LENG","LI","LIA","LIAN","LIANG","LIAO","LIE","LIN","LING","LIU","LO","LONG","LOU","LU","LV","LUAN","LVE","LUN","LUO","M","MA","MAI","MAN","MANG","MAO","ME","MEI","MEN","MENG","MI","MIAN","MIAO","MIE","MIN","MING","MIU","MO","MOU","MU","N","NA","NAI","NAN","NANG","NAO","NE","NEI","NEN","NENG","NI","NIAN","NIANG","NIAO","NIE","NIN","NING","NIU","NONG","NOU","NU","NV","NUAN","NVE","NUN","NUO","O","OU","PA","PAI","PAN","PANG","PAO","PEI","PEN","PENG","PI","PIAN","PIAO","PIE","PIN","PING","PO","POU","PU","QI","QIA","QIAN","QIANG","QIAO","QIE","QIN","QING","QIONG","QIU","QU","QUAN","QUE","QUN","RAN","RANG","RAO","RE","REN","RENG","RI","RONG","ROU","RU","RUA","RUAN","RUI","RUN","RUO","SA","SAI","SAN","SANG","SAO","SE","SEN","SENG","SHA","SHAI","SHAN","SHANG","SHAO","SHE","SHEN","SHENG","SHI","SHOU","SHU","SHUA","SHUAI","SHUAN","SHUANG","SHUI","SHUN","SHUO","SI","SONG","SOU","SU","SUAN","SUI","SUN","SUO","TA","TAI","TAN","TANG","TAO","TE","TENG","TI","TIAN","TIAO","TIE","TING","TONG","TOU","TU","TUAN","TUI","TUN","TUO","WA","WAI","WAN","WANG","WEI","WEN","WENG","WO","WU","XI","XIA","XIAN","XIANG","XIAO","XIE","XIN","XING","XIONG","XIU","XU","XUAN","XUE","XUN","YA","YAN","YANG","YAO","YE","YI","YIN","YING","YO","YONG","YOU","YU","YUAN","YUE","YUN","ZA","ZAI","ZAN","ZANG","ZAO","ZE","ZEI","ZEN","ZENG","ZHA","ZHAI","ZHAN","ZHANG","ZHAO","ZHE","ZHEN","ZHENG","ZHI","ZHONG","ZHOU","ZHU","ZHUA","ZHUAI","ZHUAN","ZHUANG","ZHUI","ZHUN","ZHUO","ZI","ZONG","ZOU","ZU","ZUAN","ZUI","ZUN","ZUO",""],e={"曾":"ZENG","沈":"SHEN","嗲":"DIA","碡":"ZHOU","聒":"GUO","炔":"QUE","蚵":"KE","砉":"HUA","嬤":"MO","嬷":"MO","蹒":"PAN","蹊":"XI","丬":"PAN","霰":"XIAN","莘":"XIN","豉":"CHI","饧":"XING","筠":"JUN","长":"CHANG","帧":"ZHEN","峙":"SHI","郍":"NA","芎":"XIONG","谁":"SHUI"};N.exports={PINYINS:U,UNIHANS:I,EXCEPTIONS:e}},function(N,A,t){"use strict";var I=t(0),U=t(1);I.isSupported()&&U.shouldPatch(I.genToken)&&I.patchDict(U),N.exports=I}])});
/*
 * JQuery zTree core v3.5.33
 * http://treejs.cn/
 *
 * Copyright (c) 2010 Hunter.z
 *
 * Licensed same as jquery - MIT License
 * http://www.opensource.org/licenses/mit-license.php
 *
 * email: hunter.z@263.net
 * Date: 2018-01-30
 */
(function(q){var H,I,J,K,L,M,u,s={},v={},w={},N={treeId:"",treeObj:null,view:{addDiyDom:null,autoCancelSelected:!0,dblClickExpand:!0,expandSpeed:"fast",fontCss:{},nameIsHTML:!1,selectedMulti:!0,showIcon:!0,showLine:!0,showTitle:!0,txtSelectedEnable:!1},data:{key:{isParent:"isParent",children:"children",name:"name",title:"",url:"url",icon:"icon"},simpleData:{enable:!1,idKey:"id",pIdKey:"pId",rootPId:null},keep:{parent:!1,leaf:!1}},async:{enable:!1,contentType:"application/x-www-form-urlencoded",type:"post",
dataType:"text",url:"",autoParam:[],otherParam:[],dataFilter:null},callback:{beforeAsync:null,beforeClick:null,beforeDblClick:null,beforeRightClick:null,beforeMouseDown:null,beforeMouseUp:null,beforeExpand:null,beforeCollapse:null,beforeRemove:null,onAsyncError:null,onAsyncSuccess:null,onNodeCreated:null,onClick:null,onDblClick:null,onRightClick:null,onMouseDown:null,onMouseUp:null,onExpand:null,onCollapse:null,onRemove:null}},x=[function(a){var b=a.treeObj,c=f.event;b.bind(c.NODECREATED,function(b,
c,h){j.apply(a.callback.onNodeCreated,[b,c,h])});b.bind(c.CLICK,function(b,c,h,e,m){j.apply(a.callback.onClick,[c,h,e,m])});b.bind(c.EXPAND,function(b,c,h){j.apply(a.callback.onExpand,[b,c,h])});b.bind(c.COLLAPSE,function(b,c,h){j.apply(a.callback.onCollapse,[b,c,h])});b.bind(c.ASYNC_SUCCESS,function(b,c,h,e){j.apply(a.callback.onAsyncSuccess,[b,c,h,e])});b.bind(c.ASYNC_ERROR,function(b,c,h,e,m,f){j.apply(a.callback.onAsyncError,[b,c,h,e,m,f])});b.bind(c.REMOVE,function(b,c,h){j.apply(a.callback.onRemove,
[b,c,h])});b.bind(c.SELECTED,function(b,c,h){j.apply(a.callback.onSelected,[c,h])});b.bind(c.UNSELECTED,function(b,c,h){j.apply(a.callback.onUnSelected,[c,h])})}],y=[function(a){var b=f.event;a.treeObj.unbind(b.NODECREATED).unbind(b.CLICK).unbind(b.EXPAND).unbind(b.COLLAPSE).unbind(b.ASYNC_SUCCESS).unbind(b.ASYNC_ERROR).unbind(b.REMOVE).unbind(b.SELECTED).unbind(b.UNSELECTED)}],z=[function(a){var b=e.getCache(a);b||(b={},e.setCache(a,b));b.nodes=[];b.doms=[]}],A=[function(a,b,c,d,g,h){if(c){var k=
e.getRoot(a),m=e.nodeChildren(a,c);c.level=b;c.tId=a.treeId+"_"+ ++k.zId;c.parentTId=d?d.tId:null;c.open=typeof c.open=="string"?j.eqs(c.open,"true"):!!c.open;b=e.nodeIsParent(a,c);j.isArray(m)&&!(b===!1||typeof b=="string"&&j.eqs(b,"false"))?(e.nodeIsParent(a,c,!0),c.zAsync=!0):(b=e.nodeIsParent(a,c,b),c.open=b&&!a.async.enable?c.open:!1,c.zAsync=!b);c.isFirstNode=g;c.isLastNode=h;c.getParentNode=function(){return e.getNodeCache(a,c.parentTId)};c.getPreNode=function(){return e.getPreNode(a,c)};c.getNextNode=
function(){return e.getNextNode(a,c)};c.getIndex=function(){return e.getNodeIndex(a,c)};c.getPath=function(){return e.getNodePath(a,c)};c.isAjaxing=!1;e.fixPIdKeyValue(a,c)}}],t=[function(a){var b=a.target,c=e.getSetting(a.data.treeId),d="",g=null,h="",k="",m=null,i=null,o=null;if(j.eqs(a.type,"mousedown"))k="mousedown";else if(j.eqs(a.type,"mouseup"))k="mouseup";else if(j.eqs(a.type,"contextmenu"))k="contextmenu";else if(j.eqs(a.type,"click"))if(j.eqs(b.tagName,"span")&&b.getAttribute("treeNode"+
f.id.SWITCH)!==null)d=j.getNodeMainDom(b).id,h="switchNode";else{if(o=j.getMDom(c,b,[{tagName:"a",attrName:"treeNode"+f.id.A}]))d=j.getNodeMainDom(o).id,h="clickNode"}else if(j.eqs(a.type,"dblclick")&&(k="dblclick",o=j.getMDom(c,b,[{tagName:"a",attrName:"treeNode"+f.id.A}])))d=j.getNodeMainDom(o).id,h="switchNode";if(k.length>0&&d.length==0&&(o=j.getMDom(c,b,[{tagName:"a",attrName:"treeNode"+f.id.A}])))d=j.getNodeMainDom(o).id;if(d.length>0)switch(g=e.getNodeCache(c,d),h){case "switchNode":e.nodeIsParent(c,
g)?j.eqs(a.type,"click")||j.eqs(a.type,"dblclick")&&j.apply(c.view.dblClickExpand,[c.treeId,g],c.view.dblClickExpand)?m=H:h="":h="";break;case "clickNode":m=I}switch(k){case "mousedown":i=J;break;case "mouseup":i=K;break;case "dblclick":i=L;break;case "contextmenu":i=M}return{stop:!1,node:g,nodeEventType:h,nodeEventCallback:m,treeEventType:k,treeEventCallback:i}}],B=[function(a){var b=e.getRoot(a);b||(b={},e.setRoot(a,b));e.nodeChildren(a,b,[]);b.expandTriggerFlag=!1;b.curSelectedList=[];b.noSelection=
!0;b.createdNodes=[];b.zId=0;b._ver=(new Date).getTime()}],C=[],D=[],E=[],F=[],G=[],e={addNodeCache:function(a,b){e.getCache(a).nodes[e.getNodeCacheId(b.tId)]=b},getNodeCacheId:function(a){return a.substring(a.lastIndexOf("_")+1)},addAfterA:function(a){D.push(a)},addBeforeA:function(a){C.push(a)},addInnerAfterA:function(a){F.push(a)},addInnerBeforeA:function(a){E.push(a)},addInitBind:function(a){x.push(a)},addInitUnBind:function(a){y.push(a)},addInitCache:function(a){z.push(a)},addInitNode:function(a){A.push(a)},
addInitProxy:function(a,b){b?t.splice(0,0,a):t.push(a)},addInitRoot:function(a){B.push(a)},addNodesData:function(a,b,c,d){var g=e.nodeChildren(a,b);g?c>=g.length&&(c=-1):(g=e.nodeChildren(a,b,[]),c=-1);if(g.length>0&&c===0)g[0].isFirstNode=!1,i.setNodeLineIcos(a,g[0]);else if(g.length>0&&c<0)g[g.length-1].isLastNode=!1,i.setNodeLineIcos(a,g[g.length-1]);e.nodeIsParent(a,b,!0);c<0?e.nodeChildren(a,b,g.concat(d)):(a=[c,0].concat(d),g.splice.apply(g,a))},addSelectedNode:function(a,b){var c=e.getRoot(a);
e.isSelectedNode(a,b)||c.curSelectedList.push(b)},addCreatedNode:function(a,b){(a.callback.onNodeCreated||a.view.addDiyDom)&&e.getRoot(a).createdNodes.push(b)},addZTreeTools:function(a){G.push(a)},exSetting:function(a){q.extend(!0,N,a)},fixPIdKeyValue:function(a,b){a.data.simpleData.enable&&(b[a.data.simpleData.pIdKey]=b.parentTId?b.getParentNode()[a.data.simpleData.idKey]:a.data.simpleData.rootPId)},getAfterA:function(a,b,c){for(var d=0,e=D.length;d<e;d++)D[d].apply(this,arguments)},getBeforeA:function(a,
b,c){for(var d=0,e=C.length;d<e;d++)C[d].apply(this,arguments)},getInnerAfterA:function(a,b,c){for(var d=0,e=F.length;d<e;d++)F[d].apply(this,arguments)},getInnerBeforeA:function(a,b,c){for(var d=0,e=E.length;d<e;d++)E[d].apply(this,arguments)},getCache:function(a){return w[a.treeId]},getNodeIndex:function(a,b){if(!b)return null;for(var c=b.parentTId?b.getParentNode():e.getRoot(a),c=e.nodeChildren(a,c),d=0,g=c.length-1;d<=g;d++)if(c[d]===b)return d;return-1},getNextNode:function(a,b){if(!b)return null;
for(var c=b.parentTId?b.getParentNode():e.getRoot(a),c=e.nodeChildren(a,c),d=0,g=c.length-1;d<=g;d++)if(c[d]===b)return d==g?null:c[d+1];return null},getNodeByParam:function(a,b,c,d){if(!b||!c)return null;for(var g=0,h=b.length;g<h;g++){var k=b[g];if(k[c]==d)return b[g];k=e.nodeChildren(a,k);if(k=e.getNodeByParam(a,k,c,d))return k}return null},getNodeCache:function(a,b){if(!b)return null;var c=w[a.treeId].nodes[e.getNodeCacheId(b)];return c?c:null},getNodePath:function(a,b){if(!b)return null;var c;
(c=b.parentTId?b.getParentNode().getPath():[])&&c.push(b);return c},getNodes:function(a){return e.nodeChildren(a,e.getRoot(a))},getNodesByParam:function(a,b,c,d){if(!b||!c)return[];for(var g=[],h=0,k=b.length;h<k;h++){var m=b[h];m[c]==d&&g.push(m);m=e.nodeChildren(a,m);g=g.concat(e.getNodesByParam(a,m,c,d))}return g},getNodesByParamFuzzy:function(a,b,c,d){if(!b||!c)return[];for(var g=[],d=d.toLowerCase(),h=0,k=b.length;h<k;h++){var m=b[h];typeof m[c]=="string"&&b[h][c].toLowerCase().indexOf(d)>-1&&
g.push(m);m=e.nodeChildren(a,m);g=g.concat(e.getNodesByParamFuzzy(a,m,c,d))}return g},getNodesByFilter:function(a,b,c,d,g){if(!b)return d?null:[];for(var h=d?null:[],k=0,m=b.length;k<m;k++){var f=b[k];if(j.apply(c,[f,g],!1)){if(d)return f;h.push(f)}f=e.nodeChildren(a,f);f=e.getNodesByFilter(a,f,c,d,g);if(d&&f)return f;h=d?f:h.concat(f)}return h},getPreNode:function(a,b){if(!b)return null;for(var c=b.parentTId?b.getParentNode():e.getRoot(a),c=e.nodeChildren(a,c),d=0,g=c.length;d<g;d++)if(c[d]===b)return d==
0?null:c[d-1];return null},getRoot:function(a){return a?v[a.treeId]:null},getRoots:function(){return v},getSetting:function(a){return s[a]},getSettings:function(){return s},getZTreeTools:function(a){return(a=this.getRoot(this.getSetting(a)))?a.treeTools:null},initCache:function(a){for(var b=0,c=z.length;b<c;b++)z[b].apply(this,arguments)},initNode:function(a,b,c,d,e,h){for(var k=0,f=A.length;k<f;k++)A[k].apply(this,arguments)},initRoot:function(a){for(var b=0,c=B.length;b<c;b++)B[b].apply(this,arguments)},
isSelectedNode:function(a,b){for(var c=e.getRoot(a),d=0,g=c.curSelectedList.length;d<g;d++)if(b===c.curSelectedList[d])return!0;return!1},nodeChildren:function(a,b,c){if(!b)return null;a=a.data.key.children;typeof c!=="undefined"&&(b[a]=c);return b[a]},nodeIsParent:function(a,b,c){if(!b)return!1;a=a.data.key.isParent;typeof c!=="undefined"&&(typeof c==="string"&&(c=j.eqs(c,"true")),b[a]=!!c);return b[a]},nodeName:function(a,b,c){a=a.data.key.name;typeof c!=="undefined"&&(b[a]=c);return""+b[a]},nodeTitle:function(a,
b){return""+b[a.data.key.title===""?a.data.key.name:a.data.key.title]},removeNodeCache:function(a,b){var c=e.nodeChildren(a,b);if(c)for(var d=0,g=c.length;d<g;d++)e.removeNodeCache(a,c[d]);e.getCache(a).nodes[e.getNodeCacheId(b.tId)]=null},removeSelectedNode:function(a,b){for(var c=e.getRoot(a),d=0,g=c.curSelectedList.length;d<g;d++)if(b===c.curSelectedList[d]||!e.getNodeCache(a,c.curSelectedList[d].tId))c.curSelectedList.splice(d,1),a.treeObj.trigger(f.event.UNSELECTED,[a.treeId,b]),d--,g--},setCache:function(a,
b){w[a.treeId]=b},setRoot:function(a,b){v[a.treeId]=b},setZTreeTools:function(a,b){for(var c=0,d=G.length;c<d;c++)G[c].apply(this,arguments)},transformToArrayFormat:function(a,b){function c(b){d.push(b);(b=e.nodeChildren(a,b))&&(d=d.concat(e.transformToArrayFormat(a,b)))}if(!b)return[];var d=[];if(j.isArray(b))for(var g=0,h=b.length;g<h;g++)c(b[g]);else c(b);return d},transformTozTreeFormat:function(a,b){var c,d,g=a.data.simpleData.idKey,h=a.data.simpleData.pIdKey;if(!g||g==""||!b)return[];if(j.isArray(b)){var k=
[],f={};for(c=0,d=b.length;c<d;c++)f[b[c][g]]=b[c];for(c=0,d=b.length;c<d;c++){var i=f[b[c][h]];if(i&&b[c][g]!=b[c][h]){var o=e.nodeChildren(a,i);o||(o=e.nodeChildren(a,i,[]));o.push(b[c])}else k.push(b[c])}return k}else return[b]}},n={bindEvent:function(a){for(var b=0,c=x.length;b<c;b++)x[b].apply(this,arguments)},unbindEvent:function(a){for(var b=0,c=y.length;b<c;b++)y[b].apply(this,arguments)},bindTree:function(a){var b={treeId:a.treeId},c=a.treeObj;a.view.txtSelectedEnable||c.bind("selectstart",
u).css({"-moz-user-select":"-moz-none"});c.bind("click",b,n.proxy);c.bind("dblclick",b,n.proxy);c.bind("mouseover",b,n.proxy);c.bind("mouseout",b,n.proxy);c.bind("mousedown",b,n.proxy);c.bind("mouseup",b,n.proxy);c.bind("contextmenu",b,n.proxy)},unbindTree:function(a){a.treeObj.unbind("selectstart",u).unbind("click",n.proxy).unbind("dblclick",n.proxy).unbind("mouseover",n.proxy).unbind("mouseout",n.proxy).unbind("mousedown",n.proxy).unbind("mouseup",n.proxy).unbind("contextmenu",n.proxy)},doProxy:function(a){for(var b=
[],c=0,d=t.length;c<d;c++){var e=t[c].apply(this,arguments);b.push(e);if(e.stop)break}return b},proxy:function(a){var b=e.getSetting(a.data.treeId);if(!j.uCanDo(b,a))return!0;for(var b=n.doProxy(a),c=!0,d=0,g=b.length;d<g;d++){var h=b[d];h.nodeEventCallback&&(c=h.nodeEventCallback.apply(h,[a,h.node])&&c);h.treeEventCallback&&(c=h.treeEventCallback.apply(h,[a,h.node])&&c)}return c}};H=function(a,b){var c=e.getSetting(a.data.treeId);if(b.open){if(j.apply(c.callback.beforeCollapse,[c.treeId,b],!0)==
!1)return!0}else if(j.apply(c.callback.beforeExpand,[c.treeId,b],!0)==!1)return!0;e.getRoot(c).expandTriggerFlag=!0;i.switchNode(c,b);return!0};I=function(a,b){var c=e.getSetting(a.data.treeId),d=c.view.autoCancelSelected&&(a.ctrlKey||a.metaKey)&&e.isSelectedNode(c,b)?0:c.view.autoCancelSelected&&(a.ctrlKey||a.metaKey)&&c.view.selectedMulti?2:1;if(j.apply(c.callback.beforeClick,[c.treeId,b,d],!0)==!1)return!0;d===0?i.cancelPreSelectedNode(c,b):i.selectNode(c,b,d===2);c.treeObj.trigger(f.event.CLICK,
[a,c.treeId,b,d]);return!0};J=function(a,b){var c=e.getSetting(a.data.treeId);j.apply(c.callback.beforeMouseDown,[c.treeId,b],!0)&&j.apply(c.callback.onMouseDown,[a,c.treeId,b]);return!0};K=function(a,b){var c=e.getSetting(a.data.treeId);j.apply(c.callback.beforeMouseUp,[c.treeId,b],!0)&&j.apply(c.callback.onMouseUp,[a,c.treeId,b]);return!0};L=function(a,b){var c=e.getSetting(a.data.treeId);j.apply(c.callback.beforeDblClick,[c.treeId,b],!0)&&j.apply(c.callback.onDblClick,[a,c.treeId,b]);return!0};
M=function(a,b){var c=e.getSetting(a.data.treeId);j.apply(c.callback.beforeRightClick,[c.treeId,b],!0)&&j.apply(c.callback.onRightClick,[a,c.treeId,b]);return typeof c.callback.onRightClick!="function"};u=function(a){a=a.originalEvent.srcElement.nodeName.toLowerCase();return a==="input"||a==="textarea"};var j={apply:function(a,b,c){return typeof a=="function"?a.apply(O,b?b:[]):c},canAsync:function(a,b){var c=e.nodeChildren(a,b),d=e.nodeIsParent(a,b);return a.async.enable&&b&&d&&!(b.zAsync||c&&c.length>
0)},clone:function(a){if(a===null)return null;var b=j.isArray(a)?[]:{},c;for(c in a)b[c]=a[c]instanceof Date?new Date(a[c].getTime()):typeof a[c]==="object"?j.clone(a[c]):a[c];return b},eqs:function(a,b){return a.toLowerCase()===b.toLowerCase()},isArray:function(a){return Object.prototype.toString.apply(a)==="[object Array]"},isElement:function(a){return typeof HTMLElement==="object"?a instanceof HTMLElement:a&&typeof a==="object"&&a!==null&&a.nodeType===1&&typeof a.nodeName==="string"},$:function(a,
b,c){b&&typeof b!="string"&&(c=b,b="");return typeof a=="string"?q(a,c?c.treeObj.get(0).ownerDocument:null):q("#"+a.tId+b,c?c.treeObj:null)},getMDom:function(a,b,c){if(!b)return null;for(;b&&b.id!==a.treeId;){for(var d=0,e=c.length;b.tagName&&d<e;d++)if(j.eqs(b.tagName,c[d].tagName)&&b.getAttribute(c[d].attrName)!==null)return b;b=b.parentNode}return null},getNodeMainDom:function(a){return q(a).parent("li").get(0)||q(a).parentsUntil("li").parent().get(0)},isChildOrSelf:function(a,b){return q(a).closest("#"+
b).length>0},uCanDo:function(){return!0}},i={addNodes:function(a,b,c,d,g){var h=e.nodeIsParent(a,b);if(!a.data.keep.leaf||!b||h)if(j.isArray(d)||(d=[d]),a.data.simpleData.enable&&(d=e.transformTozTreeFormat(a,d)),b){var h=l(b,f.id.SWITCH,a),k=l(b,f.id.ICON,a),m=l(b,f.id.UL,a);if(!b.open)i.replaceSwitchClass(b,h,f.folder.CLOSE),i.replaceIcoClass(b,k,f.folder.CLOSE),b.open=!1,m.css({display:"none"});e.addNodesData(a,b,c,d);i.createNodes(a,b.level+1,d,b,c);g||i.expandCollapseParentNode(a,b,!0)}else e.addNodesData(a,
e.getRoot(a),c,d),i.createNodes(a,0,d,null,c)},appendNodes:function(a,b,c,d,g,h,k){if(!c)return[];var f=[],j=d?d:e.getRoot(a),j=e.nodeChildren(a,j),o,l;if(!j||g>=j.length-c.length)g=-1;for(var n=0,Q=c.length;n<Q;n++){var p=c[n];h&&(o=(g===0||j.length==c.length)&&n==0,l=g<0&&n==c.length-1,e.initNode(a,b,p,d,o,l,k),e.addNodeCache(a,p));o=e.nodeIsParent(a,p);l=[];var q=e.nodeChildren(a,p);q&&q.length>0&&(l=i.appendNodes(a,b+1,q,p,-1,h,k&&p.open));k&&(i.makeDOMNodeMainBefore(f,a,p),i.makeDOMNodeLine(f,
a,p),e.getBeforeA(a,p,f),i.makeDOMNodeNameBefore(f,a,p),e.getInnerBeforeA(a,p,f),i.makeDOMNodeIcon(f,a,p),e.getInnerAfterA(a,p,f),i.makeDOMNodeNameAfter(f,a,p),e.getAfterA(a,p,f),o&&p.open&&i.makeUlHtml(a,p,f,l.join("")),i.makeDOMNodeMainAfter(f,a,p),e.addCreatedNode(a,p))}return f},appendParentULDom:function(a,b){var c=[],d=l(b,a);!d.get(0)&&b.parentTId&&(i.appendParentULDom(a,b.getParentNode()),d=l(b,a));var g=l(b,f.id.UL,a);g.get(0)&&g.remove();g=e.nodeChildren(a,b);g=i.appendNodes(a,b.level+1,
g,b,-1,!1,!0);i.makeUlHtml(a,b,c,g.join(""));d.append(c.join(""))},asyncNode:function(a,b,c,d){var g,h;g=e.nodeIsParent(a,b);if(b&&!g)return j.apply(d),!1;else if(b&&b.isAjaxing)return!1;else if(j.apply(a.callback.beforeAsync,[a.treeId,b],!0)==!1)return j.apply(d),!1;if(b)b.isAjaxing=!0,l(b,f.id.ICON,a).attr({style:"","class":f.className.BUTTON+" "+f.className.ICO_LOADING});var k={},m=j.apply(a.async.autoParam,[a.treeId,b],a.async.autoParam);for(g=0,h=m.length;b&&g<h;g++){var r=m[g].split("="),o=
r;r.length>1&&(o=r[1],r=r[0]);k[o]=b[r]}m=j.apply(a.async.otherParam,[a.treeId,b],a.async.otherParam);if(j.isArray(m))for(g=0,h=m.length;g<h;g+=2)k[m[g]]=m[g+1];else for(var n in m)k[n]=m[n];var P=e.getRoot(a)._ver;q.ajax({contentType:a.async.contentType,cache:!1,type:a.async.type,url:j.apply(a.async.url,[a.treeId,b],a.async.url),data:a.async.contentType.indexOf("application/json")>-1?JSON.stringify(k):k,dataType:a.async.dataType,success:function(h){if(P==e.getRoot(a)._ver){var k=[];try{k=!h||h.length==
0?[]:typeof h=="string"?eval("("+h+")"):h}catch(g){k=h}if(b)b.isAjaxing=null,b.zAsync=!0;i.setNodeLineIcos(a,b);k&&k!==""?(k=j.apply(a.async.dataFilter,[a.treeId,b,k],k),i.addNodes(a,b,-1,k?j.clone(k):[],!!c)):i.addNodes(a,b,-1,[],!!c);a.treeObj.trigger(f.event.ASYNC_SUCCESS,[a.treeId,b,h]);j.apply(d)}},error:function(c,d,h){if(P==e.getRoot(a)._ver){if(b)b.isAjaxing=null;i.setNodeLineIcos(a,b);a.treeObj.trigger(f.event.ASYNC_ERROR,[a.treeId,b,c,d,h])}}});return!0},cancelPreSelectedNode:function(a,
b,c){var d=e.getRoot(a).curSelectedList,g,h;for(g=d.length-1;g>=0;g--)if(h=d[g],b===h||!b&&(!c||c!==h))if(l(h,f.id.A,a).removeClass(f.node.CURSELECTED),b){e.removeSelectedNode(a,b);break}else d.splice(g,1),a.treeObj.trigger(f.event.UNSELECTED,[a.treeId,h])},createNodeCallback:function(a){if(a.callback.onNodeCreated||a.view.addDiyDom)for(var b=e.getRoot(a);b.createdNodes.length>0;){var c=b.createdNodes.shift();j.apply(a.view.addDiyDom,[a.treeId,c]);a.callback.onNodeCreated&&a.treeObj.trigger(f.event.NODECREATED,
[a.treeId,c])}},createNodes:function(a,b,c,d,g){if(c&&c.length!=0){var h=e.getRoot(a),k=!d||d.open||!!l(e.nodeChildren(a,d)[0],a).get(0);h.createdNodes=[];var b=i.appendNodes(a,b,c,d,g,!0,k),m,j;d?(d=l(d,f.id.UL,a),d.get(0)&&(m=d)):m=a.treeObj;m&&(g>=0&&(j=m.children()[g]),g>=0&&j?q(j).before(b.join("")):m.append(b.join("")));i.createNodeCallback(a)}},destroy:function(a){a&&(e.initCache(a),e.initRoot(a),n.unbindTree(a),n.unbindEvent(a),a.treeObj.empty(),delete s[a.treeId])},expandCollapseNode:function(a,
b,c,d,g){var h=e.getRoot(a),k;if(b){var m=e.nodeChildren(a,b),r=e.nodeIsParent(a,b);if(h.expandTriggerFlag)k=g,g=function(){k&&k();b.open?a.treeObj.trigger(f.event.EXPAND,[a.treeId,b]):a.treeObj.trigger(f.event.COLLAPSE,[a.treeId,b])},h.expandTriggerFlag=!1;if(!b.open&&r&&(!l(b,f.id.UL,a).get(0)||m&&m.length>0&&!l(m[0],a).get(0)))i.appendParentULDom(a,b),i.createNodeCallback(a);if(b.open==c)j.apply(g,[]);else{var c=l(b,f.id.UL,a),h=l(b,f.id.SWITCH,a),o=l(b,f.id.ICON,a);r?(b.open=!b.open,b.iconOpen&&
b.iconClose&&o.attr("style",i.makeNodeIcoStyle(a,b)),b.open?(i.replaceSwitchClass(b,h,f.folder.OPEN),i.replaceIcoClass(b,o,f.folder.OPEN),d==!1||a.view.expandSpeed==""?(c.show(),j.apply(g,[])):m&&m.length>0?c.slideDown(a.view.expandSpeed,g):(c.show(),j.apply(g,[]))):(i.replaceSwitchClass(b,h,f.folder.CLOSE),i.replaceIcoClass(b,o,f.folder.CLOSE),d==!1||a.view.expandSpeed==""||!(m&&m.length>0)?(c.hide(),j.apply(g,[])):c.slideUp(a.view.expandSpeed,g))):j.apply(g,[])}}else j.apply(g,[])},expandCollapseParentNode:function(a,
b,c,d,e){b&&(b.parentTId?(i.expandCollapseNode(a,b,c,d),b.parentTId&&i.expandCollapseParentNode(a,b.getParentNode(),c,d,e)):i.expandCollapseNode(a,b,c,d,e))},expandCollapseSonNode:function(a,b,c,d,g){var h=e.getRoot(a),h=b?e.nodeChildren(a,b):e.nodeChildren(a,h),k=b?!1:d,f=e.getRoot(a).expandTriggerFlag;e.getRoot(a).expandTriggerFlag=!1;if(h)for(var j=0,l=h.length;j<l;j++)h[j]&&i.expandCollapseSonNode(a,h[j],c,k);e.getRoot(a).expandTriggerFlag=f;i.expandCollapseNode(a,b,c,d,g)},isSelectedNode:function(a,
b){if(!b)return!1;var c=e.getRoot(a).curSelectedList,d;for(d=c.length-1;d>=0;d--)if(b===c[d])return!0;return!1},makeDOMNodeIcon:function(a,b,c){var d=e.nodeName(b,c),d=b.view.nameIsHTML?d:d.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");a.push("<span id='",c.tId,f.id.ICON,"' title='' treeNode",f.id.ICON," class='",i.makeNodeIcoClass(b,c),"' style='",i.makeNodeIcoStyle(b,c),"'></span><span id='",c.tId,f.id.SPAN,"' class='",f.className.NAME,"'>",d,"</span>")},makeDOMNodeLine:function(a,
b,c){a.push("<span id='",c.tId,f.id.SWITCH,"' title='' class='",i.makeNodeLineClass(b,c),"' treeNode",f.id.SWITCH,"></span>")},makeDOMNodeMainAfter:function(a){a.push("</li>")},makeDOMNodeMainBefore:function(a,b,c){a.push("<li id='",c.tId,"' class='",f.className.LEVEL,c.level,"' tabindex='0' hidefocus='true' treenode>")},makeDOMNodeNameAfter:function(a){a.push("</a>")},makeDOMNodeNameBefore:function(a,b,c){var d=e.nodeTitle(b,c),g=i.makeNodeUrl(b,c),h=i.makeNodeFontCss(b,c),k=[],m;for(m in h)k.push(m,
":",h[m],";");a.push("<a id='",c.tId,f.id.A,"' class='",f.className.LEVEL,c.level,"' treeNode",f.id.A,' onclick="',c.click||"",'" ',g!=null&&g.length>0?"href='"+g+"'":""," target='",i.makeNodeTarget(c),"' style='",k.join(""),"'");j.apply(b.view.showTitle,[b.treeId,c],b.view.showTitle)&&d&&a.push("title='",d.replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;"),"'");a.push(">")},makeNodeFontCss:function(a,b){var c=j.apply(a.view.fontCss,[a.treeId,b],a.view.fontCss);return c&&typeof c!="function"?
c:{}},makeNodeIcoClass:function(a,b){var c=["ico"];if(!b.isAjaxing){var d=e.nodeIsParent(a,b);c[0]=(b.iconSkin?b.iconSkin+"_":"")+c[0];d?c.push(b.open?f.folder.OPEN:f.folder.CLOSE):c.push(f.folder.DOCU)}return f.className.BUTTON+" "+c.join("_")},makeNodeIcoStyle:function(a,b){var c=[];if(!b.isAjaxing){var d=e.nodeIsParent(a,b)&&b.iconOpen&&b.iconClose?b.open?b.iconOpen:b.iconClose:b[a.data.key.icon];d&&c.push("background:url(",d,") 0 0 no-repeat;");(a.view.showIcon==!1||!j.apply(a.view.showIcon,[a.treeId,
b],!0))&&c.push("width:0px;height:0px;")}return c.join("")},makeNodeLineClass:function(a,b){var c=[];a.view.showLine?b.level==0&&b.isFirstNode&&b.isLastNode?c.push(f.line.ROOT):b.level==0&&b.isFirstNode?c.push(f.line.ROOTS):b.isLastNode?c.push(f.line.BOTTOM):c.push(f.line.CENTER):c.push(f.line.NOLINE);e.nodeIsParent(a,b)?c.push(b.open?f.folder.OPEN:f.folder.CLOSE):c.push(f.folder.DOCU);return i.makeNodeLineClassEx(b)+c.join("_")},makeNodeLineClassEx:function(a){return f.className.BUTTON+" "+f.className.LEVEL+
a.level+" "+f.className.SWITCH+" "},makeNodeTarget:function(a){return a.target||"_blank"},makeNodeUrl:function(a,b){var c=a.data.key.url;return b[c]?b[c]:null},makeUlHtml:function(a,b,c,d){c.push("<ul id='",b.tId,f.id.UL,"' class='",f.className.LEVEL,b.level," ",i.makeUlLineClass(a,b),"' style='display:",b.open?"block":"none","'>");c.push(d);c.push("</ul>")},makeUlLineClass:function(a,b){return a.view.showLine&&!b.isLastNode?f.line.LINE:""},removeChildNodes:function(a,b){if(b){var c=e.nodeChildren(a,
b);if(c){for(var d=0,g=c.length;d<g;d++)e.removeNodeCache(a,c[d]);e.removeSelectedNode(a);delete b[a.data.key.children];a.data.keep.parent?l(b,f.id.UL,a).empty():(e.nodeIsParent(a,b,!1),b.open=!1,c=l(b,f.id.SWITCH,a),d=l(b,f.id.ICON,a),i.replaceSwitchClass(b,c,f.folder.DOCU),i.replaceIcoClass(b,d,f.folder.DOCU),l(b,f.id.UL,a).remove())}}},scrollIntoView:function(a,b){if(b)if(typeof Element==="undefined"){var c=a.treeObj.get(0).getBoundingClientRect(),d=b.getBoundingClientRect();(d.top<c.top||d.bottom>
c.bottom||d.right>c.right||d.left<c.left)&&b.scrollIntoView()}else{if(!Element.prototype.scrollIntoViewIfNeeded)Element.prototype.scrollIntoViewIfNeeded=function(a){function b(a,c,d,f){return{left:a,top:c,width:d,height:f,right:a+d,bottom:c+f,translate:function(e,g){return b(e+a,g+c,d,f)},relativeFromTo:function(g,k){var i=a,j=c,g=g.offsetParent,k=k.offsetParent;if(g===k)return e;for(;g;g=g.offsetParent)i+=g.offsetLeft+g.clientLeft,j+=g.offsetTop+g.clientTop;for(;k;k=k.offsetParent)i-=k.offsetLeft+
k.clientLeft,j-=k.offsetTop+k.clientTop;return b(i,j,d,f)}}}for(var c,d=this,e=b(this.offsetLeft,this.offsetTop,this.offsetWidth,this.offsetHeight);j.isElement(c=d.parentNode);){var f=c.offsetLeft+c.clientLeft,i=c.offsetTop+c.clientTop,e=e.relativeFromTo(d,c).translate(-f,-i);c.scrollLeft=!1===a||e.left<=c.scrollLeft+c.clientWidth&&c.scrollLeft<=e.right-c.clientWidth+c.clientWidth?Math.min(e.left,Math.max(e.right-c.clientWidth,c.scrollLeft)):(e.right-c.clientWidth+e.left)/2;c.scrollTop=!1===a||e.top<=
c.scrollTop+c.clientHeight&&c.scrollTop<=e.bottom-c.clientHeight+c.clientHeight?Math.min(e.top,Math.max(e.bottom-c.clientHeight,c.scrollTop)):(e.bottom-c.clientHeight+e.top)/2;e=e.translate(f-c.scrollLeft,i-c.scrollTop);d=c}};b.scrollIntoViewIfNeeded()}},setFirstNode:function(a,b){var c=e.nodeChildren(a,b);if(c.length>0)c[0].isFirstNode=!0},setLastNode:function(a,b){var c=e.nodeChildren(a,b);if(c.length>0)c[c.length-1].isLastNode=!0},removeNode:function(a,b){var c=e.getRoot(a),d=b.parentTId?b.getParentNode():
c;b.isFirstNode=!1;b.isLastNode=!1;b.getPreNode=function(){return null};b.getNextNode=function(){return null};if(e.getNodeCache(a,b.tId)){l(b,a).remove();e.removeNodeCache(a,b);e.removeSelectedNode(a,b);for(var g=e.nodeChildren(a,d),h=0,k=g.length;h<k;h++)if(g[h].tId==b.tId){g.splice(h,1);break}i.setFirstNode(a,d);i.setLastNode(a,d);var j,h=g.length;if(!a.data.keep.parent&&h==0)e.nodeIsParent(a,d,!1),d.open=!1,delete d[a.data.key.children],h=l(d,f.id.UL,a),k=l(d,f.id.SWITCH,a),j=l(d,f.id.ICON,a),
i.replaceSwitchClass(d,k,f.folder.DOCU),i.replaceIcoClass(d,j,f.folder.DOCU),h.css("display","none");else if(a.view.showLine&&h>0){var r=g[h-1],h=l(r,f.id.UL,a),k=l(r,f.id.SWITCH,a);j=l(r,f.id.ICON,a);d==c?g.length==1?i.replaceSwitchClass(r,k,f.line.ROOT):(c=l(g[0],f.id.SWITCH,a),i.replaceSwitchClass(g[0],c,f.line.ROOTS),i.replaceSwitchClass(r,k,f.line.BOTTOM)):i.replaceSwitchClass(r,k,f.line.BOTTOM);h.removeClass(f.line.LINE)}}},replaceIcoClass:function(a,b,c){if(b&&!a.isAjaxing&&(a=b.attr("class"),
a!=void 0)){a=a.split("_");switch(c){case f.folder.OPEN:case f.folder.CLOSE:case f.folder.DOCU:a[a.length-1]=c}b.attr("class",a.join("_"))}},replaceSwitchClass:function(a,b,c){if(b){var d=b.attr("class");if(d!=void 0){d=d.split("_");switch(c){case f.line.ROOT:case f.line.ROOTS:case f.line.CENTER:case f.line.BOTTOM:case f.line.NOLINE:d[0]=i.makeNodeLineClassEx(a)+c;break;case f.folder.OPEN:case f.folder.CLOSE:case f.folder.DOCU:d[1]=c}b.attr("class",d.join("_"));c!==f.folder.DOCU?b.removeAttr("disabled"):
b.attr("disabled","disabled")}}},selectNode:function(a,b,c){c||i.cancelPreSelectedNode(a,null,b);l(b,f.id.A,a).addClass(f.node.CURSELECTED);e.addSelectedNode(a,b);a.treeObj.trigger(f.event.SELECTED,[a.treeId,b])},setNodeFontCss:function(a,b){var c=l(b,f.id.A,a),d=i.makeNodeFontCss(a,b);d&&c.css(d)},setNodeLineIcos:function(a,b){if(b){var c=l(b,f.id.SWITCH,a),d=l(b,f.id.UL,a),g=l(b,f.id.ICON,a),h=i.makeUlLineClass(a,b);h.length==0?d.removeClass(f.line.LINE):d.addClass(h);c.attr("class",i.makeNodeLineClass(a,
b));e.nodeIsParent(a,b)?c.removeAttr("disabled"):c.attr("disabled","disabled");g.removeAttr("style");g.attr("style",i.makeNodeIcoStyle(a,b));g.attr("class",i.makeNodeIcoClass(a,b))}},setNodeName:function(a,b){var c=e.nodeTitle(a,b),d=l(b,f.id.SPAN,a);d.empty();a.view.nameIsHTML?d.html(e.nodeName(a,b)):d.text(e.nodeName(a,b));j.apply(a.view.showTitle,[a.treeId,b],a.view.showTitle)&&l(b,f.id.A,a).attr("title",!c?"":c)},setNodeTarget:function(a,b){l(b,f.id.A,a).attr("target",i.makeNodeTarget(b))},setNodeUrl:function(a,
b){var c=l(b,f.id.A,a),d=i.makeNodeUrl(a,b);d==null||d.length==0?c.removeAttr("href"):c.attr("href",d)},switchNode:function(a,b){b.open||!j.canAsync(a,b)?i.expandCollapseNode(a,b,!b.open):a.async.enable?i.asyncNode(a,b)||i.expandCollapseNode(a,b,!b.open):b&&i.expandCollapseNode(a,b,!b.open)}};q.fn.zTree={consts:{className:{BUTTON:"button",LEVEL:"level",ICO_LOADING:"ico_loading",SWITCH:"switch",NAME:"node_name"},event:{NODECREATED:"ztree_nodeCreated",CLICK:"ztree_click",EXPAND:"ztree_expand",COLLAPSE:"ztree_collapse",
ASYNC_SUCCESS:"ztree_async_success",ASYNC_ERROR:"ztree_async_error",REMOVE:"ztree_remove",SELECTED:"ztree_selected",UNSELECTED:"ztree_unselected"},id:{A:"_a",ICON:"_ico",SPAN:"_span",SWITCH:"_switch",UL:"_ul"},line:{ROOT:"root",ROOTS:"roots",CENTER:"center",BOTTOM:"bottom",NOLINE:"noline",LINE:"line"},folder:{OPEN:"open",CLOSE:"close",DOCU:"docu"},node:{CURSELECTED:"curSelectedNode"}},_z:{tools:j,view:i,event:n,data:e},getZTreeObj:function(a){return(a=e.getZTreeTools(a))?a:null},destroy:function(a){if(a&&
a.length>0)i.destroy(e.getSetting(a));else for(var b in s)i.destroy(s[b])},init:function(a,b,c){var d=j.clone(N);q.extend(!0,d,b);d.treeId=a.attr("id");d.treeObj=a;d.treeObj.empty();s[d.treeId]=d;if(typeof document.body.style.maxHeight==="undefined")d.view.expandSpeed="";e.initRoot(d);a=e.getRoot(d);c=c?j.clone(j.isArray(c)?c:[c]):[];d.data.simpleData.enable?e.nodeChildren(d,a,e.transformTozTreeFormat(d,c)):e.nodeChildren(d,a,c);e.initCache(d);n.unbindTree(d);n.bindTree(d);n.unbindEvent(d);n.bindEvent(d);
var g={setting:d,addNodes:function(a,b,c,g){function f(){i.addNodes(d,a,b,n,g==!0)}a||(a=null);var l=e.nodeIsParent(d,a);if(a&&!l&&d.data.keep.leaf)return null;l=parseInt(b,10);isNaN(l)?(g=!!c,c=b,b=-1):b=l;if(!c)return null;var n=j.clone(j.isArray(c)?c:[c]);j.canAsync(d,a)?i.asyncNode(d,a,g,f):f();return n},cancelSelectedNode:function(a){i.cancelPreSelectedNode(d,a)},destroy:function(){i.destroy(d)},expandAll:function(a){a=!!a;i.expandCollapseSonNode(d,null,a,!0);return a},expandNode:function(a,
b,c,g,f){function n(){var b=l(a,d).get(0);b&&g!==!1&&i.scrollIntoView(d,b)}if(!a||!e.nodeIsParent(d,a))return null;b!==!0&&b!==!1&&(b=!a.open);if((f=!!f)&&b&&j.apply(d.callback.beforeExpand,[d.treeId,a],!0)==!1)return null;else if(f&&!b&&j.apply(d.callback.beforeCollapse,[d.treeId,a],!0)==!1)return null;b&&a.parentTId&&i.expandCollapseParentNode(d,a.getParentNode(),b,!1);if(b===a.open&&!c)return null;e.getRoot(d).expandTriggerFlag=f;!j.canAsync(d,a)&&c?i.expandCollapseSonNode(d,a,b,!0,n):(a.open=
!b,i.switchNode(this.setting,a),n());return b},getNodes:function(){return e.getNodes(d)},getNodeByParam:function(a,b,c){return!a?null:e.getNodeByParam(d,c?e.nodeChildren(d,c):e.getNodes(d),a,b)},getNodeByTId:function(a){return e.getNodeCache(d,a)},getNodesByParam:function(a,b,c){return!a?null:e.getNodesByParam(d,c?e.nodeChildren(d,c):e.getNodes(d),a,b)},getNodesByParamFuzzy:function(a,b,c){return!a?null:e.getNodesByParamFuzzy(d,c?e.nodeChildren(d,c):e.getNodes(d),a,b)},getNodesByFilter:function(a,
b,c,f){b=!!b;return!a||typeof a!="function"?b?null:[]:e.getNodesByFilter(d,c?e.nodeChildren(d,c):e.getNodes(d),a,b,f)},getNodeIndex:function(a){if(!a)return null;for(var b=a.parentTId?a.getParentNode():e.getRoot(d),b=e.nodeChildren(d,b),c=0,f=b.length;c<f;c++)if(b[c]==a)return c;return-1},getSelectedNodes:function(){for(var a=[],b=e.getRoot(d).curSelectedList,c=0,f=b.length;c<f;c++)a.push(b[c]);return a},isSelectedNode:function(a){return e.isSelectedNode(d,a)},reAsyncChildNodesPromise:function(a,
b,c){return new Promise(function(d,e){try{g.reAsyncChildNodes(a,b,c,function(){d(a)})}catch(f){e(f)}})},reAsyncChildNodes:function(a,b,c,g){if(this.setting.async.enable){var j=!a;j&&(a=e.getRoot(d));if(b=="refresh"){for(var b=e.nodeChildren(d,a),n=0,q=b?b.length:0;n<q;n++)e.removeNodeCache(d,b[n]);e.removeSelectedNode(d);e.nodeChildren(d,a,[]);j?this.setting.treeObj.empty():l(a,f.id.UL,d).empty()}i.asyncNode(this.setting,j?null:a,!!c,g)}},refresh:function(){this.setting.treeObj.empty();var a=e.getRoot(d),
b=e.nodeChildren(d,a);e.initRoot(d);e.nodeChildren(d,a,b);e.initCache(d);i.createNodes(d,0,e.nodeChildren(d,a),null,-1)},removeChildNodes:function(a){if(!a)return null;var b=e.nodeChildren(d,a);i.removeChildNodes(d,a);return b?b:null},removeNode:function(a,b){a&&(b=!!b,b&&j.apply(d.callback.beforeRemove,[d.treeId,a],!0)==!1||(i.removeNode(d,a),b&&this.setting.treeObj.trigger(f.event.REMOVE,[d.treeId,a])))},selectNode:function(a,b,c){function e(){if(!c){var b=l(a,d).get(0);i.scrollIntoView(d,b)}}if(a&&
j.uCanDo(d)){b=d.view.selectedMulti&&b;if(a.parentTId)i.expandCollapseParentNode(d,a.getParentNode(),!0,!1,e);else if(!c)try{l(a,d).focus().blur()}catch(f){}i.selectNode(d,a,b)}},transformTozTreeNodes:function(a){return e.transformTozTreeFormat(d,a)},transformToArray:function(a){return e.transformToArrayFormat(d,a)},updateNode:function(a){a&&l(a,d).get(0)&&j.uCanDo(d)&&(i.setNodeName(d,a),i.setNodeTarget(d,a),i.setNodeUrl(d,a),i.setNodeLineIcos(d,a),i.setNodeFontCss(d,a))}};a.treeTools=g;e.setZTreeTools(d,
g);(c=e.nodeChildren(d,a))&&c.length>0?i.createNodes(d,0,c,null,-1):d.async.enable&&d.async.url&&d.async.url!==""&&i.asyncNode(d);return g}};var O=q.fn.zTree,l=j.$,f=O.consts})(jQuery);

/*
 * JQuery zTree excheck v3.5.33
 * http://treejs.cn/
 *
 * Copyright (c) 2010 Hunter.z
 *
 * Licensed same as jquery - MIT License
 * http://www.opensource.org/licenses/mit-license.php
 *
 * email: hunter.z@263.net
 * Date: 2018-01-30
 */
(function(n){var q,r,s,p={event:{CHECK:"ztree_check"},id:{CHECK:"_check"},checkbox:{STYLE:"checkbox",DEFAULT:"chk",DISABLED:"disable",FALSE:"false",TRUE:"true",FULL:"full",PART:"part",FOCUS:"focus"},radio:{STYLE:"radio",TYPE_ALL:"all",TYPE_LEVEL:"level"}},w={check:{enable:!1,autoCheckTrigger:!1,chkStyle:p.checkbox.STYLE,nocheckInherit:!1,chkDisabledInherit:!1,radioType:p.radio.TYPE_LEVEL,chkboxType:{Y:"ps",N:"ps"}},data:{key:{checked:"checked"}},callback:{beforeCheck:null,onCheck:null}};q=function(c,
a){if(a.chkDisabled===!0)return!1;var b=e.getSetting(c.data.treeId);if(i.apply(b.callback.beforeCheck,[b.treeId,a],!0)==!1)return!0;var d=e.nodeChecked(b,a);e.nodeChecked(b,a,!d);f.checkNodeRelation(b,a);d=m(a,h.id.CHECK,b);f.setChkClass(b,d,a);f.repairParentChkClassWithSelf(b,a);b.treeObj.trigger(h.event.CHECK,[c,b.treeId,a]);return!0};r=function(c,a){if(a.chkDisabled===!0)return!1;var b=e.getSetting(c.data.treeId),d=m(a,h.id.CHECK,b);a.check_Focus=!0;f.setChkClass(b,d,a);return!0};s=function(c,
a){if(a.chkDisabled===!0)return!1;var b=e.getSetting(c.data.treeId),d=m(a,h.id.CHECK,b);a.check_Focus=!1;f.setChkClass(b,d,a);return!0};n.extend(!0,n.fn.zTree.consts,p);n.extend(!0,n.fn.zTree._z,{tools:{},view:{checkNodeRelation:function(c,a){var b,d,j;d=h.radio;b=e.nodeChecked(c,a);if(c.check.chkStyle==d.STYLE){var g=e.getRadioCheckedList(c);if(b)if(c.check.radioType==d.TYPE_ALL){for(d=g.length-1;d>=0;d--){b=g[d];var k=e.nodeChecked(c,b);k&&b!=a&&(e.nodeChecked(c,b,!1),g.splice(d,1),f.setChkClass(c,
m(b,h.id.CHECK,c),b),b.parentTId!=a.parentTId&&f.repairParentChkClassWithSelf(c,b))}g.push(a)}else{g=a.parentTId?a.getParentNode():e.getRoot(c);g=e.nodeChildren(c,g);for(d=0,j=g.length;d<j;d++)if(b=g[d],(k=e.nodeChecked(c,b))&&b!=a)e.nodeChecked(c,b,!1),f.setChkClass(c,m(b,h.id.CHECK,c),b)}else if(c.check.radioType==d.TYPE_ALL)for(d=0,j=g.length;d<j;d++)if(a==g[d]){g.splice(d,1);break}}else g=e.nodeChildren(c,a),b&&(!g||g.length==0||c.check.chkboxType.Y.indexOf("s")>-1)&&f.setSonNodeCheckBox(c,a,
!0),!b&&(!g||g.length==0||c.check.chkboxType.N.indexOf("s")>-1)&&f.setSonNodeCheckBox(c,a,!1),b&&c.check.chkboxType.Y.indexOf("p")>-1&&f.setParentNodeCheckBox(c,a,!0),!b&&c.check.chkboxType.N.indexOf("p")>-1&&f.setParentNodeCheckBox(c,a,!1)},makeChkClass:function(c,a){var b=h.checkbox,d=h.radio,j="",g=e.nodeChecked(c,a),j=a.chkDisabled===!0?b.DISABLED:a.halfCheck?b.PART:c.check.chkStyle==d.STYLE?a.check_Child_State<1?b.FULL:b.PART:g?a.check_Child_State===2||a.check_Child_State===-1?b.FULL:b.PART:
a.check_Child_State<1?b.FULL:b.PART,d=c.check.chkStyle+"_"+(g?b.TRUE:b.FALSE)+"_"+j,d=a.check_Focus&&a.chkDisabled!==!0?d+"_"+b.FOCUS:d;return h.className.BUTTON+" "+b.DEFAULT+" "+d},repairAllChk:function(c,a){if(c.check.enable&&c.check.chkStyle===h.checkbox.STYLE)for(var b=e.getRoot(c),b=e.nodeChildren(c,b),d=0,j=b.length;d<j;d++){var g=b[d];g.nocheck!==!0&&g.chkDisabled!==!0&&e.nodeChecked(c,g,a);f.setSonNodeCheckBox(c,g,a)}},repairChkClass:function(c,a){if(a&&(e.makeChkFlag(c,a),a.nocheck!==!0)){var b=
m(a,h.id.CHECK,c);f.setChkClass(c,b,a)}},repairParentChkClass:function(c,a){if(a&&a.parentTId){var b=a.getParentNode();f.repairChkClass(c,b);f.repairParentChkClass(c,b)}},repairParentChkClassWithSelf:function(c,a){if(a){var b=e.nodeChildren(c,a);b&&b.length>0?f.repairParentChkClass(c,b[0]):f.repairParentChkClass(c,a)}},repairSonChkDisabled:function(c,a,b,d){if(a){if(a.chkDisabled!=b)a.chkDisabled=b;f.repairChkClass(c,a);if((a=e.nodeChildren(c,a))&&d)for(var j=0,g=a.length;j<g;j++)f.repairSonChkDisabled(c,
a[j],b,d)}},repairParentChkDisabled:function(c,a,b,d){if(a){if(a.chkDisabled!=b&&d)a.chkDisabled=b;f.repairChkClass(c,a);f.repairParentChkDisabled(c,a.getParentNode(),b,d)}},setChkClass:function(c,a,b){a&&(b.nocheck===!0?a.hide():a.show(),a.attr("class",f.makeChkClass(c,b)))},setParentNodeCheckBox:function(c,a,b,d){var j=m(a,h.id.CHECK,c);d||(d=a);e.makeChkFlag(c,a);a.nocheck!==!0&&a.chkDisabled!==!0&&(e.nodeChecked(c,a,b),f.setChkClass(c,j,a),c.check.autoCheckTrigger&&a!=d&&c.treeObj.trigger(h.event.CHECK,
[null,c.treeId,a]));if(a.parentTId){j=!0;if(!b)for(var g=e.nodeChildren(c,a.getParentNode()),k=0,o=g.length;k<o;k++){var l=g[k],i=e.nodeChecked(c,l);if(l.nocheck!==!0&&l.chkDisabled!==!0&&i||(l.nocheck===!0||l.chkDisabled===!0)&&l.check_Child_State>0){j=!1;break}}j&&f.setParentNodeCheckBox(c,a.getParentNode(),b,d)}},setSonNodeCheckBox:function(c,a,b,d){if(a){var j=m(a,h.id.CHECK,c);d||(d=a);var g=!1,k=e.nodeChildren(c,a);if(k)for(var o=0,l=k.length;o<l;o++){var i=k[o];f.setSonNodeCheckBox(c,i,b,d);
i.chkDisabled===!0&&(g=!0)}if(a!=e.getRoot(c)&&a.chkDisabled!==!0){g&&a.nocheck!==!0&&e.makeChkFlag(c,a);if(a.nocheck!==!0&&a.chkDisabled!==!0){if(e.nodeChecked(c,a,b),!g)a.check_Child_State=k&&k.length>0?b?2:0:-1}else a.check_Child_State=-1;f.setChkClass(c,j,a);c.check.autoCheckTrigger&&a!=d&&a.nocheck!==!0&&a.chkDisabled!==!0&&c.treeObj.trigger(h.event.CHECK,[null,c.treeId,a])}}}},event:{},data:{getRadioCheckedList:function(c){for(var a=e.getRoot(c).radioCheckedList,b=0,d=a.length;b<d;b++)e.getNodeCache(c,
a[b].tId)||(a.splice(b,1),b--,d--);return a},getCheckStatus:function(c,a){if(!c.check.enable||a.nocheck||a.chkDisabled)return null;var b=e.nodeChecked(c,a);return{checked:b,half:a.halfCheck?a.halfCheck:c.check.chkStyle==h.radio.STYLE?a.check_Child_State===2:b?a.check_Child_State>-1&&a.check_Child_State<2:a.check_Child_State>0}},getTreeCheckedNodes:function(c,a,b,d){if(!a)return[];for(var j=b&&c.check.chkStyle==h.radio.STYLE&&c.check.radioType==h.radio.TYPE_ALL,d=!d?[]:d,g=0,f=a.length;g<f;g++){var i=
a[g],l=e.nodeChildren(c,i),m=e.nodeChecked(c,i);if(i.nocheck!==!0&&i.chkDisabled!==!0&&m==b&&(d.push(i),j))break;e.getTreeCheckedNodes(c,l,b,d);if(j&&d.length>0)break}return d},getTreeChangeCheckedNodes:function(c,a,b){if(!a)return[];for(var b=!b?[]:b,d=0,j=a.length;d<j;d++){var g=a[d],f=e.nodeChildren(c,g),h=e.nodeChecked(c,g);g.nocheck!==!0&&g.chkDisabled!==!0&&h!=g.checkedOld&&b.push(g);e.getTreeChangeCheckedNodes(c,f,b)}return b},makeChkFlag:function(c,a){if(a){var b=-1,d=e.nodeChildren(c,a);
if(d)for(var j=0,g=d.length;j<g;j++){var f=d[j],i=e.nodeChecked(c,f),l=-1;if(c.check.chkStyle==h.radio.STYLE)if(l=f.nocheck===!0||f.chkDisabled===!0?f.check_Child_State:f.halfCheck===!0?2:i?2:f.check_Child_State>0?2:0,l==2){b=2;break}else l==0&&(b=0);else if(c.check.chkStyle==h.checkbox.STYLE)if(l=f.nocheck===!0||f.chkDisabled===!0?f.check_Child_State:f.halfCheck===!0?1:i?f.check_Child_State===-1||f.check_Child_State===2?2:1:f.check_Child_State>0?1:0,l===1){b=1;break}else if(l===2&&b>-1&&j>0&&l!==
b){b=1;break}else if(b===2&&l>-1&&l<2){b=1;break}else l>-1&&(b=l)}a.check_Child_State=b}}}});var n=n.fn.zTree,i=n._z.tools,h=n.consts,f=n._z.view,e=n._z.data,m=i.$;e.nodeChecked=function(c,a,b){if(!a)return!1;c=c.data.key.checked;typeof b!=="undefined"&&(typeof b==="string"&&(b=i.eqs(checked,"true")),a[c]=!!b);return a[c]};e.exSetting(w);e.addInitBind(function(c){c.treeObj.bind(h.event.CHECK,function(a,b,d,e){a.srcEvent=b;i.apply(c.callback.onCheck,[a,d,e])})});e.addInitUnBind(function(c){c.treeObj.unbind(h.event.CHECK)});
e.addInitCache(function(){});e.addInitNode(function(c,a,b,d){if(b){a=e.nodeChecked(c,b);a=e.nodeChecked(c,b,a);b.checkedOld=a;if(typeof b.nocheck=="string")b.nocheck=i.eqs(b.nocheck,"true");b.nocheck=!!b.nocheck||c.check.nocheckInherit&&d&&!!d.nocheck;if(typeof b.chkDisabled=="string")b.chkDisabled=i.eqs(b.chkDisabled,"true");b.chkDisabled=!!b.chkDisabled||c.check.chkDisabledInherit&&d&&!!d.chkDisabled;if(typeof b.halfCheck=="string")b.halfCheck=i.eqs(b.halfCheck,"true");b.halfCheck=!!b.halfCheck;
b.check_Child_State=-1;b.check_Focus=!1;b.getCheckStatus=function(){return e.getCheckStatus(c,b)};c.check.chkStyle==h.radio.STYLE&&c.check.radioType==h.radio.TYPE_ALL&&a&&e.getRoot(c).radioCheckedList.push(b)}});e.addInitProxy(function(c){var a=c.target,b=e.getSetting(c.data.treeId),d="",f=null,g="",k=null;if(i.eqs(c.type,"mouseover")){if(b.check.enable&&i.eqs(a.tagName,"span")&&a.getAttribute("treeNode"+h.id.CHECK)!==null)d=i.getNodeMainDom(a).id,g="mouseoverCheck"}else if(i.eqs(c.type,"mouseout")){if(b.check.enable&&
i.eqs(a.tagName,"span")&&a.getAttribute("treeNode"+h.id.CHECK)!==null)d=i.getNodeMainDom(a).id,g="mouseoutCheck"}else if(i.eqs(c.type,"click")&&b.check.enable&&i.eqs(a.tagName,"span")&&a.getAttribute("treeNode"+h.id.CHECK)!==null)d=i.getNodeMainDom(a).id,g="checkNode";if(d.length>0)switch(f=e.getNodeCache(b,d),g){case "checkNode":k=q;break;case "mouseoverCheck":k=r;break;case "mouseoutCheck":k=s}return{stop:g==="checkNode",node:f,nodeEventType:g,nodeEventCallback:k,treeEventType:"",treeEventCallback:null}},
!0);e.addInitRoot(function(c){e.getRoot(c).radioCheckedList=[]});e.addBeforeA(function(c,a,b){c.check.enable&&(e.makeChkFlag(c,a),b.push("<span ID='",a.tId,h.id.CHECK,"' class='",f.makeChkClass(c,a),"' treeNode",h.id.CHECK,a.nocheck===!0?" style='display:none;'":"","></span>"))});e.addZTreeTools(function(c,a){a.checkNode=function(a,b,g,k){var o=e.nodeChecked(c,a);if(a.chkDisabled!==!0&&(b!==!0&&b!==!1&&(b=!o),k=!!k,(o!==b||g)&&!(k&&i.apply(this.setting.callback.beforeCheck,[this.setting.treeId,a],
!0)==!1)&&i.uCanDo(this.setting)&&this.setting.check.enable&&a.nocheck!==!0))e.nodeChecked(c,a,b),b=m(a,h.id.CHECK,this.setting),(g||this.setting.check.chkStyle===h.radio.STYLE)&&f.checkNodeRelation(this.setting,a),f.setChkClass(this.setting,b,a),f.repairParentChkClassWithSelf(this.setting,a),k&&this.setting.treeObj.trigger(h.event.CHECK,[null,this.setting.treeId,a])};a.checkAllNodes=function(a){f.repairAllChk(this.setting,!!a)};a.getCheckedNodes=function(a){var a=a!==!1,b=e.nodeChildren(c,e.getRoot(this.setting));
return e.getTreeCheckedNodes(this.setting,b,a)};a.getChangeCheckedNodes=function(){var a=e.nodeChildren(c,e.getRoot(this.setting));return e.getTreeChangeCheckedNodes(this.setting,a)};a.setChkDisabled=function(a,b,c,e){b=!!b;c=!!c;f.repairSonChkDisabled(this.setting,a,b,!!e);f.repairParentChkDisabled(this.setting,a.getParentNode(),b,c)};var b=a.updateNode;a.updateNode=function(c,e){b&&b.apply(a,arguments);if(c&&this.setting.check.enable&&m(c,this.setting).get(0)&&i.uCanDo(this.setting)){var g=m(c,
h.id.CHECK,this.setting);(e==!0||this.setting.check.chkStyle===h.radio.STYLE)&&f.checkNodeRelation(this.setting,c);f.setChkClass(this.setting,g,c);f.repairParentChkClassWithSelf(this.setting,c)}}});var t=f.createNodes;f.createNodes=function(c,a,b,d,e){t&&t.apply(f,arguments);b&&f.repairParentChkClassWithSelf(c,d)};var u=f.removeNode;f.removeNode=function(c,a){var b=a.getParentNode();u&&u.apply(f,arguments);a&&b&&(f.repairChkClass(c,b),f.repairParentChkClass(c,b))};var v=f.appendNodes;f.appendNodes=
function(c,a,b,d,h,g,i){var m="";v&&(m=v.apply(f,arguments));d&&e.makeChkFlag(c,d);return m}})(jQuery);

/*
 * JQuery zTree exedit v3.5.33
 * http://treejs.cn/
 *
 * Copyright (c) 2010 Hunter.z
 *
 * Licensed same as jquery - MIT License
 * http://www.opensource.org/licenses/mit-license.php
 *
 * email: hunter.z@263.net
 * Date: 2018-01-30
 */
(function(B){var I={event:{DRAG:"ztree_drag",DROP:"ztree_drop",RENAME:"ztree_rename",DRAGMOVE:"ztree_dragmove"},id:{EDIT:"_edit",INPUT:"_input",REMOVE:"_remove"},move:{TYPE_INNER:"inner",TYPE_PREV:"prev",TYPE_NEXT:"next"},node:{CURSELECTED_EDIT:"curSelectedNode_Edit",TMPTARGET_TREE:"tmpTargetzTree",TMPTARGET_NODE:"tmpTargetNode"}},v={onHoverOverNode:function(a,b){var c=i.getSetting(a.data.treeId),d=i.getRoot(c);if(d.curHoverNode!=b)v.onHoverOutNode(a);d.curHoverNode=b;e.addHoverDom(c,b)},onHoverOutNode:function(a){var a=
i.getSetting(a.data.treeId),b=i.getRoot(a);if(b.curHoverNode&&!i.isSelectedNode(a,b.curHoverNode))e.removeTreeDom(a,b.curHoverNode),b.curHoverNode=null},onMousedownNode:function(a,b){function c(a){if(m.dragFlag==0&&Math.abs(N-a.clientX)<f.edit.drag.minMoveSize&&Math.abs(O-a.clientY)<f.edit.drag.minMoveSize)return!0;var b,c,g,j;L.css("cursor","pointer");if(m.dragFlag==0){if(k.apply(f.callback.beforeDrag,[f.treeId,n],!0)==!1)return l(a),!0;for(b=0,c=n.length;b<c;b++){if(b==0)m.dragNodeShowBefore=[];
g=n[b];i.nodeIsParent(f,g)&&g.open?(e.expandCollapseNode(f,g,!g.open),m.dragNodeShowBefore[g.tId]=!0):m.dragNodeShowBefore[g.tId]=!1}m.dragFlag=1;y.showHoverDom=!1;k.showIfameMask(f,!0);j=!0;var p=-1;if(n.length>1){var o=n[0].parentTId?i.nodeChildren(f,n[0].getParentNode()):i.getNodes(f);g=[];for(b=0,c=o.length;b<c;b++)if(m.dragNodeShowBefore[o[b].tId]!==void 0&&(j&&p>-1&&p+1!==b&&(j=!1),g.push(o[b]),p=b),n.length===g.length){n=g;break}}j&&(H=n[0].getPreNode(),Q=n[n.length-1].getNextNode());C=q("<ul class='zTreeDragUL'></ul>",
f);for(b=0,c=n.length;b<c;b++)g=n[b],g.editNameFlag=!1,e.selectNode(f,g,b>0),e.removeTreeDom(f,g),b>f.edit.drag.maxShowNodeNum-1||(j=q("<li id='"+g.tId+"_tmp'></li>",f),j.append(q(g,d.id.A,f).clone()),j.css("padding","0"),j.children("#"+g.tId+d.id.A).removeClass(d.node.CURSELECTED),C.append(j),b==f.edit.drag.maxShowNodeNum-1&&(j=q("<li id='"+g.tId+"_moretmp'><a>  ...  </a></li>",f),C.append(j)));C.attr("id",n[0].tId+d.id.UL+"_tmp");C.addClass(f.treeObj.attr("class"));C.appendTo(L);u=q("<span class='tmpzTreeMove_arrow'></span>",
f);u.attr("id","zTreeMove_arrow_tmp");u.appendTo(L);f.treeObj.trigger(d.event.DRAG,[a,f.treeId,n])}if(m.dragFlag==1){t&&u.attr("id")==a.target.id&&w&&a.clientX+G.scrollLeft()+2>B("#"+w+d.id.A,t).offset().left?(g=B("#"+w+d.id.A,t),a.target=g.length>0?g.get(0):a.target):t&&(t.removeClass(d.node.TMPTARGET_TREE),w&&B("#"+w+d.id.A,t).removeClass(d.node.TMPTARGET_NODE+"_"+d.move.TYPE_PREV).removeClass(d.node.TMPTARGET_NODE+"_"+I.move.TYPE_NEXT).removeClass(d.node.TMPTARGET_NODE+"_"+I.move.TYPE_INNER));
w=t=null;J=!1;h=f;g=i.getSettings();for(var z in g)if(g[z].treeId&&g[z].edit.enable&&g[z].treeId!=f.treeId&&(a.target.id==g[z].treeId||B(a.target).parents("#"+g[z].treeId).length>0))J=!0,h=g[z];z=G.scrollTop();j=G.scrollLeft();p=h.treeObj.offset();b=h.treeObj.get(0).scrollHeight;g=h.treeObj.get(0).scrollWidth;c=a.clientY+z-p.top;var E=h.treeObj.height()+p.top-a.clientY-z,r=a.clientX+j-p.left,s=h.treeObj.width()+p.left-a.clientX-j,p=c<f.edit.drag.borderMax&&c>f.edit.drag.borderMin,o=E<f.edit.drag.borderMax&&
E>f.edit.drag.borderMin,F=r<f.edit.drag.borderMax&&r>f.edit.drag.borderMin,v=s<f.edit.drag.borderMax&&s>f.edit.drag.borderMin,E=c>f.edit.drag.borderMin&&E>f.edit.drag.borderMin&&r>f.edit.drag.borderMin&&s>f.edit.drag.borderMin,r=p&&h.treeObj.scrollTop()<=0,s=o&&h.treeObj.scrollTop()+h.treeObj.height()+10>=b,M=F&&h.treeObj.scrollLeft()<=0,P=v&&h.treeObj.scrollLeft()+h.treeObj.width()+10>=g;if(a.target&&k.isChildOrSelf(a.target,h.treeId)){for(var D=a.target;D&&D.tagName&&!k.eqs(D.tagName,"li")&&D.id!=
h.treeId;)D=D.parentNode;var R=!0;for(b=0,c=n.length;b<c;b++)if(g=n[b],D.id===g.tId){R=!1;break}else if(q(g,f).find("#"+D.id).length>0){R=!1;break}if(R&&a.target&&k.isChildOrSelf(a.target,D.id+d.id.A))t=B(D),w=D.id}g=n[0];if(E&&k.isChildOrSelf(a.target,h.treeId)){if(!t&&(a.target.id==h.treeId||r||s||M||P)&&(J||!J&&g.parentTId))t=h.treeObj;p?h.treeObj.scrollTop(h.treeObj.scrollTop()-10):o&&h.treeObj.scrollTop(h.treeObj.scrollTop()+10);F?h.treeObj.scrollLeft(h.treeObj.scrollLeft()-10):v&&h.treeObj.scrollLeft(h.treeObj.scrollLeft()+
10);t&&t!=h.treeObj&&t.offset().left<h.treeObj.offset().left&&h.treeObj.scrollLeft(h.treeObj.scrollLeft()+t.offset().left-h.treeObj.offset().left)}C.css({top:a.clientY+z+3+"px",left:a.clientX+j+3+"px"});b=j=0;if(t&&t.attr("id")!=h.treeId){var A=w==null?null:i.getNodeCache(h,w),p=(a.ctrlKey||a.metaKey)&&f.edit.drag.isMove&&f.edit.drag.isCopy||!f.edit.drag.isMove&&f.edit.drag.isCopy;c=!!(H&&w===H.tId);F=!!(Q&&w===Q.tId);o=g.parentTId&&g.parentTId==w;g=(p||!F)&&k.apply(h.edit.drag.prev,[h.treeId,n,A],
!!h.edit.drag.prev);c=(p||!c)&&k.apply(h.edit.drag.next,[h.treeId,n,A],!!h.edit.drag.next);p=(p||!o)&&!(h.data.keep.leaf&&!i.nodeIsParent(f,A))&&k.apply(h.edit.drag.inner,[h.treeId,n,A],!!h.edit.drag.inner);o=function(){t=null;w="";x=d.move.TYPE_INNER;u.css({display:"none"});if(window.zTreeMoveTimer)clearTimeout(window.zTreeMoveTimer),window.zTreeMoveTargetNodeTId=null};if(!g&&!c&&!p)o();else if(F=B("#"+w+d.id.A,t),v=A.isLastNode?null:B("#"+A.getNextNode().tId+d.id.A,t.next()),E=F.offset().top,r=
F.offset().left,s=g?p?0.25:c?0.5:1:-1,M=c?p?0.75:g?0.5:0:-1,z=(a.clientY+z-E)/F.height(),(s==1||z<=s&&z>=-0.2)&&g?(j=1-u.width(),b=E-u.height()/2,x=d.move.TYPE_PREV):(M==0||z>=M&&z<=1.2)&&c?(j=1-u.width(),b=v==null||i.nodeIsParent(f,A)&&A.open?E+F.height()-u.height()/2:v.offset().top-u.height()/2,x=d.move.TYPE_NEXT):p?(j=5-u.width(),b=E,x=d.move.TYPE_INNER):o(),t){u.css({display:"block",top:b+"px",left:r+j+"px"});F.addClass(d.node.TMPTARGET_NODE+"_"+x);if(S!=w||T!=x)K=(new Date).getTime();if(A&&i.nodeIsParent(f,
A)&&x==d.move.TYPE_INNER&&(z=!0,window.zTreeMoveTimer&&window.zTreeMoveTargetNodeTId!==A.tId?(clearTimeout(window.zTreeMoveTimer),window.zTreeMoveTargetNodeTId=null):window.zTreeMoveTimer&&window.zTreeMoveTargetNodeTId===A.tId&&(z=!1),z))window.zTreeMoveTimer=setTimeout(function(){x==d.move.TYPE_INNER&&A&&i.nodeIsParent(f,A)&&!A.open&&(new Date).getTime()-K>h.edit.drag.autoOpenTime&&k.apply(h.callback.beforeDragOpen,[h.treeId,A],!0)&&(e.switchNode(h,A),h.edit.drag.autoExpandTrigger&&h.treeObj.trigger(d.event.EXPAND,
[h.treeId,A]))},h.edit.drag.autoOpenTime+50),window.zTreeMoveTargetNodeTId=A.tId}}else if(x=d.move.TYPE_INNER,t&&k.apply(h.edit.drag.inner,[h.treeId,n,null],!!h.edit.drag.inner)?t.addClass(d.node.TMPTARGET_TREE):t=null,u.css({display:"none"}),window.zTreeMoveTimer)clearTimeout(window.zTreeMoveTimer),window.zTreeMoveTargetNodeTId=null;S=w;T=x;f.treeObj.trigger(d.event.DRAGMOVE,[a,f.treeId,n])}return!1}function l(a){if(window.zTreeMoveTimer)clearTimeout(window.zTreeMoveTimer),window.zTreeMoveTargetNodeTId=
null;T=S=null;G.unbind("mousemove",c);G.unbind("mouseup",l);G.unbind("selectstart",g);L.css("cursor","");t&&(t.removeClass(d.node.TMPTARGET_TREE),w&&B("#"+w+d.id.A,t).removeClass(d.node.TMPTARGET_NODE+"_"+d.move.TYPE_PREV).removeClass(d.node.TMPTARGET_NODE+"_"+I.move.TYPE_NEXT).removeClass(d.node.TMPTARGET_NODE+"_"+I.move.TYPE_INNER));k.showIfameMask(f,!1);y.showHoverDom=!0;if(m.dragFlag!=0){m.dragFlag=0;var b,j,o;for(b=0,j=n.length;b<j;b++)o=n[b],i.nodeIsParent(f,o)&&m.dragNodeShowBefore[o.tId]&&
!o.open&&(e.expandCollapseNode(f,o,!o.open),delete m.dragNodeShowBefore[o.tId]);C&&C.remove();u&&u.remove();var r=(a.ctrlKey||a.metaKey)&&f.edit.drag.isMove&&f.edit.drag.isCopy||!f.edit.drag.isMove&&f.edit.drag.isCopy;!r&&t&&w&&n[0].parentTId&&w==n[0].parentTId&&x==d.move.TYPE_INNER&&(t=null);if(t){var p=w==null?null:i.getNodeCache(h,w);if(k.apply(f.callback.beforeDrop,[h.treeId,n,p,x,r],!0)==!1)e.selectNodes(v,n);else{var s=r?k.clone(n):n;b=function(){if(J){if(!r)for(var b=0,c=n.length;b<c;b++)e.removeNode(f,
n[b]);x==d.move.TYPE_INNER?e.addNodes(h,p,-1,s):e.addNodes(h,p.getParentNode(),x==d.move.TYPE_PREV?p.getIndex():p.getIndex()+1,s)}else if(r&&x==d.move.TYPE_INNER)e.addNodes(h,p,-1,s);else if(r)e.addNodes(h,p.getParentNode(),x==d.move.TYPE_PREV?p.getIndex():p.getIndex()+1,s);else if(x!=d.move.TYPE_NEXT)for(b=0,c=s.length;b<c;b++)e.moveNode(h,p,s[b],x,!1);else for(b=-1,c=s.length-1;b<c;c--)e.moveNode(h,p,s[c],x,!1);e.selectNodes(h,s);b=q(s[0],f).get(0);e.scrollIntoView(f,b);f.treeObj.trigger(d.event.DROP,
[a,h.treeId,s,p,x,r])};x==d.move.TYPE_INNER&&k.canAsync(h,p)?e.asyncNode(h,p,!1,b):b()}}else e.selectNodes(v,n),f.treeObj.trigger(d.event.DROP,[a,f.treeId,n,null,null,null])}}function g(){return!1}var o,j,f=i.getSetting(a.data.treeId),m=i.getRoot(f),y=i.getRoots();if(a.button==2||!f.edit.enable||!f.edit.drag.isCopy&&!f.edit.drag.isMove)return!0;var r=a.target,s=i.getRoot(f).curSelectedList,n=[];if(i.isSelectedNode(f,b))for(o=0,j=s.length;o<j;o++){if(s[o].editNameFlag&&k.eqs(r.tagName,"input")&&r.getAttribute("treeNode"+
d.id.INPUT)!==null)return!0;n.push(s[o]);if(n[0].parentTId!==s[o].parentTId){n=[b];break}}else n=[b];e.editNodeBlur=!0;e.cancelCurEditNode(f);var G=B(f.treeObj.get(0).ownerDocument),L=B(f.treeObj.get(0).ownerDocument.body),C,u,t,J=!1,h=f,v=f,H,Q,S=null,T=null,w=null,x=d.move.TYPE_INNER,N=a.clientX,O=a.clientY,K=(new Date).getTime();k.uCanDo(f)&&G.bind("mousemove",c);G.bind("mouseup",l);G.bind("selectstart",g);a.preventDefault&&a.preventDefault();return!0}};B.extend(!0,B.fn.zTree.consts,I);B.extend(!0,
B.fn.zTree._z,{tools:{getAbs:function(a){a=a.getBoundingClientRect();return[a.left+(document.body.scrollLeft+document.documentElement.scrollLeft),a.top+(document.body.scrollTop+document.documentElement.scrollTop)]},inputFocus:function(a){a.get(0)&&(a.focus(),k.setCursorPosition(a.get(0),a.val().length))},inputSelect:function(a){a.get(0)&&(a.focus(),a.select())},setCursorPosition:function(a,b){if(a.setSelectionRange)a.focus(),a.setSelectionRange(b,b);else if(a.createTextRange){var c=a.createTextRange();
c.collapse(!0);c.moveEnd("character",b);c.moveStart("character",b);c.select()}},showIfameMask:function(a,b){for(var c=i.getRoot(a);c.dragMaskList.length>0;)c.dragMaskList[0].remove(),c.dragMaskList.shift();if(b)for(var d=q("iframe",a),g=0,e=d.length;g<e;g++){var j=d.get(g),f=k.getAbs(j),j=q("<div id='zTreeMask_"+g+"' class='zTreeMask' style='top:"+f[1]+"px; left:"+f[0]+"px; width:"+j.offsetWidth+"px; height:"+j.offsetHeight+"px;'></div>",a);j.appendTo(q("body",a));c.dragMaskList.push(j)}}},view:{addEditBtn:function(a,
b){if(!(b.editNameFlag||q(b,d.id.EDIT,a).length>0)&&k.apply(a.edit.showRenameBtn,[a.treeId,b],a.edit.showRenameBtn)){var c=q(b,d.id.A,a),l="<span class='"+d.className.BUTTON+" edit' id='"+b.tId+d.id.EDIT+"' title='"+k.apply(a.edit.renameTitle,[a.treeId,b],a.edit.renameTitle)+"' treeNode"+d.id.EDIT+" style='display:none;'></span>";c.append(l);q(b,d.id.EDIT,a).bind("click",function(){if(!k.uCanDo(a)||k.apply(a.callback.beforeEditName,[a.treeId,b],!0)==!1)return!1;e.editNode(a,b);return!1}).show()}},
addRemoveBtn:function(a,b){if(!(b.editNameFlag||q(b,d.id.REMOVE,a).length>0)&&k.apply(a.edit.showRemoveBtn,[a.treeId,b],a.edit.showRemoveBtn)){var c=q(b,d.id.A,a),l="<span class='"+d.className.BUTTON+" remove' id='"+b.tId+d.id.REMOVE+"' title='"+k.apply(a.edit.removeTitle,[a.treeId,b],a.edit.removeTitle)+"' treeNode"+d.id.REMOVE+" style='display:none;'></span>";c.append(l);q(b,d.id.REMOVE,a).bind("click",function(){if(!k.uCanDo(a)||k.apply(a.callback.beforeRemove,[a.treeId,b],!0)==!1)return!1;e.removeNode(a,
b);a.treeObj.trigger(d.event.REMOVE,[a.treeId,b]);return!1}).bind("mousedown",function(){return!0}).show()}},addHoverDom:function(a,b){if(i.getRoots().showHoverDom)b.isHover=!0,a.edit.enable&&(e.addEditBtn(a,b),e.addRemoveBtn(a,b)),k.apply(a.view.addHoverDom,[a.treeId,b])},cancelCurEditNode:function(a,b,c){var l=i.getRoot(a),g=l.curEditNode;if(g){var o=l.curEditInput,b=b?b:c?i.nodeName(a,g):o.val();if(k.apply(a.callback.beforeRename,[a.treeId,g,b,c],!0)===!1)return!1;i.nodeName(a,g,b);q(g,d.id.A,
a).removeClass(d.node.CURSELECTED_EDIT);o.unbind();e.setNodeName(a,g);g.editNameFlag=!1;l.curEditNode=null;l.curEditInput=null;e.selectNode(a,g,!1);a.treeObj.trigger(d.event.RENAME,[a.treeId,g,c])}return l.noSelection=!0},editNode:function(a,b){var c=i.getRoot(a);e.editNodeBlur=!1;if(i.isSelectedNode(a,b)&&c.curEditNode==b&&b.editNameFlag)setTimeout(function(){k.inputFocus(c.curEditInput)},0);else{b.editNameFlag=!0;e.removeTreeDom(a,b);e.cancelCurEditNode(a);e.selectNode(a,b,!1);q(b,d.id.SPAN,a).html("<input type=text class='rename' id='"+
b.tId+d.id.INPUT+"' treeNode"+d.id.INPUT+" >");var l=q(b,d.id.INPUT,a);l.attr("value",i.nodeName(a,b));a.edit.editNameSelectAll?k.inputSelect(l):k.inputFocus(l);l.bind("blur",function(){e.editNodeBlur||e.cancelCurEditNode(a)}).bind("keydown",function(b){b.keyCode=="13"?(e.editNodeBlur=!0,e.cancelCurEditNode(a)):b.keyCode=="27"&&e.cancelCurEditNode(a,null,!0)}).bind("click",function(){return!1}).bind("dblclick",function(){return!1});q(b,d.id.A,a).addClass(d.node.CURSELECTED_EDIT);c.curEditInput=l;
c.noSelection=!1;c.curEditNode=b}},moveNode:function(a,b,c,l,g,k){var j=i.getRoot(a);if(b!=c&&(!a.data.keep.leaf||!b||i.nodeIsParent(a,b)||l!=d.move.TYPE_INNER)){var f=c.parentTId?c.getParentNode():j,m=b===null||b==j;m&&b===null&&(b=j);if(m)l=d.move.TYPE_INNER;j=b.parentTId?b.getParentNode():j;if(l!=d.move.TYPE_PREV&&l!=d.move.TYPE_NEXT)l=d.move.TYPE_INNER;if(l==d.move.TYPE_INNER)if(m)c.parentTId=null;else{if(!i.nodeIsParent(a,b))i.nodeIsParent(a,b,!0),b.open=!!b.open,e.setNodeLineIcos(a,b);c.parentTId=
b.tId}var y;m?y=m=a.treeObj:(!k&&l==d.move.TYPE_INNER?e.expandCollapseNode(a,b,!0,!1):k||e.expandCollapseNode(a,b.getParentNode(),!0,!1),m=q(b,a),y=q(b,d.id.UL,a),m.get(0)&&!y.get(0)&&(y=[],e.makeUlHtml(a,b,y,""),m.append(y.join(""))),y=q(b,d.id.UL,a));var r=q(c,a);r.get(0)?m.get(0)||r.remove():r=e.appendNodes(a,c.level,[c],null,-1,!1,!0).join("");y.get(0)&&l==d.move.TYPE_INNER?y.append(r):m.get(0)&&l==d.move.TYPE_PREV?m.before(r):m.get(0)&&l==d.move.TYPE_NEXT&&m.after(r);var s;y=-1;var r=0,n=null,
m=null,B=c.level,v=i.nodeChildren(a,f),C=i.nodeChildren(a,j),u=i.nodeChildren(a,b);if(c.isFirstNode){if(y=0,v.length>1)n=v[1],n.isFirstNode=!0}else if(c.isLastNode)y=v.length-1,n=v[y-1],n.isLastNode=!0;else for(j=0,s=v.length;j<s;j++)if(v[j].tId==c.tId){y=j;break}y>=0&&v.splice(y,1);if(l!=d.move.TYPE_INNER)for(j=0,s=C.length;j<s;j++)C[j].tId==b.tId&&(r=j);if(l==d.move.TYPE_INNER){u||(u=i.nodeChildren(a,b,[]));if(u.length>0)m=u[u.length-1],m.isLastNode=!1;u.splice(u.length,0,c);c.isLastNode=!0;c.isFirstNode=
u.length==1}else b.isFirstNode&&l==d.move.TYPE_PREV?(C.splice(r,0,c),m=b,m.isFirstNode=!1,c.parentTId=b.parentTId,c.isFirstNode=!0,c.isLastNode=!1):b.isLastNode&&l==d.move.TYPE_NEXT?(C.splice(r+1,0,c),m=b,m.isLastNode=!1,c.parentTId=b.parentTId,c.isFirstNode=!1,c.isLastNode=!0):(l==d.move.TYPE_PREV?C.splice(r,0,c):C.splice(r+1,0,c),c.parentTId=b.parentTId,c.isFirstNode=!1,c.isLastNode=!1);i.fixPIdKeyValue(a,c);i.setSonNodeLevel(a,c.getParentNode(),c);e.setNodeLineIcos(a,c);e.repairNodeLevelClass(a,
c,B);!a.data.keep.parent&&v.length<1?(i.nodeIsParent(a,f,!1),f.open=!1,b=q(f,d.id.UL,a),l=q(f,d.id.SWITCH,a),j=q(f,d.id.ICON,a),e.replaceSwitchClass(f,l,d.folder.DOCU),e.replaceIcoClass(f,j,d.folder.DOCU),b.css("display","none")):n&&e.setNodeLineIcos(a,n);m&&e.setNodeLineIcos(a,m);a.check&&a.check.enable&&e.repairChkClass&&(e.repairChkClass(a,f),e.repairParentChkClassWithSelf(a,f),f!=c.parent&&e.repairParentChkClassWithSelf(a,c));k||e.expandCollapseParentNode(a,c.getParentNode(),!0,g)}},removeEditBtn:function(a,
b){q(b,d.id.EDIT,a).unbind().remove()},removeRemoveBtn:function(a,b){q(b,d.id.REMOVE,a).unbind().remove()},removeTreeDom:function(a,b){b.isHover=!1;e.removeEditBtn(a,b);e.removeRemoveBtn(a,b);k.apply(a.view.removeHoverDom,[a.treeId,b])},repairNodeLevelClass:function(a,b,c){if(c!==b.level){var e=q(b,a),g=q(b,d.id.A,a),a=q(b,d.id.UL,a),c=d.className.LEVEL+c,b=d.className.LEVEL+b.level;e.removeClass(c);e.addClass(b);g.removeClass(c);g.addClass(b);a.removeClass(c);a.addClass(b)}},selectNodes:function(a,
b){for(var c=0,d=b.length;c<d;c++)e.selectNode(a,b[c],c>0)}},event:{},data:{setSonNodeLevel:function(a,b,c){if(c){var d=i.nodeChildren(a,c);c.level=b?b.level+1:0;if(d)for(var b=0,g=d.length;b<g;b++)d[b]&&i.setSonNodeLevel(a,c,d[b])}}}});var H=B.fn.zTree,k=H._z.tools,d=H.consts,e=H._z.view,i=H._z.data,q=k.$;i.exSetting({edit:{enable:!1,editNameSelectAll:!1,showRemoveBtn:!0,showRenameBtn:!0,removeTitle:"remove",renameTitle:"rename",drag:{autoExpandTrigger:!1,isCopy:!0,isMove:!0,prev:!0,next:!0,inner:!0,
minMoveSize:5,borderMax:10,borderMin:-5,maxShowNodeNum:5,autoOpenTime:500}},view:{addHoverDom:null,removeHoverDom:null},callback:{beforeDrag:null,beforeDragOpen:null,beforeDrop:null,beforeEditName:null,beforeRename:null,onDrag:null,onDragMove:null,onDrop:null,onRename:null}});i.addInitBind(function(a){var b=a.treeObj,c=d.event;b.bind(c.RENAME,function(b,c,d,e){k.apply(a.callback.onRename,[b,c,d,e])});b.bind(c.DRAG,function(b,c,d,e){k.apply(a.callback.onDrag,[c,d,e])});b.bind(c.DRAGMOVE,function(b,
c,d,e){k.apply(a.callback.onDragMove,[c,d,e])});b.bind(c.DROP,function(b,c,d,e,f,i,q){k.apply(a.callback.onDrop,[c,d,e,f,i,q])})});i.addInitUnBind(function(a){var a=a.treeObj,b=d.event;a.unbind(b.RENAME);a.unbind(b.DRAG);a.unbind(b.DRAGMOVE);a.unbind(b.DROP)});i.addInitCache(function(){});i.addInitNode(function(a,b,c){if(c)c.isHover=!1,c.editNameFlag=!1});i.addInitProxy(function(a){var b=a.target,c=i.getSetting(a.data.treeId),e=a.relatedTarget,g="",o=null,j="",f=null,m=null;if(k.eqs(a.type,"mouseover")){if(m=
k.getMDom(c,b,[{tagName:"a",attrName:"treeNode"+d.id.A}]))g=k.getNodeMainDom(m).id,j="hoverOverNode"}else if(k.eqs(a.type,"mouseout"))m=k.getMDom(c,e,[{tagName:"a",attrName:"treeNode"+d.id.A}]),m||(g="remove",j="hoverOutNode");else if(k.eqs(a.type,"mousedown")&&(m=k.getMDom(c,b,[{tagName:"a",attrName:"treeNode"+d.id.A}])))g=k.getNodeMainDom(m).id,j="mousedownNode";if(g.length>0)switch(o=i.getNodeCache(c,g),j){case "mousedownNode":f=v.onMousedownNode;break;case "hoverOverNode":f=v.onHoverOverNode;
break;case "hoverOutNode":f=v.onHoverOutNode}return{stop:!1,node:o,nodeEventType:j,nodeEventCallback:f,treeEventType:"",treeEventCallback:null}});i.addInitRoot(function(a){var a=i.getRoot(a),b=i.getRoots();a.curEditNode=null;a.curEditInput=null;a.curHoverNode=null;a.dragFlag=0;a.dragNodeShowBefore=[];a.dragMaskList=[];b.showHoverDom=!0});i.addZTreeTools(function(a,b){b.cancelEditName=function(a){i.getRoot(this.setting).curEditNode&&e.cancelCurEditNode(this.setting,a?a:null,!0)};b.copyNode=function(b,
l,g,o){if(!l)return null;var j=i.nodeIsParent(a,b);if(b&&!j&&this.setting.data.keep.leaf&&g===d.move.TYPE_INNER)return null;var f=this,m=k.clone(l);if(!b)b=null,g=d.move.TYPE_INNER;g==d.move.TYPE_INNER?(l=function(){e.addNodes(f.setting,b,-1,[m],o)},k.canAsync(this.setting,b)?e.asyncNode(this.setting,b,o,l):l()):(e.addNodes(this.setting,b.parentNode,-1,[m],o),e.moveNode(this.setting,b,m,g,!1,o));return m};b.editName=function(a){a&&a.tId&&a===i.getNodeCache(this.setting,a.tId)&&(a.parentTId&&e.expandCollapseParentNode(this.setting,
a.getParentNode(),!0),e.editNode(this.setting,a))};b.moveNode=function(b,l,g,o){function j(){e.moveNode(m.setting,b,l,g,!1,o)}if(!l)return l;var f=i.nodeIsParent(a,b);if(b&&!f&&this.setting.data.keep.leaf&&g===d.move.TYPE_INNER)return null;else if(b&&(l.parentTId==b.tId&&g==d.move.TYPE_INNER||q(l,this.setting).find("#"+b.tId).length>0))return null;else b||(b=null);var m=this;k.canAsync(this.setting,b)&&g===d.move.TYPE_INNER?e.asyncNode(this.setting,b,o,j):j();return l};b.setEditable=function(a){this.setting.edit.enable=
a;return this.refresh()}});var N=e.cancelPreSelectedNode;e.cancelPreSelectedNode=function(a,b){for(var c=i.getRoot(a).curSelectedList,d=0,g=c.length;d<g;d++)if(!b||b===c[d])if(e.removeTreeDom(a,c[d]),b)break;N&&N.apply(e,arguments)};var O=e.createNodes;e.createNodes=function(a,b,c,d,g){O&&O.apply(e,arguments);c&&e.repairParentChkClassWithSelf&&e.repairParentChkClassWithSelf(a,d)};var V=e.makeNodeUrl;e.makeNodeUrl=function(a,b){return a.edit.enable?null:V.apply(e,arguments)};var K=e.removeNode;e.removeNode=
function(a,b){var c=i.getRoot(a);if(c.curEditNode===b)c.curEditNode=null;K&&K.apply(e,arguments)};var P=e.selectNode;e.selectNode=function(a,b,c){var d=i.getRoot(a);if(i.isSelectedNode(a,b)&&d.curEditNode==b&&b.editNameFlag)return!1;P&&P.apply(e,arguments);e.addHoverDom(a,b);return!0};var U=k.uCanDo;k.uCanDo=function(a,b){var c=i.getRoot(a);if(b&&(k.eqs(b.type,"mouseover")||k.eqs(b.type,"mouseout")||k.eqs(b.type,"mousedown")||k.eqs(b.type,"mouseup")))return!0;if(c.curEditNode)e.editNodeBlur=!1,c.curEditInput.focus();
return!c.curEditNode&&(U?U.apply(e,arguments):!0)}})(jQuery);
/**
 * theme: 部门架构选择器组件
 * author: joinFisher
 * date: 2018-02-27
 * versions: 0.0.1
 *
 * 后期插件将更新支持： 
 * 1、只开启组织
 * 2、只开启人物
 * 需要后端接口支持
 * 
 */
/*
1、代码最前面的分号，可以防止多个文件压缩合并以为其他文件最后一行语句没加分号，而引起合并后的语法错误。

2、匿名函数(function(){})();：由于Javascript执行表达式是从圆括号里面到外面，所以可以用圆括号强制执行声明的函数。避免函数体内和外部的变量冲突。

3、$实参:$是jquery的简写，很多方法和类库也使用$,这里$接受jQuery对象，也是为了避免$变量冲突，保证插件可以正常运行。

4、window, document实参分别接受window, document对象，window, document对象都是全局环境下的，而在函数体内的window, document其实是局部变量，不是全局的window, document对象。这样做有个好处就是可以提高性能，减少作用域链的查询时间，如果你在函数体内需要多次调用window 或 document对象，这样把window 或 document对象当作参数传进去，这样做是非常有必要的。当然如果你的插件用不到这两个对象，那么就不用传递这两个参数了。

5、最后剩下一个undefined形参了，那么这个形参是干什么用的呢，看起来是有点多余。undefined在老一辈的浏览器是不被支持的，直接使用会报错，js框架要考虑到兼容性，因此增加一个形参undefined
*/
;(function($,window,document,undefined){

    var oTree =function(ele, options){
        this.$element = $(ele); //主元素
        this.defaults = {
            all: false,     //人物组织都开启
            area: null,     //弹窗框宽高
            search: true    //支持搜索
        };
        //将一个新的空对象做为$.extend的第一个参数，defaults和用户传递的参数对象紧随其后，
        //这样做的好处是所有值被合并到这个空对象上，保护了插件里面的默认值。
        this.settings = $.extend({}, this.defaults, options); 
    };
    var saveVal = []; //操作以保存的值， 数组形式
    var allJson;      //从后台获取原始组织架构数据，防止多次加载  
    var filterDataList;  //数据结构进行处理
    var orgZTree; //可以多方位操作ztree
    oTree.prototype = {
        dialog: function(){

            var contentsHTML, $wrapper, _this, $treeWrapper, allLoadData;

            _this = this;
            contentsHTML = '<div class="multiPickerDlg clearfix"><div class="multiPickerDlg_left"><div class="multiPickerDlg_left_cnt"><!--loading--><div class="ww_loading loading_left_wrap js_search_loading"><span class="ww_loadingIconSmall"></span><span class="ww_loading_text">正在搜索，请稍候…</span></div><!--jstree--><div id="partyTree" class="multiPickerDlg_left_cnt_list"><div class="ww_loading js_search_loading"><span class="ww_loadingIconSmall"></span><span class="ww_loading_text">正在搜索，请稍候…</span></div><div class="ztree_wrapper"><ul id="ztreeArea" class="ztree"></ul></div></div><div class="multiPickerDlg_left_mask js_left_mask"></div></div></div><div class="multiPickerDlg_right"><div class="multiPickerDlg_right_title">已选择的科室</div><div class="multiPickerDlg_right_cnt"><div class="js_right_col"><ul id="saveNode"></ul></div><div class="multiPickerDlg_right_no_result"><i></i>未选择科室</div></div></div></div>';

            //获取全部组织架构包括人物
            $.getJSON('./js/orgTree/root-org.json').done(function(data){

                allJson = data; 
                filterDataList = _this.filterDataSloveList(data);

                // 页面进入渲染
                _this.getValue();

                if(_this.settings.all){
                    //全部开启
                    allLoadData = _this.dataSolve(data);  //进行数据处理
                };

            });

            _this.$element.on('click', '.js_show_party_selector', function(){

                if(!allJson || allJson == '') {
                    layer.msg('获取组织架构失败', {icon: 5});
                    return;
                }
                layer.confirm(contentsHTML, {
                    skin: 'org-skin',
                    title: '选择科室所在银行',
                    area: _this.settings.area , 
                    resize: false, //禁止弹出窗拉伸
                    btn: ['确认','取消'], //按钮
                    cancel: function(index, layero){  //右上角关闭按钮
                        var oldValue = _this.savedJson();
                        saveVal = oldValue;
                    }
                }, function(index){

                    _this.renderOut(saveVal);
                    layer.close(index);

                }, function(){

                    var oldValue = _this.savedJson();
                    saveVal = oldValue;

                });

                //第一个loading隐藏
                $('.ww_loading').css('display','none');

                $leftWrap = $('.multiPickerDlg_left_cnt');
                $treeWrapper = $('.multiPickerDlg').find('.multiPickerDlg_left_cnt_list');
                $zTreeWrap = $treeWrapper.find('#ztreeArea');


                //判断搜索是否开启
                if(_this.settings.search) {
                    _this.searchFuc(filterDataList);
                };

                if(_this.settings.all){
                    //全部开启
                    _this.loadAll($zTreeWrap, allLoadData);
                };

            });

        },
        filterDataSloveList: function(data) {

            var _this = this;

            var treeNode = _this.dataSolve(data);
            var filterResult = []; 
            function filterTree(fNode, dataNode) {
                dataNode.forEach(function(aDate){
                    fNode.push({
                        id: aDate.id,
                        name: aDate.name,
                        crumbs: aDate.crumbs
                    });
                    if(aDate.children) {
                        filterTree(fNode, aDate.children)
                    }
                });
            };
            filterTree(filterResult, treeNode);
            function unique(arr) {
                var ret = [];
                for (var i = 0, j = arr.length; i < j; i++) {
                    if (ret.indexOf(arr[i].id) === -1) {
                        ret.push(arr[i]);
                    };
                };
                return ret;
            }
            var nodeResult=unique(filterResult);

            return nodeResult;
        },
        loadAll: function(ele, data){

            var _this = this;
            var $ele = $(ele);
            orgZTree = $.fn.zTree.init($ele ,{
                view:{
                    dblClickExpand: false,
                    selectedMulti: false,
                    showLine: false,
                    addHoverDom: addHoverDom,
                    removeHoverDom: removeHoverDom,
                    addDiyDom: addDiyDom
                },
                callback: {
                    onClick:function(event, treeId, treeNode, clickFlag){

                        //获取对应的id或者name值，只需treeNode.id 或者 treeNode.name 即可
                        //myZTree.expandNode(treeNode);
                        //myZTree.cancelSelectedNode(treeNode);
                        var curId = treeNode.id;
                        var curName = treeNode.name;
                        var curCrumbs = treeNode.crumbs;
                        var repIndex;  //获取重复数组的索引

                        var aObj = $("#" + treeNode.tId + "_a");
                        var checkIcon = aObj.find('.jstree-custom-checked');
                        if(checkIcon.hasClass('selected')) {
                            checkIcon.removeClass('selected');
                        }else {
                            checkIcon.addClass('selected');
                        };


                        if(saveVal.length > 0) {
                            for(var i=0; i<saveVal.length; i++) {
                                if(saveVal[i].id == curId) {
                                    repIndex = i;
                                };
                            };
                        };
                        if(repIndex){ 
                        	//点击之后 当前项与已选择部门 有重复  
                            saveVal.splice(repIndex, 1);
                        }else{
                            if(repIndex == 0) {
                            	//因为 splice从1开始， 而索引是从0开始,所以第一个元素特殊处理
                                saveVal.splice(repIndex, 1);
                            }else {
                                saveVal.push({
                                    id: curId,
                                    name: curName,
                                    crumbs: curCrumbs
                                });
                            };
                        };

                        //以数组形式返回选种值    
                        _this.renderNode(saveVal);
                        _this.deleteNode(saveVal);

                    }
                }

            }, data);

            //ztree 鼠标经过添加&删除 效果
            function addHoverDom(treeId, treeNode) {
                var pObj = $('#' + treeNode.tId);
                pObj.children('.jstree-wholerow').addClass('jstree-wholerow-hover');
            };
            function removeHoverDom(treeId, treeNode) {
                $('.ztree .jstree-wholerow').removeClass('jstree-wholerow-hover');
            };

            //添加自定义div
            function addDiyDom(treeId, treeNode) {

                var aObj = $('#' + treeNode.tId + '_a');
                if ($('#diyBtn_'+treeNode.id).length>0) return;

                var selectedStr = '<div class="jstree-custom-checked"></div>';
                var hoverStr = '<div class="jstree-wholerow"></div>';

                var pObj = $('#'+ treeNode.tId);
                pObj.prepend(hoverStr);
                aObj.append(selectedStr);

                pObj.find('.jstree-wholerow').eq(0).bind('click', function(){

                        //获取对应的id或者name值，只需treeNode.id 或者 treeNode.name 即可
                        var curId = treeNode.id;
                        var curName = treeNode.name;
                        var curCrumbs = treeNode.crumbs;
                        var repIndex;  //获取重复数组的索引

                        var aObj = $("#" + treeNode.tId + "_a");
                        var checkIcon = aObj.find('.jstree-custom-checked');
                        if(checkIcon.hasClass('selected')) {
                            checkIcon.removeClass('selected');
                        }else {
                            checkIcon.addClass('selected');
                        };

                        if(saveVal.length > 0) {
                            for(var i=0; i<saveVal.length; i++) {
                                if(saveVal[i].id == curId) {
                                    repIndex = i;
                                };
                            };
                        };

                        if(repIndex){   
                            saveVal.splice(repIndex, 1);
                        }else{
                            if(repIndex == 0) {
                                saveVal.splice(repIndex, 1);
                            }else {
                                saveVal.push({
                                    id: curId,
                                    name: curName,
                                    crumbs: curCrumbs
                                });
                            };
                        };

                        //以数组形式返回选种值    
                        _this.renderNode(saveVal);
                        _this.deleteNode(saveVal);

                });

                for(var i=0; i<saveVal.length; i++) {
                    if (treeNode.id == saveVal[i].id) {
                        aObj.find('.jstree-custom-checked').addClass('selected');
                    }
                };
                
            };       

            //渲染已选中部门
            if(saveVal&&saveVal.length>0) {
                _this.renderNode(saveVal);
                _this.deleteNode(saveVal);
            };

        },
        searchFuc: function(data){

            var _this = this;
            $('.multiPickerDlg').addClass('multiPickerDlg_WithSearch');

            var sdom = '<div class="multiPickerDlg_search_wrapper">'
                     + '<div class="multiPickerDlg_search">'
                     + '<span class="ww_searchInput">'
                     + '<span class="ww_commonImg ww_commonImg_Search ww_searchInput_icon"href="javascript:;"></span>'
                     + '<span class="ww_commonImg ww_commonImg_ClearText ww_searchInput_delete" id="clearMemberSearchInput"></span>'
                     + '<input type="text"id="memberSearchInput"class="qui_inputText ww_inputText ww_searchInput_text" placeholder="搜索科室"></span>'
                     + '</div>'
                     + '<div id="searchResult"class="ww_searchResult"style="display: none">'
                     + '<div id="search_member_list_title"class="ww_searchResult_title ww_searchResult_title_First">搜索结果</div>'
                     + '<div class="search_member_none">无搜索结果...</div>'
                     + '<ul id="search_member_list"></ul>'
                     + '</div>'
                     + '</div>';
            $('.multiPickerDlg_left_cnt').prepend(sdom);
            
            var $input = $('#memberSearchInput');

            //聚焦失焦样式
            $input.focus(function(){
                $(this).addClass('onfocus');
            }).blur(function(){
                $(this).removeClass('onfocus');
            });
            
            $input.on('keydown', function(event){

                event.stopPropagation();

            }).on('keyup', function(event){

                var inputValue = $(this).val();
                inputValue = inputValue.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
                var matcher = new RegExp(inputValue, "i");
                var filterTxt = $.grep(data, function(value) {
                    return matcher.test(value.name);
                });

                if(inputValue) {

                    $('#clearMemberSearchInput').show();
                    $('#searchResult').show();
                    $('#partyTree').hide(); 
                    $('#search_member_list').empty();

                    var resultList = '';
                    filterTxt.forEach(function(data){
                        resultList += '<li data-id="'+ data.id +'" data-name="'+ data.name +'" title="'+ data.crumbs +'"><i class="ww_commonImg ww_commonImg_TreeMenuThumb"></i>' + data.name +  '</li>'
                    });
                    //判断筛选之后有没有值
                    if(resultList){
                        $('.search_member_none').hide();
                    }else {
                        $('.search_member_none').show();
                    }
                    $('#search_member_list').append(resultList);

                    //清空
                    $('.ww_searchInput_delete').show();
                    $('.ww_searchInput_delete').on('click', function(){
                        $('#memberSearchInput').val(null);
                        $('#searchResult').hide();
                        $('#partyTree').show();
                        $('#search_member_list').empty();
                        $('.search_member_none').show();
                        $(this).hide();
                    });


                    $('#search_member_list li').on('click', function(){

                        var selectId = $(this).attr('data-id');
                        var selectName = $(this).attr('data-name');
                        var selectCrumbs = $(this).attr('title');
                        var repInx;  //获取重复数组的索引

                        if(saveVal.length > 0) {
                            for(var i=0; i<saveVal.length; i++) {
                                if(saveVal[i].name == selectName) {
                                    repInx = i;
                                };
                            };
                        };
                        if(repInx){
                            saveVal.splice(repInx, 1);
                        }else{
                            if(repInx == 0) {
                                saveVal.splice(repInx, 1);
                            }else {
                                saveVal.push({
                                    id: selectId,
                                    name: selectName,
                                    crumbs: selectCrumbs                                    
                                });
                            };
                        };

                        $('#searchResult').hide();
                        $('#partyTree').show();
                        $('#search_member_list').empty();
                        $('#memberSearchInput').val(null);
                        $('#clearMemberSearchInput').hide();

                        if(saveVal.length>0){
                            $('.multiPickerDlg_right_no_result').hide();
                        }else {
                            $('.multiPickerDlg_right_no_result').show();
                        };
                        //以数组形式返回选种值    
                        _this.renderNode(saveVal);
                        _this.deleteNode(saveVal);

                        //ztree进行操作，点击li之后 展开树
                        var selectedTreeNode = orgZTree.getNodeByParam("id", selectId);  

                        //处理ztree数 的选中图标
                        var aObj = $("#" + selectedTreeNode.tId + "_a");
                        var checkIcon = aObj.find('.jstree-custom-checked');
                        if(checkIcon.hasClass('selected')) {
                            checkIcon.removeClass('selected');
                        }else {
                            checkIcon.addClass('selected');
                        };

                        orgZTree.selectNode(selectedTreeNode, true);//指定选中ID的节点  
                        orgZTree.expandNode(selectedTreeNode, true, false);//指定选中ID节点展开  
                        //orgZTree.cancelSelectedNode();  ztree取消选中



                    });

                }else {

                    $('#searchResult').hide();
                    $('#partyTree').show();
                    $('#search_member_list').empty();
                    $('#clearMemberSearchInput').hide();
                    $('.search_member_none').show();
                };

            });


        },
        dataSolve: function(data) {

            var memberData = data.data;
            var zTreeNode = [];

            if (Pinyin.isSupported()) {  
                //如果浏览器支持中文转拼音
                function fillNode(zNode, dataNode, presentName) {
                    dataNode.forEach(function(aDate){
                        var thisNode = {
                            id: aDate.id,
                            name: aDate.deptname,
                            spellName: 'achild_' + spellChange(aDate.deptname),
                            parentId: aDate.parent_id,
                            crumbs: presentName +'/'+ aDate.deptname,
                            children: []
                        };
                        var noChildNode = {
                            id: aDate.id,
                            name: aDate.deptname,
                            spellName: 'bchild_' + spellChange(aDate.deptname),
                            parentId: aDate.parent_id,
                            crumbs: presentName +'/'+ aDate.deptname,
                        };

                        if(aDate.children.length > 0){
                            zNode.unshift(thisNode);
                            zNode.sort(compare('spellName'));
                        }else {
                            zNode.push(noChildNode);
                            zNode.sort(compare('spellName'));
                        };

                        fillNode(thisNode.children, aDate.children, thisNode.crumbs);
                    });
                };
                fillNode(zTreeNode, memberData, '');
            }else {
                //如果浏览器不支持中文转拼音
                function fillNode(zNode, dataNode, presentName) {
                    dataNode.forEach(function(aDate){
                        var thisNode = {
                            id: aDate.id,
                            name: aDate.deptname,
                            parentId: aDate.parent_id,
                            crumbs: presentName +'/'+ aDate.deptname,
                            children: []
                        };
                        var noChildNode = {
                            id: aDate.id,
                            name: aDate.deptname,
                            parentId: aDate.parent_id,
                            crumbs: presentName +'/'+ aDate.deptname,
                        };
                        if(aDate.children.length > 0){
                            zNode.unshift(thisNode);
                        }else {
                            zNode.push(noChildNode);
                        };
                        fillNode(thisNode.children, aDate.children, thisNode.crumbs);
                    });
                };
                fillNode(zTreeNode, memberData, '');
            }

            //拼音转化
            function spellChange (value) {
                var pinyin = '';
                if (value) {
                    // 中文数字转化为阿拉伯数字，这里暂时没有更好办法了
                    // 这里是为了 排序的时候，根据首字母‘一二三’会排成 ‘二三一’
                    // 希望路过的大神帮忙支招
					function _convert(str) {
					    var arr = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十'];
					    for (var i = 0; i < arr.length; i++) {
					        str = str.replace(new RegExp(arr[i], 'g'), (i));
					    }
					    return str;
					};
                    value = _convert(value);
                    var tokens = Pinyin.parse(value);
                    var lastToken;
                    tokens.forEach((function(v, i) {
                        if (v.type === 2) {
                            pinyin += (pinyin && !/\n|\s/.test(lastToken.target)) ? ('' + format(v.target)) : format(v.target);
                        } else {
                            pinyin += ((lastToken && lastToken.type === 2) ? '' : '') + v.target;
                        };
                        lastToken = v;
                    }))
                }; 
                return pinyin.toLowerCase();
            }

            function format(str) {
              if (str) {
                return str.toLowerCase()
              };
              return '';
            }

            //排序
            function compare(propertyName) { 
                return function (object1, object2) { 
                    var value1 = object1[propertyName]; 
                    var value2 = object2[propertyName]; 
                    if (value2 < value1) { 
                        return 1; 
                    } 
                    else if (value2 > value1) { 
                        return -1; 
                    } 
                    else { 
                        return 0; 
                    } 
                }; 
            }; 

            return zTreeNode;

        },
        getValue: function(){
            var _this=this;
            var savedVal = $('#field-dept').val().split(';');
            var filterJson = [];
            for(var i=0; i<savedVal.length; i++) {
                (function(i){
                    filterDataList.forEach(function(item, index){
                        if(item.id == savedVal[i]) {
                            return filterJson.push(item);
                        };
                    });
                })(i);
            };

            saveVal = filterJson;
            _this.renderOut(saveVal);
            return saveVal;
        },
        outRepair: function(){
            var _this=this;
            $(document).on('click', '.js_disselect_party', function(){
                $(this).parent().remove();
                saveVal = _this.savedJson();
                if(saveVal.length>0) {
                    $('.js_show_party_selector').html('选择');
                }else {
                    $('.js_show_party_selector').html('添加');
                };

                //处理ztree数 的选中图标
                // var curId = $(this).siblings('.parydata').attr('data-id');
                // var selectedTreeNode = orgZTree.getNodeByParam('id', curId); 
                
                // var aObj = $('#' + selectedTreeNode.tId + "_a");
                // var checkIcon = aObj.find('.jstree-custom-checked');
                // checkIcon.removeClass('selected');

            });
        },
        savedJson: function(){
            var itemList = $('.js_party_select_result_list').children('div');
            var saveLength = itemList.length;
            var jsonList = [];
            var outInputVal = '';

            if(saveLength > 0) {
                itemList.each(function(index, ele){
                    jsonList.push({
                        name: $(ele).find('.parydata').attr('data-name'),
                        id: $(ele).find('.parydata').attr('data-id'),
                        crumbs: $(ele).find('.parydata').attr('data-crumbs')
                    });
                    outInputVal += $(ele).find('.parydata').attr('data-id') + ';';
                });
            };
            //渲染外部input的值
            $('#field-dept').val(outInputVal);
            //console.log($('#field-dept').val());
            return jsonList;
        },  
        renderOut: function(arr) {
            $('.js_party_select_result_list').html('');
            var wrap ='';
            var perVal = '';
            if(arr.length>0) {
                arr.map(function(ele, index){
                    perVal += ele.id+';';
                    wrap += '<div class="ww_groupSelBtn_item">'
                          + '<span class="ww_commonImg ww_commonImg_TreeMenuThumb"></span>'
                          + '<span class="ww_groupSelBtn_item_text">'
                          + ele.name
                          + '</span>'
                          + '<span class="ww_commonImg ww_commonImg_GroupDelSel js_disselect_party">x</span>'
                          + '<input type="hidden" class="parydata" name="partyid" data-name="'
                          + ele.name
                          + '" data-id="'
                          + ele.id
                          + '" data-crumbs="'
                          + ele.crumbs
                          + '" value="'
                          + ele.id
                          + '">'
                          + '</div>';
                });
                $('.js_show_party_selector').html('选择');
            }else {
                $('.js_show_party_selector').html('添加');
            };
            $('.js_party_select_result_list').append(wrap);
            //渲染外部input的值
            $('#field-dept').val(perVal);
            //console.log($('#field-dept').val())
        },
        renderNode: function(arr){
            var _this = this;
            var liHtml = '';
            $('#saveNode').html('');
            if(arr.length>0){
                $('.multiPickerDlg_right_no_result').hide();
            }else {
                $('.multiPickerDlg_right_no_result').show();
            }
            arr.map(function(item, index){
                liHtml = '<li title='+ item.crumbs +' data-name='+ item.name +' data-id='+ item.id +' class="ww_menuDialog_DualCols_colRight_cnt_item token-input-token js_list_item">'
                       + '<span class="ww_commonImg icon icon_folder_blue"></span>'
                       + '<span class="ww_treeMenu_item_text" title='+ item.crumbs +'>'+ item.name+'</span>'
                       + '<a href="javascript:" class="ww_menuDialog_DualCols_colRight_cnt_item_delete"><span class="ww_commonImg ww_commonImg_DeleteItem js_delete"></span></a>'
                       + '</li>';
                $('#saveNode').append(liHtml);
            });
        },
        deleteNode: function(arr) {
            var _this = this;
            var arrNode = arr;
            $('.js_list_item').on('click', function(){

                var curId = $(this).attr('data-id');  //获取当前ID

                for(var i=0; i<arrNode.length; i++){
                    if(arrNode[i].id == curId){
                        arrNode.splice(i, 1);
                    };
                };

                //删除选中树节点的选中图标
                var selectedTreeNode = orgZTree.getNodeByParam("id", curId); 
                var aObj = $("#" + selectedTreeNode.tId + "_a");
                var checkIcon = aObj.find('.jstree-custom-checked');
                checkIcon.removeClass('selected');

                //操作接下来的逻辑
                $(this).remove();
                saveVal = arrNode;
                if(saveVal.length>0){
                    $('.multiPickerDlg_right_no_result').hide();
                }else {
                    $('.multiPickerDlg_right_no_result').show();
                };
                return saveVal;
            });
        },
        init: function(){
            this.dialog();
            this.outRepair();
        }
    };

    $.fn.orgTree = function(opts){
        var ot = new oTree(this, opts); //接收两个参数，主元素 + 设置参数 this: 使用这个插件的容器  opts: 外部配置
        return ot.init();
    };

})(jQuery,window,document);

