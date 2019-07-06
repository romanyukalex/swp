/*! jQuery v1.8.3 jquery.com | jquery.org/license */
(function(e,t){function _(e){var t=M[e]={};return v.each(e.split(y),function(e,n){t[n]=!0}),t}function H(e,n,r){if(r===t&&e.nodeType===1){var i="data-"+n.replace(P,"-$1").toLowerCase();r=e.getAttribute(i);if(typeof r=="string"){try{r=r==="true"?!0:r==="false"?!1:r==="null"?null:+r+""===r?+r:D.test(r)?v.parseJSON(r):r}catch(s){}v.data(e,n,r)}else r=t}return r}function B(e){var t;for(t in e){if(t==="data"&&v.isEmptyObject(e[t]))continue;if(t!=="toJSON")return!1}return!0}function et(){return!1}function tt(){return!0}function ut(e){return!e||!e.parentNode||e.parentNode.nodeType===11}function at(e,t){do e=e[t];while(e&&e.nodeType!==1);return e}function ft(e,t,n){t=t||0;if(v.isFunction(t))return v.grep(e,function(e,r){var i=!!t.call(e,r,e);return i===n});if(t.nodeType)return v.grep(e,function(e,r){return e===t===n});if(typeof t=="string"){var r=v.grep(e,function(e){return e.nodeType===1});if(it.test(t))return v.filter(t,r,!n);t=v.filter(t,r)}return v.grep(e,function(e,r){return v.inArray(e,t)>=0===n})}function lt(e){var t=ct.split("|"),n=e.createDocumentFragment();if(n.createElement)while(t.length)n.createElement(t.pop());return n}function Lt(e,t){return e.getElementsByTagName(t)[0]||e.appendChild(e.ownerDocument.createElement(t))}function At(e,t){if(t.nodeType!==1||!v.hasData(e))return;var n,r,i,s=v._data(e),o=v._data(t,s),u=s.events;if(u){delete o.handle,o.events={};for(n in u)for(r=0,i=u[n].length;r<i;r++)v.event.add(t,n,u[n][r])}o.data&&(o.data=v.extend({},o.data))}function Ot(e,t){var n;if(t.nodeType!==1)return;t.clearAttributes&&t.clearAttributes(),t.mergeAttributes&&t.mergeAttributes(e),n=t.nodeName.toLowerCase(),n==="object"?(t.parentNode&&(t.outerHTML=e.outerHTML),v.support.html5Clone&&e.innerHTML&&!v.trim(t.innerHTML)&&(t.innerHTML=e.innerHTML)):n==="input"&&Et.test(e.type)?(t.defaultChecked=t.checked=e.checked,t.value!==e.value&&(t.value=e.value)):n==="option"?t.selected=e.defaultSelected:n==="input"||n==="textarea"?t.defaultValue=e.defaultValue:n==="script"&&t.text!==e.text&&(t.text=e.text),t.removeAttribute(v.expando)}function Mt(e){return typeof e.getElementsByTagName!="undefined"?e.getElementsByTagName("*"):typeof e.querySelectorAll!="undefined"?e.querySelectorAll("*"):[]}function _t(e){Et.test(e.type)&&(e.defaultChecked=e.checked)}function Qt(e,t){if(t in e)return t;var n=t.charAt(0).toUpperCase()+t.slice(1),r=t,i=Jt.length;while(i--){t=Jt[i]+n;if(t in e)return t}return r}function Gt(e,t){return e=t||e,v.css(e,"display")==="none"||!v.contains(e.ownerDocument,e)}function Yt(e,t){var n,r,i=[],s=0,o=e.length;for(;s<o;s++){n=e[s];if(!n.style)continue;i[s]=v._data(n,"olddisplay"),t?(!i[s]&&n.style.display==="none"&&(n.style.display=""),n.style.display===""&&Gt(n)&&(i[s]=v._data(n,"olddisplay",nn(n.nodeName)))):(r=Dt(n,"display"),!i[s]&&r!=="none"&&v._data(n,"olddisplay",r))}for(s=0;s<o;s++){n=e[s];if(!n.style)continue;if(!t||n.style.display==="none"||n.style.display==="")n.style.display=t?i[s]||"":"none"}return e}function Zt(e,t,n){var r=Rt.exec(t);return r?Math.max(0,r[1]-(n||0))+(r[2]||"px"):t}function en(e,t,n,r){var i=n===(r?"border":"content")?4:t==="width"?1:0,s=0;for(;i<4;i+=2)n==="margin"&&(s+=v.css(e,n+$t[i],!0)),r?(n==="content"&&(s-=parseFloat(Dt(e,"padding"+$t[i]))||0),n!=="margin"&&(s-=parseFloat(Dt(e,"border"+$t[i]+"Width"))||0)):(s+=parseFloat(Dt(e,"padding"+$t[i]))||0,n!=="padding"&&(s+=parseFloat(Dt(e,"border"+$t[i]+"Width"))||0));return s}function tn(e,t,n){var r=t==="width"?e.offsetWidth:e.offsetHeight,i=!0,s=v.support.boxSizing&&v.css(e,"boxSizing")==="border-box";if(r<=0||r==null){r=Dt(e,t);if(r<0||r==null)r=e.style[t];if(Ut.test(r))return r;i=s&&(v.support.boxSizingReliable||r===e.style[t]),r=parseFloat(r)||0}return r+en(e,t,n||(s?"border":"content"),i)+"px"}function nn(e){if(Wt[e])return Wt[e];var t=v("<"+e+">").appendTo(i.body),n=t.css("display");t.remove();if(n==="none"||n===""){Pt=i.body.appendChild(Pt||v.extend(i.createElement("iframe"),{frameBorder:0,width:0,height:0}));if(!Ht||!Pt.createElement)Ht=(Pt.contentWindow||Pt.contentDocument).document,Ht.write("<!doctype html><html><body>"),Ht.close();t=Ht.body.appendChild(Ht.createElement(e)),n=Dt(t,"display"),i.body.removeChild(Pt)}return Wt[e]=n,n}function fn(e,t,n,r){var i;if(v.isArray(t))v.each(t,function(t,i){n||sn.test(e)?r(e,i):fn(e+"["+(typeof i=="object"?t:"")+"]",i,n,r)});else if(!n&&v.type(t)==="object")for(i in t)fn(e+"["+i+"]",t[i],n,r);else r(e,t)}function Cn(e){return function(t,n){typeof t!="string"&&(n=t,t="*");var r,i,s,o=t.toLowerCase().split(y),u=0,a=o.length;if(v.isFunction(n))for(;u<a;u++)r=o[u],s=/^\+/.test(r),s&&(r=r.substr(1)||"*"),i=e[r]=e[r]||[],i[s?"unshift":"push"](n)}}function kn(e,n,r,i,s,o){s=s||n.dataTypes[0],o=o||{},o[s]=!0;var u,a=e[s],f=0,l=a?a.length:0,c=e===Sn;for(;f<l&&(c||!u);f++)u=a[f](n,r,i),typeof u=="string"&&(!c||o[u]?u=t:(n.dataTypes.unshift(u),u=kn(e,n,r,i,u,o)));return(c||!u)&&!o["*"]&&(u=kn(e,n,r,i,"*",o)),u}function Ln(e,n){var r,i,s=v.ajaxSettings.flatOptions||{};for(r in n)n[r]!==t&&((s[r]?e:i||(i={}))[r]=n[r]);i&&v.extend(!0,e,i)}function An(e,n,r){var i,s,o,u,a=e.contents,f=e.dataTypes,l=e.responseFields;for(s in l)s in r&&(n[l[s]]=r[s]);while(f[0]==="*")f.shift(),i===t&&(i=e.mimeType||n.getResponseHeader("content-type"));if(i)for(s in a)if(a[s]&&a[s].test(i)){f.unshift(s);break}if(f[0]in r)o=f[0];else{for(s in r){if(!f[0]||e.converters[s+" "+f[0]]){o=s;break}u||(u=s)}o=o||u}if(o)return o!==f[0]&&f.unshift(o),r[o]}function On(e,t){var n,r,i,s,o=e.dataTypes.slice(),u=o[0],a={},f=0;e.dataFilter&&(t=e.dataFilter(t,e.dataType));if(o[1])for(n in e.converters)a[n.toLowerCase()]=e.converters[n];for(;i=o[++f];)if(i!=="*"){if(u!=="*"&&u!==i){n=a[u+" "+i]||a["* "+i];if(!n)for(r in a){s=r.split(" ");if(s[1]===i){n=a[u+" "+s[0]]||a["* "+s[0]];if(n){n===!0?n=a[r]:a[r]!==!0&&(i=s[0],o.splice(f--,0,i));break}}}if(n!==!0)if(n&&e["throws"])t=n(t);else try{t=n(t)}catch(l){return{state:"parsererror",error:n?l:"No conversion from "+u+" to "+i}}}u=i}return{state:"success",data:t}}function Fn(){try{return new e.XMLHttpRequest}catch(t){}}function In(){try{return new e.ActiveXObject("Microsoft.XMLHTTP")}catch(t){}}function $n(){return setTimeout(function(){qn=t},0),qn=v.now()}function Jn(e,t){v.each(t,function(t,n){var r=(Vn[t]||[]).concat(Vn["*"]),i=0,s=r.length;for(;i<s;i++)if(r[i].call(e,t,n))return})}function Kn(e,t,n){var r,i=0,s=0,o=Xn.length,u=v.Deferred().always(function(){delete a.elem}),a=function(){var t=qn||$n(),n=Math.max(0,f.startTime+f.duration-t),r=n/f.duration||0,i=1-r,s=0,o=f.tweens.length;for(;s<o;s++)f.tweens[s].run(i);return u.notifyWith(e,[f,i,n]),i<1&&o?n:(u.resolveWith(e,[f]),!1)},f=u.promise({elem:e,props:v.extend({},t),opts:v.extend(!0,{specialEasing:{}},n),originalProperties:t,originalOptions:n,startTime:qn||$n(),duration:n.duration,tweens:[],createTween:function(t,n,r){var i=v.Tween(e,f.opts,t,n,f.opts.specialEasing[t]||f.opts.easing);return f.tweens.push(i),i},stop:function(t){var n=0,r=t?f.tweens.length:0;for(;n<r;n++)f.tweens[n].run(1);return t?u.resolveWith(e,[f,t]):u.rejectWith(e,[f,t]),this}}),l=f.props;Qn(l,f.opts.specialEasing);for(;i<o;i++){r=Xn[i].call(f,e,l,f.opts);if(r)return r}return Jn(f,l),v.isFunction(f.opts.start)&&f.opts.start.call(e,f),v.fx.timer(v.extend(a,{anim:f,queue:f.opts.queue,elem:e})),f.progress(f.opts.progress).done(f.opts.done,f.opts.complete).fail(f.opts.fail).always(f.opts.always)}function Qn(e,t){var n,r,i,s,o;for(n in e){r=v.camelCase(n),i=t[r],s=e[n],v.isArray(s)&&(i=s[1],s=e[n]=s[0]),n!==r&&(e[r]=s,delete e[n]),o=v.cssHooks[r];if(o&&"expand"in o){s=o.expand(s),delete e[r];for(n in s)n in e||(e[n]=s[n],t[n]=i)}else t[r]=i}}function Gn(e,t,n){var r,i,s,o,u,a,f,l,c,h=this,p=e.style,d={},m=[],g=e.nodeType&&Gt(e);n.queue||(l=v._queueHooks(e,"fx"),l.unqueued==null&&(l.unqueued=0,c=l.empty.fire,l.empty.fire=function(){l.unqueued||c()}),l.unqueued++,h.always(function(){h.always(function(){l.unqueued--,v.queue(e,"fx").length||l.empty.fire()})})),e.nodeType===1&&("height"in t||"width"in t)&&(n.overflow=[p.overflow,p.overflowX,p.overflowY],v.css(e,"display")==="inline"&&v.css(e,"float")==="none"&&(!v.support.inlineBlockNeedsLayout||nn(e.nodeName)==="inline"?p.display="inline-block":p.zoom=1)),n.overflow&&(p.overflow="hidden",v.support.shrinkWrapBlocks||h.done(function(){p.overflow=n.overflow[0],p.overflowX=n.overflow[1],p.overflowY=n.overflow[2]}));for(r in t){s=t[r];if(Un.exec(s)){delete t[r],a=a||s==="toggle";if(s===(g?"hide":"show"))continue;m.push(r)}}o=m.length;if(o){u=v._data(e,"fxshow")||v._data(e,"fxshow",{}),"hidden"in u&&(g=u.hidden),a&&(u.hidden=!g),g?v(e).show():h.done(function(){v(e).hide()}),h.done(function(){var t;v.removeData(e,"fxshow",!0);for(t in d)v.style(e,t,d[t])});for(r=0;r<o;r++)i=m[r],f=h.createTween(i,g?u[i]:0),d[i]=u[i]||v.style(e,i),i in u||(u[i]=f.start,g&&(f.end=f.start,f.start=i==="width"||i==="height"?1:0))}}function Yn(e,t,n,r,i){return new Yn.prototype.init(e,t,n,r,i)}function Zn(e,t){var n,r={height:e},i=0;t=t?1:0;for(;i<4;i+=2-t)n=$t[i],r["margin"+n]=r["padding"+n]=e;return t&&(r.opacity=r.width=e),r}function tr(e){return v.isWindow(e)?e:e.nodeType===9?e.defaultView||e.parentWindow:!1}var n,r,i=e.document,s=e.location,o=e.navigator,u=e.jQuery,a=e.$,f=Array.prototype.push,l=Array.prototype.slice,c=Array.prototype.indexOf,h=Object.prototype.toString,p=Object.prototype.hasOwnProperty,d=String.prototype.trim,v=function(e,t){return new v.fn.init(e,t,n)},m=/[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source,g=/\S/,y=/\s+/,b=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,w=/^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,E=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,S=/^[\],:{}\s]*$/,x=/(?:^|:|,)(?:\s*\[)+/g,T=/\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,N=/"[^"\\\r\n]*"|true|false|null|-?(?:\d\d*\.|)\d+(?:[eE][\-+]?\d+|)/g,C=/^-ms-/,k=/-([\da-z])/gi,L=function(e,t){return(t+"").toUpperCase()},A=function(){i.addEventListener?(i.removeEventListener("DOMContentLoaded",A,!1),v.ready()):i.readyState==="complete"&&(i.detachEvent("onreadystatechange",A),v.ready())},O={};v.fn=v.prototype={constructor:v,init:function(e,n,r){var s,o,u,a;if(!e)return this;if(e.nodeType)return this.context=this[0]=e,this.length=1,this;if(typeof e=="string"){e.charAt(0)==="<"&&e.charAt(e.length-1)===">"&&e.length>=3?s=[null,e,null]:s=w.exec(e);if(s&&(s[1]||!n)){if(s[1])return n=n instanceof v?n[0]:n,a=n&&n.nodeType?n.ownerDocument||n:i,e=v.parseHTML(s[1],a,!0),E.test(s[1])&&v.isPlainObject(n)&&this.attr.call(e,n,!0),v.merge(this,e);o=i.getElementById(s[2]);if(o&&o.parentNode){if(o.id!==s[2])return r.find(e);this.length=1,this[0]=o}return this.context=i,this.selector=e,this}return!n||n.jquery?(n||r).find(e):this.constructor(n).find(e)}return v.isFunction(e)?r.ready(e):(e.selector!==t&&(this.selector=e.selector,this.context=e.context),v.makeArray(e,this))},selector:"",jquery:"1.8.3",length:0,size:function(){return this.length},toArray:function(){return l.call(this)},get:function(e){return e==null?this.toArray():e<0?this[this.length+e]:this[e]},pushStack:function(e,t,n){var r=v.merge(this.constructor(),e);return r.prevObject=this,r.context=this.context,t==="find"?r.selector=this.selector+(this.selector?" ":"")+n:t&&(r.selector=this.selector+"."+t+"("+n+")"),r},each:function(e,t){return v.each(this,e,t)},ready:function(e){return v.ready.promise().done(e),this},eq:function(e){return e=+e,e===-1?this.slice(e):this.slice(e,e+1)},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},slice:function(){return this.pushStack(l.apply(this,arguments),"slice",l.call(arguments).join(","))},map:function(e){return this.pushStack(v.map(this,function(t,n){return e.call(t,n,t)}))},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:[].sort,splice:[].splice},v.fn.init.prototype=v.fn,v.extend=v.fn.extend=function(){var e,n,r,i,s,o,u=arguments[0]||{},a=1,f=arguments.length,l=!1;typeof u=="boolean"&&(l=u,u=arguments[1]||{},a=2),typeof u!="object"&&!v.isFunction(u)&&(u={}),f===a&&(u=this,--a);for(;a<f;a++)if((e=arguments[a])!=null)for(n in e){r=u[n],i=e[n];if(u===i)continue;l&&i&&(v.isPlainObject(i)||(s=v.isArray(i)))?(s?(s=!1,o=r&&v.isArray(r)?r:[]):o=r&&v.isPlainObject(r)?r:{},u[n]=v.extend(l,o,i)):i!==t&&(u[n]=i)}return u},v.extend({noConflict:function(t){return e.$===v&&(e.$=a),t&&e.jQuery===v&&(e.jQuery=u),v},isReady:!1,readyWait:1,holdReady:function(e){e?v.readyWait++:v.ready(!0)},ready:function(e){if(e===!0?--v.readyWait:v.isReady)return;if(!i.body)return setTimeout(v.ready,1);v.isReady=!0;if(e!==!0&&--v.readyWait>0)return;r.resolveWith(i,[v]),v.fn.trigger&&v(i).trigger("ready").off("ready")},isFunction:function(e){return v.type(e)==="function"},isArray:Array.isArray||function(e){return v.type(e)==="array"},isWindow:function(e){return e!=null&&e==e.window},isNumeric:function(e){return!isNaN(parseFloat(e))&&isFinite(e)},type:function(e){return e==null?String(e):O[h.call(e)]||"object"},isPlainObject:function(e){if(!e||v.type(e)!=="object"||e.nodeType||v.isWindow(e))return!1;try{if(e.constructor&&!p.call(e,"constructor")&&!p.call(e.constructor.prototype,"isPrototypeOf"))return!1}catch(n){return!1}var r;for(r in e);return r===t||p.call(e,r)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},error:function(e){throw new Error(e)},parseHTML:function(e,t,n){var r;return!e||typeof e!="string"?null:(typeof t=="boolean"&&(n=t,t=0),t=t||i,(r=E.exec(e))?[t.createElement(r[1])]:(r=v.buildFragment([e],t,n?null:[]),v.merge([],(r.cacheable?v.clone(r.fragment):r.fragment).childNodes)))},parseJSON:function(t){if(!t||typeof t!="string")return null;t=v.trim(t);if(e.JSON&&e.JSON.parse)return e.JSON.parse(t);if(S.test(t.replace(T,"@").replace(N,"]").replace(x,"")))return(new Function("return "+t))();v.error("Invalid JSON: "+t)},parseXML:function(n){var r,i;if(!n||typeof n!="string")return null;try{e.DOMParser?(i=new DOMParser,r=i.parseFromString(n,"text/xml")):(r=new ActiveXObject("Microsoft.XMLDOM"),r.async="false",r.loadXML(n))}catch(s){r=t}return(!r||!r.documentElement||r.getElementsByTagName("parsererror").length)&&v.error("Invalid XML: "+n),r},noop:function(){},globalEval:function(t){t&&g.test(t)&&(e.execScript||function(t){e.eval.call(e,t)})(t)},camelCase:function(e){return e.replace(C,"ms-").replace(k,L)},nodeName:function(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()},each:function(e,n,r){var i,s=0,o=e.length,u=o===t||v.isFunction(e);if(r){if(u){for(i in e)if(n.apply(e[i],r)===!1)break}else for(;s<o;)if(n.apply(e[s++],r)===!1)break}else if(u){for(i in e)if(n.call(e[i],i,e[i])===!1)break}else for(;s<o;)if(n.call(e[s],s,e[s++])===!1)break;return e},trim:d&&!d.call("\ufeff\u00a0")?function(e){return e==null?"":d.call(e)}:function(e){return e==null?"":(e+"").replace(b,"")},makeArray:function(e,t){var n,r=t||[];return e!=null&&(n=v.type(e),e.length==null||n==="string"||n==="function"||n==="regexp"||v.isWindow(e)?f.call(r,e):v.merge(r,e)),r},inArray:function(e,t,n){var r;if(t){if(c)return c.call(t,e,n);r=t.length,n=n?n<0?Math.max(0,r+n):n:0;for(;n<r;n++)if(n in t&&t[n]===e)return n}return-1},merge:function(e,n){var r=n.length,i=e.length,s=0;if(typeof r=="number")for(;s<r;s++)e[i++]=n[s];else while(n[s]!==t)e[i++]=n[s++];return e.length=i,e},grep:function(e,t,n){var r,i=[],s=0,o=e.length;n=!!n;for(;s<o;s++)r=!!t(e[s],s),n!==r&&i.push(e[s]);return i},map:function(e,n,r){var i,s,o=[],u=0,a=e.length,f=e instanceof v||a!==t&&typeof a=="number"&&(a>0&&e[0]&&e[a-1]||a===0||v.isArray(e));if(f)for(;u<a;u++)i=n(e[u],u,r),i!=null&&(o[o.length]=i);else for(s in e)i=n(e[s],s,r),i!=null&&(o[o.length]=i);return o.concat.apply([],o)},guid:1,proxy:function(e,n){var r,i,s;return typeof n=="string"&&(r=e[n],n=e,e=r),v.isFunction(e)?(i=l.call(arguments,2),s=function(){return e.apply(n,i.concat(l.call(arguments)))},s.guid=e.guid=e.guid||v.guid++,s):t},access:function(e,n,r,i,s,o,u){var a,f=r==null,l=0,c=e.length;if(r&&typeof r=="object"){for(l in r)v.access(e,n,l,r[l],1,o,i);s=1}else if(i!==t){a=u===t&&v.isFunction(i),f&&(a?(a=n,n=function(e,t,n){return a.call(v(e),n)}):(n.call(e,i),n=null));if(n)for(;l<c;l++)n(e[l],r,a?i.call(e[l],l,n(e[l],r)):i,u);s=1}return s?e:f?n.call(e):c?n(e[0],r):o},now:function(){return(new Date).getTime()}}),v.ready.promise=function(t){if(!r){r=v.Deferred();if(i.readyState==="complete")setTimeout(v.ready,1);else if(i.addEventListener)i.addEventListener("DOMContentLoaded",A,!1),e.addEventListener("load",v.ready,!1);else{i.attachEvent("onreadystatechange",A),e.attachEvent("onload",v.ready);var n=!1;try{n=e.frameElement==null&&i.documentElement}catch(s){}n&&n.doScroll&&function o(){if(!v.isReady){try{n.doScroll("left")}catch(e){return setTimeout(o,50)}v.ready()}}()}}return r.promise(t)},v.each("Boolean Number String Function Array Date RegExp Object".split(" "),function(e,t){O["[object "+t+"]"]=t.toLowerCase()}),n=v(i);var M={};v.Callbacks=function(e){e=typeof e=="string"?M[e]||_(e):v.extend({},e);var n,r,i,s,o,u,a=[],f=!e.once&&[],l=function(t){n=e.memory&&t,r=!0,u=s||0,s=0,o=a.length,i=!0;for(;a&&u<o;u++)if(a[u].apply(t[0],t[1])===!1&&e.stopOnFalse){n=!1;break}i=!1,a&&(f?f.length&&l(f.shift()):n?a=[]:c.disable())},c={add:function(){if(a){var t=a.length;(function r(t){v.each(t,function(t,n){var i=v.type(n);i==="function"?(!e.unique||!c.has(n))&&a.push(n):n&&n.length&&i!=="string"&&r(n)})})(arguments),i?o=a.length:n&&(s=t,l(n))}return this},remove:function(){return a&&v.each(arguments,function(e,t){var n;while((n=v.inArray(t,a,n))>-1)a.splice(n,1),i&&(n<=o&&o--,n<=u&&u--)}),this},has:function(e){return v.inArray(e,a)>-1},empty:function(){return a=[],this},disable:function(){return a=f=n=t,this},disabled:function(){return!a},lock:function(){return f=t,n||c.disable(),this},locked:function(){return!f},fireWith:function(e,t){return t=t||[],t=[e,t.slice?t.slice():t],a&&(!r||f)&&(i?f.push(t):l(t)),this},fire:function(){return c.fireWith(this,arguments),this},fired:function(){return!!r}};return c},v.extend({Deferred:function(e){var t=[["resolve","done",v.Callbacks("once memory"),"resolved"],["reject","fail",v.Callbacks("once memory"),"rejected"],["notify","progress",v.Callbacks("memory")]],n="pending",r={state:function(){return n},always:function(){return i.done(arguments).fail(arguments),this},then:function(){var e=arguments;return v.Deferred(function(n){v.each(t,function(t,r){var s=r[0],o=e[t];i[r[1]](v.isFunction(o)?function(){var e=o.apply(this,arguments);e&&v.isFunction(e.promise)?e.promise().done(n.resolve).fail(n.reject).progress(n.notify):n[s+"With"](this===i?n:this,[e])}:n[s])}),e=null}).promise()},promise:function(e){return e!=null?v.extend(e,r):r}},i={};return r.pipe=r.then,v.each(t,function(e,s){var o=s[2],u=s[3];r[s[1]]=o.add,u&&o.add(function(){n=u},t[e^1][2].disable,t[2][2].lock),i[s[0]]=o.fire,i[s[0]+"With"]=o.fireWith}),r.promise(i),e&&e.call(i,i),i},when:function(e){var t=0,n=l.call(arguments),r=n.length,i=r!==1||e&&v.isFunction(e.promise)?r:0,s=i===1?e:v.Deferred(),o=function(e,t,n){return function(r){t[e]=this,n[e]=arguments.length>1?l.call(arguments):r,n===u?s.notifyWith(t,n):--i||s.resolveWith(t,n)}},u,a,f;if(r>1){u=new Array(r),a=new Array(r),f=new Array(r);for(;t<r;t++)n[t]&&v.isFunction(n[t].promise)?n[t].promise().done(o(t,f,n)).fail(s.reject).progress(o(t,a,u)):--i}return i||s.resolveWith(f,n),s.promise()}}),v.support=function(){var t,n,r,s,o,u,a,f,l,c,h,p=i.createElement("div");p.setAttribute("className","t"),p.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",n=p.getElementsByTagName("*"),r=p.getElementsByTagName("a")[0];if(!n||!r||!n.length)return{};s=i.createElement("select"),o=s.appendChild(i.createElement("option")),u=p.getElementsByTagName("input")[0],r.style.cssText="top:1px;float:left;opacity:.5",t={leadingWhitespace:p.firstChild.nodeType===3,tbody:!p.getElementsByTagName("tbody").length,htmlSerialize:!!p.getElementsByTagName("link").length,style:/top/.test(r.getAttribute("style")),hrefNormalized:r.getAttribute("href")==="/a",opacity:/^0.5/.test(r.style.opacity),cssFloat:!!r.style.cssFloat,checkOn:u.value==="on",optSelected:o.selected,getSetAttribute:p.className!=="t",enctype:!!i.createElement("form").enctype,html5Clone:i.createElement("nav").cloneNode(!0).outerHTML!=="<:nav></:nav>",boxModel:i.compatMode==="CSS1Compat",submitBubbles:!0,changeBubbles:!0,focusinBubbles:!1,deleteExpando:!0,noCloneEvent:!0,inlineBlockNeedsLayout:!1,shrinkWrapBlocks:!1,reliableMarginRight:!0,boxSizingReliable:!0,pixelPosition:!1},u.checked=!0,t.noCloneChecked=u.cloneNode(!0).checked,s.disabled=!0,t.optDisabled=!o.disabled;try{delete p.test}catch(d){t.deleteExpando=!1}!p.addEventListener&&p.attachEvent&&p.fireEvent&&(p.attachEvent("onclick",h=function(){t.noCloneEvent=!1}),p.cloneNode(!0).fireEvent("onclick"),p.detachEvent("onclick",h)),u=i.createElement("input"),u.value="t",u.setAttribute("type","radio"),t.radioValue=u.value==="t",u.setAttribute("checked","checked"),u.setAttribute("name","t"),p.appendChild(u),a=i.createDocumentFragment(),a.appendChild(p.lastChild),t.checkClone=a.cloneNode(!0).cloneNode(!0).lastChild.checked,t.appendChecked=u.checked,a.removeChild(u),a.appendChild(p);if(p.attachEvent)for(l in{submit:!0,change:!0,focusin:!0})f="on"+l,c=f in p,c||(p.setAttribute(f,"return;"),c=typeof p[f]=="function"),t[l+"Bubbles"]=c;return v(function(){var n,r,s,o,u="padding:0;margin:0;border:0;display:block;overflow:hidden;",a=i.getElementsByTagName("body")[0];if(!a)return;n=i.createElement("div"),n.style.cssText="visibility:hidden;border:0;width:0;height:0;position:static;top:0;margin-top:1px",a.insertBefore(n,a.firstChild),r=i.createElement("div"),n.appendChild(r),r.innerHTML="<table><tr><td></td><td>t</td></tr></table>",s=r.getElementsByTagName("td"),s[0].style.cssText="padding:0;margin:0;border:0;display:none",c=s[0].offsetHeight===0,s[0].style.display="",s[1].style.display="none",t.reliableHiddenOffsets=c&&s[0].offsetHeight===0,r.innerHTML="",r.style.cssText="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;",t.boxSizing=r.offsetWidth===4,t.doesNotIncludeMarginInBodyOffset=a.offsetTop!==1,e.getComputedStyle&&(t.pixelPosition=(e.getComputedStyle(r,null)||{}).top!=="1%",t.boxSizingReliable=(e.getComputedStyle(r,null)||{width:"4px"}).width==="4px",o=i.createElement("div"),o.style.cssText=r.style.cssText=u,o.style.marginRight=o.style.width="0",r.style.width="1px",r.appendChild(o),t.reliableMarginRight=!parseFloat((e.getComputedStyle(o,null)||{}).marginRight)),typeof r.style.zoom!="undefined"&&(r.innerHTML="",r.style.cssText=u+"width:1px;padding:1px;display:inline;zoom:1",t.inlineBlockNeedsLayout=r.offsetWidth===3,r.style.display="block",r.style.overflow="visible",r.innerHTML="<div></div>",r.firstChild.style.width="5px",t.shrinkWrapBlocks=r.offsetWidth!==3,n.style.zoom=1),a.removeChild(n),n=r=s=o=null}),a.removeChild(p),n=r=s=o=u=a=p=null,t}();var D=/(?:\{[\s\S]*\}|\[[\s\S]*\])$/,P=/([A-Z])/g;v.extend({cache:{},deletedIds:[],uuid:0,expando:"jQuery"+(v.fn.jquery+Math.random()).replace(/\D/g,""),noData:{embed:!0,object:"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",applet:!0},hasData:function(e){return e=e.nodeType?v.cache[e[v.expando]]:e[v.expando],!!e&&!B(e)},data:function(e,n,r,i){if(!v.acceptData(e))return;var s,o,u=v.expando,a=typeof n=="string",f=e.nodeType,l=f?v.cache:e,c=f?e[u]:e[u]&&u;if((!c||!l[c]||!i&&!l[c].data)&&a&&r===t)return;c||(f?e[u]=c=v.deletedIds.pop()||v.guid++:c=u),l[c]||(l[c]={},f||(l[c].toJSON=v.noop));if(typeof n=="object"||typeof n=="function")i?l[c]=v.extend(l[c],n):l[c].data=v.extend(l[c].data,n);return s=l[c],i||(s.data||(s.data={}),s=s.data),r!==t&&(s[v.camelCase(n)]=r),a?(o=s[n],o==null&&(o=s[v.camelCase(n)])):o=s,o},removeData:function(e,t,n){if(!v.acceptData(e))return;var r,i,s,o=e.nodeType,u=o?v.cache:e,a=o?e[v.expando]:v.expando;if(!u[a])return;if(t){r=n?u[a]:u[a].data;if(r){v.isArray(t)||(t in r?t=[t]:(t=v.camelCase(t),t in r?t=[t]:t=t.split(" ")));for(i=0,s=t.length;i<s;i++)delete r[t[i]];if(!(n?B:v.isEmptyObject)(r))return}}if(!n){delete u[a].data;if(!B(u[a]))return}o?v.cleanData([e],!0):v.support.deleteExpando||u!=u.window?delete u[a]:u[a]=null},_data:function(e,t,n){return v.data(e,t,n,!0)},acceptData:function(e){var t=e.nodeName&&v.noData[e.nodeName.toLowerCase()];return!t||t!==!0&&e.getAttribute("classid")===t}}),v.fn.extend({data:function(e,n){var r,i,s,o,u,a=this[0],f=0,l=null;if(e===t){if(this.length){l=v.data(a);if(a.nodeType===1&&!v._data(a,"parsedAttrs")){s=a.attributes;for(u=s.length;f<u;f++)o=s[f].name,o.indexOf("data-")||(o=v.camelCase(o.substring(5)),H(a,o,l[o]));v._data(a,"parsedAttrs",!0)}}return l}return typeof e=="object"?this.each(function(){v.data(this,e)}):(r=e.split(".",2),r[1]=r[1]?"."+r[1]:"",i=r[1]+"!",v.access(this,function(n){if(n===t)return l=this.triggerHandler("getData"+i,[r[0]]),l===t&&a&&(l=v.data(a,e),l=H(a,e,l)),l===t&&r[1]?this.data(r[0]):l;r[1]=n,this.each(function(){var t=v(this);t.triggerHandler("setData"+i,r),v.data(this,e,n),t.triggerHandler("changeData"+i,r)})},null,n,arguments.length>1,null,!1))},removeData:function(e){return this.each(function(){v.removeData(this,e)})}}),v.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=v._data(e,t),n&&(!r||v.isArray(n)?r=v._data(e,t,v.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=v.queue(e,t),r=n.length,i=n.shift(),s=v._queueHooks(e,t),o=function(){v.dequeue(e,t)};i==="inprogress"&&(i=n.shift(),r--),i&&(t==="fx"&&n.unshift("inprogress"),delete s.stop,i.call(e,o,s)),!r&&s&&s.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return v._data(e,n)||v._data(e,n,{empty:v.Callbacks("once memory").add(function(){v.removeData(e,t+"queue",!0),v.removeData(e,n,!0)})})}}),v.fn.extend({queue:function(e,n){var r=2;return typeof e!="string"&&(n=e,e="fx",r--),arguments.length<r?v.queue(this[0],e):n===t?this:this.each(function(){var t=v.queue(this,e,n);v._queueHooks(this,e),e==="fx"&&t[0]!=="inprogress"&&v.dequeue(this,e)})},dequeue:function(e){return this.each(function(){v.dequeue(this,e)})},delay:function(e,t){return e=v.fx?v.fx.speeds[e]||e:e,t=t||"fx",this.queue(t,function(t,n){var r=setTimeout(t,e);n.stop=function(){clearTimeout(r)}})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,n){var r,i=1,s=v.Deferred(),o=this,u=this.length,a=function(){--i||s.resolveWith(o,[o])};typeof e!="string"&&(n=e,e=t),e=e||"fx";while(u--)r=v._data(o[u],e+"queueHooks"),r&&r.empty&&(i++,r.empty.add(a));return a(),s.promise(n)}});var j,F,I,q=/[\t\r\n]/g,R=/\r/g,U=/^(?:button|input)$/i,z=/^(?:button|input|object|select|textarea)$/i,W=/^a(?:rea|)$/i,X=/^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,V=v.support.getSetAttribute;v.fn.extend({attr:function(e,t){return v.access(this,v.attr,e,t,arguments.length>1)},removeAttr:function(e){return this.each(function(){v.removeAttr(this,e)})},prop:function(e,t){return v.access(this,v.prop,e,t,arguments.length>1)},removeProp:function(e){return e=v.propFix[e]||e,this.each(function(){try{this[e]=t,delete this[e]}catch(n){}})},addClass:function(e){var t,n,r,i,s,o,u;if(v.isFunction(e))return this.each(function(t){v(this).addClass(e.call(this,t,this.className))});if(e&&typeof e=="string"){t=e.split(y);for(n=0,r=this.length;n<r;n++){i=this[n];if(i.nodeType===1)if(!i.className&&t.length===1)i.className=e;else{s=" "+i.className+" ";for(o=0,u=t.length;o<u;o++)s.indexOf(" "+t[o]+" ")<0&&(s+=t[o]+" ");i.className=v.trim(s)}}}return this},removeClass:function(e){var n,r,i,s,o,u,a;if(v.isFunction(e))return this.each(function(t){v(this).removeClass(e.call(this,t,this.className))});if(e&&typeof e=="string"||e===t){n=(e||"").split(y);for(u=0,a=this.length;u<a;u++){i=this[u];if(i.nodeType===1&&i.className){r=(" "+i.className+" ").replace(q," ");for(s=0,o=n.length;s<o;s++)while(r.indexOf(" "+n[s]+" ")>=0)r=r.replace(" "+n[s]+" "," ");i.className=e?v.trim(r):""}}}return this},toggleClass:function(e,t){var n=typeof e,r=typeof t=="boolean";return v.isFunction(e)?this.each(function(n){v(this).toggleClass(e.call(this,n,this.className,t),t)}):this.each(function(){if(n==="string"){var i,s=0,o=v(this),u=t,a=e.split(y);while(i=a[s++])u=r?u:!o.hasClass(i),o[u?"addClass":"removeClass"](i)}else if(n==="undefined"||n==="boolean")this.className&&v._data(this,"__className__",this.className),this.className=this.className||e===!1?"":v._data(this,"__className__")||""})},hasClass:function(e){var t=" "+e+" ",n=0,r=this.length;for(;n<r;n++)if(this[n].nodeType===1&&(" "+this[n].className+" ").replace(q," ").indexOf(t)>=0)return!0;return!1},val:function(e){var n,r,i,s=this[0];if(!arguments.length){if(s)return n=v.valHooks[s.type]||v.valHooks[s.nodeName.toLowerCase()],n&&"get"in n&&(r=n.get(s,"value"))!==t?r:(r=s.value,typeof r=="string"?r.replace(R,""):r==null?"":r);return}return i=v.isFunction(e),this.each(function(r){var s,o=v(this);if(this.nodeType!==1)return;i?s=e.call(this,r,o.val()):s=e,s==null?s="":typeof s=="number"?s+="":v.isArray(s)&&(s=v.map(s,function(e){return e==null?"":e+""})),n=v.valHooks[this.type]||v.valHooks[this.nodeName.toLowerCase()];if(!n||!("set"in n)||n.set(this,s,"value")===t)this.value=s})}}),v.extend({valHooks:{option:{get:function(e){var t=e.attributes.value;return!t||t.specified?e.value:e.text}},select:{get:function(e){var t,n,r=e.options,i=e.selectedIndex,s=e.type==="select-one"||i<0,o=s?null:[],u=s?i+1:r.length,a=i<0?u:s?i:0;for(;a<u;a++){n=r[a];if((n.selected||a===i)&&(v.support.optDisabled?!n.disabled:n.getAttribute("disabled")===null)&&(!n.parentNode.disabled||!v.nodeName(n.parentNode,"optgroup"))){t=v(n).val();if(s)return t;o.push(t)}}return o},set:function(e,t){var n=v.makeArray(t);return v(e).find("option").each(function(){this.selected=v.inArray(v(this).val(),n)>=0}),n.length||(e.selectedIndex=-1),n}}},attrFn:{},attr:function(e,n,r,i){var s,o,u,a=e.nodeType;if(!e||a===3||a===8||a===2)return;if(i&&v.isFunction(v.fn[n]))return v(e)[n](r);if(typeof e.getAttribute=="undefined")return v.prop(e,n,r);u=a!==1||!v.isXMLDoc(e),u&&(n=n.toLowerCase(),o=v.attrHooks[n]||(X.test(n)?F:j));if(r!==t){if(r===null){v.removeAttr(e,n);return}return o&&"set"in o&&u&&(s=o.set(e,r,n))!==t?s:(e.setAttribute(n,r+""),r)}return o&&"get"in o&&u&&(s=o.get(e,n))!==null?s:(s=e.getAttribute(n),s===null?t:s)},removeAttr:function(e,t){var n,r,i,s,o=0;if(t&&e.nodeType===1){r=t.split(y);for(;o<r.length;o++)i=r[o],i&&(n=v.propFix[i]||i,s=X.test(i),s||v.attr(e,i,""),e.removeAttribute(V?i:n),s&&n in e&&(e[n]=!1))}},attrHooks:{type:{set:function(e,t){if(U.test(e.nodeName)&&e.parentNode)v.error("type property can't be changed");else if(!v.support.radioValue&&t==="radio"&&v.nodeName(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}},value:{get:function(e,t){return j&&v.nodeName(e,"button")?j.get(e,t):t in e?e.value:null},set:function(e,t,n){if(j&&v.nodeName(e,"button"))return j.set(e,t,n);e.value=t}}},propFix:{tabindex:"tabIndex",readonly:"readOnly","for":"htmlFor","class":"className",maxlength:"maxLength",cellspacing:"cellSpacing",cellpadding:"cellPadding",rowspan:"rowSpan",colspan:"colSpan",usemap:"useMap",frameborder:"frameBorder",contenteditable:"contentEditable"},prop:function(e,n,r){var i,s,o,u=e.nodeType;if(!e||u===3||u===8||u===2)return;return o=u!==1||!v.isXMLDoc(e),o&&(n=v.propFix[n]||n,s=v.propHooks[n]),r!==t?s&&"set"in s&&(i=s.set(e,r,n))!==t?i:e[n]=r:s&&"get"in s&&(i=s.get(e,n))!==null?i:e[n]},propHooks:{tabIndex:{get:function(e){var n=e.getAttributeNode("tabindex");return n&&n.specified?parseInt(n.value,10):z.test(e.nodeName)||W.test(e.nodeName)&&e.href?0:t}}}}),F={get:function(e,n){var r,i=v.prop(e,n);return i===!0||typeof i!="boolean"&&(r=e.getAttributeNode(n))&&r.nodeValue!==!1?n.toLowerCase():t},set:function(e,t,n){var r;return t===!1?v.removeAttr(e,n):(r=v.propFix[n]||n,r in e&&(e[r]=!0),e.setAttribute(n,n.toLowerCase())),n}},V||(I={name:!0,id:!0,coords:!0},j=v.valHooks.button={get:function(e,n){var r;return r=e.getAttributeNode(n),r&&(I[n]?r.value!=="":r.specified)?r.value:t},set:function(e,t,n){var r=e.getAttributeNode(n);return r||(r=i.createAttribute(n),e.setAttributeNode(r)),r.value=t+""}},v.each(["width","height"],function(e,t){v.attrHooks[t]=v.extend(v.attrHooks[t],{set:function(e,n){if(n==="")return e.setAttribute(t,"auto"),n}})}),v.attrHooks.contenteditable={get:j.get,set:function(e,t,n){t===""&&(t="false"),j.set(e,t,n)}}),v.support.hrefNormalized||v.each(["href","src","width","height"],function(e,n){v.attrHooks[n]=v.extend(v.attrHooks[n],{get:function(e){var r=e.getAttribute(n,2);return r===null?t:r}})}),v.support.style||(v.attrHooks.style={get:function(e){return e.style.cssText.toLowerCase()||t},set:function(e,t){return e.style.cssText=t+""}}),v.support.optSelected||(v.propHooks.selected=v.extend(v.propHooks.selected,{get:function(e){var t=e.parentNode;return t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex),null}})),v.support.enctype||(v.propFix.enctype="encoding"),v.support.checkOn||v.each(["radio","checkbox"],function(){v.valHooks[this]={get:function(e){return e.getAttribute("value")===null?"on":e.value}}}),v.each(["radio","checkbox"],function(){v.valHooks[this]=v.extend(v.valHooks[this],{set:function(e,t){if(v.isArray(t))return e.checked=v.inArray(v(e).val(),t)>=0}})});var $=/^(?:textarea|input|select)$/i,J=/^([^\.]*|)(?:\.(.+)|)$/,K=/(?:^|\s)hover(\.\S+|)\b/,Q=/^key/,G=/^(?:mouse|contextmenu)|click/,Y=/^(?:focusinfocus|focusoutblur)$/,Z=function(e){return v.event.special.hover?e:e.replace(K,"mouseenter$1 mouseleave$1")};v.event={add:function(e,n,r,i,s){var o,u,a,f,l,c,h,p,d,m,g;if(e.nodeType===3||e.nodeType===8||!n||!r||!(o=v._data(e)))return;r.handler&&(d=r,r=d.handler,s=d.selector),r.guid||(r.guid=v.guid++),a=o.events,a||(o.events=a={}),u=o.handle,u||(o.handle=u=function(e){return typeof v=="undefined"||!!e&&v.event.triggered===e.type?t:v.event.dispatch.apply(u.elem,arguments)},u.elem=e),n=v.trim(Z(n)).split(" ");for(f=0;f<n.length;f++){l=J.exec(n[f])||[],c=l[1],h=(l[2]||"").split(".").sort(),g=v.event.special[c]||{},c=(s?g.delegateType:g.bindType)||c,g=v.event.special[c]||{},p=v.extend({type:c,origType:l[1],data:i,handler:r,guid:r.guid,selector:s,needsContext:s&&v.expr.match.needsContext.test(s),namespace:h.join(".")},d),m=a[c];if(!m){m=a[c]=[],m.delegateCount=0;if(!g.setup||g.setup.call(e,i,h,u)===!1)e.addEventListener?e.addEventListener(c,u,!1):e.attachEvent&&e.attachEvent("on"+c,u)}g.add&&(g.add.call(e,p),p.handler.guid||(p.handler.guid=r.guid)),s?m.splice(m.delegateCount++,0,p):m.push(p),v.event.global[c]=!0}e=null},global:{},remove:function(e,t,n,r,i){var s,o,u,a,f,l,c,h,p,d,m,g=v.hasData(e)&&v._data(e);if(!g||!(h=g.events))return;t=v.trim(Z(t||"")).split(" ");for(s=0;s<t.length;s++){o=J.exec(t[s])||[],u=a=o[1],f=o[2];if(!u){for(u in h)v.event.remove(e,u+t[s],n,r,!0);continue}p=v.event.special[u]||{},u=(r?p.delegateType:p.bindType)||u,d=h[u]||[],l=d.length,f=f?new RegExp("(^|\\.)"+f.split(".").sort().join("\\.(?:.*\\.|)")+"(\\.|$)"):null;for(c=0;c<d.length;c++)m=d[c],(i||a===m.origType)&&(!n||n.guid===m.guid)&&(!f||f.test(m.namespace))&&(!r||r===m.selector||r==="**"&&m.selector)&&(d.splice(c--,1),m.selector&&d.delegateCount--,p.remove&&p.remove.call(e,m));d.length===0&&l!==d.length&&((!p.teardown||p.teardown.call(e,f,g.handle)===!1)&&v.removeEvent(e,u,g.handle),delete h[u])}v.isEmptyObject(h)&&(delete g.handle,v.removeData(e,"events",!0))},customEvent:{getData:!0,setData:!0,changeData:!0},trigger:function(n,r,s,o){if(!s||s.nodeType!==3&&s.nodeType!==8){var u,a,f,l,c,h,p,d,m,g,y=n.type||n,b=[];if(Y.test(y+v.event.triggered))return;y.indexOf("!")>=0&&(y=y.slice(0,-1),a=!0),y.indexOf(".")>=0&&(b=y.split("."),y=b.shift(),b.sort());if((!s||v.event.customEvent[y])&&!v.event.global[y])return;n=typeof n=="object"?n[v.expando]?n:new v.Event(y,n):new v.Event(y),n.type=y,n.isTrigger=!0,n.exclusive=a,n.namespace=b.join("."),n.namespace_re=n.namespace?new RegExp("(^|\\.)"+b.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,h=y.indexOf(":")<0?"on"+y:"";if(!s){u=v.cache;for(f in u)u[f].events&&u[f].events[y]&&v.event.trigger(n,r,u[f].handle.elem,!0);return}n.result=t,n.target||(n.target=s),r=r!=null?v.makeArray(r):[],r.unshift(n),p=v.event.special[y]||{};if(p.trigger&&p.trigger.apply(s,r)===!1)return;m=[[s,p.bindType||y]];if(!o&&!p.noBubble&&!v.isWindow(s)){g=p.delegateType||y,l=Y.test(g+y)?s:s.parentNode;for(c=s;l;l=l.parentNode)m.push([l,g]),c=l;c===(s.ownerDocument||i)&&m.push([c.defaultView||c.parentWindow||e,g])}for(f=0;f<m.length&&!n.isPropagationStopped();f++)l=m[f][0],n.type=m[f][1],d=(v._data(l,"events")||{})[n.type]&&v._data(l,"handle"),d&&d.apply(l,r),d=h&&l[h],d&&v.acceptData(l)&&d.apply&&d.apply(l,r)===!1&&n.preventDefault();return n.type=y,!o&&!n.isDefaultPrevented()&&(!p._default||p._default.apply(s.ownerDocument,r)===!1)&&(y!=="click"||!v.nodeName(s,"a"))&&v.acceptData(s)&&h&&s[y]&&(y!=="focus"&&y!=="blur"||n.target.offsetWidth!==0)&&!v.isWindow(s)&&(c=s[h],c&&(s[h]=null),v.event.triggered=y,s[y](),v.event.triggered=t,c&&(s[h]=c)),n.result}return},dispatch:function(n){n=v.event.fix(n||e.event);var r,i,s,o,u,a,f,c,h,p,d=(v._data(this,"events")||{})[n.type]||[],m=d.delegateCount,g=l.call(arguments),y=!n.exclusive&&!n.namespace,b=v.event.special[n.type]||{},w=[];g[0]=n,n.delegateTarget=this;if(b.preDispatch&&b.preDispatch.call(this,n)===!1)return;if(m&&(!n.button||n.type!=="click"))for(s=n.target;s!=this;s=s.parentNode||this)if(s.disabled!==!0||n.type!=="click"){u={},f=[];for(r=0;r<m;r++)c=d[r],h=c.selector,u[h]===t&&(u[h]=c.needsContext?v(h,this).index(s)>=0:v.find(h,this,null,[s]).length),u[h]&&f.push(c);f.length&&w.push({elem:s,matches:f})}d.length>m&&w.push({elem:this,matches:d.slice(m)});for(r=0;r<w.length&&!n.isPropagationStopped();r++){a=w[r],n.currentTarget=a.elem;for(i=0;i<a.matches.length&&!n.isImmediatePropagationStopped();i++){c=a.matches[i];if(y||!n.namespace&&!c.namespace||n.namespace_re&&n.namespace_re.test(c.namespace))n.data=c.data,n.handleObj=c,o=((v.event.special[c.origType]||{}).handle||c.handler).apply(a.elem,g),o!==t&&(n.result=o,o===!1&&(n.preventDefault(),n.stopPropagation()))}}return b.postDispatch&&b.postDispatch.call(this,n),n.result},props:"attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(e,t){return e.which==null&&(e.which=t.charCode!=null?t.charCode:t.keyCode),e}},mouseHooks:{props:"button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(e,n){var r,s,o,u=n.button,a=n.fromElement;return e.pageX==null&&n.clientX!=null&&(r=e.target.ownerDocument||i,s=r.documentElement,o=r.body,e.pageX=n.clientX+(s&&s.scrollLeft||o&&o.scrollLeft||0)-(s&&s.clientLeft||o&&o.clientLeft||0),e.pageY=n.clientY+(s&&s.scrollTop||o&&o.scrollTop||0)-(s&&s.clientTop||o&&o.clientTop||0)),!e.relatedTarget&&a&&(e.relatedTarget=a===e.target?n.toElement:a),!e.which&&u!==t&&(e.which=u&1?1:u&2?3:u&4?2:0),e}},fix:function(e){if(e[v.expando])return e;var t,n,r=e,s=v.event.fixHooks[e.type]||{},o=s.props?this.props.concat(s.props):this.props;e=v.Event(r);for(t=o.length;t;)n=o[--t],e[n]=r[n];return e.target||(e.target=r.srcElement||i),e.target.nodeType===3&&(e.target=e.target.parentNode),e.metaKey=!!e.metaKey,s.filter?s.filter(e,r):e},special:{load:{noBubble:!0},focus:{delegateType:"focusin"},blur:{delegateType:"focusout"},beforeunload:{setup:function(e,t,n){v.isWindow(this)&&(this.onbeforeunload=n)},teardown:function(e,t){this.onbeforeunload===t&&(this.onbeforeunload=null)}}},simulate:function(e,t,n,r){var i=v.extend(new v.Event,n,{type:e,isSimulated:!0,originalEvent:{}});r?v.event.trigger(i,null,t):v.event.dispatch.call(t,i),i.isDefaultPrevented()&&n.preventDefault()}},v.event.handle=v.event.dispatch,v.removeEvent=i.removeEventListener?function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n,!1)}:function(e,t,n){var r="on"+t;e.detachEvent&&(typeof e[r]=="undefined"&&(e[r]=null),e.detachEvent(r,n))},v.Event=function(e,t){if(!(this instanceof v.Event))return new v.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||e.returnValue===!1||e.getPreventDefault&&e.getPreventDefault()?tt:et):this.type=e,t&&v.extend(this,t),this.timeStamp=e&&e.timeStamp||v.now(),this[v.expando]=!0},v.Event.prototype={preventDefault:function(){this.isDefaultPrevented=tt;var e=this.originalEvent;if(!e)return;e.preventDefault?e.preventDefault():e.returnValue=!1},stopPropagation:function(){this.isPropagationStopped=tt;var e=this.originalEvent;if(!e)return;e.stopPropagation&&e.stopPropagation(),e.cancelBubble=!0},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=tt,this.stopPropagation()},isDefaultPrevented:et,isPropagationStopped:et,isImmediatePropagationStopped:et},v.each({mouseenter:"mouseover",mouseleave:"mouseout"},function(e,t){v.event.special[e]={delegateType:t,bindType:t,handle:function(e){var n,r=this,i=e.relatedTarget,s=e.handleObj,o=s.selector;if(!i||i!==r&&!v.contains(r,i))e.type=s.origType,n=s.handler.apply(this,arguments),e.type=t;return n}}}),v.support.submitBubbles||(v.event.special.submit={setup:function(){if(v.nodeName(this,"form"))return!1;v.event.add(this,"click._submit keypress._submit",function(e){var n=e.target,r=v.nodeName(n,"input")||v.nodeName(n,"button")?n.form:t;r&&!v._data(r,"_submit_attached")&&(v.event.add(r,"submit._submit",function(e){e._submit_bubble=!0}),v._data(r,"_submit_attached",!0))})},postDispatch:function(e){e._submit_bubble&&(delete e._submit_bubble,this.parentNode&&!e.isTrigger&&v.event.simulate("submit",this.parentNode,e,!0))},teardown:function(){if(v.nodeName(this,"form"))return!1;v.event.remove(this,"._submit")}}),v.support.changeBubbles||(v.event.special.change={setup:function(){if($.test(this.nodeName)){if(this.type==="checkbox"||this.type==="radio")v.event.add(this,"propertychange._change",function(e){e.originalEvent.propertyName==="checked"&&(this._just_changed=!0)}),v.event.add(this,"click._change",function(e){this._just_changed&&!e.isTrigger&&(this._just_changed=!1),v.event.simulate("change",this,e,!0)});return!1}v.event.add(this,"beforeactivate._change",function(e){var t=e.target;$.test(t.nodeName)&&!v._data(t,"_change_attached")&&(v.event.add(t,"change._change",function(e){this.parentNode&&!e.isSimulated&&!e.isTrigger&&v.event.simulate("change",this.parentNode,e,!0)}),v._data(t,"_change_attached",!0))})},handle:function(e){var t=e.target;if(this!==t||e.isSimulated||e.isTrigger||t.type!=="radio"&&t.type!=="checkbox")return e.handleObj.handler.apply(this,arguments)},teardown:function(){return v.event.remove(this,"._change"),!$.test(this.nodeName)}}),v.support.focusinBubbles||v.each({focus:"focusin",blur:"focusout"},function(e,t){var n=0,r=function(e){v.event.simulate(t,e.target,v.event.fix(e),!0)};v.event.special[t]={setup:function(){n++===0&&i.addEventListener(e,r,!0)},teardown:function(){--n===0&&i.removeEventListener(e,r,!0)}}}),v.fn.extend({on:function(e,n,r,i,s){var o,u;if(typeof e=="object"){typeof n!="string"&&(r=r||n,n=t);for(u in e)this.on(u,n,r,e[u],s);return this}r==null&&i==null?(i=n,r=n=t):i==null&&(typeof n=="string"?(i=r,r=t):(i=r,r=n,n=t));if(i===!1)i=et;else if(!i)return this;return s===1&&(o=i,i=function(e){return v().off(e),o.apply(this,arguments)},i.guid=o.guid||(o.guid=v.guid++)),this.each(function(){v.event.add(this,e,i,r,n)})},one:function(e,t,n,r){return this.on(e,t,n,r,1)},off:function(e,n,r){var i,s;if(e&&e.preventDefault&&e.handleObj)return i=e.handleObj,v(e.delegateTarget).off(i.namespace?i.origType+"."+i.namespace:i.origType,i.selector,i.handler),this;if(typeof e=="object"){for(s in e)this.off(s,n,e[s]);return this}if(n===!1||typeof n=="function")r=n,n=t;return r===!1&&(r=et),this.each(function(){v.event.remove(this,e,r,n)})},bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},live:function(e,t,n){return v(this.context).on(e,this.selector,t,n),this},die:function(e,t){return v(this.context).off(e,this.selector||"**",t),this},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return arguments.length===1?this.off(e,"**"):this.off(t,e||"**",n)},trigger:function(e,t){return this.each(function(){v.event.trigger(e,t,this)})},triggerHandler:function(e,t){if(this[0])return v.event.trigger(e,t,this[0],!0)},toggle:function(e){var t=arguments,n=e.guid||v.guid++,r=0,i=function(n){var i=(v._data(this,"lastToggle"+e.guid)||0)%r;return v._data(this,"lastToggle"+e.guid,i+1),n.preventDefault(),t[i].apply(this,arguments)||!1};i.guid=n;while(r<t.length)t[r++].guid=n;return this.click(i)},hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),v.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(e,t){v.fn[t]=function(e,n){return n==null&&(n=e,e=null),arguments.length>0?this.on(t,null,e,n):this.trigger(t)},Q.test(t)&&(v.event.fixHooks[t]=v.event.keyHooks),G.test(t)&&(v.event.fixHooks[t]=v.event.mouseHooks)}),function(e,t){function nt(e,t,n,r){n=n||[],t=t||g;var i,s,a,f,l=t.nodeType;if(!e||typeof e!="string")return n;if(l!==1&&l!==9)return[];a=o(t);if(!a&&!r)if(i=R.exec(e))if(f=i[1]){if(l===9){s=t.getElementById(f);if(!s||!s.parentNode)return n;if(s.id===f)return n.push(s),n}else if(t.ownerDocument&&(s=t.ownerDocument.getElementById(f))&&u(t,s)&&s.id===f)return n.push(s),n}else{if(i[2])return S.apply(n,x.call(t.getElementsByTagName(e),0)),n;if((f=i[3])&&Z&&t.getElementsByClassName)return S.apply(n,x.call(t.getElementsByClassName(f),0)),n}return vt(e.replace(j,"$1"),t,n,r,a)}function rt(e){return function(t){var n=t.nodeName.toLowerCase();return n==="input"&&t.type===e}}function it(e){return function(t){var n=t.nodeName.toLowerCase();return(n==="input"||n==="button")&&t.type===e}}function st(e){return N(function(t){return t=+t,N(function(n,r){var i,s=e([],n.length,t),o=s.length;while(o--)n[i=s[o]]&&(n[i]=!(r[i]=n[i]))})})}function ot(e,t,n){if(e===t)return n;var r=e.nextSibling;while(r){if(r===t)return-1;r=r.nextSibling}return 1}function ut(e,t){var n,r,s,o,u,a,f,l=L[d][e+" "];if(l)return t?0:l.slice(0);u=e,a=[],f=i.preFilter;while(u){if(!n||(r=F.exec(u)))r&&(u=u.slice(r[0].length)||u),a.push(s=[]);n=!1;if(r=I.exec(u))s.push(n=new m(r.shift())),u=u.slice(n.length),n.type=r[0].replace(j," ");for(o in i.filter)(r=J[o].exec(u))&&(!f[o]||(r=f[o](r)))&&(s.push(n=new m(r.shift())),u=u.slice(n.length),n.type=o,n.matches=r);if(!n)break}return t?u.length:u?nt.error(e):L(e,a).slice(0)}function at(e,t,r){var i=t.dir,s=r&&t.dir==="parentNode",o=w++;return t.first?function(t,n,r){while(t=t[i])if(s||t.nodeType===1)return e(t,n,r)}:function(t,r,u){if(!u){var a,f=b+" "+o+" ",l=f+n;while(t=t[i])if(s||t.nodeType===1){if((a=t[d])===l)return t.sizset;if(typeof a=="string"&&a.indexOf(f)===0){if(t.sizset)return t}else{t[d]=l;if(e(t,r,u))return t.sizset=!0,t;t.sizset=!1}}}else while(t=t[i])if(s||t.nodeType===1)if(e(t,r,u))return t}}function ft(e){return e.length>1?function(t,n,r){var i=e.length;while(i--)if(!e[i](t,n,r))return!1;return!0}:e[0]}function lt(e,t,n,r,i){var s,o=[],u=0,a=e.length,f=t!=null;for(;u<a;u++)if(s=e[u])if(!n||n(s,r,i))o.push(s),f&&t.push(u);return o}function ct(e,t,n,r,i,s){return r&&!r[d]&&(r=ct(r)),i&&!i[d]&&(i=ct(i,s)),N(function(s,o,u,a){var f,l,c,h=[],p=[],d=o.length,v=s||dt(t||"*",u.nodeType?[u]:u,[]),m=e&&(s||!t)?lt(v,h,e,u,a):v,g=n?i||(s?e:d||r)?[]:o:m;n&&n(m,g,u,a);if(r){f=lt(g,p),r(f,[],u,a),l=f.length;while(l--)if(c=f[l])g[p[l]]=!(m[p[l]]=c)}if(s){if(i||e){if(i){f=[],l=g.length;while(l--)(c=g[l])&&f.push(m[l]=c);i(null,g=[],f,a)}l=g.length;while(l--)(c=g[l])&&(f=i?T.call(s,c):h[l])>-1&&(s[f]=!(o[f]=c))}}else g=lt(g===o?g.splice(d,g.length):g),i?i(null,o,g,a):S.apply(o,g)})}function ht(e){var t,n,r,s=e.length,o=i.relative[e[0].type],u=o||i.relative[" "],a=o?1:0,f=at(function(e){return e===t},u,!0),l=at(function(e){return T.call(t,e)>-1},u,!0),h=[function(e,n,r){return!o&&(r||n!==c)||((t=n).nodeType?f(e,n,r):l(e,n,r))}];for(;a<s;a++)if(n=i.relative[e[a].type])h=[at(ft(h),n)];else{n=i.filter[e[a].type].apply(null,e[a].matches);if(n[d]){r=++a;for(;r<s;r++)if(i.relative[e[r].type])break;return ct(a>1&&ft(h),a>1&&e.slice(0,a-1).join("").replace(j,"$1"),n,a<r&&ht(e.slice(a,r)),r<s&&ht(e=e.slice(r)),r<s&&e.join(""))}h.push(n)}return ft(h)}function pt(e,t){var r=t.length>0,s=e.length>0,o=function(u,a,f,l,h){var p,d,v,m=[],y=0,w="0",x=u&&[],T=h!=null,N=c,C=u||s&&i.find.TAG("*",h&&a.parentNode||a),k=b+=N==null?1:Math.E;T&&(c=a!==g&&a,n=o.el);for(;(p=C[w])!=null;w++){if(s&&p){for(d=0;v=e[d];d++)if(v(p,a,f)){l.push(p);break}T&&(b=k,n=++o.el)}r&&((p=!v&&p)&&y--,u&&x.push(p))}y+=w;if(r&&w!==y){for(d=0;v=t[d];d++)v(x,m,a,f);if(u){if(y>0)while(w--)!x[w]&&!m[w]&&(m[w]=E.call(l));m=lt(m)}S.apply(l,m),T&&!u&&m.length>0&&y+t.length>1&&nt.uniqueSort(l)}return T&&(b=k,c=N),x};return o.el=0,r?N(o):o}function dt(e,t,n){var r=0,i=t.length;for(;r<i;r++)nt(e,t[r],n);return n}function vt(e,t,n,r,s){var o,u,f,l,c,h=ut(e),p=h.length;if(!r&&h.length===1){u=h[0]=h[0].slice(0);if(u.length>2&&(f=u[0]).type==="ID"&&t.nodeType===9&&!s&&i.relative[u[1].type]){t=i.find.ID(f.matches[0].replace($,""),t,s)[0];if(!t)return n;e=e.slice(u.shift().length)}for(o=J.POS.test(e)?-1:u.length-1;o>=0;o--){f=u[o];if(i.relative[l=f.type])break;if(c=i.find[l])if(r=c(f.matches[0].replace($,""),z.test(u[0].type)&&t.parentNode||t,s)){u.splice(o,1),e=r.length&&u.join("");if(!e)return S.apply(n,x.call(r,0)),n;break}}}return a(e,h)(r,t,s,n,z.test(e)),n}function mt(){}var n,r,i,s,o,u,a,f,l,c,h=!0,p="undefined",d=("sizcache"+Math.random()).replace(".",""),m=String,g=e.document,y=g.documentElement,b=0,w=0,E=[].pop,S=[].push,x=[].slice,T=[].indexOf||function(e){var t=0,n=this.length;for(;t<n;t++)if(this[t]===e)return t;return-1},N=function(e,t){return e[d]=t==null||t,e},C=function(){var e={},t=[];return N(function(n,r){return t.push(n)>i.cacheLength&&delete e[t.shift()],e[n+" "]=r},e)},k=C(),L=C(),A=C(),O="[\\x20\\t\\r\\n\\f]",M="(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+",_=M.replace("w","w#"),D="([*^$|!~]?=)",P="\\["+O+"*("+M+")"+O+"*(?:"+D+O+"*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|("+_+")|)|)"+O+"*\\]",H=":("+M+")(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|([^()[\\]]*|(?:(?:"+P+")|[^:]|\\\\.)*|.*))\\)|)",B=":(even|odd|eq|gt|lt|nth|first|last)(?:\\("+O+"*((?:-\\d)?\\d*)"+O+"*\\)|)(?=[^-]|$)",j=new RegExp("^"+O+"+|((?:^|[^\\\\])(?:\\\\.)*)"+O+"+$","g"),F=new RegExp("^"+O+"*,"+O+"*"),I=new RegExp("^"+O+"*([\\x20\\t\\r\\n\\f>+~])"+O+"*"),q=new RegExp(H),R=/^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,U=/^:not/,z=/[\x20\t\r\n\f]*[+~]/,W=/:not\($/,X=/h\d/i,V=/input|select|textarea|button/i,$=/\\(?!\\)/g,J={ID:new RegExp("^#("+M+")"),CLASS:new RegExp("^\\.("+M+")"),NAME:new RegExp("^\\[name=['\"]?("+M+")['\"]?\\]"),TAG:new RegExp("^("+M.replace("w","w*")+")"),ATTR:new RegExp("^"+P),PSEUDO:new RegExp("^"+H),POS:new RegExp(B,"i"),CHILD:new RegExp("^:(only|nth|first|last)-child(?:\\("+O+"*(even|odd|(([+-]|)(\\d*)n|)"+O+"*(?:([+-]|)"+O+"*(\\d+)|))"+O+"*\\)|)","i"),needsContext:new RegExp("^"+O+"*[>+~]|"+B,"i")},K=function(e){var t=g.createElement("div");try{return e(t)}catch(n){return!1}finally{t=null}},Q=K(function(e){return e.appendChild(g.createComment("")),!e.getElementsByTagName("*").length}),G=K(function(e){return e.innerHTML="<a href='#'></a>",e.firstChild&&typeof e.firstChild.getAttribute!==p&&e.firstChild.getAttribute("href")==="#"}),Y=K(function(e){e.innerHTML="<select></select>";var t=typeof e.lastChild.getAttribute("multiple");return t!=="boolean"&&t!=="string"}),Z=K(function(e){return e.innerHTML="<div class='hidden e'></div><div class='hidden'></div>",!e.getElementsByClassName||!e.getElementsByClassName("e").length?!1:(e.lastChild.className="e",e.getElementsByClassName("e").length===2)}),et=K(function(e){e.id=d+0,e.innerHTML="<a name='"+d+"'></a><div name='"+d+"'></div>",y.insertBefore(e,y.firstChild);var t=g.getElementsByName&&g.getElementsByName(d).length===2+g.getElementsByName(d+0).length;return r=!g.getElementById(d),y.removeChild(e),t});try{x.call(y.childNodes,0)[0].nodeType}catch(tt){x=function(e){var t,n=[];for(;t=this[e];e++)n.push(t);return n}}nt.matches=function(e,t){return nt(e,null,null,t)},nt.matchesSelector=function(e,t){return nt(t,null,null,[e]).length>0},s=nt.getText=function(e){var t,n="",r=0,i=e.nodeType;if(i){if(i===1||i===9||i===11){if(typeof e.textContent=="string")return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=s(e)}else if(i===3||i===4)return e.nodeValue}else for(;t=e[r];r++)n+=s(t);return n},o=nt.isXML=function(e){var t=e&&(e.ownerDocument||e).documentElement;return t?t.nodeName!=="HTML":!1},u=nt.contains=y.contains?function(e,t){var n=e.nodeType===9?e.documentElement:e,r=t&&t.parentNode;return e===r||!!(r&&r.nodeType===1&&n.contains&&n.contains(r))}:y.compareDocumentPosition?function(e,t){return t&&!!(e.compareDocumentPosition(t)&16)}:function(e,t){while(t=t.parentNode)if(t===e)return!0;return!1},nt.attr=function(e,t){var n,r=o(e);return r||(t=t.toLowerCase()),(n=i.attrHandle[t])?n(e):r||Y?e.getAttribute(t):(n=e.getAttributeNode(t),n?typeof e[t]=="boolean"?e[t]?t:null:n.specified?n.value:null:null)},i=nt.selectors={cacheLength:50,createPseudo:N,match:J,attrHandle:G?{}:{href:function(e){return e.getAttribute("href",2)},type:function(e){return e.getAttribute("type")}},find:{ID:r?function(e,t,n){if(typeof t.getElementById!==p&&!n){var r=t.getElementById(e);return r&&r.parentNode?[r]:[]}}:function(e,n,r){if(typeof n.getElementById!==p&&!r){var i=n.getElementById(e);return i?i.id===e||typeof i.getAttributeNode!==p&&i.getAttributeNode("id").value===e?[i]:t:[]}},TAG:Q?function(e,t){if(typeof t.getElementsByTagName!==p)return t.getElementsByTagName(e)}:function(e,t){var n=t.getElementsByTagName(e);if(e==="*"){var r,i=[],s=0;for(;r=n[s];s++)r.nodeType===1&&i.push(r);return i}return n},NAME:et&&function(e,t){if(typeof t.getElementsByName!==p)return t.getElementsByName(name)},CLASS:Z&&function(e,t,n){if(typeof t.getElementsByClassName!==p&&!n)return t.getElementsByClassName(e)}},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace($,""),e[3]=(e[4]||e[5]||"").replace($,""),e[2]==="~="&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),e[1]==="nth"?(e[2]||nt.error(e[0]),e[3]=+(e[3]?e[4]+(e[5]||1):2*(e[2]==="even"||e[2]==="odd")),e[4]=+(e[6]+e[7]||e[2]==="odd")):e[2]&&nt.error(e[0]),e},PSEUDO:function(e){var t,n;if(J.CHILD.test(e[0]))return null;if(e[3])e[2]=e[3];else if(t=e[4])q.test(t)&&(n=ut(t,!0))&&(n=t.indexOf(")",t.length-n)-t.length)&&(t=t.slice(0,n),e[0]=e[0].slice(0,n)),e[2]=t;return e.slice(0,3)}},filter:{ID:r?function(e){return e=e.replace($,""),function(t){return t.getAttribute("id")===e}}:function(e){return e=e.replace($,""),function(t){var n=typeof t.getAttributeNode!==p&&t.getAttributeNode("id");return n&&n.value===e}},TAG:function(e){return e==="*"?function(){return!0}:(e=e.replace($,"").toLowerCase(),function(t){return t.nodeName&&t.nodeName.toLowerCase()===e})},CLASS:function(e){var t=k[d][e+" "];return t||(t=new RegExp("(^|"+O+")"+e+"("+O+"|$)"))&&k(e,function(e){return t.test(e.className||typeof e.getAttribute!==p&&e.getAttribute("class")||"")})},ATTR:function(e,t,n){return function(r,i){var s=nt.attr(r,e);return s==null?t==="!=":t?(s+="",t==="="?s===n:t==="!="?s!==n:t==="^="?n&&s.indexOf(n)===0:t==="*="?n&&s.indexOf(n)>-1:t==="$="?n&&s.substr(s.length-n.length)===n:t==="~="?(" "+s+" ").indexOf(n)>-1:t==="|="?s===n||s.substr(0,n.length+1)===n+"-":!1):!0}},CHILD:function(e,t,n,r){return e==="nth"?function(e){var t,i,s=e.parentNode;if(n===1&&r===0)return!0;if(s){i=0;for(t=s.firstChild;t;t=t.nextSibling)if(t.nodeType===1){i++;if(e===t)break}}return i-=r,i===n||i%n===0&&i/n>=0}:function(t){var n=t;switch(e){case"only":case"first":while(n=n.previousSibling)if(n.nodeType===1)return!1;if(e==="first")return!0;n=t;case"last":while(n=n.nextSibling)if(n.nodeType===1)return!1;return!0}}},PSEUDO:function(e,t){var n,r=i.pseudos[e]||i.setFilters[e.toLowerCase()]||nt.error("unsupported pseudo: "+e);return r[d]?r(t):r.length>1?(n=[e,e,"",t],i.setFilters.hasOwnProperty(e.toLowerCase())?N(function(e,n){var i,s=r(e,t),o=s.length;while(o--)i=T.call(e,s[o]),e[i]=!(n[i]=s[o])}):function(e){return r(e,0,n)}):r}},pseudos:{not:N(function(e){var t=[],n=[],r=a(e.replace(j,"$1"));return r[d]?N(function(e,t,n,i){var s,o=r(e,null,i,[]),u=e.length;while(u--)if(s=o[u])e[u]=!(t[u]=s)}):function(e,i,s){return t[0]=e,r(t,null,s,n),!n.pop()}}),has:N(function(e){return function(t){return nt(e,t).length>0}}),contains:N(function(e){return function(t){return(t.textContent||t.innerText||s(t)).indexOf(e)>-1}}),enabled:function(e){return e.disabled===!1},disabled:function(e){return e.disabled===!0},checked:function(e){var t=e.nodeName.toLowerCase();return t==="input"&&!!e.checked||t==="option"&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,e.selected===!0},parent:function(e){return!i.pseudos.empty(e)},empty:function(e){var t;e=e.firstChild;while(e){if(e.nodeName>"@"||(t=e.nodeType)===3||t===4)return!1;e=e.nextSibling}return!0},header:function(e){return X.test(e.nodeName)},text:function(e){var t,n;return e.nodeName.toLowerCase()==="input"&&(t=e.type)==="text"&&((n=e.getAttribute("type"))==null||n.toLowerCase()===t)},radio:rt("radio"),checkbox:rt("checkbox"),file:rt("file"),password:rt("password"),image:rt("image"),submit:it("submit"),reset:it("reset"),button:function(e){var t=e.nodeName.toLowerCase();return t==="input"&&e.type==="button"||t==="button"},input:function(e){return V.test(e.nodeName)},focus:function(e){var t=e.ownerDocument;return e===t.activeElement&&(!t.hasFocus||t.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},active:function(e){return e===e.ownerDocument.activeElement},first:st(function(){return[0]}),last:st(function(e,t){return[t-1]}),eq:st(function(e,t,n){return[n<0?n+t:n]}),even:st(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:st(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:st(function(e,t,n){for(var r=n<0?n+t:n;--r>=0;)e.push(r);return e}),gt:st(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}},f=y.compareDocumentPosition?function(e,t){return e===t?(l=!0,0):(!e.compareDocumentPosition||!t.compareDocumentPosition?e.compareDocumentPosition:e.compareDocumentPosition(t)&4)?-1:1}:function(e,t){if(e===t)return l=!0,0;if(e.sourceIndex&&t.sourceIndex)return e.sourceIndex-t.sourceIndex;var n,r,i=[],s=[],o=e.parentNode,u=t.parentNode,a=o;if(o===u)return ot(e,t);if(!o)return-1;if(!u)return 1;while(a)i.unshift(a),a=a.parentNode;a=u;while(a)s.unshift(a),a=a.parentNode;n=i.length,r=s.length;for(var f=0;f<n&&f<r;f++)if(i[f]!==s[f])return ot(i[f],s[f]);return f===n?ot(e,s[f],-1):ot(i[f],t,1)},[0,0].sort(f),h=!l,nt.uniqueSort=function(e){var t,n=[],r=1,i=0;l=h,e.sort(f);if(l){for(;t=e[r];r++)t===e[r-1]&&(i=n.push(r));while(i--)e.splice(n[i],1)}return e},nt.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},a=nt.compile=function(e,t){var n,r=[],i=[],s=A[d][e+" "];if(!s){t||(t=ut(e)),n=t.length;while(n--)s=ht(t[n]),s[d]?r.push(s):i.push(s);s=A(e,pt(i,r))}return s},g.querySelectorAll&&function(){var e,t=vt,n=/'|\\/g,r=/\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,i=[":focus"],s=[":active"],u=y.matchesSelector||y.mozMatchesSelector||y.webkitMatchesSelector||y.oMatchesSelector||y.msMatchesSelector;K(function(e){e.innerHTML="<select><option selected=''></option></select>",e.querySelectorAll("[selected]").length||i.push("\\["+O+"*(?:checked|disabled|ismap|multiple|readonly|selected|value)"),e.querySelectorAll(":checked").length||i.push(":checked")}),K(function(e){e.innerHTML="<p test=''></p>",e.querySelectorAll("[test^='']").length&&i.push("[*^$]="+O+"*(?:\"\"|'')"),e.innerHTML="<input type='hidden'/>",e.querySelectorAll(":enabled").length||i.push(":enabled",":disabled")}),i=new RegExp(i.join("|")),vt=function(e,r,s,o,u){if(!o&&!u&&!i.test(e)){var a,f,l=!0,c=d,h=r,p=r.nodeType===9&&e;if(r.nodeType===1&&r.nodeName.toLowerCase()!=="object"){a=ut(e),(l=r.getAttribute("id"))?c=l.replace(n,"\\$&"):r.setAttribute("id",c),c="[id='"+c+"'] ",f=a.length;while(f--)a[f]=c+a[f].join("");h=z.test(e)&&r.parentNode||r,p=a.join(",")}if(p)try{return S.apply(s,x.call(h.querySelectorAll(p),0)),s}catch(v){}finally{l||r.removeAttribute("id")}}return t(e,r,s,o,u)},u&&(K(function(t){e=u.call(t,"div");try{u.call(t,"[test!='']:sizzle"),s.push("!=",H)}catch(n){}}),s=new RegExp(s.join("|")),nt.matchesSelector=function(t,n){n=n.replace(r,"='$1']");if(!o(t)&&!s.test(n)&&!i.test(n))try{var a=u.call(t,n);if(a||e||t.document&&t.document.nodeType!==11)return a}catch(f){}return nt(n,null,null,[t]).length>0})}(),i.pseudos.nth=i.pseudos.eq,i.filters=mt.prototype=i.pseudos,i.setFilters=new mt,nt.attr=v.attr,v.find=nt,v.expr=nt.selectors,v.expr[":"]=v.expr.pseudos,v.unique=nt.uniqueSort,v.text=nt.getText,v.isXMLDoc=nt.isXML,v.contains=nt.contains}(e);var nt=/Until$/,rt=/^(?:parents|prev(?:Until|All))/,it=/^.[^:#\[\.,]*$/,st=v.expr.match.needsContext,ot={children:!0,contents:!0,next:!0,prev:!0};v.fn.extend({find:function(e){var t,n,r,i,s,o,u=this;if(typeof e!="string")return v(e).filter(function(){for(t=0,n=u.length;t<n;t++)if(v.contains(u[t],this))return!0});o=this.pushStack("","find",e);for(t=0,n=this.length;t<n;t++){r=o.length,v.find(e,this[t],o);if(t>0)for(i=r;i<o.length;i++)for(s=0;s<r;s++)if(o[s]===o[i]){o.splice(i--,1);break}}return o},has:function(e){var t,n=v(e,this),r=n.length;return this.filter(function(){for(t=0;t<r;t++)if(v.contains(this,n[t]))return!0})},not:function(e){return this.pushStack(ft(this,e,!1),"not",e)},filter:function(e){return this.pushStack(ft(this,e,!0),"filter",e)},is:function(e){return!!e&&(typeof e=="string"?st.test(e)?v(e,this.context).index(this[0])>=0:v.filter(e,this).length>0:this.filter(e).length>0)},closest:function(e,t){var n,r=0,i=this.length,s=[],o=st.test(e)||typeof e!="string"?v(e,t||this.context):0;for(;r<i;r++){n=this[r];while(n&&n.ownerDocument&&n!==t&&n.nodeType!==11){if(o?o.index(n)>-1:v.find.matchesSelector(n,e)){s.push(n);break}n=n.parentNode}}return s=s.length>1?v.unique(s):s,this.pushStack(s,"closest",e)},index:function(e){return e?typeof e=="string"?v.inArray(this[0],v(e)):v.inArray(e.jquery?e[0]:e,this):this[0]&&this[0].parentNode?this.prevAll().length:-1},add:function(e,t){var n=typeof e=="string"?v(e,t):v.makeArray(e&&e.nodeType?[e]:e),r=v.merge(this.get(),n);return this.pushStack(ut(n[0])||ut(r[0])?r:v.unique(r))},addBack:function(e){return this.add(e==null?this.prevObject:this.prevObject.filter(e))}}),v.fn.andSelf=v.fn.addBack,v.each({parent:function(e){var t=e.parentNode;return t&&t.nodeType!==11?t:null},parents:function(e){return v.dir(e,"parentNode")},parentsUntil:function(e,t,n){return v.dir(e,"parentNode",n)},next:function(e){return at(e,"nextSibling")},prev:function(e){return at(e,"previousSibling")},nextAll:function(e){return v.dir(e,"nextSibling")},prevAll:function(e){return v.dir(e,"previousSibling")},nextUntil:function(e,t,n){return v.dir(e,"nextSibling",n)},prevUntil:function(e,t,n){return v.dir(e,"previousSibling",n)},siblings:function(e){return v.sibling((e.parentNode||{}).firstChild,e)},children:function(e){return v.sibling(e.firstChild)},contents:function(e){return v.nodeName(e,"iframe")?e.contentDocument||e.contentWindow.document:v.merge([],e.childNodes)}},function(e,t){v.fn[e]=function(n,r){var i=v.map(this,t,n);return nt.test(e)||(r=n),r&&typeof r=="string"&&(i=v.filter(r,i)),i=this.length>1&&!ot[e]?v.unique(i):i,this.length>1&&rt.test(e)&&(i=i.reverse()),this.pushStack(i,e,l.call(arguments).join(","))}}),v.extend({filter:function(e,t,n){return n&&(e=":not("+e+")"),t.length===1?v.find.matchesSelector(t[0],e)?[t[0]]:[]:v.find.matches(e,t)},dir:function(e,n,r){var i=[],s=e[n];while(s&&s.nodeType!==9&&(r===t||s.nodeType!==1||!v(s).is(r)))s.nodeType===1&&i.push(s),s=s[n];return i},sibling:function(e,t){var n=[];for(;e;e=e.nextSibling)e.nodeType===1&&e!==t&&n.push(e);return n}});var ct="abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",ht=/ jQuery\d+="(?:null|\d+)"/g,pt=/^\s+/,dt=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,vt=/<([\w:]+)/,mt=/<tbody/i,gt=/<|&#?\w+;/,yt=/<(?:script|style|link)/i,bt=/<(?:script|object|embed|option|style)/i,wt=new RegExp("<(?:"+ct+")[\\s/>]","i"),Et=/^(?:checkbox|radio)$/,St=/checked\s*(?:[^=]|=\s*.checked.)/i,xt=/\/(java|ecma)script/i,Tt=/^\s*<!(?:\[CDATA\[|\-\-)|[\]\-]{2}>\s*$/g,Nt={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],area:[1,"<map>","</map>"],_default:[0,"",""]},Ct=lt(i),kt=Ct.appendChild(i.createElement("div"));Nt.optgroup=Nt.option,Nt.tbody=Nt.tfoot=Nt.colgroup=Nt.caption=Nt.thead,Nt.th=Nt.td,v.support.htmlSerialize||(Nt._default=[1,"X<div>","</div>"]),v.fn.extend({text:function(e){return v.access(this,function(e){return e===t?v.text(this):this.empty().append((this[0]&&this[0].ownerDocument||i).createTextNode(e))},null,e,arguments.length)},wrapAll:function(e){if(v.isFunction(e))return this.each(function(t){v(this).wrapAll(e.call(this,t))});if(this[0]){var t=v(e,this[0].ownerDocument).eq(0).clone(!0);this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstChild&&e.firstChild.nodeType===1)e=e.firstChild;return e}).append(this)}return this},wrapInner:function(e){return v.isFunction(e)?this.each(function(t){v(this).wrapInner(e.call(this,t))}):this.each(function(){var t=v(this),n=t.contents();n.length?n.wrapAll(e):t.append(e)})},wrap:function(e){var t=v.isFunction(e);return this.each(function(n){v(this).wrapAll(t?e.call(this,n):e)})},unwrap:function(){return this.parent().each(function(){v.nodeName(this,"body")||v(this).replaceWith(this.childNodes)}).end()},append:function(){return this.domManip(arguments,!0,function(e){(this.nodeType===1||this.nodeType===11)&&this.appendChild(e)})},prepend:function(){return this.domManip(arguments,!0,function(e){(this.nodeType===1||this.nodeType===11)&&this.insertBefore(e,this.firstChild)})},before:function(){if(!ut(this[0]))return this.domManip(arguments,!1,function(e){this.parentNode.insertBefore(e,this)});if(arguments.length){var e=v.clean(arguments);return this.pushStack(v.merge(e,this),"before",this.selector)}},after:function(){if(!ut(this[0]))return this.domManip(arguments,!1,function(e){this.parentNode.insertBefore(e,this.nextSibling)});if(arguments.length){var e=v.clean(arguments);return this.pushStack(v.merge(this,e),"after",this.selector)}},remove:function(e,t){var n,r=0;for(;(n=this[r])!=null;r++)if(!e||v.filter(e,[n]).length)!t&&n.nodeType===1&&(v.cleanData(n.getElementsByTagName("*")),v.cleanData([n])),n.parentNode&&n.parentNode.removeChild(n);return this},empty:function(){var e,t=0;for(;(e=this[t])!=null;t++){e.nodeType===1&&v.cleanData(e.getElementsByTagName("*"));while(e.firstChild)e.removeChild(e.firstChild)}return this},clone:function(e,t){return e=e==null?!1:e,t=t==null?e:t,this.map(function(){return v.clone(this,e,t)})},html:function(e){return v.access(this,function(e){var n=this[0]||{},r=0,i=this.length;if(e===t)return n.nodeType===1?n.innerHTML.replace(ht,""):t;if(typeof e=="string"&&!yt.test(e)&&(v.support.htmlSerialize||!wt.test(e))&&(v.support.leadingWhitespace||!pt.test(e))&&!Nt[(vt.exec(e)||["",""])[1].toLowerCase()]){e=e.replace(dt,"<$1></$2>");try{for(;r<i;r++)n=this[r]||{},n.nodeType===1&&(v.cleanData(n.getElementsByTagName("*")),n.innerHTML=e);n=0}catch(s){}}n&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(e){return ut(this[0])?this.length?this.pushStack(v(v.isFunction(e)?e():e),"replaceWith",e):this:v.isFunction(e)?this.each(function(t){var n=v(this),r=n.html();n.replaceWith(e.call(this,t,r))}):(typeof e!="string"&&(e=v(e).detach()),this.each(function(){var t=this.nextSibling,n=this.parentNode;v(this).remove(),t?v(t).before(e):v(n).append(e)}))},detach:function(e){return this.remove(e,!0)},domManip:function(e,n,r){e=[].concat.apply([],e);var i,s,o,u,a=0,f=e[0],l=[],c=this.length;if(!v.support.checkClone&&c>1&&typeof f=="string"&&St.test(f))return this.each(function(){v(this).domManip(e,n,r)});if(v.isFunction(f))return this.each(function(i){var s=v(this);e[0]=f.call(this,i,n?s.html():t),s.domManip(e,n,r)});if(this[0]){i=v.buildFragment(e,this,l),o=i.fragment,s=o.firstChild,o.childNodes.length===1&&(o=s);if(s){n=n&&v.nodeName(s,"tr");for(u=i.cacheable||c-1;a<c;a++)r.call(n&&v.nodeName(this[a],"table")?Lt(this[a],"tbody"):this[a],a===u?o:v.clone(o,!0,!0))}o=s=null,l.length&&v.each(l,function(e,t){t.src?v.ajax?v.ajax({url:t.src,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0}):v.error("no ajax"):v.globalEval((t.text||t.textContent||t.innerHTML||"").replace(Tt,"")),t.parentNode&&t.parentNode.removeChild(t)})}return this}}),v.buildFragment=function(e,n,r){var s,o,u,a=e[0];return n=n||i,n=!n.nodeType&&n[0]||n,n=n.ownerDocument||n,e.length===1&&typeof a=="string"&&a.length<512&&n===i&&a.charAt(0)==="<"&&!bt.test(a)&&(v.support.checkClone||!St.test(a))&&(v.support.html5Clone||!wt.test(a))&&(o=!0,s=v.fragments[a],u=s!==t),s||(s=n.createDocumentFragment(),v.clean(e,n,s,r),o&&(v.fragments[a]=u&&s)),{fragment:s,cacheable:o}},v.fragments={},v.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,t){v.fn[e]=function(n){var r,i=0,s=[],o=v(n),u=o.length,a=this.length===1&&this[0].parentNode;if((a==null||a&&a.nodeType===11&&a.childNodes.length===1)&&u===1)return o[t](this[0]),this;for(;i<u;i++)r=(i>0?this.clone(!0):this).get(),v(o[i])[t](r),s=s.concat(r);return this.pushStack(s,e,o.selector)}}),v.extend({clone:function(e,t,n){var r,i,s,o;v.support.html5Clone||v.isXMLDoc(e)||!wt.test("<"+e.nodeName+">")?o=e.cloneNode(!0):(kt.innerHTML=e.outerHTML,kt.removeChild(o=kt.firstChild));if((!v.support.noCloneEvent||!v.support.noCloneChecked)&&(e.nodeType===1||e.nodeType===11)&&!v.isXMLDoc(e)){Ot(e,o),r=Mt(e),i=Mt(o);for(s=0;r[s];++s)i[s]&&Ot(r[s],i[s])}if(t){At(e,o);if(n){r=Mt(e),i=Mt(o);for(s=0;r[s];++s)At(r[s],i[s])}}return r=i=null,o},clean:function(e,t,n,r){var s,o,u,a,f,l,c,h,p,d,m,g,y=t===i&&Ct,b=[];if(!t||typeof t.createDocumentFragment=="undefined")t=i;for(s=0;(u=e[s])!=null;s++){typeof u=="number"&&(u+="");if(!u)continue;if(typeof u=="string")if(!gt.test(u))u=t.createTextNode(u);else{y=y||lt(t),c=t.createElement("div"),y.appendChild(c),u=u.replace(dt,"<$1></$2>"),a=(vt.exec(u)||["",""])[1].toLowerCase(),f=Nt[a]||Nt._default,l=f[0],c.innerHTML=f[1]+u+f[2];while(l--)c=c.lastChild;if(!v.support.tbody){h=mt.test(u),p=a==="table"&&!h?c.firstChild&&c.firstChild.childNodes:f[1]==="<table>"&&!h?c.childNodes:[];for(o=p.length-1;o>=0;--o)v.nodeName(p[o],"tbody")&&!p[o].childNodes.length&&p[o].parentNode.removeChild(p[o])}!v.support.leadingWhitespace&&pt.test(u)&&c.insertBefore(t.createTextNode(pt.exec(u)[0]),c.firstChild),u=c.childNodes,c.parentNode.removeChild(c)}u.nodeType?b.push(u):v.merge(b,u)}c&&(u=c=y=null);if(!v.support.appendChecked)for(s=0;(u=b[s])!=null;s++)v.nodeName(u,"input")?_t(u):typeof u.getElementsByTagName!="undefined"&&v.grep(u.getElementsByTagName("input"),_t);if(n){m=function(e){if(!e.type||xt.test(e.type))return r?r.push(e.parentNode?e.parentNode.removeChild(e):e):n.appendChild(e)};for(s=0;(u=b[s])!=null;s++)if(!v.nodeName(u,"script")||!m(u))n.appendChild(u),typeof u.getElementsByTagName!="undefined"&&(g=v.grep(v.merge([],u.getElementsByTagName("script")),m),b.splice.apply(b,[s+1,0].concat(g)),s+=g.length)}return b},cleanData:function(e,t){var n,r,i,s,o=0,u=v.expando,a=v.cache,f=v.support.deleteExpando,l=v.event.special;for(;(i=e[o])!=null;o++)if(t||v.acceptData(i)){r=i[u],n=r&&a[r];if(n){if(n.events)for(s in n.events)l[s]?v.event.remove(i,s):v.removeEvent(i,s,n.handle);a[r]&&(delete a[r],f?delete i[u]:i.removeAttribute?i.removeAttribute(u):i[u]=null,v.deletedIds.push(r))}}}}),function(){var e,t;v.uaMatch=function(e){e=e.toLowerCase();var t=/(chrome)[ \/]([\w.]+)/.exec(e)||/(webkit)[ \/]([\w.]+)/.exec(e)||/(opera)(?:.*version|)[ \/]([\w.]+)/.exec(e)||/(msie) ([\w.]+)/.exec(e)||e.indexOf("compatible")<0&&/(mozilla)(?:.*? rv:([\w.]+)|)/.exec(e)||[];return{browser:t[1]||"",version:t[2]||"0"}},e=v.uaMatch(o.userAgent),t={},e.browser&&(t[e.browser]=!0,t.version=e.version),t.chrome?t.webkit=!0:t.webkit&&(t.safari=!0),v.browser=t,v.sub=function(){function e(t,n){return new e.fn.init(t,n)}v.extend(!0,e,this),e.superclass=this,e.fn=e.prototype=this(),e.fn.constructor=e,e.sub=this.sub,e.fn.init=function(r,i){return i&&i instanceof v&&!(i instanceof e)&&(i=e(i)),v.fn.init.call(this,r,i,t)},e.fn.init.prototype=e.fn;var t=e(i);return e}}();var Dt,Pt,Ht,Bt=/alpha\([^)]*\)/i,jt=/opacity=([^)]*)/,Ft=/^(top|right|bottom|left)$/,It=/^(none|table(?!-c[ea]).+)/,qt=/^margin/,Rt=new RegExp("^("+m+")(.*)$","i"),Ut=new RegExp("^("+m+")(?!px)[a-z%]+$","i"),zt=new RegExp("^([-+])=("+m+")","i"),Wt={BODY:"block"},Xt={position:"absolute",visibility:"hidden",display:"block"},Vt={letterSpacing:0,fontWeight:400},$t=["Top","Right","Bottom","Left"],Jt=["Webkit","O","Moz","ms"],Kt=v.fn.toggle;v.fn.extend({css:function(e,n){return v.access(this,function(e,n,r){return r!==t?v.style(e,n,r):v.css(e,n)},e,n,arguments.length>1)},show:function(){return Yt(this,!0)},hide:function(){return Yt(this)},toggle:function(e,t){var n=typeof e=="boolean";return v.isFunction(e)&&v.isFunction(t)?Kt.apply(this,arguments):this.each(function(){(n?e:Gt(this))?v(this).show():v(this).hide()})}}),v.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=Dt(e,"opacity");return n===""?"1":n}}}},cssNumber:{fillOpacity:!0,fontWeight:!0,lineHeight:!0,opacity:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":v.support.cssFloat?"cssFloat":"styleFloat"},style:function(e,n,r,i){if(!e||e.nodeType===3||e.nodeType===8||!e.style)return;var s,o,u,a=v.camelCase(n),f=e.style;n=v.cssProps[a]||(v.cssProps[a]=Qt(f,a)),u=v.cssHooks[n]||v.cssHooks[a];if(r===t)return u&&"get"in u&&(s=u.get(e,!1,i))!==t?s:f[n];o=typeof r,o==="string"&&(s=zt.exec(r))&&(r=(s[1]+1)*s[2]+parseFloat(v.css(e,n)),o="number");if(r==null||o==="number"&&isNaN(r))return;o==="number"&&!v.cssNumber[a]&&(r+="px");if(!u||!("set"in u)||(r=u.set(e,r,i))!==t)try{f[n]=r}catch(l){}},css:function(e,n,r,i){var s,o,u,a=v.camelCase(n);return n=v.cssProps[a]||(v.cssProps[a]=Qt(e.style,a)),u=v.cssHooks[n]||v.cssHooks[a],u&&"get"in u&&(s=u.get(e,!0,i)),s===t&&(s=Dt(e,n)),s==="normal"&&n in Vt&&(s=Vt[n]),r||i!==t?(o=parseFloat(s),r||v.isNumeric(o)?o||0:s):s},swap:function(e,t,n){var r,i,s={};for(i in t)s[i]=e.style[i],e.style[i]=t[i];r=n.call(e);for(i in t)e.style[i]=s[i];return r}}),e.getComputedStyle?Dt=function(t,n){var r,i,s,o,u=e.getComputedStyle(t,null),a=t.style;return u&&(r=u.getPropertyValue(n)||u[n],r===""&&!v.contains(t.ownerDocument,t)&&(r=v.style(t,n)),Ut.test(r)&&qt.test(n)&&(i=a.width,s=a.minWidth,o=a.maxWidth,a.minWidth=a.maxWidth=a.width=r,r=u.width,a.width=i,a.minWidth=s,a.maxWidth=o)),r}:i.documentElement.currentStyle&&(Dt=function(e,t){var n,r,i=e.currentStyle&&e.currentStyle[t],s=e.style;return i==null&&s&&s[t]&&(i=s[t]),Ut.test(i)&&!Ft.test(t)&&(n=s.left,r=e.runtimeStyle&&e.runtimeStyle.left,r&&(e.runtimeStyle.left=e.currentStyle.left),s.left=t==="fontSize"?"1em":i,i=s.pixelLeft+"px",s.left=n,r&&(e.runtimeStyle.left=r)),i===""?"auto":i}),v.each(["height","width"],function(e,t){v.cssHooks[t]={get:function(e,n,r){if(n)return e.offsetWidth===0&&It.test(Dt(e,"display"))?v.swap(e,Xt,function(){return tn(e,t,r)}):tn(e,t,r)},set:function(e,n,r){return Zt(e,n,r?en(e,t,r,v.support.boxSizing&&v.css(e,"boxSizing")==="border-box"):0)}}}),v.support.opacity||(v.cssHooks.opacity={get:function(e,t){return jt.test((t&&e.currentStyle?e.currentStyle.filter:e.style.filter)||"")?.01*parseFloat(RegExp.$1)+"":t?"1":""},set:function(e,t){var n=e.style,r=e.currentStyle,i=v.isNumeric(t)?"alpha(opacity="+t*100+")":"",s=r&&r.filter||n.filter||"";n.zoom=1;if(t>=1&&v.trim(s.replace(Bt,""))===""&&n.removeAttribute){n.removeAttribute("filter");if(r&&!r.filter)return}n.filter=Bt.test(s)?s.replace(Bt,i):s+" "+i}}),v(function(){v.support.reliableMarginRight||(v.cssHooks.marginRight={get:function(e,t){return v.swap(e,{display:"inline-block"},function(){if(t)return Dt(e,"marginRight")})}}),!v.support.pixelPosition&&v.fn.position&&v.each(["top","left"],function(e,t){v.cssHooks[t]={get:function(e,n){if(n){var r=Dt(e,t);return Ut.test(r)?v(e).position()[t]+"px":r}}}})}),v.expr&&v.expr.filters&&(v.expr.filters.hidden=function(e){return e.offsetWidth===0&&e.offsetHeight===0||!v.support.reliableHiddenOffsets&&(e.style&&e.style.display||Dt(e,"display"))==="none"},v.expr.filters.visible=function(e){return!v.expr.filters.hidden(e)}),v.each({margin:"",padding:"",border:"Width"},function(e,t){v.cssHooks[e+t]={expand:function(n){var r,i=typeof n=="string"?n.split(" "):[n],s={};for(r=0;r<4;r++)s[e+$t[r]+t]=i[r]||i[r-2]||i[0];return s}},qt.test(e)||(v.cssHooks[e+t].set=Zt)});var rn=/%20/g,sn=/\[\]$/,on=/\r?\n/g,un=/^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,an=/^(?:select|textarea)/i;v.fn.extend({serialize:function(){return v.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?v.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||an.test(this.nodeName)||un.test(this.type))}).map(function(e,t){var n=v(this).val();return n==null?null:v.isArray(n)?v.map(n,function(e,n){return{name:t.name,value:e.replace(on,"\r\n")}}):{name:t.name,value:n.replace(on,"\r\n")}}).get()}}),v.param=function(e,n){var r,i=[],s=function(e,t){t=v.isFunction(t)?t():t==null?"":t,i[i.length]=encodeURIComponent(e)+"="+encodeURIComponent(t)};n===t&&(n=v.ajaxSettings&&v.ajaxSettings.traditional);if(v.isArray(e)||e.jquery&&!v.isPlainObject(e))v.each(e,function(){s(this.name,this.value)});else for(r in e)fn(r,e[r],n,s);return i.join("&").replace(rn,"+")};var ln,cn,hn=/#.*$/,pn=/^(.*?):[ \t]*([^\r\n]*)\r?$/mg,dn=/^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,vn=/^(?:GET|HEAD)$/,mn=/^\/\//,gn=/\?/,yn=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,bn=/([?&])_=[^&]*/,wn=/^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,En=v.fn.load,Sn={},xn={},Tn=["*/"]+["*"];try{cn=s.href}catch(Nn){cn=i.createElement("a"),cn.href="",cn=cn.href}ln=wn.exec(cn.toLowerCase())||[],v.fn.load=function(e,n,r){if(typeof e!="string"&&En)return En.apply(this,arguments);if(!this.length)return this;var i,s,o,u=this,a=e.indexOf(" ");return a>=0&&(i=e.slice(a,e.length),e=e.slice(0,a)),v.isFunction(n)?(r=n,n=t):n&&typeof n=="object"&&(s="POST"),v.ajax({url:e,type:s,dataType:"html",data:n,complete:function(e,t){r&&u.each(r,o||[e.responseText,t,e])}}).done(function(e){o=arguments,u.html(i?v("<div>").append(e.replace(yn,"")).find(i):e)}),this},v.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),function(e,t){v.fn[t]=function(e){return this.on(t,e)}}),v.each(["get","post"],function(e,n){v[n]=function(e,r,i,s){return v.isFunction(r)&&(s=s||i,i=r,r=t),v.ajax({type:n,url:e,data:r,success:i,dataType:s})}}),v.extend({getScript:function(e,n){return v.get(e,t,n,"script")},getJSON:function(e,t,n){return v.get(e,t,n,"json")},ajaxSetup:function(e,t){return t?Ln(e,v.ajaxSettings):(t=e,e=v.ajaxSettings),Ln(e,t),e},ajaxSettings:{url:cn,isLocal:dn.test(ln[1]),global:!0,type:"GET",contentType:"application/x-www-form-urlencoded; charset=UTF-8",processData:!0,async:!0,accepts:{xml:"application/xml, text/xml",html:"text/html",text:"text/plain",json:"application/json, text/javascript","*":Tn},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText"},converters:{"* text":e.String,"text html":!0,"text json":v.parseJSON,"text xml":v.parseXML},flatOptions:{context:!0,url:!0}},ajaxPrefilter:Cn(Sn),ajaxTransport:Cn(xn),ajax:function(e,n){function T(e,n,s,a){var l,y,b,w,S,T=n;if(E===2)return;E=2,u&&clearTimeout(u),o=t,i=a||"",x.readyState=e>0?4:0,s&&(w=An(c,x,s));if(e>=200&&e<300||e===304)c.ifModified&&(S=x.getResponseHeader("Last-Modified"),S&&(v.lastModified[r]=S),S=x.getResponseHeader("Etag"),S&&(v.etag[r]=S)),e===304?(T="notmodified",l=!0):(l=On(c,w),T=l.state,y=l.data,b=l.error,l=!b);else{b=T;if(!T||e)T="error",e<0&&(e=0)}x.status=e,x.statusText=(n||T)+"",l?d.resolveWith(h,[y,T,x]):d.rejectWith(h,[x,T,b]),x.statusCode(g),g=t,f&&p.trigger("ajax"+(l?"Success":"Error"),[x,c,l?y:b]),m.fireWith(h,[x,T]),f&&(p.trigger("ajaxComplete",[x,c]),--v.active||v.event.trigger("ajaxStop"))}typeof e=="object"&&(n=e,e=t),n=n||{};var r,i,s,o,u,a,f,l,c=v.ajaxSetup({},n),h=c.context||c,p=h!==c&&(h.nodeType||h instanceof v)?v(h):v.event,d=v.Deferred(),m=v.Callbacks("once memory"),g=c.statusCode||{},b={},w={},E=0,S="canceled",x={readyState:0,setRequestHeader:function(e,t){if(!E){var n=e.toLowerCase();e=w[n]=w[n]||e,b[e]=t}return this},getAllResponseHeaders:function(){return E===2?i:null},getResponseHeader:function(e){var n;if(E===2){if(!s){s={};while(n=pn.exec(i))s[n[1].toLowerCase()]=n[2]}n=s[e.toLowerCase()]}return n===t?null:n},overrideMimeType:function(e){return E||(c.mimeType=e),this},abort:function(e){return e=e||S,o&&o.abort(e),T(0,e),this}};d.promise(x),x.success=x.done,x.error=x.fail,x.complete=m.add,x.statusCode=function(e){if(e){var t;if(E<2)for(t in e)g[t]=[g[t],e[t]];else t=e[x.status],x.always(t)}return this},c.url=((e||c.url)+"").replace(hn,"").replace(mn,ln[1]+"//"),c.dataTypes=v.trim(c.dataType||"*").toLowerCase().split(y),c.crossDomain==null&&(a=wn.exec(c.url.toLowerCase()),c.crossDomain=!(!a||a[1]===ln[1]&&a[2]===ln[2]&&(a[3]||(a[1]==="http:"?80:443))==(ln[3]||(ln[1]==="http:"?80:443)))),c.data&&c.processData&&typeof c.data!="string"&&(c.data=v.param(c.data,c.traditional)),kn(Sn,c,n,x);if(E===2)return x;f=c.global,c.type=c.type.toUpperCase(),c.hasContent=!vn.test(c.type),f&&v.active++===0&&v.event.trigger("ajaxStart");if(!c.hasContent){c.data&&(c.url+=(gn.test(c.url)?"&":"?")+c.data,delete c.data),r=c.url;if(c.cache===!1){var N=v.now(),C=c.url.replace(bn,"$1_="+N);c.url=C+(C===c.url?(gn.test(c.url)?"&":"?")+"_="+N:"")}}(c.data&&c.hasContent&&c.contentType!==!1||n.contentType)&&x.setRequestHeader("Content-Type",c.contentType),c.ifModified&&(r=r||c.url,v.lastModified[r]&&x.setRequestHeader("If-Modified-Since",v.lastModified[r]),v.etag[r]&&x.setRequestHeader("If-None-Match",v.etag[r])),x.setRequestHeader("Accept",c.dataTypes[0]&&c.accepts[c.dataTypes[0]]?c.accepts[c.dataTypes[0]]+(c.dataTypes[0]!=="*"?", "+Tn+"; q=0.01":""):c.accepts["*"]);for(l in c.headers)x.setRequestHeader(l,c.headers[l]);if(!c.beforeSend||c.beforeSend.call(h,x,c)!==!1&&E!==2){S="abort";for(l in{success:1,error:1,complete:1})x[l](c[l]);o=kn(xn,c,n,x);if(!o)T(-1,"No Transport");else{x.readyState=1,f&&p.trigger("ajaxSend",[x,c]),c.async&&c.timeout>0&&(u=setTimeout(function(){x.abort("timeout")},c.timeout));try{E=1,o.send(b,T)}catch(k){if(!(E<2))throw k;T(-1,k)}}return x}return x.abort()},active:0,lastModified:{},etag:{}});var Mn=[],_n=/\?/,Dn=/(=)\?(?=&|$)|\?\?/,Pn=v.now();v.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=Mn.pop()||v.expando+"_"+Pn++;return this[e]=!0,e}}),v.ajaxPrefilter("json jsonp",function(n,r,i){var s,o,u,a=n.data,f=n.url,l=n.jsonp!==!1,c=l&&Dn.test(f),h=l&&!c&&typeof a=="string"&&!(n.contentType||"").indexOf("application/x-www-form-urlencoded")&&Dn.test(a);if(n.dataTypes[0]==="jsonp"||c||h)return s=n.jsonpCallback=v.isFunction(n.jsonpCallback)?n.jsonpCallback():n.jsonpCallback,o=e[s],c?n.url=f.replace(Dn,"$1"+s):h?n.data=a.replace(Dn,"$1"+s):l&&(n.url+=(_n.test(f)?"&":"?")+n.jsonp+"="+s),n.converters["script json"]=function(){return u||v.error(s+" was not called"),u[0]},n.dataTypes[0]="json",e[s]=function(){u=arguments},i.always(function(){e[s]=o,n[s]&&(n.jsonpCallback=r.jsonpCallback,Mn.push(s)),u&&v.isFunction(o)&&o(u[0]),u=o=t}),"script"}),v.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/javascript|ecmascript/},converters:{"text script":function(e){return v.globalEval(e),e}}}),v.ajaxPrefilter("script",function(e){e.cache===t&&(e.cache=!1),e.crossDomain&&(e.type="GET",e.global=!1)}),v.ajaxTransport("script",function(e){if(e.crossDomain){var n,r=i.head||i.getElementsByTagName("head")[0]||i.documentElement;return{send:function(s,o){n=i.createElement("script"),n.async="async",e.scriptCharset&&(n.charset=e.scriptCharset),n.src=e.url,n.onload=n.onreadystatechange=function(e,i){if(i||!n.readyState||/loaded|complete/.test(n.readyState))n.onload=n.onreadystatechange=null,r&&n.parentNode&&r.removeChild(n),n=t,i||o(200,"success")},r.insertBefore(n,r.firstChild)},abort:function(){n&&n.onload(0,1)}}}});var Hn,Bn=e.ActiveXObject?function(){for(var e in Hn)Hn[e](0,1)}:!1,jn=0;v.ajaxSettings.xhr=e.ActiveXObject?function(){return!this.isLocal&&Fn()||In()}:Fn,function(e){v.extend(v.support,{ajax:!!e,cors:!!e&&"withCredentials"in e})}(v.ajaxSettings.xhr()),v.support.ajax&&v.ajaxTransport(function(n){if(!n.crossDomain||v.support.cors){var r;return{send:function(i,s){var o,u,a=n.xhr();n.username?a.open(n.type,n.url,n.async,n.username,n.password):a.open(n.type,n.url,n.async);if(n.xhrFields)for(u in n.xhrFields)a[u]=n.xhrFields[u];n.mimeType&&a.overrideMimeType&&a.overrideMimeType(n.mimeType),!n.crossDomain&&!i["X-Requested-With"]&&(i["X-Requested-With"]="XMLHttpRequest");try{for(u in i)a.setRequestHeader(u,i[u])}catch(f){}a.send(n.hasContent&&n.data||null),r=function(e,i){var u,f,l,c,h;try{if(r&&(i||a.readyState===4)){r=t,o&&(a.onreadystatechange=v.noop,Bn&&delete Hn[o]);if(i)a.readyState!==4&&a.abort();else{u=a.status,l=a.getAllResponseHeaders(),c={},h=a.responseXML,h&&h.documentElement&&(c.xml=h);try{c.text=a.responseText}catch(p){}try{f=a.statusText}catch(p){f=""}!u&&n.isLocal&&!n.crossDomain?u=c.text?200:404:u===1223&&(u=204)}}}catch(d){i||s(-1,d)}c&&s(u,f,c,l)},n.async?a.readyState===4?setTimeout(r,0):(o=++jn,Bn&&(Hn||(Hn={},v(e).unload(Bn)),Hn[o]=r),a.onreadystatechange=r):r()},abort:function(){r&&r(0,1)}}}});var qn,Rn,Un=/^(?:toggle|show|hide)$/,zn=new RegExp("^(?:([-+])=|)("+m+")([a-z%]*)$","i"),Wn=/queueHooks$/,Xn=[Gn],Vn={"*":[function(e,t){var n,r,i=this.createTween(e,t),s=zn.exec(t),o=i.cur(),u=+o||0,a=1,f=20;if(s){n=+s[2],r=s[3]||(v.cssNumber[e]?"":"px");if(r!=="px"&&u){u=v.css(i.elem,e,!0)||n||1;do a=a||".5",u/=a,v.style(i.elem,e,u+r);while(a!==(a=i.cur()/o)&&a!==1&&--f)}i.unit=r,i.start=u,i.end=s[1]?u+(s[1]+1)*n:n}return i}]};v.Animation=v.extend(Kn,{tweener:function(e,t){v.isFunction(e)?(t=e,e=["*"]):e=e.split(" ");var n,r=0,i=e.length;for(;r<i;r++)n=e[r],Vn[n]=Vn[n]||[],Vn[n].unshift(t)},prefilter:function(e,t){t?Xn.unshift(e):Xn.push(e)}}),v.Tween=Yn,Yn.prototype={constructor:Yn,init:function(e,t,n,r,i,s){this.elem=e,this.prop=n,this.easing=i||"swing",this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=s||(v.cssNumber[n]?"":"px")},cur:function(){var e=Yn.propHooks[this.prop];return e&&e.get?e.get(this):Yn.propHooks._default.get(this)},run:function(e){var t,n=Yn.propHooks[this.prop];return this.options.duration?this.pos=t=v.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):Yn.propHooks._default.set(this),this}},Yn.prototype.init.prototype=Yn.prototype,Yn.propHooks={_default:{get:function(e){var t;return e.elem[e.prop]==null||!!e.elem.style&&e.elem.style[e.prop]!=null?(t=v.css(e.elem,e.prop,!1,""),!t||t==="auto"?0:t):e.elem[e.prop]},set:function(e){v.fx.step[e.prop]?v.fx.step[e.prop](e):e.elem.style&&(e.elem.style[v.cssProps[e.prop]]!=null||v.cssHooks[e.prop])?v.style(e.elem,e.prop,e.now+e.unit):e.elem[e.prop]=e.now}}},Yn.propHooks.scrollTop=Yn.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},v.each(["toggle","show","hide"],function(e,t){var n=v.fn[t];v.fn[t]=function(r,i,s){return r==null||typeof r=="boolean"||!e&&v.isFunction(r)&&v.isFunction(i)?n.apply(this,arguments):this.animate(Zn(t,!0),r,i,s)}}),v.fn.extend({fadeTo:function(e,t,n,r){return this.filter(Gt).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(e,t,n,r){var i=v.isEmptyObject(e),s=v.speed(t,n,r),o=function(){var t=Kn(this,v.extend({},e),s);i&&t.stop(!0)};return i||s.queue===!1?this.each(o):this.queue(s.queue,o)},stop:function(e,n,r){var i=function(e){var t=e.stop;delete e.stop,t(r)};return typeof e!="string"&&(r=n,n=e,e=t),n&&e!==!1&&this.queue(e||"fx",[]),this.each(function(){var t=!0,n=e!=null&&e+"queueHooks",s=v.timers,o=v._data(this);if(n)o[n]&&o[n].stop&&i(o[n]);else for(n in o)o[n]&&o[n].stop&&Wn.test(n)&&i(o[n]);for(n=s.length;n--;)s[n].elem===this&&(e==null||s[n].queue===e)&&(s[n].anim.stop(r),t=!1,s.splice(n,1));(t||!r)&&v.dequeue(this,e)})}}),v.each({slideDown:Zn("show"),slideUp:Zn("hide"),slideToggle:Zn("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,t){v.fn[e]=function(e,n,r){return this.animate(t,e,n,r)}}),v.speed=function(e,t,n){var r=e&&typeof e=="object"?v.extend({},e):{complete:n||!n&&t||v.isFunction(e)&&e,duration:e,easing:n&&t||t&&!v.isFunction(t)&&t};r.duration=v.fx.off?0:typeof r.duration=="number"?r.duration:r.duration in v.fx.speeds?v.fx.speeds[r.duration]:v.fx.speeds._default;if(r.queue==null||r.queue===!0)r.queue="fx";return r.old=r.complete,r.complete=function(){v.isFunction(r.old)&&r.old.call(this),r.queue&&v.dequeue(this,r.queue)},r},v.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2}},v.timers=[],v.fx=Yn.prototype.init,v.fx.tick=function(){var e,n=v.timers,r=0;qn=v.now();for(;r<n.length;r++)e=n[r],!e()&&n[r]===e&&n.splice(r--,1);n.length||v.fx.stop(),qn=t},v.fx.timer=function(e){e()&&v.timers.push(e)&&!Rn&&(Rn=setInterval(v.fx.tick,v.fx.interval))},v.fx.interval=13,v.fx.stop=function(){clearInterval(Rn),Rn=null},v.fx.speeds={slow:600,fast:200,_default:400},v.fx.step={},v.expr&&v.expr.filters&&(v.expr.filters.animated=function(e){return v.grep(v.timers,function(t){return e===t.elem}).length});var er=/^(?:body|html)$/i;v.fn.offset=function(e){if(arguments.length)return e===t?this:this.each(function(t){v.offset.setOffset(this,e,t)});var n,r,i,s,o,u,a,f={top:0,left:0},l=this[0],c=l&&l.ownerDocument;if(!c)return;return(r=c.body)===l?v.offset.bodyOffset(l):(n=c.documentElement,v.contains(n,l)?(typeof l.getBoundingClientRect!="undefined"&&(f=l.getBoundingClientRect()),i=tr(c),s=n.clientTop||r.clientTop||0,o=n.clientLeft||r.clientLeft||0,u=i.pageYOffset||n.scrollTop,a=i.pageXOffset||n.scrollLeft,{top:f.top+u-s,left:f.left+a-o}):f)},v.offset={bodyOffset:function(e){var t=e.offsetTop,n=e.offsetLeft;return v.support.doesNotIncludeMarginInBodyOffset&&(t+=parseFloat(v.css(e,"marginTop"))||0,n+=parseFloat(v.css(e,"marginLeft"))||0),{top:t,left:n}},setOffset:function(e,t,n){var r=v.css(e,"position");r==="static"&&(e.style.position="relative");var i=v(e),s=i.offset(),o=v.css(e,"top"),u=v.css(e,"left"),a=(r==="absolute"||r==="fixed")&&v.inArray("auto",[o,u])>-1,f={},l={},c,h;a?(l=i.position(),c=l.top,h=l.left):(c=parseFloat(o)||0,h=parseFloat(u)||0),v.isFunction(t)&&(t=t.call(e,n,s)),t.top!=null&&(f.top=t.top-s.top+c),t.left!=null&&(f.left=t.left-s.left+h),"using"in t?t.using.call(e,f):i.css(f)}},v.fn.extend({position:function(){if(!this[0])return;var e=this[0],t=this.offsetParent(),n=this.offset(),r=er.test(t[0].nodeName)?{top:0,left:0}:t.offset();return n.top-=parseFloat(v.css(e,"marginTop"))||0,n.left-=parseFloat(v.css(e,"marginLeft"))||0,r.top+=parseFloat(v.css(t[0],"borderTopWidth"))||0,r.left+=parseFloat(v.css(t[0],"borderLeftWidth"))||0,{top:n.top-r.top,left:n.left-r.left}},offsetParent:function(){return this.map(function(){var e=this.offsetParent||i.body;while(e&&!er.test(e.nodeName)&&v.css(e,"position")==="static")e=e.offsetParent;return e||i.body})}}),v.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(e,n){var r=/Y/.test(n);v.fn[e]=function(i){return v.access(this,function(e,i,s){var o=tr(e);if(s===t)return o?n in o?o[n]:o.document.documentElement[i]:e[i];o?o.scrollTo(r?v(o).scrollLeft():s,r?s:v(o).scrollTop()):e[i]=s},e,i,arguments.length,null)}}),v.each({Height:"height",Width:"width"},function(e,n){v.each({padding:"inner"+e,content:n,"":"outer"+e},function(r,i){v.fn[i]=function(i,s){var o=arguments.length&&(r||typeof i!="boolean"),u=r||(i===!0||s===!0?"margin":"border");return v.access(this,function(n,r,i){var s;return v.isWindow(n)?n.document.documentElement["client"+e]:n.nodeType===9?(s=n.documentElement,Math.max(n.body["scroll"+e],s["scroll"+e],n.body["offset"+e],s["offset"+e],s["client"+e])):i===t?v.css(n,r,i,u):v.style(n,r,i,u)},n,o?i:t,o,null)}})}),e.jQuery=e.$=v,typeof define=="function"&&define.amd&&define.amd.jQuery&&define("jquery",[],function(){return v})})(window);
/*!
 * jQuery Cookie Plugin
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2011, Klaus Hartl
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/GPL-2.0
 */
(function($) {
    $.cookie = function(key, value, options) {

        // key and at least value given, set cookie...
        if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value === null || value === undefined)) {
            options = $.extend({}, options);

            if (value === null || value === undefined) {
                options.expires = -1;
            }

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = String(value);

            return (document.cookie = [
                encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // key and possibly options given, get cookie...
        options = value || {};
        var decode = options.raw ? function(s) { return s; } : decodeURIComponent;

        var pairs = document.cookie.split('; ');
        for (var i = 0, pair; pair = pairs[i] && pairs[i].split('='); i++) {
            if (decode(pair[0]) === key) return decode(pair[1] || ''); // IE saves cookies with empty string as "c; ", e.g. without "=" as opposed to EOMB, thus pair[1] may be undefined
        }
        return null;
    };
})(jQuery);

/*! fancyBox v2.1.5 fancyapps.com | fancyapps.com/fancybox/#license */
(function(r,G,f,v){var J=f("html"),n=f(r),p=f(G),b=f.fancybox=function(){b.open.apply(this,arguments)},I=navigator.userAgent.match(/msie/i),B=null,s=G.createTouch!==v,t=function(a){return a&&a.hasOwnProperty&&a instanceof f},q=function(a){return a&&"string"===f.type(a)},E=function(a){return q(a)&&0<a.indexOf("%")},l=function(a,d){var e=parseInt(a,10)||0;d&&E(a)&&(e*=b.getViewport()[d]/100);return Math.ceil(e)},w=function(a,b){return l(a,b)+"px"};f.extend(b,{version:"2.1.5",defaults:{padding:15,margin:20,
width:800,height:600,minWidth:100,minHeight:100,maxWidth:9999,maxHeight:9999,pixelRatio:1,autoSize:!0,autoHeight:!1,autoWidth:!1,autoResize:!0,autoCenter:!s,fitToView:!0,aspectRatio:!1,topRatio:0.5,leftRatio:0.5,scrolling:"auto",wrapCSS:"",arrows:!0,closeBtn:!0,closeClick:!1,nextClick:!1,mouseWheel:!0,autoPlay:!1,playSpeed:3E3,preload:3,modal:!1,loop:!0,ajax:{dataType:"html",headers:{"X-fancyBox":!0}},iframe:{scrolling:"auto",preload:!0},swf:{wmode:"transparent",allowfullscreen:"true",allowscriptaccess:"always"},
keys:{next:{13:"left",34:"up",39:"left",40:"up"},prev:{8:"right",33:"down",37:"right",38:"down"},close:[27],play:[32],toggle:[70]},direction:{next:"left",prev:"right"},scrollOutside:!0,index:0,type:null,href:null,content:null,title:null,tpl:{wrap:'<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',image:'<img class="fancybox-image" src="{href}" alt="" />',iframe:'<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen'+
(I?' allowtransparency="true"':"")+"></iframe>",error:'<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',closeBtn:'<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',next:'<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',prev:'<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'},openEffect:"fade",openSpeed:250,openEasing:"swing",openOpacity:!0,
openMethod:"zoomIn",closeEffect:"fade",closeSpeed:250,closeEasing:"swing",closeOpacity:!0,closeMethod:"zoomOut",nextEffect:"elastic",nextSpeed:250,nextEasing:"swing",nextMethod:"changeIn",prevEffect:"elastic",prevSpeed:250,prevEasing:"swing",prevMethod:"changeOut",helpers:{overlay:!0,title:!0},onCancel:f.noop,beforeLoad:f.noop,afterLoad:f.noop,beforeShow:f.noop,afterShow:f.noop,beforeChange:f.noop,beforeClose:f.noop,afterClose:f.noop},group:{},opts:{},previous:null,coming:null,current:null,isActive:!1,
isOpen:!1,isOpened:!1,wrap:null,skin:null,outer:null,inner:null,player:{timer:null,isActive:!1},ajaxLoad:null,imgPreload:null,transitions:{},helpers:{},open:function(a,d){if(a&&(f.isPlainObject(d)||(d={}),!1!==b.close(!0)))return f.isArray(a)||(a=t(a)?f(a).get():[a]),f.each(a,function(e,c){var k={},g,h,j,m,l;"object"===f.type(c)&&(c.nodeType&&(c=f(c)),t(c)?(k={href:c.data("fancybox-href")||c.attr("href"),title:c.data("fancybox-title")||c.attr("title"),isDom:!0,element:c},f.metadata&&f.extend(!0,k,
c.metadata())):k=c);g=d.href||k.href||(q(c)?c:null);h=d.title!==v?d.title:k.title||"";m=(j=d.content||k.content)?"html":d.type||k.type;!m&&k.isDom&&(m=c.data("fancybox-type"),m||(m=(m=c.prop("class").match(/fancybox\.(\w+)/))?m[1]:null));q(g)&&(m||(b.isImage(g)?m="image":b.isSWF(g)?m="swf":"#"===g.charAt(0)?m="inline":q(c)&&(m="html",j=c)),"ajax"===m&&(l=g.split(/\s+/,2),g=l.shift(),l=l.shift()));j||("inline"===m?g?j=f(q(g)?g.replace(/.*(?=#[^\s]+$)/,""):g):k.isDom&&(j=c):"html"===m?j=g:!m&&(!g&&
k.isDom)&&(m="inline",j=c));f.extend(k,{href:g,type:m,content:j,title:h,selector:l});a[e]=k}),b.opts=f.extend(!0,{},b.defaults,d),d.keys!==v&&(b.opts.keys=d.keys?f.extend({},b.defaults.keys,d.keys):!1),b.group=a,b._start(b.opts.index)},cancel:function(){var a=b.coming;a&&!1!==b.trigger("onCancel")&&(b.hideLoading(),b.ajaxLoad&&b.ajaxLoad.abort(),b.ajaxLoad=null,b.imgPreload&&(b.imgPreload.onload=b.imgPreload.onerror=null),a.wrap&&a.wrap.stop(!0,!0).trigger("onReset").remove(),b.coming=null,b.current||
b._afterZoomOut(a))},close:function(a){b.cancel();!1!==b.trigger("beforeClose")&&(b.unbindEvents(),b.isActive&&(!b.isOpen||!0===a?(f(".fancybox-wrap").stop(!0).trigger("onReset").remove(),b._afterZoomOut()):(b.isOpen=b.isOpened=!1,b.isClosing=!0,f(".fancybox-item, .fancybox-nav").remove(),b.wrap.stop(!0,!0).removeClass("fancybox-opened"),b.transitions[b.current.closeMethod]())))},play:function(a){var d=function(){clearTimeout(b.player.timer)},e=function(){d();b.current&&b.player.isActive&&(b.player.timer=
setTimeout(b.next,b.current.playSpeed))},c=function(){d();p.unbind(".player");b.player.isActive=!1;b.trigger("onPlayEnd")};if(!0===a||!b.player.isActive&&!1!==a){if(b.current&&(b.current.loop||b.current.index<b.group.length-1))b.player.isActive=!0,p.bind({"onCancel.player beforeClose.player":c,"onUpdate.player":e,"beforeLoad.player":d}),e(),b.trigger("onPlayStart")}else c()},next:function(a){var d=b.current;d&&(q(a)||(a=d.direction.next),b.jumpto(d.index+1,a,"next"))},prev:function(a){var d=b.current;
d&&(q(a)||(a=d.direction.prev),b.jumpto(d.index-1,a,"prev"))},jumpto:function(a,d,e){var c=b.current;c&&(a=l(a),b.direction=d||c.direction[a>=c.index?"next":"prev"],b.router=e||"jumpto",c.loop&&(0>a&&(a=c.group.length+a%c.group.length),a%=c.group.length),c.group[a]!==v&&(b.cancel(),b._start(a)))},reposition:function(a,d){var e=b.current,c=e?e.wrap:null,k;c&&(k=b._getPosition(d),a&&"scroll"===a.type?(delete k.position,c.stop(!0,!0).animate(k,200)):(c.css(k),e.pos=f.extend({},e.dim,k)))},update:function(a){var d=
a&&a.type,e=!d||"orientationchange"===d;e&&(clearTimeout(B),B=null);b.isOpen&&!B&&(B=setTimeout(function(){var c=b.current;c&&!b.isClosing&&(b.wrap.removeClass("fancybox-tmp"),(e||"load"===d||"resize"===d&&c.autoResize)&&b._setDimension(),"scroll"===d&&c.canShrink||b.reposition(a),b.trigger("onUpdate"),B=null)},e&&!s?0:300))},toggle:function(a){b.isOpen&&(b.current.fitToView="boolean"===f.type(a)?a:!b.current.fitToView,s&&(b.wrap.removeAttr("style").addClass("fancybox-tmp"),b.trigger("onUpdate")),
b.update())},hideLoading:function(){p.unbind(".loading");f("#fancybox-loading").remove()},showLoading:function(){var a,d;b.hideLoading();a=f('<div id="fancybox-loading"><div></div></div>').click(b.cancel).appendTo("body");p.bind("keydown.loading",function(a){if(27===(a.which||a.keyCode))a.preventDefault(),b.cancel()});b.defaults.fixed||(d=b.getViewport(),a.css({position:"absolute",top:0.5*d.h+d.y,left:0.5*d.w+d.x}))},getViewport:function(){var a=b.current&&b.current.locked||!1,d={x:n.scrollLeft(),
y:n.scrollTop()};a?(d.w=a[0].clientWidth,d.h=a[0].clientHeight):(d.w=s&&r.innerWidth?r.innerWidth:n.width(),d.h=s&&r.innerHeight?r.innerHeight:n.height());return d},unbindEvents:function(){b.wrap&&t(b.wrap)&&b.wrap.unbind(".fb");p.unbind(".fb");n.unbind(".fb")},bindEvents:function(){var a=b.current,d;a&&(n.bind("orientationchange.fb"+(s?"":" resize.fb")+(a.autoCenter&&!a.locked?" scroll.fb":""),b.update),(d=a.keys)&&p.bind("keydown.fb",function(e){var c=e.which||e.keyCode,k=e.target||e.srcElement;
if(27===c&&b.coming)return!1;!e.ctrlKey&&(!e.altKey&&!e.shiftKey&&!e.metaKey&&(!k||!k.type&&!f(k).is("[contenteditable]")))&&f.each(d,function(d,k){if(1<a.group.length&&k[c]!==v)return b[d](k[c]),e.preventDefault(),!1;if(-1<f.inArray(c,k))return b[d](),e.preventDefault(),!1})}),f.fn.mousewheel&&a.mouseWheel&&b.wrap.bind("mousewheel.fb",function(d,c,k,g){for(var h=f(d.target||null),j=!1;h.length&&!j&&!h.is(".fancybox-skin")&&!h.is(".fancybox-wrap");)j=h[0]&&!(h[0].style.overflow&&"hidden"===h[0].style.overflow)&&
(h[0].clientWidth&&h[0].scrollWidth>h[0].clientWidth||h[0].clientHeight&&h[0].scrollHeight>h[0].clientHeight),h=f(h).parent();if(0!==c&&!j&&1<b.group.length&&!a.canShrink){if(0<g||0<k)b.prev(0<g?"down":"left");else if(0>g||0>k)b.next(0>g?"up":"right");d.preventDefault()}}))},trigger:function(a,d){var e,c=d||b.coming||b.current;if(c){f.isFunction(c[a])&&(e=c[a].apply(c,Array.prototype.slice.call(arguments,1)));if(!1===e)return!1;c.helpers&&f.each(c.helpers,function(d,e){if(e&&b.helpers[d]&&f.isFunction(b.helpers[d][a]))b.helpers[d][a](f.extend(!0,
{},b.helpers[d].defaults,e),c)});p.trigger(a)}},isImage:function(a){return q(a)&&a.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)},isSWF:function(a){return q(a)&&a.match(/\.(swf)((\?|#).*)?$/i)},_start:function(a){var d={},e,c;a=l(a);e=b.group[a]||null;if(!e)return!1;d=f.extend(!0,{},b.opts,e);e=d.margin;c=d.padding;"number"===f.type(e)&&(d.margin=[e,e,e,e]);"number"===f.type(c)&&(d.padding=[c,c,c,c]);d.modal&&f.extend(!0,d,{closeBtn:!1,closeClick:!1,nextClick:!1,arrows:!1,
mouseWheel:!1,keys:null,helpers:{overlay:{closeClick:!1}}});d.autoSize&&(d.autoWidth=d.autoHeight=!0);"auto"===d.width&&(d.autoWidth=!0);"auto"===d.height&&(d.autoHeight=!0);d.group=b.group;d.index=a;b.coming=d;if(!1===b.trigger("beforeLoad"))b.coming=null;else{c=d.type;e=d.href;if(!c)return b.coming=null,b.current&&b.router&&"jumpto"!==b.router?(b.current.index=a,b[b.router](b.direction)):!1;b.isActive=!0;if("image"===c||"swf"===c)d.autoHeight=d.autoWidth=!1,d.scrolling="visible";"image"===c&&(d.aspectRatio=
!0);"iframe"===c&&s&&(d.scrolling="scroll");d.wrap=f(d.tpl.wrap).addClass("fancybox-"+(s?"mobile":"desktop")+" fancybox-type-"+c+" fancybox-tmp "+d.wrapCSS).appendTo(d.parent||"body");f.extend(d,{skin:f(".fancybox-skin",d.wrap),outer:f(".fancybox-outer",d.wrap),inner:f(".fancybox-inner",d.wrap)});f.each(["Top","Right","Bottom","Left"],function(a,b){d.skin.css("padding"+b,w(d.padding[a]))});b.trigger("onReady");if("inline"===c||"html"===c){if(!d.content||!d.content.length)return b._error("content")}else if(!e)return b._error("href");
"image"===c?b._loadImage():"ajax"===c?b._loadAjax():"iframe"===c?b._loadIframe():b._afterLoad()}},_error:function(a){f.extend(b.coming,{type:"html",autoWidth:!0,autoHeight:!0,minWidth:0,minHeight:0,scrolling:"no",hasError:a,content:b.coming.tpl.error});b._afterLoad()},_loadImage:function(){var a=b.imgPreload=new Image;a.onload=function(){this.onload=this.onerror=null;b.coming.width=this.width/b.opts.pixelRatio;b.coming.height=this.height/b.opts.pixelRatio;b._afterLoad()};a.onerror=function(){this.onload=
this.onerror=null;b._error("image")};a.src=b.coming.href;!0!==a.complete&&b.showLoading()},_loadAjax:function(){var a=b.coming;b.showLoading();b.ajaxLoad=f.ajax(f.extend({},a.ajax,{url:a.href,error:function(a,e){b.coming&&"abort"!==e?b._error("ajax",a):b.hideLoading()},success:function(d,e){"success"===e&&(a.content=d,b._afterLoad())}}))},_loadIframe:function(){var a=b.coming,d=f(a.tpl.iframe.replace(/\{rnd\}/g,(new Date).getTime())).attr("scrolling",s?"auto":a.iframe.scrolling).attr("src",a.href);
f(a.wrap).bind("onReset",function(){try{f(this).find("iframe").hide().attr("src","//about:blank").end().empty()}catch(a){}});a.iframe.preload&&(b.showLoading(),d.one("load",function(){f(this).data("ready",1);s||f(this).bind("load.fb",b.update);f(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show();b._afterLoad()}));a.content=d.appendTo(a.inner);a.iframe.preload||b._afterLoad()},_preloadImages:function(){var a=b.group,d=b.current,e=a.length,c=d.preload?Math.min(d.preload,
e-1):0,f,g;for(g=1;g<=c;g+=1)f=a[(d.index+g)%e],"image"===f.type&&f.href&&((new Image).src=f.href)},_afterLoad:function(){var a=b.coming,d=b.current,e,c,k,g,h;b.hideLoading();if(a&&!1!==b.isActive)if(!1===b.trigger("afterLoad",a,d))a.wrap.stop(!0).trigger("onReset").remove(),b.coming=null;else{d&&(b.trigger("beforeChange",d),d.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove());b.unbindEvents();e=a.content;c=a.type;k=a.scrolling;f.extend(b,{wrap:a.wrap,skin:a.skin,
outer:a.outer,inner:a.inner,current:a,previous:d});g=a.href;switch(c){case "inline":case "ajax":case "html":a.selector?e=f("<div>").html(e).find(a.selector):t(e)&&(e.data("fancybox-placeholder")||e.data("fancybox-placeholder",f('<div class="fancybox-placeholder"></div>').insertAfter(e).hide()),e=e.show().detach(),a.wrap.bind("onReset",function(){f(this).find(e).length&&e.hide().replaceAll(e.data("fancybox-placeholder")).data("fancybox-placeholder",!1)}));break;case "image":e=a.tpl.image.replace("{href}",
g);break;case "swf":e='<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="'+g+'"></param>',h="",f.each(a.swf,function(a,b){e+='<param name="'+a+'" value="'+b+'"></param>';h+=" "+a+'="'+b+'"'}),e+='<embed src="'+g+'" type="application/x-shockwave-flash" width="100%" height="100%"'+h+"></embed></object>"}(!t(e)||!e.parent().is(a.inner))&&a.inner.append(e);b.trigger("beforeShow");a.inner.css("overflow","yes"===k?"scroll":
"no"===k?"hidden":k);b._setDimension();b.reposition();b.isOpen=!1;b.coming=null;b.bindEvents();if(b.isOpened){if(d.prevMethod)b.transitions[d.prevMethod]()}else f(".fancybox-wrap").not(a.wrap).stop(!0).trigger("onReset").remove();b.transitions[b.isOpened?a.nextMethod:a.openMethod]();b._preloadImages()}},_setDimension:function(){var a=b.getViewport(),d=0,e=!1,c=!1,e=b.wrap,k=b.skin,g=b.inner,h=b.current,c=h.width,j=h.height,m=h.minWidth,u=h.minHeight,n=h.maxWidth,p=h.maxHeight,s=h.scrolling,q=h.scrollOutside?
h.scrollbarWidth:0,x=h.margin,y=l(x[1]+x[3]),r=l(x[0]+x[2]),v,z,t,C,A,F,B,D,H;e.add(k).add(g).width("auto").height("auto").removeClass("fancybox-tmp");x=l(k.outerWidth(!0)-k.width());v=l(k.outerHeight(!0)-k.height());z=y+x;t=r+v;C=E(c)?(a.w-z)*l(c)/100:c;A=E(j)?(a.h-t)*l(j)/100:j;if("iframe"===h.type){if(H=h.content,h.autoHeight&&1===H.data("ready"))try{H[0].contentWindow.document.location&&(g.width(C).height(9999),F=H.contents().find("body"),q&&F.css("overflow-x","hidden"),A=F.outerHeight(!0))}catch(G){}}else if(h.autoWidth||
h.autoHeight)g.addClass("fancybox-tmp"),h.autoWidth||g.width(C),h.autoHeight||g.height(A),h.autoWidth&&(C=g.width()),h.autoHeight&&(A=g.height()),g.removeClass("fancybox-tmp");c=l(C);j=l(A);D=C/A;m=l(E(m)?l(m,"w")-z:m);n=l(E(n)?l(n,"w")-z:n);u=l(E(u)?l(u,"h")-t:u);p=l(E(p)?l(p,"h")-t:p);F=n;B=p;h.fitToView&&(n=Math.min(a.w-z,n),p=Math.min(a.h-t,p));z=a.w-y;r=a.h-r;h.aspectRatio?(c>n&&(c=n,j=l(c/D)),j>p&&(j=p,c=l(j*D)),c<m&&(c=m,j=l(c/D)),j<u&&(j=u,c=l(j*D))):(c=Math.max(m,Math.min(c,n)),h.autoHeight&&
"iframe"!==h.type&&(g.width(c),j=g.height()),j=Math.max(u,Math.min(j,p)));if(h.fitToView)if(g.width(c).height(j),e.width(c+x),a=e.width(),y=e.height(),h.aspectRatio)for(;(a>z||y>r)&&(c>m&&j>u)&&!(19<d++);)j=Math.max(u,Math.min(p,j-10)),c=l(j*D),c<m&&(c=m,j=l(c/D)),c>n&&(c=n,j=l(c/D)),g.width(c).height(j),e.width(c+x),a=e.width(),y=e.height();else c=Math.max(m,Math.min(c,c-(a-z))),j=Math.max(u,Math.min(j,j-(y-r)));q&&("auto"===s&&j<A&&c+x+q<z)&&(c+=q);g.width(c).height(j);e.width(c+x);a=e.width();
y=e.height();e=(a>z||y>r)&&c>m&&j>u;c=h.aspectRatio?c<F&&j<B&&c<C&&j<A:(c<F||j<B)&&(c<C||j<A);f.extend(h,{dim:{width:w(a),height:w(y)},origWidth:C,origHeight:A,canShrink:e,canExpand:c,wPadding:x,hPadding:v,wrapSpace:y-k.outerHeight(!0),skinSpace:k.height()-j});!H&&(h.autoHeight&&j>u&&j<p&&!c)&&g.height("auto")},_getPosition:function(a){var d=b.current,e=b.getViewport(),c=d.margin,f=b.wrap.width()+c[1]+c[3],g=b.wrap.height()+c[0]+c[2],c={position:"absolute",top:c[0],left:c[3]};d.autoCenter&&d.fixed&&
!a&&g<=e.h&&f<=e.w?c.position="fixed":d.locked||(c.top+=e.y,c.left+=e.x);c.top=w(Math.max(c.top,c.top+(e.h-g)*d.topRatio));c.left=w(Math.max(c.left,c.left+(e.w-f)*d.leftRatio));return c},_afterZoomIn:function(){var a=b.current;a&&(b.isOpen=b.isOpened=!0,b.wrap.css("overflow","visible").addClass("fancybox-opened"),b.update(),(a.closeClick||a.nextClick&&1<b.group.length)&&b.inner.css("cursor","pointer").bind("click.fb",function(d){!f(d.target).is("a")&&!f(d.target).parent().is("a")&&(d.preventDefault(),
b[a.closeClick?"close":"next"]())}),a.closeBtn&&f(a.tpl.closeBtn).appendTo(b.skin).bind("click.fb",function(a){a.preventDefault();b.close()}),a.arrows&&1<b.group.length&&((a.loop||0<a.index)&&f(a.tpl.prev).appendTo(b.outer).bind("click.fb",b.prev),(a.loop||a.index<b.group.length-1)&&f(a.tpl.next).appendTo(b.outer).bind("click.fb",b.next)),b.trigger("afterShow"),!a.loop&&a.index===a.group.length-1?b.play(!1):b.opts.autoPlay&&!b.player.isActive&&(b.opts.autoPlay=!1,b.play()))},_afterZoomOut:function(a){a=
a||b.current;f(".fancybox-wrap").trigger("onReset").remove();f.extend(b,{group:{},opts:{},router:!1,current:null,isActive:!1,isOpened:!1,isOpen:!1,isClosing:!1,wrap:null,skin:null,outer:null,inner:null});b.trigger("afterClose",a)}});b.transitions={getOrigPosition:function(){var a=b.current,d=a.element,e=a.orig,c={},f=50,g=50,h=a.hPadding,j=a.wPadding,m=b.getViewport();!e&&(a.isDom&&d.is(":visible"))&&(e=d.find("img:first"),e.length||(e=d));t(e)?(c=e.offset(),e.is("img")&&(f=e.outerWidth(),g=e.outerHeight())):
(c.top=m.y+(m.h-g)*a.topRatio,c.left=m.x+(m.w-f)*a.leftRatio);if("fixed"===b.wrap.css("position")||a.locked)c.top-=m.y,c.left-=m.x;return c={top:w(c.top-h*a.topRatio),left:w(c.left-j*a.leftRatio),width:w(f+j),height:w(g+h)}},step:function(a,d){var e,c,f=d.prop;c=b.current;var g=c.wrapSpace,h=c.skinSpace;if("width"===f||"height"===f)e=d.end===d.start?1:(a-d.start)/(d.end-d.start),b.isClosing&&(e=1-e),c="width"===f?c.wPadding:c.hPadding,c=a-c,b.skin[f](l("width"===f?c:c-g*e)),b.inner[f](l("width"===
f?c:c-g*e-h*e))},zoomIn:function(){var a=b.current,d=a.pos,e=a.openEffect,c="elastic"===e,k=f.extend({opacity:1},d);delete k.position;c?(d=this.getOrigPosition(),a.openOpacity&&(d.opacity=0.1)):"fade"===e&&(d.opacity=0.1);b.wrap.css(d).animate(k,{duration:"none"===e?0:a.openSpeed,easing:a.openEasing,step:c?this.step:null,complete:b._afterZoomIn})},zoomOut:function(){var a=b.current,d=a.closeEffect,e="elastic"===d,c={opacity:0.1};e&&(c=this.getOrigPosition(),a.closeOpacity&&(c.opacity=0.1));b.wrap.animate(c,
{duration:"none"===d?0:a.closeSpeed,easing:a.closeEasing,step:e?this.step:null,complete:b._afterZoomOut})},changeIn:function(){var a=b.current,d=a.nextEffect,e=a.pos,c={opacity:1},f=b.direction,g;e.opacity=0.1;"elastic"===d&&(g="down"===f||"up"===f?"top":"left","down"===f||"right"===f?(e[g]=w(l(e[g])-200),c[g]="+=200px"):(e[g]=w(l(e[g])+200),c[g]="-=200px"));"none"===d?b._afterZoomIn():b.wrap.css(e).animate(c,{duration:a.nextSpeed,easing:a.nextEasing,complete:b._afterZoomIn})},changeOut:function(){var a=
b.previous,d=a.prevEffect,e={opacity:0.1},c=b.direction;"elastic"===d&&(e["down"===c||"up"===c?"top":"left"]=("up"===c||"left"===c?"-":"+")+"=200px");a.wrap.animate(e,{duration:"none"===d?0:a.prevSpeed,easing:a.prevEasing,complete:function(){f(this).trigger("onReset").remove()}})}};b.helpers.overlay={defaults:{closeClick:!0,speedOut:200,showEarly:!0,css:{},locked:!s,fixed:!0},overlay:null,fixed:!1,el:f("html"),create:function(a){a=f.extend({},this.defaults,a);this.overlay&&this.close();this.overlay=
f('<div class="fancybox-overlay"></div>').appendTo(b.coming?b.coming.parent:a.parent);this.fixed=!1;a.fixed&&b.defaults.fixed&&(this.overlay.addClass("fancybox-overlay-fixed"),this.fixed=!0)},open:function(a){var d=this;a=f.extend({},this.defaults,a);this.overlay?this.overlay.unbind(".overlay").width("auto").height("auto"):this.create(a);this.fixed||(n.bind("resize.overlay",f.proxy(this.update,this)),this.update());a.closeClick&&this.overlay.bind("click.overlay",function(a){if(f(a.target).hasClass("fancybox-overlay"))return b.isActive?
b.close():d.close(),!1});this.overlay.css(a.css).show()},close:function(){var a,b;n.unbind("resize.overlay");this.el.hasClass("fancybox-lock")&&(f(".fancybox-margin").removeClass("fancybox-margin"),a=n.scrollTop(),b=n.scrollLeft(),this.el.removeClass("fancybox-lock"),n.scrollTop(a).scrollLeft(b));f(".fancybox-overlay").remove().hide();f.extend(this,{overlay:null,fixed:!1})},update:function(){var a="100%",b;this.overlay.width(a).height("100%");I?(b=Math.max(G.documentElement.offsetWidth,G.body.offsetWidth),
p.width()>b&&(a=p.width())):p.width()>n.width()&&(a=p.width());this.overlay.width(a).height(p.height())},onReady:function(a,b){var e=this.overlay;f(".fancybox-overlay").stop(!0,!0);e||this.create(a);a.locked&&(this.fixed&&b.fixed)&&(e||(this.margin=p.height()>n.height()?f("html").css("margin-right").replace("px",""):!1),b.locked=this.overlay.append(b.wrap),b.fixed=!1);!0===a.showEarly&&this.beforeShow.apply(this,arguments)},beforeShow:function(a,b){var e,c;b.locked&&(!1!==this.margin&&(f("*").filter(function(){return"fixed"===
f(this).css("position")&&!f(this).hasClass("fancybox-overlay")&&!f(this).hasClass("fancybox-wrap")}).addClass("fancybox-margin"),this.el.addClass("fancybox-margin")),e=n.scrollTop(),c=n.scrollLeft(),this.el.addClass("fancybox-lock"),n.scrollTop(e).scrollLeft(c));this.open(a)},onUpdate:function(){this.fixed||this.update()},afterClose:function(a){this.overlay&&!b.coming&&this.overlay.fadeOut(a.speedOut,f.proxy(this.close,this))}};b.helpers.title={defaults:{type:"float",position:"bottom"},beforeShow:function(a){var d=
b.current,e=d.title,c=a.type;f.isFunction(e)&&(e=e.call(d.element,d));if(q(e)&&""!==f.trim(e)){d=f('<div class="fancybox-title fancybox-title-'+c+'-wrap">'+e+"</div>");switch(c){case "inside":c=b.skin;break;case "outside":c=b.wrap;break;case "over":c=b.inner;break;default:c=b.skin,d.appendTo("body"),I&&d.width(d.width()),d.wrapInner('<span class="child"></span>'),b.current.margin[2]+=Math.abs(l(d.css("margin-bottom")))}d["top"===a.position?"prependTo":"appendTo"](c)}}};f.fn.fancybox=function(a){var d,
e=f(this),c=this.selector||"",k=function(g){var h=f(this).blur(),j=d,k,l;!g.ctrlKey&&(!g.altKey&&!g.shiftKey&&!g.metaKey)&&!h.is(".fancybox-wrap")&&(k=a.groupAttr||"data-fancybox-group",l=h.attr(k),l||(k="rel",l=h.get(0)[k]),l&&(""!==l&&"nofollow"!==l)&&(h=c.length?f(c):e,h=h.filter("["+k+'="'+l+'"]'),j=h.index(this)),a.index=j,!1!==b.open(h,a)&&g.preventDefault())};a=a||{};d=a.index||0;!c||!1===a.live?e.unbind("click.fb-start").bind("click.fb-start",k):p.undelegate(c,"click.fb-start").delegate(c+
":not('.fancybox-item, .fancybox-nav')","click.fb-start",k);this.filter("[data-fancybox-start=1]").trigger("click");return this};p.ready(function(){var a,d;f.scrollbarWidth===v&&(f.scrollbarWidth=function(){var a=f('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),b=a.children(),b=b.innerWidth()-b.height(99).innerWidth();a.remove();return b});if(f.support.fixedPosition===v){a=f.support;d=f('<div style="position:fixed;top:20px;"></div>').appendTo("body");var e=20===
d[0].offsetTop||15===d[0].offsetTop;d.remove();a.fixedPosition=e}f.extend(b.defaults,{scrollbarWidth:f.scrollbarWidth(),fixed:f.support.fixedPosition,parent:f("body")});a=f(r).width();J.addClass("fancybox-lock-test");d=f(r).width();J.removeClass("fancybox-lock-test");f("<style type='text/css'>.fancybox-margin{margin-right:"+(d-a)+"px;}</style>").appendTo("head")})})(window,document,jQuery);

(function(e){"use strict";var t=e.fancybox,n=function(t,n,r){r=r||"";if(e.type(r)==="object"){r=e.param(r,true)}e.each(n,function(e,n){t=t.replace("$"+e,n||"")});if(r.length){t+=(t.indexOf("?")>0?"&":"?")+r}return t};t.helpers.media={defaults:{youtube:{matcher:/(youtube\.com|youtu\.be|youtube-nocookie\.com)\/(watch\?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*)).*/i,params:{autoplay:1,autohide:1,fs:1,rel:0,hd:1,wmode:"opaque",enablejsapi:1},type:"iframe",url:"//www.youtube.com/embed/$3"},vimeo:{matcher:/(?:vimeo(?:pro)?.com)\/(?:[^\d]+)?(\d+)(?:.*)/,params:{autoplay:1,hd:1,show_title:1,show_byline:1,show_portrait:0,fullscreen:1},type:"iframe",url:"//player.vimeo.com/video/$1"},metacafe:{matcher:/metacafe.com\/(?:watch|fplayer)\/([\w\-]{1,10})/,params:{autoPlay:"yes"},type:"swf",url:function(t,n,r){r.swf.flashVars="playerVars="+e.param(n,true);return"//www.metacafe.com/fplayer/"+t[1]+"/.swf"}},dailymotion:{matcher:/dailymotion.com\/video\/(.*)\/?(.*)/,params:{additionalInfos:0,autoStart:1},type:"swf",url:"//www.dailymotion.com/swf/video/$1"},twitvid:{matcher:/twitvid\.com\/([a-zA-Z0-9_\-\?\=]+)/i,params:{autoplay:0},type:"iframe",url:"//www.twitvid.com/embed.php?guid=$1"},twitpic:{matcher:/twitpic\.com\/(?!(?:place|photos|events)\/)([a-zA-Z0-9\?\=\-]+)/i,type:"image",url:"//twitpic.com/show/full/$1/"},instagram:{matcher:/(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,type:"image",url:"//$1/p/$2/media/?size=l"},google_maps:{matcher:/maps\.google\.([a-z]{2,3}(\.[a-z]{2})?)\/(\?ll=|maps\?)(.*)/i,type:"iframe",url:function(e){return"//maps.google."+e[1]+"/"+e[3]+""+e[4]+"&output="+(e[4].indexOf("layer=c")>0?"svembed":"embed")}}},beforeLoad:function(t,r){var i=r.href||"",s=false,o,u,a,f;for(o in t){if(t.hasOwnProperty(o)){u=t[o];a=i.match(u.matcher);if(a){s=u.type;f=e.extend(true,{},u.params,r[o]||(e.isPlainObject(t[o])?t[o].params:null));i=e.type(u.url)==="function"?u.url.call(this,a,f,r):n(u.url,a,f);break}}}if(s){r.href=i;r.type=s;r.autoHeight=false}}}})(jQuery)
// popup auth - moved from functions.js
$(function() {
    $('form[data-form="login"]').each(function() {
        var $form = $(this),
            $submit,
            abTest = $form.find('input[name=ab_test_id]').attr('value');

        $form.on('submit', function() {
            if (Bm.isMobile) {
                $submit = $form.find('input[type=submit]');
                $submit.addClass('visibility-hidden');

                $form.find('.item').removeClass('invalid').find('.error').empty();
                $form.find('.error-main').empty().hide();
            } else {
                $submit = $form.find('.js-form-submit');

                $form.find('.popup .popup__error').empty().hide();
                $form.find('.item .input').removeClass('error');
                $form.find('.item .input-error').empty().hide();
            }

            Bm.ajax($submit, {
                type: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                beforeSend: function() {

                },
                success: function(result) {
                    if (result['redirect']) {
                        if (result['abPage'] && abTest) {
                            Bm.ab.invokeTest(abTest, result['abPage']['uri'], result);

                            return false;
                        }

                        window.location.href = result['redirect'];
                    } else {
                        var captchaImage = $form.find('.captchaImage'),
                            captchaBlock = $form.find('.captchaBlock'),
                            captchaWord = $form.find('.captchaWord'),
                            captchaCode = $form.find('.captchaCode');

                        if (result['status'] == 'error') {
                            if ((result['rawMessage']) instanceof Object && result['rawMessage'][0] == undefined) {
                                for (var name in result['rawMessage']) {
                                    var $input = $form.find('input[name=' + name + ']');

                                    for (var i in result['rawMessage'][name]) {
                                        var message = result['rawMessage'][name][i];
                                        break;
                                    }

                                    if (Bm.isMobile) {
                                        $input.parents('.item').addClass('invalid').find('.error').text(message);
                                    } else {
                                        $input.addClass('error').next('.input-error').text(message).show();
                                    }
                                }
                            } else {
                                var message = result['rawMessage'];

                                if ((result['rawMessage']) instanceof Array) {
                                    message = result['rawMessage'].shift();
                                }

                                var $input2 = $form.find('input').eq(0);

                                if (Bm.isMobile) {
                                    $input2.parents('.item').addClass('invalid').find('.error').text(message);
                                } else {
                                    $input2.addClass('error').next('.input-error').text(message).show();
                                }

                                if ('captcha_url' in result) {
                                    captchaImage.attr('src', result['captcha_url']);
                                    captchaBlock.removeClass('hidden');

                                    if (result['wrong_code']) {
                                        captchaWord.addClass('error').focus();
                                    }

                                    $form.find('.captchaCode').val(result['captcha_code']);
                                    captchaWord.val('');
                                } else {
                                    captchaWord.removeClass('error').val('');
                                    captchaBlock.addClass('hidden');
                                    captchaCode.val('');
                                }
                            }
                        } else if (result['status'] == 'success') {
                            captchaBlock.addClass('hidden');
                            captchaWord.removeClass('error').val('');
                            captchaCode.val('');

                            if (Bm.isMobile) {
                                $form.prepend('<div class="center">' + result.message + '</div>');

                            } else {
                                $form.prepend('<div class="popup__text">' + result.message + '</div>');
                            }

                            ga('send', 'event', 'button', 'start_reg_block');
                            ga('send', 'pageview', '/start_registrarion/button');
                        }

                        $submit.removeClass('visibility-hidden');
                    }
                },
                error: function() {
                    $submit.removeClass('visibility-hidden');
                    $form.find('.error-main').text('Ошибка загрузки').show();
                }
            });

            return false;
        });
    });
});
// bm global - moved from functions.js
Bm = {
    isMobile: false, // check on DOM ready (functions.js)
    mobile: {
        // init => mobile.js
    },
    social: {

    },
    user: {

    },
    feed: {

        /**
         * Работа с историей
         */
        changeHistory: function($el, event) {
            if (event.metaKey || event.ctrlKey || event.which == 2) {
                return false;
            }

            var post = $el.parents('.post').data('id'),
                path = window.location.pathname + '?from=' + post,
                $loading = $('.screen-loading'),
                $loadingIcon = $loading.children('.icon'),
                rotate,
                $content = Bm.isMobile ? $('.js-main') : $('#main, #footer'),
                scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

            $content.addClass('hidden');
            window.scrollTo(0, 0);

            setTimeout(function() {
                $loading.removeClass('hidden');
                rotate = rotateStart($loadingIcon);
            }, 5000);

            $(document).on('click', '.js-stop-screen-loading', function() {
                $loading.addClass('hidden');
                $content.removeClass('hidden');
                rotateStop($loadingIcon, rotate);
                window.scrollTo(0, scrollTop);
            });

            window.history.replaceState(null, null, path);
        },

        /**
         * Читать далее
         */
        readMore: function($button) {
            var $wrapper = $button.parents('.js-post-text-wrapper');
            var $full = $wrapper.find('.js-post-text-full');

            $full.toggleClass('hidden');

            if ($button.data('long-post')) {
                $button.removeClass('js-post-text-readmore');
            } else {
                $button.toggleClass('hidden');
            }
        }
    },
    ajax: function($item, data) {
        if ($item.hasClass('ajax-disabled')) {
            return false;
        }

        var $loading = $item.children('.loading'),
            rotate;

        $.ajax({
            type: data.type || 'POST',
            url: data.url,
            data: data.data,
            timeout: 30000,
            beforeSend: function(result) {
                $item.addClass('ajax-disabled');
                rotate = rotateStart($loading);

                if (data.beforeSend) {
                    data.beforeSend(result);
                }
            },
            success: function(result) {
                if (data.success) {
                    data.success(result);
                }
            },
            error: function(result) {
                if (data.error) {
                    data.error(result);
                }
            }
        }).always(function() {
            $item.removeClass('ajax-disabled');
            rotateStop($loading, rotate);
        });
    },
    fancybox: {
        modals: {
            standart: {
                options: {
                    maxWidth	: 800,
                    padding     : 0,
                    height		: 'auto',
                    width       : 'auto',
                    openEffect  : 'none',
                    closeEffect : 'none',
                    autoSize    : false,
                    fitToView   : false,
                    closeBtn    : false,
                    scrolling   : false
                }
            },
            auth: {
                id: '#popup_auth',
                selector: '.fancybox-popup_login',
                options: {
                    padding     : 0,
                    height		: 'auto',
                    width       : 'auto',
                    openEffect  : 'none',
                    closeEffect : 'none',
                    autoSize    : false,
                    fitToView   : false,
                    closeBtn    : false,
                    beforeClose : function() {
                        $('.popup .popup__error').empty().hide();
                        $('.popup .item .input').removeClass('error');
                        $('.popup .item .input-error').empty().hide();
                    },
                    afterShow: function() {
                        if (this.href === '#popup_auth') {
                            $('#popup_auth input[name="login"]').focus();
                        } else if (this.href === '#popup_registration') {
                            $('#popup_registration input[name="email"]').focus();
                        } else if (this.href === '#popup_pwd_remind') {
                            $('#popup_pwd_remind input[name="email"]').focus();
                        }
                    }
                },
                onInit: function() {
                    $(this.selector).fancybox(this.options);
                },
                open: function(title, successUrl) {
                    var $container = $(this.id);

                    successUrl = successUrl || null;
                    title = title || null;

                    if(successUrl) {
                        $container.find('input[name=success_url]').val(successUrl);
                    }
                    if(title) {
                        $container.find('h3').html(title);
                    }

                    $.fancybox.open(this.id, this.options);
                }
            },
            media: {
                selector: '[data-video="fancybox"]',
                options: {
                    openEffect  : 'none',
                    closeEffect : 'none',
                    type        : 'iframe',
                    helpers : {
                        media : {}
                    },
                    closeBtn: false,
                    beforeShow: function(){
                        this.skin.append('<div class="fancyboxClose"></div>');
                    }
                },
                onInit: function() {
                    $(this.selector).fancybox(this.options);
                }
            }
        },
        open: function(id) {
            $.fancybox.open({href: '#' + id}, Bm.fancybox.modals.standart.options);
        }
    },
    search: {
        show: function($el) {
            if ($el && $el.hasClass('js-disabled')) {
                return false;
            }

            var $popup = $('.search-popup_block'),
                $overlay = $('.search-overlay'),
                $body = $('body'),
                $input = $popup.find('.search-popup_input'),
                pageScrollTop = document.documentElement.scrollTop || document.body.scrollTop;

            $body.css({'overflow': 'hidden'}).scrollTop(pageScrollTop);

            $popup.removeClass('hidden');
            $overlay.removeClass('hidden');
            $input.focus();
        },
        hide: function() {
            var $popup = $('.search-popup_block'),
                $overlay = $('.search-overlay'),
                $body = $('body');

            $body.css('overflow', 'auto');

            $popup.addClass('hidden');
            $overlay.addClass('hidden');
        }
    },
    menu: {
        show: function() {
            $('body').addClass('position-fixed');
            $('.header-menu-overlay').show();
            $('.header-entry-left-main-block').show().animate({
                'marginLeft' : '-500px',
                'opacity' : '1'
            }, 200);
        },
        hide: function() {
            $('body').removeClass('position-fixed');
            $('.header-entry-left-main-block').animate({
                'opacity' : '0',
                'marginLeft' : '-100%'
            }, 200);
            $('.header-menu-overlay').hide(200);
        }
    },
    switch: {

    }
};

Bm.ab = (function(module) {
    var abPages = [];

    module.addPage = function(id, pages) {
        if(abPages[id]) {
            console.log('AbTest ' + id + ' already registered');
        } else {
            abPages[id] = pages;
        }
    };

    module.invokeTest = function(testId, pageId, request) {
        if(!abPages[testId]) {
            console.log('AbTest ' + testId + 'not register')
        } else {
            abPages[testId][pageId](request);
        }
    };

    return module;
}(Bm.ab || {}));
/**
 * Глобальный файлик для подключения обработчиков
 */

$(function() {

    /**
     * Вернуться назад
     */
    $('.js-return-back').on('click', function() {
        if (history.length && history.length > 2) {
            history.back();

            return false;
        }
    });

});
function commentReply(obj){
    $(obj).parent().after($('.comment_re').removeClass('hidden'));
    return false;
}

// hint
function hintsShow(id){
    var $hints = $('#hints');

    $('body').addClass('overflow-hidden').addClass('position-fixed');
    $hints.show();
    $hints.find('.hint' + id).show();
}
function hintsHide(){
    $('body').removeClass('overflow-hidden').removeClass('position-fixed');
    $('#hints').hide();
}

// rotate
function rotateStart($item) {
    var rotate,
        deg = 0;

    rotate = setInterval(function() {
        deg--;

        if (deg === -360) {
            deg = 0;
        }

        $item.css({
            '-ms-transform': 'rotate(' + deg + 'deg)',
            '-o-transform': 'rotate(' + deg + 'deg)',
            '-moz-transform': 'rotate(' + deg + 'deg)',
            '-webkit-transform': 'rotate(' + deg + 'deg)',
            'transform': 'rotate(' + deg + 'deg)'
        });
    }, 1);

    return rotate;
}

function rotateStop($item, rotate) {
    var deg = 0;

    $item.css({
        '-ms-transform': 'rotate(' + deg + 'deg)',
        '-o-transform': 'rotate(' + deg + 'deg)',
        '-moz-transform': 'rotate(' + deg + 'deg)',
        '-webkit-transform': 'rotate(' + deg + 'deg)',
        'transform': 'rotate(' + deg + 'deg)'
    });

    clearInterval(rotate);
}

/**
 * Process auto request
 *
 * @param $el
 */
function processAutoRequest($el)
{

    var event_id = $el.data('event'),
        product_id = $el.data('product'),
        redirect = $el.data('redirect') ? $el.data('redirect') : window.location.pathname,
        isWebinar = $el.data('webinar') ? true : false;

    var showLoading = function() {
        $.fancybox('Идет обработка запроса', {
            modal: true,
            overlayColor: "#000000",
            overlayOpacity: 0.5,
            padding: 50,
            centerOnScroll: true,
            closeBtn: false,
            beforeShow: function(){
                this.skin.append('<div class="fancyboxClose"></div>');
            }
        });
    };

    $.ajax({
        url: '/request/auto/',
        data: {
            event_id: event_id,
            product_id: product_id
        },
        type: 'POST',
        beforeSend: showLoading,
        success: function(response) {
            console.log(response);
            if(response.errorCode == 1 || response.errorCode == 2) {
                if (isWebinar) {
                    window.location = redirect + "?requestId=" + response.requestId + '&requestHash=' + response.requestHash;
                } else {
                    window.location = redirect + "?request=" + response.requestId + "&security_code=" + response.securityCode;
                }
            } else {
                window.location = $this.attr('href');
            }
        }
    });
}

/**
 * Strip tags (used for wysiwig)
 *
 * @param str
 * @param allowed_tags
 *
 * @returns {*}
 */
function strip_tags (str, allowed_tags) {

    var key = '', allowed = false;
    var matches = [];
    var allowed_array = [];
    var allowed_tag = '';
    var i = 0;
    var k = '';
    var html = '';
    var replacer = function (search, replace, str) {
        return str.split(search).join(replace);
    };

    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
    }

    str += '';

    matches = str.match(/(<\/?[\S][^>]*>)/gi);

    for (key in matches) {
        if (isNaN(key)) {
            continue;
        }

        html = matches[key].toString();
        allowed = false;

        for (k in allowed_array) {
            allowed_tag = allowed_array[k];
            i = -1;

            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}

            if (i == 0) {
                allowed = true;
                break;
            }
        }

        if (!allowed) {
            str = replacer(html, "", str); // Custom replace. No regexing
        }
    }

    return str;

}

$(function(){
    Bm.isMobile = $('body').hasClass('mobile');

    // new submit form (auth, callback, etc...)
    $(document).on('click', '.js-form-submit', function() {
        $(this).parents('form').submit();
    });

    // assetic
    $(document).on('click', '.js-admin-assetic', function() {
        var $button = $(this),
            $url = $(this).data('url'),
            $theme = $(this).data('theme'),
            $layout = $(this).data('layout');

        if ($button.hasClass('disabled')) {
            return false;
        }

        $button.removeClass('error success');

        $.ajax({
            type: 'POST',
            url: $url,
            data: {
                theme: $theme,
                layout: $layout
            },
            beforeSend: function() {
                $button.addClass('disabled');
            },
            success: function (data) {
                $button.removeClass('disabled')
                if (data.status == 'success') {
                    $button.addClass('success');
                } else {
                    $button.addClass('error');
                }
            },
            error: function() {
                $button.removeClass('disabled').addClass('error');
            }
        });
    });

    // form select
    $(document).on('click', '.js-form-select', function() {
        var find = $(this).hasClass('js-find'),
            item = find ? $(document).find('.js-form-select[data-select="' + $(this).data('select')+ '"]') : $(this),
            block = item.parents('.js-form-block'),
            select = item.data('select'),
            form = block.find($('.js-form[data-form="' + select + '"]'));

        item.addClass('active').siblings().removeClass('active');
        form.removeClass('hidden').siblings().addClass('hidden');
    });

    // scroll top
    $(document).on('load scroll', function() {
        var scrollTop = $(document).scrollTop();

        if (scrollTop > 600) {
            $('.head_top .head_top-scroll').fadeIn(300);
        } else {
            $('.head_top .head_top-scroll').fadeOut(300);
        }
    });
    $(document).on('click', '.head_top .head_top-scroll', function() {
        $('html, body').animate({
            scrollTop: 0
        }, 300);
    });

    // Script for tooltip Pop-Up (Begin)
    $(document).on('mouseenter', '.js-callback_tooltip', function(){
       $('.tooltip-callback').show();
    });
    $(document).on('mouseleave', '.js-callback_tooltip', function(){
        $('.tooltip-callback').hide();
    });
    // Script for tooltip Pop-Up (End)


    for(var type in Bm.fancybox.modals) {
        if(Bm.fancybox.modals[type].hasOwnProperty('onInit')) {
            Bm.fancybox.modals[type]['onInit']();
        }
    }

    Bm.ab.addPage(1000, {
        js_main: function(request) {
            console.log(request);
            if(request['emailLink']) {
                var $abButton = $('#popup_main_done_email');
                $abButton.find('.email-link-js').attr('href', request['emailLink']);
                Bm.fancybox.open($abButton.attr('id'));
            } else {
                Bm.fancybox.open('popup_main_done');
            }
        },
        js_redirect: function(request) {
            window.location.href = request['redirect']
        }
    });

    // close hints
    $(document).on('click', '#hints', function(){
        hintsHide();
    });

    // city tooltip
    $(document).on('click', '.head_city .tooltip .close', function(){
        $(this).parents('.tooltip').hide();
    });

    // custom fancybox close button
    $(document).on('click', '.fancyboxClose, .js-popup-close', function(){
        $.fancybox.close()
    });

    // applause
    $(document).on('mouseenter', '.check-in-js .clap.active', function(){
        var clap = $(this);
        var profit = $(this).next('.profit');

        if(profit.length == 0){
            return false;
        }
        $('.check-in-js .tooltip').hide();
        if(!profit.hasClass('active')){
            clap.children('.tooltip').show()
        }

    });
    $(document).on('mouseleave', '.check-in-js .clap.active', function(){
        var self = this;
        setTimeout(function(){
            $(self).children('.tooltip').hide();
        }, 500);
    });
    $(document).on('click', '.check-in-js .clap', function(e){
        var clap = $(this),
            profit = $(this).next('.profit'),
            url = clap.data('url'),
            redirect = clap.data('redirect'),
            $item = $('.check-in-js .clap[data-url="' + url + '"]'),
            $counter = $item.find('[data-like-counter="' + url + '"]');

        if (clap.hasClass('disabled')) {
            if (Bm.isMobile) {
                Bm.mobile.popup.show('login');
            } else {
                Bm.fancybox.modals.auth.open(null, redirect);
            }

            return false;
        }

        if ($(e.target).closest('.tooltip').length == 1 && !profit.hasClass('active')) {
            profit.trigger('click');

            return false;
        }

        if (clap.hasClass('active')) {
            $.ajax({
                type: 'GET',
                url: url,
                data: {direction: 0},
                success: function(data){
                    if (!data.status || data.status !== 'ok') {
                        return false;
                    }
                    profit.addClass('disabled');

                    $item.removeClass('active');
                    $counter.text(data.count);

                    clap.children('.tooltip').hide()
                }
            });
        } else {
            $.ajax({
                type: 'GET',
                url: url,
                data: {direction: 1},
                success: function(data){
                    if (!data.status || data.status !== 'ok') {
                        return false;
                    }
                    profit.removeClass('disabled');

                    $item.addClass('active');
                    $counter.text(data.count);

                    if (profit.length != 0 && !profit.hasClass('active')) {
                        clap.children('.tooltip').show();
                    }
                }
            });
        }

        return false;
    });

    // profit
    $(document).on('click', '.check-in-js .profit', function(){
        var profit = $(this);
        var clap = profit.prev('.clap');
        var url = profit.data('url');
        var redirect = clap.data('redirect');

        if(profit.hasClass('disabled')){
            return false;
        }

        if(profit.hasClass('active')){
            if(confirm('Вы больше не считаете материал полезным?')){

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {direction: 0},
                    success: function(data){
                        if(!data.status || data.status !== 'ok'){
                            return false;
                        }

                        profit.removeClass('active');
                        $('[data-like-counter="' + url + '"]').text(data.count);
                    }
                });
            }
        } else {
            if(confirm('Вы действительно хотите отметить материал как полезный?')){

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {direction: 1},
                    success: function(data){
                        if(!data.status || data.status !== 'ok'){
                            return false;
                        }

                        profit.addClass('active');
                        $('[data-like-counter="' + url + '"]').text(data.count);
                        profit.prev('.clap').children('.tooltip').hide();

                        if(data.record_likes_count){
                            clap.addClass('active');
                            clap.children('span').text(data.record_likes_count);
                        }
                    }
                });
            }
        }
    });

    // textarea autoresize
    if($.fn.autosize){
        $('#opros textarea, textarea.autosize').autosize();
    }

    // custom select
    if($.fn.selectbox){
        $('select.selectbox').selectbox();
    }

    // Case block
    $(document).on('click', '.caseBlock .caseReadmore', function(){
        var caseBlock = $(this).parents('.caseBlock');

        if($(this).hasClass('hide')){
            caseBlock.find('.caseFullText').fadeOut(600);
            $(this).text('Читать далее').removeClass('hide');

            $('html, body').animate({
                scrollTop: caseBlock.offset().top
            }, 600);
        } else {
            caseBlock.find('.caseFullText').fadeIn(600);
            $(this).text('Скрыть текст').addClass('hide');

            $('html, body').animate({
                scrollTop: caseBlock.find('.caseFullText').offset().top
            }, 600);
        }
    });

    // Placeholder fake
    $('.clean_area').focus(function () {
        $(this).removeClass('clean_area');
        $(this).html('');
    });

    // SMI video gallery
    $(document).on('click', '.b_video_gallery li', function(e){
        var th = $(this);
        if (!th.hasClass('active') ){
            th.addClass('active').siblings().removeClass('active');
            th.closest('.b_video_gallery-list').siblings('.b_video_gallery-current').html(th.children('.data').html());
        }

        if(e.hasOwnProperty('originalEvent')){
            $('html, body').animate({
                scrollTop: $(this).parents('.b_video_gallery').offset().top
            }, 600);
        }
    });
    $('.b_video_gallery li').eq(0).trigger('click');


    var Form = function() {
        var $form = null;
        var need_sms_activation = false;
        var submitted = 1;
        var urls = [
            '/request/only_register/',
            '/request/new/'
        ];

        var redirect_choices = {
            0: '/accept/',
            1: '/accept/',
            2: window.location.pathname + 'success/',
            3: window.location.pathname + 'success/'
        };
        var redirect_choice = 1;

        this.init = function(element) {
            $form = $(element);
            if($form.find("input[name=need_redirect]").val() != 0) {
                redirect_choice = $form.find("input[name=need_redirect]").val();
            }
            if($form.has('[data-sms]').length) {
                need_sms_activation = true;
                submitted = 0;
            }

            $form.find('[name=eventChanger]').change(function(){
                if ($(this)[0].tagName == 'SELECT') {
                    var $selectInput = $(this);
                    $.each($selectInput.find(':selected').data(), function(k, v){
                        $selectInput.data(k, v);
                    });
                }
                $form.find('input[name="event_id"]').attr('value', $(this).data('event'));
                $form.find('input[name="product_id"]').attr('value', $(this).data('product'));
                $form.find('input[name="redirect"]').attr('value', $(this).data('redirect'));
                $form.find('input[name="need_redirect"]').attr('value', $(this).data('need_redirect'));
            });

            $form.attr('onsubmit', '');
            $form.on('submit', function(e){
                if ($form.find('select[name=eventChanger]').length && !$form.find('select[name=eventChanger]').data('product')) {
                    alert('Вы должны выбрать город');
                    return false;
                }

                if ($form.attr('target') == '_blank') {

                    // Проверяем параметр формы
                    if (!checkValidation()) {
                        return false;
                    }

                    // Передаем управление в форму
                    return true;
                } else {
                    submitMainForm();
                }

                return false;
            });

            $('[data-updatecaptcha]').live('click', function(e){
                e.preventDefault();
                updateCaptcha();
            });

            $('[data-resendsms]').live('click', function(e){
                e.preventDefault();
                updatePhoneArea();
            });

        };

        var updatePhoneArea = function() {
            $form.find('input[name=firstname]').attr('readonly', 'readonly');
            $form.find('input[name=email]').attr('readonly', 'readonly');

            $.ajax({
                cache: false,
                url: '/request/phone_activation/',
                type: 'POST',
                timeout: 10000,
                data: {
                    phone_country: $form.find('input[name=phone_country_code]').val(),
                    phone_code: $form.find('input[name=phone_code]').val(),
                    phone: $form.find('input[name=phone]').val(),
                    page_id: $form.find('input[name=event_id]').val()
                },
                success: fillPhoneArea,
                error: showTimeoutError
            });
        };

        var fillPhoneArea = function(data) {
            hideLoading();
            if(data.status == 'success') {
                $form.find('[data-sms]').html(data.message);
            } else {
                $.fancybox(data.message, {
                    overlayColor: "#000000",
                    overlayOpacity: 0.5,
                    padding: 50,
                    closeBtn: false,
                    beforeShow: function(){
                        this.skin.append('<div class="fancyboxClose"></div>');
                    }
                });
            }

            var submitButton = $form.find('button[type=submit]');
            $form.off('submit');
            $(submitButton).text('Отправить');

            if ($form.find('.user-captcha').length) {
                $form.on('submit', function(e) {
                    e.preventDefault();
                    submitCaptchaForm();
                });
            } else if ($form.find(".activation_phone_accepted").length) {
                $(submitButton).hide();
                submitted = 1;
                submitMainForm();
            } else {
                $form.on('submit', function(e) {
                    e.preventDefault();
                    submitPhoneActivationForm();
                });
            }
        };

        var updateCaptcha = function() {
            var src = $form.find('.user-captcha').attr('src') + '?rnd=' + Math.random();
            $form.find('.user-captcha').attr('src', src);
        };

        var showLoading = function() {
            $.fancybox('Идет обработка запроса', {
                modal: true,
                overlayColor: "#000000",
                overlayOpacity: 0.5,
                padding: 50,
                centerOnScroll: true,
                closeBtn: false,
                beforeShow: function(){
                    this.skin.append('<div class="fancyboxClose"></div>');
                }
            });
        };

        var showTimeoutError = function(message, errorCode) {
            ga_product_type = $form.find("input[name=product_type]").val();
            ga_product_name = "product_"+ $form.find("input[name=product_id]").val();
            ga('send','event','form_send_mistake',ga_product_type,ga_product_name);
            if(message instanceof Object) {
                message = 'Попробуйте отправить форму повторно';
            }
            message = message || 'Попробуйте отправить форму повторно';
            title = 'Извините, произошла ошибка.<br>'
            if(errorCode) {
                if(errorCode == 6) {
                    title = 'Операция выполнена успешно.<br/>'
                }
            }
            setTimeout(function() {
                $.fancybox(title + message, {
                    overlayColor: "#000000",
                    overlayOpacity: 0.5,
                    padding: 50,
                    closeBtn: false,
                    beforeShow: function(){
                        this.skin.append('<div class="fancyboxClose"></div>');
                    }
                });
            }, 300);

        };

        var hideLoading = function() {
            setTimeout(function() {
                $.fancybox.close();
            }, 300);
        };

        var submitCaptchaForm = function() {
            if (!checkValidation()) {
                return false;
            }

            $.ajax({
                cache: false,
                url: '/request/phone_activation/',
                type: 'POST',
                timeout: 10000,
                data: {
                    phone_country: $form.find('input[name=phone_country_code]').val(),
                    phone_code: $form.find('input[name=phone_code]').val(),
                    phone: $form.find('input[name=phone]').val(),
                    captcha: $form.find('input[name=captcha]').val(),
                    page_id: $form.find('input[name=event_id]').val(),
                    confirm_captcha: 1
                },
                beforeSend: showLoading,
                success: fillPhoneArea,
                error: showTimeoutError
            });
        };

        var submitPhoneActivationForm = function() {
            if (!checkValidation()) {
                return false;
            }

            $.ajax({
                cache: false,
                url: '/request/phone_activation/',
                type: 'POST',
                timeout: 10000,
                data: {
                    code: $form.find('input[name=phone_activation_code]').val(),
                    activation_id: $form.find('input[name=phone_activation_id]').val(),
                    confirm_form_send: 1
                },
                beforeSend: showLoading,
                success: fillPhoneArea,
                error: showTimeoutError
            });
        };

        var submitMainForm = function() {

            if (!checkValidation()) {
                ga_product_type = $form.find("input[name=product_type]").val();
                ga_product_name = "product_"+ $form.find("input[name=product_id]").val();
                ga('send','event','form_send_mistake',ga_product_type,ga_product_name);
                return false;
            }

            $.ajax({
                cache: false,
                url: urls[submitted],
                timeout: 10000,
                type: 'POST',
                data: $form.serialize(),
                beforeSend: showLoading,
                success:  parseRequest,
                error: showTimeoutError
            });

            return true;
        };

        /**
         * Проверка валидации
         *
         * @returns boolean
         */
        var checkValidation = function() {
            return Validator.isValid($form);
        };

        var parseRequest = function(request) {
            ga_product_type = $form.find("input[name=product_type]").val();
            ga_product_name = "product_"+ $form.find("input[name=product_id]").val();
            if (request['redirect_system'] !== undefined && request['redirect_system'] != '') {
                ga('send','event','form_send',ga_product_type,ga_product_name);
                ga('send', 'pageview', '/form_send/');
                window.location = request['redirect_system'];
                return;
            }

            redirect_choice = $form.find("input[name=need_redirect]").attr('value');
            if (request.errorCode == 0 || request.errorCode == 3 || request.errorCode == 6 || request.errorCode == 8 || request.errorCode == 9) {
                showTimeoutError(request['errorMessage'], request.errorCode);
            } else if (request.errorCode == 5) {
                ga('send','event','form_send_mistake',ga_product_type,ga_product_name);
                // Специальный режим, при котором запрещено покупать продукт - отправляем на страницу /fail/
                window.location = 'http://' + window.location.hostname + window.location.pathname + 'fail/';
            } else {
                if((need_sms_activation == true) && (submitted == 0)) {
                    $.fancybox.close();
                    updatePhoneArea();
                } else {
                    var redirect = $form.find("input[name=redirect]").val();
                    if(redirect == '') {
                        redirect = redirect_choices[redirect_choice];
                    }
                    ga('send','event','form_send',ga_product_type,ga_product_name);
                    ga('send', 'pageview', '/form_send/');
                    switch(redirect_choice) {
                        case '4':
                            var href = redirect + '?' + $.param({
                                    name:  $form.find("input[name=firstname]").val(),
                                    tel: $form.find("input[name=phone_code]").val() + $form.find("input[name=phone]").val(),
                                    mail: $form.find("input[name=email]").val(),
                                    client_id: request.userId
                                });
                            console.log(href);
                            $.fancybox.open(
                                {
                                    type: 'iframe',
                                    fitToView: false,
                                    width: 940,
                                    height: 580,
                                    padding: 0,
                                    margin: 20,
                                    autoSize: false,
                                    closeClick: false,
                                    openEffect: 'none',
                                    closeEffect: 'none',
                                    wrapCSS: 'intickets',
                                    helpers: {
                                        overlay : {
                                            closeClick : false
                                        }
                                    },
                                    href : href
                                }
                            );
                            break;
                        case '3':
                            $.ajax({
                                url: redirect,
                                type: 'GET',
                                data: {email: $form.find("input[name=email]").val()},
                                timeout: 10000,
                                complete: function(response, responseStatus) {
                                    $.fancybox.close();
                                    if(responseStatus == 'success') {
                                        $form.next().remove();
                                        $form.next().remove();
                                        $form.replaceWith(response.responseText);
                                    } else {
                                        alert('Произошла ошибка, попробуйте позже');
                                    }
                                }
                            });
                            break;
                        case '2':
                            // #4874 для ссылок, которые содержат в себе get-параметры, не надо добавлять email
                            if (redirect.indexOf('?category_id') >= 0) {
                                window.location = redirect;
                            } else {
                                window.location = redirect + "?requestId=" + request.requestId + '&requestHash=' + request.requestHash;
                            }
                            break;
                        case '1':
                        default:
                            window.location = redirect + "?request=" + request.requestId + "&security_code=" + request.securityCode;
                    }
                }
            }
        }
    };


    $('form[data-form=request]').each(function() {
        new Form().init(this);
    });


    $('[data-widget=timer]').each(function(){
        var t = this;
        var wr_hours = function() {
            var oToday = new Date();
            //var sTime = "December 11, 2012 12" +  ":15" + ":00"; //до какого числа таймер
            // задаём время с точностью до секунды — это не педантизм,
            // а важная деталь, избавляющая от багов при вычислении разницы между датами
            var sTime = $(t).data('timer');
            var oDeadLineDate = new Date(sTime); // собственно устанавливаем «час Икс»
            var sek = Math.floor((oDeadLineDate - oToday) / 1000);
            if(sek <= 0 && sek >= -2) {
                window.location = window.location.pathname;
                return false;
            }
            var sec= sek % 60 ; //сколько секунд осталось
            var min= Math.floor((sek /60)%60) ;//сколько минут осталось
            var hoursek= Math.floor((sek / (60*60)) %24) ;//сколько часов осталось
            var days= Math.floor(sek /(24*60*60)) ;//сколько дней осталось
            var time_wr= "" +days+"д. "+hoursek+"ч. " +min+"м. " +sec+"с.";
            if (days > 31) {
                time_wr= ""+(days-30)+"д. "+hoursek+"ч. " +min+"м. " +sec+"с.";
            }
            $(t).html(time_wr);
        };
        setInterval(wr_hours, 1000);
    });

    $('form[data-form=event-check]').submit(function () {
        var $t = $(this);
        if(!Validator.isValid($t)) {
            return false;
        }

        var email = $t.find('input[name=email]').val();
        var redirect = $t.find("input[name=redirect]").val();
        var redirect_choice = $t.find("input[name=need_redirect]").attr('value');
        if(redirect == '') {
            redirect = window.location.pathname + 'success/';
        }

        $.fancybox('Идет обработка запроса', {
            modal: true,
            overlayColor: "#000000",
            overlayOpacity: 0.5,
            padding: 50,
            centerOnScroll: true,
            closeBtn: false,
            beforeShow: function(){
                this.skin.append('<div class="fancyboxClose"></div>');
            }
        });

        $.ajax({
            cache: false,
            url: $t.attr('action'),
            timeout: 10000,
            type: 'POST',
            data: $t.serialize(),

            success:  function (data) {
                setTimeout(function() {
                    $.fancybox.close();
                }, 300);
                if (data.status == 'success') {
                    if (redirect_choice == 3) {
                        $.ajax({
                            url: redirect,
                            type: 'GET',
                            data: {email: email},
                            timeout: 10000,
                            complete: function(response, responseStatus) {
                                $.fancybox.close();
                                if(responseStatus == 'success') {
                                    $t.prev().remove();
                                    $t.prev().remove();
                                    $t.replaceWith(response.responseText);
                                } else {
                                    alert('Произошла ошибка, попробуйте позже');
                                }
                            }
                        });
                    } else {
                        // #4874 для ссылок, которые содержат в себе get-параметры, не надо добавлять email
                        if (redirect.indexOf('?category_id') >= 0) {
                            window.location = redirect;
                        } else {
                            window.location.href = redirect + "?requestId=" + data.message.requestId + '&requestHash=' + data.message.requestHash;
                        }
                    }
                } else if (data.status == 'message') {
                    $t.find('.email-response').addClass('success').html(data.message);
                } else {
                    $t.find('.email-response').removeClass('success').html(data.message);
                }
            },
            error: function(data) {
                setTimeout(function() {
                    $.fancybox('Извините, произошла ошибка. <br />Попробуйте отправить форму позднее', {
                        overlayColor: "#000000",
                        overlayOpacity: 0.5,
                        padding: 50,
                        closeBtn: false,
                        beforeShow: function(){
                            this.skin.append('<div class="fancyboxClose"></div>');
                        }
                    });
                }, 300);
            }
        });
        return false;
    });

    $('select[data-action="selectPriceByCity"]').on('change', function() {

        var cityId = $(this).val();

        var callback = function(el) {
            var productId = $(el).data('product-id');
            var eventId = $(el).data('event-id');
            var cityId = $(el).val();
            var cityName = $(el).find(':selected').text();
            var parentBlock = 'span.js-city-price-main-block',
                cityBlock = 'span.js-change-city-name_span i',
                priceBlock = 'span[data-price="true"]',
                loaderBlock = '.js-form-price-loader-block';

            $(self).parents(parentBlock).find(priceBlock).hide();
            $(self).parents(parentBlock).find(loaderBlock).css('display', 'inline-block');

            $.ajax({
                url: $(el).data('url'),
                type: 'POST',
                data: {
                    product_id: productId,
                    event_id: eventId,
                    city_id: cityId
                },
                success: function(data) {
                    $(el).parents(parentBlock).find(priceBlock).show();
                    $(el).parents(parentBlock).find(loaderBlock).hide();
                    $(el).parents(parentBlock).find(priceBlock).text(data.price);
                    $(el).parents(parentBlock).find(cityBlock).text(cityName);
                    $(el).parents('form').find('input[name="event_id"]').val(data.event_id);
                    $(el).parents('form').find('input[name="product_id"]').val(productId);
                }
            });
        };

        callback(this);

        // Выбираем такой же блок на всех доступных селектах
        $('select[data-action="selectPriceByCity"]').not(this).each(function(index) {

            if ($(this).val() != cityId) {
                $(this).find('option[value=' + cityId + ']').attr('selected', 'selected');
                callback(this);
            }
        });

    });

    $('form[data-form=svyaz]').submit(function(){
        var $form = $(this);
        if(!Validator.isValid($form)) {
            return false;
        }

        $.fancybox('Идет обработка запроса', {
            modal: true,
            overlayColor: "#000000",
            overlayOpacity: 0.5,
            padding: 50,
            centerOnScroll: true,
            closeBtn: false,
            beforeShow: function(){
                this.skin.append('<div class="fancyboxClose"></div>');
            }
        });

        $.post(
            '/request/svyaz/',
            $form.serialize(),
            function (data) {

                var captchaImage = $form.find('.captchaImage');
                var captchaBlock = $form.find('.captchaBlock');
                var captchaWord = $form.find('.captchaWord');
                var captchaCode = $form.find('.captchaCode');

                if ('status' in data && data['status'] == 'error') {
                    $.fancybox.close();

                    var message = data['rawMessage'];
                    if((data['rawMessage']) instanceof Array) {
                        message = data['rawMessage'].shift();
                    }
                    if (!message) {
                        message = data['message'];
                    }
                    var $input2 = $form.find('input').eq(0);

                    if ('captcha_url' in data) {
                        if (captchaBlock.is(':visible')) {
                            $('#svyazErrorBlock').text(message);
                        }

                        captchaImage.attr('src', data['captcha_url']);
                        captchaBlock.removeClass('hidden');
                        if (data['wrong_code']) {
                            captchaWord.addClass('error').focus();
                        }
                        $form.find('.captchaCode').val(data);
                        captchaWord.val('');
                    }
                    else {
                        captchaWord.removeClass('error').val('');
                        captchaBlock.addClass('hidden');
                        captchaCode.val('');

                        $('#svyazErrorBlock').empty();
                    }
                }
                else {
                    $form.find('.error-text').remove();
                    $form.removeClass('alert');
                    $form.find('input').removeClass('error');
                    $('#svyazErrorBlock').empty();

                    captchaBlock.addClass('hidden');
                    captchaWord.removeClass('error').val('');
                    captchaCode.val('');

                    if ($form.find('input[name="product_id"]').val() == 68 && $form.find('input[name="event_id"]').val() == 1076461) {
                        var name = $form.find('input[name="name"]').val();
                        var email = $form.find('input[name="email"]').val();
                        var phone = $form.find('input[name="phone_country"]').val() + $form.find('input[name="phone_code"]').val() + $form.find('input[name="phone"]').val();

                        var amoForm = $('.amoForm');
                        amoForm.find('input[name="name"]').val(name);
                        amoForm.find('input[name="email"]').val(email);
                        amoForm.find('input[name="phone"]').val(phone);
                        amoForm.find('input[name="packet"]').val(1);
                        $.post(
                            amoForm.attr('action'),
                            amoForm.serialize()
                        );
                    } else if ($form.find('input[name="product_id"]').val() == 68 && $form.find('input[name="event_id"]').val() == 1076460) {
                        var name = $form.find('input[name="name"]').val();
                        var email = $form.find('input[name="email"]').val();
                        var phone = $form.find('input[name="phone_country"]').val() + $form.find('input[name="phone_code"]').val() + $form.find('input[name="phone"]').val();

                        var amoForm = $('.amoForm');
                        amoForm.find('input[name="name"]').val(name);
                        amoForm.find('input[name="email"]').val(email);
                        amoForm.find('input[name="phone"]').val(phone);
                        amoForm.find('input[name="packet"]').val(2);
                        $.post(
                            amoForm.attr('action'),
                            amoForm.serialize()
                        );
                    }

                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }

                    if($form.find('input[name="redirect"]').length > 0) {
                        window.location.href = $form.find('input[name="redirect"]').val();
                        return;
                    }

                    if ($form.find('input[name="product_id"]').val() == 585) {

                        var name = $form.find('input[name="name"]').val();
                        var email = $form.find('input[name="email"]').val();
                        var phone = $form.find('input[name="phone_country"]').val() + $form.find('input[name="phone_code"]').val() + $form.find('input[name="phone"]').val();

                        var amoForm = $('.amoForm');
                        amoForm.find('input[name="first_name"]').val(name);
                        amoForm.find('input[name="email"]').val(email);
                        amoForm.find('input[name="phone"]').val(phone);

                        amoForm.submit();
                    }

                    setTimeout(function() {
                        $.fancybox(data.message, {
                            overlayColor: "#000000",
                            overlayOpacity: 0.5,
                            padding: 50,
                            centerOnScroll: true,
                            closeBtn: false,
                            beforeShow: function(){
                                this.skin.append('<div class="fancyboxClose"></div>');
                            }
                        });
                    }, 300);
                }
            }, 'json'
        );
        return false;
    });

    $('.enterForm .loginForm').find('form').submit(function(){
        var $self = $(this);

        if(!Validator.isValid($self)) {
            $self.find('.error').html(Validator.lastError);
            return false;
        }

        $.ajax({
            type: 'POST',
            url: $self.attr('action'),
            crossDomain: true,
            data: {
                login      : $self.find("input[name='login']").val(),
                password   : $self.find("input[name='password']").val()
            },
            dataType: 'json',
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(responseData, textStatus, jqXHR) {
                if (responseData.status == 'success')
                {
                    var success_url = $self.find('input[name=success_url]').val();
                    if (success_url != '') {
                        window.location = success_url;
                    } else {
                        window.location.reload();
                    }
                }
                else
                {
                    $self.find('.error').text(responseData.message).show();
                }
            },
            error: function (responseData, textStatus, errorThrown) {
                $self.find('.error').hide();
            }
        });

        return false;
    });

    $('.enterForm .recForm').find('form').submit(function(){
        var $self = $(this);

        if(!Validator.isValid($self)) {
            $self.find('.error').html(Validator.lastError);
            return false;
        }

        $.ajax({
            type: 'POST',
            url: $self.attr('action'),
            crossDomain: true,
            data: {
                email: $self.find("input[name='email']").val()
            },
            dataType: 'json',
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(responseData, textStatus, jqXHR) {
                if (responseData.status == 'success') {
                    $self.parents('.recForm').html('<p class="ta_c">' + responseData.message + '</p>');
                } else {
                    $self.find('.error').text(responseData.message).show();
                }
            },
            error: function (responseData, textStatus, errorThrown) {
                $self.find('.error').hide();
            }
        });

        return false;
    });

    $('.enterForm .regForm').find('form').submit(function(){
        var $self = $(this);

        if(!Validator.isValid($self)) {
            $self.find('.error').html(Validator.lastError);
            return false;
        }

        $self.find("input[type='submit']").attr('disabled','disabled');

        $.ajax({
            type: 'POST',
            url: $self.attr('action'),
            crossDomain: true,
            data:  $self.serialize(),
            dataType: 'json',
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(responseData, textStatus, jqXHR) {
                if (responseData.status == 'success') {
                    $self.parents('.regForm').html('<p class="ta_c">Проверьте свою электронную почту.</p>');
                } else {
                    $self.find('.error').text(responseData.message).show();
                }

            },
            error: function (responseData, textStatus, errorThrown) {
                $self.find('.error').hide();
            }
        });
        $self.find("input[type='submit']").removeAttr('disabled');

        return false;
    });

    $(document).on('click', '.enterForm .showLoginForm', function(){
        $(this).parents('.enterForm').children('.oneForm').hide();
        $(this).parents('.enterForm').children('.loginForm').show();
    });
    $(document).on('click', '.enterForm .showRegForm', function(){
        $(this).parents('.enterForm').children('.oneForm').hide();
        $(this).parents('.enterForm').children('.regForm').show();
    });
    $(document).on('click', '.enterForm .showRecForm', function(){
        $(this).parents('.enterForm').children('.oneForm').hide();
        $(this).parents('.enterForm').children('.recForm').show();
    });

    // Banners entry
    // #3984
    $(function(){
        $(".l_banners").each(function(){
            var banners = $(this).children().hide();
            banners.eq(Math.floor(Math.random() * banners.length)).show();

            //$(this).cycle({speed: 400});
        });
    });

    // #5458 Баннеры с классом js-promo-block-random ротируем через js
    $(function() {
        var jsPromoBlock = $('.js-promo-block-random');
        $(jsPromoBlock).hide();
        $(jsPromoBlock).eq(Math.floor(Math.random() * $(jsPromoBlock).length)).show();
    });

    // Col right banner toggle
    var oWindow = $(window),
        largeBanner = $(".banner-aside.large"),
        smallBanner = $(".banner-aside.small");

    if ( largeBanner.length ){
        var showOffset = largeBanner.position().top + largeBanner.height() + smallBanner.height();

        oWindow.on("scroll", function(){
            if( oWindow.scrollTop() > showOffset ){
                smallBanner.fadeIn(200);
            } else {
                smallBanner.fadeOut(200);
            }
        }).trigger("scroll");
    }

    // Carousel
    var oReadAlso = $(".l_read_also");
    if ( oReadAlso.length && $("li", oReadAlso).length > 4 ){
        oReadAlso.closest(".b_read_also").addClass("carousel_init").end().jcarousel({
            animation: 200
        });
    }
    // Footer load
    if ($('#footer_navi').length != 0)
        $( ".footer_inner" ).prepend( decodeURIComponent($('#footer_navi').html()) );

    var isCardUpdating = false;
    $('#card-block input[type=button]').click(function(){
        if ($('input[name=card]').val().length == 0)
        {
            showError('', {'card' : 'Введите номер карты'});
            return false;
        }

        if (!/(^[0-9 ]+$)/.test($('input[name=card]').val()))
        {
            showError('', {'card' : 'Неверный формат номера карты'});
            return false;
        }

        if (!isCardUpdating)
        {
            isCardUpdating = true;
            $.ajax({
                dataType: "json",
                url: '/profile/card/activate/',
                type: 'POST',
                data: $('#user-profile-form').serialize(),
                success: function(data) {
                    if (data.status == 'success') {
                        $('#card-block').html( '<p>' + data.message + '</p>' ).removeClass('message_error');
                    } else {
                        showError( data.message, data.fields );
                    }
                    isCardUpdating = false;
                },
                error: function(xhr, status) {
                    isCardUpdating = false;
                }
            });
        }


    });

    $('#card-block form').submit(function(){
        $('#card-block input[type=button]').click();
        return false;
    });

    function showError(message, fields) {
        $('#card-block').find('p').each(function(){
            $( this).remove();
        });
        $('#card-block').prepend('<p class="message_error">' + message + '</p>');

        for(var i in fields) {
            $('input[name=' + i +']').before('<p class="message_error">' + fields[i] + '</p>');
        }
    }

    // form agreement
    $('.form-agreement').each(function() {
        var $form = $(this),
            $parent = $form.find('.js-form-agreement-parent'),
            count = $form.find('.js-form-agreement-children').length,
            countChecked = $form.find('.js-form-agreement-children:checked').length;

        if (count === countChecked) {
            $parent.prop('indeterminate', false);
            $parent.prop('checked', true);
        } else if (countChecked === 0) {
            $parent.prop('indeterminate', false);
            $parent.prop('checked', false);
        } else {
            $parent.prop('indeterminate', true);
        }
    });

    $(document).on('click', '.form-agreement .js-form-agreement-options', function() {
        $(this).parents('.form-agreement').find('.js-form-agreement-choose').toggleClass('hidden');

        return false;
    });

    $(document).on('change', '.form-agreement .js-form-agreement-children', function() {
        var $form = $(this).parents('.form-agreement'),
            $parent = $form.find('.js-form-agreement-parent'),
            count = $form.find('.js-form-agreement-children').length,
            countChecked = $form.find('.js-form-agreement-children:checked').length;

        if (count === countChecked) {
            $parent.prop('indeterminate', false);
            $parent.prop('checked', true);
        } else if (countChecked === 0) {
            $parent.prop('indeterminate', false);
            $parent.prop('checked', false);
        } else {
            $parent.prop('indeterminate', true);
        }
    });

    $(document).on('change', '.form-agreement .js-form-agreement-parent', function() {
        var $form = $(this).parents('.form-agreement');

        if ($(this).prop('checked')) {
            $form.find('.js-form-agreement-children').prop('checked', true);
        } else {
            $form.find('.js-form-agreement-choose').removeClass('hidden');
            $form.find('.js-form-agreement-children').prop('checked', false);
        }

    });
});

var Validator = {
    filters: {
        trim: function (value) {
            return jQuery.trim(value);
        },
        phoneCode: function(value) {
            if(8 == value) {
                return '+7';
            }

            var pattern = /^[0-9]{1,3}$/;
            if(pattern.test(value)) {
                return '+' + value;
            }

            return value;
        }
    },

    validators: {
        email: {
            pattern: /^(([^а-я<>()[\]\\.,;:\s@\"]+(\.[^а-я<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
            message: 'Введите корректный e-mail',
            filters: ['trim']
        },
        name: {
            pattern: /^([a-zа-яA-ZА-ЯёЁ\-0-9 ]+)$/,
            message: "Введите корректное имя",
            filters: ['trim']
        },
        lastname: {
            pattern: /^([a-zа-яA-ZА-ЯёЁ\-0-9 ]+)$/,
            message: "Введите корректную фамилию",
            filters: ['trim']
        },
        phone: {
            pattern: /^([0-9]+)$/,
            message: "Введите корректный телефон",
            filters: ['trim']
        },
        city: {
            pattern: /^([a-zа-яA-ZА-ЯёЁ\-0-9 ]+)$/,
            message: "Введите корректное название города",
            filters: ['trim']
        },
        phone_code: {
            pattern: /^(\+[0-9]{1,3})$/,
            message: "Введите корректный код страны, например, +7",
            filters: ['trim','phoneCode']
        },
        partner: {
            pattern: /^([A-Za-z0-9]+)$/,
            message: "Введите корректный код партнера",
            filters: ['trim']
        },
        sms_code: {
            pattern: /^([0-9]+)$/,
            message: "Введите корректный смс код",
            filters: ['trim']
        },
        message: {
            pattern: /(.+)/,
            message: "Введите корректное сообщение",
            filters: ['trim']
        },
        captcha: {
            pattern: /^([A-Za-z0-9]+)$/,
            message: "Введите код на картинке",
            filters: ['trim']
        }
    },

    filter : function(value, filters) {
        for(var i = 0; i < filters.length; i++) {
            var filterName = filters[i];
            value = this.filters[filterName](value);
        }

        return value;
    },

    lastError: '',

    isValid: function(element) {
        var t = this;
        var isValid = true;

        element.find('[data-validator]:enabled').each(function(){
            var type = $(this).data('validator');
            var value = $(this).attr('value');
            var show = $(this).data('validator-show');

            if(t.validators[type] != undefined) {
                if(t.validators[type]['filters'] != undefined) {
                    value = t.filter(value, t.validators[type]['filters']);
                    $(this).attr('value', value);
                }
                if(!t.validators[type].pattern.test(value)) {
                    t.lastError = t.validators[type].message;
                    if(show == 'none') {
                        //пока так, все нормально
                    } else {
                        // вместо нормальных блоков с нотификациями зачем-то нужно делать алерты................
                        //$('#svyazErrorBlock').text(t.lastError);
                        alert(t.lastError);
                    }
                    $(this).focus();
                    return isValid = false;
                }
                else {
                    $('#svyazErrorBlock').empty();
                }
            }
        });
        element.find('select.city_0306').each(function(){
           var value=$(this).val();
            if(value=="-"){
                alert("Выберете город участия");
                return isValid=false;
            }
        });
        return isValid;
    }
};

function showConfirmPersonalAlert(checked)
{
    if (!checked) {
        alert('Без согласия на обработку данных мы не можем принять заявку');
    }
}

//bm4 block!!!!

$(function() {
    var expertBlockRender = function() {
        $('.expertBlock').each(function(){
            var markerId = $(this).data('marker-block');
            var expertTop = $('[data-marker="' + markerId + '"]').offset().top + 10;
            var expertLeft = $('.post').offset().left + 525;
            $(this).css({'top' : expertTop, 'left' : expertLeft});
        });
    };

    expertBlockRender();
    $(window).resize(expertBlockRender);

    if(jQuery().sliderkit) {
        $('.topSlider').sliderkit({
            circular: false,
            mousewheel: false,
            shownavitems: 3,
            verticalnav: true,
            navclipcenter: true,
            auto: false,
            navscrollatend: true
        });
    }

    var ajaxNisha = 0;
    $(document).on('click', '.nishaBlock .one.more', function(){
        if(ajaxNisha) {
            return false;
        }
        var $this = $(this);
        $.ajax({
            url: '/ajax/random/tags/',
            type: 'POST',
            data: {
                type_id: 3,
                group_id: 3
            },
            success: function(data) {
                if(data.status == 'success') {
                    $this.siblings('.one:visible').fadeOut(600, function() {
                        var $caseBlocks= $this.siblings('.one');
                        for(var i in data.message) {
                            var $caseBlock = $caseBlocks.eq(i);
                            $caseBlock.find('img').attr('src', data.message[i]['img']);
                            $caseBlock.find('img').attr('alt', data.message[i]['name']);
                            $caseBlock.find('a').attr('href', '/case/tag/' + data.message[i]['alias'] + '/');
                            $caseBlock.find('a').text(data.message[i]['name']);
                        }
                        $(this).fadeIn(600);
                    });
                }
            },
            beforeSend: function() {
                ajaxNisha = 1;
            },
            complete: function() {
                ajaxNisha = 0;
            }
        });

    });

    $(document).on('click', '.search', function(){
        $('#searchBlock').fadeToggle(500);
        $('#searchInput').focus();
    });

    $('.topBlock .news .one:last').addClass('last');

    $(document).on('click', '.head_set-drop a', function(){
        $(this).siblings('.head_set-box').toggle();
    });

    $('.slider').on('fotorama:show', function (e, fotorama) {
        $(this).find('.slider_pagination .current').text(fotorama.activeIndex + 1);
        $(this).find('.slider_caption').text(fotorama.activeFrame.caption);
    });

    $(document).on('click', '[data-request="auto"]', function(e) {
        processAutoRequest($(this));
        return false;
    });

    $(document).on('click', '.check-in-js .star', function(e){
        var star = $(this);
        var url = star.data('url');
        var redirect = star.data('redirect');

        if(star.hasClass('disabled')){
            if (!redirect) {
                redirect = $('#popup_auth [name=success_url]').val();
            }
            if (!redirect.match(/#/)) {
                redirect += '?r='+Math.random();
            } else if (!redirect.match(/#comment/)) {
                var match = redirect.match(/^([^#]*)#(.*)/);
                if (match) {
                    redirect = '?r='+Math.random() + match[0];
                }
            }
            Bm.fancybox.modals.auth.open(null, redirect);

            return false;
        }

        if(star.hasClass('active')){
            $.ajax({
                type: 'GET',
                url: url,
                data: {direction: 0},
                success: function(data){
                    if(!data.status || data.status !== 'ok'){
                        return false;
                    }

                    star.removeClass('active');
                }
            });
        } else {
            $.ajax({
                type: 'GET',
                url: url,
                data: {direction: 1},
                success: function(data){
                    if(!data.status || data.status !== 'ok'){
                        return false;
                    }

                    star.addClass('active');
                }
            });
        }
    });

    $(document).on('click', '.blocked_block', function(){
        showTimeoutPopup();
    });

    $('.promoLink').on('click', function(){
        $(this).parent('li').find('.promoInputBlock').toggle();
        return false;
    });

});

var showTimeoutPopup = function() {
    if ($('.fancybox-overlay').is(':visible')) {
        return false;
    }

    $('.popup').find('.hidden-text').removeClass('hidden');

    // отправляем на базовый путь при щелчке на ссылку "Перейти к списку доступных материалов" /case/1293123/ => /case/
    $('.go_to_available_materials').on('click', function() {
        var basePath = /\/(\w+)\//.exec(location.pathname);
        if (basePath.length) {
            location.replace(basePath[0]);
        }
    });

    Bm.fancybox.open('popup_auth');
};
$(function() {
    window.shareInit = function() {
        $('div.share42init').each(function(idx) {
            var el = $(this), u = el.attr('data-url'), t = el.attr('data-title'), i = el.attr('data-image'), d = el.attr('data-description'), f = el.attr('data-path'), fn = el.attr('data-icons-file'), z = el.attr("data-zero-counter");
            if (!u)u = location.href;
            if (!fn)fn = 'icons.png';
            if (!z)z = 0;
            function fb_count(url) {
                var shares;
                $.getJSON('http://graph.facebook.com/?callback=?&ids=' + url, function(data) {
                    shares = data[url].shares || 0;
                    if (shares > 0 || z == 1)el.find('a[data-count="fb"]').append('<span class="share42-counter">' + shares + '</span>').data('shares', shares)
                })
            }

            fb_count(u);
            function twi_count(url) {
                var shares;
                $.getJSON('http://urls.api.twitter.com/1/urls/count.json?callback=?&url=' + url, function(data) {
                    shares = data.count;
                    if (shares > 0 || z == 1)el.find('a[data-count="twi"]').append('<span class="share42-counter">' + shares + '</span>').data('shares', shares)
                })
            }

            twi_count(u);
            function vk_count(url) {
                $.getScript('http://vk.com/share.php?act=count&index=' + idx + '&url=' + url);
                if (!window.VK)window.VK = {};
                window.VK.Share = {
                    count: function(idx, shares) {
                        if (shares > 0 || z == 1)$('div.share42init').eq(idx).find('a[data-count="vk"]').append('<span class="share42-counter">' + shares + '</span>').data('shares', shares)
                    }
                }
            }

            vk_count(u);
            if (!t)t = document.title;
            if (!d) {
                var meta = $('meta[name="description"]').attr('content');
                if (meta !== undefined)d = meta; else d = '';
            }
            u = encodeURIComponent(u);
            t = encodeURIComponent(t);
            t = t.replace(/\'/g, '%27');
            i = encodeURIComponent(i);
            d = encodeURIComponent(d);
            d = d.replace(/\'/g, '%27');
            var fbQuery = 'u=' + u;
            if (i != 'null' && i != '')fbQuery = 's=100&p[url]=' + u + '&p[title]=' + t + '&p[summary]=' + d + '&p[images][0]=' + i;
            var vkImage = '';
            if (i != 'null' && i != '')vkImage = '&image=' + i;
            var s = [
                '"#" data-count="vk" onclick="window.open(\'http://vk.com/share.php?url=' + u + '&title=' + t + vkImage + '&description=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="Поделиться В Контакте"',
                '"#" data-count="fb" onclick="window.open(\'http://www.facebook.com/sharer.php?m2w&' + fbQuery + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="Поделиться в Facebook"',
                '"#" data-count="twi" onclick="window.open(\'https://twitter.com/intent/tweet?text=' + t + '&url=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="Добавить в Twitter"'
                 ];
            var l = '';
            for (var j = 0; j < s.length; j++) l += '<a rel="nofollow" class="share42-item" href=' + s[j] + ' target="_blank"></a>';
            el.html('<div class="share42">' + l + '</div>');
        });
    };

    window.shareInit();
});
/**
 * Created with JetBrains PhpStorm.
 * User: n3b
 */



(function(window){

    if( window.BmSocialFB ) {
        return false;
    }

    window.BMSocialFB = {};

window.BmSocialFB = new function() {

	var sdk = this;
    var initialized = false;
	var callbackQueue = [];
	var authQueue = [];
	var _widgets =
	{
		like: function(params) {

			params = $.extend({}, {

				container: null,
				pageUrl: window.location.href

			}, params || {});

			if( ! params.container ) return false;

			var $cont = $('#' + params.container)
				.attr('class', 'fb-like')
				.attr('data-href', params.pageUrl)
				.attr('data-layout', 'button_count')
				.attr('data-send', 'false')
				.attr('data-show-faces', 'false');

			FB.XFBML.parse();
		},
		comments: function(params) {

			params = $.extend({}, {

				container: null,
				pageUrl: window.location.href,
				width: 500,
				posts: 10

			}, params || {});

			if( ! params.container ) return false;

			var $cont = $('#' + params.container).html('')
				.attr('class', 'fb-comments')
				.attr('data-href', params.pageUrl)
				.attr('data-num-posts', params.posts)
				.attr('data-width', params.width);

			FB.XFBML.parse();
		},
		auth: function(params) {

			params = $.extend({}, {

				container: null,
				width: 200,
				rows: 1,
				showFaces: true

			}, params || {});

			if( ! params.container ) return false;

            if( btn = document.getElementById(params.container + '-login-button') ) {
                btn.onclick = function(){ FB.login(); return false;};
                return false;
            }

			var $cont = $('#' + params.container)
				.attr('class', 'fb-login-button')
				.attr('data-show-faces', params.showFaces ? 'true' : 'false')
				.attr('data-width', params.width)
				.attr('data-max-rows', params.rows);

			FB.XFBML.parse();
		},
		group: function(params) {

			params = $.extend({}, {

				container: null,
				width: 292,
				showFaces: true,
				stram: false,
				border: false,
				header: false

			}, params || {});

			if( ! params.container ) return false;

			var $cont = $('#' + params.container).html('')
				.attr('class', 'fb-like-box')
				.attr('data-href', 'https://www.facebook.com/molodost.bz')
				.attr('data-show-faces', params.showFaces ? 'true' : 'false')
				.attr('data-stream', params.stram ? 'true' : 'false')
				.attr('data-show-border', params.border ? 'true' : 'false')
				.attr('data-header', params.header ? 'true' : 'false')
				.attr('data-width', params.width);

			FB.XFBML.parse();
		},
		membersComments: function(params) {

			params = $.extend({}, {

				container: null,
				pageUrl: window.location.href,
				width: 500,
				posts: 10

			}, params || {});

			if( ! params.container ) return false;

			authQueue.push(params);

			FB.getLoginStatus(loginStatusCallback);
		}
	};

	/**
	 * проверяем авторизацию на FB
	 * @param response
	 */
	var loginStatusCallback = function(response) {

        return _events.onJoin();

		if( ! ( response.status === 'connected' || response.status === 'not_authorized' ) ) {
			return _events.onCheck();
		}

		FB.api('/me/likes/293259244049605', function(response) {

			if( response.data && response.data.length ){
				_events.onJoin();
			}
			else {
				_events.onAuth();
			}
		});

	};

	var _events = {

		onCheck: function() {

			for( var key in authQueue ) {
				_widgets.auth({container: authQueue[key].container});
			}
		},
		onAuth: function() {

			for( var key in authQueue ) {
				_widgets.group({container: authQueue[key].container});
			}
		},
		onJoin: function() {

			var params;
			while( params = authQueue.shift() ) {
				_widgets.comments(params)
			}
		}
	};

	/**
	 * выполнить все колбеки в очереди
	 */
	var fireCallbacks = function()
	{
		var callback;

		while( callback = callbackQueue.shift() ) {
			callback.call(sdk);
		}
	};

	/**
	 * инициализация FB sdk
	 */
	var init = function()
	{
		if( typeof window.fbAsyncInit == 'undefined' )
		{
			window.fbAsyncInit = function()
			{
				if( window['socialCommentsCallbackUrl'] )
				{
					var fbCommentCallback = function(id){
						$.post(window['socialCommentsCallbackUrl'],{
							type: 'facebook',
							id: id
						});
					}

					FB.Event.subscribe('comment.create', function(response)
					{
						if( response.href ) {
							fbCommentCallback(response.href);
						}
					});

					FB.Event.subscribe('comment.remove', function(response)
					{
						if( response.href ) {
							fbCommentCallback(response.href);
						}
					});
				}

				FB.Event.subscribe('auth.login', loginStatusCallback);

				FB.Event.subscribe('edge.create', function(response)
				{
					if( 'https://www.facebook.com/molodost.bz' != response ) return;

					_events.onJoin();
				});

				fireCallbacks();
			};

			/* FB */
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=146851835502992";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		}
		else if( typeof window.FB == 'undefined' )
		{
			setTimeout(init, 100);
		}
        else if( initialized )
        {
            fireCallbacks();
        }
	};

	/**
	 *
	 * @param name          имя виджета из массива _widgets
	 * @param params        параметры виджета
	 * @return {Boolean}
	 */
	sdk.widget = function(name, params)
	{
		if( ! _widgets[name] ) return false;

		callbackQueue.push(function(){ _widgets[name].call(sdk, params) });
		setTimeout(init, 0);
	};

};
})(window);

/**
 * Created with JetBrains PhpStorm.
 * User: n3b
 */

(function(window){

    if( window.BmSocialVK ) {
        return false;
    }

    window.BmSocialVK = {};

window.BmSocialVK = new function() {

    var sdk = this;
    var initialized = false;
    var callbackQueue = [];
    var authQueue = [];
    var _widgets =
    {
        like: function(params) {

            params = $.extend({}, {
                container: null
            }, params || {});

            if( ! params.container ) return false;

            var widgetParams = {
                pageUrl: params.pageUrl
            };

            VK.Widgets.Like( params.container, widgetParams );
        },
        comments: function(params) {

            params = $.extend({}, {
                container: null,
                width: 'auto',
                posts: 10,
                attach: '*'
            }, params || {});

            if( ! params.container ) return false;

            var $cont = $('#' + params.container);

            // dirty fix
            $cont.children().hide();

            var widgetParams = {
                width: params.width,
                limit: params.posts,
                attach: params.attach,
                pageUrl: params.pageUrl || params.pageId
            };

            VK.Widgets.Comments( params.container, widgetParams, params.pageId );
        },
        auth: function(params) {

            params = $.extend({}, {
                container: null
            }, params || {});

            if( ! params.container ) return false;

            var btnId = params.container + '-login-button';
            if( btn = document.getElementById(btnId) ) {
                btn.onclick = function(){ VK.Auth.login(loginStatusCallback); return false; };
                return false;
            }

            var btn = document.createElement('div');
            btn.id = btnId;
            btn.onclick = function(){ VK.Auth.login(loginStatusCallback); };
            document.getElementById(params.container).appendChild(btn);
            VK.UI.button( btnId );
        },
        group: function(params) {

            params = $.extend({}, {
                container: null,
                width: 'auto',
                height: 100
            }, params || {});

            if( ! params.container ) return false;

            var $cont = $('#' + params.container);

            $cont.html('<p>Вам необходимо вступить в группу:</p><div id="' + params.container + '_1"></div>');
            VK.Widgets.Group(params.container + '_1', { mode: 1, width: params.width, height: params.height }, 25276999);
        },
        membersComments: function(params) {

            params = $.extend({}, {
                container: null,
                width: 500,
                posts: 10
            }, params || {});

            if( ! params.container ) return false;

            authQueue.push(params);

            VK.Auth.getLoginStatus(loginStatusCallback);
        }

    };

    /**
     * проверяем авторизацию на VK
     * @param response
     */
    var loginStatusCallback = function(response)
    {
        return _events.onJoin();

        if (response.session) {
            VK.Api.call('groups.isMember', {group_id: 25276999, user_id: response.session.mid}, function(r) {
                r.response === 1 ? _events.onJoin() : _events.onAuth();
            });
        } else {
            _events.onCheck();
        }
    };

    var _events = {

        onCheck: function() {

            for( var key in authQueue ) {
                _widgets.auth({container: authQueue[key].container});
            }
        },
        onAuth: function() {

            for( var key in authQueue ) {
                _widgets.group({container: authQueue[key].container});
            }
        },
        onJoin: function() {

            var params;
            while( params = authQueue.shift() ) {
                _widgets.comments(params)
            }
        }
    };

    /**
     * выполнить все колбеки в очереди
     */
    var fireCallbacks = function()
    {
        var callback;

        while( callback = callbackQueue.shift() ) {
            callback.call(sdk);
        }
    };

    /**
     * инициализация VK sdk
     */
    var init = function()
    {
        if( typeof window.vkAsyncInit == 'undefined' )
        {
            window.vkAsyncInit = function()
            {
                // todo
                VK.init({apiId: 3489008});
                VK.Observer.subscribe("widgets.groups.joined", _events.onJoin);
                initialized = true;
                fireCallbacks();
            };

            /* VK */
            var id = 'vk_api_transport';
            if( document.getElementById(id) ) return;

            var div = document.createElement('div');
            div.id = id;
            var el = document.createElement("script");
            el.type = "text/javascript";
            el.src = "http://vk.com/js/api/openapi.js";
            el.async = true;
            div.appendChild(el);
            document.getElementsByTagName('body')[0].appendChild(div);
        }
        else if( typeof window.VK == 'undefined' )
        {
            setTimeout(init, 100);
        }
        else if( initialized )
        {
            fireCallbacks();
        }
    };

    /**
     *
     * @param name          имя виджета из массива _widgets
     * @param params        параметры виджета
     * @return {Boolean}
     */
    sdk.widget = function(name, params)
    {
        if( ! _widgets[name] ) return false;

        callbackQueue.push(function(){ _widgets[name].call(sdk, params) });
        setTimeout(init, 0);
    };
};
})(window);


/**
 * Глобальные методы для работы с video
 */
Bm.video = {

    nowPlaying: '',

    /**
     * Инлайновое проигрывание
     *
     * @param $el
     *
     * @returns {boolean}
     */
    inline: function($el) {

        var videoId = $el.attr('data-id'),
            source = $el.attr('data-url'),
            poster = $el.attr('data-image'),
            videoContainer = $('.js-video-player');

        if ($el.hasClass('started')) {
            return false;
        }

        var $authorized = $el.data('authorized');
        var $hasPhone = $el.data('has-phone');
        var $eventId = $el.data('event-id');
        var $productId = $el.data('product-id');

        // Проверяем авторизацию
        if ($authorized === 0) {
            Bm.video.showAuth();
            return false;
        }

        // Проверяем телефон
        if ($hasPhone === 0) {
            Bm.video.showPhone();
            return false;
        }

        // Проверяем event_id и product_id
        if ($eventId && $productId) {
            $.ajax({
                url : '/request/auto/',
                data: {
                    event_id:   $eventId,
                    product_id: $productId
                },
                type: 'POST'
            });
        }

        // Это первая инциализация видео?
        var isInitial = videoContainer.find('video').length == 0;
        var video = isInitial ? $('<video class="video-js vjs-default-skin js-video-player" preload="none" controls></video>') : videoContainer.find('video');

        if (isInitial) {
            video.attr('id', videoId);
        } else {
            video.attr('id', videoId + '_html5_api');
            videoContainer.attr('id', videoId);
        }

        video.attr('width', $el.attr('data-width')).
            attr('height', $el.attr('data-height')).
            attr('data-image', poster).
            attr('src', source).
            attr('data-update-url', $el.attr('data-update-url')).
            attr('data-youtube', $el.attr('data-youtube')).
            removeClass('vjs-default-skin').
            addClass($el.attr('data-skin'));

        $el.find('img').hide();
        $el.append(isInitial ? video : videoContainer);
        $el.addClass('started');

        // Инициализируем видео, останавливаем аудио
        Bm.video.init(video, true);
        if (Bm.audio) {
            Bm.audio.stop();
        }

        if (this.nowPlaying == '' || this.nowPlaying == videoId) {
            this.nowPlaying = videoId;
            return false;
        }

        var $wrapper = $('.js-video-wrapper[data-id="' + this.nowPlaying + '"]');

        $wrapper.removeClass('started');
        $wrapper.find('img').show();

        this.nowPlaying = videoId;
    },

    /**
     * Остановить
     *
     * @returns {boolean}
     */
    stop: function() {

        if (this.nowPlaying == '') {
            return false;
        }

        videojs(this.nowPlaying).pause();

        var $wrapper = $('.js-video-wrapper[data-id="' + this.nowPlaying + '"]');

        $wrapper.removeClass('started');

        this.nowPlaying = '';
    }


};
(function(window){

    if( window.social ) {
        return false;
    }

    window.social = {};

    window.social = new function() {
        var t = this;
        t.bm5 = false;
        this.strategy = 'authorization';
        this.openAuthModal = function(href) {
            var w = 600,
                h = 500,
                left = (screen.width / 2) - (w / 2),
                top = (screen.height / 2) - (h / 2);
            window.open(href, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            return false;
        };

        this.setMessage = function(message) {
            switch(message.result.status) {
                case 'token':
                    if(t.strategy == 'authorization') {
                        getUser(message.social);
                    }
                    if(t.strategy == 'link') {
                        linkAccount(message.social);
                    }
                    break;
                case 'error':
                    alert('Вы не были привязаны к соцсети ' + message.social);
                    break;
            }
        };

        var getUser = function(social) {
            var registerPage = $('#popup_registration').find('input[name=register_page]').val();
            $.ajax({
                type: 'POST',
                url: '/social/connect/' + social + '/',
                data: {
                    register_page: registerPage + ':' + social
                },
                success: function(data) {
                    switch(data.status) {
                        case 'userFound':
                            var redirect = $('#popup_auth').find('input[name=success_url]').val();
                            if(redirect != '') {
                                window.location.href = redirect;
                            } else {
                                window.location.href = data.message;
                            }
                            break;
                        case 'userNotFound':
                            t.actions.typeEmail($('#popup_email_type'), data, social);
                            break;
                        case 'error':
                            t.actions.error(data.message);
                            break;
                    }
                }
            });
        };

        var linkAccount = function(social) {
            $.ajax({
                type: 'POST',
                url: '/social/link/' + social + '/',
                data: {
                    check: true
                },
                success: function(response) {
                    var $container = $('#popup_link');
                    $container.find('.socialSelect').html(response.template);
                    Bm.fancybox.open($container.attr('id'));
                }
            });
        };

        this.actions = {
            typeEmail: function($container, socialData, socialName) {
                $container.find('.socialSelect').html(socialData.template);
                Bm.fancybox.open($container.attr('id'));

                var $form = $container.find('form');
                $form.on('submit', function(){

                    $form.find('.error_text').empty();
                    if(!Validator.isValid($form)) {
                        $form.find('.error_text').html(Validator.lastError);
                        return false;
                    }

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        success: function(response) {
                            if('needPassword' == response.status) {
                                t.actions.typePassword($('#popup_password_type'), response, socialName);
                            }
                            if( 'error' == response.status ) {
                                $form.find('.error_text').text('Ошибка: ' + response.message).show();
                            }
                            if('success' == response.status && response.redirect != undefined) {
                                window.location.href = response.redirect;
                            }
                        }
                    });
                    return false;
                });
            },

            typePassword: function($container, socialData, socialName) {
                $container.find('.socialSelect').html(socialData.template);
                Bm.fancybox.open($container.attr('id'));

                var $form = $container.find('form');
                $form.on('submit', function(){

                    $form.find('.error_text').empty();
                    if(!Validator.isValid($form)) {
                        $form.find('.error_text').html(Validator.lastError);
                        return false;
                    }

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        success: function(response) {
                            if( 'error' == response.status ) {
                                $form.find('.error_text').text('Ошибка: ' + response.message).show();
                            }
                            if('success' == response.status && response.redirect != undefined) {
                                window.location.href = response.redirect;
                            }
                        }
                    });
                    return false;
                });
            },

            error: function(error) {
                alert(error);
            }
        };

    };

})(window);

$(function(){
    var changeSocLink = function(currentLink) {
        var $link = $('a[href="' + currentLink + '"]').first(),
            newSoc= $link.attr('data-anti-social');

        $link.attr('data-anti-social', $link.attr('data-social'));
        $link.attr('data-social', newSoc).toggleClass('active');

        var newLink = $link.attr('data-anti-href');
        $link.attr('data-anti-href', $link.attr('href'));
        $link.attr('href', newLink);

        var newTitle = $link.attr('data-anti-title');
        $link.attr('data-anti-title', $link.attr('title'));
        $link.attr('title', newTitle);
    };

    var currentSocLink  = null;

    $(document).on('click', '[data-social="link"]', function(event) {
        var href = $(this).attr('href'),
            strategy = $(this).data('social') || "authorization";

        currentSocLink = href;

        window.social.strategy = strategy;
        window.social.openAuthModal(href);

        return false;
    });

    $(document).on('click', '[data-social="unlink"]', function(event) {
        if (confirm('Вы действительно хотите отвязать аккаунт данной социальной сети?')) {
            var $link = $(this).attr('href');

            $.ajax({
                url: $link,
                type: 'GET',
                success: function() {
                    changeSocLink($link);
                }
            });
        }

        return false;
    });

    $(document).on('click', '[data-social="authorization"]', function() {
        var href = $(this).attr('href'),
            strategy = $(this).data('social') || "authorization";

        window.social.strategy = strategy;
        window.social.bm5 = $(this).hasClass('bm5-social');
        window.social.openAuthModal(href);

        return false;
    });

    $(document).on('submit','form.ajax_link',function(event){
        var $form = $(this);


        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function(response) {
                //@todo check errors
                $.fancybox.close();
                changeSocLink(currentSocLink);
            }
        });

        return false;
    })
});




//(function(window){
//
//    if( window.social ) {
//        return false;
//    }
//
//    window.social = {};
//
//    window.social = new function() {
//        var t = this;
//        this.strategy = 'authorization';
//        t.bm5 = false;
//        this.openAuthModal = function(href) {
//            console.log(t.bm5);
//
//            var w = 600,
//                h = 500,
//                left = (screen.width / 2) - (w / 2),
//                top = (screen.height / 2) - (h / 2);
//            window.open(href, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
//
//            return false;
//        };
//
//        this.setMessage = function(message) {
//            console.log('setMessage');
//            console.log(message);
//            switch(message.result.status) {
//                case 'token':
//                    if(t.strategy == 'authorization') {
//                        getUser(message.social);
//                    }
//                    if(t.strategy == 'link') {
//                        linkAccount(message.social);
//                    }
//                    break;
//                case 'error':
//                    alert('Вы не были привязаны к соцсети ' + message.social);
//                    break;
//            }
//        };
//
//        var getUser = function(social) {
//            var registerPage;
//
//            if (t.bm5) {
//                registerPage = $('.js-popup[data-popup="registration"]').find('input[name="register_page"]').val();
//            } else {
//                registerPage = $('#popup_registration').find('input[name=register_page]').val();
//            }
//
//            $.ajax({
//                type: 'POST',
//                url: '/social/connect/' + social + '/',
//                data: {
//                    register_page: registerPage + ':' + social
//                },
//                success: function(data) {
//                    console.log(data)
//
//                    switch(data.status) {
//                        case 'userFound':
//                            var redirect;
//
//                            if (t.bm5) {
//                                redirect = $('.js-popup[data-popup="login"]').find('input[name="success_url"]').val();
//                            } else {
//                                redirect = $('#popup_auth').find('input[name=success_url]').val();
//                            }
//
//                            console.log(redirect);
//
//                            if(redirect != '') {
//                                window.location.href = redirect;
//                            } else {
//                                window.location.href = data.message;
//                            }
//                            break;
//                        case 'userNotFound':
//                            t.actions.typeEmail($('#popup_email_type'), data, social);
//                            break;
//                        case 'error':
//                            t.actions.error(data.message);
//                            break;
//                    }
//                }
//            });
//        };
//
//        var linkAccount = function(social) {
//            console.log('linkAccount')
//            $.ajax({
//                type: 'POST',
//                url: '/social/link/' + social + '/',
//                data: {
//                    check: true
//                },
//                success: function(response) {
//                    var $container = $('#popup_link');
//                    $container.find('.socialSelect').html(response.template);
//                    Bm.fancybox.open($container.attr('id'));
//                }
//            });
//        };
//
//        this.actions = {
//            typeEmail: function($container, socialData, socialName) {
//                $container.find('.socialSelect').html(socialData.template);
//                Bm.fancybox.open($container.attr('id'));
//
//                var $form = $container.find('form');
//                $form.on('submit', function(){
//
//                    $form.find('.error_text').empty();
//                    if(!Validator.isValid($form)) {
//                        $form.find('.error_text').html(Validator.lastError);
//                        return false;
//                    }
//
//                    $.ajax({
//                        url: $form.attr('action'),
//                        type: 'POST',
//                        data: $form.serialize(),
//                        success: function(response) {
//                            if('needPassword' == response.status) {
//                                t.actions.typePassword($('#popup_password_type'), response, socialName);
//                            }
//                            if( 'error' == response.status ) {
//                                $form.find('.error_text').text('Ошибка: ' + response.message).show();
//                            }
//                            if('success' == response.status && response.redirect != undefined) {
//                                window.location.href = response.redirect;
//                            }
//                        }
//                    });
//                    return false;
//                });
//            },
//
//            typePassword: function($container, socialData, socialName) {
//                $container.find('.socialSelect').html(socialData.template);
//                Bm.fancybox.open($container.attr('id'));
//
//                var $form = $container.find('form');
//                $form.on('submit', function(){
//
//                    $form.find('.error_text').empty();
//                    if(!Validator.isValid($form)) {
//                        $form.find('.error_text').html(Validator.lastError);
//                        return false;
//                    }
//
//                    $.ajax({
//                        url: $form.attr('action'),
//                        type: 'POST',
//                        data: $form.serialize(),
//                        success: function(response) {
//                            if( 'error' == response.status ) {
//                                $form.find('.error_text').text('Ошибка: ' + response.message).show();
//                            }
//                            if('success' == response.status && response.redirect != undefined) {
//                                window.location.href = response.redirect;
//                            }
//                        }
//                    });
//                    return false;
//                });
//            },
//
//            error: function(error) {
//                alert(error);
//            }
//        };
//
//    };
//
//})(window);
//
//$(function(){
//
//
//    var changeSocLink = function(currentLink){
//        var $link = $('a[href="'+currentLink+'"]').first();
//
//        var newSoc= $link.attr('data-anti-social');
//        $link.attr('data-anti-social',$link.attr('data-social'));
//        $link.attr('data-social',newSoc);
//
//        $link.find('div.icon').first().toggleClass('active');
//
//
//
//        var newLink = $link.attr('data-anti-href');
//        $link.attr('data-anti-href',$link.attr('href'));
//        $link.attr('href',newLink);
//
//        var newTitle = $link.attr('data-anti-title');
//        $link.attr('data-anti-title',$link.attr('title'));
//        $link.attr('title',newTitle);
//
//        var newOnclick = $link.attr('data-anti-onclick');
//        $link.attr('data-anti-onclick',$link.attr('onclick'));
//        $link.attr('onclick',newOnclick);
//    };
//
//    var currentSocLink  = null;
//
//    $(document).on('click', '[data-social="link"]', function(event) {
//
//        var href = $(this).attr('href');
//        currentSocLink = href;
//        var strategy = $(this).data('social') || "authorization";
//        window.social.strategy = strategy;
//        window.social.openAuthModal(href);
//        event.stopPropagation();
//        return false;
//    });
//
//    $(document).on('click', '[data-social="unlink"]', function(event) {
//        var $link = $(this).attr('href');
//        $.ajax({
//            url: $link,
//            type: 'GET',
//            success: function (response) {
//                changeSocLink($link);
//            }
//        });
//        event.stopPropagation();
//        return false;
//    });
//
//    $(document).on('click', '[data-social="authorization"]', function() {
//        var href = $(this).attr('href'),
//            strategy = $(this).data('social') || "authorization";
//
//        window.social.strategy = strategy;
//        window.social.bm5 = $(this).hasClass('bm5-social');
//        window.social.openAuthModal(href);
//        return false;
//    });
//
//    $(document).on('submit','form.ajax_link',function(event){
//        var $form = $(this);
//
//
//        $.ajax({
//            url: $form.attr('action'),
//            type: $form.attr('method'),
//            data: $form.serialize(),
//            success: function(response) {
//                //@todo check errors
//                $.fancybox.close();
//                changeSocLink(currentSocLink);
//
//
//
//            }
//        });
//
//        return false;
//    })
//});
$(function() {
    Bm.social.openShareDialogCallback = function($el, $parent) {
        $parent.find('.share42init_async').addClass('share42init');

        window.shareInit();

        var url = $el.data('url');
        var id = $el.data('id');
        var share_type = $el.data('type');

        setTimeout(function() {
            var count = 0;

            $parent.find('.share42-item').each(function() {
                if ($(this).data('shares')) {
                    count = count + parseInt($(this).data('shares'));
                }
            });

            $.ajax({
                type   : 'POST',
                url    : url,
                data   : {
                    count: count,
                    id   : id,
                    type : share_type
                },
                success: function(data) {
                    $parent.find('.share42init_async').removeClass('share42init');
                }
            });

        }, 1000);
    }
});
$(function() {
    var $scrollTop = $('.js-scroll-top'),
        pageScrollTop = 0,
        shift = 0;

    // scroll top
    $scrollTop.on('click', function() {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });

    // disable hover & show scroll top
    $(document).on('scroll', function() {
        pageScrollTop = document.documentElement.scrollTop || document.body.scrollTop;

        if (pageScrollTop > 400) {
            $scrollTop.addClass('show');
        } else {
            $scrollTop.removeClass('show');
        }
    });

    // header dropdown
    $(document).on('click', '.js-header-dropdown-open', function() {
        var $this = $(this),
            $dropdown = $('.js-header-dropdown-menu');

        $this.toggleClass('active');
        $dropdown.fadeToggle(200);
    });

    // hide elements
    $(document).on('click', function(e) {
        var $el = $(e.target);

        if (!$el.hasClass('js-header-dropdown-menu') && !$el.parents().hasClass('js-header-dropdown-menu') && !$el.hasClass('js-header-dropdown-open')) {
            $('.js-header-dropdown-open').removeClass('active');
            $('.js-header-dropdown-menu').fadeOut(200);
        }
    });

    // open left menu
    $(document).on('click', '.js-left-menu-open', function() {
        Bm.menu.show();
    });

    // close left menu
    $(document).on('click', '.js-left-menu-close', function() {
        Bm.menu.hide();
    });

    // left submenu toggle
    $(document).on('click', '.js-left-menu-category-open', function() {
        $('.header-left-menu_category-block').removeClass('open-left-menu');
        $(this).parents('.header-left-menu_category-block').addClass('open-left-menu');

        return false;
    });

    // hot keys
    $(document).on('keyup', function(e) {
        if (e.keyCode == 27) {
            Bm.search.hide();
            Bm.menu.hide();
        } else if (e.keyCode == 16) {
            shift++;

            setTimeout(function() {
                shift = 0;
            }, 400);

            if (shift == 2) {
                if (Bm.user.authorized) {
                    Bm.search.show();
                } else {
                    Bm.fancybox.modals.auth.open(null);
                }
            }
        }
    });
});
$(function() {
    var $button = $('#footer .js-footer-toggle'),
        $links = $('#footer .footer_hidden-links'),
        $text = $button.find('.text');

    $button.on('click', function() {
        if ($links.is(':hidden')) {
            $text.text('скрыть карту сайта');
        } else {
            $text.text('показать карту сайта');
        }

        $links.slideToggle(200);
    });
});
$(function() {
    $(document).on('click', '.js-search-show', function() {
        Bm.search.show($(this));

        return false;
    });

    $(document).on('click', '.js-search-hide', function() {
        Bm.search.hide();
    });
});
$(function() {
    // js disabled
    $(document).on('click', '.js-disabled', function() {
        Bm.fancybox.modals.auth.open(null);

        return false;
    });
});
/*
 * jQuery UI Widget 1.10.3+amd
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 *
 * http://api.jqueryui.com/jQuery.widget/
 */

(function( factory )
{
	if( typeof define === "function" && define.amd )
	{
		// Register as an anonymous AMD module:
		define(["jquery"], factory);
	} else
	{
		// Browser globals:
		factory(jQuery);
	}
}(function( $, undefined )
{

	var uuid = 0,
		slice = Array.prototype.slice,
		_cleanData = $.cleanData;
	$.cleanData = function( elems )
	{
		for( var i = 0, elem; (elem = elems[i]) != null; i ++ )
		{
			try
			{
				$(elem).triggerHandler("remove");
				// http://bugs.jquery.com/ticket/8235
			} catch( e )
			{}
		}
		_cleanData(elems);
	};

	$.widget = function( name, base, prototype )
	{
		var fullName, existingConstructor, constructor, basePrototype,
		// proxiedPrototype allows the provided prototype to remain unmodified
		// so that it can be used as a mixin for multiple widgets (#8876)
			proxiedPrototype = {},
			namespace = name.split(".")[ 0 ];

		name = name.split(".")[ 1 ];
		fullName = namespace + "-" + name;

		if( ! prototype )
		{
			prototype = base;
			base = $.Widget;
		}

		// create selector for plugin
		$.expr[ ":" ][ fullName.toLowerCase() ] = function( elem )
		{
			return ! ! $.data(elem, fullName);
		};

		$[ namespace ] = $[ namespace ] || {};
		existingConstructor = $[ namespace ][ name ];
		constructor = $[ namespace ][ name ] = function( options, element )
		{
			// allow instantiation without "new" keyword
			if( ! this._createWidget )
			{
				return new constructor(options, element);
			}

			// allow instantiation without initializing for simple inheritance
			// must use "new" keyword (the code above always passes args)
			if( arguments.length )
			{
				this._createWidget(options, element);
			}
		};
		// extend with the existing constructor to carry over any static properties
		$.extend(constructor, existingConstructor, {
			version:            prototype.version,
			// copy the object used to create the prototype in case we need to
			// redefine the widget later
			_proto:             $.extend({}, prototype),
			// track widgets that inherit from this widget in case this widget is
			// redefined after a widget inherits from it
			_childConstructors: []
		});

		basePrototype = new base();
		// we need to make the options hash a property directly on the new instance
		// otherwise we'll modify the options hash on the prototype that we're
		// inheriting from
		basePrototype.options = $.widget.extend({}, basePrototype.options);
		$.each(prototype, function( prop, value )
		{
			if( ! $.isFunction(value) )
			{
				proxiedPrototype[ prop ] = value;
				return;
			}
			proxiedPrototype[ prop ] = (function()
			{
				var _super = function()
					{
						return base.prototype[ prop ].apply(this, arguments);
					},
					_superApply = function( args )
					{
						return base.prototype[ prop ].apply(this, args);
					};
				return function()
				{
					var __super = this._super,
						__superApply = this._superApply,
						returnValue;

					this._super = _super;
					this._superApply = _superApply;

					returnValue = value.apply(this, arguments);

					this._super = __super;
					this._superApply = __superApply;

					return returnValue;
				};
			})();
		});
		constructor.prototype = $.widget.extend(basePrototype, {
			// TODO: remove support for widgetEventPrefix
			// always use the name + a colon as the prefix, e.g., draggable:start
			// don't prefix for widgets that aren't DOM-based
			widgetEventPrefix: existingConstructor ? basePrototype.widgetEventPrefix : name
		}, proxiedPrototype, {
			constructor:    constructor,
			namespace:      namespace,
			widgetName:     name,
			widgetFullName: fullName
		});

		// If this widget is being redefined then we need to find all widgets that
		// are inheriting from it and redefine all of them so that they inherit from
		// the new version of this widget. We're essentially trying to replace one
		// level in the prototype chain.
		if( existingConstructor )
		{
			$.each(existingConstructor._childConstructors, function( i, child )
			{
				var childPrototype = child.prototype;

				// redefine the child widget using the same prototype that was
				// originally used, but inherit from the new version of the base
				$.widget(childPrototype.namespace + "." + childPrototype.widgetName, constructor, child._proto);
			});
			// remove the list of existing child constructors from the old constructor
			// so the old child constructors can be garbage collected
			delete existingConstructor._childConstructors;
		} else
		{
			base._childConstructors.push(constructor);
		}

		$.widget.bridge(name, constructor);
	};

	$.widget.extend = function( target )
	{
		var input = slice.call(arguments, 1),
			inputIndex = 0,
			inputLength = input.length,
			key,
			value;
		for( ; inputIndex < inputLength; inputIndex ++ )
		{
			for( key in input[ inputIndex ] )
			{
				value = input[ inputIndex ][ key ];
				if( input[ inputIndex ].hasOwnProperty(key) && value !== undefined )
				{
					// Clone objects
					if( $.isPlainObject(value) )
					{
						target[ key ] = $.isPlainObject(target[ key ]) ?
							$.widget.extend({}, target[ key ], value) :
							// Don't extend strings, arrays, etc. with objects
							$.widget.extend({}, value);
						// Copy everything else by reference
					} else
					{
						target[ key ] = value;
					}
				}
			}
		}
		return target;
	};

	$.widget.bridge = function( name, object )
	{
		var fullName = object.prototype.widgetFullName || name;
		$.fn[ name ] = function( options )
		{
			var isMethodCall = typeof options === "string",
				args = slice.call(arguments, 1),
				returnValue = this;

			// allow multiple hashes to be passed on init
			options = ! isMethodCall && args.length ?
				$.widget.extend.apply(null, [ options ].concat(args)) :
				options;

			if( isMethodCall )
			{
				this.each(function()
				{
					var methodValue,
						instance = $.data(this, fullName);
					if( ! instance )
					{
						return $.error("cannot call methods on " + name + " prior to initialization; " +
							"attempted to call method '" + options + "'");
					}
					if( ! $.isFunction(instance[options]) || options.charAt(0) === "_" )
					{
						return $.error("no such method '" + options + "' for " + name + " widget instance");
					}
					methodValue = instance[ options ].apply(instance, args);
					if( methodValue !== instance && methodValue !== undefined )
					{
						returnValue = methodValue && methodValue.jquery ?
							returnValue.pushStack(methodValue.get()) :
							methodValue;
						return false;
					}
				});
			} else
			{
				this.each(function()
				{
					var instance = $.data(this, fullName);
					if( instance )
					{
						instance.option(options || {})._init();
					} else
					{
						$.data(this, fullName, new object(options, this));
					}
				});
			}

			return returnValue;
		};
	};

	$.Widget = function( /* options, element */ )
	{
	};
	$.Widget._childConstructors = [];

	$.Widget.prototype = {
		widgetName:          "widget",
		widgetEventPrefix:   "",
		defaultElement:      "<div>",
		options:             {
			disabled: false,

			// callbacks
			create:   null
		},
		_createWidget:       function( options, element )
		{
			element = $(element || this.defaultElement || this)[ 0 ];
			this.element = $(element);
			this.uuid = uuid ++;
			this.eventNamespace = "." + this.widgetName + this.uuid;
			this.options = $.widget.extend({},
				this.options,
				this._getCreateOptions(),
				options);

			this.bindings = $();
			this.hoverable = $();
			this.focusable = $();

			if( element !== this )
			{
				$.data(element, this.widgetFullName, this);
				this._on(true, this.element, {
					remove: function( event )
					{
						if( event.target === element )
						{
							this.destroy();
						}
					}
				});
				this.document = $(element.style ?
					// element within the document
					element.ownerDocument :
					// element is window or document
					element.document || element);
				this.window = $(this.document[0].defaultView || this.document[0].parentWindow);
			}

			this._create();
			this._trigger("create", null, this._getCreateEventData());
			this._init();
		},
		_getCreateOptions:   $.noop,
		_getCreateEventData: $.noop,
		_create:             $.noop,
		_init:               $.noop,

		destroy:  function()
		{
			this._destroy();
			// we can probably remove the unbind calls in 2.0
			// all event bindings should go through this._on()
			this.element
				.unbind(this.eventNamespace)
				// 1.9 BC for #7810
				// TODO remove dual storage
				.removeData(this.widgetName)
				.removeData(this.widgetFullName)
				// support: jquery <1.6.3
				// http://bugs.jquery.com/ticket/9413
				.removeData($.camelCase(this.widgetFullName));
			this.widget()
				.unbind(this.eventNamespace)
				.removeAttr("aria-disabled")
				.removeClass(
				this.widgetFullName + "-disabled " +
					"ui-state-disabled");

			// clean up events and states
			this.bindings.unbind(this.eventNamespace);
			this.hoverable.removeClass("ui-state-hover");
			this.focusable.removeClass("ui-state-focus");
		},
		_destroy: $.noop,

		widget: function()
		{
			return this.element;
		},

		option:      function( key, value )
		{
			var options = key,
				parts,
				curOption,
				i;

			if( arguments.length === 0 )
			{
				// don't return a reference to the internal hash
				return $.widget.extend({}, this.options);
			}

			if( typeof key === "string" )
			{
				// handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
				options = {};
				parts = key.split(".");
				key = parts.shift();
				if( parts.length )
				{
					curOption = options[ key ] = $.widget.extend({}, this.options[ key ]);
					for( i = 0; i < parts.length - 1; i ++ )
					{
						curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
						curOption = curOption[ parts[ i ] ];
					}
					key = parts.pop();
					if( value === undefined )
					{
						return curOption[ key ] === undefined ? null : curOption[ key ];
					}
					curOption[ key ] = value;
				} else
				{
					if( value === undefined )
					{
						return this.options[ key ] === undefined ? null : this.options[ key ];
					}
					options[ key ] = value;
				}
			}

			this._setOptions(options);

			return this;
		},
		_setOptions: function( options )
		{
			var key;

			for( key in options )
			{
				this._setOption(key, options[ key ]);
			}

			return this;
		},
		_setOption:  function( key, value )
		{
			this.options[ key ] = value;

			if( key === "disabled" )
			{
				this.widget()
					.toggleClass(this.widgetFullName + "-disabled ui-state-disabled", ! ! value)
					.attr("aria-disabled", value);
				this.hoverable.removeClass("ui-state-hover");
				this.focusable.removeClass("ui-state-focus");
			}

			return this;
		},

		enable:  function()
		{
			return this._setOption("disabled", false);
		},
		disable: function()
		{
			return this._setOption("disabled", true);
		},

		_on: function( suppressDisabledCheck, element, handlers )
		{
			var delegateElement,
				instance = this;

			// no suppressDisabledCheck flag, shuffle arguments
			if( typeof suppressDisabledCheck !== "boolean" )
			{
				handlers = element;
				element = suppressDisabledCheck;
				suppressDisabledCheck = false;
			}

			// no element argument, shuffle and use this.element
			if( ! handlers )
			{
				handlers = element;
				element = this.element;
				delegateElement = this.widget();
			} else
			{
				// accept selectors, DOM elements
				element = delegateElement = $(element);
				this.bindings = this.bindings.add(element);
			}

			$.each(handlers, function( event, handler )
			{
				function handlerProxy()
				{
					// allow widgets to customize the disabled handling
					// - disabled as an array instead of boolean
					// - disabled class as method for disabling individual parts
					if( ! suppressDisabledCheck &&
						( instance.options.disabled === true ||
							$(this).hasClass("ui-state-disabled") ) )
					{
						return;
					}
					return ( typeof handler === "string" ? instance[ handler ] : handler )
						.apply(instance, arguments);
				}

				// copy the guid so direct unbinding works
				if( typeof handler !== "string" )
				{
					handlerProxy.guid = handler.guid =
						handler.guid || handlerProxy.guid || $.guid ++;
				}

				var match = event.match(/^(\w+)\s*(.*)$/),
					eventName = match[1] + instance.eventNamespace,
					selector = match[2];
				if( selector )
				{
					delegateElement.delegate(selector, eventName, handlerProxy);
				} else
				{
					element.bind(eventName, handlerProxy);
				}
			});
		},

		_off: function( element, eventName )
		{
			eventName = (eventName || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace;
			element.unbind(eventName).undelegate(eventName);
		},

		_delay: function( handler, delay )
		{
			function handlerProxy()
			{
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply(instance, arguments);
			}

			var instance = this;
			return setTimeout(handlerProxy, delay || 0);
		},

		_hoverable: function( element )
		{
			this.hoverable = this.hoverable.add(element);
			this._on(element, {
				mouseenter: function( event )
				{
					$(event.currentTarget).addClass("ui-state-hover");
				},
				mouseleave: function( event )
				{
					$(event.currentTarget).removeClass("ui-state-hover");
				}
			});
		},

		_focusable: function( element )
		{
			this.focusable = this.focusable.add(element);
			this._on(element, {
				focusin:  function( event )
				{
					$(event.currentTarget).addClass("ui-state-focus");
				},
				focusout: function( event )
				{
					$(event.currentTarget).removeClass("ui-state-focus");
				}
			});
		},

		_trigger: function( type, event, data )
		{
			var prop, orig,
				callback = this.options[ type ];

			data = data || {};
			event = $.Event(event);
			event.type = ( type === this.widgetEventPrefix ?
				type :
				this.widgetEventPrefix + type ).toLowerCase();
			// the original event may come from any element
			// so we need to reset the target on the new event
			event.target = this.element[ 0 ];

			// copy original event properties over to the new event
			orig = event.originalEvent;
			if( orig )
			{
				for( prop in orig )
				{
					if( ! ( prop in event ) )
					{
						event[ prop ] = orig[ prop ];
					}
				}
			}

			this.element.trigger(event, data);
			return ! ( $.isFunction(callback) &&
				callback.apply(this.element[0], [ event ].concat(data)) === false ||
				event.isDefaultPrevented() );
		}
	};

	$.each({ show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect )
	{
		$.Widget.prototype[ "_" + method ] = function( element, options, callback )
		{
			if( typeof options === "string" )
			{
				options = { effect: options };
			}
			var hasOptions,
				effectName = ! options ?
					method :
					options === true || typeof options === "number" ?
						defaultEffect :
						options.effect || defaultEffect;
			options = options || {};
			if( typeof options === "number" )
			{
				options = { duration: options };
			}
			hasOptions = ! $.isEmptyObject(options);
			options.complete = callback;
			if( options.delay )
			{
				element.delay(options.delay);
			}
			if( hasOptions && $.effects && $.effects.effect[ effectName ] )
			{
				element[ method ](options);
			} else if( effectName !== method && element[ effectName ] )
			{
				element[ effectName ](options.duration, options.easing, callback);
			} else
			{
				element.queue(function( next )
				{
					$(this)[ method ]();
					if( callback )
					{
						callback.call(element[ 0 ]);
					}
					next();
				});
			}
		};
	});

}));

/*
 * jQuery File Upload Plugin 5.32.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global define, window, document, location, File, Blob, FormData */

(function( factory )
{
	'use strict';
	if( typeof define === 'function' && define.amd )
	{
		// Register as an anonymous AMD module:
		define([
			'jquery',
			'jquery.ui.widget'
		], factory);
	} else
	{
		// Browser globals:
		factory(window.jQuery);
	}
}(function( $ )
{
	'use strict';

	// Detect file input support, based on
	// http://viljamis.com/blog/2012/file-upload-support-on-mobile/
	$.support.fileInput = ! (new RegExp(
		// Handle devices which give false positives for the feature detection:
		'(Android (1\\.[0156]|2\\.[01]))' +
			'|(Windows Phone (OS 7|8\\.0))|(XBLWP)|(ZuneWP)|(WPDesktop)' +
			'|(w(eb)?OSBrowser)|(webOS)' +
			'|(Kindle/(1\\.0|2\\.[05]|3\\.0))'
	).test(window.navigator.userAgent) ||
		// Feature detection for all other devices:
		$('<input type="file">').prop('disabled'));

	// The FileReader API is not actually used, but works as feature detection,
	// as e.g. Safari supports XHR file uploads via the FormData API,
	// but not non-multipart XHR file uploads:
	$.support.xhrFileUpload = ! ! (window.XMLHttpRequestUpload && window.FileReader);
	$.support.xhrFormDataFileUpload = ! ! window.FormData;

	// Detect support for Blob slicing (required for chunked uploads):
	$.support.blobSlice = window.Blob && (Blob.prototype.slice ||
		Blob.prototype.webkitSlice || Blob.prototype.mozSlice);

	// The fileupload widget listens for change events on file input fields defined
	// via fileInput setting and paste or drop events of the given dropZone.
	// In addition to the default jQuery Widget methods, the fileupload widget
	// exposes the "add" and "send" methods, to add or directly send files using
	// the fileupload API.
	// By default, files added via file input selection, paste, drag & drop or
	// "add" method are uploaded immediately, but it is possible to override
	// the "add" callback option to queue file uploads.
	$.widget('blueimp.fileupload', {

		options:         {
			// The drop target element(s), by the default the complete document.
			// Set to null to disable drag & drop support:
			dropZone:               $(document),
			// The paste target element(s), by the default the complete document.
			// Set to null to disable paste support:
			pasteZone:              $(document),
			// The file input field(s), that are listened to for change events.
			// If undefined, it is set to the file input fields inside
			// of the widget element on plugin initialization.
			// Set to null to disable the change listener.
			fileInput:              undefined,
			// By default, the file input field is replaced with a clone after
			// each input field change event. This is required for iframe transport
			// queues and allows change events to be fired for the same file
			// selection, but can be disabled by setting the following option to false:
			replaceFileInput:       true,
			// The parameter name for the file form data (the request argument name).
			// If undefined or empty, the name property of the file input field is
			// used, or "files[]" if the file input name property is also empty,
			// can be a string or an array of strings:
			paramName:              undefined,
			// By default, each file of a selection is uploaded using an individual
			// request for XHR type uploads. Set to false to upload file
			// selections in one request each:
			singleFileUploads:      true,
			// To limit the number of files uploaded with one XHR request,
			// set the following option to an integer greater than 0:
			limitMultiFileUploads:  undefined,
			// Set the following option to true to issue all file upload requests
			// in a sequential order:
			sequentialUploads:      false,
			// To limit the number of concurrent uploads,
			// set the following option to an integer greater than 0:
			limitConcurrentUploads: undefined,
			// Set the following option to true to force iframe transport uploads:
			forceIframeTransport:   false,
			// Set the following option to the location of a redirect url on the
			// origin server, for cross-domain iframe transport uploads:
			redirect:               undefined,
			// The parameter name for the redirect url, sent as part of the form
			// data and set to 'redirect' if this option is empty:
			redirectParamName:      undefined,
			// Set the following option to the location of a postMessage window,
			// to enable postMessage transport uploads:
			postMessage:            undefined,
			// By default, XHR file uploads are sent as multipart/form-data.
			// The iframe transport is always using multipart/form-data.
			// Set to false to enable non-multipart XHR uploads:
			multipart:              true,
			// To upload large files in smaller chunks, set the following option
			// to a preferred maximum chunk size. If set to 0, null or undefined,
			// or the browser does not support the required Blob API, files will
			// be uploaded as a whole.
			maxChunkSize:           undefined,
			// When a non-multipart upload or a chunked multipart upload has been
			// aborted, this option can be used to resume the upload by setting
			// it to the size of the already uploaded bytes. This option is most
			// useful when modifying the options object inside of the "add" or
			// "send" callbacks, as the options are cloned for each file upload.
			uploadedBytes:          undefined,
			// By default, failed (abort or error) file uploads are removed from the
			// global progress calculation. Set the following option to false to
			// prevent recalculating the global progress data:
			recalculateProgress:    true,
			// Interval in milliseconds to calculate and trigger progress events:
			progressInterval:       100,
			// Interval in milliseconds to calculate progress bitrate:
			bitrateInterval:        500,
			// By default, uploads are started automatically when adding files:
			autoUpload:             true,

			// Error and info messages:
			messages:               {
				uploadedBytes: 'Uploaded bytes exceed file size'
			},

			// Translation function, gets the message key to be translated
			// and an object with context specific data as arguments:
			i18n:                   function( message, context )
			{
				message = this.messages[message] || message.toString();
				if( context )
				{
					$.each(context, function( key, value )
					{
						message = message.replace('{' + key + '}', value);
					});
				}
				return message;
			},

			// Additional form data to be sent along with the file uploads can be set
			// using this option, which accepts an array of objects with name and
			// value properties, a function returning such an array, a FormData
			// object (for XHR file uploads), or a simple object.
			// The form of the first fileInput is given as parameter to the function:
			formData:               function( form )
			{
				return form.serializeArray();
			},

			// The add callback is invoked as soon as files are added to the fileupload
			// widget (via file input selection, drag & drop, paste or add API call).
			// If the singleFileUploads option is enabled, this callback will be
			// called once for each file in the selection for XHR file uploads, else
			// once for each file selection.
			//
			// The upload starts when the submit method is invoked on the data parameter.
			// The data object contains a files property holding the added files
			// and allows you to override plugin options as well as define ajax settings.
			//
			// Listeners for this callback can also be bound the following way:
			// .bind('fileuploadadd', func);
			//
			// data.submit() returns a Promise object and allows to attach additional
			// handlers using jQuery's Deferred callbacks:
			// data.submit().done(func).fail(func).always(func);
			add:                    function( e, data )
			{
				if( data.autoUpload || (data.autoUpload !== false &&
					$(this).fileupload('option', 'autoUpload')) )
				{
					data.process().done(function()
					{
						data.submit();
					});
				}
			},

			// Other callbacks:

			// Callback for the submit event of each file upload:
			// submit: function (e, data) {}, // .bind('fileuploadsubmit', func);

			// Callback for the start of each file upload request:
			// send: function (e, data) {}, // .bind('fileuploadsend', func);

			// Callback for successful uploads:
			// done: function (e, data) {}, // .bind('fileuploaddone', func);

			// Callback for failed (abort or error) uploads:
			// fail: function (e, data) {}, // .bind('fileuploadfail', func);

			// Callback for completed (success, abort or error) requests:
			// always: function (e, data) {}, // .bind('fileuploadalways', func);

			// Callback for upload progress events:
			// progress: function (e, data) {}, // .bind('fileuploadprogress', func);

			// Callback for global upload progress events:
			// progressall: function (e, data) {}, // .bind('fileuploadprogressall', func);

			// Callback for uploads start, equivalent to the global ajaxStart event:
			// start: function (e) {}, // .bind('fileuploadstart', func);

			// Callback for uploads stop, equivalent to the global ajaxStop event:
			// stop: function (e) {}, // .bind('fileuploadstop', func);

			// Callback for change events of the fileInput(s):
			// change: function (e, data) {}, // .bind('fileuploadchange', func);

			// Callback for paste events to the pasteZone(s):
			// paste: function (e, data) {}, // .bind('fileuploadpaste', func);

			// Callback for drop events of the dropZone(s):
			// drop: function (e, data) {}, // .bind('fileuploaddrop', func);

			// Callback for dragover events of the dropZone(s):
			// dragover: function (e) {}, // .bind('fileuploaddragover', func);

			// Callback for the start of each chunk upload request:
			// chunksend: function (e, data) {}, // .bind('fileuploadchunksend', func);

			// Callback for successful chunk uploads:
			// chunkdone: function (e, data) {}, // .bind('fileuploadchunkdone', func);

			// Callback for failed (abort or error) chunk uploads:
			// chunkfail: function (e, data) {}, // .bind('fileuploadchunkfail', func);

			// Callback for completed (success, abort or error) chunk upload requests:
			// chunkalways: function (e, data) {}, // .bind('fileuploadchunkalways', func);

			// The plugin options are used as settings object for the ajax calls.
			// The following are jQuery ajax settings required for the file uploads:
			processData:            false,
			contentType:            false,
			cache:                  false
		},

		// A list of options that require reinitializing event listeners and/or
		// special initialization code:
		_specialOptions: [
			'fileInput',
			'dropZone',
			'pasteZone',
			'multipart',
			'forceIframeTransport'
		],

		_blobSlice: $.support.blobSlice && function()
		{
			var slice = this.slice || this.webkitSlice || this.mozSlice;
			return slice.apply(this, arguments);
		},

		_BitrateTimer: function()
		{
			this.timestamp = ((Date.now) ? Date.now() : (new Date()).getTime());
			this.loaded = 0;
			this.bitrate = 0;
			this.getBitrate = function( now, loaded, interval )
			{
				var timeDiff = now - this.timestamp;
				if( ! this.bitrate || ! interval || timeDiff > interval )
				{
					this.bitrate = (loaded - this.loaded) * (1000 / timeDiff) * 8;
					this.loaded = loaded;
					this.timestamp = now;
				}
				return this.bitrate;
			};
		},

		_isXHRUpload: function( options )
		{
			return ! options.forceIframeTransport &&
				((! options.multipart && $.support.xhrFileUpload) ||
					$.support.xhrFormDataFileUpload);
		},

		_getFormData: function( options )
		{
			var formData;
			if( typeof options.formData === 'function' )
			{
				return options.formData(options.form);
			}
			if( $.isArray(options.formData) )
			{
				return options.formData;
			}
			if( $.type(options.formData) === 'object' )
			{
				formData = [];
				$.each(options.formData, function( name, value )
				{
					formData.push({name: name, value: value});
				});
				return formData;
			}
			return [];
		},

		_getTotal: function( files )
		{
			var total = 0;
			$.each(files, function( index, file )
			{
				total += file.size || 1;
			});
			return total;
		},

		_initProgressObject: function( obj )
		{
			var progress = {
				loaded:  0,
				total:   0,
				bitrate: 0
			};
			if( obj._progress )
			{
				$.extend(obj._progress, progress);
			} else
			{
				obj._progress = progress;
			}
		},

		_initResponseObject: function( obj )
		{
			var prop;
			if( obj._response )
			{
				for( prop in obj._response )
				{
					if( obj._response.hasOwnProperty(prop) )
					{
						delete obj._response[prop];
					}
				}
			} else
			{
				obj._response = {};
			}
		},

		_onProgress: function( e, data )
		{
			if( e.lengthComputable )
			{
				var now = ((Date.now) ? Date.now() : (new Date()).getTime()),
					loaded;
				if( data._time && data.progressInterval &&
					(now - data._time < data.progressInterval) &&
					e.loaded !== e.total )
				{
					return;
				}
				data._time = now;
				loaded = Math.floor(
					e.loaded / e.total * (data.chunkSize || data._progress.total)
				) + (data.uploadedBytes || 0);
				// Add the difference from the previously loaded state
				// to the global loaded counter:
				this._progress.loaded += (loaded - data._progress.loaded);
				this._progress.bitrate = this._bitrateTimer.getBitrate(
					now,
					this._progress.loaded,
					data.bitrateInterval
				);
				data._progress.loaded = data.loaded = loaded;
				data._progress.bitrate = data.bitrate = data._bitrateTimer.getBitrate(
					now,
					loaded,
					data.bitrateInterval
				);
				// Trigger a custom progress event with a total data property set
				// to the file size(s) of the current upload and a loaded data
				// property calculated accordingly:
				this._trigger('progress', e, data);
				// Trigger a global progress event for all current file uploads,
				// including ajax calls queued for sequential file uploads:
				this._trigger('progressall', e, this._progress);
			}
		},

		_initProgressListener: function( options )
		{
			var that = this,
				xhr = options.xhr ? options.xhr() : $.ajaxSettings.xhr();
			// Accesss to the native XHR object is required to add event listeners
			// for the upload progress event:
			if( xhr.upload )
			{
				$(xhr.upload).bind('progress', function( e )
				{
					var oe = e.originalEvent;
					// Make sure the progress event properties get copied over:
					e.lengthComputable = oe.lengthComputable;
					e.loaded = oe.loaded;
					e.total = oe.total;
					that._onProgress(e, options);
				});
				options.xhr = function()
				{
					return xhr;
				};
			}
		},

		_isInstanceOf: function( type, obj )
		{
			// Cross-frame instanceof check
			return Object.prototype.toString.call(obj) === '[object ' + type + ']';
		},

		_initXHRData: function( options )
		{
			var that = this,
				formData,
				file = options.files[0],
			// Ignore non-multipart setting if not supported:
				multipart = options.multipart || ! $.support.xhrFileUpload,
				paramName = options.paramName[0];
			options.headers = options.headers || {};
			if( options.contentRange )
			{
				options.headers['Content-Range'] = options.contentRange;
			}
			if( ! multipart || options.blob || ! this._isInstanceOf('File', file) )
			{
				options.headers['Content-Disposition'] = 'attachment; filename="' +
					encodeURI(file.name) + '"';
			}
			if( ! multipart )
			{
				options.contentType = file.type;
				options.data = options.blob || file;
			} else if( $.support.xhrFormDataFileUpload )
			{
				if( options.postMessage )
				{
					// window.postMessage does not allow sending FormData
					// objects, so we just add the File/Blob objects to
					// the formData array and let the postMessage window
					// create the FormData object out of this array:
					formData = this._getFormData(options);
					if( options.blob )
					{
						formData.push({
							name:  paramName,
							value: options.blob
						});
					} else
					{
						$.each(options.files, function( index, file )
						{
							formData.push({
								name:  options.paramName[index] || paramName,
								value: file
							});
						});
					}
				} else
				{
					if( that._isInstanceOf('FormData', options.formData) )
					{
						formData = options.formData;
					} else
					{
						formData = new FormData();
						$.each(this._getFormData(options), function( index, field )
						{
							formData.append(field.name, field.value);
						});
					}
					if( options.blob )
					{
						formData.append(paramName, options.blob, file.name);
					} else
					{
						$.each(options.files, function( index, file )
						{
							// This check allows the tests to run with
							// dummy objects:
							if( that._isInstanceOf('File', file) ||
								that._isInstanceOf('Blob', file) )
							{
								formData.append(
									options.paramName[index] || paramName,
									file,
									file.name
								);
							}
						});
					}
				}
				options.data = formData;
			}
			// Blob reference is not needed anymore, free memory:
			options.blob = null;
		},

		_initIframeSettings: function( options )
		{
			var targetHost = $('<a></a>').prop('href', options.url).prop('host');
			// Setting the dataType to iframe enables the iframe transport:
			options.dataType = 'iframe ' + (options.dataType || '');
			// The iframe transport accepts a serialized array as form data:
			options.formData = this._getFormData(options);
			// Add redirect url to form data on cross-domain uploads:
			if( options.redirect && targetHost && targetHost !== location.host )
			{
				options.formData.push({
					name:  options.redirectParamName || 'redirect',
					value: options.redirect
				});
			}
		},

		_initDataSettings: function( options )
		{
			if( this._isXHRUpload(options) )
			{
				if( ! this._chunkedUpload(options, true) )
				{
					if( ! options.data )
					{
						this._initXHRData(options);
					}
					this._initProgressListener(options);
				}
				if( options.postMessage )
				{
					// Setting the dataType to postmessage enables the
					// postMessage transport:
					options.dataType = 'postmessage ' + (options.dataType || '');
				}
			} else
			{
				this._initIframeSettings(options);
			}
		},

		_getParamName: function( options )
		{
			var fileInput = $(options.fileInput),
				paramName = options.paramName;
			if( ! paramName )
			{
				paramName = [];
				fileInput.each(function()
				{
					var input = $(this),
						name = input.prop('name') || 'files[]',
						i = (input.prop('files') || [1]).length;
					while( i )
					{
						paramName.push(name);
						i -= 1;
					}
				});
				if( ! paramName.length )
				{
					paramName = [fileInput.prop('name') || 'files[]'];
				}
			} else if( ! $.isArray(paramName) )
			{
				paramName = [paramName];
			}
			return paramName;
		},

		_initFormSettings: function( options )
		{
			// Retrieve missing options from the input field and the
			// associated form, if available:
			if( ! options.form || ! options.form.length )
			{
				options.form = $(options.fileInput.prop('form'));
				// If the given file input doesn't have an associated form,
				// use the default widget file input's form:
				if( ! options.form.length )
				{
					options.form = $(this.options.fileInput.prop('form'));
				}
			}
			options.paramName = this._getParamName(options);
			if( ! options.url )
			{
				options.url = options.form.prop('action') || location.href;
			}
			// The HTTP request method must be "POST" or "PUT":
			options.type = (options.type || options.form.prop('method') || '')
				.toUpperCase();
			if( options.type !== 'POST' && options.type !== 'PUT' &&
				options.type !== 'PATCH' )
			{
				options.type = 'POST';
			}
			if( ! options.formAcceptCharset )
			{
				options.formAcceptCharset = options.form.attr('accept-charset');
			}
		},

		_getAJAXSettings:       function( data )
		{
			var options = $.extend({}, this.options, data);
			this._initFormSettings(options);
			this._initDataSettings(options);
			return options;
		},

		// jQuery 1.6 doesn't provide .state(),
		// while jQuery 1.8+ removed .isRejected() and .isResolved():
		_getDeferredState:      function( deferred )
		{
			if( deferred.state )
			{
				return deferred.state();
			}
			if( deferred.isResolved() )
			{
				return 'resolved';
			}
			if( deferred.isRejected() )
			{
				return 'rejected';
			}
			return 'pending';
		},

		// Maps jqXHR callbacks to the equivalent
		// methods of the given Promise object:
		_enhancePromise:        function( promise )
		{
			promise.success = promise.done;
			promise.error = promise.fail;
			promise.complete = promise.always;
			return promise;
		},

		// Creates and returns a Promise object enhanced with
		// the jqXHR methods abort, success, error and complete:
		_getXHRPromise:         function( resolveOrReject, context, args )
		{
			var dfd = $.Deferred(),
				promise = dfd.promise();
			context = context || this.options.context || promise;
			if( resolveOrReject === true )
			{
				dfd.resolveWith(context, args);
			} else if( resolveOrReject === false )
			{
				dfd.rejectWith(context, args);
			}
			promise.abort = dfd.promise;
			return this._enhancePromise(promise);
		},

		// Adds convenience methods to the data callback argument:
		_addConvenienceMethods: function( e, data )
		{
			var that = this,
				getPromise = function( data )
				{
					return $.Deferred().resolveWith(that, [data]).promise();
				};
			data.process = function( resolveFunc, rejectFunc )
			{
				if( resolveFunc || rejectFunc )
				{
					data._processQueue = this._processQueue =
						(this._processQueue || getPromise(this))
							.pipe(resolveFunc, rejectFunc);
				}
				return this._processQueue || getPromise(this);
			};
			data.submit = function()
			{
				if( this.state() !== 'pending' )
				{
					data.jqXHR = this.jqXHR =
						(that._trigger('submit', e, this) !== false) &&
							that._onSend(e, this);
				}
				return this.jqXHR || that._getXHRPromise();
			};
			data.abort = function()
			{
				if( this.jqXHR )
				{
					return this.jqXHR.abort();
				}
				return that._getXHRPromise();
			};
			data.state = function()
			{
				if( this.jqXHR )
				{
					return that._getDeferredState(this.jqXHR);
				}
				if( this._processQueue )
				{
					return that._getDeferredState(this._processQueue);
				}
			};
			data.progress = function()
			{
				return this._progress;
			};
			data.response = function()
			{
				return this._response;
			};
		},

		// Parses the Range header from the server response
		// and returns the uploaded bytes:
		_getUploadedBytes:      function( jqXHR )
		{
			var range = jqXHR.getResponseHeader('Range'),
				parts = range && range.split('-'),
				upperBytesPos = parts && parts.length > 1 &&
					parseInt(parts[1], 10);
			return upperBytesPos && upperBytesPos + 1;
		},

		// Uploads a file in multiple, sequential requests
		// by splitting the file up in multiple blob chunks.
		// If the second parameter is true, only tests if the file
		// should be uploaded in chunks, but does not invoke any
		// upload requests:
		_chunkedUpload:         function( options, testOnly )
		{
			options.uploadedBytes = options.uploadedBytes || 0;
			var that = this,
				file = options.files[0],
				fs = file.size,
				ub = options.uploadedBytes,
				mcs = options.maxChunkSize || fs,
				slice = this._blobSlice,
				dfd = $.Deferred(),
				promise = dfd.promise(),
				jqXHR,
				upload;
			if( ! (this._isXHRUpload(options) && slice && (ub || mcs < fs)) ||
				options.data )
			{
				return false;
			}
			if( testOnly )
			{
				return true;
			}
			if( ub >= fs )
			{
				file.error = options.i18n('uploadedBytes');
				return this._getXHRPromise(
					false,
					options.context,
					[null, 'error', file.error]
				);
			}
			// The chunk upload method:
			upload = function()
			{
				// Clone the options object for each chunk upload:
				var o = $.extend({}, options),
					currentLoaded = o._progress.loaded;
				o.blob = slice.call(
					file,
					ub,
					ub + mcs,
					file.type
				);
				// Store the current chunk size, as the blob itself
				// will be dereferenced after data processing:
				o.chunkSize = o.blob.size;
				// Expose the chunk bytes position range:
				o.contentRange = 'bytes ' + ub + '-' +
					(ub + o.chunkSize - 1) + '/' + fs;
				// Process the upload data (the blob and potential form data):
				that._initXHRData(o);
				// Add progress listeners for this chunk upload:
				that._initProgressListener(o);
				jqXHR = ((that._trigger('chunksend', null, o) !== false && $.ajax(o)) ||
					that._getXHRPromise(false, o.context))
					.done(function( result, textStatus, jqXHR )
					{
						ub = that._getUploadedBytes(jqXHR) ||
							(ub + o.chunkSize);
						// Create a progress event if no final progress event
						// with loaded equaling total has been triggered
						// for this chunk:
						if( currentLoaded + o.chunkSize - o._progress.loaded )
						{
							that._onProgress($.Event('progress', {
								lengthComputable: true,
								loaded:           ub - o.uploadedBytes,
								total:            ub - o.uploadedBytes
							}), o);
						}
						options.uploadedBytes = o.uploadedBytes = ub;
						o.result = result;
						o.textStatus = textStatus;
						o.jqXHR = jqXHR;
						that._trigger('chunkdone', null, o);
						that._trigger('chunkalways', null, o);
						if( ub < fs )
						{
							// File upload not yet complete,
							// continue with the next chunk:
							upload();
						} else
						{
							dfd.resolveWith(
								o.context,
								[result, textStatus, jqXHR]
							);
						}
					})
					.fail(function( jqXHR, textStatus, errorThrown )
					{
						o.jqXHR = jqXHR;
						o.textStatus = textStatus;
						o.errorThrown = errorThrown;
						that._trigger('chunkfail', null, o);
						that._trigger('chunkalways', null, o);
						dfd.rejectWith(
							o.context,
							[jqXHR, textStatus, errorThrown]
						);
					});
			};
			this._enhancePromise(promise);
			promise.abort = function()
			{
				return jqXHR.abort();
			};
			upload();
			return promise;
		},

		_beforeSend: function( e, data )
		{
			if( this._active === 0 )
			{
				// the start callback is triggered when an upload starts
				// and no other uploads are currently running,
				// equivalent to the global ajaxStart event:
				this._trigger('start');
				// Set timer for global bitrate progress calculation:
				this._bitrateTimer = new this._BitrateTimer();
				// Reset the global progress values:
				this._progress.loaded = this._progress.total = 0;
				this._progress.bitrate = 0;
			}
			// Make sure the container objects for the .response() and
			// .progress() methods on the data object are available
			// and reset to their initial state:
			this._initResponseObject(data);
			this._initProgressObject(data);
			data._progress.loaded = data.loaded = data.uploadedBytes || 0;
			data._progress.total = data.total = this._getTotal(data.files) || 1;
			data._progress.bitrate = data.bitrate = 0;
			this._active += 1;
			// Initialize the global progress values:
			this._progress.loaded += data.loaded;
			this._progress.total += data.total;
		},

		_onDone: function( result, textStatus, jqXHR, options )
		{
			var total = options._progress.total,
				response = options._response;
			if( options._progress.loaded < total )
			{
				// Create a progress event if no final progress event
				// with loaded equaling total has been triggered:
				this._onProgress($.Event('progress', {
					lengthComputable: true,
					loaded:           total,
					total:            total
				}), options);
			}
			response.result = options.result = result;
			response.textStatus = options.textStatus = textStatus;
			response.jqXHR = options.jqXHR = jqXHR;
			this._trigger('done', null, options);
		},

		_onFail: function( jqXHR, textStatus, errorThrown, options )
		{
			var response = options._response;
			if( options.recalculateProgress )
			{
				// Remove the failed (error or abort) file upload from
				// the global progress calculation:
				this._progress.loaded -= options._progress.loaded;
				this._progress.total -= options._progress.total;
			}
			response.jqXHR = options.jqXHR = jqXHR;
			response.textStatus = options.textStatus = textStatus;
			response.errorThrown = options.errorThrown = errorThrown;
			this._trigger('fail', null, options);
		},

		_onAlways: function( jqXHRorResult, textStatus, jqXHRorError, options )
		{
			// jqXHRorResult, textStatus and jqXHRorError are added to the
			// options object via done and fail callbacks
			this._trigger('always', null, options);
		},

		_onSend: function( e, data )
		{
			if( ! data.submit )
			{
				this._addConvenienceMethods(e, data);
			}
			var that = this,
				jqXHR,
				aborted,
				slot,
				pipe,
				options = that._getAJAXSettings(data),
				send = function()
				{
					that._sending += 1;
					// Set timer for bitrate progress calculation:
					options._bitrateTimer = new that._BitrateTimer();
					jqXHR = jqXHR || (
						((aborted || that._trigger('send', e, options) === false) &&
							that._getXHRPromise(false, options.context, aborted)) ||
							that._chunkedUpload(options) || $.ajax(options)
						).done(function( result, textStatus, jqXHR )
						{
							that._onDone(result, textStatus, jqXHR, options);
						}).fail(function( jqXHR, textStatus, errorThrown )
						{
							that._onFail(jqXHR, textStatus, errorThrown, options);
						}).always(function( jqXHRorResult, textStatus, jqXHRorError )
						{
							that._onAlways(
								jqXHRorResult,
								textStatus,
								jqXHRorError,
								options
							);
							that._sending -= 1;
							that._active -= 1;
							if( options.limitConcurrentUploads &&
								options.limitConcurrentUploads > that._sending )
							{
								// Start the next queued upload,
								// that has not been aborted:
								var nextSlot = that._slots.shift();
								while( nextSlot )
								{
									if( that._getDeferredState(nextSlot) === 'pending' )
									{
										nextSlot.resolve();
										break;
									}
									nextSlot = that._slots.shift();
								}
							}
							if( that._active === 0 )
							{
								// The stop callback is triggered when all uploads have
								// been completed, equivalent to the global ajaxStop event:
								that._trigger('stop');
							}
						});
					return jqXHR;
				};
			this._beforeSend(e, options);
			if( this.options.sequentialUploads ||
				(this.options.limitConcurrentUploads &&
					this.options.limitConcurrentUploads <= this._sending) )
			{
				if( this.options.limitConcurrentUploads > 1 )
				{
					slot = $.Deferred();
					this._slots.push(slot);
					pipe = slot.pipe(send);
				} else
				{
					this._sequence = this._sequence.pipe(send, send);
					pipe = this._sequence;
				}
				// Return the piped Promise object, enhanced with an abort method,
				// which is delegated to the jqXHR object of the current upload,
				// and jqXHR callbacks mapped to the equivalent Promise methods:
				pipe.abort = function()
				{
					aborted = [undefined, 'abort', 'abort'];
					if( ! jqXHR )
					{
						if( slot )
						{
							slot.rejectWith(options.context, aborted);
						}
						return send();
					}
					return jqXHR.abort();
				};
				return this._enhancePromise(pipe);
			}
			return send();
		},

		_onAdd: function( e, data )
		{
			var that = this,
				result = true,
				options = $.extend({}, this.options, data),
				limit = options.limitMultiFileUploads,
				paramName = this._getParamName(options),
				paramNameSet,
				paramNameSlice,
				fileSet,
				i;
			if( ! (options.singleFileUploads || limit) || ! this._isXHRUpload(options) )
			{
				fileSet = [data.files];
				paramNameSet = [paramName];
			} else if( ! options.singleFileUploads && limit )
			{
				fileSet = [];
				paramNameSet = [];
				for( i = 0; i < data.files.length; i += limit )
				{
					fileSet.push(data.files.slice(i, i + limit));
					paramNameSlice = paramName.slice(i, i + limit);
					if( ! paramNameSlice.length )
					{
						paramNameSlice = paramName;
					}
					paramNameSet.push(paramNameSlice);
				}
			} else
			{
				paramNameSet = paramName;
			}
			data.originalFiles = data.files;
			$.each(fileSet || data.files, function( index, element )
			{
				var newData = $.extend({}, data);
				newData.files = fileSet ? element : [element];
				newData.paramName = paramNameSet[index];
				that._initResponseObject(newData);
				that._initProgressObject(newData);
				that._addConvenienceMethods(e, newData);
				result = that._trigger('add', e, newData);
				return result;
			});
			return result;
		},

		_replaceFileInput: function( input )
		{
			var inputClone = input.clone(true);
			$('<form></form>').append(inputClone)[0].reset();
			// Detaching allows to insert the fileInput on another form
			// without loosing the file input value:
			input.after(inputClone).detach();
			// Avoid memory leaks with the detached file input:
			$.cleanData(input.unbind('remove'));
			// Replace the original file input element in the fileInput
			// elements set with the clone, which has been copied including
			// event handlers:
			this.options.fileInput = this.options.fileInput.map(function( i, el )
			{
				if( el === input[0] )
				{
					return inputClone[0];
				}
				return el;
			});
			// If the widget has been initialized on the file input itself,
			// override this.element with the file input clone:
			if( input[0] === this.element[0] )
			{
				this.element = inputClone;
			}
		},

		_handleFileTreeEntry: function( entry, path )
		{
			var that = this,
				dfd = $.Deferred(),
				errorHandler = function( e )
				{
					if( e && ! e.entry )
					{
						e.entry = entry;
					}
					// Since $.when returns immediately if one
					// Deferred is rejected, we use resolve instead.
					// This allows valid files and invalid items
					// to be returned together in one set:
					dfd.resolve([e]);
				},
				dirReader;
			path = path || '';
			if( entry.isFile )
			{
				if( entry._file )
				{
					// Workaround for Chrome bug #149735
					entry._file.relativePath = path;
					dfd.resolve(entry._file);
				} else
				{
					entry.file(function( file )
					{
						file.relativePath = path;
						dfd.resolve(file);
					}, errorHandler);
				}
			} else if( entry.isDirectory )
			{
				dirReader = entry.createReader();
				dirReader.readEntries(function( entries )
				{
					that._handleFileTreeEntries(
						entries,
						path + entry.name + '/'
					).done(function( files )
						{
							dfd.resolve(files);
						}).fail(errorHandler);
				}, errorHandler);
			} else
			{
				// Return an empy list for file system items
				// other than files or directories:
				dfd.resolve([]);
			}
			return dfd.promise();
		},

		_handleFileTreeEntries: function( entries, path )
		{
			var that = this;
			return $.when.apply(
				$,
				$.map(entries, function( entry )
				{
					return that._handleFileTreeEntry(entry, path);
				})
			).pipe(function()
				{
					return Array.prototype.concat.apply(
						[],
						arguments
					);
				});
		},

		_getDroppedFiles: function( dataTransfer )
		{
			dataTransfer = dataTransfer || {};
			var items = dataTransfer.items;
			if( items && items.length && (items[0].webkitGetAsEntry ||
				items[0].getAsEntry) )
			{
				return this._handleFileTreeEntries(
					$.map(items, function( item )
					{
						var entry;
						if( item.webkitGetAsEntry )
						{
							entry = item.webkitGetAsEntry();
							if( entry )
							{
								// Workaround for Chrome bug #149735:
								entry._file = item.getAsFile();
							}
							return entry;
						}
						return item.getAsEntry();
					})
				);
			}
			return $.Deferred().resolve(
				$.makeArray(dataTransfer.files)
			).promise();
		},

		_getSingleFileInputFiles: function( fileInput )
		{
			fileInput = $(fileInput);
			var entries = fileInput.prop('webkitEntries') ||
					fileInput.prop('entries'),
				files,
				value;
			if( entries && entries.length )
			{
				return this._handleFileTreeEntries(entries);
			}
			files = $.makeArray(fileInput.prop('files'));
			if( ! files.length )
			{
				value = fileInput.prop('value');
				if( ! value )
				{
					return $.Deferred().resolve([]).promise();
				}
				// If the files property is not available, the browser does not
				// support the File API and we add a pseudo File object with
				// the input value as name with path information removed:
				files = [
					{name: value.replace(/^.*\\/, '')}
				];
			} else if( files[0].name === undefined && files[0].fileName )
			{
				// File normalization for Safari 4 and Firefox 3:
				$.each(files, function( index, file )
				{
					file.name = file.fileName;
					file.size = file.fileSize;
				});
			}
			return $.Deferred().resolve(files).promise();
		},

		_getFileInputFiles: function( fileInput )
		{
			if( ! (fileInput instanceof $) || fileInput.length === 1 )
			{
				return this._getSingleFileInputFiles(fileInput);
			}
			return $.when.apply(
				$,
				$.map(fileInput, this._getSingleFileInputFiles)
			).pipe(function()
				{
					return Array.prototype.concat.apply(
						[],
						arguments
					);
				});
		},

		_onChange: function( e )
		{
			var that = this,
				data = {
					fileInput: $(e.target),
					form:      $(e.target.form)
				};
			this._getFileInputFiles(data.fileInput).always(function( files )
			{
				data.files = files;
				if( that.options.replaceFileInput )
				{
					that._replaceFileInput(data.fileInput);
				}
				if( that._trigger('change', e, data) !== false )
				{
					that._onAdd(e, data);
				}
			});
		},

		_onPaste: function( e )
		{
			var items = e.originalEvent && e.originalEvent.clipboardData &&
					e.originalEvent.clipboardData.items,
				data = {files: []};
			if( items && items.length )
			{
				$.each(items, function( index, item )
				{
					var file = item.getAsFile && item.getAsFile();
					if( file )
					{
						data.files.push(file);
					}
				});
				if( this._trigger('paste', e, data) === false ||
					this._onAdd(e, data) === false )
				{
					return false;
				}
			}
		},

		_onDrop: function( e )
		{
			e.dataTransfer = e.originalEvent && e.originalEvent.dataTransfer;
			var that = this,
				dataTransfer = e.dataTransfer,
				data = {};
			if( dataTransfer && dataTransfer.files && dataTransfer.files.length )
			{
				e.preventDefault();
				this._getDroppedFiles(dataTransfer).always(function( files )
				{
					data.files = files;
					if( that._trigger('drop', e, data) !== false )
					{
						that._onAdd(e, data);
					}
				});
			}
		},

		_onDragOver: function( e )
		{
			e.dataTransfer = e.originalEvent && e.originalEvent.dataTransfer;
			var dataTransfer = e.dataTransfer;
			if( dataTransfer )
			{
				if( this._trigger('dragover', e) === false )
				{
					return false;
				}
				if( $.inArray('Files', dataTransfer.types) !== - 1 )
				{
					dataTransfer.dropEffect = 'copy';
					e.preventDefault();
				}
			}
		},

		_initEventHandlers: function()
		{
			if( this._isXHRUpload(this.options) )
			{
				this._on(this.options.dropZone, {
					dragover: this._onDragOver,
					drop:     this._onDrop
				});
				this._on(this.options.pasteZone, {
					paste: this._onPaste
				});
			}
			if( $.support.fileInput )
			{
				this._on(this.options.fileInput, {
					change: this._onChange
				});
			}
		},

		_destroyEventHandlers: function()
		{
			this._off(this.options.dropZone, 'dragover drop');
			this._off(this.options.pasteZone, 'paste');
			this._off(this.options.fileInput, 'change');
		},

		_setOption: function( key, value )
		{
			var reinit = $.inArray(key, this._specialOptions) !== - 1;
			if( reinit )
			{
				this._destroyEventHandlers();
			}
			this._super(key, value);
			if( reinit )
			{
				this._initSpecialOptions();
				this._initEventHandlers();
			}
		},

		_initSpecialOptions: function()
		{
			var options = this.options;
			if( options.fileInput === undefined )
			{
				options.fileInput = this.element.is('input[type="file"]') ?
					this.element : this.element.find('input[type="file"]');
			} else if( ! (options.fileInput instanceof $) )
			{
				options.fileInput = $(options.fileInput);
			}
			if( ! (options.dropZone instanceof $) )
			{
				options.dropZone = $(options.dropZone);
			}
			if( ! (options.pasteZone instanceof $) )
			{
				options.pasteZone = $(options.pasteZone);
			}
		},

		_getRegExp: function( str )
		{
			var parts = str.split('/'),
				modifiers = parts.pop();
			parts.shift();
			return new RegExp(parts.join('/'), modifiers);
		},

		_isRegExpOption: function( key, value )
		{
			return key !== 'url' && $.type(value) === 'string' &&
				/^\/.*\/[igm]{0,3}$/.test(value);
		},

		_initDataAttributes: function()
		{
			var that = this,
				options = this.options;
			// Initialize options set via HTML5 data-attributes:
			$.each(
				$(this.element[0].cloneNode(false)).data(),
				function( key, value )
				{
					if( that._isRegExpOption(key, value) )
					{
						value = that._getRegExp(value);
					}
					options[key] = value;
				}
			);
		},

		_create:  function()
		{
			this._initDataAttributes();
			this._initSpecialOptions();
			this._slots = [];
			this._sequence = this._getXHRPromise(true);
			this._sending = this._active = 0;
			this._initProgressObject(this);
			this._initEventHandlers();
		},

		// This method is exposed to the widget API and allows to query
		// the number of active uploads:
		active:   function()
		{
			return this._active;
		},

		// This method is exposed to the widget API and allows to query
		// the widget upload progress.
		// It returns an object with loaded, total and bitrate properties
		// for the running uploads:
		progress: function()
		{
			return this._progress;
		},

		// This method is exposed to the widget API and allows adding files
		// using the fileupload API. The data parameter accepts an object which
		// must have a files property and can contain additional options:
		// .fileupload('add', {files: filesList});
		add:      function( data )
		{
			var that = this;
			if( ! data || this.options.disabled )
			{
				return;
			}
			if( data.fileInput && ! data.files )
			{
				this._getFileInputFiles(data.fileInput).always(function( files )
				{
					data.files = files;
					that._onAdd(null, data);
				});
			} else
			{
				data.files = $.makeArray(data.files);
				this._onAdd(null, data);
			}
		},

		// This method is exposed to the widget API and allows sending files
		// using the fileupload API. The data parameter accepts an object which
		// must have a files or fileInput property and can contain additional options:
		// .fileupload('send', {files: filesList});
		// The method returns a Promise object for the file upload call.
		send:     function( data )
		{
			if( data && ! this.options.disabled )
			{
				if( data.fileInput && ! data.files )
				{
					var that = this,
						dfd = $.Deferred(),
						promise = dfd.promise(),
						jqXHR,
						aborted;
					promise.abort = function()
					{
						aborted = true;
						if( jqXHR )
						{
							return jqXHR.abort();
						}
						dfd.reject(null, 'abort', 'abort');
						return promise;
					};
					this._getFileInputFiles(data.fileInput).always(
						function( files )
						{
							if( aborted )
							{
								return;
							}
							if( ! files.length )
							{
								dfd.reject();
								return;
							}
							data.files = files;
							jqXHR = that._onSend(null, data).then(
								function( result, textStatus, jqXHR )
								{
									dfd.resolve(result, textStatus, jqXHR);
								},
								function( jqXHR, textStatus, errorThrown )
								{
									dfd.reject(jqXHR, textStatus, errorThrown);
								}
							);
						}
					);
					return this._enhancePromise(promise);
				}
				data.files = $.makeArray(data.files);
				if( data.files.length )
				{
					return this._onSend(null, data);
				}
			}
			return this._getXHRPromise(false, data && data.context);
		}

	});

}));

/*
 * jQuery Iframe Transport Plugin 1.7
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint unparam: true, nomen: true */
/*global define, window, document */

(function( factory )
{
	'use strict';
	if( typeof define === 'function' && define.amd )
	{
		// Register as an anonymous AMD module:
		define(['jquery'], factory);
	} else
	{
		// Browser globals:
		factory(window.jQuery);
	}
}(function( $ )
{
	'use strict';

	// Helper variable to create unique names for the transport iframes:
	var counter = 0;

	// The iframe transport accepts three additional options:
	// options.fileInput: a jQuery collection of file input fields
	// options.paramName: the parameter name for the file form data,
	//  overrides the name property of the file input field(s),
	//  can be a string or an array of strings.
	// options.formData: an array of objects with name and value properties,
	//  equivalent to the return data of .serializeArray(), e.g.:
	//  [{name: 'a', value: 1}, {name: 'b', value: 2}]
	$.ajaxTransport('iframe', function( options )
	{
		if( options.async )
		{
			var form,
				iframe,
				addParamChar;
			return {
				send:  function( _, completeCallback )
				{
					form = $('<form style="display:none;"></form>');
					form.attr('accept-charset', options.formAcceptCharset);
					addParamChar = /\?/.test(options.url) ? '&' : '?';
					// XDomainRequest only supports GET and POST:
					if( options.type === 'DELETE' )
					{
						options.url = options.url + addParamChar + '_method=DELETE';
						options.type = 'POST';
					} else if( options.type === 'PUT' )
					{
						options.url = options.url + addParamChar + '_method=PUT';
						options.type = 'POST';
					} else if( options.type === 'PATCH' )
					{
						options.url = options.url + addParamChar + '_method=PATCH';
						options.type = 'POST';
					}
					// javascript:false as initial iframe src
					// prevents warning popups on HTTPS in IE6.
					// IE versions below IE8 cannot set the name property of
					// elements that have already been added to the DOM,
					// so we set the name along with the iframe HTML markup:
					counter += 1;
					iframe = $(
						'<iframe src="javascript:false;" name="iframe-transport-' +
							counter + '"></iframe>'
					).bind('load', function()
						{
							var fileInputClones,
								paramNames = $.isArray(options.paramName) ?
									options.paramName : [options.paramName];
							iframe
								.unbind('load')
								.bind('load', function()
								{
									var response;
									// Wrap in a try/catch block to catch exceptions thrown
									// when trying to access cross-domain iframe contents:
									try
									{
										response = iframe.contents();
										// Google Chrome and Firefox do not throw an
										// exception when calling iframe.contents() on
										// cross-domain requests, so we unify the response:
										if( ! response.length || ! response[0].firstChild )
										{
											throw new Error();
										}
									} catch( e )
									{
										response = undefined;
									}
									// The complete callback returns the
									// iframe content document as response object:
									completeCallback(
										200,
										'success',
										{'iframe': response}
									);
									// Fix for IE endless progress bar activity bug
									// (happens on form submits to iframe targets):
									$('<iframe src="javascript:false;"></iframe>')
										.appendTo(form);
									window.setTimeout(function()
									{
										// Removing the form in a setTimeout call
										// allows Chrome's developer tools to display
										// the response result
										form.remove();
									}, 0);
								});
							form
								.prop('target', iframe.prop('name'))
								.prop('action', options.url)
								.prop('method', options.type);
							if( options.formData )
							{
								$.each(options.formData, function( index, field )
								{
									$('<input type="hidden"/>')
										.prop('name', field.name)
										.val(field.value)
										.appendTo(form);
								});
							}
							if( options.fileInput && options.fileInput.length &&
								options.type === 'POST' )
							{
								fileInputClones = options.fileInput.clone();
								// Insert a clone for each file input field:
								options.fileInput.after(function( index )
								{
									return fileInputClones[index];
								});
								if( options.paramName )
								{
									options.fileInput.each(function( index )
									{
										$(this).prop(
											'name',
											paramNames[index] || options.paramName
										);
									});
								}
								// Appending the file input fields to the hidden form
								// removes them from their original location:
								form
									.append(options.fileInput)
									.prop('enctype', 'multipart/form-data')
									// enctype must be set as encoding for IE:
									.prop('encoding', 'multipart/form-data');
							}
							form.submit();
							// Insert the file input fields at their original location
							// by replacing the clones with the originals:
							if( fileInputClones && fileInputClones.length )
							{
								options.fileInput.each(function( index, input )
								{
									var clone = $(fileInputClones[index]);
									$(input).prop('name', clone.prop('name'));
									clone.replaceWith(input);
								});
							}
						});
					form.append(iframe).appendTo(document.body);
				},
				abort: function()
				{
					if( iframe )
					{
						// javascript:false as iframe src aborts the request
						// and prevents warning popups on HTTPS in IE6.
						// concat is used to avoid the "Script URL" JSLint error:
						iframe
							.unbind('load')
							.prop('src', 'javascript'.concat(':false;'));
					}
					if( form )
					{
						form.remove();
					}
				}
			};
		}
	});

	// The iframe transport returns the iframe content document as response.
	// The following adds converters from iframe to text, json, html, xml
	// and script.
	// Please note that the Content-Type for JSON responses has to be text/plain
	// or text/html, if the browser doesn't include application/json in the
	// Accept header, else IE will show a download dialog.
	// The Content-Type for XML responses on the other hand has to be always
	// application/xml or text/xml, so IE properly parses the XML response.
	// See also
	// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup#content-type-negotiation
	$.ajaxSetup({
		converters: {
			'iframe text':   function( iframe )
			{
				return iframe && $(iframe[0].body).text();
			},
			'iframe json':   function( iframe )
			{
				return iframe && $.parseJSON($(iframe[0].body).text());
			},
			'iframe html':   function( iframe )
			{
				return iframe && $(iframe[0].body).html();
			},
			'iframe xml':    function( iframe )
			{
				var xmlDoc = iframe && iframe[0];
				return xmlDoc && $.isXMLDoc(xmlDoc) ? xmlDoc :
					$.parseXML((xmlDoc.XMLDocument && xmlDoc.XMLDocument.xml) ||
						$(xmlDoc.body).html());
			},
			'iframe script': function( iframe )
			{
				return iframe && $.globalEval($(iframe[0].body).text());
			}
		}
	});

}));

/*!
 * jQuery Cycle Plugin (with Transition Definitions)
 * Examples and documentation at: http://jquery.malsup.com/cycle/
 * Copyright (c) 2007-2013 M. Alsup
 * Version: 3.0.3 (11-JUL-2013)
 * Dual licensed under the MIT and GPL licenses.
 * http://jquery.malsup.com/license.html
 * Requires: jQuery v1.7.1 or later
 */
;(function($, undefined) {
"use strict";

var ver = '3.0.3';

function debug(s) {
	if ($.fn.cycle.debug)
		log(s);
}		
function log() {
	/*global console */
	if (window.console && console.log)
		console.log('[cycle] ' + Array.prototype.join.call(arguments,' '));
}
$.expr[':'].paused = function(el) {
	return el.cyclePause;
};


// the options arg can be...
//   a number  - indicates an immediate transition should occur to the given slide index
//   a string  - 'pause', 'resume', 'toggle', 'next', 'prev', 'stop', 'destroy' or the name of a transition effect (ie, 'fade', 'zoom', etc)
//   an object - properties to control the slideshow
//
// the arg2 arg can be...
//   the name of an fx (only used in conjunction with a numeric value for 'options')
//   the value true (only used in first arg == 'resume') and indicates
//	 that the resume should occur immediately (not wait for next timeout)

$.fn.cycle = function(options, arg2) {
	var o = { s: this.selector, c: this.context };

	// in 1.3+ we can fix mistakes with the ready state
	if (this.length === 0 && options != 'stop') {
		if (!$.isReady && o.s) {
			log('DOM not ready, queuing slideshow');
			$(function() {
				$(o.s,o.c).cycle(options,arg2);
			});
			return this;
		}
		// is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
		log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
		return this;
	}

	// iterate the matched nodeset
	return this.each(function() {
		var opts = handleArguments(this, options, arg2);
		if (opts === false)
			return;

		opts.updateActivePagerLink = opts.updateActivePagerLink || $.fn.cycle.updateActivePagerLink;
		
		// stop existing slideshow for this container (if there is one)
		if (this.cycleTimeout)
			clearTimeout(this.cycleTimeout);
		this.cycleTimeout = this.cyclePause = 0;
		this.cycleStop = 0; // issue #108

		var $cont = $(this);
		var $slides = opts.slideExpr ? $(opts.slideExpr, this) : $cont.children();
		var els = $slides.get();

		if (els.length < 2) {
			log('terminating; too few slides: ' + els.length);
			return;
		}

		var opts2 = buildOptions($cont, $slides, els, opts, o);
		if (opts2 === false)
			return;

		var startTime = opts2.continuous ? 10 : getTimeout(els[opts2.currSlide], els[opts2.nextSlide], opts2, !opts2.backwards);

		// if it's an auto slideshow, kick it off
		if (startTime) {
			startTime += (opts2.delay || 0);
			if (startTime < 10)
				startTime = 10;
			debug('first timeout: ' + startTime);
			this.cycleTimeout = setTimeout(function(){go(els,opts2,0,!opts.backwards);}, startTime);
		}
	});
};

function triggerPause(cont, byHover, onPager) {
	var opts = $(cont).data('cycle.opts');
	if (!opts)
		return;
	var paused = !!cont.cyclePause;
	if (paused && opts.paused)
		opts.paused(cont, opts, byHover, onPager);
	else if (!paused && opts.resumed)
		opts.resumed(cont, opts, byHover, onPager);
}

// process the args that were passed to the plugin fn
function handleArguments(cont, options, arg2) {
	if (cont.cycleStop === undefined)
		cont.cycleStop = 0;
	if (options === undefined || options === null)
		options = {};
	if (options.constructor == String) {
		switch(options) {
		case 'destroy':
		case 'stop':
			var opts = $(cont).data('cycle.opts');
			if (!opts)
				return false;
			cont.cycleStop++; // callbacks look for change
			if (cont.cycleTimeout)
				clearTimeout(cont.cycleTimeout);
			cont.cycleTimeout = 0;
			if (opts.elements)
				$(opts.elements).stop();
			$(cont).removeData('cycle.opts');
			if (options == 'destroy')
				destroy(cont, opts);
			return false;
		case 'toggle':
			cont.cyclePause = (cont.cyclePause === 1) ? 0 : 1;
			checkInstantResume(cont.cyclePause, arg2, cont);
			triggerPause(cont);
			return false;
		case 'pause':
			cont.cyclePause = 1;
			triggerPause(cont);
			return false;
		case 'resume':
			cont.cyclePause = 0;
			checkInstantResume(false, arg2, cont);
			triggerPause(cont);
			return false;
		case 'prev':
		case 'next':
			opts = $(cont).data('cycle.opts');
			if (!opts) {
				log('options not found, "prev/next" ignored');
				return false;
			}
			if (typeof arg2 == 'string') 
				opts.oneTimeFx = arg2;
			$.fn.cycle[options](opts);
			return false;
		default:
			options = { fx: options };
		}
		return options;
	}
	else if (options.constructor == Number) {
		// go to the requested slide
		var num = options;
		options = $(cont).data('cycle.opts');
		if (!options) {
			log('options not found, can not advance slide');
			return false;
		}
		if (num < 0 || num >= options.elements.length) {
			log('invalid slide index: ' + num);
			return false;
		}
		options.nextSlide = num;
		if (cont.cycleTimeout) {
			clearTimeout(cont.cycleTimeout);
			cont.cycleTimeout = 0;
		}
		if (typeof arg2 == 'string')
			options.oneTimeFx = arg2;
		go(options.elements, options, 1, num >= options.currSlide);
		return false;
	}
	return options;
	
	function checkInstantResume(isPaused, arg2, cont) {
		if (!isPaused && arg2 === true) { // resume now!
			var options = $(cont).data('cycle.opts');
			if (!options) {
				log('options not found, can not resume');
				return false;
			}
			if (cont.cycleTimeout) {
				clearTimeout(cont.cycleTimeout);
				cont.cycleTimeout = 0;
			}
			go(options.elements, options, 1, !options.backwards);
		}
	}
}

function removeFilter(el, opts) {
	if (!$.support.opacity && opts.cleartype && el.style.filter) {
		try { el.style.removeAttribute('filter'); }
		catch(smother) {} // handle old opera versions
	}
}

// unbind event handlers
function destroy(cont, opts) {
	if (opts.next)
		$(opts.next).unbind(opts.prevNextEvent);
	if (opts.prev)
		$(opts.prev).unbind(opts.prevNextEvent);
	
	if (opts.pager || opts.pagerAnchorBuilder)
		$.each(opts.pagerAnchors || [], function() {
			this.unbind().remove();
		});
	opts.pagerAnchors = null;
	$(cont).unbind('mouseenter.cycle mouseleave.cycle');
	if (opts.destroy) // callback
		opts.destroy(opts);
}

// one-time initialization
function buildOptions($cont, $slides, els, options, o) {
	var startingSlideSpecified;
	// support metadata plugin (v1.0 and v2.0)
	var opts = $.extend({}, $.fn.cycle.defaults, options || {}, $.metadata ? $cont.metadata() : $.meta ? $cont.data() : {});
	var meta = $.isFunction($cont.data) ? $cont.data(opts.metaAttr) : null;
	if (meta)
		opts = $.extend(opts, meta);
	if (opts.autostop)
		opts.countdown = opts.autostopCount || els.length;

	var cont = $cont[0];
	$cont.data('cycle.opts', opts);
	opts.$cont = $cont;
	opts.stopCount = cont.cycleStop;
	opts.elements = els;
	opts.before = opts.before ? [opts.before] : [];
	opts.after = opts.after ? [opts.after] : [];

	// push some after callbacks
	if (!$.support.opacity && opts.cleartype)
		opts.after.push(function() { removeFilter(this, opts); });
	if (opts.continuous)
		opts.after.push(function() { go(els,opts,0,!opts.backwards); });

	saveOriginalOpts(opts);

	// clearType corrections
	if (!$.support.opacity && opts.cleartype && !opts.cleartypeNoBg)
		clearTypeFix($slides);

	// container requires non-static position so that slides can be position within
	if ($cont.css('position') == 'static')
		$cont.css('position', 'relative');
	if (opts.width)
		$cont.width(opts.width);
	if (opts.height && opts.height != 'auto')
		$cont.height(opts.height);

	if (opts.startingSlide !== undefined) {
		opts.startingSlide = parseInt(opts.startingSlide,10);
		if (opts.startingSlide >= els.length || opts.startSlide < 0)
			opts.startingSlide = 0; // catch bogus input
		else 
			startingSlideSpecified = true;
	}
	else if (opts.backwards)
		opts.startingSlide = els.length - 1;
	else
		opts.startingSlide = 0;

	// if random, mix up the slide array
	if (opts.random) {
		opts.randomMap = [];
		for (var i = 0; i < els.length; i++)
			opts.randomMap.push(i);
		opts.randomMap.sort(function(a,b) {return Math.random() - 0.5;});
		if (startingSlideSpecified) {
			// try to find the specified starting slide and if found set start slide index in the map accordingly
			for ( var cnt = 0; cnt < els.length; cnt++ ) {
				if ( opts.startingSlide == opts.randomMap[cnt] ) {
					opts.randomIndex = cnt;
				}
			}
		}
		else {
			opts.randomIndex = 1;
			opts.startingSlide = opts.randomMap[1];
		}
	}
	else if (opts.startingSlide >= els.length)
		opts.startingSlide = 0; // catch bogus input
	opts.currSlide = opts.startingSlide || 0;
	var first = opts.startingSlide;

	// set position and zIndex on all the slides
	$slides.css({position: 'absolute', top:0, left:0}).hide().each(function(i) {
		var z;
		if (opts.backwards)
			z = first ? i <= first ? els.length + (i-first) : first-i : els.length-i;
		else
			z = first ? i >= first ? els.length - (i-first) : first-i : els.length-i;
		$(this).css('z-index', z);
	});

	// make sure first slide is visible
	$(els[first]).css('opacity',1).show(); // opacity bit needed to handle restart use case
	removeFilter(els[first], opts);

	// stretch slides
	if (opts.fit) {
		if (!opts.aspect) {
	        if (opts.width)
	            $slides.width(opts.width);
	        if (opts.height && opts.height != 'auto')
	            $slides.height(opts.height);
		} else {
			$slides.each(function(){
				var $slide = $(this);
				var ratio = (opts.aspect === true) ? $slide.width()/$slide.height() : opts.aspect;
				if( opts.width && $slide.width() != opts.width ) {
					$slide.width( opts.width );
					$slide.height( opts.width / ratio );
				}

				if( opts.height && $slide.height() < opts.height ) {
					$slide.height( opts.height );
					$slide.width( opts.height * ratio );
				}
			});
		}
	}

	if (opts.center && ((!opts.fit) || opts.aspect)) {
		$slides.each(function(){
			var $slide = $(this);
			$slide.css({
				"margin-left": opts.width ?
					((opts.width - $slide.width()) / 2) + "px" :
					0,
				"margin-top": opts.height ?
					((opts.height - $slide.height()) / 2) + "px" :
					0
			});
		});
	}

	if (opts.center && !opts.fit && !opts.slideResize) {
		$slides.each(function(){
			var $slide = $(this);
			$slide.css({
				"margin-left": opts.width ? ((opts.width - $slide.width()) / 2) + "px" : 0,
				"margin-top": opts.height ? ((opts.height - $slide.height()) / 2) + "px" : 0
			});
		});
	}
		
	// stretch container
	var reshape = (opts.containerResize || opts.containerResizeHeight) && $cont.innerHeight() < 1;
	if (reshape) { // do this only if container has no size http://tinyurl.com/da2oa9
		var maxw = 0, maxh = 0;
		for(var j=0; j < els.length; j++) {
			var $e = $(els[j]), e = $e[0], w = $e.outerWidth(), h = $e.outerHeight();
			if (!w) w = e.offsetWidth || e.width || $e.attr('width');
			if (!h) h = e.offsetHeight || e.height || $e.attr('height');
			maxw = w > maxw ? w : maxw;
			maxh = h > maxh ? h : maxh;
		}
		if (opts.containerResize && maxw > 0 && maxh > 0)
			$cont.css({width:maxw+'px',height:maxh+'px'});
		if (opts.containerResizeHeight && maxh > 0)
			$cont.css({height:maxh+'px'});
	}

	var pauseFlag = false;  // https://github.com/malsup/cycle/issues/44
	if (opts.pause)
		$cont.bind('mouseenter.cycle', function(){
			pauseFlag = true;
			this.cyclePause++;
			triggerPause(cont, true);
		}).bind('mouseleave.cycle', function(){
				if (pauseFlag)
					this.cyclePause--;
				triggerPause(cont, true);
		});

	if (supportMultiTransitions(opts) === false)
		return false;

	// apparently a lot of people use image slideshows without height/width attributes on the images.
	// Cycle 2.50+ requires the sizing info for every slide; this block tries to deal with that.
	var requeue = false;
	options.requeueAttempts = options.requeueAttempts || 0;
	$slides.each(function() {
		// try to get height/width of each slide
		var $el = $(this);
		this.cycleH = (opts.fit && opts.height) ? opts.height : ($el.height() || this.offsetHeight || this.height || $el.attr('height') || 0);
		this.cycleW = (opts.fit && opts.width) ? opts.width : ($el.width() || this.offsetWidth || this.width || $el.attr('width') || 0);

		if ( $el.is('img') ) {
			var loading = (this.cycleH === 0 && this.cycleW === 0 && !this.complete);
			// don't requeue for images that are still loading but have a valid size
			if (loading) {
				if (o.s && opts.requeueOnImageNotLoaded && ++options.requeueAttempts < 100) { // track retry count so we don't loop forever
					log(options.requeueAttempts,' - img slide not loaded, requeuing slideshow: ', this.src, this.cycleW, this.cycleH);
					setTimeout(function() {$(o.s,o.c).cycle(options);}, opts.requeueTimeout);
					requeue = true;
					return false; // break each loop
				}
				else {
					log('could not determine size of image: '+this.src, this.cycleW, this.cycleH);
				}
			}
		}
		return true;
	});

	if (requeue)
		return false;

	opts.cssBefore = opts.cssBefore || {};
	opts.cssAfter = opts.cssAfter || {};
	opts.cssFirst = opts.cssFirst || {};
	opts.animIn = opts.animIn || {};
	opts.animOut = opts.animOut || {};

	$slides.not(':eq('+first+')').css(opts.cssBefore);
	$($slides[first]).css(opts.cssFirst);

	if (opts.timeout) {
		opts.timeout = parseInt(opts.timeout,10);
		// ensure that timeout and speed settings are sane
		if (opts.speed.constructor == String)
			opts.speed = $.fx.speeds[opts.speed] || parseInt(opts.speed,10);
		if (!opts.sync)
			opts.speed = opts.speed / 2;
		
		var buffer = opts.fx == 'none' ? 0 : opts.fx == 'shuffle' ? 500 : 250;
		while((opts.timeout - opts.speed) < buffer) // sanitize timeout
			opts.timeout += opts.speed;
	}
	if (opts.easing)
		opts.easeIn = opts.easeOut = opts.easing;
	if (!opts.speedIn)
		opts.speedIn = opts.speed;
	if (!opts.speedOut)
		opts.speedOut = opts.speed;

	opts.slideCount = els.length;
	opts.currSlide = opts.lastSlide = first;
	if (opts.random) {
		if (++opts.randomIndex == els.length)
			opts.randomIndex = 0;
		opts.nextSlide = opts.randomMap[opts.randomIndex];
	}
	else if (opts.backwards)
		opts.nextSlide = opts.startingSlide === 0 ? (els.length-1) : opts.startingSlide-1;
	else
		opts.nextSlide = opts.startingSlide >= (els.length-1) ? 0 : opts.startingSlide+1;

	// run transition init fn
	if (!opts.multiFx) {
		var init = $.fn.cycle.transitions[opts.fx];
		if ($.isFunction(init))
			init($cont, $slides, opts);
		else if (opts.fx != 'custom' && !opts.multiFx) {
			log('unknown transition: ' + opts.fx,'; slideshow terminating');
			return false;
		}
	}

	// fire artificial events
	var e0 = $slides[first];
	if (!opts.skipInitializationCallbacks) {
		if (opts.before.length)
			opts.before[0].apply(e0, [e0, e0, opts, true]);
		if (opts.after.length)
			opts.after[0].apply(e0, [e0, e0, opts, true]);
	}
	if (opts.next)
		$(opts.next).bind(opts.prevNextEvent,function(){return advance(opts,1);});
	if (opts.prev)
		$(opts.prev).bind(opts.prevNextEvent,function(){return advance(opts,0);});
	if (opts.pager || opts.pagerAnchorBuilder)
		buildPager(els,opts);

	exposeAddSlide(opts, els);

	return opts;
}

// save off original opts so we can restore after clearing state
function saveOriginalOpts(opts) {
	opts.original = { before: [], after: [] };
	opts.original.cssBefore = $.extend({}, opts.cssBefore);
	opts.original.cssAfter  = $.extend({}, opts.cssAfter);
	opts.original.animIn	= $.extend({}, opts.animIn);
	opts.original.animOut   = $.extend({}, opts.animOut);
	$.each(opts.before, function() { opts.original.before.push(this); });
	$.each(opts.after,  function() { opts.original.after.push(this); });
}

function supportMultiTransitions(opts) {
	var i, tx, txs = $.fn.cycle.transitions;
	// look for multiple effects
	if (opts.fx.indexOf(',') > 0) {
		opts.multiFx = true;
		opts.fxs = opts.fx.replace(/\s*/g,'').split(',');
		// discard any bogus effect names
		for (i=0; i < opts.fxs.length; i++) {
			var fx = opts.fxs[i];
			tx = txs[fx];
			if (!tx || !txs.hasOwnProperty(fx) || !$.isFunction(tx)) {
				log('discarding unknown transition: ',fx);
				opts.fxs.splice(i,1);
				i--;
			}
		}
		// if we have an empty list then we threw everything away!
		if (!opts.fxs.length) {
			log('No valid transitions named; slideshow terminating.');
			return false;
		}
	}
	else if (opts.fx == 'all') {  // auto-gen the list of transitions
		opts.multiFx = true;
		opts.fxs = [];
		for (var p in txs) {
			if (txs.hasOwnProperty(p)) {
				tx = txs[p];
				if (txs.hasOwnProperty(p) && $.isFunction(tx))
					opts.fxs.push(p);
			}
		}
	}
	if (opts.multiFx && opts.randomizeEffects) {
		// munge the fxs array to make effect selection random
		var r1 = Math.floor(Math.random() * 20) + 30;
		for (i = 0; i < r1; i++) {
			var r2 = Math.floor(Math.random() * opts.fxs.length);
			opts.fxs.push(opts.fxs.splice(r2,1)[0]);
		}
		debug('randomized fx sequence: ',opts.fxs);
	}
	return true;
}

// provide a mechanism for adding slides after the slideshow has started
function exposeAddSlide(opts, els) {
	opts.addSlide = function(newSlide, prepend) {
		var $s = $(newSlide), s = $s[0];
		if (!opts.autostopCount)
			opts.countdown++;
		els[prepend?'unshift':'push'](s);
		if (opts.els)
			opts.els[prepend?'unshift':'push'](s); // shuffle needs this
		opts.slideCount = els.length;

		// add the slide to the random map and resort
		if (opts.random) {
			opts.randomMap.push(opts.slideCount-1);
			opts.randomMap.sort(function(a,b) {return Math.random() - 0.5;});
		}

		$s.css('position','absolute');
		$s[prepend?'prependTo':'appendTo'](opts.$cont);

		if (prepend) {
			opts.currSlide++;
			opts.nextSlide++;
		}

		if (!$.support.opacity && opts.cleartype && !opts.cleartypeNoBg)
			clearTypeFix($s);

		if (opts.fit && opts.width)
			$s.width(opts.width);
		if (opts.fit && opts.height && opts.height != 'auto')
			$s.height(opts.height);
		s.cycleH = (opts.fit && opts.height) ? opts.height : $s.height();
		s.cycleW = (opts.fit && opts.width) ? opts.width : $s.width();

		$s.css(opts.cssBefore);

		if (opts.pager || opts.pagerAnchorBuilder)
			$.fn.cycle.createPagerAnchor(els.length-1, s, $(opts.pager), els, opts);

		if ($.isFunction(opts.onAddSlide))
			opts.onAddSlide($s);
		else
			$s.hide(); // default behavior
	};
}

// reset internal state; we do this on every pass in order to support multiple effects
$.fn.cycle.resetState = function(opts, fx) {
	fx = fx || opts.fx;
	opts.before = []; opts.after = [];
	opts.cssBefore = $.extend({}, opts.original.cssBefore);
	opts.cssAfter  = $.extend({}, opts.original.cssAfter);
	opts.animIn	= $.extend({}, opts.original.animIn);
	opts.animOut   = $.extend({}, opts.original.animOut);
	opts.fxFn = null;
	$.each(opts.original.before, function() { opts.before.push(this); });
	$.each(opts.original.after,  function() { opts.after.push(this); });

	// re-init
	var init = $.fn.cycle.transitions[fx];
	if ($.isFunction(init))
		init(opts.$cont, $(opts.elements), opts);
};

// this is the main engine fn, it handles the timeouts, callbacks and slide index mgmt
function go(els, opts, manual, fwd) {
	var p = opts.$cont[0], curr = els[opts.currSlide], next = els[opts.nextSlide];

	// opts.busy is true if we're in the middle of an animation
	if (manual && opts.busy && opts.manualTrump) {
		// let manual transitions requests trump active ones
		debug('manualTrump in go(), stopping active transition');
		$(els).stop(true,true);
		opts.busy = 0;
		clearTimeout(p.cycleTimeout);
	}

	// don't begin another timeout-based transition if there is one active
	if (opts.busy) {
		debug('transition active, ignoring new tx request');
		return;
	}


	// stop cycling if we have an outstanding stop request
	if (p.cycleStop != opts.stopCount || p.cycleTimeout === 0 && !manual)
		return;

	// check to see if we should stop cycling based on autostop options
	if (!manual && !p.cyclePause && !opts.bounce &&
		((opts.autostop && (--opts.countdown <= 0)) ||
		(opts.nowrap && !opts.random && opts.nextSlide < opts.currSlide))) {
		if (opts.end)
			opts.end(opts);
		return;
	}

	// if slideshow is paused, only transition on a manual trigger
	var changed = false;
	if ((manual || !p.cyclePause) && (opts.nextSlide != opts.currSlide)) {
		changed = true;
		var fx = opts.fx;
		// keep trying to get the slide size if we don't have it yet
		curr.cycleH = curr.cycleH || $(curr).height();
		curr.cycleW = curr.cycleW || $(curr).width();
		next.cycleH = next.cycleH || $(next).height();
		next.cycleW = next.cycleW || $(next).width();

		// support multiple transition types
		if (opts.multiFx) {
			if (fwd && (opts.lastFx === undefined || ++opts.lastFx >= opts.fxs.length))
				opts.lastFx = 0;
			else if (!fwd && (opts.lastFx === undefined || --opts.lastFx < 0))
				opts.lastFx = opts.fxs.length - 1;
			fx = opts.fxs[opts.lastFx];
		}

		// one-time fx overrides apply to:  $('div').cycle(3,'zoom');
		if (opts.oneTimeFx) {
			fx = opts.oneTimeFx;
			opts.oneTimeFx = null;
		}

		$.fn.cycle.resetState(opts, fx);

		// run the before callbacks
		if (opts.before.length)
			$.each(opts.before, function(i,o) {
				if (p.cycleStop != opts.stopCount) return;
				o.apply(next, [curr, next, opts, fwd]);
			});

		// stage the after callacks
		var after = function() {
			opts.busy = 0;
			$.each(opts.after, function(i,o) {
				if (p.cycleStop != opts.stopCount) return;
				o.apply(next, [curr, next, opts, fwd]);
			});
			if (!p.cycleStop) {
				// queue next transition
				queueNext();
			}
		};

		debug('tx firing('+fx+'); currSlide: ' + opts.currSlide + '; nextSlide: ' + opts.nextSlide);
		
		// get ready to perform the transition
		opts.busy = 1;
		if (opts.fxFn) // fx function provided?
			opts.fxFn(curr, next, opts, after, fwd, manual && opts.fastOnEvent);
		else if ($.isFunction($.fn.cycle[opts.fx])) // fx plugin ?
			$.fn.cycle[opts.fx](curr, next, opts, after, fwd, manual && opts.fastOnEvent);
		else
			$.fn.cycle.custom(curr, next, opts, after, fwd, manual && opts.fastOnEvent);
	}
	else {
		queueNext();
	}

	if (changed || opts.nextSlide == opts.currSlide) {
		// calculate the next slide
		var roll;
		opts.lastSlide = opts.currSlide;
		if (opts.random) {
			opts.currSlide = opts.nextSlide;
			if (++opts.randomIndex == els.length) {
				opts.randomIndex = 0;
				opts.randomMap.sort(function(a,b) {return Math.random() - 0.5;});
			}
			opts.nextSlide = opts.randomMap[opts.randomIndex];
			if (opts.nextSlide == opts.currSlide)
				opts.nextSlide = (opts.currSlide == opts.slideCount - 1) ? 0 : opts.currSlide + 1;
		}
		else if (opts.backwards) {
			roll = (opts.nextSlide - 1) < 0;
			if (roll && opts.bounce) {
				opts.backwards = !opts.backwards;
				opts.nextSlide = 1;
				opts.currSlide = 0;
			}
			else {
				opts.nextSlide = roll ? (els.length-1) : opts.nextSlide-1;
				opts.currSlide = roll ? 0 : opts.nextSlide+1;
			}
		}
		else { // sequence
			roll = (opts.nextSlide + 1) == els.length;
			if (roll && opts.bounce) {
				opts.backwards = !opts.backwards;
				opts.nextSlide = els.length-2;
				opts.currSlide = els.length-1;
			}
			else {
				opts.nextSlide = roll ? 0 : opts.nextSlide+1;
				opts.currSlide = roll ? els.length-1 : opts.nextSlide-1;
			}
		}
	}
	if (changed && opts.pager)
		opts.updateActivePagerLink(opts.pager, opts.currSlide, opts.activePagerClass);
	
	function queueNext() {
		// stage the next transition
		var ms = 0, timeout = opts.timeout;
		if (opts.timeout && !opts.continuous) {
			ms = getTimeout(els[opts.currSlide], els[opts.nextSlide], opts, fwd);
         if (opts.fx == 'shuffle')
            ms -= opts.speedOut;
      }
		else if (opts.continuous && p.cyclePause) // continuous shows work off an after callback, not this timer logic
			ms = 10;
		if (ms > 0)
			p.cycleTimeout = setTimeout(function(){ go(els, opts, 0, !opts.backwards); }, ms);
	}
}

// invoked after transition
$.fn.cycle.updateActivePagerLink = function(pager, currSlide, clsName) {
   $(pager).each(function() {
       $(this).children().removeClass(clsName).eq(currSlide).addClass(clsName);
   });
};

// calculate timeout value for current transition
function getTimeout(curr, next, opts, fwd) {
	if (opts.timeoutFn) {
		// call user provided calc fn
		var t = opts.timeoutFn.call(curr,curr,next,opts,fwd);
		while (opts.fx != 'none' && (t - opts.speed) < 250) // sanitize timeout
			t += opts.speed;
		debug('calculated timeout: ' + t + '; speed: ' + opts.speed);
		if (t !== false)
			return t;
	}
	return opts.timeout;
}

// expose next/prev function, caller must pass in state
$.fn.cycle.next = function(opts) { advance(opts,1); };
$.fn.cycle.prev = function(opts) { advance(opts,0);};

// advance slide forward or back
function advance(opts, moveForward) {
	var val = moveForward ? 1 : -1;
	var els = opts.elements;
	var p = opts.$cont[0], timeout = p.cycleTimeout;
	if (timeout) {
		clearTimeout(timeout);
		p.cycleTimeout = 0;
	}
	if (opts.random && val < 0) {
		// move back to the previously display slide
		opts.randomIndex--;
		if (--opts.randomIndex == -2)
			opts.randomIndex = els.length-2;
		else if (opts.randomIndex == -1)
			opts.randomIndex = els.length-1;
		opts.nextSlide = opts.randomMap[opts.randomIndex];
	}
	else if (opts.random) {
		opts.nextSlide = opts.randomMap[opts.randomIndex];
	}
	else {
		opts.nextSlide = opts.currSlide + val;
		if (opts.nextSlide < 0) {
			if (opts.nowrap) return false;
			opts.nextSlide = els.length - 1;
		}
		else if (opts.nextSlide >= els.length) {
			if (opts.nowrap) return false;
			opts.nextSlide = 0;
		}
	}

	var cb = opts.onPrevNextEvent || opts.prevNextClick; // prevNextClick is deprecated
	if ($.isFunction(cb))
		cb(val > 0, opts.nextSlide, els[opts.nextSlide]);
	go(els, opts, 1, moveForward);
	return false;
}

function buildPager(els, opts) {
	var $p = $(opts.pager);
	$.each(els, function(i,o) {
		$.fn.cycle.createPagerAnchor(i,o,$p,els,opts);
	});
	opts.updateActivePagerLink(opts.pager, opts.startingSlide, opts.activePagerClass);
}

$.fn.cycle.createPagerAnchor = function(i, el, $p, els, opts) {
	var a;
	if ($.isFunction(opts.pagerAnchorBuilder)) {
		a = opts.pagerAnchorBuilder(i,el);
		debug('pagerAnchorBuilder('+i+', el) returned: ' + a);
	}
	else
		a = '<a href="#">'+(i+1)+'</a>';
		
	if (!a)
		return;
	var $a = $(a);
	// don't reparent if anchor is in the dom
	if ($a.parents('body').length === 0) {
		var arr = [];
		if ($p.length > 1) {
			$p.each(function() {
				var $clone = $a.clone(true);
				$(this).append($clone);
				arr.push($clone[0]);
			});
			$a = $(arr);
		}
		else {
			$a.appendTo($p);
		}
	}

	opts.pagerAnchors =  opts.pagerAnchors || [];
	opts.pagerAnchors.push($a);
	
	var pagerFn = function(e) {
		e.preventDefault();
		opts.nextSlide = i;
		var p = opts.$cont[0], timeout = p.cycleTimeout;
		if (timeout) {
			clearTimeout(timeout);
			p.cycleTimeout = 0;
		}
		var cb = opts.onPagerEvent || opts.pagerClick; // pagerClick is deprecated
		if ($.isFunction(cb))
			cb(opts.nextSlide, els[opts.nextSlide]);
		go(els,opts,1,opts.currSlide < i); // trigger the trans
//		return false; // <== allow bubble
	};
	
	if ( /mouseenter|mouseover/i.test(opts.pagerEvent) ) {
		$a.hover(pagerFn, function(){/* no-op */} );
	}
	else {
		$a.bind(opts.pagerEvent, pagerFn);
	}
	
	if ( ! /^click/.test(opts.pagerEvent) && !opts.allowPagerClickBubble)
		$a.bind('click.cycle', function(){return false;}); // suppress click
	
	var cont = opts.$cont[0];
	var pauseFlag = false; // https://github.com/malsup/cycle/issues/44
	if (opts.pauseOnPagerHover) {
		$a.hover(
			function() { 
				pauseFlag = true;
				cont.cyclePause++; 
				triggerPause(cont,true,true);
			}, function() { 
				if (pauseFlag)
					cont.cyclePause--; 
				triggerPause(cont,true,true);
			} 
		);
	}
};

// helper fn to calculate the number of slides between the current and the next
$.fn.cycle.hopsFromLast = function(opts, fwd) {
	var hops, l = opts.lastSlide, c = opts.currSlide;
	if (fwd)
		hops = c > l ? c - l : opts.slideCount - l;
	else
		hops = c < l ? l - c : l + opts.slideCount - c;
	return hops;
};

// fix clearType problems in ie6 by setting an explicit bg color
// (otherwise text slides look horrible during a fade transition)
function clearTypeFix($slides) {
	debug('applying clearType background-color hack');
	function hex(s) {
		s = parseInt(s,10).toString(16);
		return s.length < 2 ? '0'+s : s;
	}
	function getBg(e) {
		for ( ; e && e.nodeName.toLowerCase() != 'html'; e = e.parentNode) {
			var v = $.css(e,'background-color');
			if (v && v.indexOf('rgb') >= 0 ) {
				var rgb = v.match(/\d+/g);
				return '#'+ hex(rgb[0]) + hex(rgb[1]) + hex(rgb[2]);
			}
			if (v && v != 'transparent')
				return v;
		}
		return '#ffffff';
	}
	$slides.each(function() { $(this).css('background-color', getBg(this)); });
}

// reset common props before the next transition
$.fn.cycle.commonReset = function(curr,next,opts,w,h,rev) {
	$(opts.elements).not(curr).hide();
	if (typeof opts.cssBefore.opacity == 'undefined')
		opts.cssBefore.opacity = 1;
	opts.cssBefore.display = 'block';
	if (opts.slideResize && w !== false && next.cycleW > 0)
		opts.cssBefore.width = next.cycleW;
	if (opts.slideResize && h !== false && next.cycleH > 0)
		opts.cssBefore.height = next.cycleH;
	opts.cssAfter = opts.cssAfter || {};
	opts.cssAfter.display = 'none';
	$(curr).css('zIndex',opts.slideCount + (rev === true ? 1 : 0));
	$(next).css('zIndex',opts.slideCount + (rev === true ? 0 : 1));
};

// the actual fn for effecting a transition
$.fn.cycle.custom = function(curr, next, opts, cb, fwd, speedOverride) {
	var $l = $(curr), $n = $(next);
	var speedIn = opts.speedIn, speedOut = opts.speedOut, easeIn = opts.easeIn, easeOut = opts.easeOut, animInDelay = opts.animInDelay, animOutDelay = opts.animOutDelay;
	$n.css(opts.cssBefore);
	if (speedOverride) {
		if (typeof speedOverride == 'number')
			speedIn = speedOut = speedOverride;
		else
			speedIn = speedOut = 1;
		easeIn = easeOut = null;
	}
	var fn = function() {
		$n.delay(animInDelay).animate(opts.animIn, speedIn, easeIn, function() {
			cb();
		});
	};
	$l.delay(animOutDelay).animate(opts.animOut, speedOut, easeOut, function() {
		$l.css(opts.cssAfter);
		if (!opts.sync) 
			fn();
	});
	if (opts.sync) fn();
};

// transition definitions - only fade is defined here, transition pack defines the rest
$.fn.cycle.transitions = {
	fade: function($cont, $slides, opts) {
		$slides.not(':eq('+opts.currSlide+')').css('opacity',0);
		opts.before.push(function(curr,next,opts) {
			$.fn.cycle.commonReset(curr,next,opts);
			opts.cssBefore.opacity = 0;
		});
		opts.animIn	   = { opacity: 1 };
		opts.animOut   = { opacity: 0 };
		opts.cssBefore = { top: 0, left: 0 };
	}
};

$.fn.cycle.ver = function() { return ver; };

// override these globally if you like (they are all optional)
$.fn.cycle.defaults = {
    activePagerClass: 'activeSlide', // class name used for the active pager link
    after:            null,     // transition callback (scope set to element that was shown):  function(currSlideElement, nextSlideElement, options, forwardFlag)
    allowPagerClickBubble: false, // allows or prevents click event on pager anchors from bubbling
    animIn:           null,     // properties that define how the slide animates in
    animInDelay:      0,        // allows delay before next slide transitions in	
    animOut:          null,     // properties that define how the slide animates out
    animOutDelay:     0,        // allows delay before current slide transitions out
    aspect:           false,    // preserve aspect ratio during fit resizing, cropping if necessary (must be used with fit option)
    autostop:         0,        // true to end slideshow after X transitions (where X == slide count)
    autostopCount:    0,        // number of transitions (optionally used with autostop to define X)
    backwards:        false,    // true to start slideshow at last slide and move backwards through the stack
    before:           null,     // transition callback (scope set to element to be shown):     function(currSlideElement, nextSlideElement, options, forwardFlag)
    center:           null,     // set to true to have cycle add top/left margin to each slide (use with width and height options)
    cleartype:        !$.support.opacity,  // true if clearType corrections should be applied (for IE)
    cleartypeNoBg:    false,    // set to true to disable extra cleartype fixing (leave false to force background color setting on slides)
    containerResize:  1,        // resize container to fit largest slide
    containerResizeHeight:  0,  // resize containers height to fit the largest slide but leave the width dynamic
    continuous:       0,        // true to start next transition immediately after current one completes
    cssAfter:         null,     // properties that defined the state of the slide after transitioning out
    cssBefore:        null,     // properties that define the initial state of the slide before transitioning in
    delay:            0,        // additional delay (in ms) for first transition (hint: can be negative)
    easeIn:           null,     // easing for "in" transition
    easeOut:          null,     // easing for "out" transition
    easing:           null,     // easing method for both in and out transitions
    end:              null,     // callback invoked when the slideshow terminates (use with autostop or nowrap options): function(options)
    fastOnEvent:      0,        // force fast transitions when triggered manually (via pager or prev/next); value == time in ms
    fit:              0,        // force slides to fit container
    fx:               'fade',   // name of transition effect (or comma separated names, ex: 'fade,scrollUp,shuffle')
    fxFn:             null,     // function used to control the transition: function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag)
    height:           'auto',   // container height (if the 'fit' option is true, the slides will be set to this height as well)
    manualTrump:      true,     // causes manual transition to stop an active transition instead of being ignored
    metaAttr:         'cycle',  // data- attribute that holds the option data for the slideshow
    next:             null,     // element, jQuery object, or jQuery selector string for the element to use as event trigger for next slide
    nowrap:           0,        // true to prevent slideshow from wrapping
    onPagerEvent:     null,     // callback fn for pager events: function(zeroBasedSlideIndex, slideElement)
    onPrevNextEvent:  null,     // callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement)
    pager:            null,     // element, jQuery object, or jQuery selector string for the element to use as pager container
    pagerAnchorBuilder: null,   // callback fn for building anchor links:  function(index, DOMelement)
    pagerEvent:       'click.cycle', // name of event which drives the pager navigation
    pause:            0,        // true to enable "pause on hover"
    pauseOnPagerHover: 0,       // true to pause when hovering over pager link
    prev:             null,     // element, jQuery object, or jQuery selector string for the element to use as event trigger for previous slide
    prevNextEvent:    'click.cycle',// event which drives the manual transition to the previous or next slide
    random:           0,        // true for random, false for sequence (not applicable to shuffle fx)
    randomizeEffects: 1,        // valid when multiple effects are used; true to make the effect sequence random
    requeueOnImageNotLoaded: true, // requeue the slideshow if any image slides are not yet loaded
    requeueTimeout:   250,      // ms delay for requeue
    rev:              0,        // causes animations to transition in reverse (for effects that support it such as scrollHorz/scrollVert/shuffle)
    shuffle:          null,     // coords for shuffle animation, ex: { top:15, left: 200 }
    skipInitializationCallbacks: false, // set to true to disable the first before/after callback that occurs prior to any transition
    slideExpr:        null,     // expression for selecting slides (if something other than all children is required)
    slideResize:      1,        // force slide width/height to fixed size before every transition
    speed:            1000,     // speed of the transition (any valid fx speed value)
    speedIn:          null,     // speed of the 'in' transition
    speedOut:         null,     // speed of the 'out' transition
    startingSlide:    undefined,// zero-based index of the first slide to be displayed
    sync:             1,        // true if in/out transitions should occur simultaneously
    timeout:          4000,     // milliseconds between slide transitions (0 to disable auto advance)
    timeoutFn:        null,     // callback for determining per-slide timeout value:  function(currSlideElement, nextSlideElement, options, forwardFlag)
    updateActivePagerLink: null,// callback fn invoked to update the active pager link (adds/removes activePagerClass style)
    width:            null      // container width (if the 'fit' option is true, the slides will be set to this width as well)
};

})(jQuery);


/*!
 * jQuery Cycle Plugin Transition Definitions
 * This script is a plugin for the jQuery Cycle Plugin
 * Examples and documentation at: http://malsup.com/jquery/cycle/
 * Copyright (c) 2007-2010 M. Alsup
 * Version:	 2.73
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function($) {
"use strict";

//
// These functions define slide initialization and properties for the named
// transitions. To save file size feel free to remove any of these that you
// don't need.
//
$.fn.cycle.transitions.none = function($cont, $slides, opts) {
	opts.fxFn = function(curr,next,opts,after){
		$(next).show();
		$(curr).hide();
		after();
	};
};

// not a cross-fade, fadeout only fades out the top slide
$.fn.cycle.transitions.fadeout = function($cont, $slides, opts) {
	$slides.not(':eq('+opts.currSlide+')').css({ display: 'block', 'opacity': 1 });
	opts.before.push(function(curr,next,opts,w,h,rev) {
		$(curr).css('zIndex',opts.slideCount + (rev !== true ? 1 : 0));
		$(next).css('zIndex',opts.slideCount + (rev !== true ? 0 : 1));
	});
	opts.animIn.opacity = 1;
	opts.animOut.opacity = 0;
	opts.cssBefore.opacity = 1;
	opts.cssBefore.display = 'block';
	opts.cssAfter.zIndex = 0;
};

// scrollUp/Down/Left/Right
$.fn.cycle.transitions.scrollUp = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var h = $cont.height();
	opts.cssBefore.top = h;
	opts.cssBefore.left = 0;
	opts.cssFirst.top = 0;
	opts.animIn.top = 0;
	opts.animOut.top = -h;
};
$.fn.cycle.transitions.scrollDown = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var h = $cont.height();
	opts.cssFirst.top = 0;
	opts.cssBefore.top = -h;
	opts.cssBefore.left = 0;
	opts.animIn.top = 0;
	opts.animOut.top = h;
};
$.fn.cycle.transitions.scrollLeft = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var w = $cont.width();
	opts.cssFirst.left = 0;
	opts.cssBefore.left = w;
	opts.cssBefore.top = 0;
	opts.animIn.left = 0;
	opts.animOut.left = 0-w;
};
$.fn.cycle.transitions.scrollRight = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var w = $cont.width();
	opts.cssFirst.left = 0;
	opts.cssBefore.left = -w;
	opts.cssBefore.top = 0;
	opts.animIn.left = 0;
	opts.animOut.left = w;
};
$.fn.cycle.transitions.scrollHorz = function($cont, $slides, opts) {
	$cont.css('overflow','hidden').width();
	opts.before.push(function(curr, next, opts, fwd) {
		if (opts.rev)
			fwd = !fwd;
		$.fn.cycle.commonReset(curr,next,opts);
		opts.cssBefore.left = fwd ? (next.cycleW-1) : (1-next.cycleW);
		opts.animOut.left = fwd ? -curr.cycleW : curr.cycleW;
	});
	opts.cssFirst.left = 0;
	opts.cssBefore.top = 0;
	opts.animIn.left = 0;
	opts.animOut.top = 0;
};
$.fn.cycle.transitions.scrollVert = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push(function(curr, next, opts, fwd) {
		if (opts.rev)
			fwd = !fwd;
		$.fn.cycle.commonReset(curr,next,opts);
		opts.cssBefore.top = fwd ? (1-next.cycleH) : (next.cycleH-1);
		opts.animOut.top = fwd ? curr.cycleH : -curr.cycleH;
	});
	opts.cssFirst.top = 0;
	opts.cssBefore.left = 0;
	opts.animIn.top = 0;
	opts.animOut.left = 0;
};

// slideX/slideY
$.fn.cycle.transitions.slideX = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$(opts.elements).not(curr).hide();
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.animIn.width = next.cycleW;
	});
	opts.cssBefore.left = 0;
	opts.cssBefore.top = 0;
	opts.cssBefore.width = 0;
	opts.animIn.width = 'show';
	opts.animOut.width = 0;
};
$.fn.cycle.transitions.slideY = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$(opts.elements).not(curr).hide();
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.animIn.height = next.cycleH;
	});
	opts.cssBefore.left = 0;
	opts.cssBefore.top = 0;
	opts.cssBefore.height = 0;
	opts.animIn.height = 'show';
	opts.animOut.height = 0;
};

// shuffle
$.fn.cycle.transitions.shuffle = function($cont, $slides, opts) {
	var i, w = $cont.css('overflow', 'visible').width();
	$slides.css({left: 0, top: 0});
	opts.before.push(function(curr,next,opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,true,true);
	});
	// only adjust speed once!
	if (!opts.speedAdjusted) {
		opts.speed = opts.speed / 2; // shuffle has 2 transitions
		opts.speedAdjusted = true;
	}
	opts.random = 0;
	opts.shuffle = opts.shuffle || {left:-w, top:15};
	opts.els = [];
	for (i=0; i < $slides.length; i++)
		opts.els.push($slides[i]);

	for (i=0; i < opts.currSlide; i++)
		opts.els.push(opts.els.shift());

	// custom transition fn (hat tip to Benjamin Sterling for this bit of sweetness!)
	opts.fxFn = function(curr, next, opts, cb, fwd) {
		if (opts.rev)
			fwd = !fwd;
		var $el = fwd ? $(curr) : $(next);
		$(next).css(opts.cssBefore);
		var count = opts.slideCount;
		$el.animate(opts.shuffle, opts.speedIn, opts.easeIn, function() {
			var hops = $.fn.cycle.hopsFromLast(opts, fwd);
			for (var k=0; k < hops; k++) {
				if (fwd)
					opts.els.push(opts.els.shift());
				else
					opts.els.unshift(opts.els.pop());
			}
			if (fwd) {
				for (var i=0, len=opts.els.length; i < len; i++)
					$(opts.els[i]).css('z-index', len-i+count);
			}
			else {
				var z = $(curr).css('z-index');
				$el.css('z-index', parseInt(z,10)+1+count);
			}
			$el.animate({left:0, top:0}, opts.speedOut, opts.easeOut, function() {
				$(fwd ? this : curr).hide();
				if (cb) cb();
			});
		});
	};
	$.extend(opts.cssBefore, { display: 'block', opacity: 1, top: 0, left: 0 });
};

// turnUp/Down/Left/Right
$.fn.cycle.transitions.turnUp = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.cssBefore.top = next.cycleH;
		opts.animIn.height = next.cycleH;
		opts.animOut.width = next.cycleW;
	});
	opts.cssFirst.top = 0;
	opts.cssBefore.left = 0;
	opts.cssBefore.height = 0;
	opts.animIn.top = 0;
	opts.animOut.height = 0;
};
$.fn.cycle.transitions.turnDown = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.animIn.height = next.cycleH;
		opts.animOut.top   = curr.cycleH;
	});
	opts.cssFirst.top = 0;
	opts.cssBefore.left = 0;
	opts.cssBefore.top = 0;
	opts.cssBefore.height = 0;
	opts.animOut.height = 0;
};
$.fn.cycle.transitions.turnLeft = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.cssBefore.left = next.cycleW;
		opts.animIn.width = next.cycleW;
	});
	opts.cssBefore.top = 0;
	opts.cssBefore.width = 0;
	opts.animIn.left = 0;
	opts.animOut.width = 0;
};
$.fn.cycle.transitions.turnRight = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.animIn.width = next.cycleW;
		opts.animOut.left = curr.cycleW;
	});
	$.extend(opts.cssBefore, { top: 0, left: 0, width: 0 });
	opts.animIn.left = 0;
	opts.animOut.width = 0;
};

// zoom
$.fn.cycle.transitions.zoom = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,false,true);
		opts.cssBefore.top = next.cycleH/2;
		opts.cssBefore.left = next.cycleW/2;
		$.extend(opts.animIn, { top: 0, left: 0, width: next.cycleW, height: next.cycleH });
		$.extend(opts.animOut, { width: 0, height: 0, top: curr.cycleH/2, left: curr.cycleW/2 });
	});
	opts.cssFirst.top = 0;
	opts.cssFirst.left = 0;
	opts.cssBefore.width = 0;
	opts.cssBefore.height = 0;
};

// fadeZoom
$.fn.cycle.transitions.fadeZoom = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,false);
		opts.cssBefore.left = next.cycleW/2;
		opts.cssBefore.top = next.cycleH/2;
		$.extend(opts.animIn, { top: 0, left: 0, width: next.cycleW, height: next.cycleH });
	});
	opts.cssBefore.width = 0;
	opts.cssBefore.height = 0;
	opts.animOut.opacity = 0;
};

// blindX
$.fn.cycle.transitions.blindX = function($cont, $slides, opts) {
	var w = $cont.css('overflow','hidden').width();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.animIn.width = next.cycleW;
		opts.animOut.left   = curr.cycleW;
	});
	opts.cssBefore.left = w;
	opts.cssBefore.top = 0;
	opts.animIn.left = 0;
	opts.animOut.left = w;
};
// blindY
$.fn.cycle.transitions.blindY = function($cont, $slides, opts) {
	var h = $cont.css('overflow','hidden').height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.animIn.height = next.cycleH;
		opts.animOut.top   = curr.cycleH;
	});
	opts.cssBefore.top = h;
	opts.cssBefore.left = 0;
	opts.animIn.top = 0;
	opts.animOut.top = h;
};
// blindZ
$.fn.cycle.transitions.blindZ = function($cont, $slides, opts) {
	var h = $cont.css('overflow','hidden').height();
	var w = $cont.width();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.animIn.height = next.cycleH;
		opts.animOut.top   = curr.cycleH;
	});
	opts.cssBefore.top = h;
	opts.cssBefore.left = w;
	opts.animIn.top = 0;
	opts.animIn.left = 0;
	opts.animOut.top = h;
	opts.animOut.left = w;
};

// growX - grow horizontally from centered 0 width
$.fn.cycle.transitions.growX = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.cssBefore.left = this.cycleW/2;
		opts.animIn.left = 0;
		opts.animIn.width = this.cycleW;
		opts.animOut.left = 0;
	});
	opts.cssBefore.top = 0;
	opts.cssBefore.width = 0;
};
// growY - grow vertically from centered 0 height
$.fn.cycle.transitions.growY = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.cssBefore.top = this.cycleH/2;
		opts.animIn.top = 0;
		opts.animIn.height = this.cycleH;
		opts.animOut.top = 0;
	});
	opts.cssBefore.height = 0;
	opts.cssBefore.left = 0;
};

// curtainX - squeeze in both edges horizontally
$.fn.cycle.transitions.curtainX = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true,true);
		opts.cssBefore.left = next.cycleW/2;
		opts.animIn.left = 0;
		opts.animIn.width = this.cycleW;
		opts.animOut.left = curr.cycleW/2;
		opts.animOut.width = 0;
	});
	opts.cssBefore.top = 0;
	opts.cssBefore.width = 0;
};
// curtainY - squeeze in both edges vertically
$.fn.cycle.transitions.curtainY = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false,true);
		opts.cssBefore.top = next.cycleH/2;
		opts.animIn.top = 0;
		opts.animIn.height = next.cycleH;
		opts.animOut.top = curr.cycleH/2;
		opts.animOut.height = 0;
	});
	opts.cssBefore.height = 0;
	opts.cssBefore.left = 0;
};

// cover - curr slide covered by next slide
$.fn.cycle.transitions.cover = function($cont, $slides, opts) {
	var d = opts.direction || 'left';
	var w = $cont.css('overflow','hidden').width();
	var h = $cont.height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.cssAfter.display = '';
		if (d == 'right')
			opts.cssBefore.left = -w;
		else if (d == 'up')
			opts.cssBefore.top = h;
		else if (d == 'down')
			opts.cssBefore.top = -h;
		else
			opts.cssBefore.left = w;
	});
	opts.animIn.left = 0;
	opts.animIn.top = 0;
	opts.cssBefore.top = 0;
	opts.cssBefore.left = 0;
};

// uncover - curr slide moves off next slide
$.fn.cycle.transitions.uncover = function($cont, $slides, opts) {
	var d = opts.direction || 'left';
	var w = $cont.css('overflow','hidden').width();
	var h = $cont.height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,true,true);
		if (d == 'right')
			opts.animOut.left = w;
		else if (d == 'up')
			opts.animOut.top = -h;
		else if (d == 'down')
			opts.animOut.top = h;
		else
			opts.animOut.left = -w;
	});
	opts.animIn.left = 0;
	opts.animIn.top = 0;
	opts.cssBefore.top = 0;
	opts.cssBefore.left = 0;
};

// toss - move top slide and fade away
$.fn.cycle.transitions.toss = function($cont, $slides, opts) {
	var w = $cont.css('overflow','visible').width();
	var h = $cont.height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,true,true);
		// provide default toss settings if animOut not provided
		if (!opts.animOut.left && !opts.animOut.top)
			$.extend(opts.animOut, { left: w*2, top: -h/2, opacity: 0 });
		else
			opts.animOut.opacity = 0;
	});
	opts.cssBefore.left = 0;
	opts.cssBefore.top = 0;
	opts.animIn.left = 0;
};

// wipe - clip animation
$.fn.cycle.transitions.wipe = function($cont, $slides, opts) {
	var w = $cont.css('overflow','hidden').width();
	var h = $cont.height();
	opts.cssBefore = opts.cssBefore || {};
	var clip;
	if (opts.clip) {
		if (/l2r/.test(opts.clip))
			clip = 'rect(0px 0px '+h+'px 0px)';
		else if (/r2l/.test(opts.clip))
			clip = 'rect(0px '+w+'px '+h+'px '+w+'px)';
		else if (/t2b/.test(opts.clip))
			clip = 'rect(0px '+w+'px 0px 0px)';
		else if (/b2t/.test(opts.clip))
			clip = 'rect('+h+'px '+w+'px '+h+'px 0px)';
		else if (/zoom/.test(opts.clip)) {
			var top = parseInt(h/2,10);
			var left = parseInt(w/2,10);
			clip = 'rect('+top+'px '+left+'px '+top+'px '+left+'px)';
		}
	}

	opts.cssBefore.clip = opts.cssBefore.clip || clip || 'rect(0px 0px 0px 0px)';

	var d = opts.cssBefore.clip.match(/(\d+)/g);
	var t = parseInt(d[0],10), r = parseInt(d[1],10), b = parseInt(d[2],10), l = parseInt(d[3],10);

	opts.before.push(function(curr, next, opts) {
		if (curr == next) return;
		var $curr = $(curr), $next = $(next);
		$.fn.cycle.commonReset(curr,next,opts,true,true,false);
		opts.cssAfter.display = 'block';

		var step = 1, count = parseInt((opts.speedIn / 13),10) - 1;
		(function f() {
			var tt = t ? t - parseInt(step * (t/count),10) : 0;
			var ll = l ? l - parseInt(step * (l/count),10) : 0;
			var bb = b < h ? b + parseInt(step * ((h-b)/count || 1),10) : h;
			var rr = r < w ? r + parseInt(step * ((w-r)/count || 1),10) : w;
			$next.css({ clip: 'rect('+tt+'px '+rr+'px '+bb+'px '+ll+'px)' });
			(step++ <= count) ? setTimeout(f, 13) : $curr.css('display', 'none');
		})();
	});
	$.extend(opts.cssBefore, { display: 'block', opacity: 1, top: 0, left: 0 });
	opts.animIn	   = { left: 0 };
	opts.animOut   = { left: 0 };
};

})(jQuery);

/**
 * Copyright (c) 2007-2012 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.3.1
 */
;(function($){var h=$.scrollTo=function(a,b,c){$(window).scrollTo(a,b,c)};h.defaults={axis:'xy',duration:parseFloat($.fn.jquery)>=1.3?0:1,limit:true};h.window=function(a){return $(window)._scrollable()};$.fn._scrollable=function(){return this.map(function(){var a=this,isWin=!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!isWin)return a;var b=(a.contentWindow||a).document||a.ownerDocument||a;return/webkit/i.test(navigator.userAgent)||b.compatMode=='BackCompat'?b.body:b.documentElement})};$.fn.scrollTo=function(e,f,g){if(typeof f=='object'){g=f;f=0}if(typeof g=='function')g={onAfter:g};if(e=='max')e=9e9;g=$.extend({},h.defaults,g);f=f||g.duration;g.queue=g.queue&&g.axis.length>1;if(g.queue)f/=2;g.offset=both(g.offset);g.over=both(g.over);return this._scrollable().each(function(){if(e==null)return;var d=this,$elem=$(d),targ=e,toff,attr={},win=$elem.is('html,body');switch(typeof targ){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=$(targ,this);if(!targ.length)return;case'object':if(targ.is||targ.style)toff=(targ=$(targ)).offset()}$.each(g.axis.split(''),function(i,a){var b=a=='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,old=d[key],max=h.max(d,a);if(toff){attr[key]=toff[pos]+(win?0:old-$elem.offset()[pos]);if(g.margin){attr[key]-=parseInt(targ.css('margin'+b))||0;attr[key]-=parseInt(targ.css('border'+b+'Width'))||0}attr[key]+=g.offset[pos]||0;if(g.over[pos])attr[key]+=targ[a=='x'?'width':'height']()*g.over[pos]}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)=='%'?parseFloat(c)/100*max:c}if(g.limit&&/^\d+$/.test(attr[key]))attr[key]=attr[key]<=0?0:Math.min(attr[key],max);if(!i&&g.queue){if(old!=attr[key])animate(g.onAfterFirst);delete attr[key]}});animate(g.onAfter);function animate(a){$elem.animate(attr,f,g.easing,a&&function(){a.call(this,e,g)})}}).end()};h.max=function(a,b){var c=b=='x'?'Width':'Height',scroll='scroll'+c;if(!$(a).is('html,body'))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,html=a.ownerDocument.documentElement,body=a.ownerDocument.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);
/*!
	Autosize v1.18.4 - 2014-01-11
	Automatically adjust textarea height based on user input.
	(c) 2014 Jack Moore - http://www.jacklmoore.com/autosize
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function ($) {
	var
	defaults = {
		className: 'autosizejs',
		append: '',
		callback: false,
		resizeDelay: 30,
		placeholder: true
	},

	// border:0 is unnecessary, but avoids a bug in Firefox on OSX
	copy = '<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',

	// line-height is conditionally included because IE7/IE8/old Opera do not return the correct value.
	typographyStyles = [
		'fontFamily',
		'fontSize',
		'fontWeight',
		'fontStyle',
		'letterSpacing',
		'textTransform',
		'wordSpacing',
		'textIndent'
	],

	// to keep track which textarea is being mirrored when adjust() is called.
	mirrored,

	// the mirror element, which is used to calculate what size the mirrored element should be.
	mirror = $(copy).data('autosize', true)[0];

	// test that line-height can be accurately copied.
	mirror.style.lineHeight = '99px';
	if ($(mirror).css('lineHeight') === '99px') {
		typographyStyles.push('lineHeight');
	}
	mirror.style.lineHeight = '';

	$.fn.autosize = function (options) {
		if (!this.length) {
			return this;
		}

		options = $.extend({}, defaults, options || {});

		if (mirror.parentNode !== document.body) {
			$(document.body).append(mirror);
		}

		return this.each(function () {
			var
			ta = this,
			$ta = $(ta),
			maxHeight,
			minHeight,
			boxOffset = 0,
			callback = $.isFunction(options.callback),
			originalStyles = {
				height: ta.style.height,
				overflow: ta.style.overflow,
				overflowY: ta.style.overflowY,
				wordWrap: ta.style.wordWrap,
				resize: ta.style.resize
			},
			timeout,
			width = $ta.width();

			if ($ta.data('autosize')) {
				// exit if autosize has already been applied, or if the textarea is the mirror element.
				return;
			}
			$ta.data('autosize', true);

			if ($ta.css('box-sizing') === 'border-box' || $ta.css('-moz-box-sizing') === 'border-box' || $ta.css('-webkit-box-sizing') === 'border-box'){
				boxOffset = $ta.outerHeight() - $ta.height();
			}

			// IE8 and lower return 'auto', which parses to NaN, if no min-height is set.
			minHeight = Math.max(parseInt($ta.css('minHeight'), 10) - boxOffset || 0, $ta.height());

			$ta.css({
				overflow: 'hidden',
				overflowY: 'hidden',
				wordWrap: 'break-word', // horizontal overflow is hidden, so break-word is necessary for handling words longer than the textarea width
				resize: ($ta.css('resize') === 'none' || $ta.css('resize') === 'vertical') ? 'none' : 'horizontal'
			});

			// The mirror width must exactly match the textarea width, so using getBoundingClientRect because it doesn't round the sub-pixel value.
			// window.getComputedStyle, getBoundingClientRect returning a width are unsupported, but also unneeded in IE8 and lower.
			function setWidth() {
				var width;
				var style = window.getComputedStyle ? window.getComputedStyle(ta, null) : false;
				
				if (style) {

					width = ta.getBoundingClientRect().width;

					if (width === 0) {
						width = parseInt(style.width,10);
					}

					$.each(['paddingLeft', 'paddingRight', 'borderLeftWidth', 'borderRightWidth'], function(i,val){
						width -= parseInt(style[val],10);
					});
				} else {
					width = Math.max($ta.width(), 0);
				}

				mirror.style.width = width + 'px';
			}

			function initMirror() {
				var styles = {};

				mirrored = ta;
				mirror.className = options.className;
				maxHeight = parseInt($ta.css('maxHeight'), 10);

				// mirror is a duplicate textarea located off-screen that
				// is automatically updated to contain the same text as the
				// original textarea.  mirror always has a height of 0.
				// This gives a cross-browser supported way getting the actual
				// height of the text, through the scrollTop property.
				$.each(typographyStyles, function(i,val){
					styles[val] = $ta.css(val);
				});
				$(mirror).css(styles);

				setWidth();

				// Chrome-specific fix:
				// When the textarea y-overflow is hidden, Chrome doesn't reflow the text to account for the space
				// made available by removing the scrollbar. This workaround triggers the reflow for Chrome.
				if (window.chrome) {
					var width = ta.style.width;
					ta.style.width = '0px';
					var ignore = ta.offsetWidth;
					ta.style.width = width;
				}
			}

			// Using mainly bare JS in this function because it is going
			// to fire very often while typing, and needs to very efficient.
			function adjust() {
				var height, original;

				if (mirrored !== ta) {
					initMirror();
				} else {
					setWidth();
				}

				if (!ta.value && options.placeholder) {
					// If the textarea is empty, copy the placeholder text into 
					// the mirror control and use that for sizing so that we 
					// don't end up with placeholder getting trimmed.
					mirror.value = ($(ta).attr("placeholder") || '') + options.append;
				} else {
					mirror.value = ta.value + options.append;
				}

				mirror.style.overflowY = ta.style.overflowY;
				original = parseInt(ta.style.height,10);

				// Setting scrollTop to zero is needed in IE8 and lower for the next step to be accurately applied
				mirror.scrollTop = 0;

				mirror.scrollTop = 9e4;

				// Using scrollTop rather than scrollHeight because scrollHeight is non-standard and includes padding.
				height = mirror.scrollTop;

				if (maxHeight && height > maxHeight) {
					ta.style.overflowY = 'scroll';
					height = maxHeight;
				} else {
					ta.style.overflowY = 'hidden';
					if (height < minHeight) {
						height = minHeight;
					}
				}

				height += boxOffset;

				if (original !== height) {
					ta.style.height = height + 'px';
					if (callback) {
						options.callback.call(ta,ta);
					}
				}
			}

			function resize () {
				clearTimeout(timeout);
				timeout = setTimeout(function(){
					var newWidth = $ta.width();

					if (newWidth !== width) {
						width = newWidth;
						adjust();
					}
				}, parseInt(options.resizeDelay,10));
			}

			if ('onpropertychange' in ta) {
				if ('oninput' in ta) {
					// Detects IE9.  IE9 does not fire onpropertychange or oninput for deletions,
					// so binding to onkeyup to catch most of those occasions.  There is no way that I
					// know of to detect something like 'cut' in IE9.
					$ta.on('input.autosize keyup.autosize', adjust);
				} else {
					// IE7 / IE8
					$ta.on('propertychange.autosize', function(){
						if(event.propertyName === 'value'){
							adjust();
						}
					});
				}
			} else {
				// Modern Browsers
				$ta.on('input.autosize', adjust);
			}

			// Set options.resizeDelay to false if using fixed-width textarea elements.
			// Uses a timeout and width check to reduce the amount of times adjust needs to be called after window resize.

			if (options.resizeDelay !== false) {
				$(window).on('resize.autosize', resize);
			}

			// Event for manual triggering if needed.
			// Should only be needed when the value of the textarea is changed through JavaScript rather than user input.
			$ta.on('autosize.resize', adjust);

			// Event for manual triggering that also forces the styles to update as well.
			// Should only be needed if one of typography styles of the textarea change, and the textarea is already the target of the adjust method.
			$ta.on('autosize.resizeIncludeStyle', function() {
				mirrored = null;
				adjust();
			});

			$ta.on('autosize.destroy', function(){
				mirrored = null;
				clearTimeout(timeout);
				$(window).off('resize', resize);
				$ta
					.off('autosize')
					.off('.autosize')
					.css(originalStyles)
					.removeData('autosize');
			});

			// Call adjust in case the textarea already contains text.
			adjust();
		});
	};
}(window.jQuery || window.$)); // jQuery or jQuery-like library, such as Zepto

$(function(){
    /**
     * Refreshable record list
     */
    var blocked = false;
    var $list = $('.record-list-ajax');
    var fadeTimeout = 200;
    var showTimeout = 50;
    var $loader = $('<img src="/default/i/ajax-loader.gif" />').css({
        display: 'block',
        margin: '20px auto'
    });

    if( 1 !== $list.length ) return false;

    var loadRecords = function()
    {
        if( blocked ) return false;

        if( $(window).scrollTop() + $(window).height() * 1.5 < $(document).height() ) return false;

        blocked = true;
        $loader.insertAfter($list);

        $.ajax({
            url: $list.data('ajax-url'),
            data: { offset: $list.find('.record-list-ajax-element').size() },
            dataType: 'html',
            success:  function( data )
            {
                var $elements = $(data).filter('.record-list-ajax-element');
                $loader.remove();


                if( ! $elements.length ) {
                    return $(window).off('scroll.recordsLoad');
                }

                $elements.hide();
                $list.append($elements);
                blocked = false;

                var $aQueue = $({});

                $elements.each(function(i, el){
                    $aQueue.queue('show-block', function(next) {
                        $(el).fadeIn(fadeTimeout, function(){
                            var thLi = $(this),
                                thCommentHeight = thLi.find(".comment_text_inner").height(),
                                btnToggleComment = $("<a href='#' class='toggle_data'><span class='show_more'>Развернуть</span><span class='show_less'>Свернуть</span></a>");

                            if ( thCommentHeight > 130 && thCommentHeight < 360 ){
                                thLi.attr("data-size", "x2").find(".comment_text_outer").after(btnToggleComment);
                            } else if ( thCommentHeight > 360 ) {
                                thLi.attr("data-size", "x3").find(".comment_text_outer").after(btnToggleComment);
                            }
                        });
                        setTimeout(next, showTimeout);
                    });
                });

                $aQueue.dequeue('show-block');
            }
        });
    };

    $(window).on('scroll.recordsLoad', function(){
        loadRecords();
    });

    loadRecords();

});

$(document).ready(function(){
    $('[data-comment=add]').each(function(){
        var $self = $(this),
            $form = $self.find('form');

        $form.on('submit', function(){
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method') || 'POST',
                data: $form.serialize(),
                timeout: 10000,
                success: function(response) {
                    var $comment = jQuery(response);
                    $comment.insertBefore($self);
                },
                error: function(response) {
                    alert(response);
                }
            });

            return false;
        });

    });
});
$(document).ready(function(){
    $('.vacancy-top-bg').on('click', function(){
        if($(this).parents('.vacancy-block').hasClass('active')){
            $(this).parents('.vacancy-block').find('.vacancy-block-arrow-text').text('Развернуть');
            $(this).parents('.vacancy-block').removeClass('active');
            return false;
        } else {
            $(this).parents('.vacancy-main-block').find('.vacancy-block').removeClass('active');
            $(this).parents('.vacancy-main-block').find('.vacancy-block .vacancy-block-arrow-text').text('Развернуть');
            $(this).parents('.vacancy-block').addClass('active');
            $(this).parents('.vacancy-block').find('.vacancy-block-arrow-text').text('Свернуть');
            return false;
        }
    });

    $(".slide_to_work_form").on("click", function(){
        var vacancy_id = $(this).data('id');
        if(vacancy_id != undefined) {
            $('select[name=vacancy]').val(vacancy_id);
        }
        $.scrollTo(".b_form_content", 300);
        return false;
    });
});
/*!
 * jCarousel - Riding carousels with jQuery
 *   http://sorgalla.com/jcarousel/
 *
 * Copyright (c) 2006 Jan Sorgalla (http://sorgalla.com)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Built on top of the jQuery library
 *   http://jquery.com
 *
 * Inspired by the "Carousel Component" by Bill Scott
 *   http://billwscott.com/carousel/
 */

(function(a){var b={vertical:!1,rtl:!1,start:1,offset:1,size:null,scroll:3,visible:null,animation:"normal",easing:"swing",auto:0,wrap:null,initCallback:null,setupCallback:null,reloadCallback:null,itemLoadCallback:null,itemFirstInCallback:null,itemFirstOutCallback:null,itemLastInCallback:null,itemLastOutCallback:null,itemVisibleInCallback:null,itemVisibleOutCallback:null,animationStepCallback:null,buttonNextHTML:"<div></div>",buttonPrevHTML:"<div></div>",buttonNextEvent:"click",buttonPrevEvent:"click",buttonNextCallback:null,buttonPrevCallback:null,itemFallbackDimension:null},c=!1;a(window).bind("load.jcarousel",function(){c=!0}),a.jcarousel=function(e,f){this.options=a.extend({},b,f||{}),this.locked=!1,this.autoStopped=!1,this.container=null,this.clip=null,this.list=null,this.buttonNext=null,this.buttonPrev=null,this.buttonNextState=null,this.buttonPrevState=null,f&&void 0!==f.rtl||(this.options.rtl="rtl"==(a(e).attr("dir")||a("html").attr("dir")||"").toLowerCase()),this.wh=this.options.vertical?"height":"width",this.lt=this.options.vertical?"top":this.options.rtl?"right":"left";for(var g="",h=e.className.split(" "),i=0;h.length>i;i++)if(-1!=h[i].indexOf("jcarousel-skin")){a(e).removeClass(h[i]),g=h[i];break}"UL"==e.nodeName.toUpperCase()||"OL"==e.nodeName.toUpperCase()?(this.list=a(e),this.clip=this.list.parents(".jcarousel-clip"),this.container=this.list.parents(".jcarousel-container")):(this.container=a(e),this.list=this.container.find("ul,ol").eq(0),this.clip=this.container.find(".jcarousel-clip")),0===this.clip.size()&&(this.clip=this.list.wrap("<div></div>").parent()),0===this.container.size()&&(this.container=this.clip.wrap("<div></div>").parent()),""!==g&&-1==this.container.parent()[0].className.indexOf("jcarousel-skin")&&this.container.wrap('<div class=" '+g+'"></div>'),this.buttonPrev=a(".jcarousel-prev",this.container),0===this.buttonPrev.size()&&null!==this.options.buttonPrevHTML&&(this.buttonPrev=a(this.options.buttonPrevHTML).appendTo(this.container)),this.buttonPrev.addClass(this.className("jcarousel-prev")),this.buttonNext=a(".jcarousel-next",this.container),0===this.buttonNext.size()&&null!==this.options.buttonNextHTML&&(this.buttonNext=a(this.options.buttonNextHTML).appendTo(this.container)),this.buttonNext.addClass(this.className("jcarousel-next")),this.clip.addClass(this.className("jcarousel-clip")).css({position:"relative"}),this.list.addClass(this.className("jcarousel-list")).css({overflow:"hidden",position:"relative",top:0,margin:0,padding:0}).css(this.options.rtl?"right":"left",0),this.container.addClass(this.className("jcarousel-container")).css({position:"relative"}),!this.options.vertical&&this.options.rtl&&this.container.addClass("jcarousel-direction-rtl").attr("dir","rtl");var j=null!==this.options.visible?Math.ceil(this.clipping()/this.options.visible):null,k=this.list.children("li"),l=this;if(k.size()>0){var m=0,n=this.options.offset;k.each(function(){l.format(this,n++),m+=l.dimension(this,j)}),this.list.css(this.wh,m+100+"px"),f&&void 0!==f.size||(this.options.size=k.size())}this.container.css("display","block"),this.buttonNext.css("display","block"),this.buttonPrev.css("display","block"),this.funcNext=function(){return l.next(),!1},this.funcPrev=function(){return l.prev(),!1},this.funcResize=function(){l.resizeTimer&&clearTimeout(l.resizeTimer),l.resizeTimer=setTimeout(function(){l.reload()},100)},null!==this.options.initCallback&&this.options.initCallback(this,"init"),!c&&d.isSafari()?(this.buttons(!1,!1),a(window).bind("load.jcarousel",function(){l.setup()})):this.setup()};var d=a.jcarousel;d.fn=d.prototype={jcarousel:"0.2.9"},d.fn.extend=d.extend=a.extend,d.fn.extend({setup:function(){if(this.first=null,this.last=null,this.prevFirst=null,this.prevLast=null,this.animating=!1,this.timer=null,this.resizeTimer=null,this.tail=null,this.inTail=!1,!this.locked){this.list.css(this.lt,this.pos(this.options.offset)+"px");var b=this.pos(this.options.start,!0);this.prevFirst=this.prevLast=null,this.animate(b,!1),a(window).unbind("resize.jcarousel",this.funcResize).bind("resize.jcarousel",this.funcResize),null!==this.options.setupCallback&&this.options.setupCallback(this)}},reset:function(){this.list.empty(),this.list.css(this.lt,"0px"),this.list.css(this.wh,"10px"),null!==this.options.initCallback&&this.options.initCallback(this,"reset"),this.setup()},reload:function(){if(null!==this.tail&&this.inTail&&this.list.css(this.lt,d.intval(this.list.css(this.lt))+this.tail),this.tail=null,this.inTail=!1,null!==this.options.reloadCallback&&this.options.reloadCallback(this),null!==this.options.visible){var a=this,b=Math.ceil(this.clipping()/this.options.visible),c=0,e=0;this.list.children("li").each(function(d){c+=a.dimension(this,b),a.first>d+1&&(e=c)}),this.list.css(this.wh,c+"px"),this.list.css(this.lt,-e+"px")}this.scroll(this.first,!1)},lock:function(){this.locked=!0,this.buttons()},unlock:function(){this.locked=!1,this.buttons()},size:function(a){return void 0!==a&&(this.options.size=a,this.locked||this.buttons()),this.options.size},has:function(a,b){void 0!==b&&b||(b=a),null!==this.options.size&&b>this.options.size&&(b=this.options.size);for(var c=a;b>=c;c++){var d=this.get(c);if(!d.length||d.hasClass("jcarousel-item-placeholder"))return!1}return!0},get:function(b){return a(">.jcarousel-item-"+b,this.list)},add:function(b,c){var e=this.get(b),f=0,g=a(c);if(0===e.length){var h,i=d.intval(b);for(e=this.create(b);;)if(h=this.get(--i),0>=i||h.length){0>=i?this.list.prepend(e):h.after(e);break}}else f=this.dimension(e);"LI"==g.get(0).nodeName.toUpperCase()?(e.replaceWith(g),e=g):e.empty().append(c),this.format(e.removeClass(this.className("jcarousel-item-placeholder")),b);var j=null!==this.options.visible?Math.ceil(this.clipping()/this.options.visible):null,k=this.dimension(e,j)-f;return b>0&&this.first>b&&this.list.css(this.lt,d.intval(this.list.css(this.lt))-k+"px"),this.list.css(this.wh,d.intval(this.list.css(this.wh))+k+"px"),e},remove:function(a){var b=this.get(a);if(b.length&&!(a>=this.first&&this.last>=a)){var c=this.dimension(b);this.first>a&&this.list.css(this.lt,d.intval(this.list.css(this.lt))+c+"px"),b.remove(),this.list.css(this.wh,d.intval(this.list.css(this.wh))-c+"px")}},next:function(){null===this.tail||this.inTail?this.scroll("both"!=this.options.wrap&&"last"!=this.options.wrap||null===this.options.size||this.last!=this.options.size?this.first+this.options.scroll:1):this.scrollTail(!1)},prev:function(){null!==this.tail&&this.inTail?this.scrollTail(!0):this.scroll("both"!=this.options.wrap&&"first"!=this.options.wrap||null===this.options.size||1!=this.first?this.first-this.options.scroll:this.options.size)},scrollTail:function(a){if(!this.locked&&!this.animating&&this.tail){this.pauseAuto();var b=d.intval(this.list.css(this.lt));b=a?b+this.tail:b-this.tail,this.inTail=!a,this.prevFirst=this.first,this.prevLast=this.last,this.animate(b)}},scroll:function(a,b){this.locked||this.animating||(this.pauseAuto(),this.animate(this.pos(a),b))},pos:function(a,b){var c=d.intval(this.list.css(this.lt));if(this.locked||this.animating)return c;"circular"!=this.options.wrap&&(a=1>a?1:this.options.size&&a>this.options.size?this.options.size:a);for(var m,e=this.first>a,f="circular"!=this.options.wrap&&1>=this.first?1:this.first,g=e?this.get(f):this.get(this.last),h=e?f:f-1,i=null,j=0,k=!1,l=0;e?--h>=a:a>++h;)i=this.get(h),k=!i.length,0===i.length&&(i=this.create(h).addClass(this.className("jcarousel-item-placeholder")),g[e?"before":"after"](i),null!==this.first&&"circular"==this.options.wrap&&null!==this.options.size&&(0>=h||h>this.options.size)&&(m=this.get(this.index(h)),m.length&&(i=this.add(h,m.clone(!0))))),g=i,l=this.dimension(i),k&&(j+=l),null!==this.first&&("circular"==this.options.wrap||h>=1&&(null===this.options.size||this.options.size>=h))&&(c=e?c+l:c-l);var n=this.clipping(),o=[],p=0,q=0;for(g=this.get(a-1),h=a;++p;){if(i=this.get(h),k=!i.length,0===i.length&&(i=this.create(h).addClass(this.className("jcarousel-item-placeholder")),0===g.length?this.list.prepend(i):g[e?"before":"after"](i),null!==this.first&&"circular"==this.options.wrap&&null!==this.options.size&&(0>=h||h>this.options.size)&&(m=this.get(this.index(h)),m.length&&(i=this.add(h,m.clone(!0))))),g=i,l=this.dimension(i),0===l)throw Error("jCarousel: No width/height set for items. This will cause an infinite loop. Aborting...");if("circular"!=this.options.wrap&&null!==this.options.size&&h>this.options.size?o.push(i):k&&(j+=l),q+=l,q>=n)break;h++}for(var r=0;o.length>r;r++)o[r].remove();j>0&&(this.list.css(this.wh,this.dimension(this.list)+j+"px"),e&&(c-=j,this.list.css(this.lt,d.intval(this.list.css(this.lt))-j+"px")));var s=a+p-1;if("circular"!=this.options.wrap&&this.options.size&&s>this.options.size&&(s=this.options.size),h>s)for(p=0,h=s,q=0;++p&&(i=this.get(h--),i.length)&&(q+=this.dimension(i),!(q>=n)););var t=s-p+1;if("circular"!=this.options.wrap&&1>t&&(t=1),this.inTail&&e&&(c+=this.tail,this.inTail=!1),this.tail=null,"circular"!=this.options.wrap&&s==this.options.size&&s-p+1>=1){var u=d.intval(this.get(s).css(this.options.vertical?"marginBottom":"marginRight"));q-u>n&&(this.tail=q-n-u)}for(b&&a===this.options.size&&this.tail&&(c-=this.tail,this.inTail=!0);a-->t;)c+=this.dimension(this.get(a));return this.prevFirst=this.first,this.prevLast=this.last,this.first=t,this.last=s,c},animate:function(b,c){if(!this.locked&&!this.animating){this.animating=!0;var d=this,e=function(){if(d.animating=!1,0===b&&d.list.css(d.lt,0),!d.autoStopped&&("circular"==d.options.wrap||"both"==d.options.wrap||"last"==d.options.wrap||null===d.options.size||d.last<d.options.size||d.last==d.options.size&&null!==d.tail&&!d.inTail)&&d.startAuto(),d.buttons(),d.notify("onAfterAnimation"),"circular"==d.options.wrap&&null!==d.options.size)for(var a=d.prevFirst;d.prevLast>=a;a++)null===a||a>=d.first&&d.last>=a||!(1>a||a>d.options.size)||d.remove(a)};if(this.notify("onBeforeAnimation"),this.options.animation&&c!==!1){var f=this.options.vertical?{top:b}:this.options.rtl?{right:b}:{left:b},g={duration:this.options.animation,easing:this.options.easing,complete:e};a.isFunction(this.options.animationStepCallback)&&(g.step=this.options.animationStepCallback),this.list.animate(f,g)}else this.list.css(this.lt,b+"px"),e()}},startAuto:function(a){if(void 0!==a&&(this.options.auto=a),0===this.options.auto)return this.stopAuto();if(null===this.timer){this.autoStopped=!1;var b=this;this.timer=window.setTimeout(function(){b.next()},1e3*this.options.auto)}},stopAuto:function(){this.pauseAuto(),this.autoStopped=!0},pauseAuto:function(){null!==this.timer&&(window.clearTimeout(this.timer),this.timer=null)},buttons:function(a,b){null==a&&(a=!this.locked&&0!==this.options.size&&(this.options.wrap&&"first"!=this.options.wrap||null===this.options.size||this.last<this.options.size),this.locked||this.options.wrap&&"first"!=this.options.wrap||null===this.options.size||!(this.last>=this.options.size)||(a=null!==this.tail&&!this.inTail)),null==b&&(b=!this.locked&&0!==this.options.size&&(this.options.wrap&&"last"!=this.options.wrap||this.first>1),this.locked||this.options.wrap&&"last"!=this.options.wrap||null===this.options.size||1!=this.first||(b=null!==this.tail&&this.inTail));var c=this;this.buttonNext.size()>0?(this.buttonNext.unbind(this.options.buttonNextEvent+".jcarousel",this.funcNext),a&&this.buttonNext.bind(this.options.buttonNextEvent+".jcarousel",this.funcNext),this.buttonNext[a?"removeClass":"addClass"](this.className("jcarousel-next-disabled")).attr("disabled",a?!1:!0),null!==this.options.buttonNextCallback&&this.buttonNext.data("jcarouselstate")!=a&&this.buttonNext.each(function(){c.options.buttonNextCallback(c,this,a)}).data("jcarouselstate",a)):null!==this.options.buttonNextCallback&&this.buttonNextState!=a&&this.options.buttonNextCallback(c,null,a),this.buttonPrev.size()>0?(this.buttonPrev.unbind(this.options.buttonPrevEvent+".jcarousel",this.funcPrev),b&&this.buttonPrev.bind(this.options.buttonPrevEvent+".jcarousel",this.funcPrev),this.buttonPrev[b?"removeClass":"addClass"](this.className("jcarousel-prev-disabled")).attr("disabled",b?!1:!0),null!==this.options.buttonPrevCallback&&this.buttonPrev.data("jcarouselstate")!=b&&this.buttonPrev.each(function(){c.options.buttonPrevCallback(c,this,b)}).data("jcarouselstate",b)):null!==this.options.buttonPrevCallback&&this.buttonPrevState!=b&&this.options.buttonPrevCallback(c,null,b),this.buttonNextState=a,this.buttonPrevState=b},notify:function(a){var b=null===this.prevFirst?"init":this.prevFirst<this.first?"next":"prev";this.callback("itemLoadCallback",a,b),this.prevFirst!==this.first&&(this.callback("itemFirstInCallback",a,b,this.first),this.callback("itemFirstOutCallback",a,b,this.prevFirst)),this.prevLast!==this.last&&(this.callback("itemLastInCallback",a,b,this.last),this.callback("itemLastOutCallback",a,b,this.prevLast)),this.callback("itemVisibleInCallback",a,b,this.first,this.last,this.prevFirst,this.prevLast),this.callback("itemVisibleOutCallback",a,b,this.prevFirst,this.prevLast,this.first,this.last)},callback:function(b,c,d,e,f,g,h){if(null!=this.options[b]&&("object"==typeof this.options[b]||"onAfterAnimation"==c)){var i="object"==typeof this.options[b]?this.options[b][c]:this.options[b];if(a.isFunction(i)){var j=this;if(void 0===e)i(j,d,c);else if(void 0===f)this.get(e).each(function(){i(j,this,e,d,c)});else for(var k=function(a){j.get(a).each(function(){i(j,this,a,d,c)})},l=e;f>=l;l++)null===l||l>=g&&h>=l||k(l)}}},create:function(a){return this.format("<li></li>",a)},format:function(b,c){b=a(b);for(var d=b.get(0).className.split(" "),e=0;d.length>e;e++)-1!=d[e].indexOf("jcarousel-")&&b.removeClass(d[e]);return b.addClass(this.className("jcarousel-item")).addClass(this.className("jcarousel-item-"+c)).css({"float":this.options.rtl?"right":"left","list-style":"none"}).attr("jcarouselindex",c),b},className:function(a){return a+" "+a+(this.options.vertical?"-vertical":"-horizontal")},dimension:function(b,c){var e=a(b);if(null==c)return this.options.vertical?e.innerHeight()+d.intval(e.css("margin-top"))+d.intval(e.css("margin-bottom"))+d.intval(e.css("border-top-width"))+d.intval(e.css("border-bottom-width"))||d.intval(this.options.itemFallbackDimension):e.innerWidth()+d.intval(e.css("margin-left"))+d.intval(e.css("margin-right"))+d.intval(e.css("border-left-width"))+d.intval(e.css("border-right-width"))||d.intval(this.options.itemFallbackDimension);var f=this.options.vertical?c-d.intval(e.css("marginTop"))-d.intval(e.css("marginBottom")):c-d.intval(e.css("marginLeft"))-d.intval(e.css("marginRight"));return a(e).css(this.wh,f+"px"),this.dimension(e)},clipping:function(){return this.options.vertical?this.clip[0].offsetHeight-d.intval(this.clip.css("borderTopWidth"))-d.intval(this.clip.css("borderBottomWidth")):this.clip[0].offsetWidth-d.intval(this.clip.css("borderLeftWidth"))-d.intval(this.clip.css("borderRightWidth"))},index:function(a,b){return null==b&&(b=this.options.size),Math.round(((a-1)/b-Math.floor((a-1)/b))*b)+1}}),d.extend({defaults:function(c){return a.extend(b,c||{})},intval:function(a){return a=parseInt(a,10),isNaN(a)?0:a},windowLoaded:function(){c=!0},isSafari:function(){var a=navigator.userAgent.toLowerCase(),b=/(chrome)[ \/]([\w.]+)/.exec(a)||/(webkit)[ \/]([\w.]+)/.exec(a)||[],c=b[1]||"";return"webkit"===c}}),a.fn.jcarousel=function(b){if("string"==typeof b){var c=a(this).data("jcarousel"),e=Array.prototype.slice.call(arguments,1);return c[b].apply(c,e)}return this.each(function(){var c=a(this).data("jcarousel");c?(b&&a.extend(c.options,b),c.reload()):a(this).data("jcarousel",new d(this,b))})}})(jQuery);

function moveCaretToEnd(el)
{
    if (typeof el.selectionStart == "number") {
        el.selectionStart = el.selectionEnd = el.value.length;
    } else if (typeof el.createTextRange != "undefined") {
        el.focus();
        var range = el.createTextRange();
        range.collapse(false);
        range.select();
    }
}

var Comment = function(selector) {
    var $self = $(this),
        selectors = {
            container:          '.comment-container-js',
            reply:              '.reply-js',
            textarea:           '.comment-reply-textarea-js',
            comment:            '.comment-js',
            commentList:        '.comment-list-js',
            commentMainForm:    '.comment-main-form-js',
            commentForm:        '.comment-form-js',
            commentFormCopy:    '.comment-form-copy-js',
            commentCount:       '.comment-count-js',
            commentDelete:      '.comment-delete-js',
            commentRestore:     '.comment-restore-js',
            commentLevel1:      '.comment-level1-js',
            commentLeaf:        '.comment-leaf-js',
            commentMore:        '.comment-more-js',
            commentMoreLoading: '.comment-more-loading-js',
            commentDeleteUser:  '.comment-delete-user-js',
            commentBanUser:     '.comment-ban-user-js',
            commentBlockUser:   '.comment-block-user-js',
            commentSubmit:      '.js-form-submit'
        };

    this.init = function() {
        //Клик на textarea комментария
        $(document).on('focus', selectors.textarea, function() {
            if (!isAuthorized(this)) {
                return showLogin(this);
            }

            $(this).siblings('input').show();
            $(this).siblings('a.send').removeClass('hidden');

            moveCaretToEnd(this);

            // Work around Chrome's little problem
            this.onmouseup = function() {
                // Prevent further mouseup intervention
                moveCaretToEnd(this);
                this.onmouseup = null;
                return false;
            };
        });

        $(document).on('keydown', selectors.textarea, (function (e)
        {
            if (e.ctrlKey && e.keyCode == 13) {
                $(this).parents('form').submit();
                $(e.target).trigger('blur');
            }
        }));

        $(document).on('submit', selectors.commentForm, function() {
            if (!isAuthorized(this)) {
                return showLogin(this);
            }

            var _this = this,
                $form = $(this),
                $commentContainer = findCommentContainer(this),
                $submit = $form.find(selectors.commentSubmit);

            if ($form.find('textarea[name=content]').val() == '') {
                $form.find('div.error_text').empty().append('<p>Вы не ввели комментарий!</p>');
                $form.find('textarea[name=content]').focus();

                return false;
            }

            Bm.ajax($submit, {
                type: 'POST',
                url: $form.attr('action'),
                data: $form.serializeArray(),
                dataType: 'json',
                success: function(result) {
                    $form.find('.error_text.input_error').remove();
                    var errorText = $form.find('.error_text');
                    $(errorText).text('');

                    if (result.success) {
                        changeCommentCount($commentContainer, 1);
                        var $result = $(result.message);
                        if($form.hasClass(selectors.commentFormCopy)) {
                            var $prev = $form.prev();
                            hideForms(_this);
                            var $comments = $prev.nextUntil('.level1', selectors.comment);
                            $result.insertAfter($comments.length ? $comments.last() : $prev);
                        } else {
                            $form.find('textarea').val('');
                            $form.find('textarea').css('height', '');
                            $commentContainer.find(selectors.commentList).prepend($result);
                        }

                        $('.profile-name-container').remove();
                    } else {
                        if (result.error) {
                            if (typeof result.error === 'object') {
                                $.each(result.error, function (i) {
                                    var inputError = $(errorText).clone();
                                    $(inputError).addClass('input_error')
                                    var messArray = $.map(this, function(value) {
                                        return [value];
                                    });
                                    $(inputError).append($('<p>' + messArray.shift() + '</p>'));
                                    $form.find('[name=' + i +']').after(inputError);
                                    $(inputError).show();
                                });
                            } else {
                                $form.find('.error_text').text('Ошибка: ' + result.error).show();
                            }
                        }
                    }
                },
                error: function() {
                    $form.find('.popup_error_text').text('Ошибка загрузки').show();
                }
            });

            return false;
        });

        $(document).on('click', selectors.reply, function(e)
        {
            e.preventDefault();
            if (!isAuthorized(this)) {
                return showLogin(this);
            }
            if($(this).hasClass('reply-on')) {
                return false;
            }

            var $commentContainer = findCommentContainer(this),
                $comment = $(this).parents(selectors.comment),
                container = $(selectors.comment),
                leaf = $(this).parents(selectors.comment).data('leaf');

            hideForms(this);
            $(this).addClass('reply-on');
            var $formParent = $commentContainer.find(selectors.commentMainForm).clone(),
                $form = $formParent.find('form');

            $form.attr('action', $(this).data('url'));
            $form.attr('data-leaf', leaf);
            $form.addClass('level' + $comment.data('level'));
            $form.addClass(selectors.commentFormCopy);
            $form.insertAfter($comment);

            var $textarea = $form.find('textarea');
            $textarea.val($(this).data('replyTo') + ', ');
            $textarea.css('height', 'auto');
            if ($.fn.autosize){
                $textarea.autosize();
            }
            $textarea.focus();
            e.stopPropagation();
        });

        //Показать еще в комментах 2 уровня
        $(document).on('click', selectors.commentLeaf, function(e)
        {
            var leafId = $(this).data('leaf');
            if($(this).hasClass('show-less-js')) {
                $(this).removeClass('show-less-js')
                        .text('еще ответы');
                $('.comment-leaf-showed-js[data-leaf=' + leafId + ']').removeClass('comment-leaf-showed-js').slideToggle(200);
            } else {
                $('[data-leaf=' + leafId + ']:hidden').addClass('comment-leaf-showed-js').slideToggle(200);
                $(this).insertBefore($('.comment-leaf-showed-js[data-leaf=' + leafId + ']').first());
                $(this).addClass('show-less-js')
                        .text('скрыть ответы');
            }
            $(this).toggleClass('up');
        });

        //Показать еще в комментариях 1 уровня
        $(document).on('click', selectors.commentMore, function(e){
            e.preventDefault();

            var $link = $(this),
                $commentContainer = findCommentContainer(this),
                $loading = $commentContainer.find(selectors.commentMoreLoading),
                $loadingIcon = $loading.children('.icon'),
                limit = 10,
                rotate,
                options = {
                    'offset': $commentContainer.find(selectors.comment).last().data('offset')
                };

            if ($link.data('limit')) {
                options['limit'] = $link.data('limit');
                limit = $link.data('limit');
            }

            $.ajax({
                url: $link.attr('data-get-uri'),
                data: options,
                beforeSend: function() {
                    $link.hide();
                    $loading.show();
                    rotate = rotateStart($loadingIcon);
                },
                success: function(result) {
                    var $lol =  $('<div></div>').append(result),
                        count = $(selectors.comment, $lol).size();

                    $commentContainer.find(selectors.commentList).append(result);
                    $loading.hide();
                    rotateStop($loadingIcon, rotate);

                    if (count >= limit) {
                        var remaining = $link.find('span[data-count=true]').text();
                        $link.show().find('span[data-count=true]').text(remaining - limit);
                    }
                }
            });
        });

        $(document).on('click', selectors.commentDelete + ',' + selectors.commentDeleteUser, function()
        {
            if (confirm('Вы подтверждаете это действие?')) {
                var $form = $(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('data-url'),
                    dataType: 'json',
                    success: function( xhr )
                    {
                        if (xhr.ids.length) {
                            $('div.deleted_container').each(function() {
                                var found = false;
                                for (var i in xhr.ids) {
                                    if ($(this).attr('deleted-container-data-id') == xhr.ids[i]) {
                                        found = true;
                                    }
                                }

                                if (found) {
                                    var $commentContainer = findCommentContainer(this);
                                    changeCommentCount($commentContainer, 1);

                                    $(this)
                                        .removeClass('hidden')
                                        .parents(selectors.comment)
                                        .addClass('deleted-comment')
                                        .find(selectors.commentDelete + ', ' + selectors.reply).addClass('hidden');
                                }
                            });
                        }
                    }
                }).error(function() {
                    $form.find('[type=submit]').css('visibility', 'visible');
                    $form.find('.popup_error_text').text('Ошибка загрузки').show();
                });
            }

            return false;
        });

        $(document).on('click', selectors.commentRestore, function()
        {
            var $form = $(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('data-url'),
                dataType: 'json',
                success: function( xhr )
                {
                    if (xhr.ids.length) {
                        $('div.deleted_container').each(function() {
                            var found = false;
                            for (var i in xhr.ids) {
                                if ($(this).attr('deleted-container-data-id') == xhr.ids[i]) {
                                    found = true;
                                }
                            }

                            if (found) {
                                var $commentContainer = findCommentContainer(this);
                                changeCommentCount($commentContainer, 1);

                                $(this)
                                    .addClass('hidden')
                                    .parents(selectors.comment)
                                    .removeClass('deleted-comment')
                                    .find(selectors.commentDelete + ', ' + selectors.reply).removeClass('hidden');
                            }
                        });
                    }
                },
            }).error(function() {
                $form.find('[type=submit]').css('visibility', 'visible');
                $form.find('.popup_error_text').text('Ошибка загрузки').show();
            });

            return false;
        });

        $(document).on('click', selectors.commentBanUser, function()
        {
            if (confirm('Вы подтверждаете это действие?')) {
                var $form = $(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('data-url'),
                    dataType: 'json',
                    success: function( xhr )
                    {
                        if (xhr.response) {
                            $('div.commentaries_item').each(function() {
                                if ($(this).attr('data-author-id') == xhr.authorId) {
                                    $(this).find('.banned-author-container').removeClass('hidden');
                                    $(this).find(selectors.commentBanUser).addClass('hidden');
                                }
                            });
                        }
                    },
                }).error(function() {
                    $form.find('[type=submit]').css('visibility', 'visible');
                    $form.find('.popup_error_text').text('Ошибка загрузки').show();
                });
            }

            return false;
        });

        $(document).on('click', selectors.commentBlockUser, function()
        {
            if (confirm('Вы подтверждаете это действие?')) {
                var $form = $(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('data-url'),
                    dataType: 'json',
                    success: function( xhr )
                    {
                        if (xhr.response) {
                            $('div.commentaries_item').each(function() {
                                if ($(this).attr('data-author-id') == xhr.authorId) {
                                    $(this).find('.blocked-author-container').removeClass('hidden');
                                    $(this).find(selectors.commentBlockUser).addClass('hidden');
                                }
                            });
                        }
                    },
                }).error(function() {
                    $form.find('[type=submit]').css('visibility', 'visible');
                    $form.find('.popup_error_text').text('Ошибка загрузки').show();
                });
            }

            return false;
        });
    };
    var initializers = {
        reply : function() {
            this.selectors.reply;
        }
    };

    var findCommentContainer = function(object) {
        return $(object).parents(selectors.container);
    };

    var showLogin = function(object) {
        var $commentContainer = findCommentContainer(object),
            successUri = $commentContainer.data('redirectUrl');

        if (Bm.isMobile) {
            if (!successUri) {
                successUri = $('.popup[data-popup="login"] input[name="success_url"]').val();
            }
            if (!successUri || !successUri.match(/#/)) {
                successUri += '?r='+Math.random() + '#comment';
            } else if (!successUri.match(/#comment/)) {
                var match = successUri.match(/^([^#]*)#(.*)/);
                if (match) {
                    successUri = '?r='+Math.random() + match[0];
                }
            }
            Bm.mobile.popup.show('login');
        } else {
            if (!successUri) {
                successUri = $('#popup_auth [name=success_url]').val();
            }
            if (!successUri.match(/#/)) {
                successUri += '?r='+Math.random() + '#comment';
            } else if (!successUri.match(/#comment/)) {
                var match = successUri.match(/^([^#]*)#(.*)/);
                if (match) {
                    successUri = '?r='+Math.random() + match[0];
                }
            }
            Bm.fancybox.modals.auth.open('<span>Чтобы оставить комментарий, авторизуйтесь или зарегистрируйтесь</span>', successUri);
        }

        $(selectors.textarea).blur();

        return false;
    };

    var isAuthorized = function(object) {
        var $commentContainer = findCommentContainer(object);

        return $commentContainer.attr('data-authorized');
    };

    var hideForms = function(cont) {
        var $commentContainer = findCommentContainer(cont);
        $commentContainer.find('.reply-on').removeClass('reply-on');
        $commentContainer.find(selectors.commentList + ' form').remove();
    };

    var changeCommentCount = function($commentContainer, delta) {
        var count = $commentContainer.data('count'),
            url   = $commentContainer.data('url');

        count = count + delta;
        $commentContainer.data('count', count);
        $('[data-comment-count="' + url + '"]').text(count);

        if (url) {
            var re  = /\/comment\/add\/(\d+)\/(\d+)\/\d+\//;
            var galleryUri = url.replace(re, "/ajax/comments/$1/$2/");

            $('[data-comment-count="' + galleryUri + '"]').text(count);
        }
    }
};

$(document).ready(function()
{
    var c = new Comment('.comment-container-js');
    c.init();
});
$(function() {

    $('form:not(.direct)').each(function()
    {
        var $form = $(this);
        $form.on('submit', function( e )
        {
            e.preventDefault();
            if($form.hasClass('relogin')) {
                $.ajax({
                    url: $form.attr('logout'),
                    type: 'GET',
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    headers: {'X-Requested-With': 'XMLHttpRequest'}});
            }

            $form.find('input[type=submit]').css('visibility', 'hidden');

            $.ajax({

                type: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function( result )
                {
                    if( result['redirect'] )
                    {
                        window.location.href = result['redirect'];
                    } else
                    {
                        if('success_replace' == result['status'] && result['message']) {
                            $form.html(result['message']);
                        }
                        else if( 'success' == result['status'] && result['message'] ) {
                            $form.find('.error_text').text(result['message']).show();
                        } else if( 'error' == result['status'] ) {
                            $form.find('.error_text').text('Ошибка: ' + result['message']).show();
                        }
                        $form.find('input[type=submit]').css('visibility', 'visible');
                    }
                },
                dataType: 'json',
                xhrFields: {
                    withCredentials: true
                },
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).error(function( jqXHR )
                {
                    $form.find('input[type=submit]').css('visibility', 'visible');
                    $form.find('.error_text').text('Ошибка загрузки').show();
                });

            return false;
        });
    });

});
/**
 * Created by n3b on 26.11.13.
 */

!function(w){

    if( w.imageUploderInitialized ) return;

    var domain = 'f.molodost.bz'; // todo
    var originReg = new RegExp('^.+'+domain.replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1") + '$', "g");
    var acceptArr = {
        'images':  'image/jpeg,image/png,image/pjpeg,image/gif',
        'files':  ''
    }

    var receiveMessage = function(event)
    {
        if ( ! event.origin.match(originReg) )
            return;

        var $b = $('#'+ event.data.pid);
        if( ! $b.length ) return;

        var b = $b.get(0);
        if( ! b._frames[event.data.callee] ) return;

        b._frames[event.data.callee].remove();
        delete b._frames[event.data.callee];

        if( ! event.data.status ) return b._onError.call($b, event.data.message);

        b._onSuccess.call($b, event.data.data);
    };

    w.addEventListener("message", receiveMessage, false);

    w.BMUploadTrigger = function($cont, link, resizeType, fileType, onSuccess, onError, onStart, accept)
    {
        var maxFileSize = 5; // todo
        var maxFileSizeFile = 10; // todo
        onStart = onStart || function(){};
        onError = onError || function(){};
        onSuccess = onSuccess || function(){};
        $cont = $($cont);

        if( ! $cont.attr('id') )
            $cont.attr('id', 'bm-media-upload-cont-' + Math.random().toString().substr(2));

        var cont = $cont.get(0);

        if( ! cont._frames )
            cont._frames = {};
        cont._onSuccess = onSuccess;
        cont._onError = onError;

        var $form = $cont.next('form');
        if( $form.length ) return $form.children('input').trigger('click');
        $form = $('<form class="bm-media-upload-form" method="post" enctype="multipart/form-data" style="display: none;"><input accept="'+acceptArr[accept]+'" type="file" name="file"></form>');
        $form.attr('id', 'bm-media-upload-form-' + Math.random().toString().substr(2));
        $form.insertAfter($cont);

        var $input = $form.children('input:first');

        $input.on('change', function(){

            if (fileType == 2) {
                if( this.files[0].size > maxFileSizeFile * 1024 * 1024 ) {
                    $form.remove();
                    onError.call($cont, 'Максимальный размер файла ' + maxFileSizeFile + 'Мб');
                    return false;
                }
            } else {
                if( this.files[0].size > maxFileSize * 1024 * 1024 ) {
                    $form.remove();
                    onError.call($cont, 'Максимальный размер изображения ' + maxFileSize + 'Мб');
                    return false;
                }
            }

            onStart.call($cont, this.files[0]);

            $.get(link, function(data)
            {
                if( ! data.status )
                {
                    $form.remove();
                    onError.call($cont, 'Системная ошибка. Повторите позже.');
                    return false;
                }

                var $frame = $('<iframe style="display:none" />').attr('id', 'iframe-' + $form.attr('id'));
                $frame.attr('name', $frame.attr('id'));
                $frame.insertAfter($form);
                $form.attr('target', $frame.attr('id'));

                data.link += '&type=' + ( parseInt(resizeType) || 1 );
                data.link += '&filetype=' + ( parseInt(fileType) || 1 );

                $form.attr('action', data.link);

                $form.on('submit', function()
                {
                    $frame.on('load', function(){
                        cont._frames[$frame.attr('id')] = $frame;
                        $frame.get(0).contentWindow.postMessage({callee: $frame.attr('id'), pid: $cont.attr('id')},'*');
                        $form.remove();
                        // todo remove if no message from iframe
                    });
                });
                $form.trigger('submit');
            }, 'json');
        });

        $input.trigger('click');
    }

    w.imageUploderInitialized = 1;

}(window);
