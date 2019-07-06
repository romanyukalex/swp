// Manifesto: $Id: utilities.js 1919 2010-02-01 19:08:02Z spud $
// license: GNU LGPL
// copyright 2001-2008: dada typo and contributors

/* ------------------------------------------------------------------------
// Collapsable module boxes in the left and right sidebars
// This script works on the principle that the drop arrow has an ID of [module]_droparrow
// and it toggles the display of an element whose ID is [module]_modbox
------------------------------------------------------------------------ */
function collapsableModboxes() {
	jQuery(".droparrow").click(function(event) {
		if (event.altKey) {
			event.stopPropagation();
			jQuery(".droparrow").click();
		} else {
			var box = "#"+jQuery(this).attr("id").replace("_droparrow","_modbox");
			jQuery(box).slideToggle("fast");
			var src = jQuery(this).attr("src");
			if (src.indexOf('undrop') == -1) {
				jQuery(this).attr("src",src.replace("drop","undrop"));
			} else {
				jQuery(this).attr("src",src.replace("undrop","drop"));
			}
		}
	});
}
// add the event to the onload handler
jQuery(document).ready(collapsableModboxes);

/* ------------------------------------------------------------------------
// ZoomableImages creates an overlay popup of an image
// It expects an A tag with an HREF containing the URL to the image
// It is applied to all tags with class of "zoom" and intercepts the click
------------------------------------------------------------------------ */
function zoomableImages() {
	jQuery("a.zoom").fancybox({"overlayOpacity":.6});
}
// add the event to the onload handler
jQuery(document).ready(zoomableImages);

/* ------------------------------------------------------------------------
// thumbView creates an overlay popup of a thumbnail image
// It expects an A tag with an HREF containing the URL to the image
// It is applied to all tags with class of "thumbview" and is triggered on mouseover
------------------------------------------------------------------------ */
function thumbView() {
	jQuery(".thumbview").hover(function(event) {
		var thumbpop = jQuery("<div></div>").attr("id","thumbpop").css({"backgroundColor":"#ffffff","border":"1px solid #999999","padding":"3px"});
		thumbpop.append(jQuery('<img />').attr({"src": jQuery(this).attr("href"), "alt": jQuery(this).attr("href")}));
		jQuery(this).css("position","relative").append(thumbpop);
	},
	function() {
		jQuery("#thumbpop").remove();
	});
}
jQuery(document).ready(thumbView);

/* ------------------------------------------------------------------------
// switchTabs
// This toggles a nice sliding transition between tabbed DIVs 
// It is applied to all A tags inside a ".tabbar" and triggered on click
// If the requested URL already specifies an anchor, it will attempt to
// automatically call the click() handler on the appropriate tab and
// preload the correct output section.
// 
// It assumes a nested structure of proximity and parentage, for example:
// <code>
// <div title="Container Element">
//    <ul class="tabbar" title="The Tab Menu Bar">
//       <li><a href="#section_1">First Element</a></li>
//       <li><a href="#section_2">Second Element</a></li>
//    </ul>
//    <div class="tabdivs" title="The Sections To Be Displayed">
//       <div id="section_1">Some content goes here</div>
//       <div id="section_2">Other content goes here</div>
//    </div>
// </div>
// </code>
------------------------------------------------------------------------ */
function switchTabs() {
	// Get all the A tags in the tabbar
	jQuery(".tabbar a").each(function(i){
		// Tabs with no hash are not switchable, so ignore them
		if (jQuery(this).attr("hash") != "#" && jQuery(this).attr("hash") != "") {
			var href = jQuery(this).attr("href");
			// Get the tabdivs DIV associated with the parent .tabcontainer, and hide its children DIVS
			if (jQuery(this).parent().hasClass("selected")) {
				jQuery(href).fadeIn("fast");
			} else {
				jQuery(href).hide();
			}
			jQuery(this).click(function(event) {
				// Remove the selected class from all tabs (LI children of .tabbar)
				jQuery(this).parents(".tabbar").children("li").removeClass("selected");
				// Add selected class to parent LI of this A tag
				jQuery(this).parent("li").addClass("selected");
				// Get the tabdivs DIV associated with the parent .tabcontainer, and hide its children DIVS
				jQuery(this).parents(".tabbar").next(".tabdivs").children("div,table,ul,ol,fieldset").hide();
				jQuery(href).fadeIn("fast");
				event.preventDefault();
			});
		}
		if (window.location.hash.length > 1) {
			jQuery("a[href="+window.location.hash+"]").click();
		}
	});
}
// add the event to the onload handler
jQuery(document).ready(switchTabs);

/* ------------------------------------------------------------------------
// toggleDisplay
// This toggles any DIV using a nice sliding transition 
// It is applied to all A tags with a class of toggleclick
------------------------------------------------------------------------ */
function toggleDisplay() {
	jQuery(".toggleclick").each(function(i) {
		if (jQuery(this).attr("hash") != "#" && jQuery(this).attr("hash") != "") {
			var href = jQuery(this).attr("href");
			// hide the reference by default
			jQuery(href).hide();
			jQuery(this).click(function(event) {
				jQuery(href).slideToggle("normal");
				event.preventDefault();
			});
		}
	});
}
// add the event to the onload handler
jQuery(document).ready(toggleDisplay);

