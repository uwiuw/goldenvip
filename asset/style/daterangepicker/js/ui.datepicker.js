/* jQuery Calendar v2.7
   Written by Marc Grabanski (m@marcgrabanski.com) and enhanced by Keith Wood (kbwood@iprimus.com.au).

   Date Range Picker mods provided by Filament Group, Inc
   ** NOTE! The portions of this script that are modified by Filament Group are not written for flexible reuse but rather for a specific implementation. 
   * We welcome any modification to package this in a more reusable plugin style.

   Copyright (c) 2007 Marc Grabanski (http://marcgrabanski.com/code/jquery-calendar)
   Dual licensed under the GPL (http://www.gnu.org/licenses/gpl-3.0.txt) and 
   CC (http://creativecommons.org/licenses/by/3.0/) licenses. "Share or Remix it but please Attribute the authors."
   Date: 09-03-2007  */

/* PopUp Calendar manager.
   Use the singleton instance of this class, popUpCal, to interact with the calendar.
   Settings for (groups of) calendars are maintained in an instance object
   (PopUpCalInstance), allowing multiple different settings on the same page. */
function PopUpCal() {
	this._nextId = 0; // Next ID for a calendar instance
	this._inst = []; // List of instances indexed by ID
	this._curInst = null; // The current instance in use
	this._disabledInputs = []; // List of calendar inputs that have been disabled
	this._popUpShowing = false; // True if the popup calendar is showing , false if not
	this._inDialog = false; // True if showing within a "dialog", false if not
	this.regional = []; // Available regional settings, indexed by language code
	this.regional[''] = { // Default regional settings
		clearText: 'Clear', // Display text for clear link
		closeText: 'Close', // Display text for close link
		prevText: '&lt;Prev', // Display text for previous month link
		nextText: 'Next&gt;', // Display text for next month link
		currentText: 'Today', // Display text for current month link
		dayNames: ['Su','Mo','Tu','We','Th','Fr','Sa'], // Names of days starting at Sunday
		monthNames: ['January','February','March','April','May','June',
			'July','August','September','October','November','December'], // Names of months
		dateFormat: 'MDY/' // First three are day, month, year in the required order,
			// fourth (optional) is the separator, e.g. US would be 'MDY/', ISO would be 'YMD-'
	};
	this._defaults = { // Global defaults for all the calendar instances
		autoPopUp: 'focus', // 'focus' for popup on focus,
			// 'button' for trigger button, or 'both' for either
		defaultDate: null, // Used when field is blank: actual date,
			// +/-number for offset from today, null for today
		appendText: '', // Display text following the input box, e.g. showing the format
		buttonText: '...', // Text for trigger button
		buttonImage: '', // URL for trigger button image
		buttonImageOnly: false, // True if the image appears alone, false if it appears on a button
		closeAtTop: false, // True to have the clear/close at the top,
			// false to have them at the bottom
		hideIfNoPrevNext: false, // True to hide next/previous month links
			// if not applicable, false to just disable them
		changeMonth: true, // True if month can be selected directly, false if only prev/next
		changeYear: true, // True if year can be selected directly, false if only prev/next
		monthYearMenu: true, //True if a mixed month/year menu is desired
		yearRange: '-10:+10', // Range of years to display in drop-down,
			// either relative to current year (-nn:+nn) or absolute (nnnn:nnnn)
		firstDay: 0, // The first day of the week, Sun = 0, Mon = 1, ...
		//changeFirstDay: true, // True to click on day name to change, false to remain as set
		showOtherMonths: true, // True to show dates in other months, false to leave blank
		minDate: null, // The earliest selectable date, or null for no limit
		maxDate: null, // The latest selectable date, or null for no limit
		speed: 'fast', // Speed of display/closure
		customDate: null, // Function that takes a date and returns an array with
			// [0] = true if selectable, false if not,
			// [1] = custom CSS class name(s) or '', e.g. popUpCal.noWeekends
		fieldSettings: null, // Function that takes an input field and
			// returns a set of custom settings for the calendar
		onSelect: null, // Define a callback function when a date is selected
		dateRange: false
	};
	$.extend(this._defaults, this.regional['']);
	$(document).click(this._checkExternalClick);
}

