


; /* Start:/bitrix/js/main/core/core.js*/
/**********************************************************************/
/*********** Bitrix JS Core library ver 0.9.0 beta ********************/
/**********************************************************************/

;(function(window){

if (!!window.BX && !!window.BX.extend)
	return;

var _bxtmp;
if (!!window.BX)
{
	_bxtmp = window.BX;
}

window.BX = function(node, bCache)
{
	if (BX.type.isNotEmptyString(node))
	{
		var ob;

		if (!!bCache && null != NODECACHE[node])
			ob = NODECACHE[node];
		ob = ob || document.getElementById(node);
		if (!!bCache)
			NODECACHE[node] = ob;

		return ob;
	}
	else if (BX.type.isDomNode(node))
		return node;
	else if (BX.type.isFunction(node))
		return BX.ready(node);

	return null;
};

// language utility
BX.message = function(mess)
{
	if (BX.type.isString(mess))
	{
		if (typeof BX.message[mess] == 'undefined')
			BX.debug('message undefined: ' + mess);
		return BX.message[mess];
	}
	else
	{
		for (var i in mess)
		{
			BX.message[i]=mess[i];
		}
		return true;
	}
};

if(!!_bxtmp)
{
	for(var i in _bxtmp)
	{
		if(!BX[i])
		{
			BX[i]=_bxtmp[i];
		}
		else if(i=='message')
		{
			for(var j in _bxtmp[i])
			{
				BX.message[j]=_bxtmp[i][j];
			}
		}
		_bxtmp = null;
	}
}

var

/* ready */
__readyHandler = null,
readyBound = false,
readyList = [],

/* list of registered proxy functions */
proxySalt = Math.random(),
proxyId = 1,
proxyList = [],
deferList = [],

/* getElementById cache */
NODECACHE = {},

/* List of denied event handlers */
deniedEvents = [],

/* list of registered event handlers */
eventsList = [],

/* list of registered custom events */
customEvents = {},

/* list of external garbage collectors */
garbageCollectors = [],

/* list of loaded CSS files */
cssList = [],

/* list of loaded JS kernel files */
arKernelJS = [],

/* browser detection */
bSafari = navigator.userAgent.toLowerCase().indexOf('webkit') != -1,
bOpera = navigator.userAgent.toLowerCase().indexOf('opera') != -1,
bFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') != -1,
bChrome = navigator.userAgent.toLowerCase().indexOf('chrome') != -1,
bIE = document.attachEvent && !bOpera,

/* regexps */
r = {
	script: /<script([^>]*)>/i,
	script_src: /src=["\']([^"\']+)["\']/i,
	space: /\s+/,
	ltrim: /^[\s\r\n]+/g,
	rtrim: /[\s\r\n]+$/g,
	style: /<link.*?(rel="stylesheet"|type="text\/css")[^>]*>/i,
	style_href: /href=["\']([^"\']+)["\']/i
},

eventTypes = {
	click: 'MouseEvent',
	dblclick: 'MouseEvent',
	mousedown: 'MouseEvent',
	mousemove: 'MouseEvent',
	mouseout: 'MouseEvent',
	mouseover: 'MouseEvent',
	mouseup: 'MouseEvent',
	focus: 'MouseEvent',
	blur: 'MouseEvent'
},

lastWait = [],

CHECK_FORM_ELEMENTS = {tagName: /^INPUT|SELECT|TEXTAREA|BUTTON$/i};

BX.MSLEFT = 1;
BX.MSMIDDLE = 2;
BX.MSRIGHT = 4;

BX.ext = function(ob) {for (var i in ob) this[i] = ob[i];}

/* OO emulation utility */
BX.extend = function(child, parent)
{
	var f = function() {};
	f.prototype = parent.prototype;

	child.prototype = new f();
	child.prototype.constructor = child;

	child.superclass = parent.prototype;
	if(parent.prototype.constructor == Object.prototype.constructor)
	{
		parent.prototype.constructor = parent;
	}
}

BX.debug = function()
{
	if (window.BXDEBUG)
	{
		if (window.console && window.console.log)
			console.log('BX.debug: ', arguments.length > 0 ? arguments : arguments[0]);
	}
}

BX.is_subclass_of = function(ob, parent_class)
{
	if (ob instanceof parent_class)
		return true;

	if (parent_class.superclass)
		return BX.is_subclass_of(ob, parent_class.superclass);

	return false;
}

BX.bitrix_sessid = function() {return BX.message.bitrix_sessid;}

/* DOM manipulation */
BX.create = function(tag, data, context)
{
	context = context || document;

	if (null == data && typeof tag == 'object' && tag.constructor !== String)
	{
		data = tag; tag = tag.tag;
	}

	var elem;
	if (BX.browser.IsIE() && !BX.browser.IsIE9() && null != data && null != data.props && (data.props.name || data.props.id))
	{
		elem = context.createElement('<' + tag + (data.props.name ? ' name="' + data.props.name + '"' : '') + (data.props.id ? ' id="' + data.props.id + '"' : '') + '>');
	}
	else
	{
		elem = context.createElement(tag);
	}

	return data ? BX.adjust(elem, data) : elem;
}

BX.adjust = function(elem, data)
{
	var j,len;

	if (!elem.nodeType)
		return null;

	if (elem.nodeType == 9)
		elem = elem.body;

	if (data.attrs)
	{
		for (j in data.attrs)
		{
			if (j == 'class' || j == 'className')
				elem.className = data.attrs[j];
			else if (j == 'for')
				elem.htmlFor = data.attrs[j];
			else if(data.attrs[j] == "")
				elem.removeAttribute(j);
			else
				elem.setAttribute(j, data.attrs[j]);
		}
	}

	if (data.style)
	{
		for (j in data.style)
			elem.style[j] = data.style[j];
	}

	if (data.props)
	{
		for (j in data.props)
			elem[j] = data.props[j];
	}

	if (data.events)
	{
		for (j in data.events)
			BX.bind(elem, j, data.events[j]);
	}

	if (data.children && data.children.length > 0)
	{
		for (j=0,len=data.children.length; j<len; j++)
		{
			if (BX.type.isNotEmptyString(data.children[j]))
				elem.innerHTML += data.children[j];
			else if (BX.type.isElementNode(data.children[j]))
				elem.appendChild(data.children[j]);
		}
	}
	else if (data.text)
	{
		BX.cleanNode(elem);
		elem.appendChild((elem.ownerDocument || document).createTextNode(data.text));
	}
	else if (data.html)
	{
		elem.innerHTML = data.html;
	}

	return elem;
}

BX.remove = function(ob)
{
	if (ob && null != ob.parentNode)
		ob.parentNode.removeChild(ob);
	ob = null;
	return null;
}

BX.cleanNode = function(node, bSuicide)
{
	node = BX(node);
	bSuicide = !!bSuicide;

	if (node && node.childNodes)
	{
		while(node.childNodes.length > 0)
			node.removeChild(node.firstChild);
	}

	if (node && bSuicide)
	{
		node = BX.remove(node);
	}

	return node;
}

BX.addClass = function(ob, value)
{
	var classNames;
	ob = BX(ob)

	value = BX.util.trim(value);
	if (value == '')
		return ob;

	if (ob)
	{
		if (!ob.className)
		{
			ob.className = value
		}
		else if (!!ob.classList && value.indexOf(' ') < 0)
		{
			ob.classList.add(value);
		}
		else
		{
			classNames = (value || "").split(r.space);

			var className = " " + ob.className + " ";
			for (var j = 0, cl = classNames.length; j < cl; j++)
			{
				if (className.indexOf(" " + classNames[j] + " ") < 0)
				{
					ob.className += " " + classNames[j];
				}
			}
		}
	}

	return ob;
}

BX.removeClass = function(ob, value)
{
	ob = BX(ob);
	if (ob)
	{
		if (ob.className && !!value)
		{
			if (BX.type.isString(value))
			{
				if (!!ob.classList && value.indexOf(' ') < 0)
				{
					ob.classList.remove(value);
				}
				else
				{
					var classNames = value.split(r.space), className = " " + ob.className + " ";
					for (var j = 0, cl = classNames.length; j < cl; j++)
					{
						className = className.replace(" " + classNames[j] + " ", " ");
					}

					ob.className = BX.util.trim(className);
				}
			}
			else
			{
				ob.className = "";
			}
		}
	}

	return ob;
}

BX.toggleClass = function(ob, value)
{
	var className;
	if (BX.type.isArray(value))
	{
		className = ' ' + ob.className + ' ';
		for (var j = 0, len = value.length; j < len; j++)
		{
			if (BX.hasClass(ob, value[j]))
			{
				className = (' ' + className + ' ').replace(' ' + value[j] + ' ', ' ');
				className += ' ' + value[j >= len-1 ? 0 : j+1];

				j--;
				break;
			}
		}

		if (j == len)
			ob.className += ' ' + value[0];
		else
			ob.className = className;

		ob.className = BX.util.trim(ob.className);
	}
	else if (BX.type.isNotEmptyString(value))
	{
		if (!!ob.classList)
		{
			ob.classList.toggle(value);
		}
		else
		{
			className = ob.className;
			if (BX.hasClass(ob, value))
			{
				className = (' ' + className + ' ').replace(' ' + value + ' ', ' ');
			}
			else
			{
				className += ' ' + value;
			}

			ob.className = BX.util.trim(className);
		}
	}

	return ob;
}

BX.hasClass = function(el, className)
{
	if (!el || !BX.type.isDomNode(el))
	{
		BX.debug(el);
		return false;
	}

	if (!el.className || !className)
	{
		return false;
	}

	if (!!el.classList && !!className && className.indexOf(' ') < 0)
	{
		return el.classList.contains(BX.util.trim(className));
	}
	else
		return ((" " + el.className + " ").indexOf(" " + className + " ")) >= 0;
}

BX.hoverEvents = function(el)
{
	if (el)
		return BX.adjust(el, {events: BX.hoverEvents()});
	else
		return {mouseover: BX.hoverEventsHover, mouseout: BX.hoverEventsHout};
}

BX.hoverEventsHover = function(){BX.addClass(this,'bx-hover');this.BXHOVER=true;}
BX.hoverEventsHout = function(){BX.removeClass(this,'bx-hover');this.BXHOVER=false;}

BX.focusEvents = function(el)
{
	if (el)
		return BX.adjust(el, {events: BX.focusEvents()});
	else
		return {mouseover: BX.focusEventsFocus, mouseout: BX.focusEventsBlur};
}

BX.focusEventsFocus = function(){BX.addClass(this,'bx-focus');this.BXFOCUS=true;}
BX.focusEventsBlur = function(){BX.removeClass(this,'bx-focus');this.BXFOCUS=false;}

BX.setUnselectable = function(node)
{
	BX.addClass(node, 'bx-unselectable');
	node.setAttribute('unSelectable', 'on');
}

BX.setSelectable = function(node)
{
	BX.removeClass(node, 'bx-unselectable');
	node.removeAttribute('unSelectable');
}

BX.styleIEPropertyName = function(name)
{
	if (name == 'float')
		name = BX.browser.IsIE() ? 'styleFloat' : 'cssFloat';
	else
	{
		var res = BX.browser.isPropertySupported(name);
		if (res)
		{
			name = res;
		}
		else
		{
			var reg = /(\-([a-z]){1})/g;
			if (reg.test(name))
			{
				name = name.replace(reg, function () {return arguments[2].toUpperCase();});
			}
		}
	}
	return name;
}

/* CSS-notation should be used here */
BX.style = function(el, property, value)
{
	if (!BX.type.isElementNode(el))
		return null;

	if (value == null)
	{
		var res;

		if(el.currentStyle)
			res = el.currentStyle[BX.styleIEPropertyName(property)];
		else if(window.getComputedStyle)
		{
			var q = BX.browser.isPropertySupported(property, true);
			if (!!q)
				property = q;

			res = BX.GetContext(el).getComputedStyle(el, null).getPropertyValue(property);
		}

		if(!res)
			res = '';
		return res;
	}
	else
	{
		el.style[BX.styleIEPropertyName(property)] = value;
		return el;
	}
}

BX.focus = function(el)
{
	try
	{
		el.focus();
		return true;
	}
	catch (e)
	{
		return false;
	}
}

BX.firstChild = function(el)
{
	var e = el.firstChild;
	while (e && !BX.type.isElementNode(e))
	{
		e = e.nextSibling;
	}

	return e;
}

BX.lastChild = function(el)
{
	var e = el.lastChild;
	while (e && !BX.type.isElementNode(e))
	{
		e = e.previousSibling;
	}

	return e;
}

BX.previousSibling = function(el)
{
	var e = el.previousSibling;
	while (e && !BX.type.isElementNode(e))
	{
		var e = e.previousSibling;
	}

	return e;
}

BX.nextSibling = function(el)
{
	var e = el.nextSibling;
	while (e && !BX.type.isElementNode(e))
	{
		var e = e.nextSibling;
	}

	return e;
}

/*
	params: {
		tagName|tag : 'tagName',
		className|class : 'className',
		attribute : {attribute : value, attribute : value} | attribute | [attribute, attribute....],
		property : {prop: value, prop: value} | prop | [prop, prop]
	}

	all values can be RegExps or strings
*/
BX.findChildren = function(obj, params, recursive)
{
	return BX.findChild(obj, params, recursive, true);
}

BX.findChild = function(obj, params, recursive, get_all)
{
	if(!obj || !obj.childNodes) return null;

	recursive = !!recursive; get_all = !!get_all;

	var n = obj.childNodes.length, result = [];

	for (var j=0; j<n; j++)
	{
		var child = obj.childNodes[j];

		if (_checkNode(child, params))
		{
			if (get_all)
				result.push(child)
			else
				return child;
		}

		if(recursive == true)
		{
			var res = BX.findChild(child, params, recursive, get_all);
			if (res)
			{
				if (get_all)
					result = BX.util.array_merge(result, res);
				else
					return res;
			}
		}
	}

	if (get_all || result.length > 0)
		return result;
	else
		return null;
}

BX.findParent = function(obj, params, maxParent)
{
	if(!obj)
		return null;

	var o = obj;
	while(o.parentNode)
	{
		var parent = o.parentNode;

		if (_checkNode(parent, params))
			return parent;

		o = parent;

		if (!!maxParent &&
			(BX.type.isFunction(maxParent)
				|| typeof maxParent == 'object'))
		{
			if (BX.type.isElementNode(maxParent))
			{
				if (o == maxParent)
					break;
			}
			else
			{
				if (_checkNode(o, maxParent))
					break;
			}
		}
	}
	return null;
}

BX.findNextSibling = function(obj, params)
{
	if(!obj)
		return null;
	var o = obj;
	while(o.nextSibling)
	{
		var sibling = o.nextSibling;
		if (_checkNode(sibling, params))
			return sibling;
		o = sibling;
	}
	return null;
}

BX.findPreviousSibling = function(obj, params)
{
	if(!obj)
		return null;

	var o = obj;
	while(o.previousSibling)
	{
		var sibling = o.previousSibling;
		if(_checkNode(sibling, params))
			return sibling;
		o = sibling;
	}
	return null;
}

BX.findFormElements = function(form)
{
	if (BX.type.isString(form))
		form = document.forms[form]||BX(form);

	var res = [];

	if (BX.type.isElementNode(form))
	{
		if (form.tagName.toUpperCase() == 'FORM')
		{
			res = form.elements;
		}
		else
		{
			res = BX.findChildren(form, CHECK_FORM_ELEMENTS, true);
		}
	}

	return res;
}

BX.clone = function(obj, bCopyObj)
{
	var _obj, i, l;
	if (bCopyObj !== false)
		bCopyObj = true;

	if (obj === null)
		return null;

	if (BX.type.isDomNode(obj))
	{
		_obj = obj.cloneNode(bCopyObj);
	}
	else if (typeof obj == 'object')
	{
		if (BX.type.isArray(obj))
		{
			_obj = [];
			for (i=0,l=obj.length;i<l;i++)
			{
				if (typeof obj[i] == "object" && bCopyObj)
					_obj[i] = BX.clone(obj[i], bCopyObj);
				else
					_obj[i] = obj[i];
			}
		}
		else
		{
			_obj =  {};
			if (obj.constructor)
			{
				if (obj.constructor === Date)
					_obj = new Date(obj);
				else
					_obj = new obj.constructor();
			}

			for (i in obj)
			{
				if (typeof obj[i] == "object" && bCopyObj)
					_obj[i] = BX.clone(obj[i], bCopyObj);
				else
					_obj[i] = obj[i];
			}
		}

	}
	else
	{
		_obj = obj;
	}

	return _obj;
}

/* events */
BX.bind = function(el, evname, func)
{
	if (!el)
		return;

	if (evname === 'mousewheel')
		BX.bind(el, 'DOMMouseScroll', func);
	else if (evname === 'transitionend')
	{
		BX.bind(el, 'webkitTransitionEnd', func);
		BX.bind(el, 'msTransitionEnd', func);
		BX.bind(el, 'oTransitionEnd', func);
		// IE8-9 doesn't support this feature!
	}

	if (el.addEventListener)
		el.addEventListener(evname, func, false);
	else if(el.attachEvent) // IE
		el.attachEvent("on" + evname, BX.proxy(func, el));
	else
		el["on" + evname] = func;

	eventsList[eventsList.length] = {'element': el, 'event': evname, 'fn': func};
}

BX.unbind = function(el, evname, func)
{
	if (!el)
		return;

	if (evname === 'mousewheel')
		BX.unbind(el, 'DOMMouseScroll', func);

	if(el.removeEventListener) // Gecko / W3C
		el.removeEventListener(evname, func, false);
	else if(el.detachEvent) // IE
		el.detachEvent("on" + evname, BX.proxy(func, el));
	else
		el["on" + evname] = null;
}

BX.getEventButton = function(e)
{
	e = e || window.event;

	var flags = 0;

	if (typeof e.which != 'undefined')
	{
		switch (e.which)
		{
			case 1: flags = flags|BX.MSLEFT; break;
			case 2: flags = flags|BX.MSMIDDLE; break;
			case 3: flags = flags|BX.MSRIGHT; break;
		}
	}
	else if (typeof e.button != 'undefined')
	{
		flags = event.button;
	}

	return flags || BX.MSLEFT;
}

BX.unbindAll = function(el)
{
	if (!el)
		return;

	for (var i=0,len=eventsList.length; i<len; i++)
	{
		try
		{
			if (eventsList[i] && (null==el || el==eventsList[i].element))
			{
				BX.unbind(eventsList[i].element, eventsList[i].event, eventsList[i].fn);
				eventsList[i] = null;
			}
		}
		catch(e){}
	}

	if (null==el)
	{
		eventsList = [];
	}
}

var captured_events = null, _bind = null;
BX.CaptureEvents = function(el_c, evname_c)
{
	if (_bind)
		return false;

	_bind = BX.bind; captured_events = [];

	BX.bind = function(el, evname, func)
	{
		if (el === el_c && evname === evname_c)
			captured_events.push(func);

		_bind.apply(this, arguments);
	}
}

BX.CaptureEventsGet = function()
{
	if (_bind)
	{
		BX.bind = _bind;

		var captured = captured_events;

		_bind = null; captured_events = null;
		return captured;
	}
}

// Don't even try to use it for submit event!
BX.fireEvent = function(ob,ev)
{
	var result = false;
	if (BX.type.isDomNode(ob))
	{
		result = true;
		if (document.createEventObject)
		{
			// IE
			if (eventTypes[ev] != 'MouseEvent')
			{
				var e = document.createEventObject();
				e.type = ev;
				result = ob.fireEvent('on' + ev, e);
			}

			if (ob[ev])
			{
				ob[ev]();
			}
		}
		else
		{
			// non-IE
			var e = null;

			switch (eventTypes[ev])
			{
				case 'MouseEvent':
					e = document.createEvent('MouseEvent');
					e.initMouseEvent(ev, true, true, top, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, null);
				break;
				default:
					e = document.createEvent('Event');
					e.initEvent(ev, true, true);
			}

			result = ob.dispatchEvent(e);
		}
	}

	return result;
}

BX.getWheelData = function(e)
{
	e = e || window.event;
	return wheelData = e.detail ? e.detail * -1 : e.wheelDelta / 40;
}

BX.proxy_context = null;

BX.delegate = function (func, thisObject)
{
	if (!func || !thisObject)
		return func;

	return function() {
		var cur = BX.proxy_context;
		BX.proxy_context = this;
		var res = func.apply(thisObject, arguments);
		BX.proxy_context = cur;
		return res;
	}
}

BX.delegateLater = function (func_name, thisObject, contextObject)
{
	return function()
	{
		if (thisObject[func_name])
		{
			var cur = BX.proxy_context;
			BX.proxy_context = this;
			var res = thisObject[func_name].apply(contextObject||thisObject, arguments);
			BX.proxy_context = cur;
			return res;
		}
	}
}

BX._initObjectProxy = function(thisObject)
{
	if (typeof thisObject['__proxy_id_' + proxySalt] == 'undefined')
	{
		thisObject['__proxy_id_' + proxySalt] = proxyList.length;
		proxyList[thisObject['__proxy_id_' + proxySalt]] = {};
	}
}

BX.proxy = function(func, thisObject)
{
	if (!func || !thisObject)
		return func;

	BX._initObjectProxy(thisObject)

	if (typeof func['__proxy_id_' + proxySalt] == 'undefined')
		func['__proxy_id_' + proxySalt] = proxyId++;

	if (!proxyList[thisObject['__proxy_id_' + proxySalt]][func['__proxy_id_' + proxySalt]])
		proxyList[thisObject['__proxy_id_' + proxySalt]][func['__proxy_id_' + proxySalt]] = BX.delegate(func, thisObject);

	return proxyList[thisObject['__proxy_id_' + proxySalt]][func['__proxy_id_' + proxySalt]];
}

BX.defer = function(func, thisObject)
{
	if (!!thisObject)
		return BX.defer_proxy(func, thisObject);
	else
		return function() {
			var arg = arguments;
			setTimeout(function(){func.apply(this,arg)}, 10);
		};
}

BX.defer_proxy = function(func, thisObject)
{
	if (!func || !thisObject)
		return func;

	var f = BX.proxy(func, thisObject);

	this._initObjectProxy(thisObject);

	if (typeof func['__defer_id_' + proxySalt] == 'undefined')
		func['__defer_id_' + proxySalt] = proxyId++;

	if (!proxyList[thisObject['__proxy_id_' + proxySalt]][func['__defer_id_' + proxySalt]])
	{
		proxyList[thisObject['__proxy_id_' + proxySalt]][func['__defer_id_' + proxySalt]] = BX.defer(BX.delegate(func, thisObject));
	}

	return proxyList[thisObject['__proxy_id_' + proxySalt]][func['__defer_id_' + proxySalt]];
}

BX.bindDelegate = function (elem, eventName, isTarget, handler)
{
	var h = BX.delegateEvent(isTarget, handler);
	BX.bind(elem, eventName, h);
	return h;
}

BX.delegateEvent = function(isTarget, handler)
{
	return function(e)
	{
		e = e || window.event;
		var target = e.target || e.srcElement;

		while (target != this)
		{
			if (_checkNode(target, isTarget))
			{
				return handler.call(target, e);
			}
			if (target && target.parentNode)
				target = target.parentNode;
			else
				break;
		}
	}
}

BX.False = function() {return false;}
BX.DoNothing = function() {}

// TODO: also check event handlers set via BX.bind()
BX.denyEvent = function(el, ev)
{
	deniedEvents.push([el, ev, el['on' + ev]]);
	el['on' + ev] = BX.DoNothing;
}

BX.allowEvent = function(el, ev)
{
	for(var i=0, len=deniedEvents.length; i<len; i++)
	{
		if (deniedEvents[i][0] == el && deniedEvents[i][1] == ev)
		{
			el['on' + ev] = deniedEvents[i][2];
			BX.util.deleteFromArray(deniedEvents, i);
			return;
		}
	}
}

BX.fixEventPageXY = function(event)
{
	BX.fixEventPageX(event);
	BX.fixEventPageY(event);
	return event;
};

BX.fixEventPageX = function(event)
{
	if (event.pageX == null && event.clientX != null)
	{
		event.pageX =
			event.clientX +
			(document.documentElement && document.documentElement.scrollLeft || document.body && document.body.scrollLeft || 0) -
			(document.documentElement.clientLeft || 0);
	}

	return event;
};

BX.fixEventPageY = function(event)
{
	if (event.pageY == null && event.clientY != null)
	{
		event.pageY =
			event.clientY +
			(document.documentElement && document.documentElement.scrollTop || document.body && document.body.scrollTop || 0) -
			(document.documentElement.clientTop || 0);
	}

	return event;
};

BX.PreventDefault = function(e)
{
	if(!e) e = window.event;
	if(e.stopPropagation)
	{
		e.preventDefault();
		e.stopPropagation();
	}
	else
	{
		e.cancelBubble = true;
		e.returnValue = false;
	}
	return false;
}

BX.eventReturnFalse = function(e)
{
	e=e||window.event;
	if (e && e.preventDefault) e.preventDefault();
	else e.returnValue = false;
	return false;
}

BX.eventCancelBubble = function(e)
{
	e=e||window.event;
	if(e && e.stopPropagation)
		e.stopPropagation();
	else
		e.cancelBubble = true;
}

/* custom events */
/*
	BX.addCustomEvent(eventObject, eventName, eventHandler) - set custom event handler for particular object
	BX.addCustomEvent(eventName, eventHandler) - set custom event handler for all objects
*/
BX.addCustomEvent = function(eventObject, eventName, eventHandler)
{
	/* shift parameters for short version */
	if (BX.type.isString(eventObject))
	{
		eventHandler = eventName;
		eventName = eventObject;
		eventObject = window;
	}

	eventName = eventName.toUpperCase();

	if (!customEvents[eventName])
		customEvents[eventName] = [];

	customEvents[eventName].push(
		{
			handler: eventHandler,
			obj: eventObject
		}
	);
}

BX.removeCustomEvent = function(eventObject, eventName, eventHandler)
{
	/* shift parameters for short version */
	if (BX.type.isString(eventObject))
	{
		eventHandler = eventName;
		eventName = eventObject;
		eventObject = window;
	}

	eventName = eventName.toUpperCase();

	if (!customEvents[eventName])
		return;

	for (var i = 0, l = customEvents[eventName].length; i < l; i++)
	{
		if (!customEvents[eventName][i])
			continue;
		if (customEvents[eventName][i].handler == eventHandler && customEvents[eventName][i].obj == eventObject)
		{
			delete customEvents[eventName][i];
			return;
		}
	}
}

BX.onCustomEvent = function(eventObject, eventName, arEventParams)
{
	/* shift parameters for short version */
	if (BX.type.isString(eventObject))
	{
		arEventParams = eventName;
		eventName = eventObject;
		eventObject = window;
	}

	eventName = eventName.toUpperCase();

	if (!customEvents[eventName])
		return;

	if (!arEventParams)
		arEventParams = [];

	var h;
	for (var i = 0, l = customEvents[eventName].length; i < l; i++)
	{
		h = customEvents[eventName][i];
		if (!h || !h.handler)
			continue;

		if (h.obj == window || /*eventObject == window || */h.obj == eventObject) //- only global event handlers will be called
		{
			h.handler.apply(eventObject, arEventParams);
		}
	}
}

BX.parseJSON = function(data, context)
{
	var result = null;
	if (BX.type.isString(data))
	{
		try {
			if (data.indexOf("\n") >= 0)
				eval('result = ' + data);
			else
				result = (new Function("return " + data))();
		} catch(e) {
			BX.onCustomEvent(context, 'onParseJSONFailure', [data, context])
		}
	}

	return result;
}

/* ready */
BX.isReady = false;
BX.ready = function(handler)
{
	bindReady();

	if (!BX.type.isFunction(handler))
	{
		BX.debug('READY: not a function! ', handler);
	}
	else
	{
		if (BX.isReady)
			handler.call(document);
		else if (readyList)
			readyList.push(handler);
	}
}

BX.submit = function(obForm, action_name, action_value, onAfterSubmit)
{
	action_name = action_name || 'save';
	if (!obForm['BXFormSubmit_' + action_name])
	{
		obForm['BXFormSubmit_' + action_name] = obForm.appendChild(BX.create('INPUT', {
			'props': {
				'type': 'submit',
				'name': action_name,
				'value': action_value || 'Y'
			},
			'style': {
				'display': 'none'
			}
		}));
	}

	if (obForm.sessid)
		obForm.sessid.value = BX.bitrix_sessid();

	setTimeout(BX.delegate(function() {BX.fireEvent(this, 'click'); if (onAfterSubmit) onAfterSubmit();}, obForm['BXFormSubmit_' + action_name]), 10);
}


/* browser detection */
BX.browser = {

	IsIE: function()
	{
		return bIE;
	},

	IsIE6: function()
	{
		return (/MSIE 6/i.test(navigator.userAgent));
	},

	IsIE9: function()
	{
		return !!document.documentMode && document.documentMode >= 9;
	},

	IsIE10: function()
	{
		return !!document.documentMode && document.documentMode >= 10;
	},

	IsOpera: function()
	{
		return bOpera;
	},

	IsSafari: function()
	{
		return bSafari;
	},

	IsFirefox: function()
	{
		return bFirefox;
	},

	IsChrome: function()
	{
		return bChrome;
	},

	IsMac: function()
	{
		return (/Macintosh/i.test(navigator.userAgent));
	},

	IsAndroid: function()
	{
		return (/Android/i.test(navigator.userAgent));
	},

	IsIOS: function()
	{
		return (/(iPad;)|(iPhone;)/i.test(navigator.userAgent));
	},

	IsDoctype: function(pDoc)
	{
		pDoc = pDoc || document;

		if (pDoc.compatMode)
			return (pDoc.compatMode == "CSS1Compat");

		if (pDoc.documentElement && pDoc.documentElement.clientHeight)
			return true;

		return false;
	},

	SupportLocalStorage: function()
	{
		return !!BX.localStorage && !!BX.localStorage.checkBrowser()
	},

	addGlobalClass: function() {
		if (BX.browser.IsIOS())
		{
			BX.addClass(document.documentElement, 'bx-ios');
		}
		else if (BX.browser.IsMac())
		{
			BX.addClass(document.documentElement, 'bx-mac');
		}
		else if (BX.browser.IsAndroid())
		{
			BX.addClass(document.documentElement, 'bx-android');
		}

		if (BX.browser.IsIOS() || BX.browser.IsAndroid())
		{
			BX.addClass(document.documentElement, 'bx-touch');
		}
		else
		{
			BX.addClass(document.documentElement, 'bx-no-touch');
		}

		if (/AppleWebKit/.test(navigator.userAgent))
		{
			BX.addClass(document.documentElement, 'bx-chrome');
		}
		else if (/MSIE 8/.test(navigator.userAgent))
		{
			BX.addClass(document.documentElement, 'bx-ie bx-ie8'
				 + (!BX.browser.IsDoctype() ? ' bx-quirks' : ''));
		}
		else if (/MSIE 9/.test(navigator.userAgent))
		{
			BX.addClass(document.documentElement, 'bx-ie bx-ie9'
				 + (!BX.browser.IsDoctype() ? ' bx-quirks' : ''));
		}
		else if (/MSIE 10/.test(navigator.userAgent))
		{
			// it seems IE10 doesn't have any specific bugs like others event in quirks mode
			BX.addClass(document.documentElement, 'bx-ie bx-ie10');
		}
		else if (/Opera/.test(navigator.userAgent))
		{
			BX.addClass(document.documentElement, 'bx-opera');
		}
		else if (/Gecko/.test(navigator.userAgent))
		{
			BX.addClass(document.documentElement, 'bx-firefox');
		}

		BX.browser.addGlobalClass = BX.DoNothing;
	},

	isPropertySupported: function(jsProperty, bReturnCSSName)
	{
		if (!BX.type.isNotEmptyString(jsProperty))
			return false;

		var property = jsProperty.indexOf("-") > -1 ? getJsName(jsProperty) : jsProperty;
		bReturnCSSName = !!bReturnCSSName;

		var ucProperty = property.charAt(0).toUpperCase() + property.slice(1);
		var properties = (property + ' ' + ["Webkit", "Moz", "O", "ms"].join(ucProperty + " ") + ucProperty).split(" ");
		var obj = document.body || document.documentElement;

		for (var i = 0; i < properties.length; i++)
		{
			var prop = properties[i];
			if (obj.style[prop] !== undefined)
			{
				var prefix = prop == property
							? ""
							: "-" + prop.substr(0, prop.length - property.length).toLowerCase() + "-";
				return bReturnCSSName ? prefix + getCssName(property) : prop;
			}
		}

		function getCssName(propertyName)
		{
			return propertyName.replace(/([A-Z])/g, function() { return "-" + arguments[1].toLowerCase(); } )
		}

		function getJsName(cssName)
		{
			var reg = /(\-([a-z]){1})/g;
			if (reg.test(cssName))
				return cssName.replace(reg, function () {return arguments[2].toUpperCase();});
			else
				return cssName;
		}

		return false;
	},

	addGlobalFeatures : function(features, prefix)
	{
		if (!BX.type.isArray(features))
			return;

		var classNames = [];
		for (var i = 0; i < features.length; i++)
		{
			var support = !!BX.browser.isPropertySupported(features[i]);
			classNames.push( "bx-" + (support ? "" : "no-") + features[i].toLowerCase());
		}
		BX.addClass(document.documentElement, classNames.join(" "));
	}
}

/* low-level fx funcitons*/
BX.show = function(ob, displayType)
{
	if (ob.BXDISPLAY || !_checkDisplay(ob, displayType))
	{
		ob.style.display = ob.BXDISPLAY;
	}
}

BX.hide = function(ob, displayType)
{
	if (!ob.BXDISPLAY)
		_checkDisplay(ob, displayType);

	ob.style.display = 'none';
}

BX.toggle = function(ob, values)
{
	if (!values && BX.type.isElementNode(ob))
	{
		var bShow = true;
		if (ob.BXDISPLAY)
			bShow = !_checkDisplay(ob);
		else
			bShow = ob.style.display == 'none';

		if (bShow)
			BX.show(ob);
		else
			BX.hide(ob);
	}
	else if (BX.type.isArray(values))
	{
		for (var i=0,len=values.length; i<len; i++)
		{
			if (ob == values[i])
			{
				ob = values[i==len-1 ? 0 : i+1]
				break;
			}
		}
		if (i==len)
			ob = values[0];
	}

	return ob;
}

/* some useful util functions */

BX.util = {
	array_values: function(ar)
	{
		if (!BX.type.isArray(ar))
			return BX.util._array_values_ob(ar);
		var arv = [];
		for(var i=0,l=ar.length;i<l;i++)
			if (ar[i] !== null && typeof ar[i] != 'undefined')
				arv.push(ar[i]);
		return arv;
	},

	_array_values_ob: function(ar)
	{
		var arv = [];
		for(var i in ar)
			if (ar[i] !== null && typeof ar[i] != 'undefined')
				arv.push(ar[i]);
		return arv;
	},

	array_keys: function(ar)
	{
		if (!BX.type.isArray(ar))
			return BX.util._array_keys_ob(ar);
		var arv = [];
		for(var i=0,l=ar.length;i<l;i++)
			if (ar[i] !== null && typeof ar[i] != 'undefined')
				arv.push(i);
		return arv;
	},

	_array_keys_ob: function(ar)
	{
		var arv = [];
		for(var i in ar)
			if (ar[i] !== null && typeof ar[i] != 'undefined')
				arv.push(i);
		return arv;
	},

	array_merge: function(first, second)
	{
		if (!BX.type.isArray(first)) first = [];
		if (!BX.type.isArray(second)) second = [];

		var i = first.length, j = 0;

		if (typeof second.length === "number")
		{
			for (var l = second.length; j < l; j++)
			{
				first[i++] = second[j];
			}
		}
		else
		{
			while (second[j] !== undefined)
			{
				first[i++] = second[j++];
			}
		}

		first.length = i;

		return first;
	},

	array_unique: function(ar)
	{
		var i=0,j,len=ar.length;
		if(len<2) return ar;

		for (; i<len-1;i++)
		{
			for (j=i+1; j<len;j++)
			{
				if (ar[i]==ar[j])
				{
					ar.splice(j--,1); len--;
				}
			}
		}

		return ar;
	},

	in_array: function(needle, haystack)
	{
		for(var i=0; i<haystack.length; i++)
		{
			if(haystack[i] == needle)
				return true;
		}
		return false;
	},

	array_search: function(needle, haystack)
	{
		for(var i=0; i<haystack.length; i++)
		{
			if(haystack[i] == needle)
				return i;
		}
		return -1;
	},

	object_search_key: function(needle, haystack)
	{
		if (haystack[needle])
			return haystack[needle];

		for(var i in haystack)
		{
			if (typeof haystack[i] == "object")
			{
				var result = BX.util.object_search_key(needle, haystack[i]);
				if (result !== false)
					return result;
			}
		}
		return false;
	},

	trim: function(s)
	{
		if (BX.type.isString(s))
			return s.replace(r.ltrim, '').replace(r.rtrim, '');
		else
			return s;
	},

	urlencode: function(s){return encodeURIComponent(s);},

	// it may also be useful. via sVD.
	deleteFromArray: function(ar, ind) {return ar.slice(0, ind).concat(ar.slice(ind + 1));},
	insertIntoArray: function(ar, ind, el) {return ar.slice(0, ind).concat([el]).concat(ar.slice(ind));},

	htmlspecialchars: function(str)
	{
		if(!str.replace) return str;

		return str.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	},

	htmlspecialcharsback: function(str)
	{
		if(!str.replace) return str;

		return str.replace(/\&quot;/g, '"').replace(/&#39;/g, "'").replace(/\&lt;/g, '<').replace(/\&gt;/g, '>').replace(/\&amp;/g, '&');
	},

	// Quote regular expression characters plus an optional character
	preg_quote: function(str, delimiter)
	{
		if(!str.replace)
			return str;
		return str.replace(new RegExp('[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\' + (delimiter || '') + '-]', 'g'), '\\$&');
	},

	jsencode: function(str)
	{
		if (!str || !str.replace)
			return str;

		var escapes =
		[
			{ c: "\\\\", r: "\\\\" }, // should be first
			{ c: "\\t", r: "\\t" },
			{ c: "\\n", r: "\\n" },
			{ c: "\\r", r: "\\r" },
			{ c: "\"", r: "\\\"" },
			{ c: "'", r: "\\'" },
			{ c: "<", r: "\\x3C" },
			{ c: ">", r: "\\x3E" },
			{ c: "\\u2028", r: "\\u2028" },
			{ c: "\\u2029", r: "\\u2029" }
		];
		for (var i = 0; i < escapes.length; i++)
			str = str.replace(new RegExp(escapes[i].c, 'g'), escapes[i].r);
		return str;
	},

	str_pad: function(input, pad_length, pad_string, pad_type)
	{
		pad_string = pad_string || ' ';
		pad_type = pad_type || 'right';
		input = input.toString();

		if (pad_type == 'left')
			return BX.util.str_pad_left(input, pad_length, pad_string);
		else
			return BX.util.str_pad_right(input, pad_length, pad_string);

	},

	str_pad_left: function(input, pad_length, pad_string)
	{
		var i = input.length, q=pad_string.length;
		if (i >= pad_length) return input;

		for(;i<pad_length;i+=q)
			input = pad_string + input;

		return input;
	},

	str_pad_right: function(input, pad_length, pad_string)
	{
		var i = input.length, q=pad_string.length;
		if (i >= pad_length) return input;

		for(;i<pad_length;i+=q)
			input += pad_string;

		return input;
	},

	strip_tags: function(str)
	{
		return str.split(/<[^>]+>/g).join('')
	},

	popup: function(url, width, height)
	{
		var w, h;
		if(BX.browser.IsOpera())
		{
			w = document.body.offsetWidth;
			h = document.body.offsetHeight;
		}
		else
		{
			w = screen.width;
			h = screen.height;
		}
		return window.open(url, '', 'status=no,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+Math.floor((h - height)/2-14)+',left='+Math.floor((w - width)/2-5));
	},

	// BX.util.objectSort(object, sortBy, sortDir) - Sort object by property
	// function params: 1 - object for sort, 2 - sort by property, 3 - sort direction (asc/desc)
	// return: sort array [[objectElement], [objectElement]] in sortDir direction

	// example: BX.util.objectSortBy({'L1': {'name': 'Last'}, 'F1': {'name': 'First'}}, 'name', 'asc');
	// return: [{'name' : 'First'}, {'name' : 'Last'}]
	objectSort: function(object, sortBy, sortDir)
	{
		sortDir = sortDir == 'asc'? 'asc': 'desc';

		var arItems = Array();
		for (var i in object)
			if (object[i][sortBy])
				arItems.push([i, object[i][sortBy]]);

		if (sortDir == 'asc')
		{
			arItems.sort(function(i, ii) {
				if (!isNaN(i[1]) && !isNaN(ii[1]))
				{
					var s1 = parseInt(i[1]); var s2 = parseInt(ii[1]);
				}
				else
				{
					var s1 = i[1].toString().toLowerCase(); var s2 = ii[1].toString().toLowerCase();
				}
				if (s1 > s2) return 1; else if (s1 < s2) return -1; else return 0;
			});
		}
		else
		{
			arItems.sort(function(i, ii) {
				if (!isNaN(i[1]) && !isNaN(ii[1]))
				{
					var s1 = parseInt(i[1]);
					var s2 = parseInt(ii[1]);
				}
				else
				{
					var s1 = i[1].toString().toLowerCase();
					var s2 = ii[1].toString().toLowerCase();
				}
				if (s1 < s2) return 1; else if (s1 > s2) return -1; else return 0;
			});
		}

		var arReturnArray = Array();
		for (var i = 0; i < arItems.length; i++)
			arReturnArray.push(object[arItems[i][0]]);

		return arReturnArray;
	},

	// #fdf9e5 => {r=253, g=249, b=229}
	hex2rgb: function(color)
	{
		var rgb = color.replace(/[# ]/g,"").replace(/^(.)(.)(.)$/,'$1$1$2$2$3$3').match(/.{2}/g);
		for (var i=0;  i<3; i++)
		{
			rgb[i] = parseInt(rgb[i], 16);
		}
		return {'r':rgb[0],'g':rgb[1],'b':rgb[2]};
	},

	remove_url_param: function(url, param)
	{
		if (BX.type.isArray(param))
		{
			for (var i=0; i<param.length; i++)
				url = BX.util.remove_url_param(url, param[i])
		}
		else
		{
			url = url.replace(new RegExp('([?&])'+param+'=[^&]*[&]*', 'i'), '$1');
		}

		return url;
	},

	even: function(digit)
	{
		return (parseInt(digit) % 2 == 0)? true: false;
	}
}

BX.type = {
	isString: function(item) {
		return item === '' ? true : (item ? (typeof (item) == "string" || item instanceof String) : false);
	},
	isNotEmptyString: function(item) {
		return BX.type.isString(item) ? item.length > 0 : false;
	},
	isBoolean: function(item) {
		return item === true || item === false;
	},
	isNumber: function(item) {
		return item === 0 ? true : (item ? (typeof (item) == "number" || item instanceof Number) : false);
	},
	isFunction: function(item) {
		return item === null ? false : (typeof (item) == "function" || item instanceof Function);
	},
	isElementNode: function(item) {
		//document.body.ELEMENT_NODE;
		return item && typeof (item) == "object" && "nodeType" in item && item.nodeType == 1 && item.tagName && item.tagName.toUpperCase() != 'SCRIPT' && item.tagName.toUpperCase() != 'STYLE' && item.tagName.toUpperCase() != 'LINK';
	},
	isDomNode: function(item) {
		return item && typeof (item) == "object" && "nodeType" in item;
	},
	isArray: function(item) {
		return item && Object.prototype.toString.call(item) == "[object Array]";
	},
	isDate : function(item) {
		return item && Object.prototype.toString.call(item) == "[object Date]";
	}
}

BX.isNodeInDom = function(node)
{
	return node === document ? true :
		(node.parentNode ? BX.isNodeInDom(node.parentNode) : false);
}

BX.isNodeHidden = function(node)
{
	if (node === document)
		return false;
	else if (BX.style(node, 'display') == 'none')
		return true;
	else
		return (node.parentNode ? BX.isNodeHidden(node.parentNode) : true);
}

BX.evalPack = function(code)
{
	while (code.length > 0)
	{
		var c = code.shift();

		if (c.TYPE == 'SCRIPT_EXT' || c.TYPE == 'SCRIPT_SRC')
		{
			BX.loadScript(c.DATA, function() {BX.evalPack(code)});
		}
		else if (c.TYPE == 'SCRIPT')
			BX.evalGlobal(c.DATA);
	}
}

BX.evalGlobal = function(data)
{
	if (data)
	{
		var head = document.getElementsByTagName("head")[0] || document.documentElement,
			script = document.createElement("script");

		script.type = "text/javascript";

		if (!BX.browser.IsIE())
		{
			script.appendChild(document.createTextNode(data));
		}
		else
		{
			script.text = data;
		}

		head.insertBefore(script, head.firstChild);
		head.removeChild(script);
	}
}

BX.processHTML = function(HTML, scriptsRunFirst)
{
	var matchScript, scripts = [], styles = [], data = HTML;

	while ((matchScript = data.match(r.script)) !== null)
	{
		var end = data.search(/<\/script>/i);
		if (end == -1)
			break;

		var bRunFirst = scriptsRunFirst || (matchScript[1].indexOf('bxrunfirst') != '-1');

		var matchSrc;
		if ((matchSrc = matchScript[1].match(r.script_src)) !== null)
			scripts.push({"bRunFirst": bRunFirst, "isInternal": false, "JS": matchSrc[1]});
		else
		{
			var start = matchScript.index + matchScript[0].length;
			var js = data.substr(start, end-start);

			scripts.push({"bRunFirst": bRunFirst, "isInternal": true, "JS": js});
		}

		data = data.substr(0, matchScript.index) + data.substr(end+9);
	}

	while ((matchStyle = data.match(r.style)) !== null)
	{
		var matchHref;
		if ((matchHref = matchStyle[0].match(r.style_href)) !== null && matchStyle[0].indexOf('media="') < 0)
		{
			styles.push(matchHref[1]);
		}
		data = data.replace(matchStyle[0], '');
	}

	return {'HTML': data, 'SCRIPT': scripts, 'STYLE': styles};
}

BX.garbage = function(call, thisObject)
{
	garbageCollectors.push({callback: call, context: thisObject});
}

/* window pos functions */

BX.GetDocElement = function (pDoc)
{
	pDoc = pDoc || document;
	return (BX.browser.IsDoctype(pDoc) ? pDoc.documentElement : pDoc.body);
}

BX.GetContext = function(node)
{
	if (BX.type.isElementNode(node))
		return node.ownerDocument.parentWindow || node.ownerDocument.defaultView || window;
	else if (BX.type.isDomNode(node))
		return node.parentWindow || node.defaultView || window;
	else
		return window;
}

BX.GetWindowInnerSize = function(pDoc)
{
	var width, height;

	pDoc = pDoc || document;

	if (self.innerHeight) // all except Explorer
	{
		width = BX.GetContext(pDoc).innerWidth;
		height = BX.GetContext(pDoc).innerHeight;
	}
	else if (pDoc.documentElement && (pDoc.documentElement.clientHeight || pDoc.documentElement.clientWidth)) // Explorer 6 Strict Mode
	{
		width = pDoc.documentElement.clientWidth;
		height = pDoc.documentElement.clientHeight;
	}
	else if (pDoc.body) // other Explorers
	{
		width = pDoc.body.clientWidth;
		height = pDoc.body.clientHeight;
	}
	return {innerWidth : width, innerHeight : height};
}

BX.GetWindowScrollPos = function(pDoc)
{
	var left, top;

	pDoc = pDoc || document;

	if (self.pageYOffset) // all except Explorer
	{
		left = BX.GetContext(pDoc).pageXOffset;
		top = BX.GetContext(pDoc).pageYOffset;
	}
	else if (pDoc.documentElement && (pDoc.documentElement.scrollTop || pDoc.documentElement.scrollLeft)) // Explorer 6 Strict
	{
		left = pDoc.documentElement.scrollLeft;
		top = pDoc.documentElement.scrollTop;
	}
	else if (pDoc.body) // all other Explorers
	{
		left = pDoc.body.scrollLeft;
		top = pDoc.body.scrollTop;
	}
	return {scrollLeft : left, scrollTop : top};
}

BX.GetWindowScrollSize = function(pDoc)
{
	var width, height;
	if (!pDoc)
		pDoc = document;

	if ( (pDoc.compatMode && pDoc.compatMode == "CSS1Compat"))
	{
		width = pDoc.documentElement.scrollWidth;
		height = pDoc.documentElement.scrollHeight;
	}
	else
	{
		if (pDoc.body.scrollHeight > pDoc.body.offsetHeight)
			height = pDoc.body.scrollHeight;
		else
			height = pDoc.body.offsetHeight;

		if (pDoc.body.scrollWidth > pDoc.body.offsetWidth ||
			(pDoc.compatMode && pDoc.compatMode == "BackCompat") ||
			(pDoc.documentElement && !pDoc.documentElement.clientWidth)
		)
			width = pDoc.body.scrollWidth;
		else
			width = pDoc.body.offsetWidth;
	}
	return {scrollWidth : width, scrollHeight : height};
}

BX.GetWindowSize = function(pDoc)
{
	var innerSize = this.GetWindowInnerSize(pDoc);
	var scrollPos = this.GetWindowScrollPos(pDoc);
	var scrollSize = this.GetWindowScrollSize(pDoc);

	return  {
		innerWidth : innerSize.innerWidth, innerHeight : innerSize.innerHeight,
		scrollLeft : scrollPos.scrollLeft, scrollTop : scrollPos.scrollTop,
		scrollWidth : scrollSize.scrollWidth, scrollHeight : scrollSize.scrollHeight
	};
}

BX.hide_object = function(ob)
{
	ob = BX(ob);
	ob.style.position = 'absolute';
	ob.style.top = '-1000px';
	ob.style.left = '-1000px';
	ob.style.height = '10px';
	ob.style.width = '10px';
};

BX.is_relative = function(el)
{
	var p = BX.style(el, 'position');
	return p == 'relative' || p == 'absolute';
}

BX.is_float = function(el)
{
	var p = BX.style(el, 'float');
	return p == 'right' || p == 'left';
}

BX.is_fixed = function(el)
{
	var p = BX.style(el, 'position');
	return p == 'fixed';
}

BX.pos = function(el, bRelative)
{
	var r = { top: 0, right: 0, bottom: 0, left: 0, width: 0, height: 0 };
	bRelative = !!bRelative;
	if (!el)
		return r;
	if (typeof (el.getBoundingClientRect) != "undefined" && el.ownerDocument == document && !bRelative)
	{
		var clientRect = el.getBoundingClientRect();
		var root = document.documentElement;
		var body = document.body;

		r.top = clientRect.top + (root.scrollTop || body.scrollTop);
		r.left = clientRect.left + (root.scrollLeft || body.scrollLeft);
		r.width = clientRect.right - clientRect.left;
		r.height = clientRect.bottom - clientRect.top;
		r.right = clientRect.right + (root.scrollLeft || body.scrollLeft);
		r.bottom = clientRect.bottom + (root.scrollTop || body.scrollTop);
	}
	else
	{
		var x = 0, y = 0, w = el.offsetWidth, h = el.offsetHeight;
		var first = true;
		for (; el != null; el = el.offsetParent)
		{
			if (!first && bRelative && BX.is_relative(el))
				break;

			x += el.offsetLeft;
			y += el.offsetTop;
			if (first)
			{
				first = false;
				continue;
			}

			var elBorderLeftWidth = parseInt(BX.style(el, 'border-left-width')),
				elBorderTopWidth = parseInt(BX.style(el, 'border-top-width'));

			if (!isNaN(elBorderLeftWidth) && elBorderLeftWidth > 0)
				x += elBorderLeftWidth;
			if (!isNaN(elBorderTopWidth) && elBorderTopWidth > 0)
				y += elBorderTopWidth;
		}

		r.top = y;
		r.left = x;
		r.width = w;
		r.height = h;
		r.right = r.left + w;
		r.bottom = r.top + h;
	}

	for (var i in r) r[i] = parseInt(r[i]);

	return r;
}


BX.align = function(pos, w, h, type)
{
	if (type)
		type = type.toLowerCase();
	else
		type = '';

	var pDoc = document;
	if (BX.type.isElementNode(pos))
	{
		pDoc = pos.ownerDocument;
		pos = BX.pos(pos);
	}

	var x = pos["left"], y = pos["bottom"];

	var scroll = BX.GetWindowScrollPos(pDoc);
	var size = BX.GetWindowInnerSize(pDoc);

	if((size.innerWidth + scroll.scrollLeft) - (pos["left"] + w) < 0)
	{
		if(pos["right"] - w >= 0 )
			x = pos["right"] - w;
		else
			x = scroll.scrollLeft;
	}

	if(((size.innerHeight + scroll.scrollTop) - (pos["bottom"] + h) < 0) || ~type.indexOf('top'))
	{
		if(pos["top"] - h >= 0 || ~type.indexOf('top'))
			y = pos["top"] - h;
		else
			y = scroll.scrollTop;
	}

	return {'left':x, 'top':y};
}

BX.scrollToNode = function(node)
{
	var obNode = BX(node);

	if (obNode.scrollIntoView)
		obNode.scrollIntoView(true);
	else
	{
		var arNodePos = BX.pos(obNode);
		window.scrollTo(arNodePos.left, arNodePos.top);
	}
}

/* non-xhr loadings */
BX.showWait = function(node, msg)
{
	node = BX(node) || document.body || document.documentElement;
	msg = msg || BX.message('JS_CORE_LOADING');

	var container_id = node.id || Math.random();

	var obMsg = node.bxmsg = document.body.appendChild(BX.create('DIV', {
		props: {
			id: 'wait_' + container_id,
			className: 'bx-core-waitwindow'
		},
		text: msg
	}));

	setTimeout(BX.delegate(_adjustWait, node), 10);

	lastWait[lastWait.length] = obMsg;
	return obMsg;
}

BX.closeWait = function(node, obMsg)
{
	if(node && !obMsg)
		obMsg = node.bxmsg;
	if(node && !obMsg && BX.hasClass(node, 'bx-core-waitwindow'))
		obMsg = node;
	if(node && !obMsg)
		obMsg = BX('wait_' + node.id);
	if(!obMsg)
		obMsg = lastWait.pop();

	if (obMsg && obMsg.parentNode)
	{
		for (var i=0,len=lastWait.length;i<len;i++)
		{
			if (obMsg == lastWait[i])
			{
				lastWait = BX.util.deleteFromArray(lastWait, i);
				break;
			}
		}

		obMsg.parentNode.removeChild(obMsg);
		if (node) node.bxmsg = null;
		BX.cleanNode(obMsg, true);
	}
}

BX.setKernelJS = function(scripts)
{
	if (BX.type.isArray(scripts))
		arKernelJS = scripts;
}

BX.getKernelJS = function()
{
	return arKernelJS;
}

BX.loadScript = function(script, callback, doc)
{
	if (!BX.isReady)
	{
		var _args = arguments;
		BX.ready(function() {
			BX.loadScript.apply(this, _args);
		});
		return;
	}

	doc = doc || document;

	if (BX.type.isString(script))
		script = [script];
	var _callback = function()
	{
		return (callback && BX.type.isFunction(callback)) ? callback() : null
	}
	var load_js = function(ind)
	{
		if(ind >= script.length)
			return _callback();

		if(!!script[ind])
		{
			var oHead = doc.getElementsByTagName("head")[0] || doc.documentElement;
			var oScript = doc.createElement('script');
			oScript.src = script[ind];

			var verInd = script[ind].indexOf('.js?');
			if(verInd>0)
				fileSrc = script[ind].substr(0, verInd + 3);
			else
				fileSrc = script[ind];

			if(_isScriptLoaded(fileSrc))
			{
				load_js(++ind);
			}
			else
			{
				var bLoaded = false;
				oScript.onload = oScript.onreadystatechange = function()
				{
					if (!bLoaded && (!oScript.readyState || oScript.readyState == "loaded" || oScript.readyState == "complete"))
					{
						bLoaded = true;
						setTimeout(function (){load_js(++ind);}, 50);

						oScript.onload = oScript.onreadystatechange = null;
						if (oHead && oScript.parentNode)
						{
							oHead.removeChild(oScript);
						}
					}
				}

				return oHead.insertBefore(oScript, oHead.firstChild);
			}
		}
		else
		{
			load_js(++ind);
		}
	}

	load_js(0);
}

BX.loadCSS = function(arCSS, doc, win)
{
	if (!BX.isReady)
	{
		var _args = arguments;
		BX.ready(function() {
			BX.loadCSS.apply(this, _args);
		});
		return null;
	}

	if (BX.type.isString(arCSS))
	{
		var bSingle = true;
		arCSS = [arCSS];
	}
	var i = 0,
		l = arCSS.length,
		lnk = null,
		pLnk = [];

	if (l == 0)
		return null;

	doc = doc || document;
	win = win || window;

	_checkCssList();

	if (!win.bxhead)
	{
		var heads = doc.getElementsByTagName('HEAD');
		win.bxhead = heads[0];

		if (!win.bxhead)
		{
			return null;
		}
	}

	for (i = 0; i < l; i++)
	{
		var _check = arCSS[i]
				.replace(/\.css(\?\d*)/, '.css')
				.replace(/^(http[s]*:)*\/\/[^\/]+/i, '');

		if (BX.util.in_array(_check, cssList))
			continue;

		lnk = document.createElement('LINK');
		lnk.href = arCSS[i];
		lnk.rel = 'stylesheet';
		lnk.type = 'text/css';
		win.bxhead.appendChild(lnk);

		pLnk.push(lnk);
		cssList.push(_check);
	}

	if (bSingle)
		return lnk;

	return pLnk;
}

BX.reload = function(back_url, bAddClearCache)
{
	if (back_url === true)
	{
		bAddClearCache = true;
		back_url = null;
	}

	var new_href = back_url || top.location.href;

	var hashpos = new_href.indexOf('#'), hash = '';

	if (hashpos != -1)
	{
		hash = new_href.substr(hashpos);
		new_href = new_href.substr(0, hashpos);
	}

	if (bAddClearCache && new_href.indexOf('clear_cache=Y') < 0)
		new_href += (new_href.indexOf('?') == -1 ? '?' : '&') + 'clear_cache=Y';

	if (hash)
	{
		// hack for clearing cache in ajax mode components with history emulation
		if (bAddClearCache && (hash.substr(0, 5) == 'view/' || hash.substr(0, 6) == '#view/') && hash.indexOf('clear_cache%3DY') < 0)
			hash += (hash.indexOf('%3F') == -1 ? '%3F' : '%26') + 'clear_cache%3DY'

		new_href = new_href.replace(/(\?|\&)_r=[\d]*/, '');
		new_href += (new_href.indexOf('?') == -1 ? '?' : '&') + '_r='+Math.round(Math.random()*10000) + hash;
	}

	top.location.href = new_href;
}

BX.clearCache = function()
{
	BX.showWait();
	BX.reload(true);
}

BX.template = function(tpl, callback, bKillTpl)
{
	BX.ready(function() {
		_processTpl(BX(tpl), callback, bKillTpl);
	});
}

BX.isAmPmMode = function()
{
	return BX.message('FORMAT_DATETIME').match('T') == null ? false : true;
}

BX.formatDate = function(date, format)
{
	date = date || new Date();

	var bTime = date.getHours() || date.getMinutes() || date.getSeconds(),
		str = !!format
			? format :
			(bTime ? BX.message('FORMAT_DATETIME') : BX.message('FORMAT_DATE')
		);

	return str.replace(/YYYY/ig, date.getFullYear())
		.replace(/MMMM/ig, BX.util.str_pad_left((date.getMonth()+1).toString(), 2, '0'))
		.replace(/MM/ig, BX.util.str_pad_left((date.getMonth()+1).toString(), 2, '0'))
		.replace(/DD/ig, BX.util.str_pad_left(date.getDate().toString(), 2, '0'))
		.replace(/HH/ig, BX.util.str_pad_left(date.getHours().toString(), 2, '0'))
		.replace(/MI/ig, BX.util.str_pad_left(date.getMinutes().toString(), 2, '0'))
		.replace(/SS/ig, BX.util.str_pad_left(date.getSeconds().toString(), 2, '0'));
}

BX.getNumMonth = function(month)
{
	var wordMonthCut = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
	var wordMonth = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

	var q = month.toUpperCase();
	for (i = 1; i <= 12; i++)
	{
		if (q == BX.message('MON_'+i).toUpperCase() || q == BX.message('MONTH_'+i).toUpperCase() || q == wordMonthCut[i-1].toUpperCase() || q == wordMonth[i-1].toUpperCase())
		{
			return i;
		}
	}
	return month;
}

BX.parseDate = function(str)
{
	if (BX.type.isNotEmptyString(str))
	{
		var regMonths = '';
		for (i = 1; i <= 12; i++)
		{
			regMonths = regMonths + '|' + BX.message('MON_'+i);
		}

		var expr = new RegExp('([0-9]+|[a-z]+' + regMonths + ')', 'ig');
		var aDate = str.match(expr),
			aFormat = BX.message('FORMAT_DATE').match(/(DD|MI|MMMM|MM|M|YYYY)/ig),
			i, cnt,
			aDateArgs=[], aFormatArgs=[],
			aResult={};

		if (!aDate)
			return null;

		if(aDate.length > aFormat.length)
		{
			aFormat = BX.message('FORMAT_DATETIME').match(/(DD|MI|MMMM|MM|M|YYYY|HH|H|SS|TT|T|GG|G)/ig);
		}

		for(i = 0, cnt = aDate.length; i < cnt; i++)
		{
			if(BX.util.trim(aDate[i]) != '')
			{
				aDateArgs[aDateArgs.length] = aDate[i];
			}
		}

		for(i = 0, cnt = aFormat.length; i < cnt; i++)
		{
			if(BX.util.trim(aFormat[i]) != '')
			{
				aFormatArgs[aFormatArgs.length] = aFormat[i];
			}
		}


		var m = BX.util.array_search('MMMM', aFormatArgs)
		if (m > 0)
		{
			aDateArgs[m] = BX.getNumMonth(aDateArgs[m]);
			aFormatArgs[m] = "MM";
		}
		else
		{
			m = BX.util.array_search('M', aFormatArgs)
			if (m > 0)
			{
				aDateArgs[m] = BX.getNumMonth(aDateArgs[m]);
				aFormatArgs[m] = "MM";
			}
		}

		for(i = 0, cnt = aFormatArgs.length; i < cnt; i++)
		{
			var k = aFormatArgs[i].toUpperCase();
			aResult[k] = k == 'T' || k == 'TT' ? aDateArgs[i] : parseInt(aDateArgs[i], 10);
		}

		if(aResult['DD'] > 0 && aResult['MM'] > 0 && aResult['YYYY'] > 0)
		{
			var d = new Date();
			d.setDate(1);
			d.setFullYear(aResult['YYYY']);
			d.setMonth(aResult['MM']-1);
			d.setDate(aResult['DD']);
			d.setHours(0, 0, 0);

			if(
				(!isNaN(aResult['HH']) || !isNaN(aResult['GG']) || !isNaN(aResult['H']) || !isNaN(aResult['G']))
					&& !isNaN(aResult['MI'])
			)
			{
				if (!isNaN(aResult['H']) || !isNaN(aResult['G']))
				{
					var bPM = (aResult['T']||aResult['TT']||'am').toUpperCase()=='PM';
					aResult['HH'] = parseInt(aResult['H']||aResult['G']||0, 10) + (bPM ? 12 : 0);
				}
				else
				{
					aResult['HH'] = parseInt(aResult['HH']||aResult['GG']||0, 10);
				}

				if (isNaN(aResult['SS']))
					aResult['SS'] = 00;

				d.setHours(aResult['HH'], aResult['MI'], aResult['SS']);
			}

			return d;
		}
	}

	return null;
}

BX.selectUtils =
{
	addNewOption: function(oSelect, opt_value, opt_name, do_sort, check_unique)
	{
		oSelect = BX(oSelect);
		if(oSelect)
		{
			var n = oSelect.length;
			if(check_unique !== false)
			{
				for(var i=0;i<n;i++)
				{
					if(oSelect[i].value==opt_value)
					{
						return;
					}
				}
			}

			var newoption = new Option(opt_name, opt_value, false, false);
			oSelect.options[n]=newoption;
		}

		if(do_sort === true)
		{
			this.sortSelect(select_id);
		}
	},

	deleteOption: function(oSelect, opt_value)
	{
		oSelect = BX(oSelect);
		if(oSelect)
		{
			for(var i=0;i<oSelect.length;i++)
			{
				if(oSelect[i].value==opt_value)
				{
					oSelect.remove(i);
					break;
				}
			}
		}
	},

	deleteSelectedOptions: function(select_id)
	{
		var oSelect = BX(select_id);
		if(oSelect)
		{
			var i=0;
			while(i<oSelect.length)
			{
				if(oSelect[i].selected)
				{
					oSelect[i].selected=false;
					oSelect.remove(i);
				}
				else
				{
					i++;
				}
			}
		}
	},

	deleteAllOptions: function(oSelect)
	{
		oSelect = BX(oSelect);
		if(oSelect)
		{
			for(var i=oSelect.length-1; i>=0; i--)
			{
				oSelect.remove(i);
			}
		}
	},

	optionCompare: function(record1, record2)
	{
		var value1 = record1.optText.toLowerCase();
		var value2 = record2.optText.toLowerCase();
		if (value1 > value2) return(1);
		if (value1 < value2) return(-1);
		return(0);
	},

	sortSelect: function(oSelect)
	{
		oSelect = BX(select_id);
		if(oSelect)
		{
			var myOptions = [];
			var n = oSelect.options.length;
			for (var i=0;i<n;i++)
			{
				myOptions[i] = {
					optText:oSelect[i].text,
					optValue:oSelect[i].value
				};
			}
			myOptions.sort(this.optionCompare);
			oSelect.length=0;
			n = myOptions.length;
			for(var i=0;i<n;i++)
			{
				var newoption = new Option(myOptions[i].optText, myOptions[i].optValue, false, false);
				oSelect[i]=newoption;
			}
		}
	},

	selectAllOptions: function(oSelect)
	{
		oSelect = BX(select_id);
		if(oSelect)
		{
			var n = oSelect.length;
			for(var i=0;i<n;i++)
			{
				oSelect[i].selected=true;
			}
		}
	},

	selectOption: function(oSelect, opt_value)
	{
		oSelect = BX(select_id);
		if(oSelect)
		{
			var n = oSelect.length;
			for(var i=0;i<n;i++)
			{
				oSelect[i].selected = (oSelect[i].value == opt_value);
			}
		}
	},

	addSelectedOptions: function(oSelect, to_select_id, check_unique, do_sort)
	{
		oSelect = BX(oSelect);
		if(!oSelect)
			return;
		var n = oSelect.length;
		for(var i=0; i<n; i++)
			if(oSelect[i].selected)
				this.addNewOption(to_select_id, oSelect[i].value, oSelect[i].text, do_sort, check_unique);
	},

	moveOptionsUp: function(oSelect)
	{
		oSelect = BX(oSelect)
		if(!oSelect)
			return;
		var n = oSelect.length;
		for(var i=0; i<n; i++)
		{
			if(oSelect[i].selected && i>0 && oSelect[i-1].selected == false)
			{
				var option1 = new Option(oSelect[i].text, oSelect[i].value);
				var option2 = new Option(oSelect[i-1].text, oSelect[i-1].value);
				oSelect[i] = option2;
				oSelect[i].selected = false;
				oSelect[i-1] = option1;
				oSelect[i-1].selected = true;
			}
		}
	},

	moveOptionsDown: function(oSelect)
	{
		oSelect = BX(oSelect);
		if(!oSelect)
			return;
		var n = oSelect.length;
		for(var i=n-1; i>=0; i--)
		{
			if(oSelect[i].selected && i<n-1 && oSelect[i+1].selected == false)
			{
				var option1 = new Option(oSelect[i].text, oSelect[i].value);
				var option2 = new Option(oSelect[i+1].text, oSelect[i+1].value);
				oSelect[i] = option2;
				oSelect[i].selected = false;
				oSelect[i+1] = option1;
				oSelect[i+1].selected = true;
			}
		}
	}
}



/******* HINT ***************/
// if function has 2 params - the 2nd one is hint html. otherwise hint_html is third and hint_title - 2nd;
// '<div onmouseover="BX.hint(this, 'This is &lt;b&gt;Hint&lt;/b&gt;')"'>;
// BX.hint(el, 'This is <b>Hint</b>') - this won't work, use constructor
BX.hint = function(el, hint_title, hint_html, hint_id)
{
	if (null == hint_html)
	{
		hint_html = hint_title;
		hint_title = '';
	}

	if (null == el.BXHINT)
	{
		el.BXHINT = new BX.CHint({
			parent: el, hint: hint_html, title: hint_title, id: hint_id
		});
		el.BXHINT.Show();
	}
}

BX.hint_replace = function(el, hint_title, hint_html)
{
	if (null == hint_html)
	{
		hint_html = hint_title;
		hint_title = '';
	}

	if (!el || !el.parentNode || !hint_html)
			return null;

	var obHint = new BX.CHint({
		hint: hint_html,
		title: hint_title
	});

	obHint.CreateParent();

	el.parentNode.insertBefore(obHint.PARENT, el);
	el.parentNode.removeChild(el);

	obHint.PARENT.style.marginLeft = '5px';

	return el;
}

BX.CHint = function(params)
{
	this.PARENT = BX(params.parent);

	this.HINT = params.hint;
	this.HINT_TITLE = params.title;

	this.PARAMS = {}
	for (var i in this.defaultSettings)
	{
		if (null == params[i])
			this.PARAMS[i] = this.defaultSettings[i];
		else
			this.PARAMS[i] = params[i];
	}

	if (null != params.id)
		this.ID = params.id;

	this.timer = null;
	this.bInited = false;
	this.msover = true;

	if (this.PARAMS.showOnce)
	{
		this.__show();
		this.msover = false;
		this.timer = setTimeout(BX.proxy(this.__hide, this), this.PARAMS.hide_timeout);
	}
	else if (this.PARENT)
	{
		BX.bind(this.PARENT, 'mouseover', BX.proxy(this.Show, this));
		BX.bind(this.PARENT, 'mouseout', BX.proxy(this.Hide, this));
	}

	BX.addCustomEvent('onMenuOpen', BX.delegate(this.disable, this));
	BX.addCustomEvent('onMenuClose', BX.delegate(this.enable, this));
}

BX.CHint.prototype.defaultSettings = {
	show_timeout: 1000,
	hide_timeout: 500,
	dx: 2,
	showOnce: false,
	preventHide: true,
	min_width: 250
}

BX.CHint.prototype.CreateParent = function(element, params)
{
	if (this.PARENT)
	{
		BX.unbind(this.PARENT, 'mouseover', BX.proxy(this.Show, this));
		BX.unbind(this.PARENT, 'mouseout', BX.proxy(this.Hide, this));
	}

	if (!params) params = {}
	var type = 'icon';

	if (params.type && (params.type == "link" || params.type == "icon"))
		type = params.type;

	if (element)
		type = "element";

	if (type == "icon")
	{
		element = BX.create('IMG', {
			props: {
				src: params.iconSrc
					? params.iconSrc
					: "/bitrix/js/main/core/images/hint.gif"
			}
		});
	}
	else if (type == "link")
	{
		element = BX.create("A", {
			props: {href: 'javascript:void(0)'},
			html: '[?]'
		});
	}

	this.PARENT = element;

	BX.bind(this.PARENT, 'mouseover', BX.proxy(this.Show, this));
	BX.bind(this.PARENT, 'mouseout', BX.proxy(this.Hide, this));

	return this.PARENT;
}

BX.CHint.prototype.Show = function()
{
	this.msover = true;

	if (null != this.timer)
		clearTimeout(this.timer);

	this.timer = setTimeout(BX.proxy(this.__show, this), this.PARAMS.show_timeout);
}

BX.CHint.prototype.Hide = function()
{
	this.msover = false;

	if (null != this.timer)
		clearTimeout(this.timer);

	this.timer = setTimeout(BX.proxy(this.__hide, this), this.PARAMS.hide_timeout);
}

BX.CHint.prototype.__show = function()
{
	if (!this.msover || this.disabled) return;
	if (!this.bInited) this.Init();

	if (this.prepareAdjustPos())
	{
		this.DIV.style.display = 'block';
		this.adjustPos();

		BX.bind(window, 'scroll', BX.proxy(this.__onscroll, this));

		if (this.PARAMS.showOnce)
		{
			this.timer = setTimeout(BX.proxy(this.__hide, this), this.PARAMS.hide_timeout);
		}
	}
}

BX.CHint.prototype.__onscroll = function()
{
	if (!BX.admin || !BX.admin.panel || !BX.admin.panel.isFixed()) return;

	if (this.scrollTimer) clearTimeout(this.scrollTimer);

	this.DIV.style.display = 'none';
	this.scrollTimer = setTimeout(BX.proxy(this.Reopen, this), this.PARAMS.show_timeout);
}

BX.CHint.prototype.Reopen = function()
{
	if (null != this.timer) clearTimeout(this.timer);
	this.timer = setTimeout(BX.proxy(this.__show, this), 50);
}

BX.CHint.prototype.__hide = function()
{
	if (this.msover) return;
	if (!this.bInited) return;

	BX.unbind(window, 'scroll', BX.proxy(this.Reopen, this));

	if (this.PARAMS.showOnce)
	{
		this.Destroy();
	}
	else
	{
		this.DIV.style.display = 'none';
	}
}

BX.CHint.prototype.__hide_immediately = function()
{
	this.msover = false;
	this.__hide();
}

BX.CHint.prototype.Init = function()
{
	this.DIV = document.body.appendChild(BX.create('DIV', {
		props: {className: 'bx-panel-tooltip'},
		style: {display: 'none'},
		children: [
			BX.create('DIV', {
				props: {className: 'bx-panel-tooltip-top-border'},
				html: '<div class="bx-panel-tooltip-corner bx-panel-tooltip-left-corner"></div><div class="bx-panel-tooltip-border"></div><div class="bx-panel-tooltip-corner bx-panel-tooltip-right-corner"></div>'
			}),
			(this.CONTENT = BX.create('DIV', {
				props: {className: 'bx-panel-tooltip-content'},
				children: [
					BX.create('DIV', {
						props: {className: 'bx-panel-tooltip-underlay'},
						children: [
							BX.create('DIV', {props: {className: 'bx-panel-tooltip-underlay-bg'}})
						]
					})
				]
			})),

			BX.create('DIV', {
				props: {className: 'bx-panel-tooltip-bottom-border'},
				html: '<div class="bx-panel-tooltip-corner bx-panel-tooltip-left-corner"></div><div class="bx-panel-tooltip-border"></div><div class="bx-panel-tooltip-corner bx-panel-tooltip-right-corner"></div>'
			})
		]
	}));

	if (this.ID)
	{
		this.CONTENT.insertBefore(BX.create('A', {
			attrs: {href: 'javascript:void(0)'},
			props: {className: 'bx-panel-tooltip-close'},
			events: {click: BX.delegate(this.Close, this)}
		}), this.CONTENT.firstChild)
	}

	if (this.HINT_TITLE)
	{
		this.CONTENT.appendChild(
			BX.create('DIV', {
				props: {className: 'bx-panel-tooltip-title'},
				text: this.HINT_TITLE
			})
		)
	}

	if (this.HINT)
	{
		this.CONTENT_TEXT = this.CONTENT.appendChild(BX.create('DIV', {props: {className: 'bx-panel-tooltip-text'}})).appendChild(BX.create('SPAN', {html: this.HINT}));
	}

	if (this.PARAMS.preventHide)
	{
		BX.bind(this.DIV, 'mouseout', BX.proxy(this.Hide, this));
		BX.bind(this.DIV, 'mouseover', BX.proxy(this.Show, this));
	}

	this.bInited = true;
}

BX.CHint.prototype.setContent = function(content)
{
	this.HINT = content;

	if (this.CONTENT_TEXT)
		this.CONTENT_TEXT.innerHTML = this.HINT;
	else
		this.CONTENT_TEXT = this.CONTENT.appendChild(BX.create('DIV', {props: {className: 'bx-panel-tooltip-text'}})).appendChild(BX.create('SPAN', {html: this.HINT}));
}

BX.CHint.prototype.prepareAdjustPos = function()
{
	this._wnd = {scrollPos: BX.GetWindowScrollPos(),scrollSize:BX.GetWindowScrollSize()};
	return BX.style(this.PARENT, 'display') != 'none';
}

BX.CHint.prototype.getAdjustPos = function()
{
	var res = {}, pos = BX.pos(this.PARENT);

	res.top = pos.bottom + this.PARAMS.dx;

	if (BX.admin && BX.admin.panel.DIV)
	{
		var min_top = BX.admin.panel.DIV.offsetHeight + this.PARAMS.dx;

		if (BX.admin.panel.isFixed())
		{
			min_top += this._wnd.scrollPos.scrollTop;
		}
	}

	if (res.top < min_top)
		res.top = min_top;
	else
	{
		if (res.top + this.DIV.offsetHeight > this._wnd.scrollSize.scrollHeight)
			res.top = pos.top - this.PARAMS.dx - this.DIV.offsetHeight;
	}

	res.left = pos.left;
	if (pos.left < this.PARAMS.dx) pos.left = this.PARAMS.dx;
	else
	{
		floatWidth = this.DIV.offsetWidth;

		var max_left = this._wnd.scrollSize.scrollWidth - floatWidth - this.PARAMS.dx;

		if (res.left > max_left)
			res.left = max_left;
	}

	return res;
}

BX.CHint.prototype.adjustWidth = function()
{
	if (this.bWidthAdjusted) return;

	var w = this.DIV.offsetWidth, h = this.DIV.offsetHeight;

	if (w > this.PARAMS.min_width)
		w = Math.round(Math.sqrt(1.618*w*h));

	if (w < this.PARAMS.min_width)
		w = this.PARAMS.min_width;

	this.DIV.style.width = w + "px";

	if (this._adjustWidthInt)
		clearInterval(this._adjustWidthInt);
	this._adjustWidthInt = setInterval(BX.delegate(this._adjustWidthInterval, this), 5);

	this.bWidthAdjusted = true;
}

BX.CHint.prototype._adjustWidthInterval = function()
{
	if (!this.DIV || this.DIV.style.display == 'none')
		clearInterval(this._adjustWidthInt);

	var
		dW = 20,
		maxWidth = 1500,
		w = this.DIV.offsetWidth,
		w1 = this.CONTENT_TEXT.offsetWidth;

	if (w > 0 && w1 > 0 && w - w1 < dW && w < maxWidth)
	{
		this.DIV.style.width = (w + dW) + "px";
		return;
	}

	clearInterval(this._adjustWidthInt);
}

BX.CHint.prototype.adjustPos = function()
{
	this.adjustWidth();

	var pos = this.getAdjustPos();

	this.DIV.style.top = pos.top + 'px';
	this.DIV.style.left = pos.left + 'px';
}

BX.CHint.prototype.Close = function()
{
	if (this.ID && BX.WindowManager)
		BX.WindowManager.saveWindowOptions(this.ID, {display: 'off'});
	this.__hide_immediately();
	this.Destroy();
}

BX.CHint.prototype.Destroy = function()
{
	if (this.PARENT)
	{
		BX.unbind(this.PARENT, 'mouseover', BX.proxy(this.Show, this));
		BX.unbind(this.PARENT, 'mouseout', BX.proxy(this.Hide, this));
	}

	if (this.DIV)
	{
		BX.unbind(this.DIV, 'mouseover', BX.proxy(this.Show, this));
		BX.unbind(this.DIV, 'mouseout', BX.proxy(this.Hide, this));

		BX.cleanNode(this.DIV, true);
	}
}

BX.CHint.prototype.enable = function(){this.disabled = false;}
BX.CHint.prototype.disable = function(){this.__hide_immediately(); this.disabled = true;}

/* ready */
if (document.addEventListener)
{
	__readyHandler = function()
	{
		document.removeEventListener("DOMContentLoaded", __readyHandler, false);
		runReady();
	}
}
else if (document.attachEvent)
{
	__readyHandler = function()
	{
		if (document.readyState === "complete")
		{
			document.detachEvent("onreadystatechange", __readyHandler);
			runReady();
		}
	}
}

function bindReady()
{
	if (!readyBound)
	{
		readyBound = true;

		if (document.readyState === "complete")
		{
			return runReady();
		}

		if (document.addEventListener)
		{
			document.addEventListener("DOMContentLoaded", __readyHandler, false);
			window.addEventListener("load", runReady, false);
		}
		else if (document.attachEvent) // IE
		{
			document.attachEvent("onreadystatechange", __readyHandler);
			window.attachEvent("onload", runReady);

			var toplevel = false;
			try {toplevel = (window.frameElement == null);} catch(e) {}

			if (document.documentElement.doScroll && toplevel)
				doScrollCheck();
		}
	}

	return null;
}


function runReady()
{
	if (!BX.isReady)
	{
		if (!document.body)
			return setTimeout(runReady, 15);

		BX.isReady = true;


		if (readyList && readyList.length > 0)
		{
			var fn, i = 0;
			while (readyList && (fn = readyList[i++]))
			{
				try{
					fn.call(document);
				}
				catch(e){
					BX.debug('BX.ready error: ', e);
				}
			}

			readyList = null;
		}
		// TODO: check ready handlers binded some other way;
	}
	return null;
}

// hack for IE
function doScrollCheck()
{
	if (BX.isReady)
		return;

	try {document.documentElement.doScroll("left");} catch( error ) {setTimeout(doScrollCheck, 1); return;}

	runReady();
}
/* \ready */

function _adjustWait()
{
	if (!this.bxmsg) return;

	var arContainerPos = BX.pos(this),
		div_top = arContainerPos.top;

	if (div_top < BX.GetDocElement().scrollTop)
		div_top = BX.GetDocElement().scrollTop + 5;

	this.bxmsg.style.top = (div_top + 5) + 'px';

	if (this == BX.GetDocElement())
	{
		this.bxmsg.style.right = '5px';
	}
	else
	{
		this.bxmsg.style.left = (arContainerPos.right - this.bxmsg.offsetWidth - 5) + 'px';
	}
}

function _checkDisplay(ob, displayType)
{
	if (typeof displayType != 'undefined')
		ob.BXDISPLAY = displayType;

	var d = ob.style.display || BX.style(ob, 'display');
	if (d != 'none')
	{
		ob.BXDISPLAY = ob.BXDISPLAY || d;
		return true;
	}
	else
	{
		ob.BXDISPLAY = ob.BXDISPLAY || 'block';
		return false;
	}
}

function _processTpl(tplNode, cb, bKillTpl)
{
	if (tplNode)
	{
		if (bKillTpl)
			tplNode.parentNode.removeChild(tplNode);

		var res = {}, nodes = BX.findChildren(tplNode, {attribute: 'data-role'}, true);

		for (var i = 0, l = nodes.length; i < l; i++)
		{
			res[nodes[i].getAttribute('data-role')] = nodes[i];
		}

		cb.apply(tplNode, [res]);
	}
}

function _checkNode(obj, params)
{
	params = params || {};

	if (BX.type.isFunction(params))
		return params.call(window, obj);

	if (!params.allowTextNodes && !BX.type.isElementNode(obj))
		return false;
	var i,j,len;
	for (i in params)
	{
		switch(i)
		{
			case 'tag':
			case 'tagName':
				if (BX.type.isString(params[i]))
				{
					if (obj.tagName.toUpperCase() != params[i].toUpperCase())
						return false;
				}
				else if (params[i] instanceof RegExp)
				{
					if (!params[i].test(obj.tagName))
						return false;
				}
			break;

			case 'class':
			case 'className':
				if (BX.type.isString(params[i]))
				{
					if (!BX.hasClass(obj, params[i]))
						return false;
				}
				else if (params[i] instanceof RegExp)
				{
					if (!BX.type.isString(obj.className) || !params[i].test(obj.className))
						return false;
				}
			break;

			case 'attr':
			case 'attribute':
				if (BX.type.isString(params[i]))
				{
					if (!obj.getAttribute(params[i]))
						return false;
				}
				else if (BX.type.isArray(params[i]))
				{
					for (j = 0, len = params[i].length; j < len; j++)
					{
						if (params[i] && !obj.getAttribute(params[i]))
							return false;
					}
				}
				else
				{
					for (j in params[i])
					{
						var q = obj.getAttribute(j);
						if (params[i][j] instanceof RegExp)
						{
							if (!BX.type.isString(q) || !params[i][j].test(q))
								return false;
						}
						else
						{
							if (q != '' + params[i][j])
								return false;
						}
					}
				}
			break;

			case 'property':
				if (BX.type.isString(params[i]))
				{
					if (!obj[params[i]])
						return false;
				}
				else if (BX.type.isArray(params[i]))
				{
					for (j = 0, len = params[i].length; j < len; j++)
					{
						if (params[i] && !obj[params[i]])
							return false;
					}
				}
				else
				{
					for (j in params[i])
					{
						if (BX.type.isString(params[i][j]))
						{
							if (obj[j] != params[i][j])
								return false;
						}
						else if (params[i][j] instanceof RegExp)
						{
							if (!BX.type.isString(obj[j]) || !params[i][j].test(obj[j]))
								return false;
						}
					}
				}
			break;

			case 'callback':
				return params[i](obj);
			break;
		}
	}

	return true;
}

function _checkCssList()
{
	var linksCol = document.getElementsByTagName('LINK'), links = [];

	if(!!linksCol && linksCol.length > 0)
	{
		for(var i=0;i<linksCol.length;i++)
		{
			links.push(linksCol[i]);
		}
	}

	if(!!window.arKernelCSS && BX.type.isArray(arKernelCSS))
	{
		links = BX.util.array_merge(links, arKernelCSS);
	}

	for (var i = 0; i < links.length; i++)
	{
		var href = BX.type.isDomNode(links[i]) ? links[i].getAttribute('href') : links[i];
		if (!!href && href.replace)
		{
			cssList.push(href
				.replace(/\.css(\?\d*)/, '.css')
				.replace(/^(http[s]*:)*\/\/[^\/]+/i, '')
			);
		}
	}
	_checkCssList = BX.DoNothing;
}

/********* Check for currently loaded core scripts ***********/
function _isScriptLoaded(fileSrc)
{
	return (
		BX.util.in_array(fileSrc, arKernelJS)
		||fileSrc.indexOf('/core/core.js') > 0
		||fileSrc.indexOf('/core_access.js') >= 0 && !!BX.Access
		||fileSrc.indexOf('/core_admin.js') >= 0 && !!BX.admin
		||fileSrc.indexOf('/core_admin_interface.js') >= 0 && !!BX.adminPanel
		||fileSrc.indexOf('/core_admin_login.js') >= 0 && !!BX.adminLogin
		||fileSrc.indexOf('/core_ajax.js') >= 0 && !!BX.ajax
		||fileSrc.indexOf('/core_autosave.js') >= 0 && !!BX.CAutoSave
		||fileSrc.indexOf('/core_date.js') >= 0 && !!BX.date
		||fileSrc.indexOf('/core_finder.js') >= 0 && !!BX.Finder
		||fileSrc.indexOf('/core_fx.js') >= 0 && !!BX.easing
		||fileSrc.indexOf('/core_image.js') >= 0 && !!BX.CImageView
		||fileSrc.indexOf('/core_ls.js') >= 0 && !!BX.localStorage
		||fileSrc.indexOf('/core_popup.js') >= 0 && !!BX.PopupWindowManager
		||fileSrc.indexOf('/core_tags.js') >= 0 && !!BX.TagsWindowArea
		||fileSrc.indexOf('/core_timer.js') >= 0 && !!BX.timer
		||fileSrc.indexOf('/core_tooltip.js') >= 0 && !!BX.tooltip
		||fileSrc.indexOf('/core_translit.js') >= 0 && !!BX.translit
		||fileSrc.indexOf('/core_window.js') >= 0 && !!BX.WindowManager
		||fileSrc.indexOf('/jquery-') >= 0 && !!window.jQuery
	);
}

/* garbage collector */
function Trash()
{
	var i,len;

	for (i = 0, len = garbageCollectors.length; i<len; i++)
	{
		try {
			garbageCollectors[i].callback.apply(garbageCollectors[i].context || window);
			delete garbageCollectors[i];
			garbageCollectors[i] = null;
		} catch (e) {}
	}

	try {BX.unbindAll();} catch(e) {}
/*
	for (i = 0, len = proxyList.length; i < len; i++)
	{
		try {
			delete proxyList[i];
			proxyList[i] = null;
		} catch (e) {}
	}
*/
}

if(window.attachEvent) // IE
	window.attachEvent("onunload", Trash);
else if(window.addEventListener) // Gecko / W3C
	window.addEventListener('unload', Trash, false);
else
	window.onunload = Trash;
/* \garbage collector */

// set empty ready handler
BX(BX.DoNothing);
window.BX = BX;
BX.browser.addGlobalClass();
BX.browser.addGlobalFeatures(["boxShadow", "borderRadius", "flexWrap", "boxDirection", "transition", "transform"])
})(window);

/* End */
;
; /* Start:/bitrix/js/main/core/core_ajax.js*/
;(function(window){

if (window.BX.ajax)
	return;

var
	BX = window.BX,

	tempDefaultConfig = {},
	defaultConfig = {
		method: 'GET', // request method: GET|POST
		dataType: 'html', // type of data loading: html|json|script
		timeout: 0, // request timeout in seconds. 0 for browser-default
		async: true, // whether request is asynchronous or not
		processData: true, // any data processing is disabled if false, only callback call
		scriptsRunFirst: false, // whether to run _all_ found scripts before onsuccess call. script tag can have an attribute "bxrunfirst" to turn  this flag on only for itself
		emulateOnload: true,
		start: true, // send request immediately (if false, request can be started manually via XMLHttpRequest object returned)
		cache: true, // whether NOT to add random addition to URL
		preparePost: true, // whether set Content-Type x-www-form-urlencoded in POST
		headers: false, // add additional headers, example: [{'name': 'If-Modified-Since', 'value': 'Wed, 15 Aug 2012 08:59:08 GMT'}, {'name': 'If-None-Match', 'value': '0'}]
		lsTimeout: 30, //local storage data TTL. useless without lsId.
		lsForce: false //wheter to force query instead of using localStorage data. useless without lsId.
/*
other parameters:
	url: url to get/post
	data: data to post
	onsuccess: successful request callback. BX.proxy may be used.
	onfailure: request failure callback. BX.proxy may be used.

	lsId: local storage id - for constantly updating queries which can communicate via localStorage. core_ls.js needed

any of the default parameters can be overridden. defaults can be changed by BX.ajax.Setup() - for all further requests!
*/
	},
	ajax_session = null,
	loadedScripts = {},
	loadedScriptsQueue = [],
	r = {
		'url_utf': /[^\034-\254]+/g,
		'script_self': /\/bitrix\/js\/main\/core\/core(_ajax)*.js$/i,
		'script_self_window': /\/bitrix\/js\/main\/core\/core_window.js$/i,
		'script_self_admin': /\/bitrix\/js\/main\/core\/core_admin.js$/i,
		'script_onload': /window.onload/g
	};

// low-level method
BX.ajax = function(config)
{
	var status, data;

	if (!config || !config.url || !BX.type.isString(config.url))
	{
		return false;
	}

	for (var i in tempDefaultConfig)
		if (typeof (config[i]) == "undefined") config[i] = tempDefaultConfig[i];

	tempDefaultConfig = {};

	for (var i in defaultConfig)
		if (typeof (config[i]) == "undefined") config[i] = defaultConfig[i];

	config.method = config.method.toUpperCase();

	if (!BX.localStorage)
		config.lsId = null;

	if (BX.browser.IsIE())
	{
		var result = r.url_utf.exec(config.url);
		if (result)
		{
			do
			{
				config.url = config.url.replace(result, BX.util.urlencode(result));
				result = r.url_utf.exec(config.url);
			} while (result);
		}
	}

	if(config.dataType == 'json')
		config.emulateOnload = false;

	if (!config.cache && config.method == 'GET')
		config.url = BX.ajax._uncache(config.url);

	if (config.method == 'POST' && config.preparePost)
	{
		config.data = BX.ajax.prepareData(config.data);
	}

	var bXHR = true;
	if (config.lsId && !config.lsForce)
	{
		var v = BX.localStorage.get('ajax-' + config.lsId);
		if (v !== null)
		{
			bXHR = false;

			var lsHandler = function(lsData) {
				if (lsData.key == 'ajax-' + config.lsId && lsData.value != 'BXAJAXWAIT')
				{
					var data = lsData.value,
						bRemove = !!lsData.oldValue && data == null;
					if (!bRemove)
						BX.ajax.__run(config, data);
					else if (config.onfailure)
						config.onfailure("timeout");

					BX.removeCustomEvent('onLocalStorageChange', lsHandler);
				}
			}

			if (v == 'BXAJAXWAIT')
			{
				BX.addCustomEvent('onLocalStorageChange', lsHandler);
			}
			else
			{
				setTimeout(function() {lsHandler({key: 'ajax-' + config.lsId, value: v})}, 10);
			}
		}
	}

	if (bXHR)
	{
		config.xhr = BX.ajax.xhr();
		if (!config.xhr) return;

		if (config.lsId)
		{
			BX.localStorage.set('ajax-' + config.lsId, 'BXAJAXWAIT', config.lsTimeout);
		}

		config.xhr.open(config.method, config.url, config.async);
		if (config.method == 'POST' && config.preparePost)
		{
			config.xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		}
		if (typeof(config.headers) == "object")
		{
			for (var i = 0; i < config.headers.length; i++)
				config.xhr.setRequestHeader(config.headers[i].name, config.headers[i].value);
		}

		var bRequestCompleted = false;
		var onreadystatechange = config.xhr.onreadystatechange = function(additional)
		{
			if (bRequestCompleted)
				return;

			if (additional === 'timeout')
			{
				if (config.onfailure)
					config.onfailure("timeout");

				BX.onCustomEvent(config.xhr, 'onAjaxFailure', ['timeout', '', config]);

				config.xhr.onreadystatechange = BX.DoNothing;
				config.xhr.abort();

				if (config.async)
				{
					config.xhr = null;
				}
			}
			else
			{
				if (config.xhr.readyState == 4 || additional == 'run')
				{
					status = BX.ajax.xhrSuccess(config.xhr) ? "success" : "error";
					bRequestCompleted = true;
					config.xhr.onreadystatechange = BX.DoNothing;

					// var status = oAjax.arThreads[TID].httpRequest.getResponseHeader('X-Bitrix-Ajax-Status');
					// var bRedirect = (status == 'Redirect');

					if (status == 'success')
					{
						var data = config.xhr.responseText;

						if (config.lsId)
						{
							BX.localStorage.set('ajax-' + config.lsId, data, config.lsTimeout);
						}

						BX.ajax.__run(config, data);
					}
					else if (config.onfailure)
					{
						config.onfailure("status", config.xhr.status);
						BX.onCustomEvent(config.xhr, 'onAjaxFailure', ['status', config.xhr.status, config]);
					}

					if (config.async)
					{
						config.xhr = null;
					}
				}
			}
		}

		if (config.async && config.timeout > 0)
		{
			setTimeout(function() {
				if (config.xhr && !bRequestCompleted)
				{
					onreadystatechange("timeout");
				}
			}, config.timeout * 1000);
		}

		if (config.start)
		{
			config.xhr.send(config.data);

			if (!config.async)
			{
				onreadystatechange('run');
			}
		}

		return config.xhr;
	}
}

BX.ajax.xhr = function()
{
	if (window.XMLHttpRequest)
	{
		try {return new XMLHttpRequest();} catch(e){}
	}
	else if (window.ActiveXObject)
	{
		try { return new ActiveXObject("Msxml2.XMLHTTP.6.0"); }
			catch(e) {}
		try { return new ActiveXObject("Msxml2.XMLHTTP.3.0"); }
			catch(e) {}
		try { return new ActiveXObject("Msxml2.XMLHTTP"); }
			catch(e) {}
		try { return new ActiveXObject("Microsoft.XMLHTTP"); }
			catch(e) {}
		throw new Error("This browser does not support XMLHttpRequest.");
	}

	return null;
}

BX.ajax.__prepareOnload = function(scripts)
{
	if (scripts.length > 0)
	{
		BX.ajax['onload_' + ajax_session] = null;

		for (var i=0,len=scripts.length;i<len;i++)
		{
			if (scripts[i].isInternal)
			{
				scripts[i].JS = scripts[i].JS.replace(r.script_onload, 'BX.ajax.onload_' + ajax_session);
			}
		}
	}

	BX.CaptureEventsGet();
	BX.CaptureEvents(window, 'load');
}

BX.ajax.__runOnload = function()
{
	if (null != BX.ajax['onload_' + ajax_session])
	{
		BX.ajax['onload_' + ajax_session].apply(window);
		BX.ajax['onload_' + ajax_session] = null;
	}

	var h = BX.CaptureEventsGet();

	if (h)
	{
		for (var i=0; i<h.length; i++)
			h[i].apply(window);
	}
}

BX.ajax.__run = function(config, data)
{
	if (!config.processData)
	{
		if (config.onsuccess)
		{
			config.onsuccess(data);
		}

		BX.onCustomEvent(config.xhr, 'onAjaxSuccess', [data, config]);
	}
	else
	{
		data = BX.ajax.processRequestData(data, config);
	}
}


BX.ajax._onParseJSONFailure = function(data)
{
	this.jsonFailure = true;
	this.jsonResponse = data;
	this.jsonProactive = /^\[WAF\]/.test(data);
}

BX.ajax.processRequestData = function(data, config)
{
	var result, scripts = [], styles = [];
	switch (config.dataType.toUpperCase())
	{
		case 'JSON':
			BX.addCustomEvent(config.xhr, 'onParseJSONFailure', BX.proxy(BX.ajax._onParseJSONFailure, config));
			result = BX.parseJSON(data, config.xhr);
			BX.removeCustomEvent(config.xhr, 'onParseJSONFailure', BX.proxy(BX.ajax._onParseJSONFailure, config));

		break;
		case 'SCRIPT':
			scripts.push({"isInternal": true, "JS": data, bRunFirst: config.scriptsRunFirst});
			config.processScriptsConsecutive = true;
			result = data;
		break;

		default: // HTML
			var ob = BX.processHTML(data, config.scriptsRunFirst);
			result = ob.HTML; scripts = ob.SCRIPT; styles = ob.STYLE
		break;
	}

	var bSessionCreated = false;
	if (null == ajax_session)
	{
		ajax_session = parseInt(Math.random() * 1000000);
		bSessionCreated = true;
	}

	if (styles.length > 0)
		BX.loadCSS(styles);

	if (config.emulateOnload)
			BX.ajax.__prepareOnload(scripts);

	var cb = BX.DoNothing;
	if(config.emulateOnload || bSessionCreated)
	{
		cb = BX.defer(function()
		{
			if (config.emulateOnload)
				BX.ajax.__runOnload();
			if (bSessionCreated)
				ajax_session = null;
			BX.onCustomEvent(config.xhr, 'onAjaxSuccessFinish', [config]);
		});
	}

	try
	{
		if (!!config.jsonFailure)
		{
			throw {type: 'json_failure', data: config.jsonResponse, bProactive: config.jsonProactive};
		}

		config.scripts = scripts;

		BX.ajax.processScripts(config.scripts, true);


		if (config.onsuccess)
		{
			config.onsuccess(result);
		}

		BX.onCustomEvent(config.xhr, 'onAjaxSuccess', [result, config]);

		if(!config.processScriptsConsecutive)
		{
			BX.ajax.processScripts(config.scripts, false, cb);
		}
		else
		{
			BX.ajax.processScriptsConsecutive(config.scripts, false);
			cb();
		}
	}
	catch (e)
	{
		if (config.onfailure)
			config.onfailure("processing", e);
		BX.onCustomEvent(config.xhr, 'onAjaxFailure', ['processing', e, config]);
	}
}

BX.ajax.processScripts = function(scripts, bRunFirst, cb)
{
	var scriptsExt = [], scriptsInt = '';

	cb=cb||BX.DoNothing;

	for (var i = 0, length = scripts.length; i < length; i++)
	{
		if (typeof bRunFirst != 'undefined' && bRunFirst != !!scripts[i].bRunFirst)
			continue;

		if (scripts[i].isInternal)
			scriptsInt += ';' + scripts[i].JS
		else
			scriptsExt.push(scripts[i].JS);
	}

	scriptsExt = BX.util.array_unique(scriptsExt);

	var l=l1=scriptsExt.length,
		f=scriptsInt.length>0?function(){BX.evalGlobal(scriptsInt)}:BX.DoNothing;

	if(l>0)
	{
		var c=function(){if(--l1<=0){f();cb();f=BX.DoNothing;}};
		for(var i=0; i<l;i++)
		{
			BX.loadScript(scriptsExt[i], c);
		}
	}
	else
	{
		//f();BX.defer(cb)();
		f();cb();
	}
}

BX.ajax.processScriptsConsecutive = function(scripts, bRunFirst)
{
	for (var i = 0, length = scripts.length; i < length; i++)
	{
		if (null != bRunFirst && bRunFirst != !!scripts[i].bRunFirst)
			continue;

		if (scripts[i].isInternal)
		{
			BX.evalGlobal(scripts[i].JS);
		}
		else
		{
			BX.ajax.loadScriptAjax([scripts[i].JS]);
		}
	}
}

// TODO: extend this function to use with any data objects or forms
BX.ajax.prepareData = function(arData, prefix)
{
	var data = '';
	if (BX.type.isString(arData))
		data = arData;
	else if (null != arData)
	{
		for(var i in arData)
		{
			if (!arData.hasOwnProperty(i))
				continue;
			if (data.length > 0) data += '&';
			var name = BX.util.urlencode(i);
			if(prefix)
				name = prefix + '[' + name + ']';
			if(typeof arData[i] == 'object')
				data += BX.ajax.prepareData(arData[i], name)
			else
				data += name + '=' + BX.util.urlencode(arData[i])
		}
	}
	return data;
}

BX.ajax.xhrSuccess = function(xhr)
{
	return (xhr.status >= 200 && xhr.status < 300) || xhr.status === 304 || xhr.status === 1223 || xhr.status === 0;
}

BX.ajax.Setup = function(config, bTemp)
{
	bTemp = !!bTemp;

	for (var i in config)
	{
		if (bTemp)
			tempDefaultConfig[i] = config[i];
		else
			defaultConfig[i] = config[i];
	}
}

BX.ajax.replaceLocalStorageValue = function(lsId, data, ttl)
{
	if (!!BX.localStorage)
		BX.localStorage.set('ajax-' + lsId, data, ttl);
}


BX.ajax._uncache = function(url)
{
	return url + ((url.indexOf('?') !== -1 ? "&" : "?") + '_=' + (new Date).getTime());
}

/* simple interface */
BX.ajax.get = function(url, data, callback)
{
	if (BX.type.isFunction(data))
	{
		callback = data;
		data = '';
	}

	data = BX.ajax.prepareData(data);

	if (data)
	{
		url += (url.indexOf('?') !== -1 ? "&" : "?") + data;
		data = '';
	}

	return BX.ajax({
		'method': 'GET',
		'dataType': 'html',
		'url': url,
		'data':  '',
		'onsuccess': callback
	});
}

BX.ajax.getCaptcha = function(callback)
{
	return BX.ajax.loadJSON('/bitrix/tools/ajax_captcha.php', callback);
}

BX.ajax.insertToNode = function(url, node)
{
	if (node = BX(node))
	{
		BX.onCustomEvent('onAjaxInsertToNode', [{url: url, node: node}]);

		var show = null;
		if (!tempDefaultConfig.denyShowWait)
		{
			show = BX.showWait(node);
			delete tempDefaultConfig.denyShowWait;
		}

		return BX.ajax.get(url, function(data) {
			node.innerHTML = data;
			BX.closeWait(node, show);
		});
	}
}

BX.ajax.post = function(url, data, callback)
{
	data = BX.ajax.prepareData(data);

	return BX.ajax({
		'method': 'POST',
		'dataType': 'html',
		'url': url,
		'data':  data,
		'onsuccess': callback
	});
}

/* load and execute external file script with onload emulation */
BX.ajax.loadScriptAjax = function(script_src, callback, bPreload)
{
	if (BX.type.isArray(script_src))
	{
		for (var i=0,len=script_src.length;i<len;i++)
		{
			BX.ajax.loadScriptAjax(script_src[i], callback, bPreload);
		}
	}
	else
	{
		var script_src_test = script_src.replace(/\.js\?.*/, '.js');

		if (r.script_self.test(script_src_test)) return;
		if (r.script_self_window.test(script_src_test) && BX.CWindow) return;
		if (r.script_self_admin.test(script_src_test) && BX.admin) return;

		if (typeof loadedScripts[script_src_test] == 'undefined')
		{
			if (!!bPreload)
			{
				loadedScripts[script_src_test] = '';
				return BX.loadScript(script_src);
			}
			else
			{
				return BX.ajax({
					url: script_src,
					method: 'GET',
					dataType: 'script',
					processData: true,
					emulateOnload: false,
					scriptsRunFirst: true,
					async: false,
					start: true,
					onsuccess: function(result) {
						loadedScripts[script_src_test] = result;
						if (callback)
							callback(result);
					}
				});
			}
		}
		else if (callback)
		{
			callback(loadedScripts[script_src_test]);
		}
	}
}

/* non-xhr loadings */
BX.ajax.loadJSON = function(url, data, callback, callback_failure)
{
	if (BX.type.isFunction(data))
	{
		callback_failure = callback;
		callback = data;
		data = '';
	}

	data = BX.ajax.prepareData(data);

	if (data)
	{
		url += (url.indexOf('?') !== -1 ? "&" : "?") + data;
		data = '';
	}

	return BX.ajax({
		'method': 'GET',
		'dataType': 'json',
		'url': url,
		'onsuccess': callback,
		'onfailure': callback_failure
	});
}

/*
arObs = [{
	url: url,
	type: html|script|json|css,
	callback: function
}]
*/
BX.ajax.load = function(arObs, callback)
{
	if (!BX.type.isArray(arObs))
		arObs = [arObs];

	var cnt = 0;

	if (!BX.type.isFunction(callback))
		callback = BX.DoNothing;

	var handler = function(data)
		{
			if (BX.type.isFunction(this.callback))
				this.callback(data);

			if (++cnt >= len)
				callback();
		};

	for (var i = 0, len = arObs.length; i<len; i++)
	{
		switch(arObs.type.toUpperCase())
		{
			case 'SCRIPT':
				BX.loadScript([arObs[i].url], jsBX.proxy(handler, arObs[i]));
			break;
			case 'CSS':
				BX.loadCSS([arObs[i].url]);

				if (++cnt >= len)
					callback();
			break;
			case 'JSON':
				BX.ajax.loadJSON(arObs.url, jsBX.proxy(handler, arObs[i]));
			break;

			default:
				BX.ajax.get(arObs.url, '', jsBX.proxy(handler, arObs[i]));
			break;
		}
	}
}

/* ajax form sending */
BX.ajax.submit = function(obForm, callback)
{
	if (!obForm.target)
	{
		if (null == obForm.BXFormTarget)
		{
			var frame_name = 'formTarget_' + Math.random();
			obForm.BXFormTarget = document.body.appendChild(BX.create('IFRAME', {
				props: {
					name: frame_name,
					id: frame_name,
					src: 'javascript:void(0)'
				},
				style: {
					display: 'none'
				}
			}));
		}

		obForm.target = obForm.BXFormTarget.name;
	}

	obForm.BXFormCallback = callback;
	BX.bind(obForm.BXFormTarget, 'load', BX.proxy(BX.ajax._submit_callback, obForm));

	BX.submit(obForm);

	return false;
}

BX.ajax.submitComponentForm = function(obForm, container, bWait)
{
	if (!obForm.target)
	{
		if (null == obForm.BXFormTarget)
		{
			var frame_name = 'formTarget_' + Math.random();
			obForm.BXFormTarget = document.body.appendChild(BX.create('IFRAME', {
				props: {
					name: frame_name,
					id: frame_name,
					src: 'javascript:void(0)'
				},
				style: {
					display: 'none'
				}
			}));
		}

		obForm.target = obForm.BXFormTarget.name;
	}

	if (!!bWait)
		var w = BX.showWait(container);

	obForm.BXFormCallback = function(d) {
		if (!!bWait)
			BX.closeWait(w);

		BX(container).innerHTML = d;
		if (window.bxcompajaxframeonload){
			setTimeout("window.bxcompajaxframeonload();window.bxcompajaxframeonload=null;", 10)
		};
		BX.onCustomEvent('onAjaxSuccess', []);
	};

	BX.bind(obForm.BXFormTarget, 'load', BX.proxy(BX.ajax._submit_callback, obForm));

	return true;
}

// func will be executed in form context
BX.ajax._submit_callback = function()
{
	//opera and IE8 triggers onload event even on empty iframe
	try
	{
		if(this.BXFormTarget.contentWindow.location.href.indexOf('http') != 0)
			return;
	} catch (e) {
		return;
	}

	if (this.BXFormCallback)
		this.BXFormCallback.apply(this, [this.BXFormTarget.contentWindow.document.body.innerHTML]);

	BX.unbindAll(this.BXFormTarget);
}

// TODO: currently in window extension. move it here.
BX.ajax.submitAjax = function(obForm, callback)
{

}

BX.ajax.UpdatePageData = function (arData)
{
	if (arData.TITLE)
		BX.ajax.UpdatePageTitle(arData.TITLE);
	if (arData.NAV_CHAIN)
		BX.ajax.UpdatePageNavChain(arData.NAV_CHAIN);
	if (arData.CSS && arData.CSS.length > 0)
		BX.loadCSS(arData.CSS);
	if (arData.SCRIPTS && arData.SCRIPTS.length > 0)
	{
		var f=function(result,config){
			if(!!config && BX.type.isArray(config.scripts))
			{
				for(var i=0,l=arData.SCRIPTS.length;i<l;i++)
				{
					config.scripts.push({isInternal:false,JS:arData.SCRIPTS[i]});
				}
			}
			else
			{
				BX.loadScript(arData.SCRIPTS);
			}

			BX.removeCustomEvent('onAjaxSuccess',f);
		}
		BX.addCustomEvent('onAjaxSuccess',f);
	}
}

BX.ajax.UpdatePageTitle = function(title)
{
	var obTitle = BX('pagetitle');
	if (obTitle)
	{
		obTitle.removeChild(obTitle.firstChild);
		if (!obTitle.firstChild)
			obTitle.appendChild(document.createTextNode(title));
		else
			obTitle.insertBefore(document.createTextNode(title), obTitle.firstChild);
	}

	document.title = title;
}

BX.ajax.UpdatePageNavChain = function(nav_chain)
{
	var obNavChain = BX('navigation');
	if (obNavChain)
	{
		obNavChain.innerHTML = nav_chain;
	}
}

/* user options handling */
BX.userOptions = {
	options: null,
	bSend: false,
	delay: 5000
}

BX.userOptions.save = function(sCategory, sName, sValName, sVal, bCommon)
{
	if (null == BX.userOptions.options)
		BX.userOptions.options = {};

	bCommon = !!bCommon;
	BX.userOptions.options[sCategory+'.'+sName+'.'+sValName] = [sCategory, sName, sValName, sVal, bCommon];

	var sParam = BX.userOptions.__get();
	if (sParam != '')
		document.cookie = BX.message('COOKIE_PREFIX')+"_LAST_SETTINGS=" + sParam + "&sessid="+BX.bitrix_sessid()+"; expires=Thu, 31 Dec 2020 23:59:59 GMT; path=/;";

	if(!BX.userOptions.bSend)
	{
		BX.userOptions.bSend = true;
		setTimeout(function(){BX.userOptions.send(null)}, BX.userOptions.delay);
	}
}

BX.userOptions.send = function(callback)
{
	var sParam = BX.userOptions.__get();
	BX.userOptions.options = null;
	BX.userOptions.bSend = false;

	if (sParam != '')
	{
		document.cookie = BX.message('COOKIE_PREFIX') + "_LAST_SETTINGS=; path=/;";
		BX.ajax({
			'method': 'GET',
			'dataType': 'html',
			'processData': false,
			'cache': false,
			'url': '/bitrix/admin/user_options.php?'+sParam+'&sessid='+BX.bitrix_sessid(),
			'onsuccess': callback
		});
	}
}

BX.userOptions.del = function(sCategory, sName, bCommon, callback)
{
	BX.ajax.get('/bitrix/admin/user_options.php?action=delete&c='+sCategory+'&n='+sName+(bCommon == true? '&common=Y':'')+'&sessid='+BX.bitrix_sessid(), callback);
}

BX.userOptions.__get = function()
{
	if (!BX.userOptions.options) return '';

	var sParam = '', n = -1, prevParam = '', aOpt, i;

	for (i in BX.userOptions.options)
	{
		aOpt = BX.userOptions.options[i];

		if (prevParam != aOpt[0]+'.'+aOpt[1])
		{
			n++;
			sParam += '&p['+n+'][c]='+BX.util.urlencode(aOpt[0]);
			sParam += '&p['+n+'][n]='+BX.util.urlencode(aOpt[1]);
			if (aOpt[4] == true)
				sParam += '&p['+n+'][d]=Y';
			prevParam = aOpt[0]+'.'+aOpt[1];
		}

		sParam += '&p['+n+'][v]['+BX.util.urlencode(aOpt[2])+']='+BX.util.urlencode(aOpt[3]);
	}

	return sParam.substr(1);
}

BX.ajax.history = {
	expected_hash: '',

	obParams: null,

	obFrame: null,
	obImage: null,

	obTimer: null,

	bInited: false,
	bHashCollision: false,
	bPushState: !!(history.pushState && BX.type.isFunction(history.pushState)),

	startState: null,

	init: function(obParams)
	{
		if (BX.ajax.history.bInited)
			return;

		this.obParams = obParams;
		var obCurrentState = this.obParams.getState();

		if (BX.ajax.history.bPushState)
		{
			BX.ajax.history.expected_hash = window.location.pathname;
			if (window.location.search)
				BX.ajax.history.expected_hash += window.location.search;

			BX.ajax.history.put(obCurrentState, BX.ajax.history.expected_hash, '', true);
			// due to some strange thing, chrome calls popstate event on page start. so we should delay it
			setTimeout("BX.bind(window, 'popstate', BX.ajax.history.__hashListener);", 500);
		}
		else
		{
			BX.ajax.history.expected_hash = window.location.hash;

			if (!BX.ajax.history.expected_hash || BX.ajax.history.expected_hash == '#')
				BX.ajax.history.expected_hash = '__bx_no_hash__';

			jsAjaxHistoryContainer.put(BX.ajax.history.expected_hash, obCurrentState);
			BX.ajax.history.obTimer = setTimeout(BX.ajax.history.__hashListener, 500);

			if (BX.browser.IsIE())
			{
				BX.ajax.history.obFrame = document.createElement('IFRAME');
				BX.hide_object(BX.ajax.history.obFrame);

				document.body.appendChild(BX.ajax.history.obFrame);

				BX.ajax.history.obFrame.contentWindow.document.open();
				BX.ajax.history.obFrame.contentWindow.document.write(BX.ajax.history.expected_hash);
				BX.ajax.history.obFrame.contentWindow.document.close();
			}
			else if (BX.browser.IsOpera())
			{
				BX.ajax.history.obImage = document.createElement('IMG');
				BX.hide_object(BX.ajax.history.obImage);

				document.body.appendChild(BX.ajax.history.obImage);

				BX.ajax.history.obImage.setAttribute('src', 'javascript:location.href = \'javascript:BX.ajax.history.__hashListener();\';');
			}
		}

		BX.ajax.history.bInited = true;
	},

	__hashListener: function(e)
	{
		e = e || window.event || {state:false};

		if (BX.ajax.history.bPushState)
		{
			BX.ajax.history.obParams.setState(e.state||BX.ajax.history.startState);
		}
		else
		{
			if (BX.ajax.history.obTimer)
			{
				window.clearTimeout(BX.ajax.history.obTimer);
				BX.ajax.history.obTimer = null;
			}

			if (null != BX.ajax.history.obFrame)
				var current_hash = BX.ajax.history.obFrame.contentWindow.document.body.innerText;
			else
				var current_hash = window.location.hash;

			if (!current_hash || current_hash == '#')
				current_hash = '__bx_no_hash__';

			if (current_hash.indexOf('#') == 0)
				current_hash = current_hash.substring(1);

			if (current_hash != BX.ajax.history.expected_hash)
			{
				var state = jsAjaxHistoryContainer.get(current_hash);
				if (state)
				{
					BX.ajax.history.obParams.setState(state);

					BX.ajax.history.expected_hash = current_hash;
					if (null != BX.ajax.history.obFrame)
					{
						var __hash = current_hash == '__bx_no_hash__' ? '' : current_hash;
						if (window.location.hash != __hash && window.location.hash != '#' + __hash)
							window.location.hash = __hash;
					}
				}
			}

			BX.ajax.history.obTimer = setTimeout(BX.ajax.history.__hashListener, 500);
		}
	},

	put: function(state, new_hash, new_hash1, bStartState)
	{
		if (this.bPushState)
		{
			if(!bStartState)
			{
				history.pushState(state, '', new_hash);
			}
			else
			{
				BX.ajax.history.startState = state;
			}
		}
		else
		{
			if (typeof new_hash1 != 'undefined')
				new_hash = new_hash1;
			else
				new_hash = 'view' + new_hash;

			jsAjaxHistoryContainer.put(new_hash, state);
			BX.ajax.history.expected_hash = new_hash;

			window.location.hash = BX.util.urlencode(new_hash);

			if (null != BX.ajax.history.obFrame)
			{
				BX.ajax.history.obFrame.contentWindow.document.open();
				BX.ajax.history.obFrame.contentWindow.document.write(new_hash);
				BX.ajax.history.obFrame.contentWindow.document.close();
			}
		}
	},

	checkRedirectStart: function(param_name, param_value)
	{
		var current_hash = window.location.hash;
		if (current_hash.substring(0, 1) == '#') current_hash = current_hash.substring(1);

		var test = current_hash.substring(0, 5);
		if (test == 'view/' || test == 'view%')
		{
			BX.ajax.history.bHashCollision = true;
			document.write('<' + 'div id="__ajax_hash_collision_' + param_value + '" style="display: none;">');
		}
	},

	checkRedirectFinish: function(param_name, param_value)
	{
		document.write('</div>');

		var current_hash = window.location.hash;
		if (current_hash.substring(0, 1) == '#') current_hash = current_hash.substring(1);

		BX.ready(function ()
		{
			var test = current_hash.substring(0, 5);
			if (test == 'view/' || test == 'view%')
			{
				var obColNode = BX('__ajax_hash_collision_' + param_value);
				var obNode = obColNode.firstChild;
				BX.cleanNode(obNode);
				obColNode.style.display = 'block';

				// IE, Opera and Chrome automatically modifies hash with urlencode, but FF doesn't ;-(
				if (test != 'view%')
					current_hash = BX.util.urlencode(current_hash);

				current_hash += (current_hash.indexOf('%3F') == -1 ? '%3F' : '%26') + param_name + '=' + param_value;

				var url = '/bitrix/tools/ajax_redirector.php?hash=' + current_hash;

				BX.ajax.insertToNode(url, obNode);
			}
		});
	}
}

BX.ajax.component = function(node)
{
	this.node = node;
}

BX.ajax.component.prototype.getState = function()
{
	var state = {
		'node': this.node,
		'title': window.document.title,
		'data': BX(this.node).innerHTML
	};

	var obNavChain = BX('navigation');
	if (null != obNavChain)
		state.nav_chain = obNavChain.innerHTML;

	return state;
}

BX.ajax.component.prototype.setState = function(state)
{
	BX(state.node).innerHTML = state.data;
	BX.ajax.UpdatePageTitle(state.title);

	if (state.nav_chain)
		BX.ajax.UpdatePageNavChain(state.nav_chain);
}

var jsAjaxHistoryContainer = {
	arHistory: {},

	put: function(hash, state)
	{
		this.arHistory[hash] = state;
	},

	get: function(hash)
	{
		return this.arHistory[hash];
	}
}


BX.ajax.FormData = function()
{
	this.elements = [];
	this.files = [];
	this.features = {};
	this.isSupported();
	this.log('BX FormData init');
}

BX.ajax.FormData.isSupported = function()
{
	var f = new BX.ajax.FormData()
	var result = f.features.supported;
	f = null;
	return result;
}

BX.ajax.FormData.prototype.log = function(o)
{
	if (false) {
		try {
			if (BX.browser.IsIE()) o = JSON.stringify(o);
			console.log(o);
		} catch(e) {}
	}
}

BX.ajax.FormData.prototype.isSupported = function()
{
	var f = {};
	f.fileReader = (window.FileReader && window.FileReader.prototype.readAsBinaryString);
	f.readFormData = f.sendFormData = !!(window.FormData);
	f.supported = !!(f.readFormData && f.sendFormData);
	this.features = f;
	this.log('features:');
	this.log(f);

	return f.supported;
}

BX.ajax.FormData.prototype.append = function(name, value)
{
	if (typeof(value) === 'object') { // seems to be files element
		this.files.push({'name': name, 'value':value});
	} else {
		this.elements.push({'name': name, 'value':value});
	}
}

BX.ajax.FormData.prototype.send = function(url, callbackOk, callbackProgress, callbackError)
{
	this.log('FD send');
	this.xhr = BX.ajax({
			'method': 'POST',
			'dataType': 'html',
			'url': url,
			'onsuccess': callbackOk,
			'onfailure': callbackError,
			'start': false,
			'preparePost':false
		});

	if (callbackProgress)
	{
		this.xhr.upload.addEventListener(
			'progress',
			function(e) {
				if (e.lengthComputable)
					callbackProgress(e.loaded / e.totalSize);
			},
			false
		);
	}

	if (this.features.readFormData && this.features.sendFormData)
	{
		var fd = new FormData();
		this.log('use browser formdata');
		for (i in this.elements)
			fd.append(this.elements[i].name,this.elements[i].value);
		for (i in this.files)
			fd.append(this.files[i].name, this.files[i].value);
		this.xhr.send(fd);
	}

	return this.xhr;
}

BX.addCustomEvent('onAjaxFailure', BX.debug);
})(window)

/* End */
;
; /* Start:/bitrix/js/main/session.js*/
function CBXSession()
{
	var _this = this;
	this.mess = {};
	this.timeout = null;
	this.sessid = null;
	this.bShowMess = true;
	this.dateStart = new Date();
	this.dateInput = new Date();
	this.dateCheck = new Date();
	this.activityInterval = 0;
	this.notifier = null;
	
	this.Expand = function(timeout, sessid, bShowMess, key)
	{
		this.timeout = timeout;
		this.sessid = sessid;
		this.bShowMess = bShowMess;
		this.key = key;
		
		BX.ready(function(){
			BX.bind(document, "keypress", _this.OnUserInput);
			BX.bind(document.body, "mousemove", _this.OnUserInput);
			BX.bind(document.body, "click", _this.OnUserInput);
			
			setTimeout(_this.CheckSession, (_this.timeout-60)*1000);
		})
	},
		
	this.OnUserInput = function()
	{
		var curr = new Date();
		_this.dateInput.setTime(curr.valueOf());
	}
	
	this.CheckSession = function()
	{
		var curr = new Date();
		if(curr.valueOf() - _this.dateCheck.valueOf() < 30000)
			return;

		_this.activityInterval = Math.round((_this.dateInput.valueOf() - _this.dateStart.valueOf())/1000);
		_this.dateStart.setTime(_this.dateInput.valueOf());
		var interval = (_this.activityInterval > _this.timeout? (_this.timeout-60) : _this.activityInterval);
		BX.ajax.get('/bitrix/tools/public_session.php?sessid='+_this.sessid+'&interval='+interval+'&k='+_this.key, function(data){_this.CheckResult(data)});
	}
	
	this.CheckResult = function(data)
	{
		if(data == 'SESSION_EXPIRED')
		{
			if(_this.bShowMess)
			{
				_this.notifier = document.body.appendChild(BX.create('DIV', {
					props: {className: 'bx-session-message'},
					style: {top: '-1000px'},
					html: '<a class="bx-session-message-close" href="javascript:bxSession.Close()"></a>'+_this.mess.messSessExpired
				}));
	
				var windowScroll = BX.GetWindowScrollPos();
				var windowSize = BX.GetWindowInnerSize();

				_this.notifier.style.left = parseInt(windowScroll.scrollLeft + windowSize.innerWidth / 2 - parseInt(_this.notifier.clientWidth) / 2) + 'px';

				var fxStart = windowScroll.scrollTop - _this.notifier.offsetHeight;
				var fxFinish = windowScroll.scrollTop;
	
				(new BX.fx({
					time: 0.5,
					step: 0.01,
					type: 'accelerated',
					start: fxStart,
					finish: fxFinish,
					callback: function(top){_this.notifier.style.top = top + 'px';},
					callback_complete: function()
					{
						if(BX.browser.IsIE())
						{
							BX.bind(window, 'scroll', function()
							{
								var windowScroll = BX.GetWindowScrollPos();
								_this.notifier.style.top = windowScroll.scrollTop + 'px';
							});
						}
						else
						{
							_this.notifier.style.top='0px';
							_this.notifier.style.position='fixed';
						}
					}
				})).start();
			}
		}
		else
		{
			var timeout;
			if(data == 'SESSION_CHANGED')
				timeout = (_this.timeout-60);
			else
				timeout = (_this.activityInterval < 60? 60 : (_this.activityInterval > _this.timeout? (_this.timeout-60) : _this.activityInterval));

			var curr = new Date();
			_this.dateCheck.setTime(curr.valueOf());
			setTimeout(_this.CheckSession, timeout*1000);
		}
	}
	
	this.Close = function()
	{
		this.notifier.style.display = 'none';
	}
}

var bxSession = new CBXSession();
/* End */
;
; /* Start:/bitrix/js/main/core/core_fx.js*/
;(function(window){

var defaultOptions = {
	time: 1.0,
	step: 0.05,
	type: 'linear',

	allowFloat: false
}

/*
options: {
	start: start value or {param: value, param: value}
	finish: finish value or {param: value, param: value}
	time: time to transform in seconds
	type: linear|accelerated|decelerated|custom func name
	callback,
	callback_start,
	callback_complete,

	step: time between steps in seconds
	allowFloat: false|true
}
*/
BX.fx = function(options)
{
	this.options = options;

	if (null != this.options.time)
		this.options.originalTime = this.options.time;
	if (null != this.options.step)
		this.options.originalStep = this.options.step;

	if (!this.__checkOptions())
		return false;

	this.__go = BX.delegate(this.go, this);

	this.PARAMS = {};
}

BX.fx.prototype.__checkOptions = function()
{
	if (typeof this.options.start != typeof this.options.finish)
		return false;

	if (null == this.options.time) this.options.time = defaultOptions.time;
	if (null == this.options.step) this.options.step = defaultOptions.step;
	if (null == this.options.type) this.options.type = defaultOptions.type;
	if (null == this.options.allowFloat) this.options.allowFloat = defaultOptions.allowFloat;

	this.options.time *= 1000;
	this.options.step *= 1000;

	if (typeof this.options.start != 'object')
	{
		this.options.start = {_param: this.options.start};
		this.options.finish = {_param: this.options.finish};
	}

	var i;
	for (i in this.options.start)
	{
		if (null == this.options.finish[i])
		{
			this.options.start[i] = null;
			delete this.options.start[i];
		}
	}

	if (!BX.type.isFunction(this.options.type))
	{
		if (BX.type.isFunction(window[this.options.type]))
			this.options.type = window[this.options.type];
		else if (BX.type.isFunction(BX.fx.RULES[this.options.type]))
			this.options.type = BX.fx.RULES[this.options.type];
		else
			this.options.type = BX.fx.RULES[defaultOptions.type];
	}

	return true;
}

BX.fx.prototype.go = function()
{
	var timeCurrent = new Date().valueOf();
	if (timeCurrent < this.PARAMS.timeFinish)
	{
		for (var i in this.PARAMS.current)
		{
			this.PARAMS.current[i][0] = this.options.type.apply(this, [{
				start_value: this.PARAMS.start[i][0],
				finish_value: this.PARAMS.finish[i][0],
				current_value: this.PARAMS.current[i][0],
				current_time: timeCurrent - this.PARAMS.timeStart,
				total_time: this.options.time
			}]);
		}

		this._callback(this.options.callback);

		if (!this.paused)
			this.PARAMS.timer = setTimeout(this.__go, this.options.step);
	}
	else
	{
		this.stop();
	}
}

BX.fx.prototype._callback = function(cb)
{
	var tmp = {};

	cb = cb || this.options.callback;

	for (var i in this.PARAMS.current)
	{
		tmp[i] = (this.options.allowFloat ? this.PARAMS.current[i][0] : Math.round(this.PARAMS.current[i][0])) + this.PARAMS.current[i][1];
	}

	return cb.apply(this, [null != tmp['_param'] ? tmp._param : tmp]);
}

BX.fx.prototype.start = function()
{
	var i,value, unit;

	this.PARAMS.start = {};
	this.PARAMS.current = {};
	this.PARAMS.finish = {};

	for (i in this.options.start)
	{
		value = +this.options.start[i];
		unit = (this.options.start[i]+'').substring((value+'').length);
		this.PARAMS.start[i] = [value, unit];
		this.PARAMS.current[i] = [value, unit];
		this.PARAMS.finish[i] = [+this.options.finish[i], unit];
	}

	this._callback(this.options.callback_start);
	this._callback(this.options.callback);

	this.PARAMS.timeStart = new Date().valueOf();
	this.PARAMS.timeFinish = this.PARAMS.timeStart + this.options.time;
	this.PARAMS.timer = setTimeout(BX.delegate(this.go, this), this.options.step);

	return this;
}

BX.fx.prototype.pause = function()
{
	if (this.paused)
	{
		this.PARAMS.timer = setTimeout(this.__go, this.options.step);
		this.paused = false;
	}
	else
	{
		clearTimeout(this.PARAMS.timer);
		this.paused = true;
	}
}

BX.fx.prototype.stop = function(silent)
{
	silent = !!silent;
	if (this.PARAMS.timer)
		clearTimeout(this.PARAMS.timer);

	if (null != this.options.originalTime)
		this.options.time = this.options.originalTime;
	if (null != this.options.originalStep)
		this.options.step = this.options.originalStep;

	this.PARAMS.current = this.PARAMS.finish;
	if (!silent) {
		this._callback(this.options.callback);
		this._callback(this.options.callback_complete);
	}
}

/*
type rules of animation
 - linear - simple linear animation
 - accelerated
 - decelerated
*/

/*
	params: {
		start_value, finish_value, current_time, total_time
	}
*/
BX.fx.RULES =
{
	linear: function(params)
	{
		return params.start_value + (params.current_time/params.total_time) * (params.finish_value - params.start_value);
	},

	decelerated: function(params)
	{
		return params.start_value + Math.sqrt(params.current_time/params.total_time) * (params.finish_value - params.start_value);
	},

	accelerated: function(params)
	{
		var q = params.current_time/params.total_time;
		return params.start_value + q * q * (params.finish_value - params.start_value);
	}
}

/****************** effects realizaion ************************/

/*
	type = 'fade' || 'scroll' || 'scale' || 'fold'
*/

BX.fx.hide = function(el, type, opts)
{
	el = BX(el);

	if (typeof type == 'object' && null == opts)
	{
		opts = type;
		type = opts.type
	}

	if (!BX.type.isNotEmptyString(type))
	{
		el.style.display = 'none';
		return;
	}

	var fxOptions = BX.fx.EFFECTS[type](el, opts, 0);
	fxOptions.callback_complete = function () {
		if (opts.hide !== false)
			el.style.display = 'none';

		if (opts.callback_complete)
			opts.callback_complete.apply(this, arguments);
	}

	return (new BX.fx(fxOptions)).start();
}

BX.fx.show = function(el, type, opts)
{
	el = BX(el);

	if (typeof type == 'object' && null == opts)
	{
		opts = type;
		type = opts.type
	}

	if (!opts) opts = {};

	if (!BX.type.isNotEmptyString(type))
	{
		el.style.display = 'block';
		return;
	}

	var fxOptions = BX.fx.EFFECTS[type](el, opts, 1);

	fxOptions.callback_complete = function () {
		if (opts.show !== false)
			el.style.display = 'block';

		if (opts.callback_complete)
			opts.callback_complete.apply(this, arguments);
	}

	return (new BX.fx(fxOptions)).start();
}

BX.fx.EFFECTS = {
	scroll: function(el, opts, action)
	{
		if (!opts.direction) opts.direction = 'vertical';

		var param = opts.direction == 'horizontal' ? 'width' : 'height';

		var val = parseInt(BX.style(el, param));
		if (isNaN(val))
		{
			val = BX.pos(el)[param];
		}

		if (action == 0)
			var start = val, finish = opts.min_height ? parseInt(opts.min_height) : 0;
		else
			var finish = val, start = opts.min_height ? parseInt(opts.min_height) : 0;

		return {
			'start': start,
			'finish': finish,
			'time': opts.time || defaultOptions.time,
			'type': 'linear',
			callback_start: function () {
				if (BX.style(el, 'position') == 'static')
					el.style.position = 'relative';

				el.style.overflow = 'hidden';
				el.style[param] = start + 'px';
				el.style.display = 'block';
			},
			callback: function (val) {el.style[param] = val + 'px';}
		}
	},

	fade: function(el, opts, action)
	{
		var fadeOpts = {
			'time': opts.time || defaultOptions.time,
			'type': action == 0 ? 'decelerated' : 'linear',
			'start': action == 0 ? 1 : 0,
			'finish': action == 0 ? 0 : 1,
			'allowFloat': true
		};

		if (BX.browser.IsIE() && !BX.browser.IsIE9())
		{
			fadeOpts.start *= 100; fadeOpts.finish *= 100; fadeOpts.allowFloat = false;

			fadeOpts.callback_start = function() {
				el.style.display = 'block';
				el.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity=" + fadeOpts.start + ")";
			};

			fadeOpts.callback = function (val) {
				(el.filters['DXImageTransform.Microsoft.alpha']||el.filters.alpha).opacity = val;
			}
		}
		else
		{
			fadeOpts.callback_start = function () {
				el.style.display = 'block';
			}

			fadeOpts.callback = function (val) {
				el.style.opacity = el.style.KhtmlOpacity = el.style.MozOpacity = val;
			};
		}

		return fadeOpts;
	},

	fold: function (el, opts, action) // 'fold' is a combination of two consequential 'scroll' hidings.
	{
		if (action != 0) return;

		var pos = BX.pos(el);
		var coef = pos.height / (pos.width + pos.height);
		var old_opts = {time: opts.time || defaultOptions.time, callback_complete: opts.callback_complete, hide: opts.hide};

		opts.type = 'scroll';
		opts.direction = 'vertical';
		opts.min_height = opts.min_height || 10;
		opts.hide = false;
		opts.time = coef * old_opts.time;
		opts.callback_complete = function()
		{
			el.style.whiteSpace = 'nowrap';

			opts.direction = 'horizontal';
			opts.min_height = null;

			opts.time = old_opts.time - opts.time;
			opts.hide = old_opts.hide;
			opts.callback_complete = old_opts.callback_complete;

			BX.fx.hide(el, opts);
		}

		return BX.fx.EFFECTS.scroll(el, opts, action);
	},

	scale: function (el, opts, action)
	{
		var val = {width: parseInt(BX.style(el, 'width')), height: parseInt(BX.style(el, 'height'))};
		if (isNaN(val.width) || isNaN(val.height))
		{
			var pos = BX.pos(el)
			val = {width: pos.width, height: pos.height};
		}

		if (action == 0)
			var start = val, finish = {width: 0, height: 0};
		else
			var finish = val, start = {width: 0, height: 0};

		return {
			'start': start,
			'finish': finish,
			'time': opts.time || defaultOptions.time,
			'type': 'linear',
			callback_start: function () {
				el.style.position = 'relative';
				el.style.overflow = 'hidden';
				el.style.display = 'block';
				el.style.height = start.height + 'px';
				el.style.width = start.width + 'px';
			},
			callback: function (val) {
				el.style.height = val.height + 'px';
				el.style.width = val.width + 'px';
			}
		}
	}
}

// Color animation
//
// Set animation rule
// BX.fx.colorAnimate.addRule('animationRule1',"#FFF","#faeeb4", "background-color", 100, 1, true);
// BX.fx.colorAnimate.addRule('animationRule2',"#fc8282","#ff0000", "color", 100, 1, true);
// Params: 1 - animation name, 2 - start color, 3 - end color, 4 - count step, 5 - delay each step, 6 - return color on end animation
//
// Animate color for element
// BX.fx.colorAnimate(BX('element'), 'animationRule1,animationRule2');

var defaultOptionsColorAnimation = {
	arStack: {},
	arRules: {},
	globalAnimationId: 0
}

BX.fx.colorAnimate = function(element, rule, back)
{
	if (element == null)
		return;

	animationId = element.getAttribute('data-animation-id');
	if (animationId == null)
	{
		animationId = defaultOptionsColorAnimation.globalAnimationId;
		element.setAttribute('data-animation-id', defaultOptionsColorAnimation.globalAnimationId++);
	}
	var aRuleList = rule.split(/\s*,\s*/);

	for (var j	= 0; j < aRuleList.length; j++)
	{
		rule = aRuleList[j];

		if (!defaultOptionsColorAnimation.arRules[rule]) continue;

		var i=0;

		if (!defaultOptionsColorAnimation.arStack[animationId])
		{
			defaultOptionsColorAnimation.arStack[animationId] = {};
		}
		else if (defaultOptionsColorAnimation.arStack[animationId][rule])
		{
			i = defaultOptionsColorAnimation.arStack[animationId][rule].i;
			clearInterval(defaultOptionsColorAnimation.arStack[animationId][rule].tId);
		}

		if ((i==0 && back) || (i==defaultOptionsColorAnimation.arRules[rule][3] && !back)) continue;

		defaultOptionsColorAnimation.arStack[animationId][rule] = {'i':i, 'element': element, 'tId':setInterval('BX.fx.colorAnimate.run("'+animationId+'","'+rule+'")', defaultOptionsColorAnimation.arRules[rule][4]),'back':Boolean(back)};
	}
}

BX.fx.colorAnimate.addRule = function (rule, startColor, finishColor, cssProp, step, delay, back)
{
	defaultOptionsColorAnimation.arRules[rule] = [
		BX.util.hex2rgb(startColor),
		BX.util.hex2rgb(finishColor),
		cssProp.replace(/\-(.)/g,function(){return arguments[1].toUpperCase();}),
		step,
		delay || 1,
		back || false
	];
};

BX.fx.colorAnimate.run = function(animationId, rule)
{
	element = defaultOptionsColorAnimation.arStack[animationId][rule].element;

    defaultOptionsColorAnimation.arStack[animationId][rule].i += defaultOptionsColorAnimation.arStack[animationId][rule].back?-1:1;
 	var finishPercent = defaultOptionsColorAnimation.arStack[animationId][rule].i/defaultOptionsColorAnimation.arRules[rule][3];
	var startPercent = 1 - finishPercent;

	var aRGBStart = defaultOptionsColorAnimation.arRules[rule][0];
	var aRGBFinish = defaultOptionsColorAnimation.arRules[rule][1];

	element.style[defaultOptionsColorAnimation.arRules[rule][2]] = 'rgb('+
	Math.floor( aRGBStart['r'] * startPercent + aRGBFinish['r'] * finishPercent ) + ','+
	Math.floor( aRGBStart['g'] * startPercent + aRGBFinish['g'] * finishPercent ) + ','+
	Math.floor( aRGBStart['b'] * startPercent + aRGBFinish['b'] * finishPercent ) +')';

	if ( defaultOptionsColorAnimation.arStack[animationId][rule].i == defaultOptionsColorAnimation.arRules[rule][3] || defaultOptionsColorAnimation.arStack[animationId][rule].i ==0)
	{
		clearInterval(defaultOptionsColorAnimation.arStack[animationId][rule].tId);
		if (defaultOptionsColorAnimation.arRules[rule][5])
			BX.fx.colorAnimate(defaultOptionsColorAnimation.arStack[animationId][rule].element, rule, true);
	}
}


/*
options = {
	delay: 100,
	duration : 3000,
	start : { scroll : document.body.scrollTop, left : 0, opacity :  100 },
	finish : { scroll : document.body.scrollHeight, left : 500, opacity : 10 },
	transition : BitrixAnimation.makeEaseOut(BitrixAnimation.transitions.quart),

	step : function(state)
	{
		document.body.scrollTop = state.scroll;
		button.style.left =  state.left + "px";
		button.style.opacity =  state.opacity / 100;
	},
	complete : function()
	{
		button.style.background = "green";
	}
}

options =
{
	delay : 20,
	duration : 4000,
	transition : BXAnimation.makeEaseOut(BXAnimation.transitions.quart),
	progress : function(progress)
	{
		document.body.scrollTop = Math.round(topMax * progress);
		button.style.left =  Math.round(leftMax * progress) + "px";
		button.style.opacity =  (100 + Math.round((opacityMin - 100) * progress)) / 100;

	},
	complete : function()
	{
		button.style.background = "green";
	}
}
*/

BX.easing = function(options)
{
	this.options = options;
	this.timer = null;
};

BX.easing.prototype.animate = function()
{
	if (!this.options || !this.options.start || !this.options.finish ||
		typeof(this.options.start) != "object" || typeof(this.options.finish) != "object"
		)
		return null;

	for (var propName in this.options.start)
	{
		if (typeof(this.options.finish[propName]) == "undefined")
		{
			delete this.options.start[propName];
		}
	}

	this.options.progress = function(progress) {
		var state = {};
		for (var propName in this.start)
			state[propName] = Math.round(this.start[propName] + (this.finish[propName] - this.start[propName]) * progress);

		if (this.step)
			this.step(state);
	};

	this.animateProgress();
};

BX.easing.prototype.stop = function(completed)
{
	if (this.timer)
	{
		clearInterval(this.timer);
		this.timer = null;

		if (completed)
			this.options.complete && this.options.complete();
	}
};

BX.easing.prototype.animateProgress = function()
{
	var start = new Date();
	var delta = this.options.transition || BX.easing.transitions.linear;
	var duration = this.options.duration || 1000;

	this.timer = setInterval(BX.proxy(function() {

		var progress = (new Date() - start) / duration;
		if (progress > 1)
			progress = 1;

		this.options.progress(delta(progress));

		if (progress == 1)
			this.stop(true);

	}, this), this.options.delay || 13);

};

BX.easing.makeEaseInOut = function(delta)
{
	return function(progress) {
		if (progress < 0.5)
			return delta( 2 * progress ) / 2;
		else
			return (2 - delta( 2 * (1-progress) ) ) / 2;
	}
};

BX.easing.makeEaseOut = function(delta)
{
	return function(progress) {
		return 1 - delta(1 - progress);
	};
};

BX.easing.transitions = {

	linear : function(progress)
	{
		return progress;
	},

	quad : function(progress)
	{
		return Math.pow(progress, 2);
	},

	cubic : function(progress) {
		return Math.pow(progress, 3);
	},

	quart : function(progress)
	{
		return Math.pow(progress, 4);
	},

	quint : function(progress)
	{
		return Math.pow(progress, 5);
	},

	circ : function(progress)
	{
		return 1 - Math.sin(Math.acos(progress));
	},

	back : function(progress)
	{
		return Math.pow(progress, 2) * ((1.5 + 1) * progress - 1.5);
	},

	elastic: function(progress)
	{
		return Math.pow(2, 10 * (progress-1)) * Math.cos(20 * Math.PI * 1.5/3 * progress);
	},

	bounce : function(progress)
	{
		for(var a = 0, b = 1; 1; a += b, b /= 2) {
			if (progress >= (7 - 4 * a) / 11) {
				return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
			}
		}
	}};


})(window);

/* End */
;
; /* Start:/bitrix/js/main/core/core_window.js*/
;(function(window) {
if (BX.WindowManager) return;

/* windows manager */
BX.WindowManager = {
	_stack: [],
	_runtime_resize: {},
	_delta: 2,
	_delta_start: 1000,
	currently_loaded: null,

	settings_category: 'BX.WindowManager.9.5',

	register: function (w)
	{
		this.currently_loaded = null;
		var div = w.Get();

		div.style.zIndex = w.zIndex = this.GetZIndex();

		w.WM_REG_INDEX = this._stack.length;
		this._stack.push(w);

		if (this._stack.length < 2)
		{
			BX.bind(document, 'keyup', BX.proxy(this.__checkKeyPress, this));
		}
	},

	unregister: function (w)
	{
		if (null == w.WM_REG_INDEX)
			return null;

		var _current;
		if (this._stack.length > 0)
		{
			while ((_current = this.__pop_stack()) != w)
			{
				if (!_current)
				{
					_current = null;
					break;
				}
			}

			if (this._stack.length <= 0)
			{
				this.enableKeyCheck();
			}

			return _current;
		}
		else
		{
			return null;
		}
	},

	__pop_stack: function(clean)
	{
		if (this._stack.length > 0)
		{
			var _current = this._stack.pop();
			_current.WM_REG_INDEX = null;
			BX.onCustomEvent(_current, 'onWindowUnRegister', [clean === true]);

			return _current;
		}
		else
			return null;
	},

	clean: function()
	{
		while (this.__pop_stack(true)){}
		this._stack = null;
		this.disableKeyCheck();
	},

	Get: function()
	{
		if (this.currently_loaded)
			return this.currently_loaded;
		else if (this._stack.length > 0)
			return this._stack[this._stack.length-1];
		else
			return null;
	},

	setStartZIndex: function(value)
	{
		this._delta_start = value;
	},

	restoreStartZIndex: function()
	{
		this._delta_start = 1000;
	},

	GetZIndex: function()
	{
		return (null != (_current = this._stack[this._stack.length-1])
			? parseInt(_current.Get().style.zIndex) + this._delta
			: this._delta_start
		);
	},

	__get_check_url: function(url)
	{
		var pos = url.indexOf('?');
		return pos == -1 ? url : url.substring(0, pos);
	},

	saveWindowSize: function(url, params)
	{
		var check_url = this.__get_check_url(url);
		if (BX.userOptions)
		{
			BX.userOptions.save(this.settings_category, 'size_' + check_url, 'width', params.width);
			BX.userOptions.save(this.settings_category, 'size_' + check_url, 'height', params.height);
		}

		this._runtime_resize[check_url] = params;
	},

	saveWindowOptions: function(wnd_id, opts)
	{
		if (BX.userOptions)
		{
			for (var i in opts)
			{
				BX.userOptions.save(this.settings_category, 'options_' + wnd_id, i, opts[i]);
			}
		}
	},

	getRuntimeWindowSize: function(url)
	{
		return this._runtime_resize[this.__get_check_url(url)];
	},

	disableKeyCheck: function()
	{
		BX.unbind(document, 'keyup', BX.proxy(this.__checkKeyPress, this));
	},

	enableKeyCheck: function()
	{
		BX.bind(document, 'keyup', BX.proxy(this.__checkKeyPress, this));
	},

	__checkKeyPress: function(e)
	{
		if (null == e)
			e = window.event;

		if (e.keyCode == 27)
		{
			var wnd = BX.WindowManager.Get();
			if (wnd && !wnd.unclosable) wnd.Close();
		}
	}
};

BX.garbage(BX.WindowManager.clean, BX.WindowManager);

/* base button class */
BX.CWindowButton = function(params)
{
	if (params.btn)
	{
		this.btn = params.btn;
		this.parentWindow = params.parentWindow;

		if (/save|apply/i.test(this.btn.name))
		{
			BX.bind(this.btn, 'click', BX.delegate(this.disableUntilError, this));
		}
	}
	else
	{
		this.title = params.title; // html value attr
		this.hint = params.hint; // html title attr
		this.id = params.id; // html name and id attrs
		this.name = params.name; // html name or value attrs when id and title 're absent
		this.className = params.className; // className for button input

		this.action = params.action;
		this.onclick = params.onclick;

		// you can override button creation method
		if (params.Button && BX.type.isFunction(params.Button))
			this.Button = params.Button;

		this.btn = null;
	}
};

BX.CWindowButton.prototype.disable = function()
{
	if (this.btn)
		this.parentWindow.showWait(this.btn);
};
BX.CWindowButton.prototype.enable = function(){
	if (this.btn)
		this.parentWindow.closeWait(this.btn);
};

BX.CWindowButton.prototype.emulate = function()
{
	if (this.btn && this.btn.disabled)
		return;

	var act =
		this.action
		? BX.delegate(this.action, this)
		: (
			this.onclick
			? this.onclick
			: (
				this.btn
				? this.btn.getAttribute('onclick')
				: ''
			)
		);

	if (act)
	{
		setTimeout(act, 50);
		if (this.btn && /save|apply/i.test(this.btn.name) && !this.action)
		{
			this.disableUntilError();
		}
	}
};

BX.CWindowButton.prototype.Button = function(parentWindow)
{
	this.parentWindow = parentWindow;

	var btn = {
		props: {
			'type': 'button',
			'name': this.id ? this.id : this.name,
			'value': this.title ? this.title : this.name,
			'id': this.id
		}
	};

	if (this.hint)
		btn.props.title = this.hint;
	if (!!this.className)
		btn.props.className = this.className;

	if (this.action)
	{
		btn.events = {
			'click': BX.delegate(this.action, this)
		};
	}
	else if (this.onclick)
	{
		if (BX.browser.IsIE())
		{
			btn.events = {
				'click': BX.delegate(function() {eval(this.onclick)}, this)
			};
		}
		else
		{
			btn.attrs = {
				'onclick': this.onclick
			};
		}
	}

	this.btn = BX.create('INPUT', btn);

	return this.btn;
};

BX.CWindowButton.prototype.disableUntilError = function() {
	this.disable();
	if (!this.__window_error_handler_set)
	{
		BX.addCustomEvent(this.parentWindow, 'onWindowError', BX.delegate(this.enable, this));
		this.__window_error_handler_set = true;
	}
};

/* base window class */
BX.CWindow = function(div, type)
{
	this.DIV = div || document.createElement('DIV');

	this.SETTINGS = {
		resizable: false,
		min_height: 0,
		min_width: 0,
		top: 0,
		left: 0,
		draggable: false,
		drag_restrict: true,
		resize_restrict: true
	};

	this.ELEMENTS = {
		draggable: [],
		resizer: [],
		close: []
	};

	this.type = type == 'float' ? 'float' : 'dialog';

	BX.adjust(this.DIV, {
		props: {
			className: 'bx-core-window'
		},
		style: {
			'zIndex': 0,
			'position': 'absolute',
			'display': 'none',
			'top': this.SETTINGS.top + 'px',
			'left': this.SETTINGS.left + 'px',
			'height': '100px',
			'width': '100px'
		}
	});

	this.isOpen = false;

	BX.addCustomEvent(this, 'onWindowRegister', BX.delegate(this.onRegister, this));
	BX.addCustomEvent(this, 'onWindowUnRegister', BX.delegate(this.onUnRegister, this));

	this.MOUSEOVER = null;
	BX.bind(this.DIV, 'mouseover', BX.delegate(this.__set_msover, this));
	BX.bind(this.DIV, 'mouseout', BX.delegate(this.__unset_msover, this));

	BX.ready(BX.delegate(function() {
		document.body.appendChild(this.DIV);
	}, this));
};

BX.CWindow.prototype.Get = function () {return this.DIV};
BX.CWindow.prototype.visible = function() {return this.isOpen;};

BX.CWindow.prototype.Show = function(bNotRegister)
{
	this.DIV.style.display = 'block';

	if (!bNotRegister)
	{
		BX.WindowManager.register(this);
		BX.onCustomEvent(this, 'onWindowRegister');
	}
};

BX.CWindow.prototype.Hide = function()
{
	BX.WindowManager.unregister(this);
	this.DIV.style.display = 'none';
};

BX.CWindow.prototype.onRegister = function()
{
	this.isOpen = true;
};

BX.CWindow.prototype.onUnRegister = function(clean)
{
	this.isOpen = false;

	if (clean || (this.PARAMS && this.PARAMS.content_url))
	{
		if (clean) {BX.onCustomEvent(this, 'onWindowClose', [this, true]);}

		if (this.DIV.parentNode)
			this.DIV.parentNode.removeChild(this.DIV);
	}
	else
	{
		this.DIV.style.display = 'none';
	}
};

BX.CWindow.prototype.CloseDialog = // compatibility
BX.CWindow.prototype.Close = function(bImmediately)
{
	BX.onCustomEvent(this, 'onBeforeWindowClose', [this]);
	if (bImmediately !== true)
	{
		if (this.denyClose)
			return false;
	}

	BX.onCustomEvent(this, 'onWindowClose', [this]);

	//this crashes vis editor in ie via onWindowResizeExt event handler
	//if (this.bExpanded) this.__expand();
	// alternative version:
	if (this.bExpanded)
	{
		var pDocElement = BX.GetDocElement();
		BX.unbind(window, 'resize', BX.proxy(this.__expand_onresize, this));
		pDocElement.style.overflow = this.__expand_settings.overflow;
	}

	BX.WindowManager.unregister(this);

	return true;
};

BX.CWindow.prototype.SetResize = function(elem)
{
	elem.style.cursor = 'se-resize';
	BX.bind(elem, 'mousedown', BX.proxy(this.__startResize, this));

	this.ELEMENTS.resizer.push(elem);
	this.SETTINGS.resizable = true;
};

BX.CWindow.prototype.SetExpand = function(elem, event_name)
{
	event_name = event_name || 'click';
	BX.bind(elem, event_name, BX.proxy(this.__expand, this));
};

BX.CWindow.prototype.__expand_onresize = function()
{
	var windowSize = BX.GetWindowInnerSize();
	this.DIV.style.width = windowSize.innerWidth + "px";
	this.DIV.style.height = windowSize.innerHeight + "px";

	BX.onCustomEvent(this, 'onWindowResize');
};

BX.CWindow.prototype.__expand = function()
{
	var pDocElement = BX.GetDocElement();

	if (!this.bExpanded)
	{
		var wndScroll = BX.GetWindowScrollPos(),
			wndSize = BX.GetWindowInnerSize();

		this.__expand_settings = {
			resizable: this.SETTINGS.resizable,
			draggable: this.SETTINGS.draggable,
			width: this.DIV.style.width,
			height: this.DIV.style.height,
			left: this.DIV.style.left,
			top: this.DIV.style.top,
			scrollTop: wndScroll.scrollTop,
			scrollLeft: wndScroll.scrollLeft,
			overflow: BX.style(pDocElement, 'overflow')
		};

		this.SETTINGS.resizable = false;
		this.SETTINGS.draggable = false;

		window.scrollTo(0,0);
		pDocElement.style.overflow = 'hidden';

		this.DIV.style.top = '0px';
		this.DIV.style.left = '0px';

		this.DIV.style.width = wndSize.innerWidth + 'px';
		this.DIV.style.height = wndSize.innerHeight + 'px';

		this.bExpanded = true;

		BX.onCustomEvent(this, 'onWindowExpand');
		BX.onCustomEvent(this, 'onWindowResize');

		BX.bind(window, 'resize', BX.proxy(this.__expand_onresize, this));
	}
	else
	{
		BX.unbind(window, 'resize', BX.proxy(this.__expand_onresize, this));

		this.SETTINGS.resizable = this.__expand_settings.resizable;
		this.SETTINGS.draggable = this.__expand_settings.draggable;

		pDocElement.style.overflow = this.__expand_settings.overflow;

		this.DIV.style.top = this.__expand_settings.top;
		this.DIV.style.left = this.__expand_settings.left;
		this.DIV.style.width = this.__expand_settings.width;
		this.DIV.style.height = this.__expand_settings.height;

		window.scrollTo(this.__expand_settings.scrollLeft, this.__expand_settings.scrollTop);

		this.bExpanded = false;

		BX.onCustomEvent(this, 'onWindowNarrow');
		BX.onCustomEvent(this, 'onWindowResize');

	}
};

BX.CWindow.prototype.Resize = function(x, y)
{
	var new_width = Math.max(x - this.pos.left + this.dx, this.SETTINGS.min_width);
	var new_height = Math.max(y - this.pos.top + this.dy, this.SETTINGS.min_height);

	if (this.SETTINGS.resize_restrict)
	{
		var scrollSize = BX.GetWindowScrollSize();

		if (this.pos.left + new_width > scrollSize.scrollWidth - this.dw)
			new_width = scrollSize.scrollWidth - this.pos.left - this.dw;
	}

	this.DIV.style.width = new_width + 'px';
	this.DIV.style.height = new_height + 'px';

	BX.onCustomEvent(this, 'onWindowResize');
};

BX.CWindow.prototype.__startResize = function(e)
{
	if (!this.SETTINGS.resizable)
		return false;

	if(!e) e = window.event;

	this.wndSize = BX.GetWindowScrollPos();
	this.wndSize.innerWidth = BX.GetWindowInnerSize().innerWidth;

	this.pos = BX.pos(this.DIV);

	this.x = e.clientX + this.wndSize.scrollLeft;
	this.y = e.clientY + this.wndSize.scrollTop;

	this.dx = this.pos.left + this.pos.width - this.x;
	this.dy = this.pos.top + this.pos.height - this.y;
	this.dw = this.pos.width - parseInt(this.DIV.style.width);

	BX.bind(document, "mousemove", BX.proxy(this.__moveResize, this));
	BX.bind(document, "mouseup", BX.proxy(this.__stopResize, this));

	if(document.body.setCapture)
		document.body.setCapture();

	document.onmousedown = BX.False;

	var b = document.body;
	b.ondrag = b.onselectstart = BX.False;
	b.style.MozUserSelect = this.DIV.style.MozUserSelect = 'none';
	b.style.cursor = 'se-resize';

	BX.onCustomEvent(this, 'onWindowResizeStart');

	return true;
};

BX.CWindow.prototype.__moveResize = function(e)
{
	if(!e) e = window.event;

	var windowScroll = BX.GetWindowScrollPos();

	var x = e.clientX + windowScroll.scrollLeft;
	var y = e.clientY + windowScroll.scrollTop;

	if(this.x == x && this.y == y)
		return;

	this.Resize(x, y);

	this.x = x;
	this.y = y;
};

BX.CWindow.prototype.__stopResize = function()
{
	if(document.body.releaseCapture)
		document.body.releaseCapture();

	BX.unbind(document, "mousemove", BX.proxy(this.__moveResize, this));
	BX.unbind(document, "mouseup", BX.proxy(this.__stopResize, this));

	document.onmousedown = null;

	var b = document.body;
	b.ondrag = b.onselectstart = null;
	b.style.MozUserSelect = this.DIV.style.MozUserSelect = '';
	b.style.cursor = '';

	BX.onCustomEvent(this, 'onWindowResizeFinished')
};

BX.CWindow.prototype.SetClose = function(elem)
{
	BX.bind(elem, 'click', BX.proxy(this.Close, this));
	this.ELEMENTS.close.push(elem);
};

BX.CWindow.prototype.SetDraggable = function(elem)
{
	BX.bind(elem, 'mousedown', BX.proxy(this.__startDrag, this));

	elem.style.cursor = 'move';

	this.ELEMENTS.draggable.push(elem);
	this.SETTINGS.draggable = true;
};

BX.CWindow.prototype.Move = function(x, y)
{
	var dxShadow = 1; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	var left = parseInt(this.DIV.style.left)+x;
	var top = parseInt(this.DIV.style.top)+y;

	if (this.SETTINGS.drag_restrict)
	{
		//Left side
		if (left < 0)
			left = 0;

		//Right side
		var scrollSize = BX.GetWindowScrollSize();
		var floatWidth = this.DIV.offsetWidth;
		var floatHeight = this.DIV.offsetHeight;

		if (left > (scrollSize.scrollWidth - floatWidth - dxShadow))
			left = scrollSize.scrollWidth - floatWidth - dxShadow;

		if (top > (scrollSize.scrollHeight - floatHeight - dxShadow))
			top = scrollSize.scrollHeight - floatHeight - dxShadow;

		//Top side
		if (top < 0)
			top = 0;
	}

	this.DIV.style.left = left+'px';
	this.DIV.style.top = top+'px';

	//this.AdjustShadow(div);
};

BX.CWindow.prototype.__startDrag = function(e)
{
	if (!this.SETTINGS.draggable)
		return false;

	if(!e) e = window.event;

	this.x = e.clientX + document.body.scrollLeft;
	this.y = e.clientY + document.body.scrollTop;

	this.__bWasDragged = false;
	BX.bind(document, "mousemove", BX.proxy(this.__moveDrag, this));
	BX.bind(document, "mouseup", BX.proxy(this.__stopDrag, this));

	if(document.body.setCapture)
		document.body.setCapture();

	document.onmousedown = BX.False;

	var b = document.body;
	b.ondrag = b.onselectstart = BX.False;
	b.style.MozUserSelect = this.DIV.style.MozUserSelect = 'none';
	b.style.cursor = 'move';
	return BX.PreventDefault(e);
};

BX.CWindow.prototype.__moveDrag = function(e)
{
	if(!e) e = window.event;

	var x = e.clientX + document.body.scrollLeft;
	var y = e.clientY + document.body.scrollTop;

	if(this.x == x && this.y == y)
		return;

	this.Move((x - this.x), (y - this.y));
	this.x = x;
	this.y = y;

	if (!this.__bWasDragged)
	{
		BX.onCustomEvent(this, 'onWindowDragStart');
		this.__bWasDragged = true;
		BX.bind(BX.proxy_context, "click", BX.PreventDefault);
	}

	BX.onCustomEvent(this, 'onWindowDrag');
};

BX.CWindow.prototype.__stopDrag = function(e)
{
	if(document.body.releaseCapture)
		document.body.releaseCapture();

	BX.unbind(document, "mousemove", BX.proxy(this.__moveDrag, this));
	BX.unbind(document, "mouseup", BX.proxy(this.__stopDrag, this));

	document.onmousedown = null;

	var b = document.body;
	b.ondrag = b.onselectstart = null;
	b.style.MozUserSelect = this.DIV.style.MozUserSelect = '';
	b.style.cursor = '';

	if (this.__bWasDragged)
	{
		BX.onCustomEvent(this, 'onWindowDragFinished');
		var _proxy_context = BX.proxy_context;
		setTimeout(function(){BX.unbind(_proxy_context, "click", BX.PreventDefault)}, 100);
		this.__bWasDragged = false;
	}
	return BX.PreventDefault(e);
};

BX.CWindow.prototype.DenyClose = function()
{
	this.denyClose = true;
};

BX.CWindow.prototype.AllowClose = function()
{
	this.denyClose = false;
};

BX.CWindow.prototype.ShowError = function(str)
{
	BX.onCustomEvent(this, 'onWindowError', [str]);

	if (this._wait)
		BX.closeWait(this._wait);

	alert(str);
};

BX.CWindow.prototype.__set_msover = function() {this.MOUSEOVER = true;};
BX.CWindow.prototype.__unset_msover = function() {this.MOUSEOVER = false;};

/* dialog window class extends window class */
BX.CWindowDialog = function() {
	arguments[1] = 'dialog';
	BX.CWindowDialog.superclass.constructor.apply(this, arguments);

	this.DIV.style.top = '10px';
	this.OVERLAY = null;
};
BX.extend(BX.CWindowDialog, BX.CWindow);

BX.CWindowDialog.prototype.__resizeOverlay = function()
{
	var windowSize = BX.GetWindowScrollSize();
	this.OVERLAY.style.width = windowSize.scrollWidth + "px";
};

BX.CWindowDialog.prototype.CreateOverlay = function(zIndex)
{
	if (null == this.OVERLAY)
	{
		var windowSize = BX.GetWindowScrollSize();
		this.OVERLAY = document.body.appendChild(BX.create("DIV", {
			style: {
				position: 'absolute',
				top: '0px',
				left: '0px',
				zIndex: zIndex || (parseInt(this.DIV.style.zIndex)-2),
				width: windowSize.scrollWidth + "px",
				height: windowSize.scrollHeight + "px"
			}
		}));
	}

	return this.OVERLAY;
};

BX.CWindowDialog.prototype.Show = function()
{
	BX.CWindowDialog.superclass.Show.apply(this, arguments);

	this.CreateOverlay();

	this.OVERLAY.style.display = 'block';
	this.OVERLAY.style.zIndex = parseInt(this.DIV.style.zIndex)-2;

	BX.unbind(window, 'resize', BX.proxy(this.__resizeOverlay, this));
	BX.bind(window, 'resize', BX.proxy(this.__resizeOverlay, this));
};

BX.CWindowDialog.prototype.onUnRegister = function(clean)
{
	BX.CWindowDialog.superclass.onUnRegister.apply(this, arguments);

	if (this.clean)
	{
		if (this.OVERLAY.parentNode)
			this.OVERLAY.parentNode.removeChild(this.OVERLAY);
	}
	else
	{
		this.OVERLAY.style.display = 'none';
	}

	BX.unbind(window, 'resize', BX.proxy(this.__resizeOverlay, this));
};

/* standard bitrix dialog extends BX.CWindowDialog */
/*
	arParams = {
		(
			title: 'dialog title',
			head: 'head block html',
			content: 'dialog content',
			icon: 'head icon classname or filename',

			resize_id: 'some id to save resize information'// useless if resizable = false
		)
		or
		(
			content_url: url to content load
				loaded content scripts can use BX.WindowManager.Get() to get access to the current window object
		)

		height: window_height_in_pixels,
		width: window_width_in_pixels,

		draggable: true|false,
		resizable: true|false,

		min_height: min_window_height_in_pixels, // useless if resizable = false
		min_width: min_window_width_in_pixels, // useless if resizable = false

		buttons: [
			'html_code',
			BX.CDialog.btnSave, BX.CDialog.btnCancel, BX.CDialog.btnClose
		]
	}
*/
BX.CDialog = function(arParams)
{
	BX.CDialog.superclass.constructor.apply(this);

	this._sender = 'core_window_cdialog';

	this.PARAMS = arParams || {};

	for (var i in this.defaultParams)
	{
		if (typeof this.PARAMS[i] == 'undefined')
			this.PARAMS[i] = this.defaultParams[i];
	}

	this.PARAMS.width = (!isNaN(parseInt(this.PARAMS.width)))
		? this.PARAMS.width
		: this.defaultParams['width'];
	this.PARAMS.height = (!isNaN(parseInt(this.PARAMS.height)))
		? this.PARAMS.height
		: this.defaultParams['height'];

	if (this.PARAMS.resize_id || this.PARAMS.content_url)
	{
		var arSize = BX.WindowManager.getRuntimeWindowSize(this.PARAMS.resize_id || this.PARAMS.content_url);
		if (arSize)
		{
			this.PARAMS.width = arSize.width;
			this.PARAMS.height = arSize.height;
		}
	}

	BX.addClass(this.DIV, 'bx-core-adm-dialog');
	this.DIV.id = 'bx-admin-prefix';

	this.PARTS = {};

	this.DIV.style.height = null;
	this.DIV.style.width = null;

	this.PARTS.TITLEBAR = this.DIV.appendChild(BX.create('DIV', {props: {
			className: 'bx-core-adm-dialog-head'
		}
	}));

	this.PARTS.TITLE_CONTAINER = this.PARTS.TITLEBAR.appendChild(BX.create('SPAN', {
		props: {className: 'bx-core-adm-dialog-head-inner'},
		text: this.PARAMS.title
	}));

	this.PARTS.TITLEBAR_ICONS = this.PARTS.TITLEBAR.appendChild(BX.create('DIV', {
		props: {
			className: 'bx-core-adm-dialog-head-icons'
		},
		children: (this.PARAMS.resizable ? [
			BX.create('SPAN', {props: {className: 'bx-core-adm-icon-expand', title: BX.message('JS_CORE_WINDOW_EXPAND')}}),
			BX.create('SPAN', {props: {className: 'bx-core-adm-icon-close', title: BX.message('JS_CORE_WINDOW_CLOSE')}})
		] : [
			BX.create('SPAN', {props: {className: 'bx-core-adm-icon-close', title: BX.message('JS_CORE_WINDOW_CLOSE')}})
		])
	}));


	this.PARTS.CONTENT = this.DIV.appendChild(BX.create('DIV', {
		props: {className: 'bx-core-adm-dialog-content-wrap adm-workarea'}
	}));

	this.PARTS.CONTENT_DATA = this.PARTS.CONTENT.appendChild(BX.create('DIV', {
		props: {className: 'bx-core-adm-dialog-content'},
		style: {
			height: this.PARAMS.height + 'px',
			width: this.PARAMS.width + 'px'
		}
	}));

	this.PARTS.HEAD = this.PARTS.CONTENT_DATA.appendChild(BX.create('DIV', {
		props: {
			className: 'bx-core-adm-dialog-head-block' + (this.PARAMS.icon ? ' ' + this.PARAMS.icon : '')
		}
	}));

	this.SetHead(this.PARAMS.head);
	this.SetContent(this.PARAMS.content);
	this.SetTitle(this.PARAMS.title);
	this.SetClose(this.PARTS.TITLEBAR_ICONS.lastChild);

	if (this.PARAMS.resizable)
	{
		this.SetExpand(this.PARTS.TITLEBAR_ICONS.firstChild);
		this.SetExpand(this.PARTS.TITLEBAR, 'dblclick');

		BX.addCustomEvent(this, 'onWindowExpand', BX.proxy(this.__onexpand, this));
		BX.addCustomEvent(this, 'onWindowNarrow', BX.proxy(this.__onexpand, this));
	}

	this.PARTS.FOOT = this.PARTS.BUTTONS_CONTAINER = this.PARTS.CONTENT.appendChild(BX.create('DIV', {
			props: {
				className: 'bx-core-adm-dialog-buttons'
			},
			// events: {
			// 	'click': BX.delegateEvent({property:{type: /button|submit/}}, BX.delegate(function() {this.showWait(BX.proxy_context)}, this))
			// },
			children: this.ShowButtons()
		}
	));

	if (this.PARAMS.draggable)
		this.SetDraggable(this.PARTS.TITLEBAR);

	if (this.PARAMS.resizable)
	{
		this.PARTS.RESIZER = this.DIV.appendChild(BX.create('DIV', {
			props: {className: 'bx-core-resizer'}
		}));

		this.SetResize(this.PARTS.RESIZER);

		this.SETTINGS.min_width = this.PARAMS.min_width;
		this.SETTINGS.min_height = this.PARAMS.min_height;
	}

	this.auth_callback = BX.delegate(function(){
		this.PARAMS.content = '';
		this.hideNotify();
		this.Show();
	}, this)
};
BX.extend(BX.CDialog, BX.CWindowDialog);

BX.CDialog.prototype.defaultParams = {
	width: 700,
	height: 400,
	min_width: 500,
	min_height: 300,

	resizable: true,
	draggable: true,

	title: '',
	icon: ''
};

BX.CDialog.prototype.showWait = function(el)
{
	if (BX.type.isElementNode(el) && (el.type == 'button' || el.type == 'submit'))
	{
		BX.defer(function(){el.disabled = true})();

		var bSave = (BX.hasClass(el, 'adm-btn-save') || BX.hasClass(el, 'adm-btn-save')),
			pos = BX.pos(el, true);

		el.bxwaiter = this.PARTS.FOOT.appendChild(BX.create('DIV', {
			props: {className: 'adm-btn-load-img' + (bSave ? '-green' : '')},
			style: {
				top: parseInt((pos.bottom + pos.top)/2 - 10) + 'px',
				left: parseInt((pos.right + pos.left)/2 - 10) + 'px'
			}
		}));

		BX.addClass(el, 'adm-btn-load');

		this.lastWaitElement = el;

		return el.bxwaiter;
	}
	return null;
};

BX.CDialog.prototype.closeWait = function(el)
{
	el = el || this.lastWaitElement;

	if (BX.type.isElementNode(el))
	{
		if (el.bxwaiter)
		{
			if(el.bxwaiter.parentNode)
			{
				el.bxwaiter.parentNode.removeChild(el.bxwaiter);
			}

			el.bxwaiter = null;
		}

		el.disabled = false;
		BX.removeClass(el, 'adm-btn-load');

		if (this.lastWaitElement == el)
			this.lastWaitElement = null;
	}
};

BX.CDialog.prototype.Authorize = function(arAuthResult)
{
	this.bSkipReplaceContent = true;
	this.ShowError(BX.message('JSADM_AUTH_REQ'));

	BX.onCustomEvent(this, 'onWindowError', []);

	BX.closeWait();

	(new BX.CAuthDialog({
		content_url: this.PARAMS.content_url,
		auth_result: arAuthResult,
		callback: BX.delegate(function(){
			if (this.auth_callback)
				this.auth_callback()
		}, this)
	})).Show();
};

BX.CDialog.prototype.ShowError = function(str)
{
	BX.onCustomEvent(this, 'onWindowError', [str]);

	this.closeWait();

	if (this._wait)
		BX.closeWait(this._wait);

	this.Notify(str, true);
};


BX.CDialog.prototype.__expandGetSize = function()
{
	var pDocElement = BX.GetDocElement();
	pDocElement.style.overflow = 'hidden';

	var wndSize = BX.GetWindowInnerSize();

	pDocElement.scrollTop = 0;

	this.DIV.style.top = '-' + this.dxShadow + 'px';
	this.DIV.style.left = '-' + this.dxShadow + 'px';

	return {
		width: (wndSize.innerWidth - parseInt(BX.style(this.PARTS.CONTENT, 'padding-right')) - parseInt(BX.style(this.PARTS.CONTENT, 'padding-left'))) + this.dxShadow,
		height: (wndSize.innerHeight - this.PARTS.TITLEBAR.offsetHeight - this.PARTS.FOOT.offsetHeight - parseInt(BX.style(this.PARTS.CONTENT, 'padding-top')) - parseInt(BX.style(this.PARTS.CONTENT, 'padding-bottom'))) + this.dxShadow
	};
};

BX.CDialog.prototype.__expand = function()
{
	var pDocElement = BX.GetDocElement();
	this.dxShadow = 2;

	if (!this.bExpanded)
	{
		var wndScroll = BX.GetWindowScrollPos();

		this.__expand_settings = {
			resizable: this.SETTINGS.resizable,
			draggable: this.SETTINGS.draggable,
			width: this.PARTS.CONTENT_DATA.style.width,
			height: this.PARTS.CONTENT_DATA.style.height,
			left: this.DIV.style.left,
			top: this.DIV.style.top,
			scrollTop: wndScroll.scrollTop,
			scrollLeft: wndScroll.scrollLeft,
			overflow: BX.style(pDocElement, 'overflow')
		};

		this.SETTINGS.resizable = false;
		this.SETTINGS.draggable = false;

		var pos = this.__expandGetSize();

		this.PARTS.CONTENT_DATA.style.width = pos.width + 'px';
		this.PARTS.CONTENT_DATA.style.height = pos.height + 'px';

		window.scrollTo(0,0);
		pDocElement.style.overflow = 'hidden';

		this.bExpanded = true;

		BX.onCustomEvent(this, 'onWindowExpand');
		BX.onCustomEvent(this, 'onWindowResize');
		BX.onCustomEvent(this, 'onWindowResizeExt', [{'width': pos.width, 'height': pos.height}]);

		BX.bind(window, 'resize', BX.proxy(this.__expand_onresize, this));
	}
	else
	{
		BX.unbind(window, 'resize', BX.proxy(this.__expand_onresize, this));

		this.SETTINGS.resizable = this.__expand_settings.resizable;
		this.SETTINGS.draggable = this.__expand_settings.draggable;

		pDocElement.style.overflow = this.__expand_settings.overflow;

		this.DIV.style.top = this.__expand_settings.top;
		this.DIV.style.left = this.__expand_settings.left;
		this.PARTS.CONTENT_DATA.style.width = this.__expand_settings.width;
		this.PARTS.CONTENT_DATA.style.height = this.__expand_settings.height;
		window.scrollTo(this.__expand_settings.scrollLeft, this.__expand_settings.scrollTop);
		this.bExpanded = false;

		BX.onCustomEvent(this, 'onWindowNarrow');
		BX.onCustomEvent(this, 'onWindowResize');
		BX.onCustomEvent(this, 'onWindowResizeExt', [{'width': parseInt(this.__expand_settings.width), 'height': parseInt(this.__expand_settings.height)}]);
	}
};

BX.CDialog.prototype.__expand_onresize = function()
{
	var pos = this.__expandGetSize();

	this.PARTS.CONTENT_DATA.style.width = pos.width + 'px';
	this.PARTS.CONTENT_DATA.style.height = pos.height + 'px';

	BX.onCustomEvent(this, 'onWindowResize');
	BX.onCustomEvent(this, 'onWindowResizeExt', [pos]);
};

BX.CDialog.prototype.__onexpand = function()
{
	var ob = this.PARTS.TITLEBAR_ICONS.firstChild;
	ob.className = BX.toggle(ob.className, ['bx-core-adm-icon-expand', 'bx-core-adm-icon-narrow']);
	ob.title = BX.toggle(ob.title, [BX.message('JS_CORE_WINDOW_EXPAND'), BX.message('JS_CORE_WINDOW_NARROW')]);

	if (this.PARTS.RESIZER)
	{
		this.PARTS.RESIZER.style.display = this.bExpanded ? 'none' : 'block';
	}
};


BX.CDialog.prototype.__startResize = function(e)
{
	if (!this.SETTINGS.resizable)
		return false;

	if(!e) e = window.event;

	this.wndSize = BX.GetWindowScrollPos();
	this.wndSize.innerWidth = BX.GetWindowInnerSize().innerWidth;

	this.pos = BX.pos(this.PARTS.CONTENT_DATA);

	this.x = e.clientX + this.wndSize.scrollLeft;
	this.y = e.clientY + this.wndSize.scrollTop;

	this.dx = this.pos.left + this.pos.width - this.x;
	this.dy = this.pos.top + this.pos.height - this.y;


	// TODO: suspicious
	this.dw = this.pos.width - parseInt(this.PARTS.CONTENT_DATA.style.width) + parseInt(BX.style(this.PARTS.CONTENT, 'padding-right'));

	BX.bind(document, "mousemove", BX.proxy(this.__moveResize, this));
	BX.bind(document, "mouseup", BX.proxy(this.__stopResize, this));

	if(document.body.setCapture)
		document.body.setCapture();

	document.onmousedown = BX.False;

	var b = document.body;
	b.ondrag = b.onselectstart = BX.False;
	b.style.MozUserSelect = this.DIV.style.MozUserSelect = 'none';
	b.style.cursor = 'se-resize';

	BX.onCustomEvent(this, 'onWindowResizeStart');

	return true;
};

BX.CDialog.prototype.Resize = function(x, y)
{
	var new_width = Math.max(x - this.pos.left + this.dx, this.SETTINGS.min_width);
	var new_height = Math.max(y - this.pos.top + this.dy, this.SETTINGS.min_height);

	if (this.SETTINGS.resize_restrict)
	{
		var scrollSize = BX.GetWindowScrollSize();

		if (this.pos.left + new_width > scrollSize.scrollWidth - this.dw)
			new_width = scrollSize.scrollWidth - this.pos.left - this.dw;
	}

	this.PARTS.CONTENT_DATA.style.width = new_width + 'px';
	this.PARTS.CONTENT_DATA.style.height = new_height + 'px';

	BX.onCustomEvent(this, 'onWindowResize');
	BX.onCustomEvent(this, 'onWindowResizeExt', [{'height': new_height, 'width': new_width}]);
};

BX.CDialog.prototype.SetSize = function(obSize)
{
	this.PARTS.CONTENT_DATA.style.width = obSize.width + 'px';
	this.PARTS.CONTENT_DATA.style.height = obSize.height + 'px';

	BX.onCustomEvent(this, 'onWindowResize');
	BX.onCustomEvent(this, 'onWindowResizeExt', [obSize]);
};

BX.CDialog.prototype.GetParameters = function(form_name)
{
	var form = this.GetForm();

	if(!form)
		return "";

	var i, s = "";
	var n = form.elements.length;

	var delim = '';
	for(i=0; i<n; i++)
	{
		if (s != '') delim = '&';
		var el = form.elements[i];
		if (el.disabled)
			continue;

		switch(el.type.toLowerCase())
		{
			case 'text':
			case 'textarea':
			case 'password':
			case 'hidden':
				if (null == form_name && el.name.substr(el.name.length-4) == '_alt' && form.elements[el.name.substr(0, el.name.length-4)])
					break;
				s += delim + el.name + '=' + BX.util.urlencode(el.value);
				break;
			case 'radio':
				if(el.checked)
					s += delim + el.name + '=' + BX.util.urlencode(el.value);
				break;
			case 'checkbox':
				s += delim + el.name + '=' + BX.util.urlencode(el.checked ? 'Y':'N');
				break;
			case 'select-one':
				var val = "";
				if (null == form_name && form.elements[el.name + '_alt'] && el.selectedIndex == 0)
					val = form.elements[el.name+'_alt'].value;
				else
					val = el.value;
				s += delim + el.name + '=' + BX.util.urlencode(val);
				break;
			case 'select-multiple':
				var j, bAdded = false;
				var l = el.options.length;
				for (j=0; j<l; j++)
				{
					if (el.options[j].selected)
					{
						s += delim + el.name + '=' + BX.util.urlencode(el.options[j].value);
						bAdded = true;
					}
				}
				if (!bAdded)
					s += delim + el.name + '=';
				break;
			default:
				break;
		}
	}

	return s;
};

BX.CDialog.prototype.PostParameters = function(params)
{
	var url = this.PARAMS.content_url;

	if (null == params)
		params = "";

	params += (params == "" ? "" : "&") + "bxsender=" + this._sender;

	var index = url.indexOf('?');
	if (index == -1)
		url += '?' + params;
	else
		url = url.substring(0, index) + '?' + params + "&" + url.substring(index+1);

	BX.showWait();

	this.auth_callback = BX.delegate(function(){
		this.hideNotify();
		this.PostParameters(params);
	}, this);

	BX.ajax.post(url, this.GetParameters(), BX.delegate(function(result) {
		BX.closeWait();
		if (!this.bSkipReplaceContent)
		{
			this.ClearButtons(); // buttons are appended during form reload, so we should clear footer
			this.SetContent(result);
			this.Show(true);
		}

		this.bSkipReplaceContent = false;
	}, this));
};

BX.CDialog.prototype.Submit = function(params, url)
{
	var FORM = this.GetForm();
	if (FORM)
	{
		FORM.onsubmit = null;

		FORM.method = 'POST';
		if (!FORM.action || url)
		{
			url = url || this.PARAMS.content_url;
			if (null != params)
			{
				var index = url.indexOf('?');
				if (index == -1)
					url += '?' + params;
				else
					url = url.substring(0, index) + '?' + params + "&" + url.substring(index+1);
			}

			FORM.action = url;
		}

		if (!FORM._bxsender)
		{
			FORM._bxsender = FORM.appendChild(BX.create('INPUT', {
				attrs: {
					type: 'hidden',
					name: 'bxsender',
					value: this._sender
				}
			}));
		}

		this._wait = BX.showWait();

		this.auth_callback = BX.delegate(function(){
			this.hideNotify();
			this.Submit(params);
		}, this);

		BX.ajax.submit(FORM, BX.delegate(function(){this.closeWait()}, this));
	}
	else
	{
		alert('no form registered!');
	}
};

BX.CDialog.prototype.GetForm = function()
{
	if (null == this.__form)
	{
		var forms = this.PARTS.CONTENT_DATA.getElementsByTagName('FORM');
		this.__form = forms[0] ? forms[0] : null;
	}

	return this.__form;
};

BX.CDialog.prototype.GetRealForm = function()
{
	if (null == this.__rform)
	{
		var forms = this.PARTS.CONTENT_DATA.getElementsByTagName('FORM');
		this.__rform = forms[1] ? forms[1] : (forms[0] ? forms[0] : null);
	}

	return this.__rform;
};

BX.CDialog.prototype._checkButton = function(btn)
{
	var arCustomButtons = ['btnSave', 'btnCancel', 'btnClose'];

	for (var i = 0; i < arCustomButtons.length; i++)
	{
		if (this[arCustomButtons[i]] && (btn == this[arCustomButtons[i]]))
			return arCustomButtons[i];
	}

	return false;
};

BX.CDialog.prototype.ShowButtons = function()
{
	var result = [];
	if (this.PARAMS.buttons)
	{
		if (this.PARAMS.buttons.title) this.PARAMS.buttons = [this.PARAMS.buttons];

		for (var i=0, len=this.PARAMS.buttons.length; i<len; i++)
		{
			if (BX.type.isNotEmptyString(this.PARAMS.buttons[i]))
			{
				result.push(this.PARAMS.buttons[i]);
			}
			else if (this.PARAMS.buttons[i])
			{
				//if (!(this.PARAMS.buttons[i] instanceof BX.CWindowButton))
				if (!BX.is_subclass_of(this.PARAMS.buttons[i], BX.CWindowButton))
				{
					var b = this._checkButton(this.PARAMS.buttons[i]); // hack to set links to real CWindowButton object in btnSave etc;
					this.PARAMS.buttons[i] = new BX.CWindowButton(this.PARAMS.buttons[i]);
					if (b) this[b] = this.PARAMS.buttons[i];
				}

				result.push(this.PARAMS.buttons[i].Button(this));
			}
		}
	}

	return result;
};

BX.CDialog.prototype.setAutosave = function () {
	if (!this.bSetAutosaveDelay)
	{
		this.bSetAutosaveDelay = true;
		setTimeout(BX.proxy(this.setAutosave, this), 10);
	}
};

BX.CDialog.prototype.SetTitle = function(title)
{
	this.PARAMS.title = title;
	BX.cleanNode(this.PARTS.TITLE_CONTAINER).appendChild(document.createTextNode(this.PARAMS.title));
};

BX.CDialog.prototype.SetHead = function(head)
{
	this.PARAMS.head = BX.util.trim(head);
	this.PARTS.HEAD.innerHTML = this.PARAMS.head || "&nbsp;";
	this.PARTS.HEAD.style.display = this.PARAMS.head ? 'block' : 'none';
	this.adjustSize();
};

BX.CDialog.prototype.Notify = function(note, bError)
{
	if (!this.PARTS.NOTIFY)
	{
		this.PARTS.NOTIFY = this.DIV.insertBefore(BX.create('DIV', {
			props: {className: 'adm-warning-block'},
			children: [
				BX.create('SPAN', {
					props: {className: 'adm-warning-text'}
				}),
				BX.create('SPAN', {
					props: {className: 'adm-warning-icon'}
				}),
				BX.create('SPAN', {
					props: {className: 'adm-warning-close'},
					events: {click: BX.proxy(this.hideNotify, this)}
				})
			]
		}), this.DIV.firstChild);
	}

	if (bError)
		BX.addClass(this.PARTS.NOTIFY, 'adm-warning-block-red');
	else
		BX.removeClass(this.PARTS.NOTIFY, 'adm-warning-block-red');

	this.PARTS.NOTIFY.firstChild.innerHTML = note || '&nbsp;';
	this.PARTS.NOTIFY.firstChild.style.width = (this.PARAMS.width-50) + 'px';
	BX.removeClass(this.PARTS.NOTIFY, 'adm-warning-animate');
};

BX.CDialog.prototype.hideNotify = function()
{
	BX.addClass(this.PARTS.NOTIFY, 'adm-warning-animate');
};

BX.CDialog.prototype.__adjustHeadToIcon = function()
{
	if (!this.PARTS.HEAD.offsetHeight)
	{
		setTimeout(BX.delegate(this.__adjustHeadToIcon, this), 50);
	}
	else
	{
		if (this.icon_image && this.icon_image.height && this.icon_image.height > this.PARTS.HEAD.offsetHeight - 5)
		{
			this.PARTS.HEAD.style.height = this.icon_image.height + 5 + 'px';
			this.adjustSize();
		}

		this.icon_image.onload = null;
		this.icon_image = null;
	}
};

BX.CDialog.prototype.SetIcon = function(icon_class)
{
	if (this.PARAMS.icon != icon_class)
	{
		if (this.PARAMS.icon)
			BX.removeClass(this.PARTS.HEAD, this.PARAMS.icon);

		this.PARAMS.icon = icon_class;

		if (this.PARAMS.icon)
		{
			BX.addClass(this.PARTS.HEAD, this.PARAMS.icon);

			var icon_file = (BX.style(this.PARTS.HEAD, 'background-image') || BX.style(this.PARTS.HEAD, 'backgroundImage'));
			if (BX.type.isNotEmptyString(icon_file) && icon_file != 'none')
			{
				var match = icon_file.match(new RegExp('url\\s*\\(\\s*(\'|"|)(.+?)(\\1)\\s*\\)'));
				if(match)
				{
					icon_file = match[2];
					if (BX.type.isNotEmptyString(icon_file))
					{
						this.icon_image = new Image();
						this.icon_image.onload = BX.delegate(this.__adjustHeadToIcon, this);
						this.icon_image.src = icon_file;
					}
				}
			}
		}
	}
	this.adjustSize();
};

BX.CDialog.prototype.SetIconFile = function(icon_file)
{
	this.icon_image = new Image();
	this.icon_image.onload = BX.delegate(this.__adjustHeadToIcon, this);
	this.icon_image.src = icon_file;

	BX.adjust(this.PARTS.HEAD, {style: {backgroundImage: 'url(' + icon_file + ')', backgroundPosition: 'right 9px'/*'99% center'*/}});
	this.adjustSize();
};

/*
BUTTON: {
	title: 'title',
	'action': function executed in window object context
}
BX.CDialog.btnSave || BX.CDialog.btnCancel - standard buttons
*/

BX.CDialog.prototype.SetButtons = function(a)
{
	if (BX.type.isString(a))
	{
		if (a.length > 0)
		{
			this.PARTS.BUTTONS_CONTAINER.innerHTML += a;

			var btns = this.PARTS.BUTTONS_CONTAINER.getElementsByTagName('INPUT');
			if (btns.length > 0)
			{
				this.PARAMS.buttons = [];
				for (var i = 0; i < btns.length; i++)
				{
					this.PARAMS.buttons.push(new BX.CWindowButton({btn: btns[i], parentWindow: this}));
				}
			}
		}
	}
	else
	{
		this.PARAMS.buttons = a;
		BX.adjust(this.PARTS.BUTTONS_CONTAINER, {
			children: this.ShowButtons()
		});
	}
	this.adjustSize();
};

BX.CDialog.prototype.ClearButtons = function()
{
	BX.cleanNode(this.PARTS.BUTTONS_CONTAINER);
	this.adjustSize();
};

BX.CDialog.prototype.SetContent = function(html)
{
	this.__form = null;

	if (BX.type.isElementNode(html))
	{
		if (html.parentNode)
			html.parentNode.removeChild(html);
	}
	else if (BX.type.isString(html))
	{
		html = BX.create('DIV', {html: html});
	}

	this.PARAMS.content = html;
	BX.cleanNode(this.PARTS.CONTENT_DATA);

	BX.adjust(this.PARTS.CONTENT_DATA, {
		children: [
			this.PARTS.HEAD,
			BX.create('DIV', {
				props: {
					className: 'bx-core-adm-dialog-content-wrap-inner'
				},
				children: [this.PARAMS.content]
			})
		]
	});

	if (this.PARAMS.content_url && this.GetForm())
	{
		this.__form.submitbtn = this.__form.appendChild(BX.create('INPUT', {props:{type:'submit'},style:{display:'none'}}));
		this.__form.onsubmit = BX.delegate(this.__submit, this);
	}
};

BX.CDialog.prototype.__submit = function(e)
{
	for (var i=0,len=this.PARAMS.buttons.length; i<len; i++)
	{
		if (
			this.PARAMS.buttons[i]
			&& (
				this.PARAMS.buttons[i].name && /save|apply/i.test(this.PARAMS.buttons[i].name)
				||
				this.PARAMS.buttons[i].btn && this.PARAMS.buttons[i].btn.name && /save|apply/i.test(this.PARAMS.buttons[i].btn.name)
			)
		)
		{
			this.PARAMS.buttons[i].emulate();
			break;
		}
	}

	return BX.PreventDefault(e);
};

BX.CDialog.prototype.SwapContent = function(cont)
{
	cont = BX(cont);

	BX.cleanNode(this.PARTS.CONTENT_DATA);
	cont.parentNode.removeChild(cont);
	this.PARTS.CONTENT_DATA.appendChild(cont);
	cont.style.display = 'block';
	this.SetContent(cont.innerHTML);
};

// this method deprecated
BX.CDialog.prototype.adjustSize = function()
{
};

// this method deprecated
BX.CDialog.prototype.__adjustSize = function()
{
};

BX.CDialog.prototype.adjustSizeEx = function()
{
	BX.defer(this.__adjustSizeEx, this)();
};

BX.CDialog.prototype.__adjustSizeEx = function()
{
	var ob = this.PARTS.CONTENT_DATA.firstChild, new_height = 0;
	while (ob)
	{
		new_height += ob.offsetHeight
			+ parseInt(BX.style(ob, 'margin-top'))
			+ parseInt(BX.style(ob, 'margin-bottom'));

		ob = BX.nextSibling(ob);
	}

	if (new_height)
		this.PARTS.CONTENT_DATA.style.height = new_height + 'px';
};


BX.CDialog.prototype.__onResizeFinished = function()
{
	BX.WindowManager.saveWindowSize(
		this.PARAMS.resize_id || this.PARAMS.content_url, {height: parseInt(this.PARTS.CONTENT_DATA.style.height), width: parseInt(this.PARTS.CONTENT_DATA.style.width)}
	);
};

BX.CDialog.prototype.Show = function(bNotRegister)
{
	if ((!this.PARAMS.content) && this.PARAMS.content_url && BX.ajax && !bNotRegister)
	{
		var wait = BX.showWait();

		BX.WindowManager.currently_loaded = this;

		this.CreateOverlay(parseInt(BX.style(wait, 'z-index'))-1);
		this.OVERLAY.style.display = 'block';
		this.OVERLAY.className = 'bx-core-dialog-overlay';

		var post_data = '', method = 'GET';
		if (this.PARAMS.content_post)
		{
			post_data = this.PARAMS.content_post;
			method = 'POST';
		}

		var url = this.PARAMS.content_url
			+ (this.PARAMS.content_url.indexOf('?')<0?'?':'&')+'bxsender=' + this._sender;

		this.auth_callback = BX.delegate(function(){
			this.PARAMS.content = '';
			this.hideNotify();
			this.Show();
		}, this);

		BX.ajax({
			method: method,
			dataType: 'html',
			url: url,
			data: post_data,
			onsuccess: BX.delegate(function(data) {
				BX.closeWait(null, wait);

				this.SetContent(data || '&nbsp;');
				this.Show();
			}, this),
			processScriptsConsecutive: true
		});
	}
	else
	{
		BX.WindowManager.currently_loaded = null;
		BX.CDialog.superclass.Show.apply(this, arguments);

		this.adjustPos();

		this.OVERLAY.className = 'bx-core-dialog-overlay';

		this.__adjustSize();

		BX.addCustomEvent(this, 'onWindowResize', BX.proxy(this.__adjustSize, this));

		if (this.PARAMS.resizable && (this.PARAMS.content_url || this.PARAMS.resize_id))
			BX.addCustomEvent(this, 'onWindowResizeFinished', BX.delegate(this.__onResizeFinished, this));
	}
};

BX.CDialog.prototype.GetInnerPos = function()
{
	return {'width': parseInt(this.PARTS.CONTENT_DATA.style.width), 'height': parseInt(this.PARTS.CONTENT_DATA.style.height)};
};

BX.CDialog.prototype.adjustPos = function()
{
	if (!this.bExpanded)
	{
		var windowSize = BX.GetWindowInnerSize();
		var windowScroll = BX.GetWindowScrollPos();

		BX.adjust(this.DIV, {
			style: {
				left: parseInt(windowScroll.scrollLeft + windowSize.innerWidth / 2 - parseInt(this.DIV.offsetWidth) / 2) + 'px',
				top: Math.max(parseInt(windowScroll.scrollTop + windowSize.innerHeight / 2 - parseInt(this.DIV.offsetHeight) / 2), 0) + 'px'
			}
		});
	}
};

BX.CDialog.prototype.GetContent = function () {return this.PARTS.CONTENT_DATA};

BX.CDialog.prototype.btnSave = BX.CDialog.btnSave = {
	title: BX.message('JS_CORE_WINDOW_SAVE'),
	id: 'savebtn',
	name: 'savebtn',
	className: BX.browser.IsIE() && BX.browser.IsDoctype() && !BX.browser.IsIE10() ? '' : 'adm-btn-save',
	action: function () {
		this.disableUntilError();
		this.parentWindow.PostParameters();
	}
};

BX.CDialog.prototype.btnCancel = BX.CDialog.btnCancel = {
	title: BX.message('JS_CORE_WINDOW_CANCEL'),
	id: 'cancel',
	name: 'cancel',
	action: function () {
		this.parentWindow.Close();
	}
};

BX.CDialog.prototype.btnClose = BX.CDialog.btnClose = {
	title: BX.message('JS_CORE_WINDOW_CLOSE'),
	id: 'close',
	name: 'close',
	action: function () {
		this.parentWindow.Close();
	}
};

/* special child for admin forms loaded into public page */
BX.CAdminDialog = function(arParams)
{
	BX.CAdminDialog.superclass.constructor.apply(this, arguments);

	this._sender = 'core_window_cadmindialog';

	BX.addClass(this.DIV, 'bx-core-adm-admin-dialog');

	this.PARTS.CONTENT.insertBefore(this.PARTS.HEAD, this.PARTS.CONTENT.firstChild);
	this.PARTS.HEAD.className = 'bx-core-adm-dialog-tabs';
};
BX.extend(BX.CAdminDialog, BX.CDialog);

BX.CAdminDialog.prototype.SetHead = function()
{
	BX.CAdminDialog.superclass.SetHead.apply(this, arguments);

	if (this.PARTS.HEAD.firstChild && BX.type.isElementNode(this.PARTS.HEAD.firstChild))
	{
		var ob = this.PARTS.HEAD.firstChild, new_width = 0;
		while (ob)
		{
			new_width += ob.offsetWidth
				+ parseInt(BX.style(ob, 'margin-left'))
				+ parseInt(BX.style(ob, 'margin-right'));

			ob = BX.nextSibling(ob);
		}

		this.SETTINGS.min_width = Math.max(new_width, this.SETTINGS.min_width) - 2;
		if (this.PARAMS.width < this.SETTINGS.min_width)
		{
			BX.adjust(this.PARTS.CONTENT_DATA, {
				style: {
					width: this.SETTINGS.min_width + 'px'
				}
			});
		}
	}
};

BX.CAdminDialog.prototype.SetContent = function(html)
{
	this.__form = null;

	if (BX.type.isElementNode(html))
	{
		if (html.parentNode)
			html.parentNode.removeChild(html);
	}

	this.PARAMS.content = html;
	BX.cleanNode(this.PARTS.CONTENT_DATA);

	BX.adjust(this.PARTS.CONTENT_DATA, {
		children: [
			this.PARAMS.content || '&nbsp;'
		]
	});

	if (this.PARAMS.content_url && this.GetForm())
	{
		this.__form.appendChild(BX.create('INPUT', {props:{type:'submit'},style:{display:'none'}}));
		this.__form.onsubmit = BX.delegate(this.__submit, this);
	}
};

BX.CAdminDialog.prototype.__adjustSizeEx = function()
{
	var new_height = BX.firstChild(this.PARTS.CONTENT_DATA).offsetHeight;
	if (new_height)
		this.PARTS.CONTENT_DATA.style.height = new_height + 'px';
};

BX.CAdminDialog.prototype.__expandGetSize = function()
{
	var res = BX.CAdminDialog.superclass.__expandGetSize.apply(this, arguments);

	res.width -= parseInt(BX.style(this.PARTS.CONTENT_DATA, 'padding-right')) + parseInt(BX.style(this.PARTS.CONTENT_DATA, 'padding-left'));
	res.height -= parseInt(BX.style(this.PARTS.CONTENT_DATA, 'padding-top')) + parseInt(BX.style(this.PARTS.CONTENT_DATA, 'padding-bottom'));

	res.height -= this.PARTS.HEAD.offsetHeight;

	return res;
};

BX.CAdminDialog.prototype.Submit = function()
{
	var FORM = this.GetForm();
	if (FORM && !FORM['bxpublic'] && !/bxpublic=/.test(FORM.action))
	{
		FORM.appendChild(BX.create('INPUT', {
			props: {
				type: 'hidden',
				name: 'bxpublic',
				value: 'Y'
			}
		}));
	}

	return BX.CAdminDialog.superclass.Submit.apply(this, arguments);
};

BX.CAdminDialog.prototype.btnSave = BX.CAdminDialog.btnSave = {
	title: BX.message('JS_CORE_WINDOW_SAVE'),
	id: 'savebtn',
	name: 'savebtn',
	className: 'adm-btn-save',
	action: function () {
		this.disableUntilError();
		this.parentWindow.Submit();
	}
};

BX.CAdminDialog.btnCancel = BX.CAdminDialog.superclass.btnCancel;
BX.CAdminDialog.btnClose = BX.CAdminDialog.superclass.btnClose;

BX.CDebugDialog = function(arParams)
{
	BX.CDebugDialog.superclass.constructor.apply(this, arguments);
};
BX.extend(BX.CDebugDialog, BX.CDialog);

BX.CDebugDialog.prototype.ShowDetails = function(div_id)
{
	var div = BX(div_id);
	if (div)
	{
		if (this.div_detail_current)
			this.div_detail_current.style.display = 'none';

		div.style.display = 'block';
		this.div_detail_current = div;
	}
};

BX.CDebugDialog.prototype.SetContent = function(html)
{
	if (!html)
		return;

	var arHtml = html.split('#DIVIDER#');
	if (arHtml.length > 1)
	{
		this.PARAMS.content = arHtml[1];

		this.PARTS.CONTENT_DATA.style.overflow = 'hidden';

		BX.CDebugDialog.superclass.SetContent.apply(this, [arHtml[1]]);

		this.PARTS.CONTENT_INNER = this.PARTS.CONTENT_DATA.firstChild.nextSibling;
		this.PARTS.CONTENT_TOP = this.PARTS.CONTENT_DATA.insertBefore(BX.create('DIV', {
			props: {
				className: 'bx-debug-content-top'
			},
			html: arHtml[0]
		}), this.PARTS.CONTENT_INNER);
		this.PARTS.CONTENT_INNER.style.overflow = 'auto';
	}
	else
	{
		BX.CDebugDialog.superclass.SetContent.apply(this, arguments);
	}
};

BX.CDebugDialog.prototype.__adjustSize = function()
{
	BX.CDebugDialog.superclass.__adjustSize.apply(this, arguments);

	if (this.PARTS.CONTENT_TOP)
	{
		var new_height = this.PARTS.CONTENT_DATA.offsetHeight - this.PARTS.HEAD.offsetHeight - this.PARTS.CONTENT_TOP.offsetHeight - 38;

		if (new_height > 0)
		{
			this.PARTS.CONTENT_INNER.style.height = new_height + 'px';
		}
	}
};


/* class for dialog window with editors */

BX.CEditorDialog = function(arParams)
{
	BX.CEditorDialog.superclass.constructor.apply(this, arguments);

	BX.removeClass(this.PARTS.CONTENT, 'bx-core-adm-dialog-content-wrap');
	BX.removeClass(this.PARTS.CONTENT_DATA, 'bx-core-adm-dialog-content');

	BX.removeClass(this.PARTS.CONTENT_DATA.lastChild, 'bx-core-adm-dialog-content-wrap-inner');
	BX.removeClass(this.PARTS.BUTTONS_CONTAINER, 'bx-core-adm-dialog-buttons');

	BX.addClass(this.PARTS.CONTENT, 'bx-core-editor-dialog-content-wrap');
	BX.addClass(this.PARTS.CONTENT_DATA, 'bx-core-editor-dialog-content');
	BX.addClass(this.PARTS.BUTTONS_CONTAINER, 'bx-core-editor-dialog-buttons');
};
BX.extend(BX.CEditorDialog, BX.CDialog);

BX.CEditorDialog.prototype.SetContent  = function()
{
	BX.CEditorDialog.superclass.SetContent.apply(this, arguments);

	BX.removeClass(this.PARTS.CONTENT_DATA.lastChild, 'bx-core-adm-dialog-content-wrap-inner');
};

/* class for wizards in admin section */
BX.CWizardDialog = function(arParams)
{
	BX.CWizardDialog.superclass.constructor.apply(this, arguments);

	BX.removeClass(this.PARTS.CONTENT, 'bx-core-adm-dialog-content-wrap');
	BX.removeClass(this.PARTS.CONTENT_DATA, 'bx-core-adm-dialog-content');
	BX.removeClass(this.PARTS.CONTENT_DATA.lastChild, 'bx-core-adm-dialog-content-wrap-inner');
	BX.removeClass(this.PARTS.BUTTONS_CONTAINER, 'bx-core-adm-dialog-buttons');

	BX.addClass(this.PARTS.CONTENT, 'bx-core-wizard-dialog-content-wrap');
};

BX.extend(BX.CWizardDialog, BX.CDialog);

/* class for auth dialog */
BX.CAuthDialog = function(arParams)
{
	arParams.resizable = false;
	arParams.width = 350;
	arParams.height = 200;

	arParams.buttons = [this.btnSave];

	BX.CAuthDialog.superclass.constructor.apply(this, arguments);
	this._sender = 'core_window_cauthdialog';

	BX.addClass(this.DIV, 'bx-core-auth-dialog');

	BX.AUTHAGENT = this;
};
BX.extend(BX.CAuthDialog, BX.CDialog);

BX.CAuthDialog.prototype.btnSave = BX.CAuthDialog.btnSave = {
	title: BX.message('JS_CORE_WINDOW_AUTH'),
	id: 'savebtn',
	name: 'savebtn',
	className: 'adm-btn-save',
	action: function () {
		this.disableUntilError();
		this.parentWindow.Submit({}, this.parentWindow.PARAMS.content_url);
	}
};

BX.CAuthDialog.prototype.SetError = function(error)
{
	BX.closeWait();

	if (!!error)
		this.ShowError(error.MESSAGE || error);
};

BX.CAuthDialog.prototype.setAuthResult = function(result)
{
	BX.closeWait();

	if (result === false)
	{
		this.Close();
		if (this.PARAMS.callback)
			this.PARAMS.callback();
	}
	else
	{
		this.SetError(result);
	}
};

/* MENU CLASSES */

BX.CWindowFloat = function(node)
{
	BX.CWindowFloat.superclass.constructor.apply(this, [node, 'float']);

	this.SETTINGS.resizable = false;
};
BX.extend(BX.CWindowFloat, BX.CWindow);

BX.CWindowFloat.prototype.adjustPos = function()
{
	if (this.PARAMS.parent)
		this.adjustToNode();
	else if (this.PARAMS.x && this.PARAMS.y)
		this.adjustToPos([this.PARAMS.x, this.PARAMS.y]);
};

BX.CWindowFloat.prototype.adjustToPos = function(pos)
{
	this.DIV.style.left = parseInt(pos[0]) + 'px';
	this.DIV.style.top = parseInt(pos[1]) + 'px';
};

BX.CWindowFloat.prototype.adjustToNodeGetPos = function()
{
	return BX.pos(this.PARAMS.parent);
};

BX.CWindowFloat.prototype.adjustToNode = function(el)
{
	el = el || this.PARAMS.parent;

	this.PARAMS.parent = BX(el);

	if (this.PARAMS.parent)
	{
		var pos = this.adjustToNodeGetPos();

		this.DIV.style.top = pos.top + 'px';//(pos.top - 26) + 'px';
		this.DIV.style.left = pos.left + 'px';

		this.PARAMS.parent.OPENER = this;
	}
};

BX.CWindowFloat.prototype.Show = function()
{
	this.adjustToPos([-1000, -1000]);
	BX.CWindowFloat.superclass.Show.apply(this, arguments);
	this.adjustPos();
};

/* menu opener class */
/*
{
	DOMNode DIV,
	BX.CMenu or Array MENU,
	TYPE = 'hover' | 'click',
	TIMEOUT: 1000
	ATTACH_MODE: 'top' | 'right'
	ACTIVE_CLASS: className for opener element when menu is opened
}
*/
BX.COpener = function(arParams)
{
	this.PARAMS = arParams || {};

	this.MENU = arParams.MENU || [];

	this.DIV = arParams.DIV;
	this.ATTACH = arParams.ATTACH || arParams.DIV;
	this.ATTACH_MODE = arParams.ATTACH_MODE || 'bottom';

	this.ACTIVE_CLASS = arParams.ACTIVE_CLASS || '';
	this.LEVEL = arParams.LEVEL || 0;

	this.CLOSE_ON_CLICK = typeof arParams.CLOSE_ON_CLICK != 'undefined' ? !!arParams.CLOSE_ON_CLICK : true;
	this.ADJUST_ON_CLICK = typeof arParams.ADJUST_ON_CLICK != 'undefined' ? !!arParams.ADJUST_ON_CLICK : true;

	this.TYPE = this.PARAMS.TYPE == 'hover' ? 'hover' : 'click';

	this._openTimeout = null;

	if (this.PARAMS.TYPE == 'hover' && arParams.TIMEOUT !== 0)
		this.TIMEOUT = arParams.TIMEOUT || 1000;
	else
		this.TIMEOUT = 0;

	if (!!this.PARAMS.MENU_URL)
	{
		this.bMenuLoaded = false;
		this.bMenuLoading = false;

		this.MENU = [{
			TEXT: BX.message('JS_CORE_LOADING'),
			CLOSE_ON_CLICK: false
		}];

		if (this.PARAMS.MENU_PRELOAD)
		{
			BX.defer(this.Load, this)();
		}
	}

	BX.ready(BX.defer(this.Init, this));
};

BX.COpener.prototype.Init = function()
{
	this.DIV = BX(this.DIV);

	switch (this.TYPE)
	{
		case 'hover':
			BX.bind(this.DIV, 'mouseover', BX.proxy(this.Open, this));
			BX.bind(this.DIV, 'click', BX.proxy(this.Toggle, this));
		break;

		case 'click':
			BX.bind(this.DIV, 'click', BX.proxy(this.Toggle, this));
		break;
	}

	//BX.bind(window, 'scroll', BX.delegate(this.__close_immediately, this));

	this.bMenuInit = false;
};

BX.COpener.prototype.Load = function()
{
	if (this.PARAMS.MENU_URL && !this.bMenuLoaded)
	{
		if (!this.bMenuLoading)
		{
			var url = this.PARAMS.MENU_URL;
			if (url.indexOf('sessid=') <= 0)
				url += (url.indexOf('?') > 0 ? '&' : '?') + 'sessid=' + BX.bitrix_sessid();

			this.bMenuLoading = true;
			BX.ajax.loadJSON(url, BX.proxy(this.SetMenu, this), BX.proxy(this.LoadFailed, this));
		}
	}
};

BX.COpener.prototype.SetMenu = function(menu)
{
	this.bMenuLoaded = true;
	this.bMenuLoading = false;
	if (this.bMenuInit)
	{
		this.MENU.setItems(menu);
	}
	else
	{
		this.MENU = menu;
	}
};

BX.COpener.prototype.LoadFailed = function()
{
	this.bMenuLoading = false;
	BX.debug(arguments);
};

BX.COpener.prototype.checkAdminMenu = function()
{
	if (document.documentElement.id == 'bx-admin-prefix')
		return true;

	return !!BX.findParent(this.DIV, {property: {id: 'bx-admin-prefix'}});
};

BX.COpener.prototype.Toggle = function(e)
{
	this.__clear_timeout();

	if (!this.bMenuInit || !this.MENU.visible())
	{
		var t = this.TIMEOUT;
		this.TIMEOUT = 0;
		this.Open(e);
		this.TIMEOUT = t;
	}
	else
	{
		this.MENU.Close();
	}

	return !!(e||window.event) && BX.PreventDefault(e);
};

BX.COpener.prototype.GetMenu = function()
{
	if (!this.bMenuInit)
	{
		if (BX.type.isArray(this.MENU))
		{
			this.MENU = new BX.CMenu({
				ITEMS: this.MENU,
				ATTACH_MODE: this.ATTACH_MODE,
				SET_ID: this.checkAdminMenu() ? 'bx-admin-prefix' : '',
				CLOSE_ON_CLICK: !!this.CLOSE_ON_CLICK,
				ADJUST_ON_CLICK: !!this.ADJUST_ON_CLICK,
				LEVEL: this.LEVEL,
				parent: BX(this.DIV),
				parent_attach: BX(this.ATTACH)
			});

			if (this.LEVEL > 0)
			{
				BX.bind(this.MENU.DIV, 'mouseover', BX.proxy(this._on_menu_hover, this));
				BX.bind(this.MENU.DIV, 'mouseout', BX.proxy(this._on_menu_hout, this));
			}
		}

		BX.addCustomEvent(this.MENU, 'onMenuOpen', BX.proxy(this.handler_onopen, this));
		BX.addCustomEvent(this.MENU, 'onMenuClose', BX.proxy(this.handler_onclose, this));

		BX.addCustomEvent('onMenuItemHover', BX.proxy(this.handler_onover, this));

		this.bMenuInit = true;
	}

	return this.MENU;
};

BX.COpener.prototype.Open = function()
{
	this.GetMenu();

	this.bOpen = true;

	this.__clear_timeout();

	if (this.TIMEOUT > 0)
	{
		BX.bind(this.DIV, 'mouseout', BX.proxy(this.__clear_timeout, this));
		this._openTimeout = setTimeout(BX.proxy(this.__open, this), this.TIMEOUT);
	}
	else
	{
		this.__open();
	}

	if (!!this.PARAMS.MENU_URL && !this.bMenuLoaded)
	{
		this._loadTimeout = setTimeout(BX.proxy(this.Load, this), parseInt(this.TIMEOUT/2));
	}

	return true;
};

BX.COpener.prototype.__clear_timeout = function()
{
	if (!!this._openTimeout)
		clearTimeout(this._openTimeout);
	if (!!this._loadTimeout)
		clearTimeout(this._loadTimeout);

	BX.unbind(this.DIV, 'mouseout', BX.proxy(this.__clear_timeout, this));
};

BX.COpener.prototype._on_menu_hover = function()
{
	this.bMenuHover = true;

	this.__clear_timeout();

	if (this.ACTIVE_CLASS)
		BX.addClass(this.DIV, this.ACTIVE_CLASS);

};

BX.COpener.prototype._on_menu_hout = function()
{
	this.bMenuHover = false;
};

BX.COpener.prototype.handler_onover = function(level, opener)
{
	if (this.bMenuHover)
		return;

	if (opener != this && level == this.LEVEL-1 && this.ACTIVE_CLASS)
	{
		BX.removeClass(this.DIV, this.ACTIVE_CLASS);
	}

	if (this.bMenuInit && level <= this.LEVEL-1 && this.MENU.visible())
	{
		if (opener != this)
		{
			this.__clear_timeout();
			this._openTimeout = setTimeout(BX.proxy(this.Close, this), this.TIMEOUT);
		}
	}
};

BX.COpener.prototype.handler_onopen = function()
{
	this.bOpen = true;

	if (this.ACTIVE_CLASS)
		BX.addClass(this.DIV, this.ACTIVE_CLASS);

	BX.defer(function() {
		BX.onCustomEvent(this, 'onOpenerMenuOpen');
	}, this)();
};

BX.COpener.prototype.handler_onclose = function()
{
	this.bOpen = false;
	BX.onCustomEvent(this, 'onOpenerMenuClose');

	if (this.ACTIVE_CLASS)
		BX.removeClass(this.DIV, this.ACTIVE_CLASS);
};

BX.COpener.prototype.Close = function()
{
	if (!this.bMenuInit)
		return;

	if (!!this._openTimeout)
		clearTimeout(this._openTimeout);

	this.bOpen = false;

	this.__close();
};

BX.COpener.prototype.__open = function()
{
	this.__clear_timeout();

	if (this.bMenuInit && this.bOpen && !this.MENU.visible())
		this.MENU.Show();
};

BX.COpener.prototype.__close = function()
{
	if (this.bMenuInit && !this.bOpen && this.MENU.visible())
		this.MENU.Hide();
};

BX.COpener.prototype.__close_immediately = function() {
	this.bOpen = false; this.__close();
};

BX.COpener.prototype.isMenuVisible = function() {
	return null != this.MENU.visible && this.MENU.visible()
};

/* common menu class */

BX.CMenu = function(arParams)
{
	BX.CMenu.superclass.constructor.apply(this);

	this.DIV.style.width = 'auto';//this.DIV.firstChild.offsetWidth + 'px';
	this.DIV.style.height = 'auto';//this.DIV.firstChild.offsetHeight + 'px';

	this.PARAMS = arParams || {};
	this.PARTS = {};

	this.PARAMS.ATTACH_MODE = this.PARAMS.ATTACH_MODE || 'bottom';
	this.PARAMS.CLOSE_ON_CLICK = typeof this.PARAMS.CLOSE_ON_CLICK == 'undefined' ? true : this.PARAMS.CLOSE_ON_CLICK;
	this.PARAMS.ADJUST_ON_CLICK = typeof this.PARAMS.ADJUST_ON_CLICK == 'undefined' ? true : this.PARAMS.ADJUST_ON_CLICK;
	this.PARAMS.LEVEL = this.PARAMS.LEVEL || 0;

	this.DIV.className = 'bx-core-popup-menu bx-core-popup-menu-' + this.PARAMS.ATTACH_MODE + ' bx-core-popup-menu-level' + this.PARAMS.LEVEL + (typeof this.PARAMS.ADDITIONAL_CLASS != 'undefined' ? ' ' + this.PARAMS.ADDITIONAL_CLASS : '');
	if (!!this.PARAMS.SET_ID)
		this.DIV.id = this.PARAMS.SET_ID;

	if (this.PARAMS.LEVEL == 0)
	{
		this.ARROW = this.DIV.appendChild(BX.create('SPAN', {props: {className: 'bx-core-popup-menu-angle'}, style: {left:'15px'}}));
	}

	if (!!this.PARAMS.CLASS_NAME)
		this.DIV.className += ' ' + this.PARAMS.CLASS_NAME;

	BX.bind(this.DIV, 'click', BX.eventCancelBubble);

	this.ITEMS = [];

	this.setItems(this.PARAMS.ITEMS);

	BX.addCustomEvent('onMenuOpen', BX.proxy(this._onMenuOpen, this));
	BX.addCustomEvent('onMenuItemSelected', BX.proxy(this.Hide, this));
};
BX.extend(BX.CMenu, BX.CWindowFloat);

BX.CMenu.broadcastCloseEvent = function()
{
	BX.onCustomEvent("onMenuItemSelected");
};

BX.CMenu._toggleChecked = function()
{
	BX.toggleClass(this, 'bx-core-popup-menu-item-checked');
};

BX.CMenu._itemDblClick = function()
{
	window.location.href = this.href;
};

BX.CMenu.prototype.toggleArrow = function(v)
{
	if (!!this.ARROW)
	{
		if (typeof v == 'undefined')
		{
			v = this.ARROW.style.visibility == 'hidden';
		}

		this.ARROW.style.visibility = !!v ? 'visible' : 'hidden';
	}
};

BX.CMenu.prototype.visible = function()
{
	return this.DIV.style.display !== 'none';
};

BX.CMenu.prototype._onMenuOpen = function(menu, menu_level)
{
	if (this.visible())
	{
		if (menu_level == this.PARAMS.LEVEL && menu != this)
		{
			this.Hide();
		}
	}
};

BX.CMenu.prototype.onUnRegister = function()
{
	if (!this.visible())
		return;

	this.Hide();
};

BX.CMenu.prototype.setItems = function(items)
{
	this.PARAMS.ITEMS = items;

	BX.cleanNode(this.DIV);

	if (!!this.ARROW)
		this.DIV.appendChild(this.ARROW);

	if (this.PARAMS.ITEMS)
	{
		this.PARAMS.ITEMS = BX.util.array_values(this.PARAMS.ITEMS);

		var bIcons = false;
		var cnt = 0;
		for (var i = 0, len = this.PARAMS.ITEMS.length; i < len; i++)
		{
			if ((i == 0 || i == len-1) && this.PARAMS.ITEMS[i].SEPARATOR)
				continue;

			cnt++;

			if (!bIcons)
				bIcons = !!this.PARAMS.ITEMS[i].GLOBAL_ICON;

			this.addItem(this.PARAMS.ITEMS[i], i);
		}

		// Occam turning in his grave
		if (cnt === 1)
			BX.addClass(this.DIV, 'bx-core-popup-menu-single-item');
		else
			BX.removeClass(this.DIV, 'bx-core-popup-menu-single-item');

		if (!bIcons)
			BX.addClass(this.DIV, 'bx-core-popup-menu-no-icons');
		else
			BX.removeClass(this.DIV, 'bx-core-popup-menu-no-icons');

	}
};

BX.CMenu.prototype.addItem = function(item)
{
	this.ITEMS.push(item);

	if (item.SEPARATOR)
	{
		item.NODE = BX.create(
			'DIV', {props: {className: 'bx-core-popup-menu-separator'}}
		);
	}
	else
	{
		var bHasMenu = (!!item.MENU
			&& (
				(BX.type.isArray(item.MENU) && item.MENU.length > 0)
				|| item.MENU instanceof BX.CMenu
			) || !!item.MENU_URL
		);

		if (item.DISABLED)
		{
			item.CLOSE_ON_CLICK = false;
			item.LINK = null;
			item.ONCLICK = null;
			item.ACTION = null;
		}

		item.NODE = BX.create(!!item.LINK || BX.browser.IsIE() && !BX.browser.IsDoctype() ? 'A' : 'SPAN', {
			props: {
				className: 'bx-core-popup-menu-item'
					+ (bHasMenu ? ' bx-core-popup-menu-item-opener' : '')
					+ (!!item.DEFAULT ? ' bx-core-popup-menu-item-default' : '')
					+ (!!item.DISABLED ? ' bx-core-popup-menu-item-disabled' : '')
					+ (!!item.CHECKED ? ' bx-core-popup-menu-item-checked' : ''),
				title: !!BX.message['MENU_ENABLE_TOOLTIP'] ? item.TITLE || '' : '',
				BXMENULEVEL: this.PARAMS.LEVEL
			},
			attrs: !!item.LINK || BX.browser.IsIE() && !BX.browser.IsDoctype() ? {href: item.LINK || 'javascript:void(0)'} : {},
			events: {
				mouseover: function()
				{
					BX.onCustomEvent('onMenuItemHover', [this.BXMENULEVEL, this.OPENER])
				}
			},
			html: '<span class="bx-core-popup-menu-item-icon' + (item.GLOBAL_ICON ? ' '+item.GLOBAL_ICON : '') + '"></span><span class="bx-core-popup-menu-item-text">'+item.TEXT+'</span>'
		});

		if (bHasMenu && !item.DISABLED)
		{
			item.NODE.OPENER = new BX.COpener({
				DIV: item.NODE,
				ACTIVE_CLASS: 'bx-core-popup-menu-item-opened',
				TYPE: 'hover',
				MENU: item.MENU,
				MENU_URL: item.MENU_URL,
				MENU_PRELOAD: !!item.MENU_PRELOAD,
				LEVEL: this.PARAMS.LEVEL + 1,
				ATTACH_MODE:'right',
				TIMEOUT: 500
			});
		}
		else if (this.PARAMS.CLOSE_ON_CLICK && (typeof item.CLOSE_ON_CLICK == 'undefined' || !!item.CLOSE_ON_CLICK))
		{
			BX.bind(item.NODE, 'click', BX.CMenu.broadcastCloseEvent);
		}
		else if (this.PARAMS.ADJUST_ON_CLICK && (typeof item.ADJUST_ON_CLICK == 'undefined' || !!item.ADJUST_ON_CLICK))
		{
			BX.bind(item.NODE, 'click', BX.defer(this.adjustPos, this));
		}

		if (bHasMenu && !!item.LINK)
		{
			BX.bind(item.NODE, 'dblclick', BX.CMenu._itemDblClick);
		}

		if (typeof item.CHECKED != 'undefined')
		{
			BX.bind(item.NODE, 'click', BX.CMenu._toggleChecked);
		}

		item.ONCLICK = item.ACTION || item.ONCLICK;
		if (!!item.ONCLICK)
		{
			if (BX.type.isString(item.ONCLICK))
			{
				item.ONCLICK = new Function("event", item.ONCLICK);
			}

			BX.bind(item.NODE, 'click', item.ONCLICK);
		}
	}

	this.DIV.appendChild(item.NODE);
};

BX.CMenu.prototype._documentClickBind = function()
{
	this._documentClickUnBind();
	BX.bind(document, 'click', BX.proxy(this._documentClick, this));
};

BX.CMenu.prototype._documentClickUnBind = function()
{
	BX.unbind(document, 'click', BX.proxy(this._documentClick, this));
};

BX.CMenu.prototype._documentClick = function(e)
{
	e = e||window.event;
	if(!!e && !(BX.getEventButton(e) & BX.MSLEFT))
		return;

	this.Close();
};

BX.CMenu.prototype.Show = function()
{
	BX.onCustomEvent(this, 'onMenuOpen', [this, this.PARAMS.LEVEL]);
	BX.CMenu.superclass.Show.apply(this, []);

	this.bCloseEventFired = false;

	BX.addCustomEvent(this.PARAMS.parent_attach, 'onChangeNodePosition', BX.proxy(this.adjustToNode, this));

	(BX.defer(this._documentClickBind, this))();
};

BX.CMenu.prototype.Close = // we shouldn't 'Close' window - only hide
BX.CMenu.prototype.Hide = function()
{
	if (!this.visible())
		return;

	BX.removeCustomEvent(this.PARAMS.parent_attach, 'onChangeNodePosition', BX.proxy(this.adjustToNode, this));

	this._documentClickUnBind();

	if (!this.bCloseEventFired)
	{
		BX.onCustomEvent(this, 'onMenuClose', [this, this.PARAMS.LEVEL]);
		this.bCloseEventFired = true;
	}
	BX.CMenu.superclass.Hide.apply(this, arguments);


//	this.DIV.onclick = null;
	//this.PARAMS.parent.onclick = null;
};

BX.CMenu.prototype.__adjustMenuToNode = function()
{
	var pos = BX.pos(this.PARAMS.parent_attach),
		bFixed = !!BX.findParent(this.PARAMS.parent_attach, BX.is_fixed);

	if (bFixed)
		this.DIV.style.position = 'fixed';
	else
		this.DIV.style.position = 'absolute';

	if (!pos.top)
	{
		this.DIV.style.top = '-1000px';
		this.DIV.style.left = '-1000px';
	}

	if (this.bTimeoutSet) return;

	var floatWidth = this.DIV.offsetWidth, floatHeight = this.DIV.offsetHeight;
	if (!floatWidth)
	{
		setTimeout(BX.delegate(function(){
			this.bTimeoutSet = false; this.__adjustMenuToNode();
		}, this), 100);

		this.bTimeoutSet = true;
		return;
	}

	var menu_pos = {},
		wndSize = BX.GetWindowSize();

/*
	if (BX.browser.IsIE() && !BX.browser.IsDoctype())
	{
		pos.top -= 4; pos.bottom -= 4;
		pos.left -= 2; pos.right -= 2;
	}
*/

	switch (this.PARAMS.ATTACH_MODE)
	{
		case 'bottom':
			menu_pos.top = pos.bottom + 9;
			menu_pos.left = pos.left;

			if (!!this.ARROW)
			{
				var arrowPos = parseInt(this.ARROW.style.left);
				if (pos.width > floatWidth)
					arrowPos = parseInt(floatWidth/2 - 7);
				else
					arrowPos = parseInt(Math.min(floatWidth, pos.width)/2 - 7);

				if (arrowPos < 7)
				{
					menu_pos.left -= 15;
					arrowPos += 15;
				}
			}

			if (menu_pos.left > wndSize.scrollWidth - floatWidth - 10)
			{
				var orig_menu_pos = menu_pos.left;
				menu_pos.left = wndSize.scrollWidth - floatWidth - 10;

				if (!!this.ARROW)
					arrowPos += orig_menu_pos - menu_pos.left;
			}

			if (bFixed)
			{
				menu_pos.left -= wndSize.scrollLeft;
			}

			if (!!this.ARROW)
				this.ARROW.style.left = arrowPos + 'px';
		break;
		case 'right':
			menu_pos.top = pos.top-1;
			menu_pos.left = pos.right;

			if (menu_pos.left > wndSize.scrollWidth - floatWidth - 10)
			{
				menu_pos.left = pos.left - floatWidth - 1;
			}
		break;
	}

	if (bFixed)
	{
		menu_pos.top -= wndSize.scrollTop;
	}

	if (!!this.ARROW)
		this.ARROW.className = 'bx-core-popup-menu-angle';

	if((menu_pos.top + floatHeight > wndSize.scrollTop + wndSize.innerHeight)
		|| (menu_pos.top + floatHeight > wndSize.scrollHeight))
	{
		var new_top = this.PARAMS.ATTACH_MODE == 'bottom'
			? pos.top - floatHeight - 9
			: pos.bottom - floatHeight + 1;

		if((new_top > wndSize.scrollTop)
			|| (menu_pos.top + floatHeight > wndSize.scrollHeight))
		{
			if ((menu_pos.top + floatHeight > wndSize.scrollHeight))
			{
				menu_pos.top = Math.max(0, wndSize.scrollHeight-floatHeight);
				this.toggleArrow(false);
			}
			else
			{
				menu_pos.top = new_top;

				if (!!this.ARROW)
					this.ARROW.className = 'bx-core-popup-menu-angle-bottom';
			}
		}
	}

	if (menu_pos.top + menu_pos.left == 0)
	{
		this.Hide();
	}
	else
	{
		this.DIV.style.top = menu_pos.top + 'px';
		this.DIV.style.left = menu_pos.left + 'px';
	}
};

BX.CMenu.prototype.adjustToNode = function(el)
{
	this.PARAMS.parent_attach = BX(el) || this.PARAMS.parent_attach || this.PARAMS.parent;
	this.__adjustMenuToNode();
};


/* components toolbar class */

BX.CMenuOpener = function(arParams)
{
	BX.CMenuOpener.superclass.constructor.apply(this);

	this.PARAMS = arParams || {};
	this.setParent(this.PARAMS.parent);
	this.PARTS = {};

	this.SETTINGS.drag_restrict = true;

	this.defaultAction = null;

	this.timeout = 500;

	this.DIV.className = 'bx-component-opener';
	this.DIV.ondblclick = BX.PreventDefault;

	if (this.PARAMS.component_id)
	{
		this.PARAMS.transform = !!this.PARAMS.transform;
	}

	this.OPENERS = [];

	this.DIV.appendChild(BX.create('SPAN', {
		props: {className: 'bx-context-toolbar' + (this.PARAMS.transform ? ' bx-context-toolbar-vertical-mode' : '')}
	}));

	//set internal structure and register draggable element
	this.PARTS.INNER = this.DIV.firstChild.appendChild(BX.create('SPAN', {
		props: {className: 'bx-context-toolbar-inner'},
		html: '<span class="bx-context-toolbar-drag-icon"></span><span class="bx-context-toolbar-vertical-line"></span><br>'
	}));

	this.EXTRA_BUTTONS = {};

	var btnCount = 0;
	for (var i = 0, len = this.PARAMS.menu.length; i < len; i++)
	{
		var item = this.addItem(this.PARAMS.menu[i]);
		if (null != item)
		{
			btnCount++;
			this.PARTS.INNER.appendChild(item);
			this.PARTS.INNER.appendChild(BX.create('BR'));
		}
	}
	var bHasButtons = btnCount > 0;

	//menu items will be attached here

	this.PARTS.ICONS = this.PARTS.INNER.appendChild(BX.create('SPAN', {
		props: {className: 'bx-context-toolbar-icons'}
	}));

	if (this.PARAMS.component_id)
	{
		this.PARAMS.pin = !!this.PARAMS.pin;

		if (bHasButtons)
			this.PARTS.ICONS.appendChild(BX.create('SPAN', {props: {className: 'bx-context-toolbar-separator'}}));

		this.PARTS.ICON_PIN = this.PARTS.ICONS.appendChild(BX.create('A', {
			attrs: {
				href: 'javascript:void(0)'
			},
			props: {
				className: this.PARAMS.pin
							? 'bx-context-toolbar-pin-fixed'
							: 'bx-context-toolbar-pin'
			},
			events: {
				click: BX.delegate(this.__pin_btn_clicked, this)
			}
		}));
	}


	if (this.EXTRA_BUTTONS['components2_props'])
	{
		var btn = this.EXTRA_BUTTONS['components2_props'] || {URL: 'javascript:void(0)'};
		if (null == this.defaultAction)
		{
			this.defaultAction = btn.ONCLICK;
			this.defaultActionTitle = btn.TITLE || btn.TEXT;
		}

		btn.URL = 'javascript:' + BX.util.urlencode(btn.ONCLICK);

		this.ATTACH = this.PARTS.ICONS.appendChild(BX.create('SPAN', {
			props: {className: 'bx-context-toolbar-button bx-context-toolbar-button-settings' },
			children:
			[
				BX.create('SPAN',
				{
					props:{className: 'bx-context-toolbar-button-inner'},
					children:
					[
						BX.create('A', {
							attrs: {href: btn.URL},
							events: {
								mouseover: BX.proxy(this.__msover_text, this),
								mouseout: BX.proxy(this.__msout_text, this),
								mousedown: BX.proxy(this.__msdown_text, this)
							},
							html: '<span class="bx-context-toolbar-button-icon bx-context-toolbar-settings-icon"></span>'
						}),
						BX.create('A', {
							attrs: {href: 'javascript: void(0)'},
							props: {className: 'bx-context-toolbar-button-arrow'},
							events: {
								mouseover: BX.proxy(this.__msover_arrow, this),
								mouseout: BX.proxy(this.__msout_arrow, this),
								mousedown: BX.proxy(this.__msdown_arrow, this)
							},
							html: '<span class="bx-context-toolbar-button-arrow"></span>'
						})
					]
				})
			]
		}));

		this.OPENER = this.ATTACH.firstChild.lastChild;

		var opener = this.attachMenu(this.EXTRA_BUTTONS['components2_submenu']['MENU']);

		BX.addCustomEvent(opener, 'onOpenerMenuOpen', BX.proxy(this.__menu_open, this));
		BX.addCustomEvent(opener, 'onOpenerMenuClose', BX.proxy(this.__menu_close, this));
	}

	if (btnCount > 1)
	{
		this.PARTS.ICONS.appendChild(BX.create('span', { props: {className: 'bx-context-toolbar-separator bx-context-toolbar-separator-switcher'}}));

		this.ICON_TRANSFORM = this.PARTS.ICONS.appendChild(BX.create('A', {
			attrs: {href: 'javascript: void(0)'},
			props: {className: 'bx-context-toolbar-switcher'},
			events: {
				click: BX.delegate(this.__trf_btn_clicked, this)
			}
		}));
	}

	if (this.PARAMS.HINT)
	{
		this.DIV.BXHINT = this.HINT = new BX.CHint({
			parent: this.DIV,
			hint:this.PARAMS.HINT.TEXT || '',
			title: this.PARAMS.HINT.TITLE || '',
			hide_timeout: this.timeout/2,
			preventHide: false
		});
	}

	BX.addCustomEvent(this, 'onWindowDragFinished', BX.delegate(this.__onMoveFinished, this));
	BX.addCustomEvent('onDynamicModeChange', BX.delegate(this.__onDynamicModeChange, this));
	BX.addCustomEvent('onTopPanelCollapse', BX.delegate(this.__onPanelCollapse, this));

	BX.addCustomEvent('onMenuOpenerMoved', BX.delegate(this.checkPosition, this));
	BX.addCustomEvent('onMenuOpenerUnhide', BX.delegate(this.checkPosition, this));

	if (this.OPENERS)
	{
		for (i=0,len=this.OPENERS.length; i<len; i++)
		{
			BX.addCustomEvent(this.OPENERS[i], 'onOpenerMenuOpen', BX.proxy(this.__hide_hint, this));
		}
	}
};
BX.extend(BX.CMenuOpener, BX.CWindowFloat);

BX.CMenuOpener.prototype.setParent = function(new_parent)
{
	new_parent = BX(new_parent);
	if(new_parent.OPENER && new_parent.OPENER != this)
	{
		new_parent.OPENER.Close();
		new_parent.OPENER.clearHoverHoutEvents();
	}

	if(this.PARAMS.parent && this.PARAMS.parent != new_parent)
	{
		this.clearHoverHoutEvents();
		this.PARAMS.parent.OPENER = null;
	}

	this.PARAMS.parent = new_parent;
	this.PARAMS.parent.OPENER = this;
};

BX.CMenuOpener.prototype.setHoverHoutEvents = function(hover, hout)
{
	if(!this.__opener_events_set)
	{
		BX.bind(this.Get(), 'mouseover', hover);
		BX.bind(this.Get(), 'mouseout', hout);
		this.__opener_events_set = true;
	}
};

BX.CMenuOpener.prototype.clearHoverHoutEvents = function()
{
	if(this.Get())
	{
		BX.unbindAll(this.Get());
		this.__opener_events_set = false;
	}
};


BX.CMenuOpener.prototype.unclosable = true;

BX.CMenuOpener.prototype.__check_intersection = function(pos_self, pos_other)
{
	return !(pos_other.right <= pos_self.left || pos_other.left >= pos_self.right
			|| pos_other.bottom <= pos_self.top || pos_other.top >= pos_self.bottom);
};


BX.CMenuOpener.prototype.__msover_text = function() {
	this.bx_hover = true;
	if (!this._menu_open)
		BX.addClass(this.ATTACH, 'bx-context-toolbar-button-text-hover');
};

BX.CMenuOpener.prototype.__msout_text = function() {
	this.bx_hover = false;
	if (!this._menu_open)
		BX.removeClass(this.ATTACH, 'bx-context-toolbar-button-text-hover bx-context-toolbar-button-text-active');
};

BX.CMenuOpener.prototype.__msover_arrow = function() {
	this.bx_hover = true;
	if (!this._menu_open)
		BX.addClass(this.ATTACH, 'bx-context-toolbar-button-arrow-hover');
};

BX.CMenuOpener.prototype.__msout_arrow = function() {
	this.bx_hover = false;
	if (!this._menu_open)
		BX.removeClass(this.ATTACH, 'bx-context-toolbar-button-arrow-hover bx-context-toolbar-button-arrow-active');
};

BX.CMenuOpener.prototype.__msdown_text = function() {
	this.bx_active = true;
	if (!this._menu_open)
		BX.addClass(this.ATTACH, 'bx-context-toolbar-button-text-active');
};

BX.CMenuOpener.prototype.__msdown_arrow = function() {
	this.bx_active = true;
	if (!this._menu_open)
		BX.addClass(this.ATTACH, 'bx-context-toolbar-button-arrow-active');
};

BX.CMenuOpener.prototype.__menu_close = function() {
	this._menu_open = false;
	this.bx_active = false;
	BX.removeClass(this.ATTACH, 'bx-context-toolbar-button-active bx-context-toolbar-button-text-active bx-context-toolbar-button-arrow-active');
	if (!this.bx_hover)
	{
		BX.removeClass(this.ATTACH, 'bx-context-toolbar-button-hover bx-context-toolbar-button-text-hover bx-context-toolbar-button-arrow-hover');
		this.bx_hover = false;
	}
};

BX.CMenuOpener.prototype.__menu_open = function() {
	this._menu_open = true;
};

BX.CMenuOpener.prototype.checkPosition = function()
{
	if (this.isMenuVisible() || this.DIV.style.display == 'none'
		|| this == BX.proxy_context || BX.proxy_context.zIndex > this.zIndex)
		return;

	this.correctPosition(BX.proxy_context);
};

BX.CMenuOpener.prototype.correctPosition = function(opener)
{
	var pos_self = BX.pos(this.DIV), pos_other = BX.pos(opener.Get());
	if (this.__check_intersection(pos_self, pos_other))
	{
		var new_top = pos_other.top - pos_self.height;
		if (new_top < 0)
			new_top = pos_other.bottom;

		this.DIV.style.top = new_top + 'px';

		BX.addCustomEvent(opener, 'onMenuOpenerHide', BX.proxy(this.restorePosition, this));
		BX.onCustomEvent(this, 'onMenuOpenerMoved');
	}
};

BX.CMenuOpener.prototype.restorePosition = function()
{
	if (!this.MOUSEOVER && !this.isMenuVisible())
	{
		if (this.originalPos)
			this.DIV.style.top = this.originalPos.top + 'px';

		BX.removeCustomEvent(BX.proxy_context, 'onMenuOpenerHide', BX.proxy(this.restorePosition, this));
		if (this.restore_pos_timeout) clearTimeout(this.restore_pos_timeout);
	}
	else
	{
		this.restore_pos_timeout = setTimeout(BX.proxy(this.restorePosition, this), this.timeout);
	}
};


BX.CMenuOpener.prototype.Show = function()
{
	BX.CMenuOpener.superclass.Show.apply(this, arguments);

	this.SetDraggable(this.PARTS.INNER.firstChild);

	this.DIV.style.width = 'auto';
	this.DIV.style.height = 'auto';

	if (!this.PARAMS.pin)
	{
		this.DIV.style.left = '-1000px';
		this.DIV.style.top = '-1000px';

		this.Hide();
	}
	else
	{
		this.bPosAdjusted = true;
		this.bMoved = true;

		if (this.PARAMS.top) this.DIV.style.top = this.PARAMS.top + 'px';
		if (this.PARAMS.left) this.DIV.style.left = this.PARAMS.left + 'px';

		this.DIV.style.display = (!BX.admin.dynamic_mode || BX.admin.dynamic_mode_show_borders) ? 'block' : 'none';

		if (this.DIV.style.display == 'block')
		{
			setTimeout(BX.delegate(function() {BX.onCustomEvent(this, 'onMenuOpenerUnhide')}, this), 50);
		}
	}
};

BX.CMenuOpener.prototype.executeDefaultAction = function()
{
	if (this.defaultAction)
	{
		if (BX.type.isFunction(this.defaultAction))
			this.defaultAction();
		else if(BX.type.isString(this.defaultAction))
			BX.evalGlobal(this.defaultAction);
	}
};

BX.CMenuOpener.prototype.__onDynamicModeChange = function(val)
{
	this.DIV.style.display = val ? 'block' : 'none';
};

BX.CMenuOpener.prototype.__onPanelCollapse = function(bCollapsed, dy)
{
	this.DIV.style.top = (parseInt(this.DIV.style.top) + dy) + 'px';
	if (this.PARAMS.pin)
	{
		this.__savePosition();
	}
};

BX.CMenuOpener.prototype.__onMoveFinished = function()
{
	BX.onCustomEvent(this, 'onMenuOpenerMoved');

	this.bMoved = true;

	if (this.PARAMS.pin)
		this.__savePosition();
};

BX.CMenuOpener.prototype.__savePosition = function()
{
	var arOpts = {};

	arOpts.pin = this.PARAMS.pin;
	if (!this.PARAMS.pin)
	{
		arOpts.top = false; arOpts.left = false; arOpts.transform = false;
	}
	else
	{
		arOpts.transform = this.PARAMS.transform;
		if (this.bMoved)
		{
			arOpts.left = parseInt(this.DIV.style.left);
			arOpts.top = parseInt(this.DIV.style.top);
		}
	}

	BX.WindowManager.saveWindowOptions(this.PARAMS.component_id, arOpts);
};

BX.CMenuOpener.prototype.__pin_btn_clicked = function() {this.Pin()};
BX.CMenuOpener.prototype.Pin = function(val)
{
	if (null == val)
		this.PARAMS.pin = !this.PARAMS.pin;
	else
		this.PARAMS.pin = !!val;

	this.PARTS.ICON_PIN.className = (this.PARAMS.pin ? 'bx-context-toolbar-pin-fixed' : 'bx-context-toolbar-pin');

	this.__savePosition();
};

BX.CMenuOpener.prototype.__trf_btn_clicked = function() {this.Transform()};
BX.CMenuOpener.prototype.Transform = function(val)
{
	if (null == val)
		this.PARAMS.transform = !this.PARAMS.transform;
	else
		this.PARAMS.transform = !!val;

	if (this.bMoved)
	{
		var pos = BX.pos(this.DIV);
	}

	if (this.PARAMS.transform)
		BX.addClass(this.DIV.firstChild, 'bx-context-toolbar-vertical-mode');
	else
		BX.removeClass(this.DIV.firstChild, 'bx-context-toolbar-vertical-mode');

	if (!this.bMoved)
	{
		this.adjustPos();
	}
	else
	{
		this.DIV.style.left = (pos.right - this.DIV.offsetWidth - (BX.browser.IsIE() && !BX.browser.IsDoctype() ? 2 : 0)) + 'px';
	}

	this.__savePosition();
};

BX.CMenuOpener.prototype.adjustToNodeGetPos = function()
{
	var pos = BX.pos(this.PARAMS.parent/*, true*/);

	var scrollSize = BX.GetWindowScrollSize();
	var floatWidth = this.DIV.offsetWidth;

	pos.left -= BX.admin.__border_dx;
	pos.top -= BX.admin.__border_dx;

	if (true || !this.PARAMS.transform)
	{
		pos.top -= 45;
	}

	if (pos.left > scrollSize.scrollWidth - floatWidth)
	{
		pos.left = scrollSize.scrollWidth - floatWidth;
	}

	return pos;
};

BX.CMenuOpener.prototype.addItem = function(item)
{
	if (item.TYPE)
	{
		this.EXTRA_BUTTONS[item.TYPE] = item;
		return null;
	}
	else
	{
		var q = new BX.CMenuOpenerItem(item);
		if (null == this.defaultAction)
		{
			if (q.item.ONCLICK)
			{
				this.defaultAction = item.ONCLICK;
			}
			else if (q.item.MENU)
			{
				this.defaultAction = BX.delegate(function() {this.Open()}, q.item.OPENER);
			}

			this.defaultActionTitle = item.TITLE || item.TEXT;

			BX.addClass(q.Get(), 'bx-content-toolbar-default');
		}
		if (q.item.OPENER) this.OPENERS[this.OPENERS.length] = q.item.OPENER;
		return q.Get();
	}
};

BX.CMenuOpener.prototype.attachMenu = function(menu)
{
	var opener = new BX.COpener({
		'DIV':  this.OPENER,
		'ATTACH': this.ATTACH,
		'MENU': menu,
		'TYPE': 'click'
	});

	this.OPENERS[this.OPENERS.length] = opener;

	return opener;
};

BX.CMenuOpener.prototype.__hide_hint = function()
{
	if (this.HINT) this.HINT.__hide_immediately();
};

BX.CMenuOpener.prototype.isMenuVisible = function()
{
	for (var i=0,len=this.OPENERS.length; i<len; i++)
	{
		if (this.OPENERS[i].isMenuVisible())
			return true;
	}

	return false;
};

BX.CMenuOpener.prototype.Hide = function()
{
	if (!this.PARAMS.pin)
	{
		this.DIV.style.display = 'none';
		BX.onCustomEvent(this, 'onMenuOpenerHide');
	}
};
BX.CMenuOpener.prototype.UnHide = function()
{
	this.DIV.style.display = 'block';
	if (!this.bPosAdjusted && !this.PARAMS.pin)
	{
		this.adjustPos();
		this.bPosAdjusted = true;
	}

	if (null == this.originalPos && !this.bMoved)
	{
		this.originalPos = BX.pos(this.DIV);
	}

	BX.onCustomEvent(this, 'onMenuOpenerUnhide');
};

BX.CMenuOpenerItem = function(item)
{
	this.item = item;

	if (this.item.ACTION && !this.item.ONCLICK)
	{
		this.item.ONCLICK = this.item.ACTION;
	}

	this.DIV = BX.create('SPAN');
	this.DIV.appendChild(BX.create('SPAN', {props: {className: 'bx-context-toolbar-button-underlay'}}));

	this.WRAPPER = this.DIV.appendChild(BX.create('SPAN', {
		props: {className: 'bx-context-toolbar-button-wrapper'},
		children: [
			BX.create('SPAN', {
				props: {className: 'bx-context-toolbar-button', title: item.TITLE},
				children: [
					BX.create('SPAN', {
						props: {className: 'bx-context-toolbar-button-inner'}
					})
				]
			})
		]
	}));

	var btn_icon = BX.create('SPAN', {
		props: {className: 'bx-context-toolbar-button-icon' + (this.item.ICON || this.item.ICONCLASS ? ' ' + (this.item.ICON || this.item.ICONCLASS) : '')},
		attrs: (
				!(this.item.ICON || this.item.ICONCLASS)
				&&
				(this.item.SRC || this.item.IMAGE)
			)
			? {
				style: 'background: scroll transparent url(' + (this.item.SRC || this.item.IMAGE) + ') no-repeat center center !important;'
			}
			: {}
	}), btn_text = BX.create('SPAN', {
		props: {className: 'bx-context-toolbar-button-text'},
		text: this.item.TEXT
	});

	if (this.item.ACTION && !this.item.ONCLICK)
	{
		this.item.ONCLICK = this.item.ACTION;
	}

	this.bHasMenu = !!this.item.MENU;
	this.bHasAction = !!this.item.ONCLICK;

	if (this.bHasAction)
	{
		this.LINK = this.WRAPPER.firstChild.firstChild.appendChild(BX.create('A', {
			attrs: {
				'href': 'javascript: void(0)'
			},
			events: {
				mouseover: this.bHasMenu ? BX.proxy(this.__msover_text, this) : BX.proxy(this.__msover, this),
				mouseout: this.bHasMenu ? BX.proxy(this.__msout_text, this) : BX.proxy(this.__msout, this),
				mousedown: this.bHasMenu ? BX.proxy(this.__msdown_text, this) : BX.proxy(this.__msdown, this)
			},
			children: [btn_icon, btn_text]
		}));

		if (this.bHasMenu)
		{
			this.LINK_MENU = this.WRAPPER.firstChild.firstChild.appendChild(BX.create('A', {
				props: {className: 'bx-context-toolbar-button-arrow'},
				attrs: {
					'href': 'javascript: void(0)'
				},
				events: {
					mouseover: BX.proxy(this.__msover_arrow, this),
					mouseout: BX.proxy(this.__msout_arrow, this),
					mousedown: BX.proxy(this.__msdown_arrow, this)
				},
				children: [
					BX.create('SPAN', {props: {className: 'bx-context-toolbar-button-arrow'}})
				]
			}));
		}

	}
	else if (this.bHasMenu)
	{
		this.item.ONCLICK = null;

		this.LINK = this.LINK_MENU = this.WRAPPER.firstChild.firstChild.appendChild(BX.create('A', {
			attrs: {
				'href': 'javascript: void(0)'
			},
			events: {
				mouseover: BX.proxy(this.__msover, this),
				mouseout: BX.proxy(this.__msout, this),
				mousedown: BX.proxy(this.__msdown, this)
			},
			children: [
				btn_icon,
				btn_text
			]
		}));

		this.LINK.appendChild(BX.create('SPAN', {props: {className: 'bx-context-toolbar-single-button-arrow'}}));

	}

	if (this.bHasMenu)
	{
		this.item.SUBMENU = new BX.CMenu({
			ATTACH_MODE:'bottom',
			ITEMS:this.item['MENU'],
			//PARENT_MENU:this.parentMenu,
			parent: this.LINK_MENU,
			parent_attach: this.WRAPPER.firstChild
		});

		this.item.OPENER = new BX.COpener({
			DIV: this.LINK_MENU,
			TYPE: 'click',
			MENU: this.item.SUBMENU
		});

		BX.addCustomEvent(this.item.OPENER, 'onOpenerMenuOpen', BX.proxy(this.__menu_open, this));
		BX.addCustomEvent(this.item.OPENER, 'onOpenerMenuClose', BX.proxy(this.__menu_close, this));
	}

	if (this.bHasAction)
	{
		BX.bind(this.LINK, 'click', BX.delegate(this.__click, this));
	}
};

BX.CMenuOpenerItem.prototype.Get = function() {return this.DIV;};
BX.CMenuOpenerItem.prototype.__msover = function() {
	this.bx_hover = true;
	if (!this._menu_open)
		BX.addClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-hover');
};
BX.CMenuOpenerItem.prototype.__msout = function() {
	this.bx_hover = false;
	if (!this._menu_open)
		BX.removeClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-hover bx-context-toolbar-button-active');
};
BX.CMenuOpenerItem.prototype.__msover_text = function() {
	this.bx_hover = true;
	if (!this._menu_open)
		BX.addClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-text-hover');
};
BX.CMenuOpenerItem.prototype.__msout_text = function() {
	this.bx_hover = false;
	if (!this._menu_open)
		BX.removeClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-text-hover bx-context-toolbar-button-text-active');
};
BX.CMenuOpenerItem.prototype.__msover_arrow = function() {
	this.bx_hover = true;
	if (!this._menu_open)
		BX.addClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-arrow-hover');
};
BX.CMenuOpenerItem.prototype.__msout_arrow = function() {
	this.bx_hover = false;
	if (!this._menu_open)
		BX.removeClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-arrow-hover bx-context-toolbar-button-arrow-active');
};
BX.CMenuOpenerItem.prototype.__msdown = function() {
	this.bx_active = true;
	if (!this._menu_open)
		BX.addClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-active');
};
BX.CMenuOpenerItem.prototype.__msdown_text = function() {
	this.bx_active = true;
	if (!this._menu_open)
		BX.addClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-text-active');
};
BX.CMenuOpenerItem.prototype.__msdown_arrow = function() {
	this.bx_active = true;
	if (!this._menu_open)
		BX.addClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-arrow-active');
};
BX.CMenuOpenerItem.prototype.__menu_close = function() {

	this._menu_open = false;
	this.bx_active = false;
	BX.removeClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-active bx-context-toolbar-button-text-active bx-context-toolbar-button-arrow-active');
	if (!this.bx_hover)
	{
		BX.removeClass(this.LINK.parentNode.parentNode, 'bx-context-toolbar-button-hover bx-context-toolbar-button-text-hover bx-context-toolbar-button-arrow-hover');
		this.bx_hover = false;
	}
};
BX.CMenuOpenerItem.prototype.__menu_open = function() {
	this._menu_open = true;
};

BX.CMenuOpenerItem.prototype.__click = function() {BX.evalGlobal(this.item.ONCLICK)};

/* global page opener class */
BX.CPageOpener = function(arParams)
{
	//if (null == arParams.pin) arParams.pin = true;
	BX.CPageOpener.superclass.constructor.apply(this, arguments);

	this.timeout = 505;

	window.PAGE_EDIT_CONTROL = this;
};
BX.extend(BX.CPageOpener, BX.CMenuOpener);

BX.CPageOpener.prototype.checkPosition = function()
{
	if (/*this.isMenuVisible() || this.DIV.style.display == 'none' || */this == BX.proxy_context)
		return;

	this.correctPosition(BX.proxy_context);
};

BX.CPageOpener.prototype.correctPosition = function(opener)
{
	if (this.bPosCorrected) return;
	if (this.DIV.style.display == 'none')
	{
		var pos_self = this.adjustToNodeGetPos();
		pos_self.bottom = pos_self.top + 30;
		pos_self.right = pos_self.left + 300;
	}
	else
	{
		pos_self = BX.pos(this.DIV);
	}

	var pos_other = BX.pos(opener.Get());
	if (this.__check_intersection(pos_self, pos_other))
	{
		this.DIV.style.display = 'none';
		BX.addCustomEvent(opener, 'onMenuOpenerHide', BX.proxy(this.restorePosition, this));

		this.bPosCorrected = true;
	}
};

BX.CPageOpener.prototype.restorePosition = function()
{
	if (BX.proxy_context && BX.proxy_context.Get().style.display == 'none')
	{
		this.bPosCorrected = false;

		if (this.PARAMS.parent.bx_over || this.PARAMS.pin)
			this.UnHide();

		BX.removeCustomEvent('onMenuOpenerHide', BX.proxy(this.restorePosition, this));
	}
};

BX.CPageOpener.prototype.UnHide = function()
{
	if (!this.bPosCorrected)
		BX.CPageOpener.superclass.UnHide.apply(this, arguments);
};

BX.CPageOpener.prototype.Remove = function()
{
	BX.admin.removeComponentBorder(this.PARAMS.parent);
	BX.userOptions.save('global', 'settings', 'page_edit_control_enable', 'N');
	this.DIV.style.display = 'none';
};

/******* HINT ***************/
BX.CHintSimple = function()
{
	BX.CHintSimple.superclass.constructor.apply(this, arguments);
};
BX.extend(BX.CHintSimple, BX.CHint);

BX.CHintSimple.prototype.Init = function()
{
	this.DIV = document.body.appendChild(BX.create('DIV', {props: {className: 'bx-tooltip-simple'}, style: {display: 'none'}, children: [(this.CONTENT = BX.create('DIV'))]}));

	if (this.HINT_TITLE)
		this.CONTENT.appendChild(BX.create('B', {text: this.HINT_TITLE}));

	if (this.HINT)
		this.CONTENT_TEXT = this.CONTENT.appendChild(BX.create('DIV')).appendChild(BX.create('SPAN', {html: this.HINT}));

	if (this.PARAMS.preventHide)
	{
		BX.bind(this.DIV, 'mouseout', BX.proxy(this.Hide, this));
		BX.bind(this.DIV, 'mouseover', BX.proxy(this.Show, this));
	}

	this.bInited = true;
};

/*************************** admin informer **********************************/
BX.adminInformer = {

	itemsShow: 3,

	Init: function (itemsShow)
	{
		if(itemsShow)
			BX.adminInformer.itemsShow = itemsShow;

		var informer = BX("admin-informer");

		if(informer)
			document.body.appendChild(informer);

		BX.addCustomEvent("onTopPanelCollapse", BX.proxy(BX.adminInformer.Close, BX.adminInformer));
	},

	Toggle: function(notifyBlock)
	{
		var informer = BX("admin-informer");

		if(!informer)
			return false;

		var pos = BX.pos(notifyBlock);

		informer.style.top = (parseInt(pos.top)+parseInt(pos.height)+7)+'px';
		informer.style.left = pos.left+'px';

		if(!BX.hasClass(informer, "adm-informer-active"))
			BX.adminInformer.Show(informer);
		else
			BX.adminInformer.Hide(informer);

		return false;
	},

	Close: function()
	{
		BX.adminInformer.Hide(BX("admin-informer"));
	},

	OnInnerClick: function(event)
	{
		var target = event.target || event.srcElement;

		if(target.nodeName.toLowerCase() != 'a' || BX.hasClass(target,"adm-informer-footer"))
		{
			return BX.PreventDefault(event);
		}

		return true;
	},

	ToggleExtra : function()
	{
		var footerLink = BX("adm-informer-footer");

		if (BX.hasClass(footerLink, "adm-informer-footer-collapsed"))
			this.ShowAll();
		else
			this.HideExtra();

		return false;
	},

	ShowAll: function()
	{
		var informer = BX("admin-informer");
		for(var i=0; i<informer.children.length; i++)

			if(BX.hasClass(informer.children[i], "adm-informer-item") && informer.children[i].style.display == "none") {
				informer.children[i].style.display = "block";
			}

		var footerLink = BX("adm-informer-footer");

		if(footerLink.textContent !== undefined)
			footerLink.textContent = BX.message('JSADM_AI_HIDE_EXTRA');
		else
			footerLink.innerText = BX.message('JSADM_AI_HIDE_EXTRA');

		BX.removeClass(footerLink, "adm-informer-footer-collapsed");

		return false;
	},

	HideExtra: function()
	{
		var informer = BX("admin-informer");
		var hided = 0;

		for(var i=BX.adminInformer.itemsShow+1; i<informer.children.length; i++)
		{
			if (BX.hasClass(informer.children[i], "adm-informer-item") && informer.children[i].style.display == "block") {
				informer.children[i].style.display = "none";
				hided++;
			}
		}

		var footerLink = BX("adm-informer-footer");

		var linkText = BX.message('JSADM_AI_ALL_NOTIF')+" ("+(BX.adminInformer.itemsShow+parseInt(hided))+")";

		if(footerLink.textContent !== undefined)
			footerLink.textContent = linkText;
		else
			footerLink.innerText = linkText;

		BX.addClass(footerLink, "adm-informer-footer-collapsed");

		return false;
	},

	Show: function(informer)
	{
		var notifButton = BX("adm-header-notif-block");
		if (notifButton)
			BX.addClass(notifButton, "adm-header-notif-block-active");

		BX.onCustomEvent(informer, 'onBeforeAdminInformerShow');
		setTimeout(
			BX.proxy(function() {
					BX.bind(document, "click", BX.proxy(BX.adminInformer.Close, BX.adminInformer));
				},
				BX.adminInformer
			),0
		);
		BX.addClass(informer, "adm-informer-active");
		setTimeout(function() {BX.addClass(informer, "adm-informer-animate");},0);
	},

	Hide: function(informer)
	{
		var notifButton = BX("adm-header-notif-block");
		if (notifButton)
			BX.removeClass(notifButton, "adm-header-notif-block-active");

		BX.unbind(document, "click", BX.proxy(BX.adminInformer.Close, BX.adminInformer));

		BX.removeClass(informer, "adm-informer-animate");

		if (this.IsAnimationSupported())
			setTimeout(function() {BX.removeClass(informer, "adm-informer-active");}, 300);
		else
			BX.removeClass(informer, "adm-informer-active");

		BX.onCustomEvent(informer, 'onAdminInformerHide');
		//setTimeout(function() {BX.adminInformer.HideExtra();},500);
	},

	IsAnimationSupported : function()
	{
		var d = document.body || document.documentElement;
		if (typeof(d.style.transition) == "string")
			return true;
		else if (typeof(d.style.MozTransition) == "string")
			return true;
		else if (typeof(d.style.OTransition) == "string")
			return true;
		else if (typeof(d.style.WebkitTransition) == "string")
			return true;
		else if (typeof(d.style.msTransition) == "string")
			return true;

		return false;
	},


	SetItemHtml: function(itemIdx, html)
	{
		var itemHtmlDiv = BX("adm-informer-item-html-"+itemIdx);

		if(!itemHtmlDiv)
			return false;

		itemHtmlDiv.innerHTML = html;

		return true;
	},

	SetItemFooter: function(itemIdx, html)
	{
		var itemFooterDiv = BX("adm-informer-item-footer-"+itemIdx);

		if(!itemFooterDiv)
			return false;

		itemFooterDiv.innerHTML = html;

		if(html)
			itemFooterDiv.style.display = "block";
		else
			itemFooterDiv.style.display = "none";

		return true;
	}

};

})(window);

/* End */
;
; /* Start:/bitrix/js/fileman/sticker.js*/
function BXSticker(Params, Stickers, MESS)
{
	this.MESS = MESS;
	this.Stickers = Stickers || [];
	this.Params = Params;
	this.sessid_get = Params.sessid_get;
	this.bShowStickers = Params.bShowStickers;
	this.curEditorStickerInd = false;
	this.oneGifSrc = '/bitrix/images/1.gif';
	this.colorSchemes = [
		{name: 'bxst-yellow', color: '#FFFCB3', title: this.MESS.Yellow},
		{name: 'bxst-green', color: '#DBFCCD', title: this.MESS.Green},
		{name: 'bxst-blue', color: '#DCE7F7', title: this.MESS.Blue},
		{name: 'bxst-red', color: '#FCDFDF', title: this.MESS.Red},
		{name: 'bxst-purple', color: '#F6DAF8', title: this.MESS.Purple},
		{name: 'bxst-gray', color: '#F5F5F5', title: this.MESS.Gray}
	];

	this.curPageCount = this.Params.curPageCount;

	// Init hotkeys
	if (this.Params.useHotkeys)
		BX.bind(document, 'keyup', BX.proxy(this.OnKeyUp, this));

	// Object contains result from ajax requests
	window.__bxst_result = {};

	if (Params.bShowStickers)
		this.Init(Params);
}

BXSticker.prototype = {
	Init: function(Params)
	{
		this.oMarkerConfig = {
			attr: {
				title : true,
				src : true,
				href : true,
				alt : true,
				'class' : true,
				className : true,
				id : true,
				name : true,
				type : true,
				value : true
			},
			impAttr: {
				src : true,
				id : true,
				name : true,
				href : true
			}
		};

		this.Params.changeColorEffect = true;
		this.arStickers = [];
		this.posReg = {};
		this.bInited = true;
		this.access = this.Params.access;

		this._arSavedStickers = {};

		BX.bind(document, 'mousedown', BX.proxy(this.OnMousedown, this));
		var _this = this;
		BX.addCustomEvent('onMenuOpen', function(){
			var pEl = BX.findChild(BX('bxst-show-sticker-icon'), {className: 'icon'}, true);
			if (pEl)
			{
				if (_this.bShowStickers)
					BX.addClass(pEl, "checked");
				else
					BX.removeClass(pEl, "checked");
			}
			_this.UpdateStickersCount();
		});

		this.DisplayStickers(!!Params.bVisEffects);

		this.ShowEditor({ind: -1});
	},

	ShowAll: function(bShow, bAddStickers)
	{
		if (typeof bShow == 'undefined')
			bShow = !this.bShowStickers;

		var _this = this;
		var pEl = BX.findChild(BX('bxst-show-sticker-icon'), {className: 'icon'}, true);
		if (pEl)
		{
			if (bShow)
				BX.addClass(pEl, "checked");
			else
				BX.removeClass(pEl, "checked");
		}

		this.bShowStickers = bShow;
		window.__bxst_result.show = null;
		window.__bxst_result.stickers = null;

		this.Request(
			bShow ? 'show_stickers' : 'hide_stickers',
			{
				pageUrl : this.Params.pageUrl,
				b_inited : this.bInited ? "Y" : "N"
			},
			function(res)
			{
				if (_this.bInited)
					return;

				_this.bShowStickers = window.__bxst_result.show;
				if (window.__bxst_result.stickers)
				{
					_this.Stickers = window.__bxst_result.stickers;
					_this.Params.bVisEffects = true;
					if (!_this.bInited)
						_this.Init(_this.Params);

					if (bAddStickers)
						_this.AddSticker();
				}
			}
		);

		if (!bShow)
		{
			this.HideAll();
		}
		else if(bShow && this.bInited)
		{
			var oSt;
			for (var i = 0, l = this.arStickers.length; i < l; i++)
			{
				oSt = this.arStickers[i];
				oSt.pWin.Get().style.display = "block";
				oSt.pShadow.style.display = "block";

				//Hide marker if it exist
				if (oSt.pMarker)
					oSt.pMarker.style.display = "";
			}
		}
	},

	HideAll: function()
	{
		var oSt;
		for (var i = 0, l = this.arStickers.length; i < l; i++)
		{
			oSt = this.arStickers[i];
			oSt.pWin.Get().style.display = "none";
			oSt.pShadow.style.display = "none";

			//Hide marker if it exist
			//if (oSt.pMarkerNode)
			//	BX.removeClass(oSt.pMarkerNode, 'bxst-sicked');
			if (oSt.pMarker)
				oSt.pMarker.style.display = "none";
		}
	},

	AddSticker: function(Sticker, bVisEffects, bShowEditor)
	{
		if (!this.bInited)
			return this.ShowAll(true, true);

		if(!this.bShowStickers && this.bInited)
			this.ShowAll(true, false);

		if (this.curEditorStickerInd !== false) // If we press add sticker hot key in the
		{
			var _this = this;
			this.SaveAndCloseEditor(this.curEditorStickerInd, true, true);
			return setTimeout(function(){_this.AddSticker(Sticker, bVisEffects, bShowEditor);}, 300);
		}

		var oSticker;
		if (Sticker)
		{
			oSticker = this.ConvertStickerObj(Sticker);
		}
		else
		{
			oSticker = {
				bNew: true,
				personal: false,
				colorInd: parseInt(this.Params.start_color),
				width: parseInt(this.Params.start_width),
				height: parseInt(this.Params.start_height),
				collapsed: false,
				completed: false,
				info: "&nbsp;"
			};
		}

		var ind = this.CreateWindow(oSticker, !!bVisEffects, bShowEditor);

		if (oSticker.bNew)
			this.SetMarker(ind, 'area');
	},

	CreateWindow: function(oSticker, bVisEffects, bShowEditor)
	{
		// Init common window object with basic functionality
		var pWin = new BX.CWindow(false, 'float');
		pWin.Show(true); // Show window
		pWin.Get().style.zIndex = pWin.zIndex = this.Params.zIndex;

		// Set resize limits
		pWin.SETTINGS.min_width = this.Params.min_width;
		pWin.SETTINGS.min_height = this.Params.min_height;
		BX.addClass(pWin.Get(), 'bx-sticker');
		pWin.DenyClose();

		var
			bReadonly = this.access == 'R',
			bNew = !!oSticker.bNew,
			_this = this,
			pTypeCont,
			ind = this.arStickers.length,// Index of element in arStickers array
			pHead = pWin.Get().appendChild(BX.create("DIV", {props: {className: 'bxst-header', id: 'bxst_head_' + ind}})),
			pIdsCont = pHead.appendChild(BX.create("DIV", {props: {className: 'bxst-id-cont bxst-title'}, html: oSticker.id > 0 ? '<a href="' + this.Params.pageUrl + "?show_sticker=" + oSticker.id + '"><span>' + oSticker.id + '</span></a>' : ''})),
			pCheckCont = pHead.appendChild(BX.create("DIV", {props: {className: 'bxst-check-cont'}})),
			pCheck = pCheckCont.appendChild(BX.create("INPUT", {props: {id: 'bxst_conplited_' + ind, name: 'bxst_conplited_' + ind, type: "checkbox", value: "Y", title: this.MESS.Complete}})),
			pCheckLabel = pCheckCont.appendChild(BX.create("LABEL", {attrs: {'for' : 'bxst_conplited_' + ind, title: this.MESS.Complete}, text: this.MESS.CompleteLabel})),
			pCollapsedTitle = pHead.appendChild(BX.create("DIV", {props: {id: 'bxst_col_title_' + ind, className: 'bxst-col-title-cont', title: this.MESS.UnCollapseTitle}})),
			pCloseBut = pHead.appendChild(BX.create("DIV", {props: {className: 'bxst-close bxst-but', title: this.MESS.Close}})).appendChild(BX.create("IMG", {props: {id: 'bxst_close_' + ind, src: this.oneGifSrc, className: 'bxst-sprite'}})),
			pCollapseBut = pHead.appendChild(BX.create("DIV", {props: {className: 'bxst-collapse bxst-but'}})).appendChild(BX.create("IMG", {props: {id: 'bxst_collapse_' + ind, src: this.oneGifSrc, className: 'bxst-sprite', title: this.MESS.Collapse}}));

		if (bNew || this.Params.curUserId == oSticker.authorId)
		{
			pTypeCont = pHead.appendChild(BX.create("DIV", {props: {id: 'bxst_type_' + ind, className: 'bxst-type-cont'}}));
			// Create type selector personal-public
			pTypeCont.appendChild(BX.create("DIV", {props: {className: 'bxst-type-l bxst-type-corn'}}));
			pTypeCont.appendChild(BX.create("DIV", {props: {className: 'bxst-type-c bxst-type-c-publ'}})).appendChild(BX.create("SPAN", {props: {}, text: this.MESS.Public}));
			pTypeCont.appendChild(BX.create("DIV", {props: {className: 'bxst-type-c  bxst-type-c-pers'}})).appendChild(BX.create("SPAN", {props: {}, text: this.MESS.Personal}));
			pTypeCont.appendChild(BX.create("DIV", {props: {className: 'bxst-type-r bxst-type-corn'}}));

			if (!bReadonly)
				pTypeCont.onclick = function(){if(!pWin.__stWasDragged){_this.SetType(parseInt(this.id.substr('bxst_type_'.length)), true);}};

			this.SetUnselectable([pTypeCont]);
		}

		var pBody = pWin.Get().appendChild(BX.create("DIV", {props: {id: 'bxst_body_' + ind, className: 'bxst-content'}}));
		var pContentArea = pBody.appendChild(BX.create("DIV", {props: {id: 'bxst_content_' + ind, className: 'bxst-content-area'}}));

		var
			pFoot = pWin.Get().appendChild(BX.create("DIV", {props: {className: 'bxst-footer'}})),
			pMarkerAreaBut = pFoot.appendChild(BX.create("DIV", {props: {className: 'bxst-marker-area-but'}})).appendChild(BX.create("IMG", {props: {id: 'bxst_marker_but0_' + ind, src: this.oneGifSrc, className: 'bxst-sprite', title: this.MESS.SetMarkerArea}})),
			pMarkerElementBut = pFoot.appendChild(BX.create("DIV", {props: {className: 'bxst-marker-elem-but'}})).appendChild(BX.create("IMG", {props: {id: 'bxst_marker_but1_' + ind, src: this.oneGifSrc, className: 'bxst-sprite', title: this.MESS.SetMarkerEl}})),
			pColorBut = pFoot.appendChild(BX.create("DIV", {props: {className: 'bxst-ctrl-txt bxst-color-but'}})).appendChild(BX.create("SPAN", {props: {id: 'bxst_color_' + ind}, text: this.MESS.Color})),
			pAddBut = pFoot.appendChild(BX.create("DIV", {props: {className: 'bxst-ctrl-txt bxst-add-but'}})).appendChild(BX.create("SPAN", {props: {id: 'bxst_add_but_' + ind}, text: this.MESS.Add})),

			pResizer = pFoot.appendChild(BX.create("DIV", {props: {className: 'bxst-resizer'}})).appendChild(BX.create("IMG", {props: {src: this.oneGifSrc, className: 'bxst-sprite'}}));

		var pInfo = pFoot.appendChild(BX.create("DIV", {props: {className: 'bxst-info-icon'}})).appendChild(BX.create("IMG", {props: {id: 'bxst_info_' + ind, src: this.oneGifSrc, className: 'bxst-sprite'}, style: {display: bNew ? 'none' : 'block'}}));
		var pHint = new BX.CHintSimple({parent: pInfo, hint: oSticker.info});

		if (bReadonly)
			BX.addClass(pWin.Get(), 'bx-sticker-readonly');

		// Adjust position to the center of the window.
		var windowSize = BX.GetWindowInnerSize();
		var windowScroll = BX.GetWindowScrollPos();

		if (bNew || oSticker.left <= 0 || oSticker.top <= 0)
		{
			oSticker.left = pWin.Get().style.left = parseInt(windowScroll.scrollLeft + windowSize.innerWidth / 2 - parseInt(pWin.Get().offsetWidth) / 2) + Math.round(oSticker.width / 2);
			oSticker.top = Math.max(parseInt(windowScroll.scrollTop + windowSize.innerHeight / 2 - parseInt(pWin.Get().offsetHeight) / 2), 0) - Math.round(oSticker.height / 2);
		}

		pWin.StickerInd = ind;

		if (bNew)
			pAddBut.style.display = 'none';

		// Create shadow
		pShadow = document.body.appendChild(BX.create("DIV", {props: {className: 'bxst-shadow'}, style: {zIndex: parseInt(pWin.Get().style.zIndex) - 5}}));

		this.RegisterSticker({
			obj: oSticker,
			pWin: pWin,
			pCheck: pCheck,
			pCloseBut: pCloseBut,
			pCollapseBut: pCollapseBut,
			pCollapsedTitle: pCollapsedTitle,
			pBody: pBody,
			pHead: pHead,
			pTypeCont: pTypeCont || false,
			pContentArea: pContentArea,
			pIdsCont: pIdsCont,
			pShadow: pShadow,
			bButPanelShowed: true,
			pMarkerAreaBut: pMarkerAreaBut,
			pMarkerElementBut: pMarkerElementBut,
			pColorBut: pColorBut,
			pAddBut: pAddBut,
			pInfo: pInfo,
			pHint: pHint,
			_over: !bNew && !bShowEditor,
			bButPanelShowed: !bNew && !bShowEditor
		});

		this.AdjustToSize(ind, oSticker.width, oSticker.height);
		this.SetColorScheme(ind, oSticker.colorInd, false);
		this.SetType(ind, false, oSticker.personal ? 'personal' : 'public');
		this.SetCompleted(ind, oSticker.completed, false);
		this.CollapseSticker(ind, false, oSticker.collapsed);

		pWin.SetDraggable(pHead);
		BX.addCustomEvent(pWin, 'onWindowDragStart', function(){this.__stWasDragged = true;});
		BX.addCustomEvent(pWin, 'onWindowDragFinished', function(){_this.OnDragEnd(this);});
		BX.addCustomEvent(pWin, 'onWindowDrag', function(){_this.OnDragDrop(this);});

		// Set and config resizer
		pWin.SetResize(pResizer);
		BX.addCustomEvent(pWin, 'onWindowResize', function(){_this.AdjustToSize(this.StickerInd);});
		BX.addCustomEvent(pWin, 'onWindowResizeStart', function(){_this.OnResizeStart(this);});
		BX.addCustomEvent(pWin, 'onWindowResizeFinished', function(){_this.OnResizeEnd(this);});

		// Control events
		pHead.ondblclick = function(){_this.CollapseSticker(parseInt(this.id.substr('bxst_head_'.length)), true);}
		pCollapseBut.onclick = function(){if(!pWin.__stWasDragged){_this.CollapseSticker(parseInt(this.id.substr('bxst_collapse_'.length)), true);}};

		if (!bReadonly)
		{
			// Control events
			pCloseBut.onclick = function(){if(!pWin.__stWasDragged){_this.CloseSticker(parseInt(this.id.substr('bxst_close_'.length)), true);}};
			//pTypeCont.onclick = function(){if(!pWin.__stWasDragged){_this.SetType(parseInt(this.id.substr('bxst_type_'.length)), true);}};
			pAddBut.onclick = function(){_this.AddToSticker(parseInt(this.id.substr('bxst_add_but_'.length)));};
			pCheck.onclick = function(){if(!pWin.__stWasDragged){_this.SetCompleted(parseInt(this.id.substr('bxst_conplited_'.length)), !!this.checked, true);}};
			pColorBut.onclick = function(){_this.ShowColorSelector(parseInt(this.id.substr('bxst_color_'.length)));};

			pMarkerAreaBut.onclick = function(){_this.SetMarker(parseInt(this.id.substr('bxst_marker_but0_'.length)), 'area');};
			pMarkerElementBut.onclick = function(){_this.SetMarker(parseInt(this.id.substr('bxst_marker_but1_'.length)),  'element');};
		}
		else
		{
			pCheck.disabled = true;
		}

		// Hide Buttons Panel instead of calling ShowButtonsPanel method
		if (!bNew && !bShowEditor && !oSticker.collapsed)
			pWin.Get().style.height = (oSticker.height - 24) + "px";

		if (bNew)
		{
			var pos = this.GetSuitablePosition(oSticker.left, oSticker.top);
			if (pos !== true)
			{
				oSticker.left = pos.left;
				oSticker.top = pos.top;
			}
		}
		else
		{
			pIdsCont.style.display = "block";
		}
		this.RegisterPosition(oSticker.left, oSticker.top);

		// Set start position
		pWin.Get().style.left = oSticker.left + 'px';
		pWin.Get().style.top = oSticker.top + 'px';

		this.SupaFlySticker(ind);
		this.AdjustShadow(ind);

		// Set unselectable elements
		this.SetUnselectable([pCloseBut, pCollapseBut, pColorBut, pMarkerAreaBut, pMarkerAreaBut, pResizer]);

		if (bNew || bShowEditor === true)
		{
			this.ShowEditor({ind: ind});

			if (bShowEditor)
			{
				this.OnDivMouseOver(ind, true);
				this.DisplayMarker(ind);
			}
		}
		else
		{
			pBody.style.overflow = 'auto';
			pContentArea.innerHTML = oSticker.html_content;
			//this.ShowButtonsPanel(ind, false, false);
			this.DisplayMarker(ind);

			if (oSticker.id == this.Params.focusOnSticker)
			{
				window.scrollTo(0, oSticker.top > 200 ? oSticker.top - 200 : 0);
				this.Hightlight(ind, true);
				this.BlinkRed(ind);
			}
		}


		if (!bReadonly)
		{
			pBody.onclick = function()
			{
				if (!this.id)
					return;
				var ind = parseInt(this.id.substr('bxst_body_'.length));
				if (_this.curEditorStickerInd !== ind)
					_this.ShowEditor({ind: ind});
			};
		}

		// Hide and show buttons panel
		pWin.Get().onmouseover = function(){_this.OnDivMouseOver(ind, true);};
		pWin.Get().onmouseout = function(){_this.OnDivMouseOver(ind, false);};

		return ind;
	},

	UpdateNewSticker: function(ind)
	{
		var oSt = this.arStickers[ind];
		oSt.pAddBut.style.display = 'block';
		oSt.pInfo.style.display = 'block';
		oSt.pIdsCont.style.display = "block";
		oSt.pIdsCont.innerHTML = '<a href="' + this.Params.pageUrl + "?show_sticker=" + oSt.obj.id + '"><span>' + oSt.obj.id + '</span></a>';

		if (ind === this.curEditorStickerInd && typeof window.oLHESticker == 'object')
		{
			setTimeout(function(){oLHESticker.SetFocusToEnd();}, 100);
			setTimeout(function(){oLHESticker.SetFocusToEnd();}, 500);
		}
	},

	RegisterPosition: function(l, t)
	{
		var
			d = 20,
			l1 = Math.round(l / d) * d,
			t1 = Math.round(t / d) * d;

		this.posReg[l1 + "_" + t1] = true;
	},

	GetSuitablePosition: function(l, t, bAdjust)
	{
		var
			d = 20,
			l1 = Math.round(l / d) * d,
			t1 = Math.round(t / d) * d;

		if (this.posReg[l1 + "_" + t1])
			return this.GetSuitablePosition(l + d, t + d, true);
		else if (bAdjust)
			return {left: l, top: t};

		return true;
	},

	RegisterSticker: function(oSt)
	{
		this.arStickers.push(oSt);
		return this.arStickers.length - 1;
	},

	AdjustToSize: function(ind, w, h)
	{
		var contHeight, oSt = this.arStickers[ind];
		if (typeof w == 'undefined' || typeof h == 'undefined')
		{
			w = parseInt(oSt.pWin.Get().style.width);
			h = parseInt(oSt.pWin.Get().style.height);
		}
		else
		{
			oSt.pWin.Get().style.width = w + "px";
			oSt.pWin.Get().style.height = h + "px";
		}

		if (BX.browser.IsIE() && !BX.browser.IsDoctype())
			contHeight = h - 19 /* header section */ - 27 /* footer section */ - 0;
		else
			contHeight = h - 19 /* header section */ - 24 /* footer section */ - 0;

		if (window.oLHESticker)
		{
			window.oLHESticker.pFrame.style.width = (w - 2)+ "px";
			window.oLHESticker.pFrame.style.height = (contHeight - 2) + "px";
			window.oLHESticker.ResizeFrame(contHeight - 2);
		}

		oSt.pCollapsedTitle.style.width = (w - 100) + "px";
		oSt.pBody.style.height = contHeight + "px";

		this.AdjustShadow(ind);
	},

	AdjustShadow: function(ind)
	{
		var oSt = this.arStickers[ind];

		if (oSt.obj.closed && oSt.pShadow.parentNode)
			return oSt.pShadow.parentNode.removeChild(oSt.pShadow);

		oSt.pShadow.style.top = (parseInt(oSt.pWin.Get().style.top) + 4) + "px";
		oSt.pShadow.style.left = (parseInt(oSt.pWin.Get().style.left) + 3) + "px";
		oSt.pShadow.style.width = oSt.pWin.Get().style.width;
		oSt.pShadow.style.height = oSt.pWin.Get().style.height;
	},

	AdjustEditorSizeAndPos: function(ind)
	{
		var oSt = this.arStickers[ind];
		this.pEditorCont.style.top = (parseInt(oSt.pWin.Get().style.top) + 20) + "px";
		this.pEditorCont.style.left = oSt.pWin.Get().style.left;
		this.pEditorCont.style.width = oSt.pWin.Get().style.width;
		this.pEditorCont.style.height = oSt.pBody.style.height;
		this.pEditorCont.style.zIndex = parseInt(oSt.pWin.Get().style.zIndex) + 10;
	},

	AdjustHintToCursor: function(pHint, e)
	{
		pHint.style.left = (e.realX + 30) + "px";
		pHint.style.top = (e.realY - 12) + "px";
	},

	AdjustScrollPosToCursor: function()
	{
	},

	AdjustStickerToArea: function(ind)
	{
		var
			x, y,
			size = BX.GetWindowInnerSize(document),
			scroll = BX.GetWindowScrollPos(document),
			oSt = this.arStickers[ind],
			deltaH = (oSt.obj.marker && oSt.obj.marker.adjust) ? 0 : 10;

		if (oSt.pMarker && oSt.obj.marker)
		{
			x = oSt.obj.marker.left + oSt.obj.marker.width - 60;
			y = oSt.obj.marker.top - oSt.obj.height + deltaH;

			if (x + oSt.obj.width > size.innerWidth)
				x = size.innerWidth - oSt.obj.width - 30;

			if (y < scroll.scrollTop + 50)
				y = oSt.obj.marker.top + oSt.obj.marker.height - deltaH;
		}

		this.MoveToPos(ind, {left: x, top: y});
		oSt.obj.top = y;
		oSt.obj.left = x;

		if (this.arStickers[ind].obj.id)
			this.SaveSticker(ind);
	},

	MoveToPos: function(ind, resPos)
	{
		var oSt = this.arStickers[ind];
		var
			startTop = parseInt(oSt.obj.top),
			startLeft = parseInt(oSt.obj.left),
			endTop = parseInt(resPos.top),
			endLeft = parseInt(resPos.left),
			curTop = parseInt(startTop),
			curLeft = parseInt(startLeft),

			_this = this,
			count = 0,
			bUp = startTop > endTop,
			bLeft = startLeft > endLeft,
			time = BX.browser.IsIE() ? 10 : 10,
			d = BX.browser.IsIE() ? 10 : 10,
			d1 = Math.ceil(Math.abs((startLeft - endLeft) / 50)),
			d2 = Math.ceil(Math.abs((startTop - endTop) / 50)),
			dx = bLeft ? -d1 : d1,
			dy = bUp ? -d2 : d2;

		var SetPos = function(t, l)
		{
			if (t !== false)
				oSt.pWin.Get().style.top = t + "px";
			if (l !== false)
				oSt.pWin.Get().style.left = l + "px";
			_this.AdjustShadow(ind);
		};

		var Interval = setInterval(function()
			{
				if (endTop != curTop && curTop !== false)
					curTop += Math.round(dy * count / 2);
				if (endLeft != curLeft && curLeft !== false)
					curLeft += Math.round(dx * count / 2);

				if (curTop !== false && (!bUp && curTop >= endTop || bUp && curTop <= endTop))
					curTop = endTop;

				if (curLeft !== false && (!bLeft && curLeft >= endLeft || bLeft && curLeft <= endLeft))
					curLeft = endLeft;

				SetPos(curTop, curLeft);

				if (curTop == endTop)
					curTop = false;

				if (curLeft == endLeft)
					curLeft = false;

				if (curTop === false && curLeft === false)
				{
					clearInterval(Interval);
					return _this.OnDragEnd(oSt.pWin);
				}
				count++;
			},
			time
		);
	},

	ChangeColor: function(ind, colorInd, bEffect, bFadeIn)
	{
		var oSt = this.arStickers[ind];
		if (!this.Params.changeColorEffect)
			bEffect = false;

		if (bEffect && bFadeIn === true)
		{
			this.Params.start_color = colorInd;
			return this.ShowColorOverlay(ind, colorInd, true);
		}
		else if((bEffect && bFadeIn === false) || !bEffect)
		{
			this.SetColorScheme(ind, colorInd, true);
			if (bEffect)
				return this.ShowColorOverlay(ind, colorInd, false);
		}
	},

	SetColorScheme: function(ind, colorInd, bSave)
	{
		// If we have editor
		if (ind === this.curEditorStickerInd && typeof window.oLHESticker == 'object')
		{
			if (window.oLHESticker.pEditorDocument && window.oLHESticker.pEditorDocument.body)
				window.oLHESticker.pEditorDocument.body.className = this.colorSchemes[colorInd].name;
		}

		this.arStickers[ind].obj.colorInd = colorInd;
		for (var i = 0, l = this.colorSchemes.length; i < l; i++)
		{
			if (i == colorInd)
				BX.addClass(this.arStickers[ind].pWin.Get(), this.colorSchemes[i].name);
			else
				BX.removeClass(this.arStickers[ind].pWin.Get(), this.colorSchemes[i].name);
		}

		if (this.arStickers[ind].pMarker)
			this.arStickers[ind].pMarker.className = 'bxst-sticker-marker ' + this.colorSchemes[colorInd].name;

		if (bSave && this.arStickers[ind].obj.id > 0)
		{
			var _this = this;
			if (this.arStickers[ind]._colTimeout)
			{
				clearTimeout(this.arStickers[ind]._colTimeout);
				this.arStickers[ind]._colTimeout = null;
			}

			// Save color with some delay for fast clicking colot controll
			// this.arStickers[ind]._colTimeout = setTimeout(function()
			// {
				//_this.arStickers[ind]._colTimeout = null;
				_this.SaveSticker(ind);
			//}, 800);
		}
	},

	SetType: function(ind, bSave, type)
	{
		var
			oSt = this.arStickers[ind],
			bPersonal = (typeof type == 'undefined') ? !oSt.obj.personal : type == 'personal';

		if (!oSt.pTypeCont)
			return;

		if (bPersonal)
		{
			BX.addClass(oSt.pTypeCont, 'bxst-type-pers');
			BX.removeClass(oSt.pTypeCont, 'bxst-type-publ');
			oSt.pTypeCont.title = this.MESS.PersonalTitle;
		}
		else
		{
			BX.addClass(oSt.pTypeCont, 'bxst-type-publ');
			BX.removeClass(oSt.pTypeCont, 'bxst-type-pers');
			oSt.pTypeCont.title = this.MESS.PublicTitle;
		}
		oSt.obj.personal = bPersonal;

		if (oSt.obj.id && bSave) // Sticker already created - we change type and save it
			this.SaveSticker(ind);
	},

	SetCompleted: function(ind, bChecked, bSave)
	{
		this.arStickers[ind].obj.completed = bChecked;
		this.arStickers[ind].pCheck.checked = bChecked;

		if (bChecked)
		{
			//BX.addClass(this.arStickers[ind].pWin.Get(), "bxst-completed");
			//this.arStickers[ind].pShadow.style.display = 'none';
		}
		else
		{
			//BX.removeClass(this.arStickers[ind].pWin.Get(), "bxst-completed");
			//this.arStickers[ind].pShadow.style.display = 'block';
		}

		if (this.arStickers[ind].obj.id && bSave)
			this.SaveSticker(ind);
	},

	CloseSticker: function(ind, bSave, bClose)
	{
		var oSt = this.arStickers[ind];
		if (bSave && oSt.obj.authorName && this.Params.curUserId != oSt.obj.authorId && !confirm(this.MESS.CloseConfirm.replace("#USER_NAME#", oSt.obj.authorName)))
			return;

		oSt.obj.closed = !oSt.obj.closed;

		if (ind === this.curEditorStickerInd)
			this.curEditorStickerInd = false;

		this.arStickers[ind].pWin.Close(true);
		this.arStickers[ind].pWin.onUnRegister(true);

		//Hide marker if it exist
		if (oSt.pMarkerNode)
			BX.removeClass(oSt.pMarkerNode, 'bxst-sicked');
		if (oSt.pMarker && oSt.pMarker.parentNode)
			oSt.pMarker.parentNode.removeChild(oSt.pMarker);

		this.AdjustShadow(ind);

		if (this.arStickers[ind].obj.id && bSave)
		{
			this.SaveSticker(ind);
			BX.admin.panel.Notify(this.MESS.CloseNotify.replace(/(.*?)#LINK#(.*?)#LINK#/ig, "$1<span class=\"bxst-close-notify-link\" onclick=\"window.oBXSticker.ShowList(\'current\'); return false;\">$2</span>"));
		}

		var a = document.body.getElementsByTagName('A');
		if (a && a[0])
			BX.focus(a[0]);
	},

	CollapseSticker: function(ind, bSave, bCollapse)
	{
		var oSt = this.arStickers[ind];

		if (typeof bCollapse == 'undefined')
			bCollapse = !oSt.obj.collapsed;

		if (bSave && this.curEditorStickerInd === ind)
			this.SaveAndCloseEditor(ind, true, false);

		if (bCollapse)
		{
			BX.addClass(oSt.pWin.Get(), "bxst-collapsed");
			oSt.pCollapseBut.title = this.MESS.UnCollapse;
			oSt.pWin.Get().style.height = '19px';
			oSt.pCollapsedTitle.innerHTML = this.GetCollapsedContent(oSt.obj.html_content);
		}
		else
		{
			BX.removeClass(oSt.pWin.Get(), "bxst-collapsed");
			oSt.pCollapseBut.title = this.MESS.Collapse;
			oSt.pWin.Get().style.height = parseInt(oSt.obj.height) + 'px';
		}

		this.AdjustShadow(ind);

		oSt.obj.collapsed = bCollapse;

		if (oSt.obj.id && bSave)
			this.SaveSticker(ind);
	},

	OnDragEnd: function(pWin)
	{
		setTimeout(function(){pWin.__stWasDragged = false;}, 200);
		var ind = pWin.StickerInd;

		this.arStickers[ind].obj.top = parseInt(pWin.Get().style.top);
		this.arStickers[ind].obj.left = parseInt(pWin.Get().style.left);

		this.SaveSticker(ind);
	},

	OnDragDrop: function(pWin)
	{
		this.AdjustShadow(pWin.StickerInd);
	},

	OnResizeEnd: function(pWin)
	{
		var ind = pWin.StickerInd;
		this.arStickers[ind].bResizingNow = false;
		this.arStickers[ind].obj.width = parseInt(pWin.Get().style.width);
		this.arStickers[ind].obj.height = parseInt(pWin.Get().style.height);

		if (this.arStickers[ind].obj.id)
			this.SaveSticker(ind);
	},

	OnResizeStart: function(pWin)
	{
		this.arStickers[pWin.StickerInd].bResizingNow = true;
	},

	ShowEditor: function(Params)
	{
		var
			bPreload = Params.ind === -1,
			_this = this,
			oSt = this.arStickers[Params.ind];

		// Create if it's necessary and move to the current sticker window
		// (We have one editor and simply append it to different sticker windows)
		if (!this.pEditorCont)
			this.pEditorCont = (bPreload ? document.body : oSt.pBody).appendChild(BX.create("DIV", {props: {className: 'bxst-lhe-cont'}}));

		this.pEditorCont.style.visibility = 'hidden';

		// Editor already loaded
		if (window.oLHESticker)
		{
			if (this.bLoadLHEEditor) // Fist init
			{
				this.PrepareEditorAfterLoading();
				this.bLoadLHEEditor = false;
			}

			if (!bPreload)
				this.DisplayEditor(oSt, Params.ind);
		}
		else if(!this.bLoadLHEEditor) // Init loading
		{
			this.Request('load_lhe', {}, function(res)
			{
				_this.pEditorCont.innerHTML = res;
				var interval = setInterval(function() // Timeout for DOM rendering
				{
					if (typeof window.LoadLHE_LHEBxStickers == 'undefined')
						return;

					clearInterval(interval);

					if (!_this.bLoadLHEEditor && !window.oLHESticker)
						LoadLHE_LHEBxStickers();

					return setTimeout(function()
					{
						_this.bLoadLHEEditor = true;
						_this.ShowEditor(Params);
					}, 50);
				}, 50);
			});
		}
		else if (_this.bLoadLHEEditor && !window.oLHESticker) // Waiting for loading complete
		{
			return setTimeout(function(){_this.ShowEditor(Params);}, 50);
		}
	},

	PrepareEditorAfterLoading: function()
	{
		if (!oLHESticker)
			return;

		oLHESticker.oSpecialParsers['st_title'] = {
			Parse: function(sName, sContent, pLEditor)
			{
				sContent = sContent.replace(/\[ST_TITLE\]((?:\s|\S)*?)\[\/ST_TITLE\]/ig, '<span id="'+ pLEditor.SetBxTag(false, {tag: "st_title"}) + '" class="bxst-title" >$1</span>');
				return sContent;
			},
			UnParse: function(bxTag, pNode, pLEditor)
			{
				var res = "[ST_TITLE]";
				for(i = 0; i < pNode.arNodes.length; i++)
					res += pLEditor._RecursiveGetHTML(pNode.arNodes[i]);
				res += "[/ST_TITLE]";
				return res;
			}
		};

		BX.addCustomEvent(oLHESticker, "OnUnParseContentAfter", function()
		{
			this.__sContent = this.__sContent.replace(/\[\/ST_TITLE\](?:\n|\r)+/ig, "[/ST_TITLE]\n");
		});
	},

	DisplayEditor: function(oSt, ind, bJustDisplay)
	{
		var _this = this;

		if (!bJustDisplay)
		{
			// Append editor
			oSt.pBody.appendChild(this.pEditorCont);
			this.AdjustToSize(ind);
			oLHESticker.SetContent(oSt.obj.content || (this.GetNewStickerContent() + "\n"));
			oLHESticker.CreateFrame(); // We need to recreate editable frame after reappending editor container
			oLHESticker.SetEditorContent(oLHESticker.content);
			window.oLHESticker.pEditorDocument.body.className = this.colorSchemes[oSt.obj.colorInd].name;

			if (this.Params.useHotkeys)
				BX.bind(window.oLHESticker.pEditorDocument, 'keyup', BX.proxy(this.OnKeyUp, this));

			setTimeout(function(){try{window.oLHESticker.pEditorDocument.execCommand("styleWithCSS", false, false);}catch(e){}}, 100);
			setTimeout(function(){try{window.oLHESticker.pEditorDocument.execCommand("styleWithCSS", false, false);}catch(e){}}, 500);
			setTimeout(function(){try{window.oLHESticker.pEditorDocument.execCommand("styleWithCSS", false, false);}catch(e){}}, 1000);

			this.curEditorStickerInd = ind;
			oSt.pBody.style.overflow = 'hidden';

			// Slow div motion for editor loading timeout
			var
				curTop = 0,
				d = 1,
				maxTop = 22;

			var movePanelInterval = setInterval(function()
			{
				if (curTop >= maxTop)
					curTop = maxTop;
				else
					curTop += d;

				oSt.pContentArea.style.top = curTop + "px";
				if (curTop == maxTop)
				{
					clearInterval(movePanelInterval);
					_this.DisplayEditor(oSt, ind, true);
				}
			}, BX.browser.IsIE() ? 5 : 10);
		}
		else
		{
			setTimeout(function()
			{
				oSt.pBody.style.overflow = 'auto';
				_this.pEditorCont.style.visibility = 'visible';
				oSt.pContentArea.style.display = 'none';
				_this.pEditorCont.style.display = 'block';

				setTimeout(function(){oLHESticker.SetFocusToEnd();}, 100);
			}, 100);
		}
	},

	AddToSticker: function(ind)
	{
		var oSt = this.arStickers[ind];
		if (this.curEditorStickerInd === ind && window.oLHESticker)
		{
			oLHESticker.SetFocusToEnd();
			oLHESticker.InsertHTML("<br />" + oLHESticker.ParseContent(this.GetNewStickerContent()) + "<br />");
			setTimeout(function(){oLHESticker.SetFocusToEnd();}, 100);
		}
		else
		{
			oSt.obj.content += "\n" + this.GetNewStickerContent();
			this.ShowEditor({ind: ind});
		}
	},

	Request : function(action, postParams, callBack, bShowWaitWin)
	{
		bShowWaitWin = bShowWaitWin === true;

		if (bShowWaitWin)
			BX.showWait();

		var actionUrl = '/bitrix/admin/fileman_stickers.php?sticker_action=' + action + "&" + this.sessid_get + '&site_id=' + this.Params.site_id;
		return BX.ajax.post(actionUrl, postParams || {},
			function(result)
			{
				if (bShowWaitWin)
					BX.closeWait();

				if(callBack)
					setTimeout(function(){callBack(result);}, 10);
			}
		);
	},

	SetUnselectable: function(arNodes)
	{
		if (typeof arNodes != 'object')
			arNodes = [arNodes];

		for (var i = 0, l = arNodes.length; i < l; i++)
		{
			BX.setUnselectable(arNodes[i]);
			arNodes[i].ondragstart = function (e){return BX.PreventDefault(e);};
		}
	},

	ShowColorOverlay: function(ind, colorInd, bFadeIn)
	{
		var
			_this = this,
			it = 0, interval,
			oSt = this.arStickers[ind];

		if (!this.pColorOverlay)
			this.pColorOverlay = document.body.appendChild(BX.create("DIV", {props: {className: 'bx-sticker-overlay'}}));

		this.pColorOverlay.style.zIndex = parseInt(oSt.pWin.Get().style.zIndex) + 10;
		this.pColorOverlay.style.top = oSt.pWin.Get().style.top;
		this.pColorOverlay.style.left = oSt.pWin.Get().style.left;
		this.pColorOverlay.style.width = oSt.pWin.Get().style.width;
		this.pColorOverlay.style.height = oSt.pWin.Get().style.height;

		interval = setInterval(function()
		{
			if (it > 2)
			{
				if (bFadeIn)
					_this.ChangeColor(ind, colorInd, true, false);
				else
					_this.pColorOverlay.className = 'bx-sticker-overlay';
				return clearInterval(interval);
			}

			if (bFadeIn)
				_this.pColorOverlay.className = 'bx-sticker-overlay bx-sticker-op-' + it;
			else
				_this.pColorOverlay.className = 'bx-sticker-overlay bx-sticker-op-' + (3 -it);

			it++;
		}, 20);
	},

	DisplayStickers: function(bVisEffects)
	{
		for (var i = 0, l = this.Stickers.length; i < l; i++)
			this.AddSticker(this.Stickers[i], bVisEffects);
	},

	MousePos: function (e)
	{
		if(window.event)
			e = window.event;

		if(e.pageX || e.pageY)
		{
			e.realX = e.pageX;
			e.realY = e.pageY;
		}
		else if(e.clientX || e.clientY)
		{
			e.realX = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
			e.realY = e.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
		}
		return e;
	},

	SaveAndCloseEditor: function(ind, bClose, bSaveSticker)
	{
		if (!window.oLHESticker || this.bLoadLHEEditor)
		{
			var _this = this;
			return setTimeout(function(){_this.SaveAndCloseEditor(ind, bClose);}, 100);
		}

		var oSt = this.arStickers[ind];
		oLHESticker.SaveContent();
		var content = oLHESticker.GetContent();
		var htmlContent = oLHESticker.ParseContent(content);

		oSt.obj.html_content = htmlContent;
		oSt.pContentArea.innerHTML = htmlContent;
		this.arStickers[ind].obj.content = content;

		if (bClose !== false)
		{
			oSt.pContentArea.style.display = 'block';
			this.pEditorCont.style.display = 'none';
			oSt.pContentArea.style.top = '0px';
			oSt.pBody.style.overflow = 'auto';
			this.curEditorStickerInd = false;
		}

		if (bSaveSticker !== false)
			this.SaveSticker(ind);
	},

	GetNewStickerContent: function()
	{
		var zeroInt = function(x)
		{
			x = parseInt(x);
			if (isNaN(x))
				x = 0;
			return x < 10 ? '0' + x.toString() : x.toString();
		}
		var oDate = new Date();
		var strDate = this.Params.strDate + " " + zeroInt(oDate.getHours()) + ':' + zeroInt(oDate.getMinutes());
		return "[ST_TITLE]" + BX.util.htmlspecialchars(this.Params.curUserName) + ' ' + strDate + "[/ST_TITLE]\n";
	},

	SaveSticker: function(ind)
	{
		if (this.access == 'R') // Readonly
			return;

		if (this.curEditorStickerInd === ind)
			this.SaveAndCloseEditor(ind, false, false);

		var oSt = this.arStickers[ind];
		var _this = this;
		var reqid = Math.round(Math.random() * 100000);
		window.__bxst_result[reqid] = false;

		if (typeof oSt.obj.content == 'undefined')
			oSt.obj.content = this.GetNewStickerContent() + "\n";

		if (oSt.obj.bNew)
		{
			if (this._arSavedStickers[ind]) // prevent double saving
				return;
			this._arSavedStickers[ind] = true;
		}

		this.Request('save_sticker',
			{
				reqid : reqid,
				id: oSt.obj.bNew ? 0 : oSt.obj.id,
				page_url: this.Params.pageUrl,
				page_title: this.Params.pageTitle,

				personal: oSt.obj.personal ? 'Y' : 'N',
				content: oSt.obj.content,

				width: oSt.obj.width,
				height: oSt.obj.height,
				top: oSt.obj.top,
				left: oSt.obj.left,
				color: oSt.obj.colorInd,

				collapsed: oSt.obj.collapsed ? 'Y' : 'N',
				completed: oSt.obj.completed ? 'Y' : 'N',
				closed: oSt.obj.closed ? 'Y' : 'N',

				marker: oSt.obj.marker
			},
			function()
			{
				if (window.__bxst_result[reqid])
				{
					var bNew = !!oSt.obj.bNew;
					_this.arStickers[ind].obj = _this.ConvertStickerObj(window.__bxst_result[reqid]);
					if (_this.arStickers[ind].pHint)
					{
						_this.arStickers[ind].pHint.HINT = _this.arStickers[ind].obj.info;
						if (_this.arStickers[ind].pHint.CONTENT_TEXT)
							_this.arStickers[ind].pHint.CONTENT_TEXT.innerHTML = _this.arStickers[ind].obj.info;
					}

					if (bNew)
					{
						_this.UpdateNewSticker(ind);

						if (!_this.arStickers[ind].obj.closed)
						{
							_this.curPageCount++;
							_this.UpdateStickersCount();
						}
					}
					else
					{
						if (_this.arStickers[ind].obj.closed)
						{
							_this.curPageCount--;
							_this.UpdateStickersCount();
						}
					}
				}
				window.__bxst_result[reqid] = null;
			}
		);
	},

	GetCollapsedContent: function(content)
	{
		var colContent = '';
		if (content.indexOf('bxst-title') != -1)
		{
			colContent = content.replace(/<span[^>]*?class="bxst-title"[^>]*?>((?:\s|\S)*?)<\/span>/ig, function(str, title)
			{
				if (title.indexOf(String.fromCharCode(160)) > 0)
					return '<span class="bxst-title">' + title.substr(0, title.indexOf(String.fromCharCode(160))) + "</span> ";
				return title;
			});

			colContent = colContent.replace(/<br( \/)?>/ig, ' ');
		}
		// else
		// {

		// }

		if (colContent != '')
			return colContent;

		return content;
	},

	ConvertStickerObj: function(Sticker)
	{
		return {
			bNew: false,
			id: parseInt(Sticker.ID),
			personal: Sticker.PERSONAL == 'Y',
			colorInd: Sticker.COLOR || 0,
			content: Sticker.CONTENT,
			html_content: Sticker.HTML_CONTENT,
			top: parseInt(Sticker.POS_TOP),
			left: parseInt(Sticker.POS_LEFT),
			width: parseInt(Sticker.WIDTH),
			height: parseInt(Sticker.HEIGHT),
			collapsed: Sticker.COLLAPSED == 'Y',
			completed: Sticker.COMPLETED == 'Y',
			closed: Sticker.CLOSED == 'Y',
			info: Sticker.INFO,
			authorName: Sticker.AUTHOR,
			authorId: Sticker.CREATED_BY,
			marker: (Sticker.MARKER_ADJUST || Sticker.MARKER_WIDTH || Sticker.MARKER_HEIGHT)  ?
				{
					top: parseInt(Sticker.MARKER_TOP),
					left: parseInt(Sticker.MARKER_LEFT),
					width: parseInt(Sticker.MARKER_WIDTH),
					height: parseInt(Sticker.MARKER_HEIGHT),
					adjust: Sticker.MARKER_ADJUST
				}
				: {}
		};
	},

	SetMarker: function(ind, mode)
	{
		var _this = this;
		var oSt = this.arStickers[ind];
		this.bHightlightElementMode = false;
		this.bSelectAreaMode = false;

		BX.removeClass(oSt.pMarkerElementBut, 'bxst-pressed');
		BX.removeClass(oSt.pMarkerAreaBut, 'bxst-pressed');

		if (!this.oMarker)
			this.oMarker = {};

		this.oMarker.StickerInd = ind;

		//Hide marker if it exist
		if (oSt.pMarkerNode)
			BX.removeClass(oSt.pMarkerNode, 'bxst-sicked');

		if (oSt.pMarker)
		{
			oSt.pMarker.style.display = "none";
			oSt.pMarker.style.top = "-1000px";
		}
		if (oSt.markerResizer && oSt.markerResizer.cont)
			oSt.markerResizer.cont.style.display = "none";

		if (oSt.obj && oSt.obj.marker)
			oSt.obj.marker = {};

		this.oMarker.node = null;

		oSt.bSetMarkerMode = true;
		if (mode == 'area')
		{
			BX.addClass(oSt.pMarkerAreaBut, 'bxst-pressed');
			setTimeout(function(){_this.bSelectAreaMode = true;}, 10);

			// Create overlay
			if (!this.oMarker.pOverlay)
				this.oMarker.pOverlay = document.body.appendChild(BX.create('DIV', {props: {className: 'bxst-marker-overlay'}}));
			// Show overlay
			this.oMarker.pOverlay.style.display = 'block';

			// Adjust overlay to size
			var ss = BX.GetWindowScrollSize(document);
			this.oMarker.pOverlay.style.width = ss.scrollWidth + "px";
			this.oMarker.pOverlay.style.height = ss.scrollHeight + "px";

			// Create hint near cursor
			if (!this.oMarker.pCursorHint)
				this.oMarker.pCursorHint = document.body.appendChild(BX.create('DIV', {props: {className: 'bxst-cursor-hint'}, text: this.MESS.CursorHint}));

			this.oMarker.pCursorHint.style.top = '';
			this.oMarker.pCursorHint.style.left = '';
			this.oMarker.pCursorHint.style.display = 'block';

			// Marker selection area object
			this.oMarker.pWnd = document.body.appendChild(BX.create('DIV'));
			this.oMarker.pWnd.className = 'bxst-cur-marker ' + this.colorSchemes[oSt.obj.colorInd].name;
		}
		else // Element
		{
			BX.addClass(oSt.pMarkerElementBut, 'bxst-pressed');
			setTimeout(function(){_this.bHightlightElementMode = true;}, 10);
		}

		// Add events
		BX.bind(document, 'mousemove', BX.proxy(this.OnMouseMove, this));
		//BX.bind(document, 'mousedown', BX.proxy(this.OnMousedown, this));
		BX.bind(document, 'mouseup', BX.proxy(this.OnMouseUp, this));
	},

	OnMousedown: function(e)
	{
		//if(!this.bHightlightElementMode && !this.bSelectAreaMode)
		//{
			if (this.curEditorStickerInd !== false && window.oLHESticker && !window.oLHESticker.bPopup)
			{
				var oSt = this.arStickers[this.curEditorStickerInd];
				if (oSt && oSt.pWin.Get())
				{
					var
						bSelMode = this.bSelectAreaMode || this.bHightlightElementMode,
						d = 3,
						top = parseInt(oSt.pWin.Get().style.top) - d,
						left = parseInt(oSt.pWin.Get().style.left) - d,
						right = left + parseInt(oSt.pWin.Get().style.width) + d * 2,
						bottom = top + parseInt(oSt.pWin.Get().style.height) + d * 2;

					e = this.MousePos(e);
					if (e.realX < left || e.realX > right || e.realY < top || e.realY > bottom)
						this.SaveAndCloseEditor(this.curEditorStickerInd, !bSelMode, !bSelMode);
				}
			}
		//}

		// Start to draw selection marker area
		if (this.bSelectAreaMode)
		{
			e = this.MousePos(e);
			this.bDrawMarkerMode = true;
			if (this.oMarker.pCursorHint)
				this.oMarker.pCursorHint.style.display = 'none';

			this.oMarker.from = {top: e.realY, left: e.realX};
		}
		else if (this.bHightlightElementMode) // Start to draw marker area
		{
			var bPrevent = false;
			if (this.pCurMarkeredNode)
			{
				bPrevent = true;
				var cn = this.pCurMarkeredNode.pNode.className;
				if (cn && (cn.indexOf('bx-sticker') != -1 || cn.indexOf('bxst') != -1) && cn.indexOf('bxst-sicked') == -1)
					bPrevent = false;
				if (bPrevent)
					bPrevent = !BX.findParent(this.pCurMarkeredNode.pNode, {className: new RegExp('bx-sticker', 'ig')});
			}

			// Prevent to go away from page
			if (bPrevent)
				return BX.PreventDefault(e);
			else
				this.MarkerHightlightNode(); // Restore onmousedown and onclick events
		}
	},

	OnMouseMove: function(e)
	{
		if(this.bHightlightElementMode)
		{
			var pEl;
			if (e.target)
				pEl = e.target;
			else if (e.srcElement)
				pEl = e.srcElement;
			if (pEl.nodeType == 3)
				pEl = pEl.parentNode;

			if (pEl && pEl.nodeName)
				this.MarkerHightlightNode(pEl);
		}

		if (this.bSelectAreaMode)
		{
			e = this.MousePos(e);

			if (this.oMarker.pCursorHint)
				this.AdjustHintToCursor(this.oMarker.pCursorHint, e);

			if (!this.bDrawMarkerMode)
				return;

			// We down mouse button and try to drop: unhightlight element and start to select area
			//this.bHightlightElementMode = false;
			//this.MarkerHightlightNode();

			this.oMarker.to = {top: e.realY, left: e.realX};
			var
				top = this.oMarker.from.top,
				left = this.oMarker.from.left,
				w = Math.abs(this.oMarker.to.left - this.oMarker.from.left),
				h = Math.abs(this.oMarker.to.top - this.oMarker.from.top);

			//00.00 - 3.00
			if (this.oMarker.to.top <= this.oMarker.from.top && this.oMarker.to.left >= this.oMarker.from.left)
			{
				top = this.oMarker.to.top;
				left = this.oMarker.from.left;
			}
			// 3.00 - 6.00
			else if (this.oMarker.to.top > this.oMarker.from.top && this.oMarker.to.left > this.oMarker.from.left)
			{
				top = this.oMarker.from.top;
				left = this.oMarker.from.left;
			}
			// 6.00 - 9.00
			else if (this.oMarker.to.top > this.oMarker.from.top && this.oMarker.to.left < this.oMarker.from.left)
			{
				top = this.oMarker.from.top;
				left = this.oMarker.to.left;
			}
			// 9.00 - 12.00
			else if (this.oMarker.to.top < this.oMarker.from.top && this.oMarker.to.left < this.oMarker.from.left)
			{
				top = this.oMarker.to.top;
				left = this.oMarker.to.left;
			}

			this.oMarker.pWnd.style.display = "block";
			this.oMarker.pWnd.style.width = w + "px";
			this.oMarker.pWnd.style.height = h + "px";
			this.oMarker.pWnd.style.top = top + "px";
			this.oMarker.pWnd.style.left = left + "px";

			this.oMarker.top = top;
			this.oMarker.left = left;
			this.oMarker.width = w;
			this.oMarker.height = h;
		}
	},

	OnMouseUp: function(e)
	{
		if (this.bHightlightElementMode && this.pCurMarkeredNode)
		{
			var bPrevent = false;
			var cn = this.pCurMarkeredNode.pNode.className;
			if (cn && (cn.indexOf('bx-sticker') != -1 || cn.indexOf('bxst') != -1) && cn.indexOf('bxst-sicked') == -1)
				bPrevent = true;
			if (!bPrevent)
				bPrevent = !!BX.findParent(this.pCurMarkeredNode.pNode, {className: new RegExp('bx-sticker', 'ig')});

			if (!bPrevent)
				this.oMarker.node = this.pCurMarkeredNode.pNode;
		}

		// Reset
		this.bDrawMarkerMode = false;
		this.bHightlightElementMode = false;
		this.bSelectAreaMode = false;

		if (this.oMarker.StickerInd >= 0 && this.arStickers[this.oMarker.StickerInd])
		{
			var oSt = this.arStickers[this.oMarker.StickerInd];
			BX.removeClass(oSt.pMarkerElementBut, 'bxst-pressed');
			BX.removeClass(oSt.pMarkerAreaBut, 'bxst-pressed');
			oSt.bSetMarkerMode = false;
		}

		// Kill events
		BX.unbind(document, 'mousemove', BX.proxy(this.OnMouseMove, this));
		//BX.unbind(document, 'mousedown', BX.proxy(this.OnMousedown, this));
		BX.unbind(document, 'mouseup', BX.proxy(this.OnMouseUp, this));

		if (this.oMarker.pOverlay)
			this.oMarker.pOverlay.style.display = 'none';
		if (this.oMarker.pCursorHint)
			this.oMarker.pCursorHint.style.display = 'none';

		// if (bPrevent)
			// this.SetMarker(this.oMarker.StickerInd);
		// else
		if (!bPrevent)
			this.CreateMarker(this.oMarker);
	},

	MarkerHightlightNode: function(node)
	{
		if (this.pCurMarkeredNode)
		{
			if (this.pCurMarkeredNode.onclick)
				this.pCurMarkeredNode.pNode.onclick = this.pCurMarkeredNode.onclick;
			if (this.pCurMarkeredNode.onmousedown)
				this.pCurMarkeredNode.pNode.onmousedown = this.pCurMarkeredNode.onmousedown;

			BX.removeClass(this.pCurMarkeredNode.pNode, 'bxst-sicked');
		}

		if (node)
		{
			this.pCurMarkeredNode = {pNode: node};

			if (node.onclick)
				this.pCurMarkeredNode.onclick = node.onclick;
			if (node.onmousedown)
				this.pCurMarkeredNode.onmousedown = node.onmousedown;

			node.onmousedown = BX.proxy(this.OnMousedown, this);
			node.onclick = function(){return BX.PreventDefault(arguments[0]);};

			BX.addClass(node, 'bxst-sicked');
		}
		else
		{
			this.pCurMarkeredNode = false;
		}
	},

	CreateMarker: function(oMarker)
	{
		if (!oMarker)
			return;

		var oSt = this.arStickers[oMarker.StickerInd];

		if (oMarker.node)
		{
			oSt.pMarkerNode = oMarker.node;
			oSt.obj.marker = {adjust: this.GetNodeAdjustInfo(oMarker.node)};

			var pos = BX.pos(oSt.pMarkerNode);
			if (pos)
			{
				oSt.obj.marker.top = pos.top - 2;
				oSt.obj.marker.left = pos.left - 2;
				oSt.obj.marker.width = pos.width - 4;
				oSt.obj.marker.height = pos.height - 4;
			}
		}
		else
		{
			oSt.obj.marker = {
				top: oMarker.top,
				left: oMarker.left,
				width: oMarker.width,
				height: oMarker.height
			};

			this.InitMagicAdjust(oMarker.StickerInd);
		}

		if (oSt.obj.marker && (oSt.obj.marker.adjust || (oSt.obj.marker.width && oSt.obj.marker.height && oSt.obj.marker.top && oSt.obj.marker.left)))
		{
			this.DisplayMarker(oMarker.StickerInd, true);
			this.AdjustStickerToArea(oMarker.StickerInd);
		}

		if (this.oMarker.pWnd)
			this.oMarker.pWnd.style.display = "none";

		if (!oSt.pWin.__stWasDragged)
			this.SaveSticker(oMarker.StickerInd);
	},

	DisplayMarker: function(ind, bNew)
	{
		var oSt = this.arStickers[ind];
		if (oSt.pMarker)
			oSt.pMarker.style.display = "none";

		if (oSt.obj.marker && oSt.obj.marker.adjust)
		{
			if (!oSt.pMarkerNode)
				oSt.pMarkerNode = this.FindMarkerNode(oSt.obj.marker.adjust);

			if (oSt.pMarkerNode)
			{
				var pos = BX.pos(oSt.pMarkerNode);
				if (pos)
				{
					if (!oSt.pMarker)
						oSt.pMarker = document.body.appendChild(BX.create('DIV', {props: {className: 'bxst-sticker-marker ' + this.colorSchemes[oSt.obj.colorInd].name}}));

					if (bNew)
						BX.addClass(oSt.pMarker, "bxst-marker-over");

					oSt.pMarker.style.display = "";
					oSt.pMarker.style.width = (pos.width - 4) + "px";
					oSt.pMarker.style.height = (pos.height - 4) + "px";
					oSt.pMarker.style.top = (pos.top - 2) + "px";
					oSt.pMarker.style.left = (pos.left - 2) + "px";
				}

				//return BX.addClass(oSt.pMarkerNode, 'bxst-sicked'); // We find node and select it
				BX.removeClass(oSt.pMarkerNode, 'bxst-sicked');
				return; // We find node and select it
			}
		}

		// Select area
		if (oSt.obj.marker && oSt.obj.marker.width > 0)
		{
			if (!oSt.pMarker)
				oSt.pMarker = document.body.appendChild(BX.create('DIV', {props: {className: 'bxst-sticker-marker ' + this.colorSchemes[oSt.obj.colorInd].name}}));

			if (bNew)
				BX.addClass(oSt.pMarker, "bxst-marker-over");

			oSt.pMarker.style.display = "";
			oSt.pMarker.style.width = oSt.obj.marker.width + "px";
			oSt.pMarker.style.height = oSt.obj.marker.height + "px";
			oSt.pMarker.style.top = oSt.obj.marker.top + "px";
			oSt.pMarker.style.left = oSt.obj.marker.left + "px";
		}
	},

	InitMagicAdjust: function(ind)
	{
		return;

		if (!this.magicNodes)
		{
			var arLinks = document.getElementsByTagName('A');
			// var arImgs = document.getElementsByTagName('IMG');
			// var arDivs = document.getElementsByTagName('DIV');


			var i, len, el, nodes = [], w, h, t, l;

			//
			len = arLinks.length;

			for (i = 0; i < len; i++)
			{
				//w = arLinks[i].offsetWidth;
				//h = arLinks[i].offsetHeight;
				// t = arLinks[i].offsetTop;
				// l = arLinks[i].offsetLeft;

				//console.info(w, h, t, l);

				//if (w > 0 && h > 0 && t > 0 && l > 0)
				if (arLinks[i].offsetWidth > 0)
				{
					var pos = BX.pos(arLinks[i]);
					nodes.push({el: arLinks[i], pos: pos});

					//nodes.push({el: arLinks[i], w: w, h: h, t: t, l: l, r: l + w, b: t + h});
				}
			}

			this.magicNodes = {
				nodes: nodes
			};
		}

		//return;
		var
			node,
			oSt = this.arStickers[ind],
			mTop = oSt.obj.marker.top,
			mLeft = oSt.obj.marker.left,
			mWidth = oSt.obj.marker.width,
			mHeight = oSt.obj.marker.height,
			mRight = mLeft + mWidth,
			mBottom = mTop + mHeight;

		len = this.magicNodes.nodes.length;
		for (i = 0; i < len; i++)
		{
			node = this.magicNodes.nodes[i];
			// if (node.el.id == 'ch1')
				// console.dir(node);

			if (node.pos.top >= mTop && node.pos.left >= mLeft && node.pos.right <= mRight && node.pos.bottom <= mBottom)
			{
				//console.info(node.el);
			}
		}

		// oSt.obj.marker = {
			// top: oMarker.top,
			// left: oMarker.left,
			// width: oMarker.width,
			// height: oMarker.height
		// };
	},

	GetNodeAdjustInfo: function(node)
	{
		var nodeInfo = this._GetNodeAdjustInfo(node);
		nodeInfo = this._GetNodeAdjustSiblings(node, nodeInfo);
		return nodeInfo;
	},

	_GetNodeAdjustInfo: function(node)
	{
		var nodeInfo = {
			nodeName: node.nodeName.toLowerCase(),
			attr: {},
			innerHTML: null
		};

		if (node.innerHTML && node.innerHTML.length)
		{
			nodeInfo.innerHTML = BX.util.trim(node.innerHTML.toLowerCase());

			nodeInfo.innerHTML = nodeInfo.innerHTML.replace(/class=""/ig, '');
			nodeInfo.innerHTML = nodeInfo.innerHTML.replace(/class=''/ig, '');
			nodeInfo.innerHTML = nodeInfo.innerHTML.replace(/\n+/ig, '');
			nodeInfo.innerHTML = nodeInfo.innerHTML.replace(/\r+/ig, '');
			nodeInfo.innerHTML = nodeInfo.innerHTML.replace(/\s+/ig, ' ');

			if (nodeInfo.innerHTML.length > 250)
				nodeInfo.innerHTML = nodeInfo.innerHTML.substr(0, 250);
		}

		if (node.attributes)
		{
			var i, l = node.attributes.length;
			for (i = 0; i < l; i++)
			{
				name = node.attributes[i].name;
				if (!name || typeof name != 'string')
					continue;
				name = name.toLowerCase();
				if (this.oMarkerConfig.attr[name])
				{
					val = node.attributes[i].value;
					if (name == 'class' || name == 'classname')
					{
						name = 'classname';
						val = val.replace('bxst-sicked', '');
						val = BX.util.trim(val);
					}

					if (val.length > 0)
						nodeInfo.attr[name] = val;
				}
			}
		}
		return nodeInfo;
	},

	_GetNodeAdjustSiblings: function(node, nodeInfo)
	{
		nodeInfo.withId = {};

		var pParent = BX.findParent(node, {attr : {id: new RegExp('.+', 'ig')}});
		if (pParent)
			nodeInfo.withId.parent = pParent.getAttribute('id');

		var pChildren = BX.findChild(node, {attr : {id: new RegExp('.+', 'ig')}}, true, true);
		if (pChildren)
		{
			nodeInfo.withId.children = [];
			for (var i = 0, l = pChildren.length; i < l; i++)
				nodeInfo.withId.children.push(pChildren[i].getAttribute('id'));
		}

		var pPrevSibling = BX.findPreviousSibling(node, {attr : {id: new RegExp('.+', 'ig')}});
		if (pPrevSibling)
			nodeInfo.withId.prevSibling = pPrevSibling.getAttribute('id');

		var pNextSibling = BX.findNextSibling(node, {attr : {id: new RegExp('.+', 'ig')}});
		if (pNextSibling)
			nodeInfo.withId.nextSibling = pNextSibling.getAttribute('id');

		return nodeInfo;
	},

	FindMarkerNode: function(nodeInfo)
	{
		var node = false;
		if (!nodeInfo || !nodeInfo.nodeName)
			return false;

		if (!nodeInfo.attr)
			nodeInfo.attr = {};

		// Simple and easy way
		if (nodeInfo.attr.id)
			node = BX(nodeInfo.attr.id);

		var arFindedNodes = [];
		var res;

		if (!node)
		{
			if (!nodeInfo.withId)
				nodeInfo.withId = {};

			// Find by prev sibling
			if (nodeInfo.withId.prevSibling)
			{
				var nextNode = BX(nodeInfo.withId.prevSibling);
				if (nextNode)
				{
					while(nextNode = nextNode.nextSibling)
					{
						res = this.TestNodeWithAttributes(nextNode, nodeInfo);
						if (res)
							arFindedNodes.push(res);

						if (res.coincide == 100)
							break;
					}
				}
			}

			// Find by next sibling
			if (nodeInfo.withId.nextSibling)
			{
				var prevNode = BX(nodeInfo.withId.nextSibling);
				if (prevNode)
				{
					while(prevNode = prevNode.previousSibling)
					{
						res = this.TestNodeWithAttributes(prevNode, nodeInfo);
						if (res)
							arFindedNodes.push(res);

						if (res.coincide == 100)
							break;
					}
				}
			}

			// Find by child
			if (nodeInfo.withId.children)
			{
				var i, l = nodeInfo.withId.children.length, child, parNode;
				for (i = 0; i < l; i++)
				{
					child = BX(nodeInfo.withId.children[i]);
					if (child)
					{
						parNode = child;
						while (true)
						{
							parNode = BX.findParent(parNode, {tagName: nodeInfo.nodeName});
							if (!parNode)
								break;

							res = this.TestNodeWithAttributes(prevNode, nodeInfo);
							if (res)
								arFindedNodes.push(res);

							if (res.coincide == 100)
								break;
						}
					}
				}
			}

			// Find by parent
			var parent;
			if (nodeInfo.withId.parent)
				parent = BX(nodeInfo.withId.parent);
			if (!parent)
				parent = document.body;

			var arAllNodes = parent.getElementsByTagName(nodeInfo.nodeName);
			var i, l = arAllNodes.length;
			for (i = 0; i < l; i++)
			{
				res = this.TestNodeWithAttributes(arAllNodes[i], nodeInfo);
				if (res)
					arFindedNodes.push(res);
				if (res.coincide == 100)
					break;
			}
		}
		else
		{
			arFindedNodes.push({coincide: 100, node: node, bImpAttrCoincide: true});
		}

		var i, l = arFindedNodes.length;
		var arRealNodes = [], maxCoincide = 0, mostRealNode = false;

		for (i = 0; i < l; i++)
		{
			if (arFindedNodes[i].coincide > maxCoincide)
			{
				maxCoincide = arFindedNodes[i].coincide;
				mostRealNode = arFindedNodes[i].node;
				arRealNodes = [];
			}

			if (arFindedNodes[i].coincide == maxCoincide && arFindedNodes[i].node != mostRealNode)
				arRealNodes.push(arFindedNodes[i].node);
		}

		if (arRealNodes.length == 0 && mostRealNode)
			return mostRealNode;
		else
			arRealNodes[0];

		return false;
	},

	TestNodeWithAttributes: function(pNode, nodeInfo)
	{
		if (!pNode || !pNode.nodeName)
			return false;

		var res = {coincide: 0, node: pNode};
		var info = this._GetNodeAdjustInfo(pNode);

		if (info.nodeName != nodeInfo.nodeName)
			return false;

		var delta = 0;
		var bInnerHTML = typeof nodeInfo.innerHTML == 'string';
		if (typeof info.innerHTML != 'string' && bInnerHTML)
			return false;

		var count = 0;
		for (i in nodeInfo.attr)
			if (typeof nodeInfo.attr[i] == 'string')
				count++;

		if (count > 0)
		{
			delta = 100 / (count + (bInnerHTML ? 1 : 0));
			var bImpAttrCoincide = true;

			for (i in nodeInfo.attr)
			{
				if (typeof nodeInfo.attr[i] == 'string')
				{
					// We have similar attributes
					if (nodeInfo.attr[i] == info.attr[i])
						res.coincide += delta;
					else if (this.oMarkerConfig.impAttr[i])
						bImpAttrCoincide = false;
				}
			}

			res.bImpAttrCoincide = bImpAttrCoincide;
		}

		if (bInnerHTML && info.innerHTML == nodeInfo.innerHTML)
			res.coincide += count > 0 ? delta : 95;
		res.coincide = Math.round(res.coincide);

		if (res.coincide > 0)
			return res;
		return false;
	},

	OnDivMouseOver: function(ind, bOver)
	{
		var oSt = this.arStickers[ind];
		if (oSt.bSetMarkerMode)
			return this.ShowButtonsPanel(ind, true, false);

		oSt._over = bOver;

		if (oSt._overTimeout)
			clearTimeout(oSt._overTimeout);

		var _this = this;
		oSt._overTimeout = setTimeout(function()
		{
			if (oSt._over == bOver)
			{
				_this.ShowButtonsPanel(ind, bOver);
				_this.Hightlight(ind, bOver);
			}
		}, bOver ? 100 : 500);
	},

	ShowButtonsPanel: function(ind, bShow, bEffects)
	{
		if (!this.Params.bHideBottom)
		{
			bShow = true;
			bEffects = false;
		}

		bEffects = bEffects !== false;

		var
			_this = this,
			oSt = this.arStickers[ind],
			h = 24, d = 3, i = 1,
			curHeight = oSt.obj.height - (oSt.bButPanelShowed ? 0 : h),
			resHeight = curHeight + h * (bShow ? 1 : -1),
			time = BX.browser.IsIE() ? 3 : 10;

		if (this.bSelectAreaMode || this.bHightlightElementMode // Set marker mode
		|| oSt.obj.collapsed || oSt.obj.closed || oSt.bColSelShowed || oSt.bResizingNow) // Sticker params
			return;

		if (oSt.bButPanelShowed == bShow)
		{
			oSt.pWin.Get().style.height = curHeight + 'px';
			return this.AdjustShadow(ind);
		}

		var sbpInterval = setInterval(function()
		{
			curHeight += d * i * (bShow ? 1 : -1 );
			if (bShow && curHeight >= resHeight || !bShow && curHeight <= resHeight)
				curHeight = resHeight;

			oSt.pWin.Get().style.height = curHeight + 'px';
			_this.AdjustShadow(ind);

			if (curHeight == resHeight)
			{
				clearInterval(sbpInterval);
				oSt.bButPanelShowed = bShow;
			}

			i++;
		}, time);
	},

	ShowColorSelector: function(ind)
	{
		var
			_this = this,
			oSt = this.arStickers[ind], b;

		if (!oSt)
			return;

		if (!oSt.pColSelector)
		{
			oSt.pColSelector = document.body.appendChild(BX.create("DIV", {props: {className: 'bxst-col-sel'}}));
			for (var i = 0, l = this.colorSchemes.length; i < l; i++)
			{
				b = oSt.pColSelector.appendChild(BX.create("SPAN", {props: {id: 'bxst_' + ind + '_' + i, className: 'bxst-col-pic ' + this.colorSchemes[i].name, title: this.colorSchemes[i].title}}));
				b.onclick = function(){
					_this.ChangeColor(ind, parseInt(this.id.substr(('bxst_' + ind + '_').length)), true, true);
					_this.ShowColorSelector(ind); // Hide
				};
			}
			oSt.pColSelector.style.zIndex = this.Params.zIndex + 20;
		}

		oSt.bColSelShowed = !oSt.bColSelShowed;
		if (oSt.bColSelShowed)
		{
			var pos = BX.pos(oSt.pColorBut);
			oSt.pColSelector.style.top = (parseInt(pos.top) + 16) + "px";
			oSt.pColSelector.style.left = (pos.left) + "px";
			oSt.pColSelector.style.display = "block";

			this.ShowOverlay(true, this.Params.zIndex + 15);
			this.pTransOverlay.onmousedown = function(){_this.ShowColorSelector(ind);};
			BX.bind(document, 'keydown', BX.proxy(function(e){this.OnKeyDown(e, ind);}, this));
		}
		else //hide
		{
			oSt.pColSelector.style.display = "none";
			this.ShowOverlay(false);
			BX.unbind(document, 'keydown', BX.proxy(function(e){this.OnKeyDown(e, ind);}, this));
		}
	},

	ShowOverlay: function(bShow, zIndex)
	{
		if (!this.pTransOverlay)
			this.pTransOverlay = document.body.appendChild(BX.create('DIV', {props: {className: 'bxst-trans-overlay'}}));

		if (bShow)
		{
			this.pTransOverlay.style.display = "block";
			this.pTransOverlay.style.zIndex = zIndex || 800;

			// Adjust overlay to size
			var ss = BX.GetWindowScrollSize(document);
			this.pTransOverlay.style.width = ss.scrollWidth + "px";
			this.pTransOverlay.style.height = ss.scrollHeight + "px";
		}
		else
		{
			this.pTransOverlay.style.display = "none";
			this.pTransOverlay.onmousedown = BX.False;
		}
	},

	OnKeyDown: function(e, ind)
	{
		if(!e)
			e = window.event;

		var key = e.which || e.keyCode;
		if (key == 27) // Esc
		{
			var oSt = this.arStickers[ind];
			if (oSt && oSt.bColSelShowed)
				this.ShowColorSelector(ind); // Hide
		}
	},

	SupaFlySticker: function()
	{
		return;
		var windowSize = BX.GetWindowInnerSize();

		var
			st_w = 350, // Sticker width
			st_h = 200, // sticker height
			st_left = 1125, // sticker left
			st_top = 100, // Sticker top
			st_x = Math.round(st_left + st_w / 2), // Sticker center X
			st_y = Math.round(st_top + st_h / 2), // Sticker center Y
			win_w = windowSize.innerWidth,
			win_h = windowSize.innerHeight,
			x0 = Math.round(win_w / 2),
			y0 = Math.round(win_h / 2);

		// console.info('x0 = ', x0, 'y0 = ', y0);
		// console.info('st_x = ', st_x, 'st_y = ', st_y);

		// A * x + B * y + C = 0
		var A = y0 - st_y;
		var B = st_x - x0;
		var C = (x0 * st_y) - (y0 * st_x);

		//console.info('A = ', A, 'B = ', B, 'C = ', C);

		//var start_x = win_w;
		//var start_y = - (C + A * start_x) / B;
		//console.info(start_x, start_y);
		//var k = st_x / st_y;
		//console.info(k);

		//Center
		var div = document.body.appendChild(BX.create("DIV", {style: {background: "#00f", position: "absolute", width: "5px", height: "5px", zIndex: 2000}}));
		div.style.left = x0 + "px";
		div.style.top = y0 + "px";

		//Center
		var div = document.body.appendChild(BX.create("DIV", {style: {background: "#0f0", position: "absolute", width: "5px", height: "5px", zIndex: 2000}}));
		div.style.left = st_x + "px";
		div.style.top = st_y + "px";

		//return;
		// var x = x0;
		// for (var i = 0; i < 200; i++)
		// {
			// var div = document.body.appendChild(BX.create("DIV", {style: {background: "red", position: "absolute", width: "2px", height: "2px", zIndex: 2000}}));

			// var start_x = x;
			// var start_y = - (C + A * start_x) / B;

			// div.style.left = Math.round(start_x) + "px";
			// div.style.top = Math.round(start_y) + "px";

			// x += 10;
			// //console.info(div);
		// }

		// var start_x = win_w;
		// var start_y = - (C + A * start_x) / B;

		var start_y = 0;
		var start_x = - (C + B * start_y) / A;

		var div = document.body.appendChild(BX.create("DIV", {style: {background: "red", position: "absolute", width: "10px", height: "10px", zIndex: 2000}}));
		div.style.left = start_x + "px";
		div.style.top = start_y + "px";
		//console.info(div);

		return;
		//var start_x = Math.round((win_w + st_w) / 2  + win_w / 2);
		var start_x = win_w;
		var start_y = Math.round(start_x / k - win_h / 2);

		var start_left = Math.round(start_x + st_w / 2);
		var start_top = Math.round(start_y - st_h / 2);

		var div = document.body.appendChild(BX.create("DIV", {style: {background: "#ffff80", position: "absolute", width: st_w + "px", height: st_h + "px", zIndex: 2000}}));

		div.style.left = start_left + "px";
		div.style.top = start_top + "px";
	},

	Hightlight: function(ind, bOver)
	{
		var
			oSt = this.arStickers[ind];

		if (oSt.bOver === bOver)
			return;

		oSt.bOver = bOver;
		if (bOver)
		{
			if (oSt.pMarker)
				BX.addClass(oSt.pMarker, "bxst-marker-over");

			BX.addClass(oSt.pWin.Get(), "bx-sticker-over");
			BX.addClass(oSt.pHead, "bxst-header-over");

			oSt.pWin.Get().style.top = (parseInt(oSt.pWin.Get().style.top) - 1) + "px";
			oSt.pWin.Get().style.left = (parseInt(oSt.pWin.Get().style.left) - 1) + "px";
		}
		else
		{
			if (oSt.pMarker)
				BX.removeClass(oSt.pMarker, "bxst-marker-over");

			BX.removeClass(oSt.pWin.Get(), "bx-sticker-over");
			BX.removeClass(oSt.pHead, "bxst-header-over");
			oSt.pWin.Get().style.top = (parseInt(oSt.pWin.Get().style.top) + 1) + "px";
			oSt.pWin.Get().style.left = (parseInt(oSt.pWin.Get().style.left) + 1) + "px";
		}
	},

	BlinkRed: function(ind)
	{
		var
			_this = this,
			rep = 4,
			it = 0, it0 =0, interval,
			oSt = this.arStickers[ind];

		if (!this.pBlinkRed)
			this.pBlinkRed = document.body.appendChild(BX.create("DIV", {props: {className: 'bxst-blink-red'}}));

		this.pBlinkRed.style.zIndex = parseInt(oSt.pWin.Get().style.zIndex) + 10;
		this.pBlinkRed.style.top = oSt.pWin.Get().style.top;
		this.pBlinkRed.style.left = oSt.pWin.Get().style.left;
		this.pBlinkRed.style.width = oSt.pWin.Get().style.width;
		this.pBlinkRed.style.height = oSt.pWin.Get().style.height;

		bFadeIn = true;
		interval = setInterval(function()
		{
			if (it > 2)
			{
				if (bFadeIn)
				{
					_this.pBlinkRed.className = 'bxst-blink-red bx-sticker-op-3';
					it = 1;
				}
				else
				{
					_this.pBlinkRed.className = 'bxst-blink-red';
					it = 0;
				}

				it0++;
				bFadeIn = !bFadeIn;
				if (it0 >= rep)
					clearInterval(interval);

				return;
			}

			if (bFadeIn)
				_this.pBlinkRed.className = 'bxst-blink-red bx-sticker-op-' + it;
			else
				_this.pBlinkRed.className = 'bxst-blink-red bx-sticker-op-' + (3 - it);
			it++;
		}, BX.browser.IsIE() ? 30 : 60);
	},

	ShowList: function(type)
	{
		if (!this.List)
			this.List = new BXStickerList(this);

		this.List.Show(type);
	},

	OnKeyUp: function(e)
	{
		if(!e)
			e = window.event;

		var key = e.which || e.keyCode;
		if (key == 17) // Ctrl
		{
			var _this = this;
			this._bCtrlPressed = true;
			setTimeout(function(){_this._bCtrlPressed = false;}, 400);
		}
		else if (key == 16) // Shift
		{
			var _this = this;
			this._bShiftPressed = true;
			setTimeout(function(){_this._bShiftPressed = false;}, 400);
		}
		else if ((this._bShiftPressed || e.shiftKey)  && (e.ctrlKey || this._bCtrlPressed))
		{
			if (key == 83 && this.Params.access == 'W')  // CTRL + SHIFT + S
			{
				this.AddSticker();
				return BX.PreventDefault(e);
			}
			else if(key == 88) // CTRL + SHIFT + X
			{
				this.ShowAll();
				return BX.PreventDefault(e);
			}
			else if(key == 76) // CTRL + SHIFT + L
			{
				this.ShowList('current');
				return BX.PreventDefault(e);
			}
		}
	},

	UpdateStickersCount: function()
	{
		if (this.curPageCount < 0 || isNaN(parseInt(this.curPageCount)))
			this.curPageCount = 0;

		var pEl = BX.findChild(BX('bxst-show-sticker-icon'), {tagName: 'B'}, true);
		if (pEl)
			pEl.innerHTML = "(" + this.curPageCount + ")";
	}
};

function BXStickerList(BXSticker)
{
	this.BXSticker = BXSticker;
	this.access = this.BXSticker.access;
	this.MESS = this.BXSticker.MESS;
	this.arCurPageIds = {};
}

BXStickerList.prototype = {
	Show: function(type)
	{
		if (this.bShowed)
			return;

		var Config = {
			content_url: '/bitrix/admin/fileman_stickers.php?sticker_action=show_list&' + this.BXSticker.sessid_get + '&cur_page=' + this.BXSticker.Params.pageUrl + '&type=' + type + '&site_id=' + this.BXSticker.Params.site_id,
			title : this.MESS.StickerListTitle,
			width: this.BXSticker.Params.listWidth,
			height: this.BXSticker.Params.listHeight,
			min_width: 800,
			min_height: 400,
			resizable: true,
			resize_id: 'bx_sticker_list_resize_id'
		};

		this.type = type;
		this.bRefreshPage = false;
		this.naviSize = this.BXSticker.Params.listNaviSize;
		this.oDialog = new BX.CDialog(Config);
		this.oDialog.Show();
		this.oDialog.SetButtons([this.oDialog.btnClose]);
		this.bShowed = true;

		var _this = this;
		BX.addCustomEvent(this.oDialog, 'onWindowUnRegister', function()
		{
			_this.bShowed = false;
			if (_this.bRefreshPage)
				window.location = window.location;
		});
		//BX.addCustomEvent(this.oDialog, 'onWindowResize', function(){_this.AdjustToSize();});

		// Adjust Navi size
		BX.addCustomEvent(this.oDialog, 'onWindowResizeFinished', function(){_this.AdjustNaviSize();});
		BX.addCustomEvent(this.oDialog, 'onWindowExpand', function(){_this.AdjustNaviSize();});
		BX.addCustomEvent(this.oDialog, 'onWindowNarrow', function(){_this.AdjustNaviSize();});
	},

	OnLoad: function(count)
	{
		this.pAllBut = BX('bxstl_fil_all_but');
		this.pMyBut = BX('bxstl_fil_my_but');
		this.pColorCont = BX('bxstl_col_cont');
		this.pOpenedBut = BX('bxstl_fil_opened_but');
		this.pClosedBut = BX('bxstl_fil_closed_but');
		this.pAllStickersBut = BX('bxstl_fil_all_p_but');

		this.pItemsTable = BX('bxstl_items_table');
		this.pItemsTableCnt = BX('bxstl_items_table_cnt');
		this.pNaviCont = BX('bxstl_navi_cont');

		if (this.access == 'W')
		{
			this.pActionSel = BX('bxstl_action_sel');
			this.pActionBut = BX('bxstl_action_ok');
		}

		this.pPageSelect = BX('bxstl_fil_page_sel');

		if (this.type == 'current')
		{
			this.BXSticker.Params.filterParams.status = 'all';
			this.BXSticker.Params.filterParams.page = 'current';
		}
		else if (this.type == 'all')
		{
			this.BXSticker.Params.filterParams.status = 'opened';
			this.BXSticker.Params.filterParams.page = 'all';
		}

		var _this = this;
		var _col = this.BXSticker.Params.filterParams.colors;
		if (_col && _col != 'all' && _col.length > 0)
		{
			this.checkedColors = [false, false, false, false, false, false];
			for (var i = 0, l = _col.length; i < l; i++)
				if (_col[i] != 99)
					this.checkedColors[parseInt(_col[i])] = true;
		}
		else
		{
			this.checkedColors = [true, true, true, true, true, true];
		}

		if (!this.bRefreshPage && window.__bxst_result.cur_page_ids !== false && typeof window.__bxst_result.cur_page_ids == 'object')
		{
			for (var i in window.__bxst_result.cur_page_ids)
				this.arCurPageIds[parseInt(window.__bxst_result.cur_page_ids[i])] = true;
		}

		/* Colors filter*/
		var i, l = this.BXSticker.colorSchemes.length, col, pCol, __s = (BX.browser.IsIE() && !BX.browser.IsDoctype()) ? 'style="width: 12px; height: 12px"' : '';
		for (i = 0; i < l; i++)
		{
			col = this.BXSticker.colorSchemes[i];
			pCol = this.pColorCont.appendChild(BX.create("DIV", {props: {id: 'bxstl_color_' + i, className: 'bxstl-color-pick' + (this.checkedColors[i] ? ' bxstl-color-pick-ch' : ''), title: col.title}, html: '<div class="bxstl-col-pic-l"></div><div class="bxstl-col-pic-c"><div class="' + col.name + '" ' + __s + '>&nbsp;</div></div><div class="bxstl-col-pic-r"></div>'}));
			pCol.onclick = function()
			{
				var colorInd = parseInt(this.id.substr('bxstl_color_'.length));
				_this.checkedColors[colorInd] = !_this.checkedColors[colorInd];
				if (_this.checkedColors[colorInd])
					BX.addClass(this, 'bxstl-color-pick-ch');
				else
					BX.removeClass(this, 'bxstl-color-pick-ch');

				_this.ReloadList();
			};
		}

		/* Stickers type: my | all*/
		this.SetStickerType(this.BXSticker.Params.filterParams.type, false);
		this.pAllBut.onclick = function(){_this.SetStickerType('all')};
		this.pMyBut.onclick = function(){_this.SetStickerType('my')};

		/* Stickers status: opened | closed | all*/
		this.SetStickerStatus(this.BXSticker.Params.filterParams.status, false);
		this.pOpenedBut.onclick = function(){_this.SetStickerStatus('opened');};
		this.pClosedBut.onclick = function(){_this.SetStickerStatus('closed');};
		this.pAllStickersBut.onclick = function(){_this.SetStickerStatus('all');};

		if (this.access == 'W')
			this.pActionBut.onclick = function(){_this.Action();};
		this.pPageSelect.onchange = function(){_this.SetPage(this.value);};

		this.SetPage(this.BXSticker.Params.filterParams.page == 'current' ? this.BXSticker.Params.pageUrl : this.BXSticker.Params.filterParams.page, false);

		count = parseInt(count);
		this.oDialog.SetTitle(this.MESS.StickerListTitle + " (" + count + ")");

		this.EnableActionBut(false);
		//this.AdjustToSize();
	},

	SetStickerStatus: function(status, bReload)
	{
		if (status == 'opened')
		{
			BX.addClass(this.pOpenedBut, 'bxstl-but-checked');
			BX.removeClass(this.pClosedBut, 'bxstl-but-checked');
			BX.removeClass(this.pAllStickersBut, 'bxstl-but-checked');
		}
		else if (status == 'closed')
		{
			BX.removeClass(this.pOpenedBut, 'bxstl-but-checked');
			BX.addClass(this.pClosedBut, 'bxstl-but-checked');
			BX.removeClass(this.pAllStickersBut, 'bxstl-but-checked');
		}
		else
		{
			BX.removeClass(this.pOpenedBut, 'bxstl-but-checked');
			BX.removeClass(this.pClosedBut, 'bxstl-but-checked');
			BX.addClass(this.pAllStickersBut, 'bxstl-but-checked');
		}

		this.StickersStatus = status;
		if (bReload !== false)
			this.ReloadList();
	},

	SetStickerType: function(type, bReload)
	{
		if (type == 'all')
		{
			BX.addClass(this.pAllBut, 'bxstl-but-checked');
			BX.removeClass(this.pMyBut, 'bxstl-but-checked');
		}
		else
		{
			BX.addClass(this.pMyBut, 'bxstl-but-checked');
			BX.removeClass(this.pAllBut, 'bxstl-but-checked');
		}

		this.StickersType = type;
		if (bReload !== false)
			this.ReloadList();
	},

	SetPage: function(value, bReload)
	{
		this.pPageSelect.value = value;
		this.StickersPage = value;

		if (bReload !== false)
			this.ReloadList();
	},

	NaviGet: function(page, navNum)
	{
		var params = {};
		params['PAGEN_' + navNum] = page;
		this.ReloadList(params)
	},

	ReloadList: function(params)
	{
		var _this = this;
		if (!params)
			params = {};

		params.sticker_just_res = 'Y';
		params.colors = [99];
		params.sticker_type = this.StickersType;
		params.sticker_status = this.StickersStatus;
		params.sticker_page = this.StickersPage;
		params.navi_size = this.naviSize;
		params.cur_page = this.BXSticker.Params.pageUrl;
		params.type = this.type;

		// Fetch filter color params
		var i, l = this.checkedColors.length;
		for (i = 0; i < l; i++)
			if (this.checkedColors[i] === true)
				params.colors.push(i);

		window.__bxst_result.list_rows_count = false;
		window.__bxst_result.cur_page_ids = false;
		this.BXSticker.Request('show_list', params,
			function(result)
			{
				var arRes = result.split('#BX_STICKER_SPLITER#');
				if (arRes.length == 2)
				{
					_this.pItemsTableCnt.innerHTML = arRes[0];
					_this.pNaviCont.innerHTML = arRes[1];
				}

				// Display count of selected rows in title
				if (window.__bxst_result.list_rows_count !== false)
					_this.oDialog.SetTitle(_this.MESS.StickerListTitle + " (" + parseInt(window.__bxst_result.list_rows_count) + ")");

				if (!_this.bRefreshPage && window.__bxst_result.cur_page_ids !== false && typeof window.__bxst_result.cur_page_ids == 'object')
				{
					for (var i in window.__bxst_result.cur_page_ids)
						_this.arCurPageIds[parseInt(window.__bxst_result.cur_page_ids[i])] = true;
				}

				_this.pItemsTable = BX('bxstl_items_table');
				_this.EnableActionBut(false);
			}, true
		);
	},

	AdjustToSize: function(w, h)
	{
		return;
		// if (typeof w == 'undefined' || typeof h == 'undefined')
		// {
			// w = parseInt(this.oDialog.GetContent().style.width);
			// h = parseInt(this.oDialog.GetContent().style.height);
		// }

		// var
			// idW = 25, // ID
			// dateW = 150, // Date
			// colorW = 52, // Color
			// authorW = 120, // Author
			// actionW = 30, // Author
			// textW = titleW = Math.round((w - 20 - idW - dateW - colorW - authorW - actionW) / 2);

		// var tr = this.pItemsTable.rows[0];
		// tr.cells[0].style.width = idW + 'px';
		// tr.cells[1].style.width = titleW + 'px'
		// tr.cells[2].style.width = dateW + 'px';
		// tr.cells[3].style.width = textW + 'px';
		// tr.cells[4].style.width = colorW + 'px';
		// tr.cells[5].style.width = authorW + 'px';
		// tr.cells[6].style.width = actionW + 'px';

		//this.pItemsTableCnt.style.height = (h - 80 /* header */ - 80 /* footer */) + "px";
	},

	AdjustNaviSize: function()
	{
		var
			newNaviSize,
			h = parseInt(this.oDialog.GetContent().style.height),
			rowHeight = 40,
			maxHeight = (h - 100 /* header */ - 80 /* footer */);

		if (maxHeight != (rowHeight * this.naviSize))
			newNaviSize = Math.floor(maxHeight / rowHeight);

		if (newNaviSize < 5)
			newNaviSize = 5;
		if (newNaviSize > 30)
			newNaviSize = 30;

		if (this.naviSize != newNaviSize)
		{
			this.naviSize = newNaviSize;
			this.ReloadList();
		}
	},

	CheckAll: function(checked)
	{
		var i, l = this.pItemsTable.rows.length, bFind = false;
		for (i = 1; i < l; i++)
		{
			if (this.pItemsTable.rows[i].cells.length == 7)
			{
				this.pItemsTable.rows[i].cells[6].firstChild.checked = !!checked;
				bFind = true;
			}
		}

		if (bFind)
			this.EnableActionBut(checked);
	},

	Action: function()
	{
		if (this.access != 'W')
			return;

		var action = this.pActionSel.value;
		if (action == '' || (action == 'del' && !confirm(this.MESS.DelConfirm)))
			return;

		var i, l = this.pItemsTable.rows.length, arIds = [];
		for (i = 1; i < l; i++)
		{
			if (this.pItemsTable.rows[i].cells.length < 7)
				continue;
			ch = this.pItemsTable.rows[i].cells[6].firstChild;
			if (ch.checked)
			{
				arIds.push(ch.value);
				if (!this.bRefreshPage && this.arCurPageIds[parseInt(ch.value)])
					this.bRefreshPage = true;
			}
		}
		this.ReloadList({list_action: action, list_ids: arIds});
	},

	EnableActionBut: function(bEnable)
	{
		if (this.access != 'W')
			return;

		if (bEnable == 'check')
		{
			var i, l = this.pItemsTable.rows.length, bEnable = false;
			for (i = 1; i < l; i++)
			{
				if (this.pItemsTable.rows[i].cells.length < 7)
					continue;
				if (this.pItemsTable.rows[i].cells[6].firstChild.checked)
				{
					bEnable = true;
					break;
				}
			}
		}
		this.pActionBut.disabled = !bEnable;
		this.pActionSel.disabled = !bEnable;
	}
};

/* End */
;
; /* Start:/bitrix/js/main/core/core_admin.js*/
(function(window){
if (BX.admin) return;

BX.admin = {
	/* settings */
	__border_style: 'solid 1px #777f8c', // 'dashed 1px orange',
	__bg_style: '#777f8c', // 'dashed 1px orange',
	__border_dx: 0,
	__border_min_height: 12,
	__border_menu_timeout: 500,

	__borders_last_comp_pos: {},

	/* borders cache */
	__borders: null,

	dynamic_mode: false,
	dynamic_mode_show_borders: false,

	timer: null,

	/* method */
	createComponentBorder: function()
	{
		BX.admin.__borders = {};
		BX.admin.__borders.cont = document.body.appendChild(BX.create('DIV', {style: {
			display: 'none',
			height: '0px',
			width: '0px'
		}}));

		BX.admin.__borders.top = BX.admin.__borders.cont.appendChild(BX.create('DIV', {style: {
			position: 'absolute',
			height: '1px',
			fontSize: '1px',
			overflow: 'hidden',
			zIndex: 990,
			//borderTop: BX.admin.__border_style
			background: BX.admin.__bg_style
		}}));
		BX.admin.__borders.right = BX.admin.__borders.cont.appendChild(BX.create('DIV', {style: {
			position: 'absolute',
			width: '1px',
			fontSize: '1px',
			overflow: 'hidden',
			zIndex: 990,
			//borderRight: BX.admin.__border_style
			background: BX.admin.__bg_style
		}}));
		BX.admin.__borders.bottom = BX.admin.__borders.cont.appendChild(BX.create('DIV', {style: {
			position: 'absolute',
			height: '1px',
			fontSize: '1px',
			overflow: 'hidden',
			zIndex: 990,
			//borderTop: BX.admin.__border_style
			background: BX.admin.__bg_style
		}}));
		BX.admin.__borders.left = BX.admin.__borders.cont.appendChild(BX.create('DIV', {style: {
			position: 'absolute',
			width: '1px',
			fontSize: '1px',
			overflow: 'hidden',
			zIndex: 990,
			//borderLeft: BX.admin.__border_style
			background: BX.admin.__bg_style
		}}));
	},

	__borders_adjust: function()
	{
		var pos = BX.pos(this),
			dx = BX.admin.__border_dx;

		var db = BX.browser.IsIE() && !BX.browser.IsDoctype() ? 2 : 0

		BX.adjust(BX.admin.__borders.top, {style: {
			'top': (pos.top - dx - db) + 'px',
			'left': (pos.left - dx - db) + 'px',
			'width': (pos.width + dx*2) + 'px'
		}});
		BX.adjust(BX.admin.__borders.right, {style: {
			'top': (pos.top - dx - db) + 'px',
			'left': (pos.right + dx - 1 - db) + 'px',
			'height': (pos.height + dx*2) + 'px'
		}});
		BX.adjust(BX.admin.__borders.bottom, {style: {
			'top': (pos.bottom + dx - db) + 'px',
			'left': (pos.left - dx - db) + 'px',
			'width': (pos.width + dx*2) + 'px'
		}});
		BX.adjust(BX.admin.__borders.left, {style: {
			'top': (pos.top - dx - db) + 'px',
			'left': (pos.left - dx - db) + 'px',
			'height': (pos.height + dx*2) + 'px'
		}});

		BX.admin.__borders_last_comp_pos = pos;
	},

	setComponentBorder: function(comp)
	{
		if (!BX.isReady)
			return BX.ready(function() {BX.admin.setComponentBorder(comp)});

		if (null == BX.admin.__borders)
			BX.admin.createComponentBorder();

		comp = BX(comp);
		if (!comp) return;

		if (comp.children.length > 0)
		{
			var c = comp.firstChild, new_comp = null, cnt = 0;
			while (c)
			{
				if (BX.type.isElementNode(c) && c.tagName.toUpperCase() != 'SCRIPT')
				{
					cnt++;
					if (cnt > 1 || !BX.is_relative(c) && !BX.is_float(c))
					{
						cnt = -1;
						break;
					}
					new_comp = c;
				}
				c = c.nextSibling;
			}

			if (cnt == 1 && new_comp)
			{
				if (comp.OPENER)
				{
					comp.OPENER.setParent(new_comp);
				}

				comp = new_comp;
			}
		}

		if (BX.admin.dynamic_mode)
		{
			BX.addCustomEvent(window, 'onDynamicModeChange', BX.delegate(BX.admin.__empty_comp_onmodechange, comp));
		}

		BX.admin.__empty_comp_onmodechange.apply(comp, [!BX.admin.dynamic_mode || BX.admin.dynamic_mode_show_borders]);

		BX.bind(comp, 'mouseover', BX.admin.__borders_show);
		BX.bind(comp, 'mouseout', BX.admin.__borders_hide);

		if (comp.OPENER && comp.OPENER.defaultAction)
		{
			comp.title = BX.message('ADMIN_INCLAREA_DBLCLICK') + ' - ' + comp.OPENER.defaultActionTitle;
			BX.bind(comp, 'dblclick', BX.admin.__borders_dblclick);
		}
	},

	removeComponentBorder: function(comp)
	{
		comp = BX(comp);
		if (!comp) return;

		BX.unbind(comp, 'mouseover', BX.admin.__borders_show);
		BX.unbind(comp, 'mouseout', BX.admin.__borders_hide);

		if (comp.bx_msover)
		{
			BX.admin.__borders_hide.apply(comp);
		}
	},

	__empty_comp_onmodechange: function(val)
	{
		if (this.offsetHeight <= BX.admin.__border_min_height)
		{
			if (val)
			{
				if (BX.browser.IsIE() && !BX.browser.IsDoctype())
					this.style.height = BX.admin.__border_min_height + 'px';
				else
					this.style.minHeight = BX.admin.__border_min_height + 'px';

				BX.addClass(this, 'bx-context-toolbar-empty-area');
			}
			else
			{
				if (BX.browser.IsIE() && !BX.browser.IsDoctype())
					this.style.height = null;
				else
					this.style.minHeight = null;

				BX.removeClass(this, 'bx-context-toolbar-empty-area');
			}
		}
	},

	__borders_dblclick: function(e)
	{
		if (
			(!BX.admin.dynamic_mode || BX.admin.dynamic_mode_show_borders)
			&& this.OPENER && this.OPENER.defaultAction
		)
		{
			this.OPENER.executeDefaultAction();
			return BX.PreventDefault(e);
		}
		return true;
	},

	__borders_show: function(e)
	{
		e = e || window.event;

		var q = BX.is_relative(this) ? this.parentNode : this;
		if (BX.admin.dynamic_mode && !BX.admin.dynamic_mode_show_borders)
		{
			if (q.title) {q._title = q.title; q.title = '';}

			return;
		}

		if (q._title) {q.title = q._title;}

		if (!BX.admin.__borders_adjusted)
		{
			BX.admin.__borders.cont.style.display = 'block';
			BX.admin.__borders_adjust.apply(this);
			BX.admin.__borders_adjusted = true;
		}

		this.bx_msover = true;

		if (this.OPENER)
		{
			if (this.bxtimer) clearTimeout(this.bxtimer);
			this.bxtimer = setTimeout(BX.proxy(BX.admin.__borders_menu_show, this), this.OPENER.timeout || BX.admin.__border_menu_timeout);
			this.OPENER.setHoverHoutEvents(
				BX.proxy(BX.admin.__borders_show, this),
				BX.proxy(BX.admin.__borders_hide, this)
			);
		}

		//return BX.PreventDefault(e);
	},

	__borders_menu_show: function()
	{
		if (this.bx_msover && this.OPENER)
		{
			this.OPENER.UnHide();
		}
	},

	__borders_hide: function()
	{
		if (BX.admin.dynamic_mode && !BX.admin.dynamic_mode_show_borders)
			return;

		if (this.OPENER && this.OPENER.isMenuVisible())
		{
			setTimeout(BX.admin.__borders_hide, 3*BX.admin.__border_menu_timeout);
			return;
		}

		BX.admin.__borders.cont.style.display = 'none';
		BX.admin.__borders_adjusted = false;

		this.bx_msover = false;

		if (this.OPENER)
		{
			var to = BX.admin.__get_hide_timeout(this.OPENER);
			if (this.bxtimer) clearTimeout(this.bxtimer);
			this.bxtimer = setTimeout(BX.proxy(BX.admin.__borders_menu_hide, this), to);
		}
	},

	__borders_menu_hide: function(e)
	{
		if (!this.bx_msover && this.OPENER)
		{
			this.OPENER.Hide();
		}
	},

	__get_hide_timeout: function(opener)
	{
		var to = BX.admin.__border_menu_timeout;
		return to;
		if (BX.admin.__borders_last_comp_pos.top)
		{
			var pos = {top: parseInt(opener.Get().style.top), left: parseInt(opener.Get().style.left)}
			var bpos = BX.admin.__borders_last_comp_pos;

			if (pos.top <= bpos.bottom && pos.top >= bpos.top && pos.left <= bpos.right && pos.left >= bpos.left)
			{
				return to;
			}

			var dist = {
				top: Math.min(Math.abs(BX.admin.__borders_last_comp_pos.top - pos.top), Math.abs(BX.admin.__borders_last_comp_pos.bottom - pos.top)),
				left: Math.min(Math.abs(BX.admin.__borders_last_comp_pos.top - pos.left), Math.abs(BX.admin.__borders_last_comp_pos.bottom - pos.left))
			}

			dist = Math.sqrt(dist.top*dist.top + dist.left*dist.left);

			to += 2*dist;
			return to;
		}

	}
};

BX.admin.panel = {
	state: {
		fixed: false,
		collapsed: false
	},

	DIV: null,
	BACKDIV: null,
	BACKFRAME: null,
	NOTIFY: null,

	buttons: [],

	Init: function()
	{
		var q;

		BX.admin.panel.DIV = BX('bx-panel');

		if (BX.admin.panel.DIV)
		{
			BX.setUnselectable(BX.admin.panel.DIV);

			q = BX('bx-panel-toggle');
			if (q)
			{
				q.onclick = function(event)
				{
					BX.admin.toggle.toggleStatus();
					event = event || window.event;
					BX.PreventDefault(event);
				}
			}

			q = BX('bx-panel-toggle-icon');
			if (q)
			{
				BX.bind(q, "mousedown", BX.proxy(BX.admin.toggle.start, BX.admin.toggle));
				BX.bind(q, "click", BX.PreventDefault);
			}

			q = BX('bx-panel-hider');
			if (q)
			{
				BX.admin.panel.DIV.ondblclick = BX('bx-panel-expander').onclick = q.onclick = BX.admin.panel.Collapse;

				BX('bx-panel-tabs').ondblclick = BX.PreventDefault;
				var sw = BX('bx-panel-switcher');
				if (sw) sw.ondblclick = BX.PreventDefault;
			}

			q = BX('bx-panel-pin');
			if (q)
			{
				BX.bind(q, 'click', function() {
					var bFixed = BX.hasClass(this, 'bx-panel-pin-fixed');
					if (bFixed)
						BX.removeClass(this, 'bx-panel-pin-fixed');
					else
						BX.addClass(this, 'bx-panel-pin-fixed');

					BX.userOptions.save('admin_panel', 'settings', 'fix', (bFixed? 'off':'on'));
				});

				BX.bind(q, 'click', BX.admin.panel.Fix);

				if (BX.admin.panel.state.fixed) BX.admin.panel.Fix();
			}

			for (var i=0,len=BX.admin.panel.buttons.length; i<len; i++)
			{
				var btn = BX(BX.admin.panel.buttons[i]['ID']);

				if (btn)
				{
					if (BX.admin.panel.buttons[i].HOVER_CSS)
					{
						btn.bx_hover_class = BX.admin.panel.buttons[i].HOVER_CSS;
						if (BX.admin.panel.buttons[i].ACTIVE_CSS)
							btn.bx_active_class = BX.admin.panel.buttons[i].ACTIVE_CSS;

						BX.bind(btn, 'mouseover', BX.admin.panel.__btn_hover);
						BX.bind(btn, 'mouseout', BX.admin.panel.__btn_hout);
						BX.bind(btn, 'mousedown', BX.admin.panel.__btn_down);
					}

					if (BX.admin.panel.buttons[i].MENU)
					{
						var opener = new BX.COpener({
							DIV: btn,
							ATTACH:btn.parentNode.parentNode,
							MENU: BX.admin.panel.buttons[i].MENU,
							TYPE: 'click'
						});

						BX.addCustomEvent(opener, 'onOpenerMenuOpen', BX.delegate(BX.admin.panel.__btn_menuopen, btn));
						BX.addCustomEvent(opener, 'onOpenerMenuClose', BX.delegate(BX.admin.panel.__btn_menuclose, btn));
					}

					if (BX.admin.panel.buttons[i].HINT)
					{
						var target = BX.admin.panel.buttons[i].HINT.TARGET ? btn.parentNode.parentNode : btn;
						if (BX.admin.panel.buttons[i].HINT.ID)
						{
							BX.hint(target, BX.admin.panel.buttons[i].HINT.TITLE, BX.admin.panel.buttons[i].HINT.TEXT, BX.admin.panel.buttons[i].HINT.ID)
						}
						else
						{
							target.BXHINT = new BX.CHint({
								parent: target, hint: BX.admin.panel.buttons[i].HINT.TEXT, title: BX.admin.panel.buttons[i].HINT.TITLE, id: BX.admin.panel.buttons[i].HINT.ID
							});
						}
					}

					btn.ondblclick = BX.PreventDefault;

					if (BX.browser.IsIE())
						btn.setAttribute('hideFocus', 'hidefocus');
				}
			}
		}

		BX.admin.panel.buttons = []; q = null;
	},

	__view_mode_toggle: function(e)
	{
		var this1 = BX('bx-panel-toggle');

		var captiontext = BX('bx-panel-toggle-caption-mode');
		if (this1.className=='bx-panel-toggle-on')
		{
			this1.className='bx-panel-toggle-off';
			captiontext.innerHTML=BX.message('ADMIN_SHOW_MODE_OFF');
			BX.admin.dynamic_mode_show_borders = false;
			this1.href = this1.href.replace('bitrix_include_areas=N', 'bitrix_include_areas=Y');
		}
		else
		{
			this1.className = 'bx-panel-toggle-on';
			captiontext.innerHTML=BX.message('ADMIN_SHOW_MODE_ON');
			BX.admin.dynamic_mode_show_borders = true;
			this1.href = this1.href.replace('bitrix_include_areas=Y', 'bitrix_include_areas=N');
		}

		if (null != this.BXHINT)
			this.BXHINT.Destroy();

		this.BXHINT = new BX.CHint({
			parent: this,
			title: BX.message('AMDIN_SHOW_MODE_TITLE'),
			hint: BX.admin.dynamic_mode_show_borders
					? BX.message('ADMIN_SHOW_MODE_ON_HINT')
					: BX.message('ADMIN_SHOW_MODE_OFF_HINT'),
			showOnce: true,
			preventHide: true,
			show_timeout: 0,
			hide_timeout: 2000
		});

		BX.userOptions.save('admin_panel', 'settings', 'edit', (BX.admin.dynamic_mode_show_borders ? 'on' : 'off'));

		BX.onCustomEvent(window, 'onDynamicModeChange', [BX.admin.dynamic_mode_show_borders]);

		return BX.eventReturnFalse(e);
	},

	__btn_hover: function() {
		this.bx_hover = true;
		if (!BX.admin.panel._menu_open) BX.addClass(this.parentNode.parentNode, this.bx_hover_class);
	},
	__btn_hout: function()
	{
		this.bx_hover = false;
		if (!BX.admin.panel._menu_open) BX.removeClass(this.parentNode.parentNode, this.bx_hover_class);
		BX.admin.panel.__btn_inactive.apply(this);
	},

	__btn_down: function()
	{
		//BX.bind(document, "mouseup", BX.proxy(BX.admin.panel.__btn_up, this));
		BX.admin.panel.__btn_active.apply(this);
	},

	__btn_up : function()
	{
		BX.unbind(document, "mouseup", BX.proxy(BX.admin.panel.__btn_up, this));
		BX.admin.panel.__btn_inactive.apply(this);
	},

	__btn_active: function()
	{
		this.bx_active = true;
		if (!BX.admin.panel._menu_open)
			BX.addClass(this.parentNode.parentNode, this.bx_active_class);
	},

	__btn_inactive: function()
	{
		this.bx_active = false;
		if (!BX.admin.panel._menu_open)
			BX.removeClass(this.parentNode.parentNode, this.bx_active_class);
	},

	__btn_menuopen: function()
	{
		if (this.bx_hover)
			BX.admin.panel.__btn_hover.apply(this);

		if (this.bx_active)
			BX.admin.panel.__btn_active.apply(this);

		BX.admin.panel._menu_open = true;
	},

	__btn_menuclose: function()
	{
		BX.admin.panel._menu_open = false;
		if (!this.bx_hover)
			BX.admin.panel.__btn_hout.apply(this);

		//if (!this.bx_active)
		BX.admin.panel.__btn_inactive.apply(this);
	},

	RegisterButton: function(btn)
	{
		BX.admin.panel.buttons[BX.admin.panel.buttons.length] = btn;
	},

	Collapse: function(e)
	{
		e = e || window.event;

		BX.admin.panel.state.collapsed = !(BX.admin.panel.DIV.className.indexOf('bx-panel-folded')>-1);
		var y_start = BX.admin.panel.DIV.offsetHeight;

		var hider = BX("bx-panel-hider", true);
		var expander = BX("bx-panel-expander", true);
		var toggle = BX("bx-panel-toggle");

		if (BX.admin.panel.state.collapsed)
		{
			BX.admin.toggle.unset();
			BX("bx-panel-userinfo").insertBefore(toggle.parentNode.removeChild(toggle), expander);
			BX.addClass(BX.admin.panel.DIV, "bx-panel-folded");
		}
		else
		{
			BX.admin.toggle.unset();
			BX("bx-panel-switcher").insertBefore(toggle.parentNode.removeChild(toggle), hider);
			BX.removeClass(BX.admin.panel.DIV, "bx-panel-folded");
		}

		var dy = BX.admin.panel.DIV.offsetHeight - y_start;

		BX.userOptions.save('admin_panel', 'settings', 'collapsed', (BX.admin.panel.state.collapsed ? 'on':'off'));

		BX.admin.panel.__adjustBackDiv();

		BX.onCustomEvent('onTopPanelCollapse', [BX.admin.panel.state.collapsed, dy]);

		return BX.PreventDefault(e);
	},

	isFixed: function()
	{
		return BX.admin.panel.DIV.className.indexOf('bx-panel-fixed') > -1;
	},

	Fix: function()
	{
		if (null == BX.admin.panel.BACKDIV)
			BX.admin.panel.BACKDIV = BX('bx-panel-back');
		var bFixed = BX.admin.panel.isFixed();

		var bIE = BX.browser.IsIE();
		if(bIE)
		{
			try {BX.admin.panel.DIV.style.removeExpression("top");} catch(e) {bIE = false;}
		}

		if(bFixed)
		{
			BX.removeClass(BX.admin.panel.DIV, bIE ? 'bx-panel-fixed-ie' : 'bx-panel-fixed');
			BX.admin.panel.BACKDIV.style.display = 'none';
			if(bIE)
			{
				BX.admin.panel.DIV.style.cssText = "position: static !important;";

				if(BX.admin.panel.BACKFRAME)
					BX.admin.panel.BACKFRAME.style.visibility = 'hidden';
			}
		}
		else
		{
			if(bIE)
			{
				try{BX.admin.panel.DIV.style.setExpression("top", "0");} catch(e) {bIE = false;}
			}

			if (bIE)
				BX.admin.panel.DIV.style.cssText = "";

			BX.addClass(BX.admin.panel.DIV, bIE ? 'bx-panel-fixed-ie' : 'bx-panel-fixed');

			if(bIE)
			{
				if(document.body.currentStyle.backgroundImage == 'none')
				{
					document.body.style.backgroundImage = "url(/bitrix/images/1.gif)";
					document.body.style.backgroundAttachment = "fixed";
					document.body.style.backgroundRepeat = "no-repeat";
				}
				BX.admin.panel.DIV.style.setExpression("top", "eval((document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop)");
				BX.admin.panel.DIV.style.setExpression("left", "eval((document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft)");
				BX.admin.panel.DIV.style.setExpression("width", "eval((document.documentElement && document.documentElement.clientWidth) ? document.documentElement.clientWidth : document.body.clientWidth)");
			}

			BX.admin.panel.__adjustBackDiv();
			BX.admin.panel.BACKDIV.style.display = 'block';

			if(bIE)
			{
				if(BX.admin.panel.BACKFRAME)
					BX.admin.panel.BACKFRAME.style.visibility = 'visible';
				else
					BX.admin.panel.CreateFrame();
			}
		}

		BX.onCustomEvent('onTopPanelFix', [!bFixed]);
	},

	__adjustBackDiv: function()
	{
		if (BX.admin.panel.BACKDIV)
		{
			var h = BX.admin.panel.DIV.offsetHeight+'px';
			BX.admin.panel.BACKDIV.style.height = h;

			var frame = BX("bx-panel-frame");
			if (BX.admin.panel.BACKFRAME)
				BX.admin.panel.BACKFRAME.style.height = h;
		}
	},

	CreateFrame: function()
	{
		BX.admin.panel.BACKFRAME = document.body.appendChild(BX.create('IFRAME', {
			props: {
				id: "bx-panel-frame"
			},
			style: {
				position: 'absolute',
				overflow: 'hidden',
				zIndex: parseInt(BX.admin.panel.DIV.currentStyle.zIndex)-1,
				height: BX.admin.panel.DIV.offsetHeight + "px"
			}
		}));

		BX.admin.panel.BACKFRAME.style.setExpression("top", "eval(document.body.scrollTop)");
		BX.admin.panel.BACKFRAME.style.setExpression("left", "eval(document.body.scrollLeft)");
		BX.admin.panel.BACKFRAME.style.setExpression("width", "eval(document.body.clientWidth)");
	},

	Notify: function(str)
	{
		if (!BX.isReady)
		{
			var _args = arguments;
			BX.ready(function() {BX.admin.panel.Notify.apply(this, _args);});
			return;
		}

		if (!BX.admin.panel.DIV) return;

		if (null == BX.admin.panel.NOTIFY)
		{
			BX.admin.panel.NOTIFY = BX.admin.panel.DIV.appendChild(BX.create('DIV', {
				props: {className: 'adm-warning-block'},
				html:
					'<span class="adm-warning-text">'+(str||'&nbsp;')+'</span><span onclick="BX.admin.panel.hideNotify(this.parentNode)" class="adm-warning-close"></span>'
			}));

		}

		BX.removeClass(BX.admin.panel.NOTIFY, 'adm-warning-animate');

		BX.admin.panel.__adjustBackDiv();
	},


	hideNotify: function(element)
	{
		var element = BX.type.isDomNode(element)? element: this;

		if (!!element && !!element.parentNode && !!element.parentNode.parentNode)
		{
			BX.addClass(element, 'adm-warning-animate');
		}

		if (BX.type.isDomNode(element) && element.getAttribute('data-ajax') == "Y")
		{
			var notifyId = parseInt(element.getAttribute('data-id'));
			if (notifyId > 0)
			{
				BX.ajax({
					url: '/bitrix/admin/admin_notify.php',
					method: 'POST',
					dataType: 'json',
					data: {'ID' : notifyId, 'sessid': BX.bitrix_sessid()}
				});
			}
		}

		(BX.defer(BX.admin.panel.__adjustBackDiv, this))();
		setTimeout(BX.proxy(BX.admin.panel.__adjustBackDiv, this), 310);
	}

	/*,
	setZIndex: function()
	{
		var zIndex = BX.WindowManager.GetZIndex()-6;
		BX.admin.panel.DIV.setAttribute('style', 'z-index: ' + zIndex + ' !important;');
	}
	*/
};

BX.admin.toggle = {

	icon : null,
	indicator : null,
	toggle : null,
	caption : null,

	pageX : 0,
	initIconPos : 0,
	initIndicatorPos : 0,

	minLeft : -3,
	maxLeft : 17,

	unset : function()
	{
		this.icon = this.indicator = this.toggle = this.caption = null;
	},

	start : function(event)
	{
		event = event || window.event;

		if (!this._init() || !event)
			return;

		BX.fixEventPageX(event);
		this.pageX = event.pageX;
		this.initIconPos = parseInt(BX.style(this.icon, "left"));
		this.initIndicatorPos = BX.hasClass(this.toggle, "bx-panel-toggle-on") ? -270 : -290;

		BX.removeClass(this.toggle, "bx-panel-toggle-animate");

		BX.bind(document, "mousemove", BX.proxy(this._onMouseMove, this));
		BX.bind(document, "mouseup", BX.proxy(this._onMouseUp, this));

		document.body.onselectstart = BX.False;
		document.body.ondragstart = BX.False;
		document.body.style.MozUserSelect = "none";
	},

	_init : function()
	{
		if (this.toggle)
			return true;

		this.toggle = BX("bx-panel-toggle");
		this.icon = BX("bx-panel-toggle-icon");
		this.indicator = BX("bx-panel-toggle-indicator");
		this.caption = BX("bx-panel-toggle-caption-mode");

		return (this.toggle && this.icon && this.indicator && this.caption);
	},

	_onMouseMove : function(event)
	{
		event = event || window.event;
		BX.fixEventPageX(event);
		this._moveToggle(event.pageX - this.pageX);
	},

	_onMouseUp : function()
	{
		var pos = parseInt(BX.style(this.icon, "left"));
		if (this.initIconPos == pos)
		{
			this.toggleStatus();
		}
		else
		{
			var half = this.minLeft + Math.floor((this.maxLeft - this.minLeft) / 2);
			if (pos >= half)
			{
				BX.addClass(this.toggle, "bx-panel-toggle-on bx-panel-toggle-animate");
				BX.removeClass(this.toggle, "bx-panel-toggle-off");
				this._changePosition(true);
			}
			else
			{
				BX.addClass(this.toggle, "bx-panel-toggle-off bx-panel-toggle-animate");
				BX.removeClass(this.toggle, "bx-panel-toggle-on");
				this._changePosition(false);
			}
		}

		this.icon.style.cssText = "";
		this.indicator.style.cssText = "";

		BX.unbind(document, "mousemove", BX.proxy(this._onMouseMove, this));
		BX.unbind(document, "mouseup", BX.proxy(this._onMouseUp, this));

		document.body.onselectstart = null;
		document.body.ondragstart = null;
		document.body.style.MozUserSelect = "";
	},

	_changePosition : function(on)
	{
		var firstNode = this.caption.childNodes[0];

		if ( (on && firstNode.id == "bx-panel-toggle-caption-mode-on") || (!on && firstNode.id == "bx-panel-toggle-caption-mode-off"))
			return;
		this.caption.appendChild(this.caption.removeChild(firstNode));

		if (BX.admin.dynamic_mode)
		{
			if (on)
			{
				BX.admin.dynamic_mode_show_borders = true;
				this.toggle.href = this.toggle.href.replace('bitrix_include_areas=Y', 'bitrix_include_areas=N');
			}
			else
			{
				BX.admin.dynamic_mode_show_borders = false;
				this.toggle.href = this.toggle.href.replace('bitrix_include_areas=N', 'bitrix_include_areas=Y');
			}

			if (null != BX.admin.panel.BXHINT)
				BX.admin.panel.BXHINT.Destroy();

			BX.admin.panel.BXHINT = new BX.CHint({
				parent: this.toggle,
				title: BX.message('AMDIN_SHOW_MODE_TITLE'),
				hint: BX.admin.dynamic_mode_show_borders
					? BX.message('ADMIN_SHOW_MODE_ON_HINT')
					: BX.message('ADMIN_SHOW_MODE_OFF_HINT'),
				showOnce: true,
				preventHide: true,
				show_timeout: 0,
				hide_timeout: 2000
			});

			BX.userOptions.save('admin_panel', 'settings', 'edit', (BX.admin.dynamic_mode_show_borders ? 'on' : 'off'));
			BX.onCustomEvent(window, 'onDynamicModeChange', [BX.admin.dynamic_mode_show_borders]);
		}
		else
		{
			BX.reload(this.toggle.href);
		}
	},

	_moveToggle : function(offset)
	{
		var newPos = this.initIconPos + offset;
		newPos = Math.min(this.maxLeft, Math.max(newPos, this.minLeft));
		this.icon.style.cssText = "left:" + newPos + "px !important";
		this.indicator.style.cssText = "background-position: " + ( this.initIndicatorPos + newPos - this.initIconPos) + "px -1751px !important";

	},

	toggleStatus : function()
	{
		if (!this._init())
			return;

		if (BX.hasClass(this.toggle, "bx-panel-toggle-off"))
		{
			BX.addClass(this.toggle, "bx-panel-toggle-on bx-panel-toggle-animate");
			BX.removeClass(this.toggle, "bx-panel-toggle-off");
			this._changePosition(true);
		}
		else
		{
			BX.addClass(this.toggle, "bx-panel-toggle-off bx-panel-toggle-animate");
			BX.removeClass(this.toggle, "bx-panel-toggle-on");
			this._changePosition(false);
		}
	}
};

BX.admin.startMenuRecent = function(itemInfo)
{
	BX.ajax.get('/bitrix/admin/get_start_menu.php', {
		mode: 'save_recent',
		url: itemInfo['LINK'],
		text: itemInfo['TEXT'],
		title: itemInfo['TITLE'],
		icon: itemInfo['GLOBAL_ICON'],
		sessid:BX.bitrix_sessid()
	});
}

BX.admin.startMenuFavAdd = function(back_url)
{
	window.location.href = '/bitrix/admin/favorite_edit.php?lang='+BX.message('LANGUAGE_ID')+'&name='+BX.util.urlencode(document.title)+'&addurl='+BX.util.urlencode(window.location.href)+'&encoded=Y' + (!!back_url ? '&back_url_pub=' + BX.util.urlencode(back_url) : '');
}

/************************** init admin panel **********************************/
BX.ready(function() {
	BX.admin.panel.Init();
});
//BX.addCustomEvent('onWindowRegister', BX.admin.panel.setZIndex);
//BX.addCustomEvent('onWindowUnRegister', BX.admin.panel.setZIndex);

})(window);

/* End */
;
; /* Start:/bitrix/js/main/utils.js*/
var phpVars;
if(!phpVars)
{
	phpVars = {
		ADMIN_THEME_ID: '.default',
		LANGUAGE_ID: 'en',
		FORMAT_DATE: 'DD.MM.YYYY',
		FORMAT_DATETIME: 'DD.MM.YYYY HH:MI:SS',
		opt_context_ctrl: false,
		cookiePrefix: 'BITRIX_SM',
		titlePrefix: '',
		bitrix_sessid: '',
		messHideMenu: '',
		messShowMenu: '',
		messHideButtons: '',
		messShowButtons: '',
		messFilterInactive: '',
		messFilterActive: '',
		messFilterLess: '',
		messLoading: 'Loading...',
		messMenuLoading: '',
		messMenuLoadingTitle: '',
		messNoData: '',
		messExpandTabs: '',
		messCollapseTabs: '',
		messPanelFixOn: '',
		messPanelFixOff: '',
		messPanelCollapse: '',
		messPanelExpand: ''
	};
}

var jsUtils =
{
	arEvents: Array(),

	addEvent: function(el, evname, func, capture)
	{
		if(el.attachEvent) // IE
			el.attachEvent("on" + evname, func);
		else if(el.addEventListener) // Gecko / W3C
			el.addEventListener(evname, func, false);
		else
			el["on" + evname] = func;
		this.arEvents[this.arEvents.length] = {'element': el, 'event': evname, 'fn': func};
	},

	removeEvent: function(el, evname, func)
	{
		if(el.detachEvent) // IE
			el.detachEvent("on" + evname, func);
		else if(el.removeEventListener) // Gecko / W3C
			el.removeEventListener(evname, func, false);
		else
			el["on" + evname] = null;
	},

	removeAllEvents: function(el)
	{
		var i;
		for(i=0; i<this.arEvents.length; i++)
		{
			if(this.arEvents[i] && (el==false || el==this.arEvents[i].element))
			{
				jsUtils.removeEvent(this.arEvents[i].element, this.arEvents[i].event, this.arEvents[i].fn);
				this.arEvents[i] = null;
			}
		}
		if(el==false)
			this.arEvents.length = 0;
	},

	IsDoctype: function()
	{
		if (document.compatMode)
			return (document.compatMode == "CSS1Compat");

		if (document.documentElement && document.documentElement.clientHeight)
			return true;

		return false;
	},

	GetRealPos: function(el)
	{
		if(window.BX)
			return BX.pos(el);

		if(!el || !el.offsetParent)
			return false;

		var res = Array();
		res["left"] = el.offsetLeft;
		res["top"] = el.offsetTop;
		var objParent = el.offsetParent;

		while(objParent && objParent.tagName != "BODY")
		{
			res["left"] += objParent.offsetLeft;
			res["top"] += objParent.offsetTop;
			objParent = objParent.offsetParent;
		}
		res["right"] = res["left"] + el.offsetWidth;
		res["bottom"] = res["top"] + el.offsetHeight;

		return res;
	},

	FindChildObject: function(obj, tag_name, class_name, recursive)
	{
		if(!obj)
			return null;
		var tag = tag_name.toUpperCase();
		var cl = (class_name? class_name.toLowerCase() : null);
		var n = obj.childNodes.length;
		for(var j=0; j<n; j++)
		{
			var child = obj.childNodes[j];
			if(child.tagName && child.tagName.toUpperCase() == tag)
				if(!class_name || child.className.toLowerCase() == cl)
					return child;
			if(recursive == true)
			{
				var deepChild;
				if((deepChild = jsUtils.FindChildObject(child, tag_name, class_name, true)))
					return deepChild;
			}
		}
		return null;
	},

	FindParentObject: function(obj, tag_name, class_name)
	{
		if(!obj)
			return null;
		var o = obj;
		var tag = tag_name.toUpperCase();
		var cl = (class_name? class_name.toLowerCase() : null);
		while(o.parentNode)
		{
			var parent = o.parentNode;
			if(parent.tagName && parent.tagName.toUpperCase() == tag)
				if(!class_name || parent.className.toLowerCase() == cl)
					return parent;
			o = parent;
		}
		return null;
	},

	FindNextSibling: function(obj, tag_name)
	{
		if(!obj)
			return null;
		var o = obj;
		var tag = tag_name.toUpperCase();
		while(o.nextSibling)
		{
			var sibling = o.nextSibling;
			if(sibling.tagName && sibling.tagName.toUpperCase() == tag)
				return sibling;
			o = sibling;
		}
		return null;
	},

	FindPreviousSibling: function(obj, tag_name)
	{
		if(!obj)
			return null;
		var o = obj;
		var tag = tag_name.toUpperCase();
		while(o.previousSibling)
		{
			var sibling = o.previousSibling;
			if(sibling.tagName && sibling.tagName.toUpperCase() == tag)
				return sibling;
			o = sibling;
		}
		return null;
	},

	bOpera : navigator.userAgent.toLowerCase().indexOf('opera') != -1,
	bIsIE : document.attachEvent && navigator.userAgent.toLowerCase().indexOf('opera') == -1,

	IsIE: function()
	{
		return this.bIsIE;
	},

	IsOpera: function()
	{
		return this.bOpera;
	},

	IsSafari: function()
	{
		var userAgent = navigator.userAgent.toLowerCase();
		return (/webkit/.test(userAgent));
	},

	IsEditor: function()
	{
		var userAgent = navigator.userAgent.toLowerCase();
		var version = (userAgent.match( /.+(msie)[\/: ]([\d.]+)/ ) || [])[2];
		var safari = /webkit/.test(userAgent);

		if (this.IsOpera() || (document.all && !document.compatMode && version < 6) || safari)
			return false;

		return true;
	},

	ToggleDiv: function(div)
	{
		var style = document.getElementById(div).style;
		if(style.display!="none")
			style.display = "none";
		else
			style.display = "block";
		return (style.display != "none");
	},

	urlencode: function(s)
	{
		return escape(s).replace(new RegExp('\\+','g'), '%2B');
	},

	OpenWindow: function(url, width, height)
	{
		var w = screen.width, h = screen.height;
		if(this.IsOpera())
		{
			w = document.body.offsetWidth;
			h = document.body.offsetHeight;
		}
		window.open(url, '', 'status=no,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+Math.floor((h - height)/2-14)+',left='+Math.floor((w - width)/2-5));
	},

	SetPageTitle: function(s)
	{
		document.title = phpVars.titlePrefix+s;
		var h1 = document.getElementsByTagName("H1");
		if(h1)
			h1[0].innerHTML = s;
	},

	LoadPageToDiv: function(url, div_id)
	{
		var div = document.getElementById(div_id);
		if(!div)
			return;
		CHttpRequest.Action = function(result)
		{
			CloseWaitWindow();
			document.getElementById(div_id).innerHTML = result;
		}
		ShowWaitWindow();
		CHttpRequest.Send(url);
	},

	trim: function(s)
	{
		if (typeof s == 'string' || typeof s == 'object' && s.constructor == String)
		{
			var r, re;

			re = /^[\s\r\n]+/g;
			r = s.replace(re, "");
			re = /[\s\r\n]+$/g;
			r = r.replace(re, "");
			return r;
		}
		else
			return s;
	},

	Redirect: function(args, url)
	{
		var e = null, bShift = false;
		if(args && args.length > 0)
			e = args[0];
		if(!e)
			e = window.event;
		if(e)
			bShift = e.shiftKey;

		if(bShift)
			window.open(url);
		else
		{
			window.location.href=url;
		}
	},

	False: function(){return false;},

	AlignToPos: function(pos, w, h)
	{
		var x = pos["left"], y = pos["bottom"];

		var scroll = jsUtils.GetWindowScrollPos();
		var size = jsUtils.GetWindowInnerSize();

		if((size.innerWidth + scroll.scrollLeft) - (pos["left"] + w) < 0)
		{
			if(pos["right"] - w >= 0 )
				x = pos["right"] - w;
			else
				x = scroll.scrollLeft;
		}

		if((size.innerHeight + scroll.scrollTop) - (pos["bottom"] + h) < 0)
		{
			if(pos["top"] - h >= 0)
				y = pos["top"] - h;
			else
				y = scroll.scrollTop;
		}

		return {'left':x, 'top':y};
	},

	// evaluate js string in window scope
	EvalGlobal: function(script)
	{
		try {
		if (window.execScript)
			window.execScript(script, 'javascript');
		else if (jsUtils.IsSafari())
			window.setTimeout(script, 0);
		else
			window.eval(script);
		} catch (e) {/*alert("Error! jsUtils.EvalGlobal");*/}
	},

	GetStyleValue: function(el, styleProp)
	{
		var res;
		if(el.currentStyle)
			res = el.currentStyle[styleProp];
		else if(window.getComputedStyle)
			res = document.defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
		if(!res)
			res = '';
		return res;
	},

	GetWindowInnerSize: function(pDoc)
	{
		var width, height;
		if (!pDoc)
			pDoc = document;

		if (self.innerHeight) // all except Explorer
		{
			width = self.innerWidth;
			height = self.innerHeight;
		}
		else if (pDoc.documentElement && (pDoc.documentElement.clientHeight || pDoc.documentElement.clientWidth)) // Explorer 6 Strict Mode
		{
			width = pDoc.documentElement.clientWidth;
			height = pDoc.documentElement.clientHeight;
		}
		else if (pDoc.body) // other Explorers
		{
			width = pDoc.body.clientWidth;
			height = pDoc.body.clientHeight;
		}
		return {innerWidth : width, innerHeight : height};
	},

	GetWindowScrollPos: function(pDoc)
	{
		var left, top;
		if (!pDoc)
			pDoc = document;

		if (self.pageYOffset) // all except Explorer
		{
			left = self.pageXOffset;
			top = self.pageYOffset;
		}
		else if (pDoc.documentElement && (pDoc.documentElement.scrollTop || pDoc.documentElement.scrollLeft)) // Explorer 6 Strict
		{
			left = document.documentElement.scrollLeft;
			top = document.documentElement.scrollTop;
		}
		else if (pDoc.body) // all other Explorers
		{
			left = pDoc.body.scrollLeft;
			top = pDoc.body.scrollTop;
		}
		return {scrollLeft : left, scrollTop : top};
	},

	GetWindowScrollSize: function(pDoc)
	{
		var width, height;
		if (!pDoc)
			pDoc = document;

		if ( (pDoc.compatMode && pDoc.compatMode == "CSS1Compat"))
		{
			width = pDoc.documentElement.scrollWidth;
			height = pDoc.documentElement.scrollHeight;
		}
		else
		{
			if (pDoc.body.scrollHeight > pDoc.body.offsetHeight)
				height = pDoc.body.scrollHeight;
			else
				height = pDoc.body.offsetHeight;

			if (pDoc.body.scrollWidth > pDoc.body.offsetWidth ||
				(pDoc.compatMode && pDoc.compatMode == "BackCompat") ||
				(pDoc.documentElement && !pDoc.documentElement.clientWidth)
			)
				width = pDoc.body.scrollWidth;
			else
				width = pDoc.body.offsetWidth;
		}
		return {scrollWidth : width, scrollHeight : height};
	},

	GetWindowSize: function()
	{
		var innerSize = jsUtils.GetWindowInnerSize();
		var scrollPos = jsUtils.GetWindowScrollPos();
		var scrollSize = jsUtils.GetWindowScrollSize();

		return  {
			innerWidth : innerSize.innerWidth, innerHeight : innerSize.innerHeight,
			scrollLeft : scrollPos.scrollLeft, scrollTop : scrollPos.scrollTop,
			scrollWidth : scrollSize.scrollWidth, scrollHeight : scrollSize.scrollHeight
		};
	},


	arCustomEvents: {},

	addCustomEvent: function(eventName, eventHandler, arParams, handlerContextObject)
	{
		if (!this.arCustomEvents[eventName])
			this.arCustomEvents[eventName] = [];

		if (!arParams)
			arParams = [];
		if (!handlerContextObject)
			handlerContextObject = false;

		this.arCustomEvents[eventName].push(
			{
				handler: eventHandler,
				arParams: arParams,
				obj: handlerContextObject
			}
		);
	},

	removeCustomEvent: function(eventName, eventHandler)
	{
		if (!this.arCustomEvents[eventName])
			return;

		var l = this.arCustomEvents[eventName].length;
		if (l == 1)
		{
			delete this.arCustomEvents[eventName];
			return;
		}

		for (var i = 0; i < l; i++)
		{
			if (!this.arCustomEvents[eventName][i])
				continue;
			if (this.arCustomEvents[eventName][i].handler == eventHandler)
			{
				delete this.arCustomEvents[eventName][i];
				return;
			}
		}
	},

	onCustomEvent: function(eventName, arEventParams)
	{
		if (!this.arCustomEvents[eventName])
			return;

		if (!arEventParams)
			arEventParams = [];

		var h;
		for (var i = 0, l = this.arCustomEvents[eventName].length; i < l; i++)
		{
			h = this.arCustomEvents[eventName][i];
			if (!h || !h.handler)
				continue;

			if (h.obj)
				h.handler.call(h.obj, h.arParams, arEventParams);
			else
				h.handler(h.arParams, arEventParams);
		}
	},

	loadJSFile: function(arJs, oCallBack, pDoc)
	{
		if (!pDoc)
			pDoc = document;
		if (typeof arJs == 'string')
			arJs = [arJs];
		var callback = function()
		{
			if (!oCallBack)
				return;
			if (typeof oCallBack == 'function')
				return oCallBack();
			if (typeof oCallBack != 'object' || !oCallBack.func)
				return;
			var p = oCallBack.params || {};
			if (oCallBack.obj)
				oCallBack.func.apply(oCallBack.obj, p);
			else
				oCallBack.func(p);
		};
		var load_js = function(ind)
		{
			if (ind >= arJs.length)
				return callback();
			var oSript = pDoc.body.appendChild(pDoc.createElement('script'));
			oSript.src = arJs[ind];
			var bLoaded = false;
			oSript.onload = oSript.onreadystatechange = function()
			{
				if (!bLoaded && (!oSript.readyState || oSript.readyState == "loaded" || oSript.readyState == "complete"))
				{
					bLoaded = true;
					setTimeout(function (){load_js(++ind);}, 50);
				}
			};
		};
		load_js(0);
	},

	loadCSSFile: function(arCSS, pDoc, pWin)
	{
		if (typeof arCSS == 'string')
		{
			var bSingle = true;
			arCSS = [arCSS];
		}
		var i, l = arCSS.length, pLnk = [];
		if (l == 0)
			return;
		if (!pDoc)
			pDoc = document;
		if (!pWin)
			pWin = window;
		if (!pWin.bxhead)
		{
			var heads = pDoc.getElementsByTagName('HEAD');
			pWin.bxhead = heads[0];
		}
		if (!pWin.bxhead)
			return;
		for (i = 0; i < l; i++)
		{
			var lnk = document.createElement('LINK');
			lnk.href = arCSS[i];
			lnk.rel = 'stylesheet';
			lnk.type = 'text/css';
			pWin.bxhead.appendChild(lnk);
			pLnk.push(lnk);
		}
		if (bSingle)
			return lnk;
		return pLnk;
	},

	appendBXHint : function(node, html)
	{
		if (!node || !node.parentNode || !html)
			return;
		var oBXHint = new BXHint(html);
		node.parentNode.insertBefore(oBXHint.oIcon, node);
		node.parentNode.removeChild(node);
		oBXHint.oIcon.style.marginLeft = "5px";
	},

	PreventDefault : function(e)
	{
		if(!e) e = window.event;
		if(e.stopPropagation)
		{
			e.preventDefault();
			e.stopPropagation();
		}
		else
		{
			e.cancelBubble = true;
			e.returnValue = false;
		}
		return false;
	},

	CreateElement: function(tag, arAttr, arStyles, pDoc)
	{
		if (!pDoc)
			pDoc = document;
		var pEl = pDoc.createElement(tag), p;
		if(arAttr)
		{
			for(p in arAttr)
			{
				if(p == 'className' || p == 'class')
				{
					pEl.setAttribute('class', arAttr[p]);
					if (jsUtils.IsIE())
						pEl.setAttribute('className', arAttr[p]);
					continue;
				}

				if (arAttr[p] != undefined && arAttr[p] != null)
					pEl.setAttribute(p, arAttr[p]);
			}
		}
		if(arStyles)
		{
			for(p in arStyles)
				pEl.style[p] = arStyles[p];
		}
		return pEl;
	},

	in_array: function(needle, haystack)
	{
		for(var i=0; i<haystack.length; i++)
		{
			if(haystack[i] == needle)
				return true;
		}
		return false;
	},

	htmlspecialchars: function(str)
	{
		if(!str.replace)
			return str;

		return str.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	}
}

/************************************************/

function JCFloatDiv()
{
	var _this = this;
	this.floatDiv = null;
	this.x = this.y = 0;

	this.Create = function(arParams)
	{
		var div = document.body.appendChild(document.createElement("DIV"));
		div.id = arParams.id;
		div.style.position = 'absolute';
		div.style.left = '-10000px';
		div.style.top = '-10000px';
		if(arParams.className)
			div.className = arParams.className;
		if(arParams.zIndex)
			div.style.zIndex = arParams.zIndex;
		if(arParams.width)
			div.style.width = arParams.width+'px';
		if(arParams.height)
			div.style.height = arParams.height+'px';
		return div;
	}

	this.Show = function(div, left, top, dxShadow, restrictDrag, showSubFrame)
	{
		if (showSubFrame !== false)
			showSubFrame = true;
		var zIndex = parseInt(div.style.zIndex);
		if(zIndex <= 0 || isNaN(zIndex))
			zIndex = 100;

		//document.title = 'zIndex = ' + zIndex;
		div.style.zIndex = zIndex;

		if (left < 0)
			left = 0;

		if (top < 0)
			top = 0;

		div.style.left = parseInt(left) + "px";
		div.style.top = parseInt(top) + "px";

		if(jsUtils.IsIE() && showSubFrame === true)
		{
			var frame = document.getElementById(div.id+"_frame");
			if(!frame)
			{
				frame = document.createElement("IFRAME");
				frame.src = "javascript:''";
				frame.id = div.id+"_frame";
				frame.style.position = 'absolute';
				frame.style.borderWidth = '0px';
				frame.style.zIndex = zIndex-1;
				document.body.appendChild(frame);
			}
			frame.style.width = div.offsetWidth + "px";
			frame.style.height = div.offsetHeight + "px";
			frame.style.left = div.style.left;
			frame.style.top = div.style.top;
			frame.style.visibility = 'visible';
		}

		/*Restrict drag*/
		div.restrictDrag = restrictDrag || false;

		/*shadow*/
		if(isNaN(dxShadow))
			dxShadow = 5;

		if(dxShadow > 0)
		{
			var img = document.getElementById(div.id+'_shadow');
			if(!img)
			{
				if(jsUtils.IsIE())
				{
		 			img = document.createElement("DIV");
		 			img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/bitrix/themes/"+phpVars.ADMIN_THEME_ID+"/images/shadow.png',sizingMethod='scale')";
				}
				else
				{
		 			img = document.createElement("IMG");
					img.src = '/bitrix/themes/' + phpVars.ADMIN_THEME_ID+'/images/shadow.png';
				}
				img.id = div.id+'_shadow';
				img.style.position = 'absolute';
				img.style.zIndex = zIndex-2;
				img.style.left = '-1000px';
				img.style.top = '-1000px';
				img.style.lineHeight = 'normal';
				img.className = "bx-js-float-shadow";
				document.body.appendChild(img);
			}
			img.style.width = div.offsetWidth+'px';
			img.style.height = div.offsetHeight+'px';
			img.style.left = parseInt(div.style.left)+dxShadow+'px';
			img.style.top = parseInt(div.style.top)+dxShadow+'px';
			img.style.visibility = 'visible';
		}
		div.dxShadow = dxShadow;
	}

	this.Close = function(div)
	{
		if(!div)
			return;
		var sh = document.getElementById(div.id+"_shadow");
		if(sh)
			sh.style.visibility = 'hidden';

		var frame = document.getElementById(div.id+"_frame");
		if(frame)
			frame.style.visibility = 'hidden';
	}

	this.Move = function(div, x, y)
	{
		if(!div)
			return;

		var dxShadow = div.dxShadow;
		var left = parseInt(div.style.left)+x;
		var top = parseInt(div.style.top)+y;

		if (div.restrictDrag)
		{
			//Left side
			if (left < 0)
				left = 0;

			//Right side
			if ( (document.compatMode && document.compatMode == "CSS1Compat"))
				windowWidth = document.documentElement.scrollWidth;
			else
			{
				if (document.body.scrollWidth > document.body.offsetWidth ||
					(document.compatMode && document.compatMode == "BackCompat") ||
					(document.documentElement && !document.documentElement.clientWidth)
				)
					windowWidth = document.body.scrollWidth;
				else
					windowWidth = document.body.offsetWidth;
			}

			var floatWidth = div.offsetWidth;
			if (left > (windowWidth - floatWidth - dxShadow))
				left = windowWidth - floatWidth - dxShadow;

			//Top side
			if (top < 0)
				top = 0;
		}

		div.style.left = left+'px';
		div.style.top = top+'px';

		this.AdjustShadow(div);
	}

	this.HideShadow = function(div)
	{
		var sh = document.getElementById(div.id + "_shadow");
		sh.style.visibility = 'hidden';
	}

	this.UnhideShadow = function(div)
	{
		var sh = document.getElementById(div.id + "_shadow");
		sh.style.visibility = 'visible';
	}

	this.AdjustShadow = function(div)
	{
		var sh = document.getElementById(div.id + "_shadow");
		if(sh && sh.style.visibility != 'hidden')
		{
			var dxShadow = div.dxShadow;

			sh.style.width = div.offsetWidth+'px';
			sh.style.height = div.offsetHeight+'px';
			sh.style.left = parseInt(div.style.left)+dxShadow+'px';
			sh.style.top = parseInt(div.style.top)+dxShadow+'px';
		}

		var frame = document.getElementById(div.id+"_frame");
		if(frame)
		{
			frame.style.width = div.offsetWidth + "px";
			frame.style.height = div.offsetHeight + "px";
			frame.style.left = div.style.left;
			frame.style.top = div.style.top;
		}
	}

	this.StartDrag = function(e, div)
	{
		if(!e)
			e = window.event;
		this.x = e.clientX + document.body.scrollLeft;
		this.y = e.clientY + document.body.scrollTop;
		this.floatDiv = div;

		jsUtils.addEvent(document, "mousemove", this.MoveDrag);
		document.onmouseup = this.StopDrag;
		if(document.body.setCapture)
			document.body.setCapture();

		document.onmousedown = jsUtils.False;
		var b = document.body;
		b.ondrag = jsUtils.False;
		b.onselectstart = jsUtils.False;
		b.style.MozUserSelect = _this.floatDiv.style.MozUserSelect = 'none';
		b.style.cursor = 'move';
	}

	this.StopDrag = function(e)
	{
		if(document.body.releaseCapture)
			document.body.releaseCapture();

		jsUtils.removeEvent(document, "mousemove", _this.MoveDrag);
		document.onmouseup = null;

		this.floatDiv = null;

		document.onmousedown = null;
		var b = document.body;
		b.ondrag = null;
		b.onselectstart = null;
		b.style.MozUserSelect = _this.floatDiv.style.MozUserSelect = '';
		b.style.cursor = '';
	}

	this.MoveDrag = function(e)
	{
		var x = e.clientX + document.body.scrollLeft;
		var y = e.clientY + document.body.scrollTop;

		if(_this.x == x && _this.y == y)
			return;

		_this.Move(_this.floatDiv, (x - _this.x), (y - _this.y));
		_this.x = x;
		_this.y = y;
	}
}
var jsFloatDiv = new JCFloatDiv();

/************************************************/

var BXHint = function(innerHTML, element, addParams)
{
	this.oDivOver = false;
	this.timeOutID = null;
	this.oIcon = null;
	this.freeze = false;
	this.x = 0;
	this.y = 0;
	this.time = 700;

	if (!innerHTML)
		innerHTML = "";
	this.Create(innerHTML, element, addParams);
}

BXHint.prototype.Create = function(innerHTML, element, addParams)
{
	var
		_this = this,
		width = 0,
		height = 0,
		className = null,
		type = "icon";
	this.bWidth = true;

	if (addParams)
	{
		if (addParams.width === false)
			this.bWidth = false;
		else if (addParams.width)
			width = addParams.width;

		if (addParams.height)
			height = addParams.height;

		if (addParams.className)
			className = addParams.className;

		if (addParams.type && (addParams.type == "link" || addParams.type == "icon"))
			type = addParams.type;
		if (addParams.time > 0)
			this.time = addParams.time;
	}

	if (element)
		type = "element";

	if (type == "icon")
	{
		var element = document.createElement("IMG");
		element.src = (addParams && addParams.iconSrc) ? addParams.iconSrc : "/bitrix/themes/"+phpVars.ADMIN_THEME_ID+"/public/popup/hint.gif";
		element.ondrag = jsUtils.False;
	}
	else if (type == "link")
	{
		var element = document.createElement("A");
		element.href = "";
		element.onclick = function(e){return false;}
		element.innerHTML = "[?]";
	}

	this.element = element;
	if (type == "element")
	{
		if(addParams && addParams.show_on_click)
		{
			jsUtils.addEvent(
				element,
				"click",
				function (event)
				{
					if (!event)
						event = window.event;
					_this.GetMouseXY(event);
					_this.timeOutID = setTimeout(function () {_this.Show(innerHTML,width,height,className) }, 10);
				}
			);
		}
		else
		{
			jsUtils.addEvent(
				element,
				"mouseover",
				function (event)
				{
					if (!event)
						event = window.event;
					_this.GetMouseXY(event);
					_this.timeOutID = setTimeout(function () {_this.Show(innerHTML,width,height,className) }, 750);
				}
			);
		}

		jsUtils.addEvent(
			element,
			"mouseout",
			function(event)
			{
				if (_this.timeOutID)
					clearTimeout(_this.timeOutID);
				_this.SmartHide(_this);
			}
		);
	}
	else
	{
		this.oIcon = element;
		element.onmouseover = function(event) {if (!event) event = window.event; _this.GetMouseXY(event); _this.Show(innerHTML,width,height,className)};
		element.onmouseout = function() {_this.SmartHide(_this);};
	}
}

BXHint.prototype.IsFrozen = function()
{
	return this.freeze;
}

BXHint.prototype.Freeze = function()
{
	this.freeze = true;
	this.Hide();
}

BXHint.prototype.UnFreeze = function()
{
	this.freeze = false;
}

BXHint.prototype.GetMouseXY = function(event)
{
	if (event.pageX || event.pageY)
	{
		this.x = event.pageX;
		this.y = event.pageY;
	}
	else if (event.clientX || event.clientY)
	{
		this.x = event.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
		this.y = event.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
	}
}

BXHint.prototype.Show = function(innerHTML, width, height, className)
{
	//Delete previous hint
	var old = document.getElementById("__BXHint_div");
	if (old)
		this.Hide();

	if (this.freeze)
		return;

	var _this = this;
	var oDiv = document.body.appendChild(document.createElement("DIV"));
	oDiv.onmouseover = function(){_this.oDivOver = true};
	oDiv.onmouseout = function(){_this.oDivOver = false; _this.SmartHide(_this);}
	oDiv.id = "__BXHint_div";
	oDiv.className = (className) ? className : "bxhint";
	oDiv.style.position = 'absolute';
	if (width && this.bWidth)
		oDiv.style.width = width + "px";

	if (height)
		oDiv.style.height = height + "px";
	oDiv.innerHTML = innerHTML;

	var w = oDiv.offsetWidth;
	var h = oDiv.offsetHeight;
	if (this.bWidth)
	{
		if (!width && w>200)
			w = Math.round(Math.sqrt(1.618*w*h));
		oDiv.style.width = w + "px";
		h = oDiv.offsetHeight;
	}

	var pos = {left : this.x + 10, right : this.x + w, top : this.y, bottom : this.y + h};

	pos = this.AlignToPos(pos, w, h);

	oDiv.style.zIndex = 2100;

	jsFloatDiv.Show(oDiv, pos.left, pos.top,3);

//	oDiv.ondrag = jsUtils.False;
//	oDiv.onselectstart = jsUtils.False;
//	oDiv.style.MozUserSelect = 'none';
	oDiv = null;
}

BXHint.prototype.AlignToPos = function(pos, w, h)
{
	var body = document.body;
	if((body.clientWidth + body.scrollLeft) < (pos.left + w))
		pos.left = (pos.left - w >= 0) ? (pos.left - w) : body.scrollLeft;

	if((body.clientHeight + body.scrollTop) - (pos["bottom"]) < 0)
		pos.top = (pos.top - h >= 0) ? (pos.top - h) : body.scrollTop;

	return pos;
}

BXHint.prototype.Hide = function()
{
	var oDiv = document.getElementById("__BXHint_div");

	if (!oDiv)
		return;

	jsFloatDiv.Close(oDiv);
	oDiv.parentNode.removeChild(oDiv);
	oDiv = null;
}

BXHint.prototype.SmartHide = function(_this)
{
	setTimeout(function ()
		{
			if (!_this.oDivOver)
				_this.Hide();
		}, 100
	);
}

/************************************************/

function WaitOnKeyPress(e)
{
	if(!e) e = window.event
	if(!e) return;
	if(e.keyCode == 27)
		CloseWaitWindow();
}

function ShowWaitWindow()
{
	CloseWaitWindow();

	var obWndSize = jsUtils.GetWindowSize();

	var div = document.body.appendChild(document.createElement("DIV"));
	div.id = "wait_window_div";
	div.innerHTML = phpVars.messLoading;
	div.className = "waitwindow";
	//div.style.left = obWndSize.scrollLeft + (obWndSize.innerWidth - div.offsetWidth) - (jsUtils.IsIE() ? 5 : 20) + "px";
	div.style.right = (5 - obWndSize.scrollLeft) + 'px';
	div.style.top = obWndSize.scrollTop + 5 + "px";

	if(jsUtils.IsIE())
	{
		var frame = document.createElement("IFRAME");
		frame.src = "javascript:''";
		frame.id = "wait_window_frame";
		frame.className = "waitwindow";
		frame.style.width = div.offsetWidth + "px";
		frame.style.height = div.offsetHeight + "px";
		frame.style.right = div.style.right;
		frame.style.top = div.style.top;
		document.body.appendChild(frame);
	}
	jsUtils.addEvent(document, "keypress", WaitOnKeyPress);
}

function CloseWaitWindow()
{
	jsUtils.removeEvent(document, "keypress", WaitOnKeyPress);

	var frame = document.getElementById("wait_window_frame");
	if(frame)
		frame.parentNode.removeChild(frame);

	var div = document.getElementById("wait_window_div");
	if(div)
		div.parentNode.removeChild(div);
}

/************************************************/

var jsSelectUtils =
{
	addNewOption: function(select_id, opt_value, opt_name, do_sort, check_unique)
	{
		var oSelect = (typeof(select_id) == 'string' || select_id instanceof String? document.getElementById(select_id) : select_id);
		if(oSelect)
		{
			var n = oSelect.length;
			if(check_unique !== false)
			{
				for(var i=0;i<n;i++)
					if(oSelect[i].value==opt_value)
						return;
			}
			var newoption = new Option(opt_name, opt_value, false, false);
			oSelect.options[n]=newoption;
		}
		if(do_sort === true)
			this.sortSelect(select_id);
	},

	deleteOption: function(select_id, opt_value)
	{
		var oSelect = (typeof(select_id) == 'string' || select_id instanceof String? document.getElementById(select_id) : select_id);
		if(oSelect)
		{
			for(var i=0;i<oSelect.length;i++)
				if(oSelect[i].value==opt_value)
				{
					oSelect.remove(i);
					break;
				}
		}
	},

	deleteSelectedOptions: function(select_id)
	{
		var oSelect = (typeof(select_id) == 'string' || select_id instanceof String? document.getElementById(select_id) : select_id);
		if(oSelect)
		{
			var i=0;
			while(i<oSelect.length)
				if(oSelect[i].selected)
				{
					oSelect[i].selected=false;
					oSelect.remove(i);
				}
				else
					i++;
		}
	},

	deleteAllOptions: function(oSelect)
	{
		if(oSelect)
		{
			for(var i=oSelect.length-1; i>=0; i--)
				oSelect.remove(i);
		}
	},

	optionCompare: function(record1, record2)
	{
		var value1 = record1.optText.toLowerCase();
		var value2 = record2.optText.toLowerCase();
		if (value1 > value2) return(1);
		if (value1 < value2) return(-1);
		return(0);
	},

	sortSelect: function(select_id)
	{
		var oSelect = (typeof(select_id) == 'string' || select_id instanceof String? document.getElementById(select_id) : select_id);
		if(oSelect)
		{
			var myOptions = [];
			var n = oSelect.options.length;
			for (var i=0;i<n;i++)
			{
				myOptions[i] = {
					optText:oSelect[i].text,
					optValue:oSelect[i].value
				};
			}
			myOptions.sort(this.optionCompare);
			oSelect.length=0;
			n = myOptions.length;
			for(var i=0;i<n;i++)
			{
				var newoption = new Option(myOptions[i].optText, myOptions[i].optValue, false, false);
				oSelect[i]=newoption;
			}
		}
	},

	selectAllOptions: function(select_id)
	{
		var oSelect = (typeof(select_id) == 'string' || select_id instanceof String? document.getElementById(select_id) : select_id);
		if(oSelect)
		{
			var n = oSelect.length;
			for(var i=0;i<n;i++)
				oSelect[i].selected=true;
		}
	},

	selectOption: function(select_id, opt_value)
	{
		var oSelect = (typeof(select_id) == 'string' || select_id instanceof String? document.getElementById(select_id) : select_id);
		if(oSelect)
		{
			var n = oSelect.length;
			for(var i=0;i<n;i++)
				oSelect[i].selected = (oSelect[i].value == opt_value);
		}
	},

	addSelectedOptions: function(oSelect, to_select_id, check_unique, do_sort)
	{
		if(!oSelect)
			return;
		var n = oSelect.length;
		for(var i=0; i<n; i++)
			if(oSelect[i].selected)
				this.addNewOption(to_select_id, oSelect[i].value, oSelect[i].text, do_sort, check_unique);
	},

	moveOptionsUp: function(oSelect)
	{
		if(!oSelect)
			return;
		var n = oSelect.length;
		for(var i=0; i<n; i++)
		{
			if(oSelect[i].selected && i>0 && oSelect[i-1].selected == false)
			{
				var option1 = new Option(oSelect[i].text, oSelect[i].value);
				var option2 = new Option(oSelect[i-1].text, oSelect[i-1].value);
				oSelect[i] = option2;
				oSelect[i].selected = false;
				oSelect[i-1] = option1;
				oSelect[i-1].selected = true;
			}
		}
	},

	moveOptionsDown: function(oSelect)
	{
		if(!oSelect)
			return;
		var n = oSelect.length;
		for(var i=n-1; i>=0; i--)
		{
			if(oSelect[i].selected && i<n-1 && oSelect[i+1].selected == false)
			{
				var option1 = new Option(oSelect[i].text, oSelect[i].value);
				var option2 = new Option(oSelect[i+1].text, oSelect[i+1].value);
				oSelect[i] = option2;
				oSelect[i].selected = false;
				oSelect[i+1] = option1;
				oSelect[i+1].selected = true;
			}
		}
	}

}

/************************************************/
/* End */
;
; /* Start:/bitrix/js/main/admin_tools.js*/
var phpVars;
if(!phpVars)
{
	phpVars = {
		ADMIN_THEME_ID: '.default',
		LANGUAGE_ID: 'en',
		FORMAT_DATE: 'DD.MM.YYYY',
		FORMAT_DATETIME: 'DD.MM.YYYY HH:MI:SS',
		opt_context_ctrl: false,
		cookiePrefix: 'BITRIX_SM',
		titlePrefix: '',
		bitrix_sessid: '',
		messHideMenu: '',
		messShowMenu: '',
		messHideButtons: '',
		messShowButtons: '',
		messFilterInactive: '',
		messFilterActive: '',
		messFilterLess: '',
		messLoading: 'Loading...',
		messMenuLoading: '',
		messMenuLoadingTitle: '',
		messNoData: '',
		messExpandTabs: '',
		messCollapseTabs: '',
		messPanelFixOn: '',
		messPanelFixOff: '',
		messPanelCollapse: '',
		messPanelExpand: '',
		messFavAddSucc: '',
		messFavAddErr: '',
		messFavDelSucc: '',
		messFavDelErr: ''
	};
}

function JCSplitter(params)
{
	this.params = params;

	this.Highlight = function(on)
	{
		var control = document.getElementById(this.params.control);
		var div = document.getElementById(this.params.divShown);
		if(div.style.display!="none")
			control.className = this.params.classShown+(on? 'sel':'');
		else
			control.className = this.params.classHidden+(on? 'sel':'');
	}

	this.Toggle = function()
	{
		var visible = jsUtils.ToggleDiv(this.params.divShown);
		jsUtils.ToggleDiv(this.params.divHidden);
		this.Highlight(false);
		document.getElementById(this.params.control).title = (visible? this.params.messHide : this.params.messShow);
		return visible;
	}
}

/************************************************/

function JCAdminMenu(sOpenedSections)
{
	var _this = this;
	this.sMenuSelected='';
	this.x = 0;
	this.divToResize = null;
	this.divToBound = null;
	this.toggle = false;
	this.oSections = {};
	this.request = new JCHttpRequest();

	var aSect = sOpenedSections.split(',');
	for(var i in aSect)
		this.oSections[aSect[i]] = true;

	this.verSplitter = new JCSplitter({
		control:'vdividercell',
		divShown:'menudiv', divHidden:'hiddenmenucontainer',
		messHide:phpVars.messHideMenu, messShow:phpVars.messShowMenu,
		classShown:'vdividerknob vdividerknobleft', classHidden:'vdividerknob vdividerknobright'
	});
	this.horSplitter = new JCSplitter({
		control:'hdividercell',
		divShown:'buttonscontainer', divHidden:'smbuttonscontainer',
		messHide:phpVars.messHideButtons, messShow:phpVars.messShowButtons,
		classShown:'hdividerknob hdividerknobup', classHidden:'hdividerknob hdividerknobdown'
	});

	this.verSplitterToggle = function()
	{
		var visible = this.verSplitter.Toggle();
		jsUserOptions.SaveOption('admin_menu', 'pos', 'ver', (visible? 'on':'off'));
	}

	this.horSplitterToggle = function()
	{
		var visible = this.horSplitter.Toggle();
		jsUserOptions.SaveOption('admin_menu', 'pos', 'hor', (visible? 'on':'off'));
	}

	this.ToggleMenu = function(menu_id, menu_text)
	{
		var div = document.getElementById(menu_id);
		if(div.style.display!="none")
			return;

		/*menu div*/
		if(this.sMenuSelected != "")
			document.getElementById(this.sMenuSelected).style.display = 'none';
		div.style.display = "block";

		/*button*/
		document.getElementById('menutitle').innerHTML = menu_text;

		document.getElementById('btn_'+this.sMenuSelected).className = 'button';
		document.getElementById('smbtn_'+this.sMenuSelected).className = 'smbutton';
		document.getElementById('btn_'+menu_id).className = 'button buttonsel';
		document.getElementById('smbtn_'+menu_id).className = 'smbutton smbuttonsel';

		this.sMenuSelected = menu_id;
	}

	this.StartDrag = function()
	{
		if(this.toggle)
			return;
		if(document.getElementById('menudiv').style.display == 'none')
			return;

		this.divToBound = document.getElementById("menu_min_width");
		this.divToResize = document.getElementById('menucontainer');
		this.x = this.divToResize.offsetWidth;

		jsUtils.addEvent(document, "mousemove", _this.ResizeMenu);
		document.onmouseup = this.StopDrag;

		var b = document.body;
	    b.ondrag = jsUtils.False;
	    b.onselectstart = jsUtils.False;
	    b.style.MozUserSelect = 'none';
	    b.style.cursor = 'e-resize';
    }

	this.StopDrag = function(e)
	{
		jsUtils.removeEvent(document, "mousemove", _this.ResizeMenu);
		document.onmouseup = null;

		var b = document.body;
		b.ondrag = null;
		b.onselectstart = null;
		b.style.MozUserSelect = '';
	    b.style.cursor = '';

	    if(window.onresize)
	    	window.onresize();

		jsUserOptions.SaveOption('admin_menu', 'pos', 'width', parseInt(_this.divToResize.style.width));
	}

	this.ResizeMenu = function(e)
	{
		var x = e.clientX + document.body.scrollLeft;
		if(	_this.x == x)
			return;

		var div = _this.divToResize;
		var mnu = _this.divToBound;

		if(x < mnu.offsetWidth)
		{
			div.style.width = mnu.offsetWidth+'px';
			_this.x = x;
			return;
		}

		div.style.width = div.offsetWidth+(x - _this.x)+'px';
		_this.x = x;
	}

	this.ToggleSection = function(cell, div_id, level)
	{
		if(jsUtils.ToggleDiv(div_id))
		{
			if(level <= 2)
				this.oSections[div_id] = true;
			cell.className='sign signminus';
		}
		else
		{
			this.oSections[div_id] = false;
			cell.className='sign signplus';
		}

		if(level <= 2)
		{
			var sect='';
			for(var i in this.oSections)
				if(this.oSections[i] == true)
					sect += (sect != ''? ',':'')+i;
			jsUserOptions.SaveOption('admin_menu', 'pos', 'sections', sect);
		}
	}

	this.ToggleDynSection = function(cell, module_id, div_id, level)
	{
		function MenuText(text)
		{
			var s = '';
			for(var i=0; i<level; i++)
				s += '<td><div class="menuindent"></div></td>\n';
			return(
				'<div class="menuline">'+
				'<table cellspacing="0">'+
				'	<tr>'+s+
				'		<td class="menutext menutext-loading">'+text+'</td>'+
				'	</tr>'+
				'</table>'+
				'</div>');
		}

		var div = document.getElementById(div_id);
		if(div.innerHTML == '')
		{
			div.innerHTML = MenuText(phpVars.messMenuLoading);

			this.request.Action = function(result)
			{
				result = jsUtils.trim(result);
				div.innerHTML = (result != ''? result : MenuText(phpVars.messNoData));
			}
			this.request.Send('/bitrix/admin/get_menu.php?lang='+phpVars.LANGUAGE_ID+'&admin_mnu_module_id='+module_id+'&admin_mnu_menu_id='+encodeURIComponent(div_id));
		}
		this.ToggleSection(cell, div_id, level);
	}
}



/***************************************/

function JCAdminList(table_id)
{
	var _this = this;
	this.table_id = table_id;

	this.InitTable = function()
	{
		var tbl = document.getElementById(this.table_id);
		if(!tbl || tbl.rows.length<1 || tbl.rows[0].cells.length<1)
			return;

		var i;
		var nCols = tbl.rows[0].cells.length;
		var sortedIndex = -1;

		/*head row mousover action*/
		for(i=0; i<nCols; i++)
		{
			var j;
			var cell_sort = tbl.rows[1].cells[i];
			var sort_table = jsUtils.FindChildObject(cell_sort, "table", "sorting");

			for(j=0; j<2; j++)
			{
				var cell = tbl.rows[j].cells[i];

				cell.onmouseover = function(){_this.HighlightGutter(this, true)};
				cell.onmouseout = function(){_this.HighlightGutter(this, false)};

				/*expand sorting table behaviour on parent cell*/
				if(sort_table)
				{
					cell.onclick = sort_table.onclick;
					cell.title = sort_table.title;
					cell.style.cursor = "pointer";

					if(j == 0)
					{
						var cl = sort_table.rows[0].cells[1].className.toLowerCase();
						if(cl == "sign up" || cl == "sign down")
						{
							cell.className += ' sorted';
							sortedIndex = i;
						}
					}
				}
			}
			if(sort_table)
				sort_table.onclick = null;
		}

		var n = tbl.rows.length;
		for(i=0; i<n; i++)
		{
			var row = tbl.rows[i];

			/*first and last columns style classes*/
			row.cells[0].className += ' left';
	 		row.cells[row.cells.length-1].className += ' right';

	 		if(row.className && row.className == 'footer')
	 			continue;

			/*sorted column*/
			if(sortedIndex != -1 && sortedIndex < row.cells.length)
				row.cells[sortedIndex].className += ' sorted';

			if(i>=2)
			{
				/*first column checkbox action*/
				var checkbox = row.cells[0].childNodes[0];
				if(checkbox && checkbox.tagName && checkbox.tagName.toUpperCase() == "INPUT" && checkbox.type.toUpperCase() == "CHECKBOX")
				{
					checkbox.onclick = function(){_this.SelectRow(this); _this.EnableActions()};
					jsUtils.addEvent(row, "click", _this.OnClickRow);
				}

				/*rows mousover action*/
				row.onmouseover = function(){_this.HighlightRow(this, true)};
				row.onmouseout = function(){_this.HighlightRow(this, false)};

				if(i%2 == 0)
					row.className += ' odd';
				else
					row.className += ' even';

				if(row.oncontextmenu)
				{
					jsUtils.addEvent(row, "contextmenu",
						function(e)
						{
							if(!e) e = window.event;
							if(!phpVars.opt_context_ctrl && e.ctrlKey || phpVars.opt_context_ctrl && !e.ctrlKey)
								return;

							var targetElement;
							if(e.target) targetElement = e.target;
							else if(e.srcElement) targetElement = e.srcElement;

							while(targetElement && !targetElement.oncontextmenu)
								targetElement = jsUtils.FindParentObject(targetElement, "tr");

							var x = e.clientX + document.body.scrollLeft;
							var y = e.clientY + document.body.scrollTop;
							var pos = {};
							pos['left'] = pos['right'] = x;
							pos['top'] = pos['bottom'] = y;

							var menu = window[_this.table_id+"_menu"];
							menu.PopupHide();
							menu.SetItems(targetElement.oncontextmenu());
							menu.BuildItems();
							menu.PopupShow(pos);

							e.returnValue = false;
							if(e.preventDefault) e.preventDefault();
						}
					);
				}
			}
		}

		if(tbl.rows.length > 2)
		{
			tbl.rows[2].className += ' top';
			tbl.rows[tbl.rows.length-1].className += ' bottom';
		}
	}

	this.Destroy = function(bLast)
	{
		var tbl = document.getElementById(this.table_id);
		if(!tbl || tbl.rows.length<1 || tbl.rows[0].cells.length<1)
			return;

		var i;
		var nCols = tbl.rows[0].cells.length;
		for(i=0; i<nCols; i++)
		{
			var j;
			for(j=0; j<2; j++)
			{
				var cell = tbl.rows[j].cells[i];
				cell.onmouseover = null;
				cell.onmouseout = null;
				cell.onclick = null;
			}
		}
		var n = tbl.rows.length;
		for(i=0; i<n; i++)
		{
			var row = tbl.rows[i];
			var checkbox = row.cells[0].childNodes[0];
			if(checkbox && checkbox.onclick)
				checkbox.onclick = null;
			row.onmouseover = null;
			row.onmouseout = null;
			jsUtils.removeAllEvents(row);
		}
		if(bLast == true)
			_this = null;
	}

	this.HighlightGutter = function(cell, on)
	{
		var table = cell.parentNode.parentNode.parentNode;
		var gutter = table.rows[0].cells[cell.cellIndex];
		if(on)
			gutter.className += ' over';
		else
			gutter.className = gutter.className.replace(/\s*over/i, '');
	}

	this.HighlightRow = function(row, on)
	{
		if(on)
			row.className += ' over';
		else
			row.className = row.className.replace(/\s*over/i, '');
	}

	this.SelectRow = function(checkbox)
	{
		var row = checkbox.parentNode.parentNode;
		var tbl = row.parentNode.parentNode;
		var span = document.getElementById(tbl.id+'_selected_span');
		var selCount = parseInt(span.innerHTML);

		if(checkbox.checked)
		{
			row.className += ' selected';
			selCount++;
		}
		else
		{
			row.className = row.className.replace(/\s*selected/ig, '');
			selCount--;
		}
		span.innerHTML = selCount;

		var checkAll = document.getElementById(tbl.id+'_check_all');
		if(selCount == tbl.rows.length-2)
			checkAll.checked = true;
		else
			checkAll.checked = false;
	}

	this.OnClickRow = function(e)
	{
		if(!e)
			var e = window.event;
		if(!e.ctrlKey)
			return;
		var obj = (e.target? e.target : (e.srcElement? e.srcElement : null));
		if(!obj)
			return;
		if(!obj.parentNode.cells)
			return;
		var checkbox = obj.parentNode.cells[0].childNodes[0];
		if(checkbox && checkbox.tagName && checkbox.tagName.toUpperCase() == "INPUT" && checkbox.type.toUpperCase() == "CHECKBOX" && !checkbox.disabled)
		{
			checkbox.checked = !checkbox.checked;
			_this.SelectRow(checkbox);
		}
		_this.EnableActions();
	}

	this.SelectAllRows = function(checkbox)
	{
		var tbl = checkbox.parentNode.parentNode.parentNode.parentNode;
		var bChecked = checkbox.checked;
		var i;
		var n = tbl.rows.length;
		for(i=2; i<n; i++)
		{
			var box = tbl.rows[i].cells[0].childNodes[0];
			if(box && box.tagName && box.tagName.toUpperCase() == 'INPUT' && box.type.toUpperCase() == "CHECKBOX")
			{
				if(box.checked != bChecked && !box.disabled)
				{
					box.checked = bChecked;
					this.SelectRow(box);
				}
			}
		}
		this.EnableActions();
	}

	this.EnableActions = function()
	{
		var form = document.forms['form_'+this.table_id];
		if(!form) return;

		var bEnabled = this.IsActionEnabled();
		var bEnabledEdit = this.IsActionEnabled('edit');

		if(form.apply) form.apply.disabled = !bEnabled;
		var b = document.getElementById('action_edit_button');
		if(b) b.className = 'context-button icon action-edit-button'+(bEnabledEdit? '':'-dis');
		b = document.getElementById('action_delete_button');
		if(b) b.className = 'context-button icon action-delete-button'+(bEnabled? '':'-dis');
	}

	this.IsActionEnabled = function(action)
	{
		var form = document.forms['form_'+this.table_id];
		if(!form) return;

		var bChecked = false;
		var span = document.getElementById(this.table_id+'_selected_span');
		if(span && parseInt(span.innerHTML)>0)
			bChecked = true;

		if(action == 'edit')
			return !(form.action_target && form.action_target.checked) && bChecked;
		else
			return (form.action_target && form.action_target.checked) || bChecked;
	}

	this.SetActiveResult = function(callback, url)
	{
		CHttpRequest.Action = function(result)
		{
			CloseWaitWindow();
			_this.Destroy(false);
			document.getElementById(_this.table_id+"_result_div").innerHTML = result;
			_this.InitTable();
			jsAdminChain.AddItems(_this.table_id+"_navchain_div");
			if(callback)
				callback(url);
		}
	}

	this.GetAdminList = function(url, callback)
	{
		ShowWaitWindow();

		var re = new RegExp('&mode=list&table_id='+escape(_this.table_id), 'g');
		url = url.replace(re, '');

		var link = document.getElementById('navchain-link');
		if(link)
			link.href = url;

		if(url.indexOf('?')>=0)
			url += '&mode=list&table_id='+escape(_this.table_id);
		else
			url += '?&mode=list&table_id='+escape(_this.table_id);

		_this.SetActiveResult(callback, url);
		CHttpRequest.Send(url);
	}

	this.Sort = function(url, bCheckCtrl, args)
	{
		if(bCheckCtrl == true)
		{
			var e = null, bControl = false;
			if(args.length > 0)
				e = args[0];
			if(!e)
				e = window.event;
			if(e)
				bControl = e.ctrlKey;
			url += (bControl? 'desc':'asc');
		}
		this.GetAdminList(url);
	}

	this.PostAdminList = function(url)
	{
		if(url.indexOf('?')>=0)
			url += '&mode=frame&table_id='+escape(this.table_id);
		else
			url += '?mode=frame&table_id='+escape(this.table_id);

		var frm = document.getElementById('form_'+this.table_id);

		try{frm.action.act.parentNode.removeChild(frm.action);}catch(e){}

		frm.action = url;
		frm.onsubmit();
		frm.submit();
	}

	this.ShowSettings = function(url)
	{
		if(document.getElementById("settings_float_div"))
			return;

		CHttpRequest.Action = function(result)
		{
			CloseWaitWindow();

			if(result == '')
				return;

			var div = document.body.appendChild(document.createElement("DIV"));
			div.id = "settings_float_div";
			div.className = "settings-float-form";
			div.style.position = 'absolute';
			div.style.zIndex = 1000;
			div.innerHTML = result;

			var left = parseInt(document.body.scrollLeft + document.body.clientWidth/2 - div.offsetWidth/2);
			var top = parseInt(document.body.scrollTop + document.body.clientHeight/2 - div.offsetHeight/2);
			jsFloatDiv.Show(div, left, top);

			jsUtils.addEvent(document, "keypress", _this.SettingsOnKeyPress);
		}
		ShowWaitWindow();
		CHttpRequest.Send(url);
	}

	this.CloseSettings =  function()
	{
		jsUtils.removeEvent(document, "keypress", _this.SettingsOnKeyPress);
		var div = document.getElementById("settings_float_div");
		jsFloatDiv.Close(div);
		div.parentNode.removeChild(div);
	}

	this.SettingsOnKeyPress = function(e)
	{
		if(!e) e = window.event
		if(!e) return;
		if(e.keyCode == 27)
			_this.CloseSettings();
	}

	this.SaveSettings =  function()
	{
		ShowWaitWindow();

		var sCols='', sBy='', sOrder='', sPageSize='';

		var oSelect = document.list_settings.selected_columns;
		var n = oSelect.length;
		for(var i=0; i<n; i++)
			sCols += (sCols != ''? ',':'')+oSelect[i].value;

		oSelect = document.list_settings.order_field;
		if(oSelect)
			sBy = oSelect[oSelect.selectedIndex].value;

		oSelect = document.list_settings.order_direction;
		if(oSelect)
			sOrder = oSelect[oSelect.selectedIndex].value;

		oSelect = document.list_settings.nav_page_size;
		sPageSize = oSelect[oSelect.selectedIndex].value;

		var bCommon = (document.list_settings.set_default && document.list_settings.set_default.checked);

		jsUserOptions.SaveOption('list', this.table_id, 'columns', sCols, bCommon);
		jsUserOptions.SaveOption('list', this.table_id, 'by', sBy, bCommon);
		jsUserOptions.SaveOption('list', this.table_id, 'order', sOrder, bCommon);
		jsUserOptions.SaveOption('list', this.table_id, 'page_size', sPageSize, bCommon);

		var url = window.location.href;
		jsUserOptions.SendData(function(){_this.GetAdminList(url, _this.CloseSettings);});
	}

	this.DeleteSettings = function(bCommon)
	{
		ShowWaitWindow();
		var url = window.location.href;
		jsUserOptions.DeleteOption('list', this.table_id, bCommon, function(){_this.GetAdminList(url, _this.CloseSettings);});
	}
}

/************************************************/

function TabControl(name, unique_name, aTabs)
{
	var _this = this;
	this.name = name;
	this.unique_name = unique_name;
	this.aTabs = aTabs;
	this.aTabsDisabled = {};
	this.bExpandTabs = false;

	this.AUTOSAVE = null;

	var auto_lnk = BX(this.name + '_autosave_link');
	if (auto_lnk)
	{
		auto_lnk.title = BX.message('AUTOSAVE_T');
		BX.addCustomEvent('onAutoSavePrepare', function (ob, h) {
			BX.bind(auto_lnk, 'click', BX.proxy(ob.Save, ob));
		});
		BX.addCustomEvent('onAutoSave', function() {
			auto_lnk.className = 'context-button bx-core-autosave bx-core-autosave-saving';
		});
		BX.addCustomEvent('onAutoSaveFinished', function(ob, t) {
			t = parseInt(t);
			if (!isNaN(t))
			{
				setTimeout(function() {
					auto_lnk.className = 'context-button bx-core-autosave bx-core-autosave-ready';
				}, 1000);
				auto_lnk.title = BX.message('AUTOSAVE_L').replace('#DATE#', BX.formatDate(new Date(t * 1000)));
			}
		});
		BX.addCustomEvent('onAutoSaveInit', function() {
			auto_lnk.className = 'context-button bx-core-autosave bx-core-autosave-edited';
		});
	}


	this.NextTab = function()
	{
		var SelectedTab = BX.findChild(document, {'className': 'tab-selected'}, true );
		//let's cut "tab_" and take tab name or tab_cont_
		if(SelectedTab)
			var CurrentTab=SelectedTab.id.substr(4);
		else
		{
			var SelectedTab = BX.findChild(document, {'className': 'tab-container-selected'}, true );
			var CurrentTab=SelectedTab.id.substr(9);
		}

		var NextTab="";

		for(var i=0; i<this.aTabs.length; i++)
			{
				if(CurrentTab==this.aTabs[i]["DIV"])
				{
					if(i>=(this.aTabs.length-1))
						NextTab=this.aTabs[0];
					else
						NextTab=this.aTabs[i+1];
				}
			}

		if(NextTab["DIV"])
			this.SelectTab(NextTab["DIV"]);
	}


	this.SelectTab = function(tab_id)
	{
		var div = document.getElementById(tab_id);
		if(div.style.display != 'none')
			return;

		for (var i = 0, cnt = this.aTabs.length; i < cnt; i++)
		{
			var tab = document.getElementById(this.aTabs[i]["DIV"])
			if(tab.style.display != 'none')
			{
				this.ShowTab(this.aTabs[i]["DIV"], false);
				tab.style.display = 'none';
				break;
			}
		}

		this.ShowTab(tab_id, true);
		div.style.display = 'block';

		document.getElementById(this.name+'_active_tab').value = tab_id;

		for (var i = 0, cnt = this.aTabs.length; i < cnt; i++)
			if(this.aTabs[i]["DIV"] == tab_id)
			{
				this.aTabs[i]["_ACTIVE"] = true;
				if(this.aTabs[i]["ONSELECT"])
					eval(this.aTabs[i]["ONSELECT"]);
				break;
			}
	}

	this.ShowTab = function(tab_id, on)
	{
		var sel = (on? '-selected':'');
		try{
		document.getElementById('tab_cont_'+tab_id).className = 'tab-container'+sel;
		document.getElementById('tab_left_'+tab_id).className = 'tab-left'+sel;
		document.getElementById('tab_'+tab_id).className = 'tab'+sel;
		if(tab_id != this.aTabs[this.aTabs.length-1]["DIV"])
			document.getElementById('tab_right_'+tab_id).className = 'tab-right'+sel;
		else
			document.getElementById('tab_right_'+tab_id).className = 'tab-right-last'+sel;
		}catch(e){}
	}

	this.HoverTab = function(tab_id, on)
	{
		var tab = document.getElementById('tab_'+tab_id);
		if(tab.className == 'tab-selected')
			return;

		document.getElementById('tab_left_'+tab_id).className = (on? 'tab-left-hover':'tab-left');
		tab.className = (on? 'tab-hover':'tab');
		var tab_right = document.getElementById('tab_right_'+tab_id);
		if(tab_id != this.aTabs[this.aTabs.length-1]["DIV"])
			tab_right.className = (on? 'tab-right-hover':'tab-right');
		else
			tab_right.className = (on? 'tab-right-last-hover':'tab-right-last');
	}

	this.InitEditTables = function()
	{
		for(var tab = 0, cnt = this.aTabs.length; tab < cnt; tab++)
		{
			var div = document.getElementById(this.aTabs[tab]["DIV"]);
			var tbl = jsUtils.FindChildObject(div.firstChild, 'table', 'edit-table');
			if(!tbl)
			{
				var tbl = jsUtils.FindChildObject(div, 'table', 'edit-table');
				if (!tbl)
					continue;
			}

			var n = tbl.rows.length;
			for(var i=0; i<n; i++)
				if(tbl.rows[i].cells.length > 1)
					tbl.rows[i].cells[0].className = 'field-name';
		}
	}

	this.DisableTab = function(tab_id)
	{
		this.aTabsDisabled[tab_id] = true;
		this.ShowDisabledTab(tab_id, true);
		if(this.bExpandTabs)
		{
			var div = document.getElementById(tab_id);
			div.style.display = 'none';
		}
	}

	this.EnableTab = function(tab_id)
	{
		this.aTabsDisabled[tab_id] = false;
		this.ShowDisabledTab(tab_id, this.bExpandTabs);
		if(this.bExpandTabs)
		{
			var div = document.getElementById(tab_id);
			div.style.display = 'block';
		}
	}

	this.ShowDisabledTab = function(tab_id, disabled)
	{
		var tab = document.getElementById('tab_cont_'+tab_id);
		if(disabled)
		{
			tab.className = 'tab-container-disabled';
			tab.onclick = null;
			tab.onmouseover = null;
			tab.onmouseout = null;
		}
		else
		{
			tab.className = 'tab-container';
			tab.onclick = function(){_this.SelectTab(tab_id);};
			tab.onmouseover = function(){_this.HoverTab(tab_id, true);};
			tab.onmouseout = function(){_this.HoverTab(tab_id, false);};
		}
	}

	this.Destroy = function()
	{
		//for(var i in this.aTabs)
		for(var i = 0, cnt = this.aTabs.length; i < cnt; i++)
		{
			var tab = document.getElementById('tab_cont_'+this.aTabs[i]["DIV"]);
			if (!tab)
				continue;
			tab.onclick = null;
			tab.onmouseover = null;
			tab.onmouseout = null;
		}
		_this = null;
	}

	this.ToggleTabs = function()
	{
		this.bExpandTabs = !this.bExpandTabs;

		var a = document.getElementById(this.name+'_expand_link');
		a.title = (this.bExpandTabs? phpVars.messCollapseTabs : phpVars.messExpandTabs);
		a.className = (this.bExpandTabs? a.className.replace(/\s*down/ig, ' up') : a.className.replace(/\s*up/ig, ' down'));

		for(var i in this.aTabs)
		{
			var tab_id = this.aTabs[i]["DIV"];
			this.ShowTab(tab_id, false);
			this.ShowDisabledTab(tab_id, (this.bExpandTabs || this.aTabsDisabled[tab_id]));
			var div = document.getElementById(tab_id);
			div.style.display = (this.bExpandTabs && !this.aTabsDisabled[tab_id]? 'block':'none');
			if(i > 0)
			{
				var tbl = jsUtils.FindChildObject(div.firstChild, 'table', 'edit-tab-title');
				if(this.bExpandTabs)
				{
					try{
						tbl.rows[0].style.display = 'table-row';
					}
					catch(e){
						tbl.rows[0].style.display = 'block';
					}
				}
				else
					tbl.rows[0].style.display = 'none';
			}
		}
		if(!this.bExpandTabs)
		{
			this.ShowTab(this.aTabs[0]["DIV"], true);
			var div = document.getElementById(this.aTabs[0]["DIV"]);
			div.style.display = 'block';
		}
		jsUserOptions.SaveOption('edit', this.unique_name, 'expand', (this.bExpandTabs? 'on': 'off'));

		jsUtils.onCustomEvent('OnToggleTabs');
	}

	this.ShowWarnings = function(form_name, warnings)
	{
		var form = document.forms[form_name];
		if(!form)
			return;
		for(var i in warnings)
		{
			var e = form.elements[warnings[i]['name']];
			if(!e)
				continue;

			var type = (e.type? e.type.toLowerCase():'');
			var bBefore = false;
			if(e.length > 1 && type != 'select-one' && type != 'select-multiple')
			{
				e = e[0];
				bBefore = true;
			}
			if(type == 'textarea' || type == 'select-multiple')
				bBefore = true;

			var td = e.parentNode;
			var img;
			if(bBefore)
			{
				img = td.insertBefore(new Image(), e);
				td.insertBefore(document.createElement("BR"), e);
			}
			else
			{
				img = td.insertBefore(new Image(), e.nextSibling);
				img.hspace = 2;
				img.vspace = 2;
				img.style.verticalAlign = 'bottom';
			}
			img.src = '/bitrix/themes/'+phpVars.ADMIN_THEME_ID+'/images/icon_warn.gif';
			img.title = warnings[i]['title'];
		}
	}

	this.ShowSettings = function(url)
	{
		if(document.getElementById("settings_float_div"))
			return;

		CHttpRequest.Action = function(result)
		{
			CloseWaitWindow();

			if(result == '')
				return;

			var div = document.body.appendChild(document.createElement("DIV"));
			div.id = "settings_float_div";
			div.className = "settings-float-form";
			div.style.position = 'absolute';
			div.style.zIndex = 1000;
			div.innerHTML = result;

			var left = parseInt(document.body.scrollLeft + document.body.clientWidth/2 - div.offsetWidth/2);
			var top = parseInt(document.body.scrollTop + document.body.clientHeight/2 - div.offsetHeight/2);
			jsFloatDiv.Show(div, left, top);

			jsUtils.addEvent(document, "keypress", _this.SettingsOnKeyPress);
		}
		ShowWaitWindow();
		CHttpRequest.Send(url);
	}

	this.CloseSettings =  function()
	{
		jsUtils.removeEvent(document, "keypress", _this.SettingsOnKeyPress);
		var div = document.getElementById("settings_float_div");
		jsFloatDiv.Close(div);
		div.parentNode.removeChild(div);
	}

	this.SettingsOnKeyPress = function(e)
	{
		if(!e) e = window.event
		if(!e) return;
		if(e.keyCode == 27)
			_this.CloseSettings();
	}

	this.SaveSettings =  function()
	{
		ShowWaitWindow();

		var sTabs='', s='';

		var oFieldsSelect;
		var oSelect = document.getElementById('selected_tabs');
		if(oSelect)
		{
			var k = oSelect.length;
			for(var i=0; i<k; i++)
			{
				s = oSelect[i].value + '--#--' + oSelect[i].text;
				oFieldsSelect = document.getElementById('selected_fields[' + oSelect[i].value + ']');
				if(oFieldsSelect)
				{
					var n = oFieldsSelect.length;
					for(var j=0; j<n; j++)
					{
						s += '--,--' + oFieldsSelect[j].value + '--#--' + jsUtils.trim(oFieldsSelect[j].text);
					}
				}
				sTabs += s + '--;--';
			}
		}

		var bCommon = (document.form_settings.set_default && document.form_settings.set_default.checked);

		var request = new JCHttpRequest;
		request.Action = function () {BX.reload()};

		var sParam = '';
		sParam += '&p[0][c]=form';
		sParam += '&p[0][n]='+encodeURIComponent(this.name);
		if(bCommon)
			sParam += '&p[0][d]=Y';
		sParam += '&p[0][v][tabs]=' + encodeURIComponent(sTabs);

		var options_url = '/bitrix/admin/user_options.php?lang='+phpVars.LANGUAGE_ID+'&sessid='+phpVars.bitrix_sessid;
		options_url += '&action=delete&c=form&n='+this.name+'_disabled';

		request.Post(options_url, sParam);
	}

	this.DeleteSettings = function(bCommon)
	{
		ShowWaitWindow();
		jsUserOptions.DeleteOption('form', this.name, bCommon, function () {BX.reload()});
	}

	this.DisableSettings = function()
	{
		var request = new JCHttpRequest;
		request.Action = function () {BX.reload()};
		var sParam = '';
		sParam += '&p[0][c]=form';
		sParam += '&p[0][n]='+encodeURIComponent(this.name+'_disabled');
		sParam += '&p[0][v][disabled]=Y';
		request.Send('/bitrix/admin/user_options.php?lang=' + phpVars.LANGUAGE_ID + sParam + '&sessid='+phpVars.bitrix_sessid);
	}

	this.EnableSettings = function()
	{
		var request = new JCHttpRequest;
		request.Action = function () {BX.reload()};
		var sParam = '';
		sParam += '&c=form';
		sParam += '&n='+encodeURIComponent(this.name)+'_disabled';
		sParam += '&action=delete';
		request.Send('/bitrix/admin/user_options.php?lang=' + phpVars.LANGUAGE_ID + sParam + '&sessid='+phpVars.bitrix_sessid);
	}
}

/************************************************/

function ViewTabControl(aTabs)
{
	var _this = this;
	this.aTabs = aTabs;

	this.SelectTab = function(tab_id)
	{
		var div = document.getElementById(tab_id);
		if(div.style.display != 'none')
			return;

		for(var i in this.aTabs)
		{
			var tab_div = document.getElementById(this.aTabs[i]["DIV"]);
			if(tab_div.style.display != 'none')
			{
				var tab = document.getElementById('view_tab_'+this.aTabs[i]["DIV"]);
				tab.innerHTML = this.aTabs[i]["HTML"];
				tab.className = 'view-tab';
				this.ToggleDelimiter(tab, true);
				tab_div.style.display = 'none';
				break;
			}
		}

		var active_tab = document.getElementById('view_tab_'+tab_id);
		active_tab.className = 'view-tab view-tab-active';
		this.ToggleDelimiter(active_tab, false);
		div.style.display = 'block';

		this.RebuildTabs();

		for(var i in this.aTabs)
		{
			if(this.aTabs[i]["DIV"] == tab_id)
			{
				this.ReplaceAnchor(this.aTabs[i]);
				if(this.aTabs[i]["ONSELECT"])
					eval(this.aTabs[i]["ONSELECT"]);
				break;
			}
		}
	}

	this.ToggleDelimiter = function(tab, on)
	{
		var d;
		if((d = jsUtils.FindNextSibling(tab, 'div')) && d.className.indexOf('view-tab-delimiter') != -1)
			d.className = 'view-tab-delimiter'+(on? '':' view-tab-hide-delimiter');
		if((d = jsUtils.FindPreviousSibling(tab, 'div')) && d.className.indexOf('view-tab-delimiter') != -1)
			d.className = 'view-tab-delimiter'+(on? '':' view-tab-hide-delimiter');
	}

	this.DisableTab = function(tab_id)
	{
	}

	this.EnableTab = function(tab_id)
	{
	}

	this.ReplaceAnchor = function(tab)
	{
		var tab_div = document.getElementById('view_tab_'+tab["DIV"]);
		tab["HTML"] = tab_div.innerHTML;
		var a = jsUtils.FindChildObject(tab_div, "a");
		tab_div.innerHTML = a.innerHTML;
	}

	this.RebuildTabs = function()
	{
		var container = jsUtils.FindParentObject(document.getElementById('view_tab_'+_this.aTabs[0]["DIV"]), "div");
		var aPos = [0];
		var selectedIndex = -1;
		var prevTop = -1;
		var last;
		var n = container.childNodes.length;
		for(var i=0; i<n; i++)
		{
			var div = container.childNodes[i];
			if(!div.id)
				continue;

			if(prevTop > -1 && div.offsetTop > prevTop)
				aPos[aPos.length] = i;
			prevTop = div.offsetTop;

			if(selectedIndex == -1 && div.className.indexOf('view-tab-active') != -1)
				selectedIndex = aPos.length-1;
			last = div;
		}

		if(selectedIndex < aPos.length && selectedIndex > -1)
		{
			var aDiv = new Array();
			var div = container.childNodes[aPos[selectedIndex]];
			for(var i = aPos[selectedIndex]; i<aPos[selectedIndex+1]; i++)
			{
				aDiv[aDiv.length] = div;
				div = div.nextSibling;
			}
			if(aDiv.length > 0)
			{
				for(var i in aDiv)
					container.removeChild(aDiv[i]);

				while(last.nextSibling)
				{
					last = last.nextSibling;
					if(last.tagName && last.tagName.toUpperCase() == 'BR' && last.className && last.className == 'tab-break')
						break;
				}

				var br = document.createElement("BR");
				br.style.clear='both';
				container.insertBefore(br, last);

				for(var i in aDiv)
				{
					if(aDiv[i].tagName && aDiv[i].tagName.toUpperCase() == 'BR')
						continue;
					container.insertBefore(aDiv[i], last);
				}
			}
		}
	}

	this.Init = function()
	{
		if(this.aTabs.length == 0)
			return;
		for(var i in this.aTabs)
		{
			var div = document.getElementById(this.aTabs[i]["DIV"]);
			if(div.style.display != 'none')
			{
				this.ReplaceAnchor(this.aTabs[i]);
				this.ToggleDelimiter(document.getElementById('view_tab_'+this.aTabs[i]["DIV"]), false);
				break;
			}
		}
		setTimeout(this.RebuildTabs, 10);
		window.onresize = this.RebuildTabs;
	}

	this.Init();
}

/************************************************/

var jsAdminChain =
{
	_chain: '',

	AddItems: function(divId)
	{
		var main_chain = document.getElementById("main_navchain");
		if(!main_chain)
			return;

		if(this._chain == '')
			this._chain = main_chain.innerHTML;
		else
			main_chain.innerHTML = this._chain;

		var div = document.getElementById(divId);
		if(!div)
			return;

		main_chain.innerHTML += '<span class="adm-navchain-delimiter"></span>';
		main_chain.innerHTML += div.innerHTML;
	}
}

/************************************************/

function JCHttpRequest()
{
	this.Action = null; //function(result){}

	this._OnDataReady = function(result)
	{
		if(this.Action)
			this.Action(result);
	}

	this._CreateHttpObject = function()
	{
		var obj = null;
		if(window.XMLHttpRequest)
		{
			try {obj = new XMLHttpRequest();} catch(e){}
		}
        else if(window.ActiveXObject)
        {
            try {obj = new ActiveXObject("Microsoft.XMLHTTP");} catch(e){}
            if(!obj)
            	try {obj = new ActiveXObject("Msxml2.XMLHTTP");} catch (e){}
        }
        return obj;
	}

	this._SetHandler = function(httpRequest)
	{
		var _this = this;
		httpRequest.onreadystatechange = function()
		{
			if(httpRequest.readyState == 4)
			{
//				try
				{
					var s = httpRequest.responseText;
					var code = [];
					var start, end;
					while((start = s.indexOf('<script>')) != -1)
					{
						var end = s.indexOf('</script>', start);
						if(end == -1)
							break;

						code[code.length] = s.substr(start+8, end-start-8);
						s = s.substr(0, start) + s.substr(end+9);
					}
					_this._OnDataReady(s);

					for(var i = 0, cnt = code.length; i < cnt; i++)
						if(code[i] != '')
							jsUtils.EvalGlobal(code[i]);
				}
/*
				catch (e)
				{
					var w = window.open("about:blank");
					w.document.write(httpRequest.responseText);
					w.document.close();
				}
*/
			}
		}
	}

	this.Send = function(url)
	{
		var httpRequest = this._CreateHttpObject();
		if(httpRequest)
		{
			httpRequest.open("GET", url, true);
			this._SetHandler(httpRequest);
			return httpRequest.send("");
  		}
	}

	this.Post = function(url, data)
	{
		var httpRequest = this._CreateHttpObject();
		if(httpRequest)
		{
			httpRequest.open("POST", url, true);
			this._SetHandler(httpRequest);
			httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			return httpRequest.send(data);
  		}
	}
}
var CHttpRequest = new JCHttpRequest();

/************************************************/

/***** DEPRECATED! Use BX.userOptions from core_ajax.js **********/
function JCUserOptions()
{
	var _this = this;
	this.options = null;
	this.bSend = false;
	this.request = new JCHttpRequest();

	this.GetParams = function()
	{
		if (BX && BX.userOptions)
		{
			_this.GetParams = BX.userOptions.__get;
			return _this.GetParams.apply(BX.userOptions, arguments);
		}

		var sParam = '';
		var n = -1;
		var prevParam = '';
		for(var i in _this.options)
		{
			var aOpt = _this.options[i];
			if(prevParam != aOpt[0]+'.'+aOpt[1])
			{
				n++;
				sParam += '&p['+n+'][c]='+encodeURIComponent(aOpt[0]);
				sParam += '&p['+n+'][n]='+encodeURIComponent(aOpt[1]);
				if(aOpt[4] == true)
					sParam += '&p['+n+'][d]=Y';
				prevParam = aOpt[0]+'.'+aOpt[1];
			}
			sParam += '&p['+n+'][v]['+encodeURIComponent(aOpt[2])+']='+encodeURIComponent(aOpt[3]);
		}

		return sParam.substr(1);
	}

	this.SaveOption = function(sCategory, sName, sValName, sVal, bCommon)
	{
		if (BX && BX.userOptions)
		{
			_this.SaveOption = BX.userOptions.save;
			return _this.SaveOption.apply(BX.userOptions, arguments);
		}

		if(!this.options)
			this.options = new Object();

		if(bCommon != true)
			bCommon = false;
		this.options[sCategory+'.'+sName+'.'+sValName] = [sCategory, sName, sValName, sVal, bCommon];

		var sParam = this.GetParams();
		if(sParam != '')
			document.cookie = phpVars.cookiePrefix+"_LAST_SETTINGS=" + sParam + "&sessid="+phpVars.bitrix_sessid+"; expires=Thu, 31 Dec 2020 23:59:59 GMT; path=/;";

		if(!this.bSend)
		{
			this.bSend = true;
			setTimeout(function(){_this.SendData(null)}, 5000);
		}
	}

	this.SendData = function(callback)
	{
		if (BX && BX.userOptions)
		{
			_this.SendData = BX.userOptions.send;
			return _this.SendData.apply(BX.userOptions, arguments);
		}

		var sParam = _this.GetParams();
		_this.options = null;
		_this.bSend = false;
		if(sParam != '')
		{
			document.cookie = phpVars.cookiePrefix+"_LAST_SETTINGS=; path=/;";
			_this.request.Action = callback;
			_this.request.Send('/bitrix/admin/user_options.php?'+sParam+'&sessid='+phpVars.bitrix_sessid);
		}
	}

	this.DeleteOption = function(sCategory, sName, bCommon, callback)
	{
		if (BX && BX.userOptions)
		{
			_this.DeleteOption = BX.userOptions.del;
			return _this.DeleteOption.apply(BX.userOptions, arguments);
		}

		_this.request.Action = callback;
		_this.request.Send('/bitrix/admin/user_options.php?action=delete&c='+sCategory+'&n='+sName+(bCommon == true? '&common=Y':'')+'&sessid='+phpVars.bitrix_sessid);
	}
}
var jsUserOptions = new JCUserOptions();

/************************************************/

function JCPanel()
{
	var _this = this;

	this.FixPanel = function()
	{
		var a = document.getElementById('admin_panel_fix_link');
		var panel = document.getElementById('bx_top_panel_container');
		var backDiv = document.getElementById('bx_top_panel_back');
		var bFixed = (panel.style.position == 'fixed' || panel.style.position == 'absolute');
		var bIE = jsUtils.IsIE();
		if(bIE)
		{
			try{panel.style.removeExpression("top");} catch(e) {bIE = false;}
		}
		if(bFixed)
		{
			a.title = phpVars.messPanelFixOn;
			a.className = 'fix-link fix-on';
			panel.style.position = '';
			backDiv.style.display = 'none';
			if(bIE)
			{
				panel.style.removeExpression("top");
				panel.style.removeExpression("left");
				panel.style.removeExpression("width");
				panel.style.width = '100%';

				var frame = document.getElementById("admin_panel_frame");
				if(frame)
					frame.style.visibility = 'hidden';
			}
		}
		else
		{
			this.ShowOn();
			if(bIE)
			{
				var frame = document.getElementById("admin_panel_frame");
				if(frame)
					frame.style.visibility = 'visible';
				else
					this.CreateFrame(panel);
			}
		}
		jsUserOptions.SaveOption('admin_panel', 'settings', 'fix', (bFixed? 'off':'on'));
	}

	this.ShowOn = function()
	{
		var a = document.getElementById('admin_panel_fix_link');
		var panel = document.getElementById('bx_top_panel_container');
		var backDiv = document.getElementById('bx_top_panel_back');
		var bIE = jsUtils.IsIE();
		if(bIE)
		{
			try{panel.style.setExpression("top", "0");} catch(e) {bIE = false;}
		}

		a.title = phpVars.messPanelFixOff;
		a.className = 'fix-link fix-off';
		panel.style.position = (bIE? 'absolute':'fixed');
		panel.style.left = '0px';
		panel.style.top = '0px';
		panel.style.zIndex = '1000';
		if(bIE)
		{
			if(document.body.currentStyle.backgroundImage == 'none')
			{
				document.body.style.backgroundImage = "url(/bitrix/images/1.gif)";
				document.body.style.backgroundAttachment = "fixed";
				document.body.style.backgroundRepeat = "no-repeat";
			}
			panel.style.setExpression("top", "eval((document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop)");
			panel.style.setExpression("left", "eval((document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft)");
			panel.style.setExpression("width", "eval((document.documentElement && document.documentElement.clientWidth) ? document.documentElement.clientWidth : document.body.clientWidth)");
		}
		backDiv.style.height = panel.offsetHeight+'px';
		backDiv.style.display = 'block';
	}

	this.FixOn = function()
	{
		this.ShowOn();
		jsUtils.addEvent(window, "load", this.AdjustBackDiv);
	}

	this.AdjustBackDiv = function()
	{
		var panel = document.getElementById('bx_top_panel_container');
		var backDiv = document.getElementById('bx_top_panel_back');

		var bIE = jsUtils.IsIE();
		if(bIE)
		{
			try{backDiv.style.setExpression("height", "0");} catch(e) {bIE = false;}
		}

		backDiv.style.height = panel.offsetHeight+'px';

		if(bIE)
			_this.CreateFrame(panel);
	}

	this.CreateFrame = function(panel)
	{
		var frame = document.createElement("IFRAME");
		frame.src = "javascript:void(0)";
		frame.id = "admin_panel_frame";
		frame.style.position = 'absolute';
		frame.style.overflow = 'hidden';
		frame.style.zIndex = parseInt(panel.currentStyle.zIndex)-1;
		frame.style.height = panel.offsetHeight + "px";
		document.body.appendChild(frame);
		frame.style.setExpression("top", "eval(document.body.scrollTop)");
		frame.style.setExpression("left", "eval(document.body.scrollLeft)");
		frame.style.setExpression("width", "eval(document.body.clientWidth)");
		return frame;
	}

	this.IsFixed = function()
	{
		var panel = document.getElementById('bx_top_panel_container');
		return (panel && (panel.style.position == 'fixed' || panel.style.position == 'absolute'));
	}

	this.DisplayPanel = function(el)
	{
		var div = document.getElementById('bx_top_panel_splitter');
		if(div.style.display == 'none')
		{
			div.style.display = 'block';
			el.className = 'splitterknob';
			el.title = phpVars.messPanelCollapse;
			jsUserOptions.SaveOption('admin_panel', 'settings', 'collapsed', 'off');
		}
		else
		{
			div.style.display = 'none';
			el.className = 'splitterknob splitterknobdown';
			el.title = phpVars.messPanelExpand;
			jsUserOptions.SaveOption('admin_panel', 'settings', 'collapsed', 'on');
		}
		var panel = document.getElementById('bx_top_panel_container');
		var backDiv = document.getElementById('bx_top_panel_back');
		backDiv.style.height = panel.offsetHeight+'px';
		var frame = document.getElementById("admin_panel_frame");
		if(frame)
			frame.style.height = panel.offsetHeight + "px";
	}
}
var jsPanel = new JCPanel();

//***************************************************

function JCDebugWindow()
{
	var _this = this;
	this.div_id = 'BX_DEBUG_WINDOW';
	this.div_current = null;
	this.div_detail_current = null;

	this.Show = function(info_id)
	{
		var div = document.getElementById(this.div_id);
		if(div)
		{
			div.style.display = 'block';
			var info_div = document.getElementById(info_id);
			if(info_div)
			{
				if(this.div_current)
					this.div_current.style.display = 'none';

				info_div.style.display = 'block';
				this.div_current = info_div;

				this.ShowDetails(info_id+'_1');
			}

			//var left = parseInt(document.body.scrollLeft + document.body.clientWidth/2 - div.offsetWidth/2);
			//var top = parseInt(document.body.scrollTop + document.body.clientHeight/2 - div.offsetHeight/2);

			var windowSize = jsUtils.GetWindowSize();

			var left = parseInt(windowSize["scrollLeft"] + windowSize["innerWidth"]/2 - div.offsetWidth/2);
			var top = parseInt(windowSize["scrollTop"] + windowSize["innerHeight"]/2 - div.offsetHeight/2);

			jsFloatDiv.Show(div, left, top);
			jsUtils.addEvent(document, "keypress", this.OnKeyPress);
		}
	}

	this.Close = function()
	{
		jsUtils.removeEvent(document, "keypress", this.OnKeyPress);
		var div = document.getElementById(this.div_id);
		jsFloatDiv.Close(div);
		div.style.display = 'none';
	}

	this.OnKeyPress = function(e)
	{
		if(!e) e = window.event
		if(!e) return;
		if(e.keyCode == 27)
			_this.Close();
	}

	this.ShowDetails = function(div_id)
	{
		var div = document.getElementById(div_id);
		if(div)
		{
			if(this.div_detail_current)
				this.div_detail_current.style.display = 'none';

			div.style.display = 'block';
			this.div_detail_current = div;
		}
	}
}
var jsDebugWindow = new JCDebugWindow();

//***************************************************

function ImgShw(ID, width, height, alt)
{
	var scroll = "no";
	var top=0, left=0;
	if(width > screen.width-10 || height > screen.height-28) scroll = "yes";
	if(height < screen.height-28) top = Math.floor((screen.height - height)/2-14);
	if(width < screen.width-10) left = Math.floor((screen.width - width)/2-5);
	width = Math.min(width, screen.width-10);
	height = Math.min(height, screen.height-28);
	var wnd = window.open("","","scrollbars="+scroll+",resizable=yes,width="+width+",height="+height+",left="+left+",top="+top);
	wnd.document.write(
		"<html><head>"+
		"<"+"script type=\"text/javascript\">"+
		"function KeyPress()"+
		"{"+
		"	if(window.event.keyCode == 27) "+
		"		window.close();"+
		"}"+
		"</"+"script>"+
		"<title></title></head>"+
		"<body topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" onKeyPress=\"KeyPress()\">"+
		"<img src=\""+ID+"\" border=\"0\" alt=\""+alt+"\" />"+
		"</body></html>"
	);
	wnd.document.close();
}


var WizardWindow = {

	iframe : null,
	messLoading : phpVars.messLoading,
	currentDialog : null,
	currentFrame : null,
	isClosed : false,
	frameLoaded : false,
	//dialogs : {},

	Open : function(wizardName, sessid)
	{
		/*if (this.dialogs[wizardName])
		{
			this.currentDialog = this.dialogs[wizardName].dialog;
			this.currentFrame = this.dialogs[wizardName].frame;
			this.currentDialog.Show();
			return;
		}*/

		this.currentDialog = new BX.CWizardDialog({
			'width':'700',
			'height':'400',
			resizable: false
		});
		this.isClosed = false;
		this.frameLoaded = false;

		BX.addCustomEvent(this.currentDialog, "onBeforeWindowClose", BX.proxy(this.onBeforeWindowClose, this));

		var iframeID = Math.random();
		this.currentDialog.SetContent('<iframe class="content" style="background-color: transparent; height:400px;" allowtransparency="true" scrolling="no" id="wizard_iframe_' + iframeID + '" width="100%" src="/bitrix/admin/wizard_install.php?lang='+phpVars.LANGUAGE_ID+'&wizardName='+wizardName+'&bxsender=admin_wizard_dialog&sessid='+sessid+'" frameborder="0"></iframe>');
		this.currentDialog.Show();

		setTimeout(BX.proxy(function() { if (!this.frameLoaded) {this.ShowWaitWindow();} }, this), 400);
		this.currentFrame = BX("wizard_iframe_" + iframeID);
		BX.bind(this.currentFrame, "load", BX.proxy(this.OnFrameLoad, this));

		//this.dialogs[wizardName] = { dialog : this.currentDialog, frame : this.currentFrame };
	},

	OnFrameLoad : function()
	{
		this.frameLoaded = true;
		this.HideWaitWindow();

		var iframeWindow = this.currentFrame.contentWindow;

		var iframeDocument = null;
		if (this.currentFrame.contentDocument)
			iframeDocument = this.currentFrame.contentDocument;
		else
			iframeDocument = this.currentFrame.contentWindow.document;

		if(iframeWindow.focus)
			iframeWindow.focus();
		else
			iframeDocument.body.focus();
	},

	Close : function()
	{
		if (this.currentDialog)
		{
			this.isClosed = true;
			this.currentDialog.Close(true);
		}
	},

	ShowWaitWindow : function()
	{
		if (this.currentDialog && BX.type.isDomNode(this.currentDialog.PARTS.CONTENT))
		{
			var waiter = document.createElement("DIV");
			waiter.id = "__bx_wait_window";
			waiter.className = "";
			waiter.style.position = "absolute";
			waiter.style.left = "40%";
			waiter.style.top = "40%";
			waiter.style.zIndex = "3000";
			waiter.style.padding = "15px 10px 15px 35px";
			waiter.style.width = "auto";
			waiter.style.fontSize = "12px";
			waiter.style.borderRadius = "4px";
			waiter.style.boxShadow = "0 0 10px 1px #dfdfdf";
			waiter.style.border = "1px solid #DCE7ED";
			waiter.style.lineHeight = "9px";
			waiter.style.background = "#fff url(/bitrix/panel/main/images/waiter-white.gif) 3px center no-repeat";
			waiter.innerHTML = this.messLoading;

			this.currentDialog.PARTS.CONTENT.appendChild(waiter);
		}
	},

	HideWaitWindow : function()
	{
		var waiter = BX("__bx_wait_window");
		if (waiter && waiter.parentNode)
			waiter.parentNode.removeChild(waiter);
	},

	onBeforeWindowClose : function(dialog)
	{
		if (this.isClosed === false)
		{
			dialog.denyClose = !confirm(BX.message("ADMIN_WIZARD_EXIT_ALERT"));
		}
	}
};

//************************************************************

function JCStartMenu()
{
	var menuStart = null;
	var request = new JCHttpRequest();
	var _this = this;

	this.EvalMenu = function(result)
	{
		if(jsUtils.trim(result).length == 0)
			return;

		var menuItems;
        try
        {
		    eval(result); // menuItems={'styles':[], 'items':[]}
        }
        catch(e)
        {
        }

		if(!menuItems)
			return false;

		//Applying styles
		var head = document.getElementsByTagName("HEAD");
		if(head && head[0])
		{
			var style = document.createElement("STYLE");
			head[0].appendChild(style);
			if(jsUtils.IsIE())
				document.styleSheets[document.styleSheets.length-1].cssText = menuItems['styles'];
			else
				style.appendChild(document.createTextNode(menuItems['styles']));
		}
		return menuItems;
	}

	this.ShowStartMenu = function(button, back_url)
	{
		var dPos = {'left':0, 'top':0, 'right':0, 'bottom':0};
		if(!menuStart || !menuStart.menuItems)
		{
			request.Action = function(result)
			{
				var menuItems = _this.EvalMenu(result);
				if(menuItems)
				{
					//show menu
					menuStart.PopupHide();
					menuStart.ShowMenu(button, menuItems['items'], jsPanel.IsFixed(), dPos);
				}
			}
			//create menu
			menuStart = new PopupMenu('panel_start_menu');
			menuStart.Create(1100);
			menuStart.ShowMenu(button, [{
				'TEXT':phpVars.messMenuLoading,
				'TITLE':phpVars.messMenuLoadingTitle,
				'ICONCLASS':'loading',
				'AUTOHIDE':false}], jsPanel.IsFixed(), dPos);
			request.Send('/bitrix/admin/get_start_menu.php?lang='+phpVars.LANGUAGE_ID+(back_url? '&back_url_pub='+encodeURIComponent(back_url):'')+'&sessid='+phpVars.bitrix_sessid);
		}
		else
		{
			menuStart.ShowMenu(button, null, jsPanel.IsFixed(), dPos);
		}
	}

	this.PreloadMenu = function(back_url)
	{
		if(!menuStart)
		{
			request.Action = function(result)
			{
				var menuItems = _this.EvalMenu(result);
				if(menuItems)
				{
					//show menu
					menuStart.SetItems(menuItems['items']);
					menuStart.BuildItems();
				}
			}
			//create menu
			menuStart = new PopupMenu('panel_start_menu');
			menuStart.Create(1100);
			request.Send('/bitrix/admin/get_start_menu.php?lang='+phpVars.LANGUAGE_ID+(back_url? '&back_url_pub='+encodeURIComponent(back_url):'')+'&sessid='+phpVars.bitrix_sessid);
		}
	}

	this.OpenDynMenu = function(menu, module_id, items_id, back_url)
	{
		request.Action = function(result)
		{
			if(jsUtils.trim(result).length == 0)
				return;

			var menuItems;
			eval(result); // menuItems={'items':[]}

			if(menu && menuItems)
			{
				var bVisible = menu.IsVisible();
				menu.PopupHide();
				menu.SetItems(menuItems['items']);
				menu.BuildItems();
				menu.parentMenu.ShowSubmenu(menu.parentItem, false, !bVisible);
			}
		}
		request.Send('/bitrix/admin/get_start_menu.php?mode=dynamic&lang='+phpVars.LANGUAGE_ID+'&admin_mnu_module_id='+encodeURIComponent(module_id)+'&admin_mnu_menu_id='+encodeURIComponent(items_id)+(back_url? '&back_url_pub='+encodeURIComponent(back_url):'')+'&sessid='+phpVars.bitrix_sessid);
	}

	this.OpenURL = function(item, arguments, url, back_url)
	{
		var itemInfo = menuStart.GetItemInfo(item);
		if(itemInfo)
		{
			request.Action = function(result){}
			request.Send('/bitrix/admin/get_start_menu.php?mode=save_recent&url='+encodeURIComponent(url)+'&text='+encodeURIComponent(itemInfo['TEXT'])+'&title='+encodeURIComponent(itemInfo['TITLE'])+'&icon='+itemInfo['ICON']+'&sessid='+phpVars.bitrix_sessid);
		}
		if(back_url)
			url += (url.indexOf('?')>=0? '&':'?')+'back_url_pub='+encodeURIComponent(back_url);
		jsUtils.Redirect(arguments, url);
	}
}
var jsStartMenu = new JCStartMenu();

//************************************************************
//Admin edit form functions

function OnAdd(id)
{
	var frm=document.form_settings;
	if(id == 'tabs_add')
	{
		var oSelect = document.getElementById('selected_tabs');
		if(oSelect)
		{
			var name = prompt(arFormEditMess.admin_lib_sett_tab_prompt, arFormEditMess.admin_lib_sett_tab_default_name);
			if(name && name.length > 0)
			{
				var n = oSelect.length;
				var c = 0;
				var found = true;
				while(found)
				{
					c++;
					found = false;
					for(var i=0; i<n; i++)
						if(oSelect[i].value == 'cedit'+c)
							found = true;
				}
				jsSelectUtils.addNewOption('selected_tabs', 'cedit'+c, name, false);
				var td = document.getElementById('selected_fields');
				var newSelect = document.createElement('SPAN');
				td.appendChild(newSelect);
				newSelect.innerHTML = '<select style="display:none" class="select" name="selected_fields[cedit' + c + ']" id="selected_fields[cedit' + c + ']" size="12" multiple onchange="Sync();"></select>';
				jsSelectUtils.selectOption('selected_tabs', 'cedit'+c);
			}
		}
	}
	if(id == 'tabs_copy')
	{
		var oSelectFrom = document.getElementById('available_tabs');
		var oSelectTo = document.getElementById('selected_tabs');
		if(oSelectFrom && oSelectTo)
		{
			var n = oSelectFrom.length;
			var k = oSelectTo.length;
			var c = 0;
			for(var i=0; i<n; i++)
				if(oSelectFrom[i].selected)
				{
					var found = false;
					for(var j=0; j<k; j++)
						if(oSelectTo[j].value == oSelectFrom[i].value)
							found = true;
					if(!found)
					{
						var td = document.getElementById('selected_fields');
						var newSelect = document.createElement('SPAN');
						var newID = 'selected_fields[' + oSelectFrom[i].value + ']';
						td.appendChild(newSelect);
						newSelect.innerHTML = '<select style="display:none" class="select" name="' + newID + '" id="' + newID + '" size="12" multiple onchange="Sync();"></select>';

						jsSelectUtils.addNewOption('selected_tabs', oSelectFrom[i].value, oSelectFrom[i].text, false);
						jsSelectUtils.selectAllOptions('available_fields');
						jsSelectUtils.addSelectedOptions(document.getElementById('available_fields'), newID);

						jsSelectUtils.selectOption('selected_tabs', oSelectFrom[i].value);

					}
				}
		}
	}
	if(id == 'fields_add')
	{
		var oSelect = document.getElementById('selected_tabs');
		var prefix = '';
		if(oSelect)
		{
			for(var i = 0; i < oSelect.length; i++)
				if(oSelect[i].selected)
					prefix = oSelect[i].value;
		}

		oSelect = GetFieldsActiveSelect();
		if(oSelect)
		{
			var name = prompt(arFormEditMess.admin_lib_sett_sec_prompt, arFormEditMess.admin_lib_sett_sec_default_name);
			if(name && name.length > 0)
			{
				var n = oSelect.length;
				var c = 0;
				var found = true;
				while(found)
				{
					c++;
					found = false;
					for(var i=0; i<n; i++)
						if(oSelect[i].value == prefix+'_csection'+c)
							found = true;
				}
				jsSelectUtils.addNewOption(oSelect.id, prefix+'_csection'+c, '--'+name, false);
				jsSelectUtils.selectOption(oSelect.id, prefix+'_csection'+c);
			}
		}
	}
	if(id == 'fields_copy')
	{
		var oSelectFrom = document.getElementById('available_fields');
		var oSelectTo = GetFieldsActiveSelect();
		if(oSelectFrom && oSelectTo && !oSelectTo.disabled)
		{
			//find last selected item in selected_fields
			var i, last = oSelectTo.length - 1;
			for(i = 0; i < oSelectTo.length; i++)
			{
				if(oSelectTo[i].selected)
					last = i;
			}
			//Delete all after last selected
			var tail = new Array;
			for(i = oSelectTo.length - 1; i > last; i--)
			{
				var newoption = new Option(oSelectTo[i].text, oSelectTo[i].value, false, false);
				newoption.innerHTML = oSelectTo[i].innerHTML;
				tail[tail.length] = newoption;
				oSelectTo.remove(i);
			}
			//Deselect all selected_fields
			for(i = 0; i < oSelectTo.length; i++)
				if(oSelectTo[i].selected)
					oSelectTo[i].selected = false;
			//Add new options
			var sel_count = 0, sel_value = '';
			for(i = 0; i < oSelectFrom.length; i++)
			{
				if(oSelectFrom[i].selected)
				{
					jsSelectUtils.addNewOption(oSelectTo.id, oSelectFrom[i].value, oSelectFrom[i].text, false);
					oSelectTo[oSelectTo.length - 1].selected = true;
					sel_count++;
					if(i < (oSelectFrom.length - 1))
						sel_value = oSelectFrom[i+1].value;
					else
						sel_value = '';
//					else if(i > 0)
//							sel_value = oSelectFrom[i-1].value;
				}
			}
			//Append selected_fields tail
			var n = oSelectTo.length;
			for(i = tail.length - 1; i >= 0; i--)
			{
				oSelectTo[n] = tail[i];
				n++;
			}
			if((sel_count == 1) && sel_value)
				jsSelectUtils.selectOption(oSelectFrom.id, sel_value);
		}
	}
	Sync();
}
function OnDelete(id)
{
	if(id == 'tabs_delete')
	{
		var selected_tabs = document.getElementById('selected_tabs');
		for(var i = 0; i < selected_tabs.length; i++)
		{
			if(selected_tabs[i].selected)
			{
				var selected_fields = document.getElementById('selected_fields[' + selected_tabs[i].value + ']');
				var p = selected_fields.parentNode;
				p.removeChild(selected_fields);
			}
		}

		jsSelectUtils.deleteSelectedOptions(selected_tabs.id);
		//For Opera deselect options
		jsSelectUtils.selectOption(selected_tabs.id, '');
	}
	if(id == 'fields_delete')
	{
		var selected_fields = GetFieldsActiveSelect();
		if(selected_fields)
		{
			jsSelectUtils.deleteSelectedOptions(selected_fields.id);
			//For Opera deselect options
			jsSelectUtils.selectOption(selected_fields.id, '');
		}
	}
	Sync();
}


function Sync()
{
	var i,j,n,found;
	var available_tabs = document.getElementById('available_tabs');
	var available_fields = document.getElementById('available_fields');
	var selected_tabs = document.getElementById('selected_tabs');

	//1 available_tabs
	//1.1 Save selection
	var available_tabs_selection = '';
	for(i = 0; i < available_tabs.length; i++)
		if(available_tabs[i].selected)
			available_tabs_selection = available_tabs[i].value;
	//2 available_fields
	//2.1 Save selection
	var available_fields_selection = new Object;
	for(i = 0; i < available_fields.length; i++)
	{
		if(available_fields[i].selected)
			available_fields_selection[available_fields[i].value] = available_fields[i].value;
	}
	//2.2 Clear list
	jsSelectUtils.selectAllOptions(available_fields.id);
	jsSelectUtils.deleteSelectedOptions(available_fields.id);
	//2.3 Fill list with fields missed
	if(available_tabs_selection)
	{
		var all_selected_fields = new Object;
		for(i = 0; i < selected_tabs.length; i++)
		{
			var selected_fields = document.getElementById('selected_fields[' + selected_tabs[i].value + ']');
			for(j = 0; j < selected_fields.length; j++)
				all_selected_fields[selected_fields[j].value] = selected_fields[j].value;
		}
		n = 0;
		for(available_field in arSystemTabsFields[available_tabs_selection])
		{
			if(!all_selected_fields[available_field])
			{
				var newoption = new Option(arSystemFields[available_field], available_field, false, false);
				available_fields.options[n] = newoption;
				available_fields.options[n].innerHTML = arSystemFields[available_field];
				n++;
			}
		}
		//2.4 Set selection
		for(i = 0; i < available_fields.length; i++)
			if(available_fields_selection[available_fields[i].value])
				available_fields[i].selected = true;
	}

	//3 selected_tabs

	//4 selected_fields
	found = false;
	for(i = 0; i < selected_tabs.length; i++)
	{
		var selected_fields = document.getElementById('selected_fields[' + selected_tabs[i].value + ']');
		if(selected_tabs[i].selected)
		{
			selected_fields.style.display = 'block';
			found = true;
		}
		else
		{
			selected_fields.style.display = 'none';
		}
	}
	if(found)
		document.getElementById('selected_fields[undef]').style.display = 'none';
	else
		document.getElementById('selected_fields[undef]').style.display = 'block';

	//5 disable and enable buttons
	//5.0 calculate selections counters
	var selected_tabs_count = 0;
	for(i = 0; i < selected_tabs.length; i++)
		if(selected_tabs[i].selected)
			selected_tabs_count++;
	var available_tabs_count = 0;
	for(i = 0; i < available_tabs.length; i++)
		if(available_tabs[i].selected)
			available_tabs_count++;
	//tabs_delete enabled if selected_tabs have selection
	document.getElementById('tabs_delete').disabled = selected_tabs_count <= 0;
	//tabs_copy enabled if available_tabs have selection and this selection does not exists in
	//		selected fields
	if(available_tabs_count <= 0)
	{
		document.getElementById('tabs_copy').disabled = true;
	}
	else
	{
		found = false;
		for(i = 0; i < selected_tabs.length; i++)
			if(selected_tabs[i].value == available_tabs_selection)
				found = true;
		document.getElementById('tabs_copy').disabled = found;
	}
	//tabs_up enabled if selected_tabs have selection
	document.getElementById('tabs_up').disabled = selected_tabs_count <= 0;
	//tabs_down enabled if selected_tabs have selection
	document.getElementById('tabs_down').disabled = selected_tabs_count <= 0;
	//tabs_rename enabled if selected_tabs have one item selected
	document.getElementById('tabs_rename').disabled = selected_tabs_count != 1;
	//tabs_add always selected
	document.getElementById('tabs_add').disabled = false;

	var selected_fields_count = 0;
	for(i = 0; i < selected_tabs.length; i++)
	{
		if(selected_tabs[i].selected)
		{
			var selected_fields = document.getElementById('selected_fields[' + selected_tabs[i].value + ']');
			for(j = 0; j < selected_fields.length; j++)
				if(selected_fields[j].selected)
					selected_fields_count++;
		}
	}
	var available_fields_count = 0;
	for(i = 0; i < available_fields.length; i++)
		if(available_fields[i].selected)
			available_fields_count++;
	//fields_delete enabled if selected_fields have selection
	document.getElementById('fields_delete').disabled = selected_fields_count <= 0;
	//fields_copy enabled if available_fields have selection and at least one tab selected
	document.getElementById('fields_copy').disabled = available_fields_count <= 0 || selected_tabs_count <= 0;
	//fields_up enabled if selected_fields have selection
	document.getElementById('fields_up').disabled = selected_fields_count <= 0;
	//fields_down enabled if selected_fields have selection
	document.getElementById('fields_down').disabled = selected_fields_count <= 0;
	//fields_rename enabled if selected_fields have one item selected
	document.getElementById('fields_rename').disabled = selected_fields_count != 1;
	//fields_add enabled if selected_tabs have one item selected
	document.getElementById('fields_add').disabled = selected_tabs_count != 1;

	var arFields = new Object;
	for(var name in arSystemFields)
		arFields[name] = arSystemFields[name];
	for(i = 0; i < selected_tabs.length; i++)
	{
		selected_fields = document.getElementById('selected_fields[' + selected_tabs[i].value + ']');
		for(j = 0; j < selected_fields.length; j++)
			delete arFields[selected_fields[j].value];
	}
	var save_button = document.getElementById('save_settings');
	save_button.disabled = false;
	for(var name in arFields)
	{
		if(arFields[name].substring(0,1) == "*")
			save_button.disabled = true;
	}
}

function SyncAvailableFields()
{
	var oSelect = document.getElementById('available_tabs');
	if(oSelect)
	{
		var k = oSelect.length;
		for(var i=0; i<k; i++)
		{
			oFieldsSelect = document.getElementById('available_fields');
			if(oFieldsSelect)
			{
				jsSelectUtils.selectAllOptions(oFieldsSelect.id);
				jsSelectUtils.deleteSelectedOptions(oFieldsSelect.id);
				if(oSelect[i].selected)
				{
					var n = 0;
					for(var field_id in arSystemTabsFields[oSelect[i].value])
					{
						var newoption = new Option(arSystemFields[field_id], field_id, false, false);
						oFieldsSelect.options[n]=newoption;
						oFieldsSelect.options[n].innerHTML = arSystemFields[field_id];
						n++;
					}
				}
			}
		}
	}
}

function GetFieldsActiveSelect()
{
	var oFieldsSelect;
	var oSelect = document.getElementById('selected_tabs');
	if(oSelect)
	{
		var k = oSelect.length;
		for(var i=0; i<k; i++)
		{
			oFieldsSelect = document.getElementById('selected_fields[' + oSelect[i].value + ']');
			if(oFieldsSelect && oFieldsSelect.style.display == 'block')
				return oFieldsSelect;
		}
	}
	return false;
}

function OnRename(id)
{
	var frm=document.form_settings;
	if(id == 'tabs_rename')
	{
		var oSelect = document.getElementById('selected_tabs');
		if(oSelect)
		{
			var n = oSelect.length;
			var c = 0;
			var choice = '';
			for(var i=0; i<n; i++)
			{
				if(oSelect[i].selected)
				{
					c++;
					if(!choice)
						choice = oSelect[i].text;
				}
			}
			if(c == 1)
			{
				var name = prompt(arFormEditMess.admin_lib_sett_tab_rename, choice);
				if(name && name.length > 0)
				{
					for(var i=0; i<n; i++)
						if(oSelect[i].selected)
						{
							oSelect[i].text = name;
							break;
						}
				}
			}
		}
	}
	if(id == 'fields_rename')
	{
		var oSelect = GetFieldsActiveSelect();
		if(oSelect)
		{
			var n = oSelect.length;
			var c = 0;
			var choice = '';
			for(var i=0; i<n; i++)
			{
				if(oSelect[i].selected)
				{
					c++;
					if(!choice)
						choice = oSelect[i].innerHTML;
				}
			}
			if(c == 1)
			{
				var prefix = '';
				if(choice.substring(0, 2) == '--')
				{
					choice = choice.substring(2);
					prefix = '--';
				}
				else
				{
					if(choice.substring(0, 1) == '*')
					{
						choice = choice.substring(1);
						prefix = '*';
					}
					else
					{
						if(choice.substring(0, 12) == '&nbsp;&nbsp;')
						{
							choice = choice.substring(12);
							prefix = '&nbsp;&nbsp;';
						}
						else
						{
							while(choice.substring(0, 2) == '\xA0\xA0' || choice.substring(0, 2) == '\xC2\xA0')
							{
								choice = choice.substring(2);
								prefix = '&nbsp;&nbsp;';
							}
						}
					}
				}
				var name = prompt(arFormEditMess.admin_lib_sett_sec_rename, choice);
				if(name && name.length > 0)
				{
					for(var i=0; i<n; i++)
						if(oSelect[i].selected)
						{
							if(prefix == '&nbsp;&nbsp;')
							{
								oSelect[i].text = name;
								oSelect[i].innerHTML = '&nbsp;&nbsp;' + oSelect[i].innerHTML;
							}
							else
							{
								oSelect[i].text = prefix + name;
							}
							break;
						}
				}
			}
		}
	}
}
function FieldsUpAndDown(direction)
{
	var oSelect = GetFieldsActiveSelect();
	if(oSelect)
	{
		if(direction == 'up')
			jsSelectUtils.moveOptionsUp(oSelect);
		else
			jsSelectUtils.moveOptionsDown(oSelect);
	}
}

/* End */
;
; /* Start:/bitrix/js/main/popup_menu.js*/
function PopupMenu(id, zIndex, dxShadow)
{
	var _this = this;
	this.menu_id = id;
	this.controlDiv = null;
	this.zIndex = 100;
	this.dxShadow = 3;
	this.menuItems = null;
	this.submenus = [];
	this.bDoHide = false;
	this.parentItem = null;
	this.parentMenu = null;
	this.submenuIndex = null;
	this.bHasSubmenus = false;

	this.OnClose = null;

	if(!isNaN(zIndex))
		this.zIndex = zIndex;
	if(!isNaN(dxShadow))
		this.dxShadow = dxShadow;

	this.Create = function(zIndex, dxShadow)
	{
		if(!isNaN(zIndex))
			this.zIndex = zIndex;
		if(!isNaN(dxShadow))
			this.dxShadow = dxShadow;

		var div = document.createElement("DIV");
		div.id = this.menu_id;
		div.className = "bx-popup-menu";
		div.style.position = 'absolute';
		div.style.zIndex = this.zIndex;
		div.style.left = '-1000px';
		div.style.top = '-1000px';
		div.style.visibility = 'hidden';
		div.onclick = _this.PreventDefault;
		document.body.appendChild(div);

		div.innerHTML =
			'<table cellpadding="0" cellspacing="0" border="0">'+
			'<tr><td class="popupmenu">'+
			'<table cellpadding="0" cellspacing="0" border="0" id="'+this.menu_id+'_items">'+
			'<tr><td></td></tr>'+
			'</table>'+
			'</td></tr>'+
			'</table>';
	}

	this.ClearItemsStyle = function()
	{
		var tbl = document.getElementById(this.menu_id+'_items');
		for(var i=0; i<tbl.rows.length; i++)
		{
			var div = jsUtils.FindChildObject(tbl.rows[i].cells[0], "div");
			if(div && div.className.indexOf('popupitemover') != -1)
			{
				div.className = div.className.replace(/\s*popupitemover/i, '');
				break;
			}
		}
	}

	this.PopupShow = function(pos)
	{
		var div = document.getElementById(this.menu_id);
		if(!div)
		{
			this.BuildItems();
			div = document.getElementById(this.menu_id);
		}

		this.ClearItemsStyle();

		setTimeout(function(){jsUtils.addEvent(document, "click", _this.CheckClick)}, 10);
		jsUtils.addEvent(document, "keypress", _this.OnKeyPress);

		var w = div.offsetWidth;
		var h = div.offsetHeight;
		pos = jsUtils.AlignToPos(pos, w, h);

		div.style.width = w + 'px';
		div.style.visibility = 'visible';

		jsFloatDiv.Show(div, pos["left"], pos["top"], this.dxShadow, false);

		div.ondrag = jsUtils.False;
		div.onselectstart = jsUtils.False;
		div.style.MozUserSelect = 'none';
	}

	this.PopupHide = function()
	{
		for(var i = 0, length = this.submenus.length; i < length; i++)
			if(this.submenus[i] && this.submenus[i].IsVisible())
				this.submenus[i].PopupHide();

		if(this.parentMenu)
			this.parentMenu.submenuIndex = null;

		var div = document.getElementById(this.menu_id);
		if(div)
		{
			jsFloatDiv.Close(div);
			div.style.visibility = 'hidden';
		}

		if(this.OnClose)
			this.OnClose();

		this.controlDiv = null;
		jsUtils.removeEvent(document, "click", _this.CheckClick);
		jsUtils.removeEvent(document, "keypress", _this.OnKeyPress);
	}

	this.CheckClick = function(e)
	{
		for(var i = 0, length = _this.submenus.length; i < length; i++)
			if(_this.submenus[i] && !_this.submenus[i].CheckClick(e))
				return false;

		var div = document.getElementById(_this.menu_id);
		if(!div)
			return true;

		if (div.style.visibility != 'visible')
			return true;

		var arScroll = jsUtils.GetWindowScrollPos();
		var x = e.clientX + arScroll.scrollLeft;
		var y = e.clientY + arScroll.scrollTop;

		/*menu region*/
		var posLeft = parseInt(div.style.left);
		var posTop = parseInt(div.style.top);
		var posRight = posLeft + parseInt(div.offsetWidth);
		var posBottom = posTop + parseInt(div.offsetHeight);
		if(x >= posLeft && x <= posRight && y >= posTop && y <= posBottom)
			return false;

		if(_this.controlDiv)
		{
			var pos = jsUtils.GetRealPos(_this.controlDiv);
			if(x >= pos['left'] && x <= pos['right'] && y >= pos['top'] && y <= pos['bottom'])
				return false;
		}
		_this.PopupHide();
		return true;
	}

	this.OnKeyPress = function(e)
	{
		if(!e) e = window.event
		if(!e) return;
		if(e.keyCode == 27)
			_this.PopupHide();
	}

	this.PreventDefault = function(e)
	{
		if(!e) e = window.event;
		if(e.stopPropagation)
		{
			e.preventDefault();
			e.stopPropagation();
		}
		else
		{
			e.cancelBubble = true;
			e.returnValue = false;
		}
		return false;
	}

	this.GetItemIndex = function(item)
	{
		var item_id = _this.menu_id+'_item_';
		var item_index = parseInt(item.id.substr(item_id.length));
		return item_index;
	}

	this.ShowSubmenu = function(item, bMouseOver, bDontShow)
	{
		if(!item)
			item = this;
		var item_index = _this.GetItemIndex(item);

		if(bMouseOver == true)
		{
			if(!_this.menuItems[item_index]["__time"])
				return;
			var dxTime = (new Date()).valueOf() - _this.menuItems[item_index]["__time"];
			if(dxTime < 500)
				return;
		}

		var menu;
		if(!_this.submenus[item_index])
		{
			menu = new PopupMenu(_this.menu_id+'_sub_'+item_index);
			menu.Create(_this.zIndex+10, _this.dxShadow);
			menu.SetItems(_this.menuItems[item_index].MENU);
			menu.BuildItems();
			menu.parentItem = document.getElementById(_this.menu_id+'_item_'+item_index);
			menu.parentMenu = _this;
			menu.OnClose = function()
			{
				jsUtils.addEvent(document, "keypress", _this.OnKeyPress);
			}
			_this.submenus[item_index] = menu;

			if(_this.menuItems[item_index].ONMENUPOPUP)
				eval(_this.menuItems[item_index].ONMENUPOPUP);
		}
		else
			menu = _this.submenus[item_index];

		_this.submenuIndex = item_index;

		if(menu.IsVisible() || bDontShow == true)
			return;

		var item_pos = jsUtils.GetRealPos(item);
		var menu_pos = jsUtils.GetRealPos(document.getElementById(_this.menu_id));
		var pos = {'left': menu_pos["right"]-1, 'right': menu_pos["left"]+1, 'top': item_pos["bottom"]+1, 'bottom': item_pos["top"]};

		jsUtils.removeEvent(document, "keypress", _this.OnKeyPress);
		menu.controlDiv = item;
		menu.PopupShow(pos);
	}

	this.OnSubmenuMouseOver = function()
	{
		_this.OnItemMouseOver(this);

		var item_index = _this.GetItemIndex(this);
		if(!_this.menuItems[item_index]["__time"])
			_this.menuItems[item_index]["__time"] = (new Date()).valueOf();

		var div = this;
		setTimeout(function(){_this.ShowSubmenu(div, true)}, 550);
	}

	this.OnItemMouseOver = function(item)
	{
		if(_this.bHasSubmenus)
			_this.ClearItemsStyle();

		var div = (item? item:this);
		div.className="popupitem popupitemover";

		if(_this.parentItem)
		{
			_this.bDoHide = false;
			if(_this.parentItem.className != "popupitem popupitemover")
			{
				_this.parentMenu.ClearItemsStyle();
				_this.parentItem.className = "popupitem popupitemover";
			}
		}

		if(_this.submenuIndex != null)
		{
			var item_index = _this.GetItemIndex(div);
			if(_this.submenuIndex != item_index && _this.submenus[_this.submenuIndex])
			{
				_this.submenus[_this.submenuIndex].bDoHide = true;
				setTimeout(function(){_this.HideSubmenu()}, 500);
			}
		}
	}

	this.OnSubmenuMouseOut = function()
	{
		var item_index = _this.GetItemIndex(this);
		_this.menuItems[item_index]["__time"] = null;
	}

	this.OnItemMouseOut = function()
	{
		this.className="popupitem";
	}

	this.HideSubmenu = function()
	{
		if(_this.submenuIndex == null)
			return;
		if(_this.submenus[_this.submenuIndex].bDoHide != true)
			return;
		_this.submenus[_this.submenuIndex].PopupHide();
	}

	this.SetItems = function(items)
	{
		this.menuItems = items;
		this.submenus = [];
	}

	this.SetItemIcon = function(item_id, icon)
	{
		if(typeof(item_id) == 'string' || item_id instanceof String)
		{
			for(var i in this.menuItems)
			{
				if(this.menuItems[i].ID && this.menuItems[i].ID == item_id)
				{
					this.menuItems[i].ICONCLASS = icon;
					var item_td = document.getElementById(item_id);
					if(item_td)
					{
						var div = jsUtils.FindChildObject(item_td, "div");
						if(div)
							div.className = "icon "+icon;
					}
					break;
				}
			}
		}
		else
		{
			var div = jsUtils.FindChildObject(jsUtils.FindChildObject(item_id, "td", "gutter", true), "div");
			if(div)
			{
				this.menuItems[this.GetItemIndex(item_id)].ICONCLASS = icon;
				div.className = "icon "+icon;
			}
		}
	}

	this.SetAllItemsIcon = function(icon)
	{
		for(var i=0, n=this.menuItems.length; i < n; i++)
		{
			var item = document.getElementById(this.menu_id+'_item_'+i);
			var div = jsUtils.FindChildObject(jsUtils.FindChildObject(item, "td", "gutter", true), "div");
			if(div)
			{
				this.menuItems[i].ICONCLASS = icon;
				div.className = "icon "+icon;
			}
		}
	}

	this.BuildItems = function()
	{
		var items = this.menuItems;
		if(!items || items.length == 0)
			return;

		var div = document.getElementById(this.menu_id);
		if(!div)
		{
			this.Create();
			div = document.getElementById(this.menu_id);
		}
		div.style.left='-1000px';
		div.style.top='-1000px';
		div.style.width='auto';

		this.bHasSubmenus = false;
		var tbl = document.getElementById(this.menu_id+'_items');
		while(tbl.rows.length>0)
			tbl.deleteRow(0);

		var n = items.length;
		for(var i=0; i<n; i++)
		{
			var row = tbl.insertRow(-1);
			var cell = row.insertCell(-1);
			if(items[i]['CLASS'])
				row.className = items[i]['CLASS'];
			if(items[i]['SEPARATOR'])
			{
				cell.innerHTML = '<div class="popupseparator"><div class="empty"></div></div>';
			}
			else
			{
				var s =
					'<div id="'+this.menu_id+'_item_'+i+'" class="popupitem"'+(items[i]['DISABLED']!=true && items[i]['ONCLICK']? ' '+(items[i]['MENU']? 'ondblclick':'onclick')+'="'+jsUtils.htmlspecialchars(items[i]['ONCLICK'])+'"':'')+'>'+
					'	<div style="width:100%;"><table style="width:100% !important" cellpadding="0" cellspacing="0" border="0" dir="ltr">'+
					'		<tr>'+
					'			<td class="gutter"'+(items[i]['ID']? ' id="'+items[i]['ID']+'"' : '')+'><div class="icon'+(items[i]['ICONCLASS']? ' '+items[i]['ICONCLASS']:'')+'"'+(items[i]['IMAGE']? ' style="background-image:url('+items[i]['IMAGE']+');"':'')+'></div></td>'+
					'			<td class="item'+(items[i]['DISABLED'] == true? ' disabled' : '')+(items[i]['DEFAULT'] == true? ' default' : '')+'"'+(items[i]["TITLE"]? ' title="'+items[i]["TITLE"]+'"' : '')+'>'+items[i]['TEXT']+'</td>';
				if(items[i]['MENU'])
					s += '<td class="arrow"></td>';

				s +=
					'		</tr>'+
					'	</table></div></div>';
				cell.innerHTML = s;
				if(items[i]['DISABLED']!=true)
				{
					var item_div = jsUtils.FindChildObject(cell, "div");
					if(items[i]['MENU'])
					{
						item_div.onclick = function(){_this.ShowSubmenu(this)};
						item_div.onmouseover = _this.OnSubmenuMouseOver;
						item_div.onmouseout = _this.OnSubmenuMouseOut;
						this.bHasSubmenus = true;
					}
					else
					{
						item_div.onmouseover = function(){_this.OnItemMouseOver(this)};
						item_div.onmouseout = _this.OnItemMouseOut;
						if(items[i]['ONCLICK'] && (items[i]['AUTOHIDE'] == null || items[i]['AUTOHIDE'] == true))
							jsUtils.addEvent(item_div, "click",	function(){_this.PopupHide();});
					}
				}
				items[i]['__id'] = this.menu_id+'_item_'+i;
			}
		}

		div.style.width = tbl.parentNode.offsetWidth;
	}


	this.GetItemInfo = function(item)
	{
		var td = jsUtils.FindChildObject(item, "td", "item", true);
		if(td)
		{
			var icon = '';
			var icon_div = jsUtils.FindChildObject(jsUtils.FindChildObject(item, "td", "gutter", true), "div");
			//<div class="icon class">
			if(icon_div.className.length > 5)
				icon = icon_div.className.substr(5);
			return {'TEXT': td.innerHTML, 'TITLE':td.title, 'ICON':icon};
		}
		return null;
	}

	this.GetMenuByItemId = function(item_id)
	{
		for(var i = 0, length = this.menuItems.length; i < length; i++)
			if(this.menuItems[i]['__id'] && this.menuItems[i]['__id'] == item_id)
				return this;

		var menu;

		for(var i = 0, length = this.submenus.length; i < length; i++)
			if(this.submenus[i] && (menu = this.submenus[i].GetMenuByItemId(item_id)) != false)
				return menu;

		return false;
	}

	this.IsVisible = function()
	{
		var div = document.getElementById(this.menu_id);
		if(div)
			return (div.style.visibility != 'hidden');
		return false;
	}

	this.ShowMenu = function(control, items, bFixed, dPos, userFunc)
	{
		if(this.controlDiv == control)
		{
			this.PopupHide();
		}
		else
		{
			if(this.IsVisible())
				this.PopupHide();

			if(items)
			{
				this.SetItems(items);
				this.BuildItems();
			}

			control.className += ' pressed bx-pressed';
			var pos = window.BX ? BX.pos(control) : jsUtils.GetRealPos(control);
			if(dPos)
			{
				pos["left"] += dPos["left"];
				pos["right"] += dPos["right"];
				pos["top"] += dPos["top"];
				pos["bottom"] += dPos["bottom"];
			}
			else
				pos["bottom"]+= 2;

			if(bFixed == true && !jsUtils.IsIE())
			{
				var arScroll = jsUtils.GetWindowScrollPos();
				pos["top"] += arScroll.scrollTop;
				pos["bottom"] += arScroll.scrollTop;
				pos["left"] += arScroll.scrollLeft;
				pos["right"] += arScroll.scrollLeft;
			}

			this.controlDiv = control;
			this.OnClose = function()
			{
				control.className = control.className.replace(/\s*pressed bx-pressed/ig, "");
				if(userFunc)
					userFunc();
			}
			this.PopupShow(pos);
		}
	}
}

/* End */
;
; /* Start:/bitrix/js/main/admin_search.js*/
function JCAdminTitleSearch(arParams)
{
	var _this = this;

	this.arParams = {
		'AJAX_PAGE': arParams.AJAX_PAGE,
		'CONTAINER_ID': arParams.CONTAINER_ID,
		'INPUT_ID': arParams.INPUT_ID,
		'MIN_QUERY_LEN': parseInt(arParams.MIN_QUERY_LEN)
	};
	if(arParams.WAIT_IMAGE)
		this.arParams.WAIT_IMAGE = arParams.WAIT_IMAGE;
	if(arParams.MIN_QUERY_LEN <= 0)
		arParams.MIN_QUERY_LEN = 1;

	this.cache = [];
	this.cache_key = null;

	this.startText = '';
	this.currentRow = -1;
	this.RESULT = null;
	this.CONTAINER = null;
	this.INPUT = null;
	this.WAIT = null;

	this.Hide = function()
	{
		_this.RESULT.style.display = 'none';
		_this.RESULT.innerHTML = '';
		_this.currentRow = -1;
		_this.UnSelectAll();
		BX.removeClass(_this.INPUT.parentNode,'adm-header-search-block-active-popup');
	};

	this.ShowResult = function(result)
	{
		var pos = BX.pos(_this.CONTAINER);
		pos.width = pos.right - pos.left;
		_this.RESULT.style.position = 'absolute';
		_this.RESULT.style.top = '4px';//(pos.bottom + 2) - 46  + 'px';
		_this.RESULT.style.left = (pos.left - 7) + 'px';
		_this.RESULT.style.width = (pos.width + 14)+ 'px';
		//_this.RESULT.style.zIndex = _this.CONTAINER.style.zIndex - 1;
		if(result != null)
			_this.RESULT.innerHTML = result;

		if(_this.RESULT.innerHTML.length > 0)
		{
			_this.RESULT.style.display = 'block';
			BX.addClass(_this.INPUT.parentNode,'adm-header-search-block-active-popup');
		}
		else
			this.Hide();

	};

	this.onKeyPress = function(keyCode)
	{
		var tbl = BX.findChild(_this.RESULT, {'tag':'table','class':'adm-search-result'}, true);
		if(!tbl)
			return false;

		var cnt = tbl.rows.length;

		switch (keyCode)
		{
		case 27: // escape key - close search div
			_this.Hide();
		return true;

		case 40: // down key - navigate down on search results
			if(_this.RESULT.style.display == 'none')
				_this.RESULT.style.display = 'block';

			var first = -1;
			for(var i = 0; i < cnt; i++)
			{
				if(first == -1)
					first = i;

				if(_this.currentRow < i)
				{
					_this.currentRow = i;
					break;
				}
				else if(tbl.rows[i].className == 'adm-search-selected')
				{
					tbl.rows[i].className = '';
				}
			}

			if(i == cnt && _this.currentRow != i)
				_this.currentRow = first;

			tbl.rows[_this.currentRow].className = 'adm-search-selected';
		return true;

		case 38: // up key - navigate up on search results
			if(_this.RESULT.style.display == 'none')
				_this.RESULT.style.display = 'block';

			var last = -1;
			for(var i = cnt-1; i >= 0; i--)
			{
				if(last == -1)
					last = i;

				if(_this.currentRow > i)
				{
					_this.currentRow = i;
					break;
				}
				else if(tbl.rows[i].className == 'adm-search-selected')
				{
					tbl.rows[i].className = '';
				}
			}

			if(i < 0)
				_this.currentRow = last;

			tbl.rows[_this.currentRow].className = 'adm-search-selected';
		return true;

		case 13: // enter key - choose current search result
			if(_this.RESULT.style.display == 'block')
			{
				for(var i = 0; i < cnt; i++)
				{
					if(_this.currentRow == i)
					{
						if(!BX.findChild(tbl.rows[i], {'class':'adm-search-separator'}, true))
						{
							var a = BX.findChild(tbl.rows[i], {'tag':'a'}, true);
							if(a)
							{
								window.location = a.href;
								return true;
							}
						}
					}
				}
			}
		return false;
		}

		return false;
	};

	this.onTimeout = function()
	{
		if(_this.INPUT.value != _this.oldValue && _this.INPUT.value != _this.startText)
		{
			if(_this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN)
			{
				_this.oldValue = _this.INPUT.value;
				_this.cache_key = _this.arParams.INPUT_ID + '|' + _this.INPUT.value;
				if(_this.cache[_this.cache_key] == null)
				{
					if(_this.WAIT)
					{
						var pos = BX.pos(_this.INPUT);
						var height = (pos.bottom - pos.top)-2;
						_this.WAIT.style.top = (pos.top+1) + 'px';
						_this.WAIT.style.height = height + 'px';
						_this.WAIT.style.width = height + 'px';
						_this.WAIT.style.left = (pos.right - height + 2) + 'px';
						_this.WAIT.style.display = 'block';
					}

					BX.ajax.post(
						_this.arParams.AJAX_PAGE,
						{
							'ajax_call':'y',
							'INPUT_ID':_this.arParams.INPUT_ID,
							'q':_this.INPUT.value
						},
						function(result)
						{
							_this.cache[_this.cache_key] = result;
							_this.ShowResult(result);
							_this.currentRow = -1;
							_this.EnableMouseEvents();
							if(_this.WAIT)
								_this.WAIT.style.display = 'none';
							setTimeout(_this.onTimeout, 500);
						}
					);
				}
				else
				{
					_this.ShowResult(_this.cache[_this.cache_key]);
					_this.currentRow = -1;
					_this.EnableMouseEvents();
					setTimeout(_this.onTimeout, 500);
				}
			}
			else
			{
				_this.Hide();
				setTimeout(_this.onTimeout, 500);
			}
		}
		else
		{
			setTimeout(_this.onTimeout, 500);
		}
	}

	this.UnSelectAll = function()
	{
		var tbl = BX.findChild(_this.RESULT, {'tag':'table','class':'adm-search-result'}, true);
		if(tbl)
		{
			var cnt = tbl.rows.length;
			for(var i = 0; i < cnt; i++)
				tbl.rows[i].className = '';
		}
	};

	this.EnableMouseEvents = function()
	{
		var tbl = BX.findChild(_this.RESULT, {'tag':'table','class':'adm-search-result'}, true);
		if(tbl)
		{
			var cnt = tbl.rows.length;
			for(var i = 0; i < cnt; i++)
			{
				tbl.rows[i].id = 'row_' + i;
				tbl.rows[i].onmouseover = function (e) {
					if(_this.currentRow != this.id.substr(4))
					{
						_this.UnSelectAll();
						this.className = 'adm-search-selected';
						_this.currentRow = this.id.substr(4);
					}
				};
				tbl.rows[i].onmouseout = function (e) {
					this.className = '';
					_this.currentRow = -1;
				};
			}
		}
	};

	this.onFocusLost = function(hide)
	{
		setTimeout(function(){_this.Hide();}, 250);
	};

	this.onFocusGain = function()
	{
		if(_this.RESULT.innerHTML.length)
			_this.ShowResult();
	};

	this.onKeyDown = function(e)
	{
		if(!e)
			e = window.event;

		if (_this.RESULT.style.display == 'block')
		{
			if(_this.onKeyPress(e.keyCode))
				return BX.PreventDefault(e);
		}
	};

	this.Init = function()
	{
		this.CONTAINER = document.getElementById(this.arParams.CONTAINER_ID);
		this.RESULT = document.getElementById("bx-panel").appendChild(document.createElement("DIV"));
		this.RESULT.className = 'adm-search-result-wrap';
		this.RESULT.style.display = 'none';

		this.INPUT = document.getElementById(this.arParams.INPUT_ID);
		this.startText = this.oldValue = this.INPUT.value;
		BX.bind(this.INPUT, 'focus', function() {_this.onFocusGain()});
		BX.bind(this.INPUT, 'blur', function() {_this.onFocusLost()});
		BX.bind(window, 'resize', function() {_this.onFocusGain()});

		if(BX.browser.IsSafari() || BX.browser.IsIE())
			this.INPUT.onkeydown = this.onKeyDown;
		else
			this.INPUT.onkeypress = this.onKeyDown;

		if(this.arParams.WAIT_IMAGE)
		{
			this.WAIT = document.body.appendChild(document.createElement("DIV"));
			this.WAIT.style.backgroundImage = "url('" + this.arParams.WAIT_IMAGE + "')";
			if(!BX.browser.IsIE())
				this.WAIT.style.backgroundRepeat = 'none';
			this.WAIT.style.display = 'none';
			this.WAIT.style.position = 'absolute';
			this.WAIT.style.zIndex = '1100';
		}

		setTimeout(this.onTimeout, 500);
	};

	BX.ready(function (){_this.Init(arParams)});
}

/* End */
;
; /* Start:/bitrix/js/main/hot_keys.js*/

if(!BXHotKeys)
{

	function CBXHotKeys()
	{
		var _this = this;
		var idxKS = 0;
		var idxCode = 1;
		var idxCodeId = 2;
		var idxName = 3;
		var idxHKId = 4;
		var arServSymb = { 8: 'Back Space',9: 'Tab',13: 'Enter',16: 'Shift',17: 'Ctrl',18: 'Alt',19: 'Pause',
						20: 'Caps Lock',27: 'ESC',32: 'Space bar',33: 'Page Up',34: 'Page Down',35: 'End',36: 'Home',
						37: 'Left',38: 'Up',39: 'Right',40: 'Down',45: 'Insert',46: 'Delete',96: '0 (ext)',97: '1 (ext)',
						98: '2 (ext)',99: '3 (ext)',100: '4 (ext)',101: '5 (ext)',102: '6 (ext)',105: '9 (ext)',106: '* (ext)',
						107: '+ (ext)',104: '8 (ext)',103: '7 (ext)',110: '. (ext)',111: '/ (ext)',112: 'F1',113: 'F2',114: 'F3',
						115: 'F4',116: 'F5',117: 'F6',118: 'F7',119: 'F8',120: 'F9',121: 'F10',122: 'F11',123: 'F12',144: 'Num Lock',
						186: ';',188: ',',190: '.',191: '/',192: '`',219: '[',220: '|',221: ']',222: "'",189: '-',187: '+',145: 'Scrol Lock' };
		var bxHotKeyCode=0;
		var inputKeyCode=0;
		var inputDopString="";

		this.ArrHKCode=[];
		this.MesNotAssign="";
		this.MesClToChange="";
		this.MesClean="";
		this.MesBusy="";
		this.MesClose="";
		this.MesSettings="";
		this.MesDefault="";
		this.MesDelAll="";
		this.MesDelete="";
		this.MesDelConfirm="";
		this.MesDefaultConfirm="";
		this.MesExport="";
		this.MesExpFalse="";
		this.MesImport="";
		this.MesImpFalse="";
		this.MesImpSuc="";
		this.MesImpHeader="";
		this.MesFileEmpty="";
		this.MesChooseFile="";
		this.uid="";
		this.deleting = false;



		this.Init = function()
		{
			this.Register();
		};

		// keysString: Ctrl+Alt+Shift+KeyCode
		this.UpdateKS = function(codeId, keysString)
		{
			for(var i=0; i<this.ArrHKCode.length; i++)
				if(this.ArrHKCode[i][idxCodeId]==codeId)
				{
					this.ArrHKCode[i][idxKS]=keysString;
					return true;
				}
		};

		this.UpdateHk = function(codeId, hkId)
		{
			for(var i=0; i<this.ArrHKCode.length; i++)
				if(this.ArrHKCode[i][idxCodeId]==codeId)
				{
					this.ArrHKCode[i][idxHKId]=hkId;
					return i;
				}

			return (-1);
		};

		this.Add = function(keysString, execCode, codeId, name, hkId)
		{
			for(var i=0; i<this.ArrHKCode.length; i++)
				if(this.ArrHKCode[i][idxCodeId]==codeId)
					return false;

			return this.ArrHKCode.push([String(keysString),String(execCode),codeId,String(name),hkId]);
		};

		// keysString: Ctrl+Alt+Shift+KeyCode
		this.GetExCode = function(keysString)
		{
			var ret="";
			if(keysString)
				for(var i=0; i<this.ArrHKCode.length; i++)
					if (this.ArrHKCode[i][idxKS]==keysString)
					{
						if(ret)
							ret+=" ";

						ret+=this.ArrHKCode[i][idxCode];
					}

			return ret;
		};

		this.MakeKeyString = function(Event)
		{
			this.inputDopString = (Event.ctrlKey ? 'Ctrl+':'') + (Event.altKey ? 'Alt+':'') + (Event.shiftKey ? 'Shift+':'');
			this.inputKeyCode = Event.keyCode;

			if(!this.inputKeyCode)
				this.inputKeyCode = Event.charCode;

			return this.inputDopString + this.inputKeyCode;
		};

		this.ShowMenu = function()
		{
			var menu = 	'<table class="bx-hk-settings-toolbar" cellspacing="0" cellpadding="0" border="0">'+
						'<tr><td class="bx-left"><div class="bx-hk-settings-empty"></div></td>'+
						'<td class="bx-content">'+
						'<a class="bx-context-button" hidefocus="true" href="javascript:void(0)" onclick="BXHotKeys.Import();">'+
						'<span class="bx-context-button-icon btn-import"></span>'+
						'<span class="bx-context-button-text">'+this.MesImport+'</span>'+
						'</a>'+
						'<a class="bx-context-button" hidefocus="true" href="javascript:void(0)" onclick="BXHotKeys.Export();">'+
						'<span class="bx-context-button-icon btn-export"></span>'+
						'<span class="bx-context-button-text">'+this.MesExport+'</span>'+
						'</a>'+
						'<a class="bx-context-button" hidefocus="true" href="javascript:void(0)" onclick="if(confirm(BXHotKeys.MesDelConfirm)) BXHotKeys.DelAll();">'+
						'<span class="bx-context-button-icon btn-delall"></span>'+
						'<span class="bx-context-button-text">'+this.MesDelAll+'</span>'+
						'</a>'+
						'<a class="bx-context-button" hidefocus="true" href="javascript:void(0)" onclick="if(confirm(BXHotKeys.MesDefaultConfirm)) { BXHotKeys.DelAll(); BXHotKeys.SetDefault(); }">'+
						'<span class="bx-context-button-icon btn-default"></span>'+
						'<span class="bx-context-button-text">'+this.MesDefault+'</span>'+
						'</a></td>'+
						'<td class="bx-right"><div class="bx-hk-settings-empty"></div></td></tr>'+
						'</table>';
			return menu;
		}

		this.ShowSettings = function()
		{
			var formText ='<table width="100%" id="tbl_hk_settings">';
			var keyStr="";
			var editStr="";

			for(var i=0; i<this.ArrHKCode.length; i++)
			{
				if(this.ArrHKCode[i][idxKS])
					keyStr=this.PrintKSAsChar(this.ArrHKCode[i][idxKS]);
				else
					keyStr=this.MesNotAssign;

				if(this.ArrHKCode[i][idxCode])
					editStr = "<td width='30%' id='hotkeys-float-form-"+this.ArrHKCode[i][idxCodeId]+"'><a href='javascript:void(0)' onclick='BXHotKeys.SubstInput("+this.ArrHKCode[i][idxCodeId]+", "+
							this.ArrHKCode[i][idxHKId]+", \""+this.ArrHKCode[i][idxKS]+"\");' title='"+this.MesClToChange+"' class='bx-hk-settings'>"+keyStr+"</a></td><td width='10%' align='right' id='hotkeys-float-form-del-"+this.ArrHKCode[i][idxCodeId]+"'><a href='javascript:void(0)' onclick='BXHotKeys.DeleteBase("+
							this.ArrHKCode[i][idxCodeId]+","+this.ArrHKCode[i][idxHKId]+");' class='hk-delete-icon' title='"+this.MesDelete+"'></a></td>";
				else
					editStr ="<td width='30%'>&nbsp;</td><td width='10%'>&nbsp</td>";

				formText+="<tr class = 'bx-hk-settings-row'><td width='60%'>"+this.ArrHKCode[i][idxName]+"</td>"+editStr+"</tr>";
			}

			formText+='</table>';

			var btnClose = new BX.CWindowButton({
				'title': this.MesClose,
				'action': function() { this.parentWindow.Close(); }
			});

			var obWnd = new BX.CDialog({
							title: this.MesSettings,
							content: formText,
							buttons: [btnClose],
							width: 500,
							height: 400,
							resizable: false
						});

			this.tblSettParent=BX("tbl_hk_settings").parentNode;
			BX.addCustomEvent(obWnd, 'onWindowClose', function(obWnd) {
																		obWnd.DIV.parentNode.removeChild(obWnd.DIV);
																		_this.Register();
																	});

			//some customization to standart BX.CDialog
			var hk_menu_div = document.createElement("div");
			hk_menu_div.className = "bx-hk-settings-toolbar";
			hk_menu_div.innerHTML = this.ShowMenu();

			var dialog_head = BX.findChild(obWnd.DIV, {attribute: {'class': 'bx-core-adm-dialog-content'}}, true );

			if(dialog_head)
			{
				dialog_head.appendChild(hk_menu_div);
				BX.findChild(obWnd.DIV, {attribute: {'class': 'bx-core-adm-dialog-content'}}, true ).style.marginTop="37px";
			}
			else // ie quirck mode
			{
				this.hk_getElementsByClass("bx-core-adm-dialog-head")[0].appendChild(hk_menu_div);
				this.hk_getElementsByClass("bx-hk-settings-toolbar",obWnd.DIV,"div")[0].style.width = "480px";
			}

			obWnd.Show();

			this.Unregister();
		};

		this.hk_getElementsByClass = function(className, node, tag)
		{
			var node = node || document,
			tag = tag || '*',
			list = node.getElementsByTagName(tag),
			length = list.length,
			result = [], i,j;
			for(i = 0; i < length; i++)
			{
				if(list[i].className == className)
				{
					result.push(list[i])
					break;
				}
			}
			return result
		}

		this.DelAll = function()
		{
			_this.deleting = true;

			for(var i=0; i<this.ArrHKCode.length; i++)
			{
				_this.UpdateKS(this.ArrHKCode[i][idxCodeId],"");
				_this.UpdateHk(this.ArrHKCode[i][idxCodeId],0);
				_this.SubstAnch(this.ArrHKCode[i][idxCodeId], 0,"");
				_this.SubstDel(this.ArrHKCode[i][idxCodeId],0);
			}

			var request = new JCHttpRequest;
			var options_url = '/bitrix/admin/hot_keys_act.php?hkaction=delete_all';
			var sParam = "&sessid="+phpVars.bitrix_sessid;
			request.Action = function (result)
			{
				_this.deleting = false;
			}

			request.Post(options_url, sParam);
		}

		this.Register = function()
		{
			try //reautorization gives unstable error
			{
				jsUtils.addEvent(document, 'keypress', _this.KeyPressHandler);
				jsUtils.addEvent(document, 'keydown', _this.KeyDownHandler);
			}
			catch (e)
			{
				//nothing
			}
		}

		this.Unregister = function()
		{
			jsUtils.removeEvent(document, 'keypress', _this.KeyPressHandler);
			jsUtils.removeEvent(document, 'keydown', _this.KeyDownHandler);
		}

		this.SetDefault = function()
		{
			var request = new JCHttpRequest;
			var options_url = '/bitrix/admin/hot_keys_act.php?hkaction=set_default';
			var sParam = "&sessid="+phpVars.bitrix_sessid;

			request.Action = function (strDefHK)
			{
				if(strDefHK)
				{
					if(!strDefHK)
						return false;

					var arHK=[];
					var row="";
					var arStrHK=strDefHK.split(";;");

					for(var i=0; i<arStrHK.length; i++)
					{
						arHK=arStrHK[i].split("::");
						row=_this.UpdateHk(arHK[0],arHK[1]);
						if (row>=0)
						{
							_this.UpdateKS(arHK[0],arHK[2]);
							_this.SubstAnch(arHK[0],arHK[1],arHK[2]);
							_this.SubstDel(arHK[0],arHK[1]);
						}
					}
				}
			}

			//waiting while deleting hot-keys
			waiter =
				{
					func: function()
					{
						if (!(this.deleting))
						{
							request.Post(options_url, sParam);
							clearInterval(intervalID);
						}
					}
				}
			intervalID = window.setInterval(function(){ waiter.func.call(waiter) }, 1000);
		}

		this.IsKeysBusy = function(strKeyString,code_id)
		{
			for(var i=0; i<this.ArrHKCode.length; i++)
				if (this.ArrHKCode[i][idxKS]==strKeyString && this.ArrHKCode[i][idxCodeId]!=code_id)
					return true;

			return false;
		}

		this.SubstInput = function(code_id, hk_id, keysString)
		{

			var td = document.getElementById('hotkeys-float-form-'+code_id);

			if(!td)
				return false;

			td.innerHTML='';
			td.innerHTML = '<input type="text" class="adm-input" name="HUMAN_KEYS_STRING" size="10" maxlength="30" value="'+this.PrintKSAsChar(keysString)+'" id="HKeysString" autocomplete="off">'+
							'<input type="hidden" name="KEYS_STRING" value="'+keysString+'" id="KeysString">';

			var inpHKString = document.getElementById("HKeysString");
			var inpKString = document.getElementById("KeysString");

			inpHKString .onkeydown  = _this.SetInput;
			inpHKString .onkeypress = _this.SetInput;
			inpHKString .onkeyup = function ()
			{
				ShowWaitWindow();

				inpHKString .onblur ="";

				if(_this.IsKeysBusy(inpKString.value,code_id))
					if(!confirm(_this.MesBusy))
					{
						_this.SubstAnch(code_id, hk_id, keysString);
						return false;
					}


				_this.bxHotKeyCode=0;

				_this.UpdateKS(code_id,inpKString.value);

				if(hk_id)
				{
					_this.UpdateHk(code_id,hk_id);
					_this.UpdateBase(hk_id,inpKString.value);
				}
				else
					_this.AddBase(code_id,inpKString.value);

				_this.SubstAnch(code_id, hk_id, inpKString.value);

				CloseWaitWindow();
			}

			inpHKString.focus();

			inpHKString.onblur = function ()
			{
				_this.SubstAnch(code_id, hk_id, keysString);
			}
		}

		this.SubstAnch = function(code_id, hk_id, keysString)
		{
			var td = document.getElementById('hotkeys-float-form-'+code_id);
			if(td)
				td.innerHTML = "<a href='javascript:void(0)' onclick='BXHotKeys.SubstInput("+code_id+", "+hk_id+", \""+keysString+"\");' title='"+this.MesClToChange+"' class='bx-hk-settings'>"+(keysString ? this.PrintKSAsChar(keysString) : this.MesNotAssign)+"</a>";
		}

		this.SubstDel = function(code_id, hk_id)
		{
			var td = document.getElementById('hotkeys-float-form-del-'+code_id);
			if (td)
				td.innerHTML = "<a href='javascript:void(0)' onclick='BXHotKeys.DeleteBase("+code_id+","+hk_id+");' class='hk-delete-icon' title='"+this.MesDelete+"'></a>";
		}


		this.AddBase = function(code_id,keysString)
		{
			var request = new JCHttpRequest;
			var options_url = '/bitrix/admin/hot_keys_act.php?hkaction=add';
			var sParam = "&KEYS_STRING="+encodeURIComponent(keysString)+"&CODE_ID="+code_id+"&USER_ID="+_this.uid+"&sessid="+phpVars.bitrix_sessid;
			request.Action = function (hk_id)
			{
				if(hk_id && (hk_id == Number(hk_id)))
				{
					var row =_this.UpdateHk(code_id,hk_id);
					if (row>=0)
					{
						_this.SubstAnch(code_id, hk_id,keysString);
						_this.SubstDel(code_id, hk_id);
					}
				}
			}
			request.Post(options_url, sParam);
		}

		this.Export = function()
		{
			window.open("/bitrix/admin/hot_keys_act.php?hkaction=export&sessid="+phpVars.bitrix_sessid);
		}

		this.OnFileInputChange = function(ob)
		{
			fileName = ob.value;
			fileName = fileName.replace(/\\/g, '/');
			fileName = fileName.substr(fileName.lastIndexOf("/")+1);

			if(ob.parentNode.childNodes[0].textContent)
				ob.parentNode.childNodes[0].textContent = fileName;
			else
				ob.parentNode.childNodes[0].innerText = fileName;
		}

		this.Import = function()
		{
			var formText = 	'<form action="/bitrix/admin/hot_keys_act.php?hkaction=import" method="post" enctype="multipart/form-data" target="upload_iframe" id="hk_import_form" name="hk_import_form">'+
							'<input type="hidden" name="sessid" value="'+BX.bitrix_sessid()+'">'+
							'<span class="adm-input-file"><span>'+this.MesChooseFile+'</span><input type="file" name="bx_hk_filename" id="bx_hk_filename" class="adm-designed-file" onchange="BXHotKeys.OnFileInputChange(this);"></span>'+
							'</form>'+
							'<iframe id="upload_iframe" name="upload_iframe" style="display:none"></iframe>';

			var btnClose = new BX.CWindowButton({
				'title': this.MesClose,
				'action': function() { this.parentWindow.Close(); }
			});

			var btnImport = new BX.CWindowButton({
				'title': this.MesImport,
				'action': function()
									{
										if(!BX('bx_hk_filename').value)
										{
											alert(_this.MesFileEmpty);
											return;
										}

										BX('hk_import_form').submit();
										ShowWaitWindow();
									}
			});


			var impWnd = new BX.CDialog({
							title: this.MesImpHeader,
							content: formText,
							buttons: [btnImport,btnClose],
							width: 300,
							height: 60,
							resizable: false
						});

			impWnd.Show();

		}

		this.OnImportResponse = function(hkNum)
		{
			if(hkNum)
				alert(_this.MesImpSuc+hkNum);
			else
				alert(_this.MesImpFalse);

			BX.reload();
		}

		this.UpdateBase = function(hk_id, keysString)
		{
			var request = new JCHttpRequest;
			var options_url = '/bitrix/admin/hot_keys_act.php?hkaction=update';
			var sParam = "&KEYS_STRING="+encodeURIComponent(keysString)+"&ID="+hk_id+"&sessid="+phpVars.bitrix_sessid;
			request.Post(options_url, sParam);
		}

		this.DeleteBase = function(code_id, hk_id)
		{
			if(hk_id)
			{
				var request = new JCHttpRequest;
				var options_url = '/bitrix/admin/hot_keys_act.php?hkaction=delete';
				var sParam = "&ID="+hk_id+"&sessid="+phpVars.bitrix_sessid;
				request.Post(options_url, sParam);
				_this.UpdateKS(code_id,"");
				_this.UpdateHk(code_id,0);
				_this.SubstAnch(code_id, 0,"");
				_this.SubstDel(code_id,0);
			}
		}

		this.PrintKSAsChar = function(strKeysString)
		{
			if(!strKeysString)
				return "";

			var lastPlus = strKeysString.lastIndexOf("+");
			if(lastPlus)
			{
				var charCode = strKeysString.substr(lastPlus+1,strKeysString.length - (lastPlus+1));
				var preChar = strKeysString.substr(0,lastPlus+1);
				if(charCode==16 || charCode==17 || charCode==18)
					return preChar.substr(0,preChar.length-1);
			}
			else
			{
				var charCode = strKeysString;
				var preChar = "";
			}

			var codeSymb=arServSymb[charCode];
			if(!codeSymb)
				codeSymb = String.fromCharCode(charCode);

			return preChar+codeSymb;
		}

		this.SetInput = function(e)
		{
			e = e || event;

			var inputDopString = (e.ctrlKey ? 'Ctrl+':'') + (e.altKey ? 'Alt+':'') + (e.shiftKey ? 'Shift+':'');

			if(e.keyCode && e.type!="keypress")
				_this.bxHotKeyCode = e.keyCode;

			var charCode;
			if(e.charCode==undefined)
				charCode = e.which;
			else
				charCode = e.charCode;

			if (charCode && (!_this.bxHotKeyCode || _this.bxHotKeyCode==17 || _this.bxHotKeyCode==18 || _this.bxHotKeyCode==16 || _this.bxHotKeyCode==224))
				_this.bxHotKeyCode = charCode;

			document.getElementById("KeysString").value = inputDopString + _this.bxHotKeyCode;
			document.getElementById("HKeysString").value = _this.PrintKSAsChar(document.getElementById("KeysString").value);
			return false;
		}

		//Key-handlers
		this.KeyPressHandler = function(e)
		{
			e = e || event;

			if(e.charCode > 256)
			{
				var ExCode=_this.GetExCode(_this.MakeKeyString(e));

				if (ExCode)
					eval(ExCode);
			}
		}

		this.KeyDownHandler = function(e)
		{
			e = e || event;

			var ExCode=_this.GetExCode(_this.MakeKeyString(e));

			if (ExCode)
				eval(ExCode);
		}
	}

	var BXHotKeys = new CBXHotKeys;
	BXHotKeys.Init();
	window.BXHotKeys = BXHotKeys;
}

/* End */
;
; /* Start:/bitrix/js/main/public_tools.js*/
function JCPopup(arParams)
{
	if (!arParams) arParams = {};
	this.suffix = arParams.suffix ? '_' + arParams.suffix.toString().toLowerCase() : '';
	this.div_id = 'bx_popup_form_div' + this.suffix;
	this.overlay_id = 'bx_popup_overlay' + this.suffix;
	this.form_name = 'bx-popup-form' + this.suffix;
	this.class_name = 'bx-popup-form';
	this.url = '';
	this.zIndex = arParams.zIndex || 1020;
	this.arParams = null;
	this.bDenyClose = false;
	this.bDenyEscKey = false;
	this.__arRuntimeResize = {};
	this.bodyOverflow = "";
	this.currentScroll = 0;
	this.div = null;
	this.div_inner = null;
	this.x = 0;
	this.y = 0;
	this.error_dy = null;
	this.arAdditionalResize = [];
	this.onClose = [];

	var _this = this;
	// Event handlers
	window['JCPopup_OnKeyPress' + this.suffix] = function(e){_this.__OnKeyPress(e)};
	window['JCPopup_OverlayResize' + this.suffix] = function(e){_this.OverlayResize(e)};
	window['JCPopup_AjaxAction' + this.suffix] = function(result) {_this.AjaxAction(result);};
	window['JCPopup_AjaxPostAction' + this.suffix] = function(result) {_this.__AjaxPostAction(result);};
	window['JCPopup_stopResize' + this.suffix] = function(e) {_this.stopResize(e);};
	window['JCPopup_startResize' + this.suffix] = function(e) {_this.startResize(e);};
	window['JCPopup_doResize' + this.suffix] = function(e) {_this.doResize(e);};

	jsExtLoader.jsPopup_name = 'jsPopup' + this.suffix;
}

JCPopup.prototype.addOnClose = function(func)
{
	this.onClose[this.onClose.length] = func;
}

JCPopup.prototype.addAdditionalResize = function(id)
{
	this.arAdditionalResize[this.arAdditionalResize.length] = document.getElementById(id);
};

JCPopup.prototype.clearAdditionalResize = function()
{
	this.arAdditionalResize = [];
};

JCPopup.prototype.DenyClose = function(bDeny)
{
	if (bDeny !== false)
		bDeny = true;
	this.bDenyClose = bDeny;

	if (!this.obSaveButton)
	{
		this.obSaveButton = document.getElementById('btn_popup_save' + this.suffix);
		this.obCloseButton = document.getElementById('btn_popup_close'  + this.suffix);
		this.obCancelButton = document.getElementById('btn_popup_cancel' + this.suffix);
	}

	if (this.obSaveButton) this.obSaveButton.disabled = bDeny;
	if (this.obCloseButton) this.obCloseButton.disabled = bDeny;
	if (this.obCancelButton) this.obCancelButton.disabled = bDeny;
};

JCPopup.prototype.AllowClose = function()
{
	this.DenyClose(false);
};

JCPopup.prototype.__OnKeyPress = function(e)
{
	if(this.bDenyEscKey) return;
	if (!e) e = window.event
	if (!e) return;
	if (this.bDenyClose) return;
	if (e.keyCode == 27)
	{
		jsUtils.removeEvent(document, "keypress", window['JCPopup_OnKeyPress' + this.suffix]);
		this.CloseDialog();
	}
};

JCPopup.prototype.AjaxAction = function(result)
{
	CloseWaitWindow();
	if (this.suffix)
		jsPopup.bDenyClose = true;
	var div = document.body.appendChild(document.createElement("DIV"));
	div.id = this.div_id;
	div.className = this.class_name;
	div.style.position = 'absolute';
	div.style.zIndex = this.zIndex;

	div.innerHTML = result;

	if (null != this.arParams.height)
		div.style.height = this.arParams.height + 'px';
	if (null != this.arParams.width)
		div.style.width = this.arParams.width + 'px';

	var windowSize = jsUtils.GetWindowInnerSize();
	var windowScroll = jsUtils.GetWindowScrollPos();

	var left = parseInt(windowScroll.scrollLeft + windowSize.innerWidth / 2 - div.offsetWidth / 2);
	var top = parseInt(windowScroll.scrollTop + windowSize.innerHeight / 2 - div.offsetHeight / 2);

	jsFloatDiv.Show(div, left, top, 5, true);
	jsUtils.addEvent(document, "keypress", window['JCPopup_OnKeyPress' + this.suffix]);

	this.div = div;
	this.div_inner = document.getElementById('bx_popup_content' + this.suffix);
	if(this.div_inner)
	{
		if(this.div.style.width)
			this.div_inner.style.width = parseInt(parseInt(this.div.style.width) - 12) + 'px';
		if(this.div.style.height)
		{
			var aDivId = ['bx_popup_title', 'bx_popup_description_container', 'bx_popup_buttons'];
			var h=0;
			for(var i=0; i < aDivId.length; i++)
			{
				var dv = document.getElementById(aDivId[i] + this.suffix);
				if(dv)
					h += dv.offsetHeight;
			}
			this.div_inner.style.height = parseInt(parseInt(this.div.style.height) - h - 16) + 'px';
		}
	}

	var _this = this;
	setTimeout(function() {_this.AdjustShadow();}, 10);
	if (this.arParams.resize && null != this.div && null != this.div_inner)
		this.createResizer();
	return div;
};

JCPopup.prototype.__AjaxPostAction = function(result)
{
	CloseWaitWindow();
	if (this.suffix)
		jsPopup.bDenyClose = true;
	this.div.innerHTML = result;
	this.div_inner = document.getElementById('bx_popup_content' + this.suffix);
	this.AdjustShadow();
	if (this.arParams.resize && null != this.div && null != this.div_inner)
		this.createResizer();
};

JCPopup.prototype.ShowDialog = function(url, arParams)
{
	if (document.getElementById(this.div_id))
		this.CloseDialog();

	if (!arParams) arParams = {};
	if (null == arParams.resize) arParams.resize = true;
	if (!arParams.min_width) arParams.min_width = 250;
	if (!arParams.min_height) arParams.min_height = 200;

	var pos = url.indexOf('?');
	if (pos == -1)
		url += "?mode=public";
	else
		url = url.substring(0, pos) + "?mode=public&" + url.substring(pos+1);

	this.check_url = pos == -1 ? url : url.substring(0, pos);

	if (arParams.resize && null != this.__arRuntimeResize[this.check_url])
	{
		arParams.width = this.__arRuntimeResize[this.check_url].width;
		arParams.height = this.__arRuntimeResize[this.check_url].height;
		var ipos = url.indexOf('bxpiheight');
		if (ipos == -1)
			url += (pos == -1 ? '?' : '&') + 'bxpiheight=' + this.__arRuntimeResize[this.check_url].iheight;
		else
			url = url.substring(0, ipos) + 'bxpiheight=' + this.__arRuntimeResize[this.check_url].iheight;
	}

	this.url = url;
	this.arParams = arParams;
	this.CreateOverlay();
	jsExtLoader.onajaxfinish = window['JCPopup_AjaxAction' + this.suffix];
	if(arParams['postData'])
		jsExtLoader.startPost(url, arParams['postData']);
	else
		jsExtLoader.start(url);
};

JCPopup.prototype.RemoveOverlay = function()
{
	//var overlay = document.getElementById(this.overlay_id);
	if (this.overlay)
		this.overlay.parentNode.removeChild(this.overlay);
	jsUtils.removeEvent(window, "resize", window['JCPopup_OverlayResize' + this.suffix]);
};

JCPopup.prototype.OverlayResize = function()
{
	//var overlay = document.getElementById(this.overlay_id);
	if (!this.overlay)
		return;
	var windowSize = jsUtils.GetWindowScrollSize();
	this.overlay.style.width = windowSize.scrollWidth + "px";
};

JCPopup.prototype.CreateOverlay = function()
{
	var opacity = new COpacity();
	if (!opacity.GetOpacityProperty())
		return;
	//Create overlay
	this.overlay = document.body.appendChild(document.createElement("DIV"));
	this.overlay.className = "bx-popup-overlay";
	this.overlay.id = this.overlay_id;
	this.overlay.style.zIndex = this.zIndex - 5;

	var windowSize = jsUtils.GetWindowScrollSize();

	this.overlay.style.width = windowSize.scrollWidth + "px";
	this.overlay.style.height = windowSize.scrollHeight + "px";

	jsUtils.addEvent(window, "resize", window['JCPopup_OverlayResize' + this.suffix]);
};

JCPopup.prototype.CloseDialog = function()
{
	jsUtils.onCustomEvent('OnBeforeCloseDialog', this.suffix);

	for(var i=0; i<this.onClose.length; i++)
		this.onClose[i]();

	if (this.bDenyClose)
		return false;
	if (this.suffix)
		jsPopup.bDenyClose = false;
	jsUtils.removeEvent(document, "keypress", window['JCPopup_OnKeyPress' + this.suffix]);
	var div = document.getElementById(this.div_id);
	if (!div)
		return;
	jsFloatDiv.Close(div);
	div.parentNode.removeChild(div);
	this.clearAdditionalResize();
	this.RemoveOverlay();

	return true;
};

JCPopup.prototype.GetParameters = function(form_name)
{
	if (null == form_name)
		var form = document.forms[this.form_name];
	else
		var form = document.forms[form_name];

	if(!form)
		return "";

	var i, s = "";
	var n = form.elements.length;

	var delim = '';
	for(i=0; i<n; i++)
	{
		if (s != '') delim = '&';
		var el = form.elements[i];
		if (el.disabled)
			continue;

		switch(el.type.toLowerCase())
		{
			case 'text':
			case 'textarea':
			case 'password':
			case 'hidden':
				if (null == form_name && el.name.substr(el.name.length-4) == '_alt' && form.elements[el.name.substr(0, el.name.length-4)])
					break;
				s += delim + el.name + '=' + encodeURIComponent(el.value);
				break;
			case 'radio':
				if(el.checked)
					s += delim + el.name + '=' + encodeURIComponent(el.value);
				break;
			case 'checkbox':
				s += delim + el.name + '=' + encodeURIComponent(el.checked ? 'Y':'N');
				break;
			case 'select-one':
				var val = "";
				if (null == form_name && form.elements[el.name + '_alt'] && el.selectedIndex == 0)
					val = form.elements[el.name+'_alt'].value;
				else
					val = el.value;
				s += delim + el.name + '=' + encodeURIComponent(val);
				break;
			case 'select-multiple':
				var j, bAdded = false;
				var l = el.options.length;
				for (j=0; j<l; j++)
				{
					if (el.options[j].selected)
					{
						s += delim + el.name + '=' + encodeURIComponent(el.options[j].value);
						bAdded = true;
					}
				}
				if (!bAdded)
					s += delim + el.name + '=';
				break;
			default:
				break;
		}
	}

	if (null != this.arParams && this.arParams.resize && this.div_inner)
	{
		var inner_width = parseInt(this.div_inner.style.width);
		var inner_height = parseInt(this.div_inner.style.height);

		if (inner_width > 0)
			s += '&bxpiwidth=' + inner_width;
		if (inner_height > 0)
			s += '&bxpiheight=' + inner_height;
	}

	return s;
};

JCPopup.prototype.PostParameters = function(params)
{
	var _this = this;
	jsExtLoader.onajaxfinish = window['JCPopup_AjaxPostAction' + this.suffix];
	ShowWaitWindow();
	var url = this.url;
	if (null != params)
	{
		index = url.indexOf('?')
		if (index == -1)
			url += '?' + params;
		else
			url = url.substring(0, index) + '?' + params + "&" + url.substring(index+1);
	}

	jsExtLoader.startPost(url, this.GetParameters());
};

JCPopup.prototype.AdjustShadow = function()
{
	if (this.div)
		jsFloatDiv.AdjustShadow(this.div);
};

JCPopup.prototype.HideShadow = function()
{
	if (this.div)
		jsFloatDiv.HideShadow(this.div);
};

JCPopup.prototype.UnhideShadow = function()
{
	if (this.div)
		jsFloatDiv.UnhideShadow(this.div);
};

JCPopup.prototype.DragPanel = function(event, td)
{
	var div = jsUtils.FindParentObject(td, 'div');
	div.style.left = div.offsetLeft+'px';
	div.style.top = div.offsetTop+'px';
	jsFloatDiv.StartDrag(event, div);
};

// ************* resizers ************* //
JCPopup.prototype.createResizer = function()
{
	this.diff_x = null;
	this.diff_y = null;
	this.arPos = jsUtils.GetRealPos(this.div);
	var zIndex = parseInt(jsUtils.GetStyleValue(this.div, jsUtils.IsIE() ? 'zIndex' : 'z-index')) + 1;
	this.obResizer = document.createElement('DIV');
	this.obResizer.className = 'bxresizer';
	this.obResizer.style.position = 'absolute';
	this.obResizer.style.zIndex = zIndex;
	this.obResizer.onmousedown = window['JCPopup_startResize' + this.suffix];
	//this.obResizer.onmousedown = this.startResize;
	this.div.appendChild(this.obResizer);
};

JCPopup.prototype.startResize = function (e)
{
	if(!e) e = window.event;

	this.wndSize = jsUtils.GetWindowScrollPos();
	this.wndSize.innerWidth = jsUtils.GetWindowInnerSize().innerWidth;

	this.x = e.clientX + this.wndSize.scrollLeft;
	this.y = e.clientY + this.wndSize.scrollTop;
	this.obDescr = document.getElementById('bx_popup_description_container' + this.suffix);
	if (jsUtils.IsIE())
	{
		this.arPos = this.div.getBoundingClientRect();
		this.arPos =
		{
			left: this.arPos.left + this.wndSize.scrollLeft,
			top: this.arPos.top + this.wndSize.scrollTop,
			right: this.arPos.right + this.wndSize.scrollLeft,
			bottom: this.arPos.bottom + this.wndSize.scrollTop
		}
		this.arPosInner = this.div_inner.getBoundingClientRect();
		this.arPosInner = {
			left: this.arPosInner.left + this.wndSize.scrollLeft,
			top: this.arPosInner.top + this.wndSize.scrollTop,
			right: this.arPosInner.right + this.wndSize.scrollLeft,
			bottom: this.arPosInner.bottom + this.wndSize.scrollTop
		}
	}
	else
	{
		this.arPos = jsUtils.GetRealPos(this.div);
		this.arPosInner = jsUtils.GetRealPos(this.div_inner);
	}

	document.onmouseup = window['JCPopup_stopResize' + this.suffix];
	jsUtils.addEvent(document, "mousemove", window['JCPopup_doResize' + this.suffix]);

	if(document.body.setCapture)
		document.body.setCapture();

	var b = document.body;
	b.ondrag = jsUtils.False;
	b.onselectstart = jsUtils.False;
	b.style.MozUserSelect = this.div.style.MozUserSelect = 'none';
	b.style.cursor = this.obResizer.style.cursor;

	this.HideShadow();
};

JCPopup.prototype.doResize = function(e)
{
	if(!e) e = window.event;
	var x = e.clientX + this.wndSize.scrollLeft;
	var y = e.clientY + this.wndSize.scrollTop;

	if(this.x == x && this.y == y || x > this.wndSize.innerWidth + this.wndSize.scrollLeft - 10)
		return;

	this.Resize(x, y);
	this.x = x;
	this.y = y;
};

JCPopup.prototype.Resize = function(x, y)
{
	if (null == this.diff_x)
	{
		this.diff_x = this.div.offsetWidth - this.div_inner.offsetWidth;
		this.diff_y = this.div.offsetHeight - this.div_inner.offsetHeight;

		if (this.arAdditionalResize.length > 0)
		{
			for (var i = 0, cnt = this.arAdditionalResize.length; i < cnt; i++)
			{
				if (null != this.arAdditionalResize[i])
				{
					var borderX = jsUtils.IsOpera() ? 0 :
						parseInt(jsUtils.GetStyleValue(
							this.arAdditionalResize[i], jsUtils.IsIE() ? 'borderLeftWidth' : 'border-left-width'
						)) +
						parseInt(jsUtils.GetStyleValue(
							this.arAdditionalResize[i], jsUtils.IsIE() ? 'borderRightWidth' : 'border-right-width'
						));

					var borderY = jsUtils.IsOpera() || jsUtils.IsIE() ? 0 :
						parseInt(jsUtils.GetStyleValue(this.arAdditionalResize[i], 'border-top-width')) +
						parseInt(jsUtils.GetStyleValue(this.arAdditionalResize[i], 'border-bottom-width'));

					this.arAdditionalResize[i].diff_x = this.div.offsetWidth - this.arAdditionalResize[i].offsetWidth + borderX;
					this.arAdditionalResize[i].diff_y = this.div.offsetHeight - this.arAdditionalResize[i].offsetHeight + borderY;
				}
			}
		}
	}
	var new_width = x - this.arPos.left;
	var new_height = y - this.arPos.top;
	var dx = new_width - this.div.offsetWidth;
	//var dy = y - this.y;

	if (null != this.obDescr)
		var descrHeight = this.obDescr.offsetHeight;

	var bResizeX = false;
	if (new_width > this.arParams.min_width)
	{
		bResizeX = true;
		this.div.style.width = new_width + 'px';
		this.div_inner.style.width = (new_width - this.diff_x) + 'px';
	}

	if (null != this.obDescr)
		var dy = this.obDescr.offsetHeight - descrHeight;
	else
		var dy = 0;

	this.diff_y += dy;
	var bResizeY = false;
	if (new_height > this.arParams.min_height)
	{
		bResizeY = true;
		this.div_inner.style.height = (new_height - this.diff_y) + 'px';
		this.div.style.height = new_height + 'px';
	}

	if (this.arAdditionalResize.length > 0)
	{
		for (var i = 0, cnt = this.arAdditionalResize.length; i < cnt; i++)
		{
			if (null != this.arAdditionalResize[i])
			{
				if (bResizeY) this.arAdditionalResize[i].style.height = (new_height - this.arAdditionalResize[i].diff_y) + 'px';
				if (bResizeX) this.arAdditionalResize[i].style.width = (new_width - this.arAdditionalResize[i].diff_x) + 'px';
			}
		}
	}
	if (jsUtils.IsIE())
		this.AdjustShadow();
};

JCPopup.prototype.stopResize = function ()
{
	if(document.body.releaseCapture)
		document.body.releaseCapture();

	jsUtils.removeEvent(document, "mousemove", window['JCPopup_doResize' + this.suffix]);

	document.onmouseup = null;

	var b = document.body;
	b.ondrag = null;
	b.onselectstart = null;
	b.style.MozUserSelect = this.div.style.MozUserSelect = '';
	b.style.cursor = '';

	this.UnhideShadow();
	this.AdjustShadow();
	this.SavePosition();
};

JCPopup.prototype.SavePosition = function()
{
	var arPos = {
		width: parseInt(this.div.style.width),
		height: parseInt(this.div.style.height),
		iheight: parseInt(this.div_inner.style.height)
	};

	if (null != this.error_dy)
		arPos.iheight += this.error_dy;

	jsUserOptions.SaveOption('jsPopup' + this.suffix, 'size_' + this.check_url, 'width', arPos.width);
	jsUserOptions.SaveOption('jsPopup' + this.suffix, 'size_' + this.check_url, 'height', arPos.height);
	jsUserOptions.SaveOption('jsPopup' + this.suffix, 'size_' + this.check_url, 'iheight', arPos.iheight);

	for (var i = 0, cnt = this.arAdditionalResize.length; i < cnt; i++)
	{
		if (null != this.arAdditionalResize[i] && null != this.arAdditionalResize[i].BXResizeCacheID)
		{
			jsUserOptions.SaveOption('jsPopup' + this.suffix, 'size_' + this.check_url, this.arAdditionalResize[i].BXResizeCacheID + '_height', parseInt(this.arAdditionalResize[i].style.height));
			jsUserOptions.SaveOption('jsPopup' + this.suffix, 'size_' + this.check_url, this.arAdditionalResize[i].BXResizeCacheID + '_width', parseInt(this.arAdditionalResize[i].style.width));
		}
	}
	this.__arRuntimeResize[this.check_url] = arPos;
};

JCPopup.prototype.IncludePrepare = function()
{
	var obFrame = window.frames.editor;
	if (null == obFrame)
		return false;
	var obSrcForm = obFrame.document.forms.inner_form;
	var obDestForm = document.forms[this.form_name];
	if (null == obSrcForm || null == obDestForm)
		return false;
	obDestForm.include_data.value = obSrcForm.filesrc_pub.value;
	return true;
};

JCPopup.prototype.ShowError = function(error_text)
{
	CloseWaitWindow();
	this.AllowClose();

	this.obDescr = document.getElementById('bx_popup_description_container' + this.suffix);
	if (null != this.obDescr)
	{
		var descrHeight = this.obDescr.offsetHeight;
		var obError = document.getElementById('bx_popup_description_error' + this.suffix);
		if (!obError)
		{
			obError = document.createElement('P');
			obError.id = 'bx_popup_description_error' + this.suffix;
			this.obDescr.firstChild.appendChild(obError);
		}
		obError.innerHTML = '<font class="errortext">' + error_text + '</font>';
		if (this.obDescr.offsetHeight != descrHeight)
		{
			this.error_dy = this.obDescr.offsetHeight - descrHeight;
			if (this.div_inner)
				this.div_inner.style.height = (parseInt(jsUtils.GetStyleValue(this.div_inner, 'height')) - this.error_dy) + 'px';
		}
	}
	else
		alert(error_text);
};

function JCComponentUtils()
{
}

JCComponentUtils.prototype.ClearCache = function(params)
{
	CHttpRequest.Action = function(result){window.location = window.location.href;};
	ShowWaitWindow();
	CHttpRequest.Send('/bitrix/admin/clear_component_cache.php?' + params);
};

JCComponentUtils.prototype.EnableComponent = function(params)
{
	CHttpRequest.Action = function(result){window.location = window.location.href;};
	ShowWaitWindow();
	CHttpRequest.Send('/bitrix/admin/enable_component.php?' + params);
};

function COpacity(element)
{
	this.element = element;
	this.opacityProperty = this.GetOpacityProperty();

	this.startOpacity = null;
	this.finishOpacity = null;
	this.delay = 30;

	this.currentOpacity = null;
	this.fadingTimeoutID = null;
}


COpacity.prototype.SetElementOpacity = function(opacity)
{
	if (!this.opacityProperty)
		return false;

	if (this.opacityProperty == "filter")
	{
		opacity = opacity * 100;
		var alphaFilter = this.element.filters['DXImageTransform.Microsoft.alpha'] || this.element.filters.alpha;
		if (alphaFilter)
			alphaFilter.opacity = opacity;
		else
			this.element.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity="+opacity+")";
	}
	else
		this.element.style[this.opacityProperty] = opacity;

	return true;
}

COpacity.prototype.GetOpacityProperty = function()
{
	var m;
	if (typeof document.body.style.opacity == 'string')
		return 'opacity';
	else if (typeof document.body.style.MozOpacity == 'string')
		return 'MozOpacity';
	else if (typeof document.body.style.KhtmlOpacity == 'string')
		return 'KhtmlOpacity';
	else if (document.body.filters && (m = navigator.appVersion.match(/MSIE ([\d.]+)/)) && m[1] >=5.5)
		return 'filter';

	return false;
}

COpacity.prototype.Fading = function(startOpacity, finishOpacity, callback)
{
	if (!this.opacityProperty)
		return;

	this.startOpacity = startOpacity;
	this.finishOpacity = finishOpacity;
	this.currentOpacity = this.startOpacity;

	if (this.fadingTimeoutID)
		clearInterval(this.fadingTimeoutID);

	var _this = this;
	this.fadingTimeoutID = setInterval(function () {_this.Run(callback)}, this.delay);
}

COpacity.prototype.Run = function(callback)
{
	this.currentOpacity = Math.round((this.currentOpacity + 0.1*(this.finishOpacity - this.startOpacity > 0 ? 1: -1) )*10) / 10;
	this.SetElementOpacity(this.currentOpacity);

	if (this.currentOpacity == this.startOpacity || this.currentOpacity == this.finishOpacity)
	{
		clearInterval(this.fadingTimeoutID);
		if (typeof(callback) == "function")
			callback(this);
	}
}

COpacity.prototype.Undo = function()
{
}

// this object can be used to load any pages with huge scripts structure via AJAX
var jsExtLoader = {
	obContainer: null,
	obContainerInner: null,
	jsPopup_name: 'jsPopup',
	url: '',

	httpRequest: null,
	httpRequest2: null, // for Opera bug fix

	obTemporary: null,

	onajaxfinish: null,

	obFrame: null,

	start: function(url)
	{
		this.url = url;

		this.obContainer = null;

		ShowWaitWindow();

		this.httpRequest = this._CreateHttpObject();
		this.httpRequest.onreadystatechange = jsExtLoader.stepOne;

		this.httpRequest.open("GET", this.url, true);
		this.httpRequest.send("");
	},

	startPost: function(url, data)
	{
		this.url = url;
		this.obContainer = null;

		ShowWaitWindow();

		this.httpRequest = this._CreateHttpObject();
		this.httpRequest.onreadystatechange = jsExtLoader.stepOne;

		this.httpRequest.open("POST", this.url, true);
		this.httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		this.httpRequest.send(data);
	},

	post: function(form_name)
	{
		var obForm = document.forms[form_name];
		if (null == obForm)
			return;

		if (null == this.obFrame)
		{
			if (jsUtils.IsIE())
				this.obFrame = document.createElement('<iframe src="javascript:void(0)" name="frame_' + form_name + '">');
			else
			{
				this.obFrame = document.createElement('IFRAME');
				this.obFrame.name = 'frame_' + form_name;
				this.obFrame.src = 'javascript:void(0)';
			}

			this.obFrame.style.display = 'none';

			document.body.appendChild(this.obFrame);
		}

		obForm.target = this.obFrame.name;

		if (obForm.action.length <= 0)
			obForm.action = this.url;

		window[jsExtLoader.jsPopup_name].DenyClose();
		ShowWaitWindow();

		obForm.save.click();

		if (false === obForm.BXReturnValue)
		{
			window[jsExtLoader.jsPopup_name].AllowClose();
			CloseWaitWindow();
		}

		obForm.BXReturnValue = true;
	},

	urlencode: function(s)
	{
		return escape(s).replace(new RegExp('\\+','g'), '%2B');
	},

	__prepareOnload: function()
	{
		this.obTemporary = window.onload;
		window.onload = null;
	},

	__runOnload: function()
	{
		if (window.onload) window.onload();
		window.onload = this.obTemporary;
		this.obTemporary = null;
	},

	stepOne: function()
	{
		if (jsExtLoader.httpRequest.readyState == 4)
		{
			var content = jsExtLoader.httpRequest.responseText;
			var arCode = [];
			var matchScript;

			var regexp = new RegExp('<script([^>]*)>', 'i');
			var regexp1 = new RegExp('src=["\']([^"\']+)["\']', 'i');

			while ((matchScript = content.match(regexp)) !== null)
			{
				var end = content.search('<\/script>', 'i');
				if (end == -1)
					break;

				var bRunFirst = matchScript[1].indexOf('bxrunfirst') != '-1';

				var matchSrc;
				if ((matchSrc = matchScript[1].match(regexp1)) !== null)
					arCode[arCode.length] = {"bRunFirst": bRunFirst, "isInternal": false, "JS": matchSrc[1]};
				else
				{
					var start = matchScript.index + matchScript[0].length;
					var js = content.substr(start, end-start);

					if (false && arCode.length > 0 && arCode[arCode.length - 1].isInternal && arCode[arCode.length - 1].bRunFirst == bRunFirst)
						arCode[arCode.length - 1].JS += "\r\n\r\n" + js;
					else
						arCode[arCode.length] = {"bRunFirst": bRunFirst, "isInternal": true, "JS": js};
				}

				content = content.substr(0, matchScript.index) + content.substr(end+9);
			}

			jsExtLoader.__prepareOnload();
			jsExtLoader.processResult(content, arCode);
			CloseWaitWindow();
			jsExtLoader.__runOnload();
		}
	},

	EvalGlobal: function(script)
	{
		if (window.execScript)
			window.execScript(script, 'javascript');
		else if (jsUtils.IsSafari())
			window.setTimeout(script, 0);
		else
			window.eval(script);
	},

	arLoadedScripts: [],

	__isScriptLoaded: function (script_src)
	{
		for (var i=0; i<jsExtLoader.arLoadedScripts.length; i++)
			if (jsExtLoader.arLoadedScripts[i] == script_src) return true;
		return false;
	},

	// evaluate external script
	EvalExternal: function(script_src)
	{
		if (/\/bitrix\/js\/main\/public_tools.js$/i.test(script_src)) return; // sorry guys, i cannot execute myself :-)
		if (jsExtLoader.__isScriptLoaded(script_src)) return;

		jsExtLoader.arLoadedScripts.push(script_src);

		if (script_src.substring(0, 8) != '/bitrix/')
			script_src = '/bitrix/admin/' + script_src;

		// fix Opera bug with combining syncronous and asynchronuos requests using one XHR object.
		if (jsUtils.IsOpera())
		{
			if (null == this.httpRequest2)
				this.httpRequest2 = this._CreateHttpObject();

			var httpRequest = this.httpRequest2;
		}
		else
		{
			var httpRequest = this.httpRequest;
		}

		httpRequest.onreadystatechange = function (str) {};
		httpRequest.open("GET", script_src, false);
		httpRequest.send("");

		var s = httpRequest.responseText;

		httpRequest = null;

		try
		{
			this.EvalGlobal(s);
		}
		catch(e)
		{
			//alert('script_src: ' + script_src + '<pre>' + s + '</pre>');
		}
	},

	processResult: function(content, arCode)
	{
		//Javascript
		jsExtLoader.processScripts(arCode, true);

		if (null == jsExtLoader.obContainer)
			jsExtLoader.obContainer = jsExtLoader.onajaxfinish(content);
		else
			jsExtLoader.obContainer.innerHTML = content;

		//Javascript
		jsExtLoader.processScripts(arCode, false);
	},

	processScripts: function(arCode, bRunFirst)
	{
		for (var i = 0, length = arCode.length; i < length; i++)
		{
			if (arCode[i].bRunFirst != bRunFirst)
				continue;

			if (arCode[i].isInternal)
			{
				arCode[i].JS = arCode[i].JS.replace('<!--', '');
				jsExtLoader.EvalGlobal(arCode[i].JS);
			}
			else
			{
				jsExtLoader.EvalExternal(arCode[i].JS);
			}
		}
	},

	_CreateHttpObject: function()
	{
		var obj = null;
		if(window.XMLHttpRequest)
		{
			try {obj = new XMLHttpRequest();} catch(e){}
		}
		else if(window.ActiveXObject)
		{
			try {obj = new ActiveXObject("Microsoft.XMLHTTP");} catch(e){}
			if(!obj)
				try {obj = new ActiveXObject("Msxml2.XMLHTTP");} catch (e){}
		}
		return obj;
	}
}

/*
public jsAdminStyle - external CSS manager
*/

var jsAdminStyle = {

	arCSS: {},
	bInited: false,

	httpRequest: null,

	Init: function()
	{
		var arStyles = document.getElementsByTagName('LINK');
		if (arStyles.length > 0)
		{
			for (var i = 0; i<arStyles.length; i++)
			{
				if (arStyles[i].href)
				{
					var filename = arStyles[i].href;
					var pos = filename.indexOf('://');
					if (pos != -1)
						filename = filename.substr(filename.indexOf('/', pos + 3));

					arStyles[i].bxajaxflag = false;
					this.arCSS[filename] = arStyles[i];
				}
			}
		}

		this.bInited = true;
	},

	Load: function(filename)
	{
		if (!this.bInited) this.Init();

		if (null != this.arCSS[filename])
		{
			this.arCSS[filename].disabled = false;
			return;
		}

		var link = document.createElement("STYLE");
		link.type = 'text/css';

		var head = document.getElementsByTagName("HEAD")[0];
		head.insertBefore(link, head.firstChild);
		//head.appendChild(link);

		if (jsUtils.IsIE())
		{
			link.styleSheet.addImport(filename);
		}
		else
		{
			try
			{
				if (null == this.httpRequest)
					this.httpRequest = jsExtLoader._CreateHttpObject();

				this.httpRequest.onreadystatechange = null;

				this.httpRequest.open("GET", filename, false); // make *synchronous* request for css source
				this.httpRequest.send("");

				var s = this.httpRequest.responseText;

				// convert relative resourse paths in css to absolute. current path to css will be lost.
				var pos = filename.lastIndexOf('/');
				if (pos != -1)
				{
					var dirname = filename.substring(0, pos);
					s = s.replace(/url\(([^\/\\].*?)\)/gi, 'url(' + dirname + '/$1)');
				}

				link.appendChild(document.createTextNode(s));
			}
			catch (e) {}
		}
	},

	Unload: function(filename)
	{
		if (!this.bInited) this.Init();

		if (null != this.arCSS[filename])
		{
			this.arCSS[filename].disabled = true;
		}
	},

	UnloadAll: function()
	{
		if (!this.bInited) this.Init();
		else
			for (var i in this.arCSS)
			{
				if (this.arCSS[i].bxajaxflag)
					this.Unload(i);
			}
	}
}

// for compatibility with IE 5.0 browser
if (![].pop)
{
	Array.prototype.pop = function()
	{
		if (this.length <= 0) return false;
		var element = this[this.length-1];
		delete this[this.length-1];
		this.length--;
		return element;
	}

	Array.prototype.shift = function()
	{
		if (this.length <= 0) return false;
		var tmp = this.reverse();
		var element = tmp.pop();
		this.prototype = tmp.reverse();
		return element;
	}

	Array.prototype.push = function(element)
	{
		this[this.length] = element;
	}
}
//************************************************************

function jsWizard()
{
	this.currentStep = null;
	this.firstStep = null;

	this.arSteps = {};

	this.nextButtonID = "btn_popup_next";
	this.prevButtonID = "btn_popup_prev";
	this.finishButtonID = "btn_popup_finish";

	this.arButtons = {};
}

jsWizard.prototype.AddStep = function(stepID, arButtons)
{
	var element = document.getElementById(stepID);
	if (!element)
		return;

	if (typeof(arButtons) != "object")
		arButtons = {};

	this.arSteps[stepID] = {"element": element};

	//Actions
	for (var button in arButtons)
		this.arSteps[stepID][button] = arButtons[button];

	if (this.firstStep === null)
		this.firstStep = stepID;
}

jsWizard.prototype.SetCurrentStep = function(stepID)
{
	this.currentStep = stepID;
}

jsWizard.prototype.SetFirstStep = function(stepID)
{
	this.firstStep = stepID;
}

jsWizard.prototype.SetNextButtonID = function(buttonID)
{
	this.nextButtonID = buttonID;
}

jsWizard.prototype.SetPrevButtonID = function(buttonID)
{
	this.prevButtonID = buttonID;
}

jsWizard.prototype.SetFinishButtonID = function(buttonID)
{
	this.finishButtonID = buttonID;
}

jsWizard.prototype.SetCancelButtonID = function(buttonID)
{
	this.cancelButtonID = buttonID;
}


jsWizard.prototype.SetButtonDisabled = function(button, disabled)
{
	if (this.arButtons[button])
		this.arButtons[button].disabled = disabled;
}

jsWizard.prototype.IsStepExists = function(stepID)
{
	if (this.arSteps[stepID])
		return true;
	else
		return false;
}

jsWizard.prototype.Display = function()
{
	if (this.firstStep === null)
		return;

	this.currentStep = this.firstStep;

	var _this = this;
	var arButtons = {"next" : this.nextButtonID, "prev" : this.prevButtonID, "finish" : this.finishButtonID};
	for (var button in arButtons)
	{
		var buttonElement = document.getElementById(arButtons[button]);
		if (buttonElement && buttonElement.tagName == "INPUT")
		{
			buttonElement.buttonID = button;
			buttonElement.onclick = function() {_this._OnButtonClick(this.buttonID)};
			this.arButtons[button] = buttonElement;
		}
		else
			this.arButtons[button] = null;
	}

	this._OnStepShow();
}

jsWizard.prototype._OnButtonClick = function(button)
{
	if (this.arSteps[this.currentStep] )
	{
		var callback = this.arSteps[this.currentStep]["on" + button];
		if (callback && typeof(callback) == "function")
		{
			if (callback(this) === false)
				return;
		}
	}

	if (!this.arSteps[this.currentStep])
	{
		if (!this.arSteps[this.firstStep])
			return;

		this.currentStep = this.firstStep;
	}
	else if (this.arSteps[this.currentStep][button])
		this.currentStep = this.arSteps[this.currentStep][button];

	this._OnStepShow();
}

jsWizard.prototype._OnStepShow = function()
{
	//Display current step and hide others steps
	for (var stepID in this.arSteps)
		this.arSteps[stepID].element.style.display = (stepID == this.currentStep ? "" : "none");

	//Activate and disable buttons
	for (var button in this.arButtons)
	{
		if (this.arButtons[button])
		{
			var stepID = this.arSteps[this.currentStep][button];
			this.arButtons[button].disabled = (stepID && this.arSteps[stepID] ? false : true);
		}
	}

	//Execute onshow function
	if (this.arSteps[this.currentStep])
	{
		var callback = this.arSteps[this.currentStep]["onshow"];
		if (callback && typeof(callback) == "function")
			callback(this);
	}
}

var jsPopup = new JCPopup();
var jsComponentUtils = new JCComponentUtils();

/* End */
;