/* ------------------------------------------------------------------------
// toggleDisclosure creates toggleable header/div combinations
// It expects an A tag with an HREF containing the URL to the image
// It is applied to all tags with class of "disclosure"
------------------------------------------------------------------------ */
function toggleDisclosure() {
	jQuery("li.disclosure > a").each(function(i) {
		var href = jQuery(this).attr("href");
		// if this is an anchor reference...
		if (href.indexOf("#") == 0) {
			// hide the reference by default
			jQuery(href).hide();
			// and attach the disclosure action to the click event
			jQuery(this).click(function(event) {
				jQuery(href).slideToggle("normal");
				jQuery(this).closest("LI").toggleClass("down");
				event.preventDefault();
			});
		}
	});
}		
jQuery(document).ready(toggleDisclosure);

/* ------------------------------------------------------------------------
// openNewWindow
// This opens a new browser window when an appropriately-configured link is clicked
// It is applied to all A tags with a class of newwindow
------------------------------------------------------------------------ */
function openNewWindow() {
	jQuery("a.newwindow").live("click",function(event) {
		event.preventDefault();
		var href = jQuery(this).attr("href");
		if (href.indexOf("_manifestomedia") != -1) {
			window.open(jQuery(this).attr("href"),"Media Browser","height=600,width=670");
		} else {
			window.open(jQuery(this).attr("href"),jQuery(this).attr("title"));
		}
	});
}
jQuery(document).ready(openNewWindow);

/* ------------------------------------------------------------------------
// mailto
// This de-obfuscates mailto tags
------------------------------------------------------------------------ */
function fixMailto() {
	jQuery("a.mailto").live("click",function(event) {
		var reg=/-AT-/;
		this.href=this.href.replace(reg,'@');
	});
}
jQuery(document).ready(fixMailto);

/* ------------------------------------------------------------------------
// uploadNowButton
// This handles the interface for instant uploads of images
------------------------------------------------------------------------ */
function uploadNowButton() {
	jQuery("#uploadnow_link").click(function(e) {
		quickUpload(jQuery(this).closest("form"));
		e.preventDefault();
	}).hide();
	jQuery(".uploadnow").click(function() {
		jQuery("#uploadnow_link").show();
	});
}
// add the event to the onload handler
jQuery(document).ready(uploadNowButton);

/* ------------------------------------------------------------------------
// quickUpload
// pops up File Upload handler window
------------------------------------------------------------------------ */
// pops up File Upload handler window
function quickUpload(f) {
	window.open("","UploadWindow","top=80,left=80,width=670,height=400,toolbar=no,menubar=no,scrollbars=yes");
	var oldaction = f.attr("action");
	f.attr({action:js_g_url+"_manifestomedia_browser.php",target:"UploadWindow"}).get(0).submit();
	f.removeAttr("target").attr("action",oldaction);
	return false;
}

/* ------------------------------------------------------------------------
// autoSubmit
// Allows forms to be auto-submitted when a popup menu changes
// Applies to any SELECT element whose form has the class "autosubmit"
------------------------------------------------------------------------ */
function autoSubmit() {
	jQuery("form.autosubmit input[type=submit]").hide();
	jQuery("form.autosubmit select").change(function() {
		this.form.submit();
	});
}
jQuery(document).ready(autoSubmit);

/* ------------------------------------------------------------------------
// markallCheckboxes
// Toggles the checked status of a group of checkboxes
// It can take a single parameter: the container within which to affect checkboxes
// And an optional second parameter specifies a required class for checkboxes
------------------------------------------------------------------------ */
function markallCheckboxes() {
	jQuery(".checkbox-markall").click(function() {
		var valclass = jQuery(this).val();
		jQuery(this).parents("form").find("input:checkbox."+valclass).each(function(i) { jQuery(this).attr("checked",!jQuery(this).attr("checked")) } );
		
	});
}
jQuery(document).ready(markallCheckboxes);

/* ------------------------------------------------------------------------
// dropDownMenu implements standard drop-down menus for toprow navigation
// It is applied to all #toprow LI tags with class of "has_submenu"
------------------------------------------------------------------------ */
function dropDownMenu() {
	jQuery("#toprow li.has_submenu").hover(function(e) {
		jQuery(this).children("ul").stop(true,true).slideDown("normal");
		e.stopPropagation();
	},
	function(e) {
		jQuery(this).children("ul").stop(true,true).slideUp("fast");
		e.stopPropagation();
	});
}
jQuery(document).ready(dropDownMenu);