$.extend(PopUpCal.prototype, {
	/* Class name added to elements to indicate already configured with a calendar. */
	markerClassName: 'hasCalendar',
	
	/* Register a new calendar instance - with custom settings. */
	_register: function(inst) {
		var id = this._nextId++;
		this._inst[id] = inst;
		this._calendarDiv = $('<div id="calendar_div_'+id+'" class="calendar_div"></div>');
		return id;
	},

	/* Retrieve a particular calendar instance based on its ID. */
	_getInst: function(id) {
		return this._inst[id] || id;
	},

	/* Override the default settings for all instances of the calendar. 
	   @param  settings  object - the new settings to use as defaults (anonymous object)
	   @return void */
	setDefaults: function(settings) {
		extendRemove(this._defaults, settings || {});
	},

	/* Handle keystrokes. */
	_doKeyDown: function(e) {
		var inst = popUpCal._getInst(this._calId);
		if (popUpCal._popUpShowing) {
			switch (e.keyCode) {
				case 9:  popUpCal.hideCalendar(inst, '');
						break; // hide on tab out
				case 13: popUpCal._selectDate(inst);
						break; // select the value on enter
				case 27: popUpCal.hideCalendar(inst, inst._get('speed'));
						break; // hide on escape
				case 33: popUpCal._adjustDate(inst, -1, (e.ctrlKey ? 'Y' : 'M'));
						break; // previous month/year on page up/+ ctrl
				case 34: popUpCal._adjustDate(inst, +1, (e.ctrlKey ? 'Y' : 'M'));
						break; // next month/year on page down/+ ctrl
				case 35: if (e.ctrlKey) popUpCal._clearDate(inst);
						break; // clear on ctrl+end
				case 36: if (e.ctrlKey) popUpCal._gotoToday(inst);
						break; // current on ctrl+home
				case 37: if (e.ctrlKey) popUpCal._adjustDate(inst, -1, 'D');
						break; // -1 day on ctrl+left
				case 38: if (e.ctrlKey) popUpCal._adjustDate(inst, -7, 'D');
						break; // -1 week on ctrl+up
				case 39: if (e.ctrlKey) popUpCal._adjustDate(inst, +1, 'D');
						break; // +1 day on ctrl+right
				case 40: if (e.ctrlKey) popUpCal._adjustDate(inst, +7, 'D');
						break; // +1 week on ctrl+down
			}
		}
		else if (e.keyCode == 36 && e.ctrlKey) { // display the calendar on ctrl+home
			popUpCal.showFor(this);
		}
	},

	/* Filter entered characters. */
	_doKeyPress: function(e) {
		var inst = popUpCal._getInst(this._calId);
		var chr = String.fromCharCode(e.charCode == undefined ? e.keyCode : e.charCode);
		return (chr < ' ' || chr == inst._get('dateFormat').charAt(3) ||
			(chr >= '0' && chr <= '9')); // only allow numbers and separator
	},

	/* Attach the calendar to an input field. */
	_connectCalendar: function(target, inst) {
		var input = $(target);
		input.addClass('calendarInput');
		if (this._hasClass(input, this.markerClassName)) {
			return;
		}
		var appendText = inst._get('appendText');
		if (appendText) {
			input.after('<span class="calendar_append">' + appendText + '</span>');
		}
		

		
		input.after(inst._calendarDiv);
		
		var autoPopUp = inst._get('autoPopUp');
		if (autoPopUp == 'focus' || autoPopUp == 'both') { // pop-up calendar when in the marked field
			input.focus(this.showFor);
		}
		if (autoPopUp == 'button' || autoPopUp == 'both') { // pop-up calendar when button clicked
			var buttonText = inst._get('buttonText');
			var buttonImage = inst._get('buttonImage');
			var buttonImageOnly = inst._get('buttonImageOnly');
			var trigger = $(buttonImageOnly ? '<img class="calendar_trigger" src="' +
				buttonImage + '" alt="' + buttonText + '" title="' + buttonText + '"/>' :
				'<button type="button" class="calendar_trigger">' + (buttonImage != '' ?
				'<img src="' + buttonImage + '" alt="' + buttonText + '" title="' + buttonText + '"/>' :
				buttonText) + '</button>');
			input.wrap('<span class="calendar_wrap"></span>').after(trigger);
			trigger.click(this.showFor);
		}
		input.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress);
		input[0]._calId = inst._id;
	},

	/* Attach an inline calendar to a div. */
	_inlineCalendar: function(target, inst) {
		var input = $(target);
		if (this._hasClass(input, this.markerClassName)) {
			return;
		}
		input.addClass(this.markerClassName).append(inst._calendarDiv);
		input[0]._calId = inst._id;
	},

	/* Does this element have a particular class? */
	_hasClass: function(element, className) {
		var classes = element.attr('class');
		return (classes && classes.indexOf(className) > -1);
	},

	/* Pop-up the calendar in a "dialog" box.
	   @param  dateText  string - the initial date to display (in the current format)
	   @param  onSelect  function - the function(dateText) to call when a date is selected
	   @param  settings  object - update the dialog calendar instance's settings (anonymous object)
	   @param  pos       int[2] - coordinates for the dialog's position within the screen
			leave empty for default (screen centre)
	   @return void */
	dialogCalendar: function(dateText, onSelect, settings, pos) {
		var inst = this._dialogInst; // internal instance
		if (!inst) {
			inst = this._dialogInst = new PopUpCalInstance({}, false);
			this._dialogInput = $('<input type="text" size="1" style="position: absolute; top: -100px;"/>');
			this._dialogInput.keydown(this._doKeyDown);
			$('body').append(this._dialogInput);
			this._dialogInput[0]._calId = inst._id;
		}
		extendRemove(inst._settings, settings || {});
		this._dialogInput.val(dateText);
		
		/*	Cross Browser Positioning */
		if (self.innerHeight) { // all except Explorer
			windowWidth = self.innerWidth;
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		} 
		this._pos = pos || // should use actual width/height below
			[(windowWidth / 2) - 100, (windowHeight / 2) - 100];

		// move input on screen for focus, but hidden behind dialog
		this._dialogInput.css('left', this._pos[0] + 'px').css('top', this._pos[1] + 'px');
		inst._settings.onSelect = onSelect;
		this._inDialog = true;
		this._calendarDiv.addClass('calendar_dialog');
		this.showFor(this._dialogInput[0]);
		if ($.blockUI) {
			$.blockUI(this._calendarDiv);
		}
	},

	/* Enable the input field(s) for entry.
	   @param  inputs  element/object - single input field or jQuery collection of input fields
	   @return void */
	enableFor: function(inputs) {
		inputs = (inputs.jquery ? inputs : $(inputs));
		inputs.each(function() {
			this.disabled = false;
			$('../button.calendar_trigger', this).each(function() { this.disabled = false; });
			$('../img.calendar_trigger', this).css({opacity:'1.0',cursor:''});
			var $this = this;
			popUpCal._disabledInputs = $.map(popUpCal._disabledInputs,
				function(value) { return (value == $this ? null : value); }); // delete entry
		});
	},

	/* Disable the input field(s) from entry.
	   @param  inputs  element/object - single input field or jQuery collection of input fields
	   @return void */
	disableFor: function(inputs) {
		inputs = (inputs.jquery ? inputs : $(inputs));
		inputs.each(function() {
			this.disabled = true;
			$('../button.calendar_trigger', this).each(function() { this.disabled = true; });
			$('../img.calendar_trigger', this).css({opacity:'0.5',cursor:'default'});
			var $this = this;
			popUpCal._disabledInputs = $.map(popUpCal._disabledInputs,
				function(value) { return (value == $this ? null : value); }); // delete entry
			popUpCal._disabledInputs[popUpCal._disabledInputs.length] = this;
		});
	},

	/* Update the settings for a calendar attached to an input field or division.
	   @param  control   element - the input field or div/span attached to the calendar or
	                     string - the ID or other jQuery selector of the input field
	   @param  settings  object - the new settings to update
	   @return void */
	reconfigureFor: function(control, settings) {
		control = (typeof control == 'string' ? $(control)[0] : control);
		var inst = this._getInst(control._calId);
		if (inst) {
			extendRemove(inst._settings, settings || {});
			this._updateCalendar(inst);
		}
	},

	/* Set the date for a calendar attached to an input field or division.
	   @param  control  element - the input field or div/span attached to the calendar
	   @param  date     Date - the new date
	   @return void */
	setDateFor: function(control, date) {
		var inst = this._getInst(control._calId);
		if (inst) {
			inst._setDate(date);
		}
	},

	/* Retrieve the date for a calendar attached to an input field or division.
	   @param  control  element - the input field or div/span attached to the calendar
	   @return Date - the current date */
	getDateFor: function(control) {
		var inst = this._getInst(control._calId);
		return (inst ? inst._getDate() : null);
	},

	/* Pop-up the calendar for a given input field.
	   @param  target  element - the input field attached to the calendar
	   @return void */
	showFor: function(target) {
		var input = (target.nodeName && target.nodeName.toLowerCase() == 'input' ? target : this);
		if (input.nodeName.toLowerCase() != 'input') { // find from button/image trigger
			input = $('input', input.parentNode)[0];
		}
		if (popUpCal._lastInput == input) { // already here
			return;
		}
		for (var i = 0; i < popUpCal._disabledInputs.length; i++) {  // check not disabled
			if (popUpCal._disabledInputs[i] == input) {
				return;
			}
		}
		var inst = popUpCal._getInst(input._calId);
		var fieldSettings = inst._get('fieldSettings');
		extendRemove(inst._settings, (fieldSettings ? fieldSettings(input) : {}));
		popUpCal.hideCalendar(inst, '');
		popUpCal._lastInput = input;
		inst._setDateFromField(input);
		if (popUpCal._inDialog) { // hide cursor
			input.value = '';
		}
		/*
		if (!popUpCal._pos) { // position below input
			popUpCal._pos = popUpCal._findPos(input);
			popUpCal._pos[1] += input.offsetHeight;
		}
		inst._calendarDiv.css('position', (popUpCal._inDialog && $.blockUI ? 'static' : 'absolute')).
			css('left', popUpCal._pos[0] + 'px').css('top', popUpCal._pos[1] + 'px');
			*/
		popUpCal._pos = null;
		popUpCal._showCalendar(inst);
	},

	/* Construct and display the calendar. */
	_showCalendar: function(id) {
		var inst = this._getInst(id);
		popUpCal._updateCalendar(inst);
		if (!inst._inline) {
			var speed = inst._get('speed');
			inst._calendarDiv.show(speed, function() {
				popUpCal._popUpShowing = true;
				popUpCal._afterShow(inst);
			});
			if (speed == '') {
				popUpCal._popUpShowing = true;
				popUpCal._afterShow(inst);
			}
			if (inst._input[0].type != 'hidden') {
				inst._input[0].focus();
			}
			this._curInst = inst;
		}
	},

	/* Generate the calendar content. */
	_updateCalendar: function(inst, visibility) {
		inst._calendarDiv.html(inst._generateCalendar());
		if (inst._input && inst._input[0].type != 'hidden' && visibility != 'hidden') {
			inst._input[0].focus();
		}
	},

	/* Tidy up after displaying the calendar. */
	_afterShow: function(inst) {
		if ($.browser.msie) { // fix IE < 7 select problems
			$('#calendar_cover').css({width: inst._calendarDiv[0].offsetWidth + 4,
				height: inst._calendarDiv[0].offsetHeight + 4});
		}
		// re-position on screen if necessary
		var calDiv = inst._calendarDiv[0];
		var pos = popUpCal._findPos(inst._input[0]);
		// Get browser width and X value (IE6+, FF, Safari, Opera)
		if( typeof( window.innerWidth ) == 'number' ) {
			browserWidth = window.innerWidth;
		} else {
			browserWidth = document.documentElement.clientWidth;
		}
		if ( document.documentElement && (document.documentElement.scrollLeft)) {
			browserX = document.documentElement.scrollLeft;	
		} else {
			browserX = document.body.scrollLeft;
		}
		// Reposition calendar if outside the browser window.
		if ((calDiv.offsetLeft + calDiv.offsetWidth) >
				(browserWidth + browserX) ) {
			inst._calendarDiv.css('left', (pos[0] + inst._input[0].offsetWidth - calDiv.offsetWidth) + 'px');
		}
		// Get browser height and Y value (IE6+, FF, Safari, Opera)
		if( typeof( window.innerHeight ) == 'number' ) {
			browserHeight = window.innerHeight;
		} else {
			browserHeight = document.documentElement.clientHeight;
		}
		if ( document.documentElement && (document.documentElement.scrollTop)) {
			browserTopY = document.documentElement.scrollTop;
		} else {
			browserTopY = document.body.scrollTop;
		}
		// Reposition calendar if outside the browser window.
		if ((calDiv.offsetTop + calDiv.offsetHeight) >
				(browserTopY + browserHeight) ) {
			inst._calendarDiv.css('top', (pos[1] - calDiv.offsetHeight) + 'px');
		}
	},

	/* Hide the calendar from view.
	   @param  id     string/object - the ID of the current calendar instance,
			or the instance itself
	   @param  speed  string - the speed at which to close the calendar
	   @return void */
	hideCalendar: function(id, speed) {
		var inst = this._getInst(id);
		var dateRange = inst._get('dateRange');
		if(dateRange == false){
			var inst = this._getInst(id);
			if (popUpCal._popUpShowing) {
				speed = (speed != null ? speed : inst._get('speed'));
				inst._calendarDiv.hide(speed, function() {
					popUpCal._tidyDialog(inst);
				});
				if (speed == '') {
					popUpCal._tidyDialog(inst);
				}
				popUpCal._popUpShowing = false;
				popUpCal._lastInput = null;
				inst._settings.prompt = null;
				if (popUpCal._inDialog) {
					popUpCal._dialogInput.css('position', 'absolute').
						css('left', '0px').css('top', '-100px');
					if ($.blockUI) {
						$.unblockUI();
						$('body').append(this._calendarDiv);
					}
				}
				popUpCal._inDialog = false;
			}
			popUpCal._curInst = null;
		}
	},

	/* Tidy up after a dialog display. */
	_tidyDialog: function(inst) {
		inst._calendarDiv.removeClass('calendar_dialog');
		$('.calendar_prompt', inst._calendarDiv).remove();
	},

	/* Close calendar if clicked elsewhere. */
	_checkExternalClick: function(event) {
		if (!popUpCal._curInst) {
			return;
		}
		var target = $(event.target);
		if( (target.parents(".calendar_div").length == 0)
			&& (target.attr('class') != 'calendar_trigger')
			&& popUpCal._popUpShowing 
			&& !(popUpCal._inDialog && $.blockUI) )
		{
			popUpCal.hideCalendar(popUpCal._curInst, '');
		}
	},

	/* Adjust one of the date sub-fields. */
	_adjustDate: function(id, offset, period) {
		var inst = this._getInst(id);
		inst._adjustDate(offset, period);
		this._updateCalendar(inst);
	},

	/* Action for current link. */
	_gotoToday: function(id) {
		var date = new Date();
		var inst = this._getInst(id);
		inst._selectedDay = date.getDate();
		inst._selectedMonth = date.getMonth();
		inst._selectedYear = date.getFullYear();
		this._adjustDate(inst);
	},

	/* Action for selecting a new month/year. */
	_selectMonthYear: function(id, select, period) {
		var inst = this._getInst(id);
		inst._selectingMonthYear = false;
		if(period == 'MY'){
			inst['_selectedMonth'] = 	select.id.split('_')[0] - 0;
			inst['_selectedYear'] = 	select.id.split('_')[1] - 0;
			
		}
		else inst[period == 'M' ? '_selectedMonth' : '_selectedYear'] = select.options[select.selectedIndex].value - 0;
		this._adjustDate(inst);
	},

	/* Restore input focus after not changing month/year. */
	_clickMonthYear: function(id) {
		var inst = this._getInst(id);
		if (inst._input && inst._selectingMonthYear && !$.browser.msie) {
			inst._input[0].focus();
		}
		inst._selectingMonthYear = !inst._selectingMonthYear;
	},

	/* Action for changing the first week day. */
	_changeFirstDay: function(id, a) {
		var inst = this._getInst(id);
		var dayNames = inst._get('dayNames');
		var value = a.firstChild.nodeValue;
		for (var i = 0; i < 7; i++) {
			if (dayNames[i] == value) {
				inst._settings.firstDay = i;
				break;
			}
		}
		this._updateCalendar(inst);
	},

	/* Action for selecting a day. */
	_selectDay: function(id, td) {
		var inst = this._getInst(id);
		inst._selectedDay = $("a", td).html();
		this._selectDate(id);
	},

	/* Erase the input field and hide the calendar. */
	_clearDate: function(id) {
		this._selectDate(id, '');
	},

	/* Update the input field with the selected date. */
	_selectDate: function(id, dateStr) {
		var inst = this._getInst(id);
		dateStr = (dateStr != null ? dateStr : inst._formatDate());
		if (inst._input) {
			inst._input.val(dateStr);
		}
		var onSelect = inst._get('onSelect');
		if (onSelect) {
			onSelect(dateStr, inst);  // trigger custom callback
		}
		else {
			inst._input.trigger('change'); // fire the change event
		}
		if (inst._inline) {
			this._updateCalendar(inst);
		}
		else {
			this.hideCalendar(inst, inst._get('speed'));
		}
	},

	/* Set as customDate function to prevent selection of weekends.
	   @param  date  Date - the date to customise
	   @return [boolean, string] - is this date selectable?, what is its CSS class? */
	noWeekends: function(date) {
		var day = date.getDay();
		return [(day > 0 && day < 6), ''];
	},

	/* Find an object's position on the screen. */
	_findPos: function(obj) {
		while (obj && (obj.type == 'hidden' || obj.nodeType != 1)) {
			obj = obj.nextSibling;
		}
		var curleft = curtop = 0;
		if (obj && obj.offsetParent) {
			curleft = obj.offsetLeft;
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {
				var origcurleft = curleft;
				curleft += obj.offsetLeft;
				if (curleft < 0) {
					curleft = origcurleft;
				}
				curtop += obj.offsetTop;
			}
		}
		return [curleft,curtop];
	}
});

