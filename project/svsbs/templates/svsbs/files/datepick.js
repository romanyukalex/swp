function formatNum2(i, valtype) {
	f = (i < 10 ? '0' : '') + i;
	if (valtype && valtype != '') {
		switch(valtype) {
			case 'month':
				f = (f > 12 ? 12 : f); break;
			case 'day':
				f = (f > 31 ? 31 : f); break;
		}
	}
	return f;
}
function dtDatePicker() {
	this.month_names = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	this.day_names = new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	this.prefix = "";
	this.picker = false;
	this.caldiv = false; // this will be a jQuery object
	this.miniyear = false;
	this.minimonth = false;
	this.miniday = false;
	this.yearmenu = false;
	this.monthmenu = false;
	this.daymenu = false;
	this.firstyear = false;
	this.lastyear = false;
}
dtDatePicker.prototype.init = function() {
	// initialize
	if (this.caldiv == false) {
		this.yearmenu = "#"+this.prefix + "__year";
		this.monthmenu = "#"+this.prefix + "__month";
		this.daymenu = "#"+this.prefix + "__day";
		this.miniyear = parseInt(jQuery(this.yearmenu+" option:selected").val());
		this.firstyear = jQuery(this.yearmenu+" option").eq(1).val();
		this.lastyear = jQuery(this.yearmenu+" option:last").val();
		this.minimonth = jQuery(this.monthmenu+" option:selected").val() - 1;
		this.miniday = jQuery(this.daymenu+" option:selected").val();
		if (isNaN(this.miniyear) || isNaN(this.minimonth) || isNaN(this.miniday) || this.miniday == 0) {
			dt = new Date();
			this.miniyear = dt.getFullYear();
			this.minimonth = dt.getMonth();
			this.miniday = dt.getDate();
		}
		this.caldiv = jQuery("<div></div>").attr("id","caldiv").click(function(e) {
			jQuery(this).remove();
			dp.caldiv = false;
			e.stopPropagation();
		});
		jQuery("#"+this.prefix+"__picker").append(this.caldiv);
		this.drawCalendar();
	}
}
dtDatePicker.prototype.drawCalendar = function() {
	// Month navigation
	if (this.minimonth > 11) {
		this.minimonth = 0;
		this.miniyear++;
	} else if (this.minimonth < 0) {
		this.minimonth = 11;
		this.miniyear--;
	}
	// restrict the year if necessary
	if (this.miniyear < this.firstyear) this.miniyear = this.firstyear;
	if (this.miniyear > this.lastyear) this.miniyear = this.lastyear;

	this.caldiv.html("");
	
	var e_form = jQuery("<form></form>").attr({"id":"calnav","action":"#","method":"get"});
	var e_form_div = jQuery("<div></div>");
	e_form_div.append(jQuery("<a></a>").attr("id","monthprev").html("&laquo;").disableSelection().click(function(e) {
		dp.minimonth--;dp.drawCalendar();e.stopPropagation();
	}));
	var e_form_month = jQuery("<select></select>").attr("id","select_month").change(function(e) {
		dp.minimonth = jQuery("#"+jQuery(this).attr("id")+" option:selected").val();dp.drawCalendar();e.stopPropagation();
	});
	for (i=0;i<12;i++) {
		if (i == this.minimonth) {
			e_form_month.append(jQuery("<option></option>").val(i).attr("selected","selected").html(this.month_names[i]));
		} else {
			e_form_month.append(jQuery("<option></option>").val(i).html(this.month_names[i]));
		}
	}
	e_form_div.append(e_form_month);
	e_form_div.append(jQuery("<a></a>").attr("id","monthnext").html("&raquo;").disableSelection().click(function(e) {
		dp.minimonth++;dp.drawCalendar();e.stopPropagation();
	}));
	e_form_div.append(jQuery("<a></a>").attr("id","yearprev").html("&laquo;").disableSelection().click(function(e) {
		dp.miniyear--;dp.drawCalendar();e.stopPropagation();
	}));
	var e_form_year = jQuery("<select></select>").attr("id","select_year").change(function(e) {
		dp.miniyear = jQuery("#"+jQuery(this).attr("id")+" option:selected").val();dp.drawCalendar();e.stopPropagation();
	});
	for (i=this.firstyear;i<=this.lastyear;i++) {
		if (i == this.miniyear) {
			e_form_year.append(jQuery("<option></option>").val(i).attr("selected","selected").html(i));
		} else {
			e_form_year.append(jQuery("<option></option>").val(i).html(i));
		}
	}
	e_form_div.append(e_form_year);
	e_form_div.append(jQuery("<a></a>").attr("id","yearnext").html("&raquo;").disableSelection().click(function(e) {
		dp.miniyear++;dp.drawCalendar();e.stopPropagation();
	}));
	e_form.append(e_form_div);

	this.caldiv.append(e_form);

	var e_cal = jQuery("<table></table>").attr("id","minical");
	var headerrow = jQuery("<tr></tr>");
	for (i=0;i<7;i++) {
		headerrow.append(jQuery("<th></th>").html(this.day_names[i]));
	}
	e_cal.append(headerrow);
	var firstDay = new Date(this.miniyear, this.minimonth, 1).getDay();
	var lastDay = new Date(this.miniyear, this.minimonth + 1, 0).getDate();
	var dayInWeek = 0;
	var row = jQuery("<tr></tr>");
	for (i=0;i<firstDay;i++) {
		row.append(jQuery("<td></td>").html("&nbsp;"));
		dayInWeek++;
	}
	for (i=1;i<=lastDay;i++) {
		if (dayInWeek == 7) {
			e_cal.append(row);
			row = jQuery("<tr></tr>");
			dayInWeek = 0;
		}
		dispmonth = 1 + this.minimonth;
		var theclass = "daycell";
		if (i == this.miniday) {
			theclass += " today";
		}
		row.append(jQuery("<td></td>").attr("id","date_"+this.miniyear+"-"+formatNum2(dispmonth,'month')+"-"+formatNum2(i,'day')).addClass(theclass).html(i).click(function(e) {
			var datearr = jQuery(this).attr("id").replace("date_","").split("-");
			dp.returnDate(datearr[0],datearr[1],datearr[2]);
			e.stopPropagation();
		}));
		dayInWeek++;
	}
	for (i = dayInWeek; i < 7; i++) {
		row.append(jQuery("<td></td>").html("&nbsp;"));
	}
	e_cal.append(row);

	this.caldiv.append(e_form);
	this.caldiv.append(e_cal);
	return false;
}
dtDatePicker.prototype.returnDate = function(y,m,d) {
	// set the popup menus
	jQuery(this.yearmenu).val(y);
	jQuery(this.monthmenu).val(m);
	jQuery(this.daymenu).val(d);
	this.caldiv.remove();
	this.caldiv = false;
}
jQuery(document).ready(function() {
	dp = new dtDatePicker();
	jQuery(".date_selector").each(function(i) {
		var prefix = jQuery(this).attr("id").replace("_container","");
		dp.picker = jQuery("<div></div>").attr("id",prefix+"__picker").addClass("date_picker").html("<a>[popup]</a>").click(function(e) {
			dp.prefix = prefix;
			dp.init();
		});
		jQuery(this).append(dp.picker);
	});
});