/* ------------------------------------------------------------------------
// makeEditable/unEditable
// This jQuery extension allows an element to be converted to an
// editable text input or textarea within a pseudo-form. Clicking the 
// submit button sends information to a callback function that can be used
// to execute an AJAX request to update a database.
// 
// Requirements:
// The element to be converted SHOULD contain an HTML ID attribute, and
// that ID is expected to end with "_nnn" where "nnn" is an identifier
// used to identify a unique database record (i.e. a Manifesto objectid)
// 
// When the form is submitted, the callback function is called with two
// parameters:
// 1) The input or text area element being edited
// 2) The unique ID
// 
// It is assumed that your callback function will e.g. execute an AJAX
// POST to "UPDATE some_table SET some_field = "+element.val()+" WHERE
// objectid = "+unique_id"
// 
// The unEditable function simply reverts the field back to its original
// state.
------------------------------------------------------------------------ */
jQuery.fn.extend({
	makeEditable: function(type,callbackFunction) {
		var params = false;
		if (arguments.length > 2) params = arguments[2];
		var baseid = jQuery(this).attr("id");
		var iid = this.attr("id").split("_").pop();
		//alert("Item ID is "+iid+" and has been made editable");
		var eform = jQuery("<form></form>");
		switch(type) {
			case 'input':
				eform.attr({id:"eform_"+iid,method:"post",action:""}).css("display","inline-block");
				var input = jQuery("<input />");
				input.attr({id:"input_"+baseid,type:"text",name:"input_"+baseid,size:40,value:this.html().trim()});
				if (params) input.attr(params);
				input.parent().blur(function() {
					jQuery(this).unEditable();
				});
				break;
			case 'textarea':
				eform.attr({id:"eform_"+iid,method:"post",action:""});
				var input = jQuery("<textarea />");
				input.attr({id:"input_"+baseid,name:"input_"+baseid,cols:40,rows:12,value:this.html().trim()});
				if (params) input.attr(params);
				input.parent().blur(function() {
					jQuery(this).parent().unEditable();
				});
				break;
		}
		var ebutton = jQuery("<input />");
		ebutton.attr({id:"ebutton_"+iid,type:"submit",name:"submitted",value:"Save"});
		ebutton.click(function() {
			callbackFunction("input_"+baseid,iid);
			event.preventDefault();
		});
		var cancelbutton = jQuery("<input />");
		cancelbutton.attr({id:"cancelbutton_"+iid,type:"submit",name:"cancel",value:"Cancel"});
		cancelbutton.click(function() {
			jQuery("#input_"+baseid).unEditable();
			event.preventDefault();
		});
		eform.append(input);
		eform.append(ebutton);
		eform.append(cancelbutton);
		jQuery(this).hide().before(eform);
		input.focus().select();
		return this;
	},
	unEditable: function() {
		var iid = this.attr("id").split("_").pop();
		var baseid = this.attr("id").replace("input_","");
		var newtext = this.val();
		if (newtext == "") {
			newtext = "[click to edit]";
		}
		jQuery("#eform_"+iid).remove();
		jQuery("#"+baseid).html(newtext).fadeIn("fast");
	}
});

/* ------------------------------------------------------------------------
// Replacement for showSheet
------------------------------------------------------------------------ */
function jSheet(output,type) {
	if (arguments.length == 3) {
		time = arguments[2];
	} else {
		time = 2000;
	}
	if (jQuery("#sheet").length) {
		var sheet = jQuery("#sheet");
	} else {
		var sheet = jQuery("<div></div>").attr("id","sheet");
		switch(type) {
			case "form validation":
				sheet.addClass("sheet-validation");
				break;
			case "error":
				sheet.addClass("sheet-error");
				break;
			case "ajax":
				sheet.addClass("sheet-ajax");
				break;
			case "info":
				sheet.addClass("sheet-info");
				break;
			case "help":
				sheet.addClass("sheet-help");
				break;
		}
	}
	if (typeof output == "object") { // for arrays
		var txt = "";
		for(var i=0;i<output.length;i++) {
			txt += output[i] + "<br />";
		}
		sheet.html(txt);
	} else {
		sheet.html(output);
	}
	jQuery("#rootcontainer").append(sheet);
	sheet.slideDown("fast",function() {setTimeout("jSheetHide()",time)} );
	return false;
}
function jSheetHide() {
	jQuery("#sheet").fadeOut(1000,function(){jQuery(this).remove()});
}
function jLog(str) {
	jQuery.post(js_g_url+"rpc.php","f=log&message="+encodeURIComponent(str));
}
function blackout() {
	var z = jQuery('<div id="blackout"></div>').css({
		"background":"transparent url(/images/whiteout.png) top left repeat",
		"position":"fixed",
		"top":0,
		"left":0,
		"height":"100%",
		"width":"100%",
		"zIndex":200,
		"textAlign":"center",
		"verticalAlign":"middle"
		});
	jQuery("body").append(z);
}
function unblackout() {
	jQuery("#blackout").remove();
}

/* ------------------------------------------------------------------------
// Utility script to arrayify old dada-style AJAX responses
------------------------------------------------------------------------ */
function dtArrayify(str) {
	var linedelim = "|";
	var fielddelim = ";";
	if (str.indexOf(linedelim) != -1) {
		var r = new Array();
		var linearr = str.split(linedelim);
		for(i=0;i<linearr.length;i++) {
			if (linearr[i] != "") {
				var fieldarr = linearr[i].split(fielddelim);
				r[r.length] = fieldarr;
			}
		}
		return r;
	}
	return false;
}