/* Individualised settings for calendars applied to one or more related inputs.
   Instances are managed and manipulated through the PopUpCal manager. */
function PopUpCalInstance(settings, inline) {
	this._id = popUpCal._register(this);
	this._selectedDay = 0;
	this._selectedMonth = 0; // 0-11
	this._selectedYear = 0; // 4-digit year
	this._input = null; // The attached input field
	this._inline = inline; // True if showing inline, false if used in a popup
	this._calendarDiv = (!inline ? popUpCal._calendarDiv :
		$('<div id="calendar_div_' + this._id + '" class="calendar_inline"></div>'));
	// customise the calendar object - uses manager defaults if not overridden
	this._settings = extendRemove({}, settings || {}); // clone
	if (inline) {
		this._setDate(this._getDefaultDate());
	}
}

$.extend(PopUpCalInstance.prototype, {
	/* Get a setting value, defaulting if necessary. */
	_get: function(name) {
		return (this._settings[name] != null ? this._settings[name] : popUpCal._defaults[name]);
	},

	/* Parse existing date and initialise calendar. */
	_setDateFromField: function(input) {
		this._input = $(input);
		var dateFormat = this._get('dateFormat');
		var currentDate = this._input.val().split(dateFormat.charAt(3));
		if (currentDate.length == 3) {
			this._currentDay = parseInt(currentDate[dateFormat.indexOf('D')], 10);
			this._currentMonth = parseInt(currentDate[dateFormat.indexOf('M')], 10) - 1;
			this._currentYear = parseInt(currentDate[dateFormat.indexOf('Y')], 10);
		}
		else {
			var date = this._getDefaultDate();
			this._currentDay = date.getDate();
			this._currentMonth = date.getMonth();
			this._currentYear = date.getFullYear();
		}
		this._selectedDay = this._currentDay;
		this._selectedMonth = this._currentMonth;
		this._selectedYear = this._currentYear;
		this._adjustDate();
	},
	
	/* Retrieve the default date shown on opening. */
	_getDefaultDate: function() {
		var offsetDate = function(offset) {
			var date = new Date();
			date.setDate(date.getDate() + offset);
			return date;
		};
		var defaultDate = this._get('defaultDate');
		return (defaultDate == null ? new Date() :
			(typeof defaultDate == 'number' ? offsetDate(defaultDate) : defaultDate));
	},

	/* Set the date directly. */
	_setDate: function(date) {
		this._selectedDay = this._currentDay = date.getDate();
		this._selectedMonth = this._currentMonth = date.getMonth();
		this._selectedYear = this._currentYear = date.getFullYear();
		this._adjustDate();
	},

	/* Retrieve the date directly. */
	_getDate: function() {
		return new Date(this._currentYear, this._currentMonth, this._currentDay);
	},

	/* Generate the HTML for the current state of the calendar. */
	_generateCalendar: function() {
		var today = new Date();
		today = new Date(today.getFullYear(), today.getMonth(), today.getDate()); // clear time
		// build the calendar HTML
		var controls = '<div class="calendar_control">' +
			'<a class="calendar_clear" onclick="popUpCal._clearDate(' + this._id + ');">' +
			this._get('clearText') + '</a>' +
			'<a class="calendar_close" onclick="popUpCal.hideCalendar(' + this._id + ');">' +
			this._get('closeText') + '</a></div>';
		var prompt = this._get('prompt');
		var closeAtTop = this._get('closeAtTop');
		var hideIfNoPrevNext = this._get('hideIfNoPrevNext');
		// controls and links
		var html = (prompt ? '<div class="calendar_prompt">' + prompt + '</div>' : '') +
			(closeAtTop && !this._inline ? controls : '') + '<div class="calendar_header">' +
			(this._canAdjustMonth(-1) ? '<a class="calendar_prev" ' +
			'onclick="popUpCal._adjustDate(' + this._id + ', -1, \'M\');">' + this._get('prevText') + '</a>' :
			(hideIfNoPrevNext ? '' : '<label class="calendar_prev">' + this._get('prevText') + '</label>'));
			//(this._isInRange(today) ? '<a class="calendar_current" ' +
			//'onclick="popUpCal._gotoToday(' + this._id + ');">' + this._get('currentText') + '</a>' : '') +
			
		var minDate = this._get('minDate');
		var maxDate = this._get('maxDate');
		// month selection
		var monthNames = this._get('monthNames');
		//if 2 menus
		if(!this._get('monthYearMenu')){
			if (!this._get('changeMonth')) {
				html += monthNames[this._selectedMonth] + '&nbsp;';
			}
			else {
				var inMinYear = (minDate && minDate.getFullYear() == this._selectedYear);
				var inMaxYear = (maxDate && maxDate.getFullYear() == this._selectedYear);
				html += '<select class="calendar_newMonth" ' +
					'onchange="popUpCal._selectMonthYear(' + this._id + ', this, \'M\');" ' +
					'onclick="popUpCal._clickMonthYear(' + this._id + ');">';
				for (var month = 0; month < 12; month++) {
					if ((!inMinYear || month >= minDate.getMonth()) &&
							(!inMaxYear || month <= maxDate.getMonth())) {
						html += '<option value="' + month + '"' +
							(month == this._selectedMonth ? ' selected="selected"' : '') +
							'>' + monthNames[month] + '</option>';
					}
				}
				html += '</select>';
			}
			// year selection
			if (!this._get('changeYear')) {
				html += this._selectedYear;
			}
			else {
				// determine range of years to display
				var years = this._get('yearRange').split(':');
				var year = 0;
				var endYear = 0;
				if (years.length != 2) {
					year = this._selectedYear - 10;
					endYear = this._selectedYear + 10;
				}
				else if (years[0].charAt(0) == '+' || years[0].charAt(0) == '-') {
					year = this._selectedYear + parseInt(years[0], 10);
					endYear = this._selectedYear + parseInt(years[1], 10);
				}
				else {
					year = parseInt(years[0], 10);
					endYear = parseInt(years[1], 10);
				}
				year = (minDate ? Math.max(year, minDate.getFullYear()) : year);
				endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear);
				html += '<select class="calendar_newYear" onchange="popUpCal._selectMonthYear(' +
					this._id + ', this, \'Y\');" ' + 'onclick="popUpCal._clickMonthYear(' +
					this._id + ');">';
				for (; year <= endYear; year++) {
					html += '<option value="' + year + '"' +
						(year == this._selectedYear ? ' selected="selected"' : '') +
						'>' + year + '</option>';
				}
				html += '</select>';
			}

		}
		//1 menu
		else {
			// determine range of years to display
				var years = this._get('yearRange').split(':');
				var year = 0;
				var endYear = 0;
				if (years.length != 2) {
					year = this._selectedYear - 10;
					endYear = this._selectedYear + 10;
				}
				else if (years[0].charAt(0) == '+' || years[0].charAt(0) == '-') {
					year = this._selectedYear + parseInt(years[0], 10);
					endYear = this._selectedYear + parseInt(years[1], 10);
				}
				else {
					year = parseInt(years[0], 10);
					endYear = parseInt(years[1], 10);
				}
				year = (minDate ? Math.max(year, minDate.getFullYear()) : year);
				endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear);
				html += '<div class="monthYearContain" ><h2 onclick="$(this).parent().toggleClass(\'display\'); '+
				'$(this).parent().find(\'li\').each(function(i){'+
				'if($(this).is(\'#'+ this._selectedMonth+'_'+this._selectedYear +'\')) {'+
				'var scrollY = (i-4)*$(this).height(); this.parentNode.scrollTop = scrollY'+
				'} }); ">'+
				'<span>'+ monthNames[this._selectedMonth] +' '+ this._selectedYear +'</span></h2><div class="menu_contain"><div class="menu_pad"><ul class="calendar_monthYear" onclick="$(this).parent().parent().parent().removeClass(\'display\'); ">';

				for (; year <= endYear; year++) {
					var inMinYear = (minDate && minDate.getFullYear() == this._selectedYear);
					var inMaxYear = (maxDate && maxDate.getFullYear() == this._selectedYear);


					for (var month = 0; month < 12; month++) {
						if ((!inMinYear || month >= minDate.getMonth()) &&
								(!inMaxYear || month <= maxDate.getMonth())) {
							html += '<li id="' + month + '_'+ year + '"' +
								(month == this._selectedMonth && year == this._selectedYear ? ' class="selected"' : '') +
								'onclick="if($(this).parent().parent().parent().parent().is(\'.display\')) {popUpCal._selectMonthYear(' + this._id + ', this, \'MY\'); popUpCal._clickMonthYear(' + this._id + ');} $(document).click(function(){$(\'calendar_monthYear\').removeClass(\'display\');}); return false;">' + monthNames[month] + ' ' + year + '</li>';
						}
					}
				}


				
				html += '</ul></div></div></div>';
		}
		html += (this._canAdjustMonth(+1) ? '<a class="calendar_next" ' +
			'onclick="popUpCal._adjustDate(' + this._id + ', +1, \'M\');">' + this._get('nextText') + '</a>' :
			(hideIfNoPrevNext ? '' : '<label class="calendar_next">' + this._get('nextText') + '</label>'));
		



		
		html += '</div><table class="calendar" cellpadding="0" cellspacing="0"><thead>' +
			'<tr class="calendar_titleRow">';
		var firstDay = this._get('firstDay');
		var changeFirstDay = this._get('changeFirstDay');
		var dayNames = this._get('dayNames');
		for (var dow = 0; dow < 7; dow++) { // days of the week
			html += '<td>' + (!changeFirstDay ? '' : '<a onclick="popUpCal._changeFirstDay(' +
				this._id + ', this);">') + dayNames[(dow + firstDay) % 7] +
				(changeFirstDay ? '</a>' : '') + '</td>';
		}
		html += '</tr></thead><tbody>';
		var daysInMonth = this._getDaysInMonth(this._selectedYear, this._selectedMonth);
		this._selectedDay = Math.min(this._selectedDay, daysInMonth);
		var leadDays = (this._getFirstDayOfMonth(this._selectedYear, this._selectedMonth) - firstDay + 7) % 7;
		var currentDate = new Date(this._currentYear, this._currentMonth, this._currentDay);
		var selectedDate = new Date(this._selectedYear, this._selectedMonth, this._selectedDay);
		var printDate = new Date(this._selectedYear, this._selectedMonth, 1 - leadDays);
		var numRows = Math.ceil((leadDays + daysInMonth) / 7); // calculate the number of rows to generate
		var customDate = this._get('customDate');
		var showOtherMonths = this._get('showOtherMonths');
		for (var row = 0; row < numRows; row++) { // create calendar rows
			html += '<tr class="calendar_daysRow">';
			for (var dow = 0; dow < 7; dow++) { // create calendar days
				var customSettings = (customDate ? customDate(printDate) : [true, '']);
				var otherMonth = (printDate.getMonth() != this._selectedMonth);
				var unselectable = otherMonth || !customSettings[0] ||
					(minDate && printDate < minDate) || (maxDate && printDate > maxDate);
				html += '<td class="calendar_daysCell' +
					((dow + firstDay + 6) % 7 >= 5 ? ' calendar_weekEndCell' : '') + // highlight weekends
					(otherMonth ? ' calendar_otherMonth' : '') + // highlight days from other months
					(printDate.getTime() == selectedDate.getTime() ? ' ' : '') + // highlight selected day
					(unselectable ? ' calendar_unselectable' : '') +  // highlight unselectable days
					(otherMonth && !showOtherMonths ? '' : ' ' + customSettings[1] + // highlight custom dates
					(printDate.getTime() == currentDate.getTime() ? ' calendar_currentDay' : // highlight current day
					(printDate.getTime() == today.getTime() ? ' calendar_today currentSelection' : ''))) + '"' + // highlight today (if different)
					(unselectable ? '' : ' onmouseover="$(this).addClass(\'calendar_daysCellOver\');"' +
					' onmouseout="$(this).removeClass(\'calendar_daysCellOver\');"' +
					' onclick="popUpCal._selectDay(' + this._id + ', this); $(this).parents(\'table:eq(0)\').find(\'.currentSelection\').removeClass(\'currentSelection\');$(this).addClass(\'currentSelection\');"') + '>' + // actions
					(otherMonth ? (showOtherMonths ? printDate.getDate() : '&nbsp;') : // display for other months
					(unselectable ? printDate.getDate() : '<a>' + printDate.getDate() + '</a>')) + '</td>'; // display for this month
				printDate.setDate(printDate.getDate() + 1);
			}
			html += '</tr>';
		}
		html += '</tbody></table>' + (!closeAtTop && !this._inline ? controls : '') +
			'<div style="clear: both;"></div>' + (!$.browser.msie ? '' :
			'<!--[if lte IE 6.5]><iframe src="javascript:false;" class="calendar_cover"></iframe><![endif]-->');
		return html;
	},

	/* Adjust one of the date sub-fields. */
	_adjustDate: function(offset, period) {
		var date = new Date(this._selectedYear + (period == 'Y' ? offset : 0),
			this._selectedMonth + (period == 'M' ? offset : 0),
			this._selectedDay + (period == 'D' ? offset : 0));
		// ensure it is within the bounds set
		var minDate = this._get('minDate');
		var maxDate = this._get('maxDate');
		date = (minDate && date < minDate ? minDate : date);
		date = (maxDate && date > maxDate ? maxDate : date);
		this._selectedDay = date.getDate();
		this._selectedMonth = date.getMonth();
		this._selectedYear = date.getFullYear();
	},

	/* Find the number of days in a given month. */
	_getDaysInMonth: function(year, month) {
		return 32 - new Date(year, month, 32).getDate();
	},

	/* Find the day of the week of the first of a month. */
	_getFirstDayOfMonth: function(year, month) {
		return new Date(year, month, 1).getDay();
	},

	/* Determines if we should allow a "next/prev" month display change. */
	_canAdjustMonth: function(offset) {
		var date = new Date(this._selectedYear, this._selectedMonth + offset, 1);
		if (offset < 0) {
			date.setDate(this._getDaysInMonth(date.getFullYear(), date.getMonth()));
		}
		return this._isInRange(date);
	},

	/* Is the given date in the accepted range? */
	_isInRange: function(date) {
		var minDate = this._get('minDate');
		var maxDate = this._get('maxDate');
		return ((!minDate || date >= minDate) && (!maxDate || date <= maxDate));
	},

	/* Format the given date for display. */
	_formatDate: function() {
		var day = this._currentDay = this._selectedDay;
		var month = this._currentMonth = this._selectedMonth;
		var year = this._currentYear = this._selectedYear;
		month++; // adjust javascript month
		var dateFormat = this._get('dateFormat');
		var dateString = '';
		for (var i = 0; i < 3; i++) {
			dateString += dateFormat.charAt(3) +
				(dateFormat.charAt(i) == 'D' ? (day < 10 ? '0' : '') + day :
				(dateFormat.charAt(i) == 'M' ? (month < 10 ? '0' : '') + month :
				(dateFormat.charAt(i) == 'Y' ? year : '?')));
		}
		return dateString.substring(dateFormat.charAt(3) ? 1 : 0);
	}
});

/* jQuery extend now ignores nulls! */
function extendRemove(target, props) {
	$.extend(target, props);
	for (var name in props) {
		if (props[name] == null) {
			target[name] = null;
		}
	}
	return target;
}

/* Attach the calendar to a jQuery selection.
   @param  settings  object - the new settings to use for this calendar instance (anonymous)
   @return jQuery object - for chaining further calls */
$.fn.calendar = function(settings) {
	return this.each(function() {
		// check for settings on the control itself - in namespace 'cal:'
		var inlineSettings = null;
		for (attrName in popUpCal._defaults) {
			var attrValue = this.getAttribute('cal:' + attrName);
			if (attrValue) {
				inlineSettings = inlineSettings || {};
				try {
					inlineSettings[attrName] = eval(attrValue);
				}
				catch (err) {
					inlineSettings[attrName] = attrValue;
				}
			}
		}
		var nodeName = this.nodeName.toLowerCase();
		if (nodeName == 'input') {
			var instSettings = (inlineSettings ? $.extend($.extend({}, settings || {}),
				inlineSettings || {}) : settings); // clone and customise
			var inst = (inst && !inlineSettings ? inst :
				new PopUpCalInstance(instSettings, false));
			popUpCal._connectCalendar(this, inst);
		} 
		else if (nodeName == 'div' || nodeName == 'span') {
			var instSettings = $.extend($.extend({}, settings || {}),
				inlineSettings || {}); // clone and customise
			var inst = new PopUpCalInstance(instSettings, true);
			popUpCal._inlineCalendar(this, inst);
		}
	});
};

/* Initialise the calendar. */
$(document).ready(function() {
   popUpCal = new PopUpCal(); // singleton instance
   var earliest = new Date(2004, 10, 10);
   var latest = new Date(2014, 10, 10);
});



/**
 * --------------------------------------------------------------------
 * jQuery-Plugin to create interactive range picker with shortcut menu
 * by Scott Jehl, scott@filamentgroup.com
 * http://www.filamentgroup.com
 * reference article: http://www.filamentgroup.com/lab/jquery_interactive_date_range_picker_with_shortcuts
 * demo page: http://www.filamentgroup.com/examples/datepicker/
 * 
 * Copyright (c) 2008 Filament Group, Inc
 * Dual licensed under the MIT (filamentgroup.com/examples/mit-license.txt) and GPL (filamentgroup.com/examples/gpl-license.txt) licenses.
 *
 * NOTE! This script is free to use and modify with proper attribution. 
 * However, it is not written for flexible reuse but rather for a specific implementation. 
 * We welcome any modification to package this in a more reusable plugin style.
 *
 * Version: 1.0, 31.05.2007
 * Changelog:
 * 	04.28.2008 initial Version 1.0
 * --------------------------------------------------------------------
 */







//DateRange Specific Extension
$.fn.dateRangePicker = function(options){
		var rangeElement = $(this).find('a.rangeDisplay');


		var presetMenu = {
				pastRange: '<div class="dateRange_contain dateRange_wide"><div class="dateRange"><ul class="dateRange_presets">'+
					'<li class="dateRange_last30"><a href="javascript://">Past 30 Days</a></li>'+
					'<li class="dateRange_lastYear"><a href="javascript://">Past 12 Months</a></li>'+
					'<li class="dateRange_yearToDate"><a href="javascript://">Current YTD</a></li>'+
					'<li class="dateRange_allDates"><a href="javascript://">All Dates</a></li>'+
					'<li class="dateRange_allBefore"><a href="javascript://">All Dates Before...</a></li>'+
					'<li class="dateRange_allAfter"><a href="javascript://">All Dates After...</a></li>'+
					'<li class="dateRange_specificDate"><a href="javascript://">Specific Date...</a></li>'+
					'<li class="dateRange_dateRange"><a href="javascript://">Date Range...</a></li>'+
					'</ul>'+
					'<a href="javascript://" class="dateRange_close">Done</a>'+
					'<h2 class="selectDate" style="display: none;"></h2>'+
					'<input type="text" name="range1" id="range1" class="range1" />'+
					'<input type="text" name="range2" id="range2" class="range2" /></div></div>',
				futureRange: '<div class="dateRange_contain dateRange_wide"><div class="dateRange"><ul class="dateRange_presets">'+
					'<li class="dateRange_dateRange"><a href="javascript://">Take Date Range...</a></li>'+
					'</ul>'+
					'<a href="javascript://" class="dateRange_close">Done</a>'+
					'<h2 class="selectDate" style="display: none;"></h2>'+
					'<input type="text" name="range1" id="range1" class="range1" />'+
					'<input type="text" name="range2" id="range2" class="range2" /></div></div>',
				singleUpcoming: '<div class="dateRange_contain"><div class="dateRange"><ul class="dateRange_presets">'+
					'<li class="dateRange_today"><a href="javascript://">Today</a></li>'+
					'<li class="dateRange_tomorrow"><a href="javascript://">Tomorrow</a></li>'+
					'<li class="dateRange_beginningOfWeek"><a href="javascript://">Start of Week</a></li>'+
					'<li class="dateRange_endOfWeek"><a href="javascript://">End of Week</a></li>'+
					'<li class="dateRange_specificDate"><a href="javascript://">Specific Date...</a></li>'+
					'</ul>'+
					'<a href="javascript://" class="dateRange_close">Done</a>'+
					'<h2 class="selectDate" style="display: none;"></h2>'+
					'<input type="text" name="range1" id="range1" class="range1" />'+
					'<input type="text" name="range2" id="range2" class="range2" /></div></div>'	
		};


		
		//insert the preset menus and calendar holders
		if(typeof options.menuSet == 'undefined' || options.menuSet == 'pastRange'){
			var presetMenu = rangeElement.after(presetMenu.pastRange);
		}
		else if(options.menuSet == 'futureRange') {
			rangeElement.after(presetMenu.futureRange);
		}
		else if(options.menuSet == 'singleUpcoming') {
			rangeElement.after(presetMenu.singleUpcoming);
		}
		//height and widths of elements
		var startHeight = 195;//rangeElement.parent().find('ul.dateRange_presets').height();
		var startWidth = 198;//rangeElement.parent().find('ul.dateRange_presets').width()) +4;//+1 for the .4 padding on inner ul
		
		

		//height with pickers
		var expandedHeight = 242;//height needed for calendars
		if(startHeight> expandedHeight) {expandedHeight = startHeight;}

		//widths with pickers
		var width_onePicker_px = startWidth+215;
		var width_twoPickers_px = startWidth+407;


		//convert to ems
		startheight = startHeight/10+'em';
		expandedHeight = expandedHeight/10+'em';
		startWidth = startWidth/10+'em';
		width_onePicker = width_onePicker_px/10+'em';
		width_twoPickers = width_twoPickers_px/10+'em';


		
		
		var rangeType;		
		if(rangeElement.is('input')) rangeType = 'input';
		else rangeType = 'text';
		

		//create the 2 pickers and hide them
		
		var parentDiv = rangeElement.next();
		var range1 = parentDiv.find('[name=range1]');
		var range2 = parentDiv.find('[name=range2]');
		
		range1.calendar({dateRange: true}).focus().css({'position': 'absolute', 'left': '-999999px', 'top': '4.2em'});
		range2.calendar({dateRange: true}).focus().css({'position': 'absolute', 'left': '-999999px', 'top': '4.2em'});

		setTimeout(function(){parentDiv.children(0).hide();}, 100);

		var picker1 = parentDiv.find('.calendar_div:eq(0)');
		var picker2 = parentDiv.find('.calendar_div:eq(1)').addClass('position2');
				//hide pickers
		hidePickers();

		function hidePickers(intvl){
			if(!intvl) intvl=0;
			picker1.fadeOut(intvl);
			picker2.fadeOut(intvl);
			parentDiv.find('h2.selectDate, a.dateRange_close').fadeOut(intvl);
		}

		//show/hide menu from input actions
		$('body, .dateRange_close').click(function(){
			$('.dateRange_contain').children(0).hide(200);
			rangeElement.removeClass('rangeDisplay_on');
		});

		
		rangeElement.click(function(){
			if($(this).next().children(0).is(':visible')){ $(this).removeClass('rangeDisplay_on');}
			else {
				//collision detect
				var offset = $(this).offset();
				var winWidth = $(window).width();
				var rightSpace = winWidth - offset.left;
				if(rightSpace < width_twoPickers_px){
					parentDiv.find('div:eq(0)').css({'left': 'auto', 'right': 0, 'top': 0});
				}
				else {
					parentDiv.find('div:eq(0)').css({'left': 0, 'right': 'auto', 'top': 0});
				}
				$(this).addClass('rangeDisplay_on');
			}
			$(this).next().children(0).slideToggle(200);
			return false;
		});

		
		//cleanup hide
		rangeElement.one("click", function(){
			picker1.hide();
			picker2.hide();
			parentDiv.find('h2.selectDate, a.dateRange_close').hide();
		});
		$('.dateRange_contain').click(function(){
			return false;
		});


		var monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; // Names of months

		//loop to set the range input based on the 2 hidden inputs
		function setRangeVal (){
			setTimeout(function(){
				var val1 = range1.val();
				var val2 = range2.val();
				var str = '';
				if(val1 != ''){
					var splitter = ' to '
					if(val1 == 'All Dates After' || val1 == 'All Dates Before' || val1 == 'All Dates'  ||  val1 == 'End of Week'  || val1 == 'End of Month'  || val1 == 'Start of Week'  || val1 == 'Start of Month'  || val1 == '') splitter = ' ';
					else {
						val1 = val1.split('/');
						val1 = monthNames[val1[0]-1]+' '+ val1[1] + ', ' + val1[2];
						
					}
					if(val2){
						val2 = val2.split('/');
						val2 = monthNames[val2[0]-1]+' '+ val2[1] + ', ' + val2[2];
					}

					
					if(val1 && val2 && val1 != val2) str = val1 + splitter + val2;
					else str = val1;
				}
				if(rangeType == 'input') rangeElement.val(str);
				else rangeElement.find('span').text(str);
				setRangeVal();
			}, 300);
		}
		setRangeVal();

		
		//input bg image
		if(rangeElement.is('input')) rangeElement.addClass('calendarInput');


		//next and prev buttons
		var btns_prevnext = $(this).find('.range_prev:eq(0), .range_next:eq(0)');

		$(btns_prevnext).click(function(){
			if(range1.val() == 'All Dates After' || range1.val() == 'All Dates Before' || range1.val() == 'All Dates'){
				return false;
			}
			function returnDate(val){
				var dateFormat = 'MDY/';
				var currentDate = val.split(dateFormat.charAt(3));
				if (currentDate.length == 3) {
					var currentDay = parseInt(currentDate[dateFormat.indexOf('D')], 10);
					var currentMonth = parseInt(currentDate[dateFormat.indexOf('M')], 10) - 1;
					var currentYear = parseInt(currentDate[dateFormat.indexOf('Y')], 10);
				}
				return new Date(currentYear, currentMonth, currentDay);
			}

			//Get 1 day in milliseconds
			var one_day=1000*60*60*24

			//date from value
			var val1 = returnDate(range1.val());
			var val2 = returnDate(range2.val());
			var difference = Math.abs(Math.ceil((val1.getTime() - val2.getTime())));
			

			

			if(difference == 0) difference=one_day;//if same day, inc by 1

			if($(this).is('.range_prev')){
				difference *= -1;
			}


			var inst1 = popUpCal._inst[$(this).parent().find('.calendar_div:eq(0)').attr('id').split('_')[2]];
			var inst2 = popUpCal._inst[$(this).parent().find('.calendar_div:eq(1)').attr('id').split('_')[2]];


			/*cal 1*/
			//get current date
			var currDate1 = inst1._getDate().getTime();
			//make new temp dates for adding
			var newDate1 = new Date();
			newDate1.setTime(currDate1 + one_day);
			
			//update
			popUpCal._updateCalendar(inst1, 'hidden');
			//set current dates to new dates
			inst1._setDate(newDate1);
			//update
			popUpCal._updateCalendar(inst1, 'hidden');

			
			if(options.menuSet != 'singleUpcoming'){
				/*cal 2*/
				//get current date
				var currDate2 = inst2._getDate().getTime();
				//make new temp dates for adding
				var newDate2 = new Date();
				newDate2.setTime(currDate2 + difference);
				//update
				 popUpCal._updateCalendar(inst2, 'hidden');
				//set current dates to new dates
				inst2._setDate(newDate2);
				//update
				 popUpCal._updateCalendar(inst2, 'hidden');

				 $(this).parent().find('.calendar_currentDay:eq(1)').trigger("click");
			}

			//selected css
			$(this).parent().find('.calendar_currentDay:eq(0)').trigger("click");

			return false;
			
		});


		
		
		var dates = {
				minDate: function(){
					var date = new Date();
					return date.getMonth()+1+'/'+date.getDate()+'/'+(date.getFullYear()-10);
				},
				today: function(){
					var date = new Date();
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				yesterday: function(){
					var date = new Date();
					date.setDate(date.getDate()-1);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				tomorrow: function(){
					var date = new Date();
					date.setDate(date.getDate()+1);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				weekAgo: function(){
					var date = new Date();
					date.setDate(date.getDate()-7);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				nextWeek: function(){
					var date = new Date();
					date.setDate(date.getDate()+7);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				startOfWeek: function(){
					var date = new Date();
					var day = date.getDay();
					date.setDate(date.getDate() -day);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				endOfWeek: function(){
					var date = new Date();
					var day = date.getDay();
					var offset = 6 - day;
					date.setDate(date.getDate() + offset);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				monthAgo: function(){
					var date = new Date();
					date.setDate(date.getDate()-30);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				nextMonth: function(){
					var date = new Date();
					date.setDate(date.getDate()+30);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				startOfMonth: function(){
					var date = new Date();
					
					date.setMonth(date.getMonth()+1);
					date.setDate(1);
					date.setDate(date.getDate() - 1);
					date.setMonth(date.setMonth() - 1);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				endOfMonth: function(){
					var date = new Date();
					date.setDate(date.getDate()+30);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				yearAgo: function(){
					var date = new Date();
					date.setDate(date.getDate()-365);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				},
				ytdStart: function(){
					var date = new Date();
					return '1/1/'+(date.getFullYear());
				},
				nextYear: function(){
					var date = new Date();
					date.setDate(date.getDate()+365);
					return date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear();
				}
			}

			//prefill hidden fields
			range1.val(dates.today());
			range2.val(dates.today());

		
			//menu animations
			var currTimeout = ''; //timeout var for hiding pickers
			$.fn.smallMenu = function(){
				$(this).parents('.dateRange:eq(0)').animate({width: startWidth}, 500,"swing");
				$(this).parents('.dateRange:eq(0)').find('ul:eq(0)').animate({height: startHeight}, 500,"swing");
				$(this).parents('.dateRange:eq(0)').slideUp(200);
				rangeElement.removeClass('rangeDisplay_on');
				currTimeout = setTimeout(function(){hidePickers(200);}, 500);
			}
			
			$.fn.showPickers = function(showPicker, pickerMsg){
				
				clearTimeout(currTimeout);
				picker1.css('top', '4.2em');
				picker2.css('top', '4.2em');
				rangeElement.addClass('rangeDisplay_on');
				$(this).addClass('dateRange_on');
				$(this).parents('.dateRange:eq(0)').find('ul:eq(0)').animate({height: expandedHeight}, 500,"swing");
				
					if(showPicker == 'picker1' || showPicker == 'picker2'){
						$(this).parents('.dateRange:eq(0)').animate({width: width_onePicker}, 500,"swing",function(){
							$(this).find('h2.selectDate').html(pickerMsg).fadeIn(100);
							$(this).find('a.dateRange_close').fadeIn(100);
						});
						if(showPicker == 'picker1') picker1.css('top', '4.2em').fadeIn(100);
						else picker2.removeClass('position2').fadeIn(100);
					}
					else {
						$(this).parents('.dateRange:eq(0)').animate({width: width_twoPickers}, 500,"swing",function(){
							$(this).find('h2.selectDate').html(pickerMsg).fadeIn(100);
								$(this).find('a.dateRange_close').fadeIn(100);
								picker1.fadeIn(100);
								picker2.addClass('position2').fadeIn(100);
						});
					}
			}





		
		parentDiv.find('li').click(function(){	
			$('.dateRange_on').removeClass('dateRange_on'); //kill onstate for LI
			hidePickers(200);//hide any range pickers present
			//figure out which preset is clicked
			if($(this).is('.dateRange_today')) {
				$(this).smallMenu();
				range1.val(dates.today());
				range2.val(dates.today());

			}
			if($(this).is('.dateRange_yesterday')) {
				$(this).smallMenu();
				range1.val(dates.yesterday());
				range2.val(dates.yesterday());

			}
			if($(this).is('.dateRange_tomorrow')) {
				$(this).smallMenu();
				range1.val(dates.tomorrow());
				range2.val(dates.tomorrow());

			}
			if($(this).is('.dateRange_beginningOfWeek')) {
				$(this).smallMenu();
				range1.val(dates.startOfWeek());
				range2.val('');
			}
			if($(this).is('.dateRange_endOfWeek')) {
				$(this).smallMenu();
				range1.val(dates.endOfWeek());
				range2.val('');
			}
			if($(this).is('.dateRange_beginningOfMonth')) {
				$(this).smallMenu();
				range1.val(dates.endOfMonth());
				range2.val('');
			}
			if($(this).is('.dateRange_endOfMonth')) {
				$(this).smallMenu();
				range1.val(dates.startOfMonth());
				range2.val('');
			}
			if($(this).is('.dateRange_last7')) {
				$(this).smallMenu();
				range1.val(dates.weekAgo());
				range2.val(dates.today());

			}
			if($(this).is('.dateRange_next7')) {
				$(this).smallMenu();
				range1.val(dates.today());
				range2.val(dates.nextWeek());

			}
			if($(this).is('.dateRange_last30')) {
				$(this).smallMenu();
				range1.val(dates.monthAgo());
				range2.val(dates.today());

			}
			if($(this).is('.dateRange_next30')) {
				$(this).smallMenu();
				range1.val(dates.today());
				range2.val(dates.nextMonth());

			}
			if($(this).is('.dateRange_lastYear')) {
				$(this).smallMenu();
				range1.val(dates.yearAgo());
				range2.val(dates.today());

			}
			if($(this).is('.dateRange_nextYear')) {
				$(this).smallMenu();
				range1.val(dates.today());
				range2.val(dates.nextYear());

			}
			if($(this).is('.dateRange_allDates')) {
				$(this).smallMenu();
				range1.val(dates.minDate());
				range2.val(dates.today());
				//console.log('all');
			}
			if($(this).is('.dateRange_yearToDate')) {
				$(this).smallMenu();
				range1.val(dates.ytdStart());
				range2.val(dates.today());
			}
			//items involving pickers
			if($(this).is('.dateRange_specificDate')) {
				range2.val('');
				$(this).showPickers('picker1', 'Select a Date:');
			}
			
			if($(this).is('.dateRange_allBefore')) {
				range1.val('All Dates Before');
				$(this).showPickers('picker2', 'All Dates Before:');
			}
			
			if($(this).is('.dateRange_allAfter')) {
				range1.val('All Dates After');
				$(this).showPickers('picker2', 'All Dates After:');
			}
			
			if($(this).is('.dateRange_dateRange')) {
				$(this).showPickers('both', 'Select a Date Range:');
			}

		});
		$('.dateRange_last30').trigger('click');
		if(parent) parent.scrollTo(0, 0); //
		return $(this);
	}









