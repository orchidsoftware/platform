webpackJsonp([1],{

/***/ 170:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(171);
module.exports = __webpack_require__(252);


/***/ }),

/***/ 171:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_stimulus_webpack_helpers__ = __webpack_require__(21);



__webpack_require__(188);

window.application = __WEBPACK_IMPORTED_MODULE_0_stimulus__["Application"].start();
var context = __webpack_require__(198);
application.load(Object(__WEBPACK_IMPORTED_MODULE_1_stimulus_webpack_helpers__["definitionsFromContext"])(context));

/***/ }),

/***/ 188:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_jQuery, $) {window.$ = __webpack_provided_window_dot_jQuery = __webpack_require__(1);

window.Vue = __webpack_require__(22);

//require('popper.js');

__webpack_require__(24);

__webpack_require__(25);

__webpack_require__(26);

document.addEventListener('turbolinks:load', function () {
  $("input[data-role='tagsinput']").tagsinput('refresh');
});

window.Dropzone = __webpack_require__(27);
Dropzone.autoDiscover = false;

__webpack_require__(28);

window.moment = __webpack_require__(0);

$.fn.datetimepicker = __webpack_require__(192);

__webpack_require__(193);

__webpack_require__(152);

$(function () {
  $('.select2-enable').select2({
    theme: 'bootstrap'
  });
});

$.fn.select2.defaults.set('theme', 'bootstrap');
__webpack_require__(153);

__webpack_require__(194);
__webpack_require__(195);

// window.Chart = require('../../../node_modules/frappe-charts/dist/frappe-charts.min.cjs');
window.Chart = __webpack_require__(154);

__webpack_require__(196);
__webpack_require__(197);
// require('./components/menu');
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1), __webpack_require__(1)))

/***/ }),

/***/ 192:
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*! version : 4.17.47
 =========================================================
 bootstrap-datetimejs
 https://github.com/Eonasdan/bootstrap-datetimepicker
 Copyright (c) 2015 Jonathan Peterson
 =========================================================
 */
/*
 The MIT License (MIT)

 Copyright (c) 2015 Jonathan Peterson

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
 */
/*global define:false */
/*global exports:false */
/*global require:false */
/*global jQuery:false */
/*global moment:false */
(function (factory) {
  'use strict';

  if (true) {
    // AMD is used - Register as an anonymous module.
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(1), __webpack_require__(0)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else if ((typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) === 'object') {
    module.exports = factory(require('jquery'), require('moment'));
  } else {
    // Neither AMD nor CommonJS used. Use global variables.
    if (typeof jQuery === 'undefined') {
      throw 'bootstrap-datetimepicker requires jQuery to be loaded first';
    }
    if (typeof moment === 'undefined') {
      throw 'bootstrap-datetimepicker requires Moment.js to be loaded first';
    }
    factory(jQuery, moment);
  }
})(function ($, moment) {
  'use strict';

  if (!moment) {
    throw new Error('bootstrap-datetimepicker requires Moment.js to be loaded first');
  }

  var dateTimePicker = function dateTimePicker(element, options) {
    var picker = {},
        date,
        viewDate,
        unset = true,
        input,
        component = false,
        widget = false,
        use24Hours,
        minViewModeNumber = 0,
        actualFormat,
        parseFormats,
        currentViewMode,
        datePickerModes = [{
      clsName: 'days',
      navFnc: 'M',
      navStep: 1
    }, {
      clsName: 'months',
      navFnc: 'y',
      navStep: 1
    }, {
      clsName: 'years',
      navFnc: 'y',
      navStep: 10
    }, {
      clsName: 'decades',
      navFnc: 'y',
      navStep: 100
    }],
        viewModes = ['days', 'months', 'years', 'decades'],
        verticalModes = ['top', 'bottom', 'auto'],
        horizontalModes = ['left', 'right', 'auto'],
        toolbarPlacements = ['default', 'top', 'bottom'],
        keyMap = {
      up: 38,
      38: 'up',
      down: 40,
      40: 'down',
      left: 37,
      37: 'left',
      right: 39,
      39: 'right',
      tab: 9,
      9: 'tab',
      escape: 27,
      27: 'escape',
      enter: 13,
      13: 'enter',
      pageUp: 33,
      33: 'pageUp',
      pageDown: 34,
      34: 'pageDown',
      shift: 16,
      16: 'shift',
      control: 17,
      17: 'control',
      space: 32,
      32: 'space',
      t: 84,
      84: 't',
      delete: 46,
      46: 'delete'
    },
        keyState = {},

    /********************************************************************************
     *
     * Private functions
     *
     ********************************************************************************/

    hasTimeZone = function hasTimeZone() {
      return moment.tz !== undefined && options.timeZone !== undefined && options.timeZone !== null && options.timeZone !== '';
    },
        getMoment = function getMoment(d) {
      var returnMoment = void 0;

      if (d === undefined || d === null) {
        returnMoment = moment(); //TODO should this use format? and locale?
      } else if (moment.isDate(d) || moment.isMoment(d)) {
        // If the date that is passed in is already a Date() or moment() object,
        // pass it directly to moment.
        returnMoment = moment(d);
      } else if (hasTimeZone()) {
        // There is a string to parse and a default time zone
        // parse with the tz function which takes a default time zone if it is not in the format string
        returnMoment = moment.tz(d, parseFormats, options.useStrict, options.timeZone);
      } else {
        returnMoment = moment(d, parseFormats, options.useStrict);
      }

      if (hasTimeZone()) {
        returnMoment.tz(options.timeZone);
      }

      return returnMoment;
    },
        isEnabled = function isEnabled(granularity) {
      if (typeof granularity !== 'string' || granularity.length > 1) {
        throw new TypeError('isEnabled expects a single character string parameter');
      }
      switch (granularity) {
        case 'y':
          return actualFormat.indexOf('Y') !== -1;
        case 'M':
          return actualFormat.indexOf('M') !== -1;
        case 'd':
          return actualFormat.toLowerCase().indexOf('d') !== -1;
        case 'h':
        case 'H':
          return actualFormat.toLowerCase().indexOf('h') !== -1;
        case 'm':
          return actualFormat.indexOf('m') !== -1;
        case 's':
          return actualFormat.indexOf('s') !== -1;
        default:
          return false;
      }
    },
        hasTime = function hasTime() {
      return isEnabled('h') || isEnabled('m') || isEnabled('s');
    },
        hasDate = function hasDate() {
      return isEnabled('y') || isEnabled('M') || isEnabled('d');
    },
        getDatePickerTemplate = function getDatePickerTemplate() {
      var headTemplate = $('<thead>').append($('<tr>').append($('<th>').addClass('prev').attr('data-action', 'previous').append($('<span>').addClass(options.icons.previous))).append($('<th>').addClass('picker-switch').attr('data-action', 'pickerSwitch').attr('colspan', options.calendarWeeks ? '6' : '5')).append($('<th>').addClass('next').attr('data-action', 'next').append($('<span>').addClass(options.icons.next)))),
          contTemplate = $('<tbody>').append($('<tr>').append($('<td>').attr('colspan', options.calendarWeeks ? '8' : '7')));

      return [$('<div>').addClass('datepicker-days').append($('<table>').addClass('table-condensed').append(headTemplate).append($('<tbody>'))), $('<div>').addClass('datepicker-months').append($('<table>').addClass('table-condensed').append(headTemplate.clone()).append(contTemplate.clone())), $('<div>').addClass('datepicker-years').append($('<table>').addClass('table-condensed').append(headTemplate.clone()).append(contTemplate.clone())), $('<div>').addClass('datepicker-decades').append($('<table>').addClass('table-condensed').append(headTemplate.clone()).append(contTemplate.clone()))];
    },
        getTimePickerMainTemplate = function getTimePickerMainTemplate() {
      var topRow = $('<tr>'),
          middleRow = $('<tr>'),
          bottomRow = $('<tr>');

      if (isEnabled('h')) {
        topRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          title: options.tooltips.incrementHour
        }).addClass('btn').attr('data-action', 'incrementHours').append($('<span>').addClass(options.icons.up))));
        middleRow.append($('<td>').append($('<span>').addClass('timepicker-hour').attr({
          'data-time-component': 'hours',
          title: options.tooltips.pickHour
        }).attr('data-action', 'showHours')));
        bottomRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          title: options.tooltips.decrementHour
        }).addClass('btn').attr('data-action', 'decrementHours').append($('<span>').addClass(options.icons.down))));
      }
      if (isEnabled('m')) {
        if (isEnabled('h')) {
          topRow.append($('<td>').addClass('separator'));
          middleRow.append($('<td>').addClass('separator').html(':'));
          bottomRow.append($('<td>').addClass('separator'));
        }
        topRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          title: options.tooltips.incrementMinute
        }).addClass('btn').attr('data-action', 'incrementMinutes').append($('<span>').addClass(options.icons.up))));
        middleRow.append($('<td>').append($('<span>').addClass('timepicker-minute').attr({
          'data-time-component': 'minutes',
          title: options.tooltips.pickMinute
        }).attr('data-action', 'showMinutes')));
        bottomRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          title: options.tooltips.decrementMinute
        }).addClass('btn').attr('data-action', 'decrementMinutes').append($('<span>').addClass(options.icons.down))));
      }
      if (isEnabled('s')) {
        if (isEnabled('m')) {
          topRow.append($('<td>').addClass('separator'));
          middleRow.append($('<td>').addClass('separator').html(':'));
          bottomRow.append($('<td>').addClass('separator'));
        }
        topRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          title: options.tooltips.incrementSecond
        }).addClass('btn').attr('data-action', 'incrementSeconds').append($('<span>').addClass(options.icons.up))));
        middleRow.append($('<td>').append($('<span>').addClass('timepicker-second').attr({
          'data-time-component': 'seconds',
          title: options.tooltips.pickSecond
        }).attr('data-action', 'showSeconds')));
        bottomRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          title: options.tooltips.decrementSecond
        }).addClass('btn').attr('data-action', 'decrementSeconds').append($('<span>').addClass(options.icons.down))));
      }

      if (!use24Hours) {
        topRow.append($('<td>').addClass('separator'));
        middleRow.append($('<td>').append($('<button>').addClass('btn btn-primary').attr({
          'data-action': 'togglePeriod',
          tabindex: '-1',
          title: options.tooltips.togglePeriod
        })));
        bottomRow.append($('<td>').addClass('separator'));
      }

      return $('<div>').addClass('timepicker-picker').append($('<table>').addClass('table-condensed').append([topRow, middleRow, bottomRow]));
    },
        getTimePickerTemplate = function getTimePickerTemplate() {
      var hoursView = $('<div>').addClass('timepicker-hours').append($('<table>').addClass('table-condensed')),
          minutesView = $('<div>').addClass('timepicker-minutes').append($('<table>').addClass('table-condensed')),
          secondsView = $('<div>').addClass('timepicker-seconds').append($('<table>').addClass('table-condensed')),
          ret = [getTimePickerMainTemplate()];

      if (isEnabled('h')) {
        ret.push(hoursView);
      }
      if (isEnabled('m')) {
        ret.push(minutesView);
      }
      if (isEnabled('s')) {
        ret.push(secondsView);
      }

      return ret;
    },
        getToolbar = function getToolbar() {
      var row = [];
      if (options.showTodayButton) {
        row.push($('<td>').append($('<a>').attr({ 'data-action': 'today', title: options.tooltips.today }).append($('<span>').addClass(options.icons.today))));
      }
      if (!options.sideBySide && hasDate() && hasTime()) {
        row.push($('<td>').append($('<a>').attr({
          'data-action': 'togglePicker',
          title: options.tooltips.selectTime
        }).append($('<span>').addClass(options.icons.time))));
      }
      if (options.showClear) {
        row.push($('<td>').append($('<a>').attr({ 'data-action': 'clear', title: options.tooltips.clear }).append($('<span>').addClass(options.icons.clear))));
      }
      if (options.showClose) {
        row.push($('<td>').append($('<a>').attr({ 'data-action': 'close', title: options.tooltips.close }).append($('<span>').addClass(options.icons.close))));
      }
      return $('<table>').addClass('table-condensed').append($('<tbody>').append($('<tr>').append(row)));
    },
        getTemplate = function getTemplate() {
      var template = $('<div>').addClass('bootstrap-datetimepicker-widget dropdown-menu'),
          dateView = $('<div>').addClass('datepicker').append(getDatePickerTemplate()),
          timeView = $('<div>').addClass('timepicker').append(getTimePickerTemplate()),
          content = $('<ul>').addClass('list-unstyled'),
          toolbar = $('<li>').addClass('picker-switch' + (options.collapse ? ' accordion-toggle' : '')).append(getToolbar());

      if (options.inline) {
        template.removeClass('dropdown-menu');
      }

      if (use24Hours) {
        template.addClass('usetwentyfour');
      }

      if (isEnabled('s') && !use24Hours) {
        template.addClass('wider');
      }

      if (options.sideBySide && hasDate() && hasTime()) {
        template.addClass('timepicker-sbs');
        if (options.toolbarPlacement === 'top') {
          template.append(toolbar);
        }
        template.append($('<div>').addClass('row').append(dateView.addClass('col-md-6')).append(timeView.addClass('col-md-6')));
        if (options.toolbarPlacement === 'bottom') {
          template.append(toolbar);
        }
        return template;
      }

      if (options.toolbarPlacement === 'top') {
        content.append(toolbar);
      }
      if (hasDate()) {
        content.append($('<li>').addClass(options.collapse && hasTime() ? 'collapse show' : '').append(dateView));
      }
      if (options.toolbarPlacement === 'default') {
        content.append(toolbar);
      }
      if (hasTime()) {
        content.append($('<li>').addClass(options.collapse && hasDate() ? 'collapse' : '').append(timeView));
      }
      if (options.toolbarPlacement === 'bottom') {
        content.append(toolbar);
      }
      return template.append(content);
    },
        dataToOptions = function dataToOptions() {
      var eData = void 0,
          dataOptions = {};

      if (element.is('input') || options.inline) {
        eData = element.data();
      } else {
        eData = element.find('input').data();
      }

      if (eData.dateOptions && eData.dateOptions instanceof Object) {
        dataOptions = $.extend(true, dataOptions, eData.dateOptions);
      }

      $.each(options, function (key) {
        var attributeName = 'date' + key.charAt(0).toUpperCase() + key.slice(1);
        if (eData[attributeName] !== undefined) {
          dataOptions[key] = eData[attributeName];
        }
      });
      return dataOptions;
    },
        place = function place() {
      var position = (component || element).position(),
          offset = (component || element).offset();
      var vertical = options.widgetPositioning.vertical,
          horizontal = options.widgetPositioning.horizontal,
          parent = void 0;

      if (options.widgetParent) {
        parent = options.widgetParent.append(widget);
      } else if (element.is('input')) {
        parent = element.after(widget).parent();
      } else if (options.inline) {
        parent = element.append(widget);
        return;
      } else {
        parent = element;
        element.children().first().after(widget);
      }

      // Top and bottom logic
      if (vertical === 'auto') {
        if (offset.top + widget.height() * 1.5 >= $(window).height() + $(window).scrollTop() && widget.height() + element.outerHeight() < offset.top) {
          vertical = 'top';
        } else {
          vertical = 'bottom';
        }
      }

      // Left and right logic
      if (horizontal === 'auto') {
        if (parent.width() < offset.left + widget.outerWidth() / 2 && offset.left + widget.outerWidth() > $(window).width()) {
          horizontal = 'right';
        } else {
          horizontal = 'left';
        }
      }

      if (vertical === 'top') {
        widget.addClass('top').removeClass('bottom');
      } else {
        widget.addClass('bottom').removeClass('top');
      }

      if (horizontal === 'right') {
        widget.addClass('pull-right');
      } else {
        widget.removeClass('pull-right');
      }

      // find the first parent element that has a non-static css positioning
      if (parent.css('position') === 'static') {
        parent = parent.parents().filter(function () {
          return $(this).css('position') !== 'static';
        }).first();
      }

      if (parent.length === 0) {
        throw new Error('datetimepicker component should be placed within a non-static positioned container');
      }

      widget.css({
        top: vertical === 'top' ? 'auto' : position.top + element.outerHeight(),
        bottom: vertical === 'top' ? parent.outerHeight() - (parent === element ? 0 : position.top) : 'auto',
        left: horizontal === 'left' ? parent === element ? 0 : position.left : 'auto',
        right: horizontal === 'left' ? 'auto' : parent.outerWidth() - element.outerWidth() - (parent === element ? 0 : position.left)
      });
    },
        notifyEvent = function notifyEvent(e) {
      if (e.type === 'dp.change' && (e.date && e.date.isSame(e.oldDate) || !e.date && !e.oldDate)) {
        return;
      }
      element.trigger(e);
    },
        viewUpdate = function viewUpdate(e) {
      if (e === 'y') {
        e = 'YYYY';
      }
      notifyEvent({
        type: 'dp.update',
        change: e,
        viewDate: viewDate.clone()
      });
    },
        showMode = function showMode(dir) {
      if (!widget) {
        return;
      }
      if (dir) {
        currentViewMode = Math.max(minViewModeNumber, Math.min(3, currentViewMode + dir));
      }
      widget.find('.datepicker > div').hide().filter('.datepicker-' + datePickerModes[currentViewMode].clsName).show();
    },
        fillDow = function fillDow() {
      var row = $('<tr>'),
          currentDate = viewDate.clone().startOf('w').startOf('d');

      if (options.calendarWeeks === true) {
        row.append($('<th>').addClass('cw').text('#'));
      }

      while (currentDate.isBefore(viewDate.clone().endOf('w'))) {
        row.append($('<th>').addClass('dow').text(currentDate.format('dd')));
        currentDate.add(1, 'd');
      }
      widget.find('.datepicker-days thead').append(row);
    },
        isInDisabledDates = function isInDisabledDates(testDate) {
      return options.disabledDates[testDate.format('YYYY-MM-DD')] === true;
    },
        isInEnabledDates = function isInEnabledDates(testDate) {
      return options.enabledDates[testDate.format('YYYY-MM-DD')] === true;
    },
        isInDisabledHours = function isInDisabledHours(testDate) {
      return options.disabledHours[testDate.format('H')] === true;
    },
        isInEnabledHours = function isInEnabledHours(testDate) {
      return options.enabledHours[testDate.format('H')] === true;
    },
        isValid = function isValid(targetMoment, granularity) {
      if (!targetMoment.isValid()) {
        return false;
      }
      if (options.disabledDates && granularity === 'd' && isInDisabledDates(targetMoment)) {
        return false;
      }
      if (options.enabledDates && granularity === 'd' && !isInEnabledDates(targetMoment)) {
        return false;
      }
      if (options.minDate && targetMoment.isBefore(options.minDate, granularity)) {
        return false;
      }
      if (options.maxDate && targetMoment.isAfter(options.maxDate, granularity)) {
        return false;
      }
      if (options.daysOfWeekDisabled && granularity === 'd' && options.daysOfWeekDisabled.indexOf(targetMoment.day()) !== -1) {
        return false;
      }
      if (options.disabledHours && (granularity === 'h' || granularity === 'm' || granularity === 's') && isInDisabledHours(targetMoment)) {
        return false;
      }
      if (options.enabledHours && (granularity === 'h' || granularity === 'm' || granularity === 's') && !isInEnabledHours(targetMoment)) {
        return false;
      }
      if (options.disabledTimeIntervals && (granularity === 'h' || granularity === 'm' || granularity === 's')) {
        var found = false;
        $.each(options.disabledTimeIntervals, function () {
          if (targetMoment.isBetween(this[0], this[1])) {
            found = true;
            return false;
          }
        });
        if (found) {
          return false;
        }
      }
      return true;
    },
        fillMonths = function fillMonths() {
      var spans = [],
          monthsShort = viewDate.clone().startOf('y').startOf('d');
      while (monthsShort.isSame(viewDate, 'y')) {
        spans.push($('<span>').attr('data-action', 'selectMonth').addClass('month').text(monthsShort.format('MMM')));
        monthsShort.add(1, 'M');
      }
      widget.find('.datepicker-months td').empty().append(spans);
    },
        updateMonths = function updateMonths() {
      var monthsView = widget.find('.datepicker-months'),
          monthsViewHeader = monthsView.find('th'),
          months = monthsView.find('tbody').find('span');

      monthsViewHeader.eq(0).find('span').attr('title', options.tooltips.prevYear);
      monthsViewHeader.eq(1).attr('title', options.tooltips.selectYear);
      monthsViewHeader.eq(2).find('span').attr('title', options.tooltips.nextYear);

      monthsView.find('.disabled').removeClass('disabled');

      if (!isValid(viewDate.clone().subtract(1, 'y'), 'y')) {
        monthsViewHeader.eq(0).addClass('disabled');
      }

      monthsViewHeader.eq(1).text(viewDate.year());

      if (!isValid(viewDate.clone().add(1, 'y'), 'y')) {
        monthsViewHeader.eq(2).addClass('disabled');
      }

      months.removeClass('active');
      if (date.isSame(viewDate, 'y') && !unset) {
        months.eq(date.month()).addClass('active');
      }

      months.each(function (index) {
        if (!isValid(viewDate.clone().month(index), 'M')) {
          $(this).addClass('disabled');
        }
      });
    },
        updateYears = function updateYears() {
      var yearsView = widget.find('.datepicker-years'),
          yearsViewHeader = yearsView.find('th'),
          startYear = viewDate.clone().subtract(5, 'y'),
          endYear = viewDate.clone().add(6, 'y');
      var html = '';

      yearsViewHeader.eq(0).find('span').attr('title', options.tooltips.prevDecade);
      yearsViewHeader.eq(1).attr('title', options.tooltips.selectDecade);
      yearsViewHeader.eq(2).find('span').attr('title', options.tooltips.nextDecade);

      yearsView.find('.disabled').removeClass('disabled');

      if (options.minDate && options.minDate.isAfter(startYear, 'y')) {
        yearsViewHeader.eq(0).addClass('disabled');
      }

      yearsViewHeader.eq(1).text(startYear.year() + '-' + endYear.year());

      if (options.maxDate && options.maxDate.isBefore(endYear, 'y')) {
        yearsViewHeader.eq(2).addClass('disabled');
      }

      while (!startYear.isAfter(endYear, 'y')) {
        html += '<span data-action="selectYear" class="year' + (startYear.isSame(date, 'y') && !unset ? ' active' : '') + (!isValid(startYear, 'y') ? ' disabled' : '') + '">' + startYear.year() + '</span>';
        startYear.add(1, 'y');
      }

      yearsView.find('td').html(html);
    },
        updateDecades = function updateDecades() {
      var decadesView = widget.find('.datepicker-decades'),
          decadesViewHeader = decadesView.find('th'),
          startDecade = moment({
        y: viewDate.year() - viewDate.year() % 100 - 1
      }),
          endDecade = startDecade.clone().add(100, 'y'),
          startedAt = startDecade.clone();
      var minDateDecade = false,
          maxDateDecade = false,
          endDecadeYear = void 0,
          html = '';

      decadesViewHeader.eq(0).find('span').attr('title', options.tooltips.prevCentury);
      decadesViewHeader.eq(2).find('span').attr('title', options.tooltips.nextCentury);

      decadesView.find('.disabled').removeClass('disabled');

      if (startDecade.isSame(moment({ y: 1900 })) || options.minDate && options.minDate.isAfter(startDecade, 'y')) {
        decadesViewHeader.eq(0).addClass('disabled');
      }

      decadesViewHeader.eq(1).text(startDecade.year() + '-' + endDecade.year());

      if (startDecade.isSame(moment({ y: 2000 })) || options.maxDate && options.maxDate.isBefore(endDecade, 'y')) {
        decadesViewHeader.eq(2).addClass('disabled');
      }

      while (!startDecade.isAfter(endDecade, 'y')) {
        endDecadeYear = startDecade.year() + 12;
        minDateDecade = options.minDate && options.minDate.isAfter(startDecade, 'y') && options.minDate.year() <= endDecadeYear;
        maxDateDecade = options.maxDate && options.maxDate.isAfter(startDecade, 'y') && options.maxDate.year() <= endDecadeYear;
        html += '<span data-action="selectDecade" class="decade' + (date.isAfter(startDecade) && date.year() <= endDecadeYear ? ' active' : '') + (!isValid(startDecade, 'y') && !minDateDecade && !maxDateDecade ? ' disabled' : '') + '" data-selection="' + (startDecade.year() + 6) + '">' + (startDecade.year() + 1) + ' - ' + (startDecade.year() + 12) + '</span>';
        startDecade.add(12, 'y');
      }
      html += '<span></span><span></span><span></span>'; //push the dangling block over, at least this way it's even

      decadesView.find('td').html(html);
      decadesViewHeader.eq(1).text(startedAt.year() + 1 + '-' + startDecade.year());
    },
        fillDate = function fillDate() {
      var daysView = widget.find('.datepicker-days'),
          daysViewHeader = daysView.find('th');
      var currentDate = void 0;
      var html = [];
      var row = void 0,
          clsNames = [],
          i = void 0;

      if (!hasDate()) {
        return;
      }

      daysViewHeader.eq(0).find('span').attr('title', options.tooltips.prevMonth);
      daysViewHeader.eq(1).attr('title', options.tooltips.selectMonth);
      daysViewHeader.eq(2).find('span').attr('title', options.tooltips.nextMonth);

      daysView.find('.disabled').removeClass('disabled');
      daysViewHeader.eq(1).text(viewDate.format(options.dayViewHeaderFormat));

      if (!isValid(viewDate.clone().subtract(1, 'M'), 'M')) {
        daysViewHeader.eq(0).addClass('disabled');
      }
      if (!isValid(viewDate.clone().add(1, 'M'), 'M')) {
        daysViewHeader.eq(2).addClass('disabled');
      }

      currentDate = viewDate.clone().startOf('M').startOf('w').startOf('d');

      for (i = 0; i < 42; i++) {
        //always display 42 days (should show 6 weeks)
        if (currentDate.weekday() === 0) {
          row = $('<tr>');
          if (options.calendarWeeks) {
            row.append('<td class="cw">' + currentDate.week() + '</td>');
          }
          html.push(row);
        }
        clsNames = ['day'];
        if (currentDate.isBefore(viewDate, 'M')) {
          clsNames.push('old');
        }
        if (currentDate.isAfter(viewDate, 'M')) {
          clsNames.push('new');
        }
        if (currentDate.isSame(date, 'd') && !unset) {
          clsNames.push('active');
        }
        if (!isValid(currentDate, 'd')) {
          clsNames.push('disabled');
        }
        if (currentDate.isSame(getMoment(), 'd')) {
          clsNames.push('today');
        }
        if (currentDate.day() === 0 || currentDate.day() === 6) {
          clsNames.push('weekend');
        }
        notifyEvent({
          type: 'dp.classify',
          date: currentDate,
          classNames: clsNames
        });
        row.append('<td data-action="selectDay" data-day="' + currentDate.format('L') + '" class="' + clsNames.join(' ') + '">' + currentDate.date() + '</td>');
        currentDate.add(1, 'd');
      }

      daysView.find('tbody').empty().append(html);

      updateMonths();

      updateYears();

      updateDecades();
    },
        fillHours = function fillHours() {
      var table = widget.find('.timepicker-hours table'),
          currentHour = viewDate.clone().startOf('d'),
          html = [];
      var row = $('<tr>');

      if (viewDate.hour() > 11 && !use24Hours) {
        currentHour.hour(12);
      }
      while (currentHour.isSame(viewDate, 'd') && (use24Hours || viewDate.hour() < 12 && currentHour.hour() < 12 || viewDate.hour() > 11)) {
        if (currentHour.hour() % 4 === 0) {
          row = $('<tr>');
          html.push(row);
        }
        row.append('<td data-action="selectHour" class="hour' + (!isValid(currentHour, 'h') ? ' disabled' : '') + '">' + currentHour.format(use24Hours ? 'HH' : 'hh') + '</td>');
        currentHour.add(1, 'h');
      }
      table.empty().append(html);
    },
        fillMinutes = function fillMinutes() {
      var table = widget.find('.timepicker-minutes table'),
          currentMinute = viewDate.clone().startOf('h'),
          html = [];
      var row = $('<tr>');
      var step = options.stepping === 1 ? 5 : options.stepping;

      while (viewDate.isSame(currentMinute, 'h')) {
        if (currentMinute.minute() % (step * 4) === 0) {
          row = $('<tr>');
          html.push(row);
        }
        row.append('<td data-action="selectMinute" class="minute' + (!isValid(currentMinute, 'm') ? ' disabled' : '') + '">' + currentMinute.format('mm') + '</td>');
        currentMinute.add(step, 'm');
      }
      table.empty().append(html);
    },
        fillSeconds = function fillSeconds() {
      var table = widget.find('.timepicker-seconds table'),
          currentSecond = viewDate.clone().startOf('m'),
          html = [];
      var row = $('<tr>');

      while (viewDate.isSame(currentSecond, 'm')) {
        if (currentSecond.second() % 20 === 0) {
          row = $('<tr>');
          html.push(row);
        }
        row.append('<td data-action="selectSecond" class="second' + (!isValid(currentSecond, 's') ? ' disabled' : '') + '">' + currentSecond.format('ss') + '</td>');
        currentSecond.add(5, 's');
      }

      table.empty().append(html);
    },
        fillTime = function fillTime() {
      var toggle = void 0,
          newDate = void 0;
      var timeComponents = widget.find('.timepicker span[data-time-component]');

      if (!use24Hours) {
        toggle = widget.find('.timepicker [data-action=togglePeriod]');
        newDate = date.clone().add(date.hours() >= 12 ? -12 : 12, 'h');

        toggle.text(date.format('A'));

        if (isValid(newDate, 'h')) {
          toggle.removeClass('disabled');
        } else {
          toggle.addClass('disabled');
        }
      }
      timeComponents.filter('[data-time-component=hours]').text(date.format(use24Hours ? 'HH' : 'hh'));
      timeComponents.filter('[data-time-component=minutes]').text(date.format('mm'));
      timeComponents.filter('[data-time-component=seconds]').text(date.format('ss'));

      fillHours();
      fillMinutes();
      fillSeconds();
    },
        update = function update() {
      if (!widget) {
        return;
      }
      fillDate();
      fillTime();
    },
        setValue = function setValue(targetMoment) {
      var oldDate = unset ? null : date;

      // case of calling setValue(null or false)
      if (!targetMoment) {
        unset = true;
        input.val('');
        element.data('date', '');
        notifyEvent({
          type: 'dp.change',
          date: false,
          oldDate: oldDate
        });
        update();
        return;
      }

      targetMoment = targetMoment.clone().locale(options.locale);

      if (hasTimeZone()) {
        targetMoment.tz(options.timeZone);
      }

      if (options.stepping !== 1) {
        targetMoment.minutes(Math.round(targetMoment.minutes() / options.stepping) * options.stepping).seconds(0);

        while (options.minDate && targetMoment.isBefore(options.minDate)) {
          targetMoment.add(options.stepping, 'minutes');
        }
      }

      if (isValid(targetMoment)) {
        date = targetMoment;
        viewDate = date.clone();
        input.val(date.format(actualFormat));
        element.data('date', date.format(actualFormat));
        unset = false;
        update();
        notifyEvent({
          type: 'dp.change',
          date: date.clone(),
          oldDate: oldDate
        });
      } else {
        if (!options.keepInvalid) {
          input.val(unset ? '' : date.format(actualFormat));
        } else {
          notifyEvent({
            type: 'dp.change',
            date: targetMoment,
            oldDate: oldDate
          });
        }
        notifyEvent({
          type: 'dp.error',
          date: targetMoment,
          oldDate: oldDate
        });
      }
    },

    /**
     * Hides the widget. Possibly will emit dp.hide
     */
    hide = function hide() {
      var transitioning = false;
      if (!widget) {
        return picker;
      }
      // Ignore event if in the middle of a picker transition
      widget.find('.collapse').each(function () {
        var collapseData = $(this).data('collapse');
        if (collapseData && collapseData.transitioning) {
          transitioning = true;
          return false;
        }
        return true;
      });
      if (transitioning) {
        return picker;
      }
      if (component && component.hasClass('btn')) {
        component.toggleClass('active');
      }
      widget.hide();

      $(window).off('resize', place);
      widget.off('click', '[data-action]');
      widget.off('mousedown', false);

      widget.remove();
      widget = false;

      notifyEvent({
        type: 'dp.hide',
        date: date.clone()
      });

      input.blur();

      viewDate = date.clone();

      return picker;
    },
        clear = function clear() {
      setValue(null);
    },
        parseInputDate = function parseInputDate(inputDate) {
      if (options.parseInputDate === undefined) {
        if (!moment.isMoment(inputDate) || inputDate instanceof Date) {
          inputDate = getMoment(inputDate);
        }
      } else {
        inputDate = options.parseInputDate(inputDate);
      }
      //inputDate.locale(options.locale);
      return inputDate;
    },

    /********************************************************************************
     *
     * Widget UI interaction functions
     *
     ********************************************************************************/
    actions = {
      next: function next() {
        var navFnc = datePickerModes[currentViewMode].navFnc;
        viewDate.add(datePickerModes[currentViewMode].navStep, navFnc);
        fillDate();
        viewUpdate(navFnc);
      },

      previous: function previous() {
        var navFnc = datePickerModes[currentViewMode].navFnc;
        viewDate.subtract(datePickerModes[currentViewMode].navStep, navFnc);
        fillDate();
        viewUpdate(navFnc);
      },

      pickerSwitch: function pickerSwitch() {
        showMode(1);
      },

      selectMonth: function selectMonth(e) {
        var month = $(e.target).closest('tbody').find('span').index($(e.target));
        viewDate.month(month);
        if (currentViewMode === minViewModeNumber) {
          setValue(date.clone().year(viewDate.year()).month(viewDate.month()));
          if (!options.inline) {
            hide();
          }
        } else {
          showMode(-1);
          fillDate();
        }
        viewUpdate('M');
      },

      selectYear: function selectYear(e) {
        var year = parseInt($(e.target).text(), 10) || 0;
        viewDate.year(year);
        if (currentViewMode === minViewModeNumber) {
          setValue(date.clone().year(viewDate.year()));
          if (!options.inline) {
            hide();
          }
        } else {
          showMode(-1);
          fillDate();
        }
        viewUpdate('YYYY');
      },

      selectDecade: function selectDecade(e) {
        var year = parseInt($(e.target).data('selection'), 10) || 0;
        viewDate.year(year);
        if (currentViewMode === minViewModeNumber) {
          setValue(date.clone().year(viewDate.year()));
          if (!options.inline) {
            hide();
          }
        } else {
          showMode(-1);
          fillDate();
        }
        viewUpdate('YYYY');
      },

      selectDay: function selectDay(e) {
        var day = viewDate.clone();
        if ($(e.target).is('.old')) {
          day.subtract(1, 'M');
        }
        if ($(e.target).is('.new')) {
          day.add(1, 'M');
        }
        setValue(day.date(parseInt($(e.target).text(), 10)));
        if (!hasTime() && !options.keepOpen && !options.inline) {
          hide();
        }
      },

      incrementHours: function incrementHours() {
        var newDate = date.clone().add(1, 'h');
        if (isValid(newDate, 'h')) {
          setValue(newDate);
        }
      },

      incrementMinutes: function incrementMinutes() {
        var newDate = date.clone().add(options.stepping, 'm');
        if (isValid(newDate, 'm')) {
          setValue(newDate);
        }
      },

      incrementSeconds: function incrementSeconds() {
        var newDate = date.clone().add(1, 's');
        if (isValid(newDate, 's')) {
          setValue(newDate);
        }
      },

      decrementHours: function decrementHours() {
        var newDate = date.clone().subtract(1, 'h');
        if (isValid(newDate, 'h')) {
          setValue(newDate);
        }
      },

      decrementMinutes: function decrementMinutes() {
        var newDate = date.clone().subtract(options.stepping, 'm');
        if (isValid(newDate, 'm')) {
          setValue(newDate);
        }
      },

      decrementSeconds: function decrementSeconds() {
        var newDate = date.clone().subtract(1, 's');
        if (isValid(newDate, 's')) {
          setValue(newDate);
        }
      },

      togglePeriod: function togglePeriod() {
        setValue(date.clone().add(date.hours() >= 12 ? -12 : 12, 'h'));
      },

      togglePicker: function togglePicker(e) {
        var $this = $(e.target),
            $parent = $this.closest('ul'),
            expanded = $parent.find('.show'),
            closed = $parent.find('.collapse:not(.show)');
        var collapseData = void 0;

        if (expanded && expanded.length) {
          collapseData = expanded.data('collapse');
          if (collapseData && collapseData.transitioning) {
            return;
          }
          if (expanded.collapse) {
            // if collapse plugin is available through bootstrap.js then use it
            expanded.collapse('hide');
            closed.collapse('show');
          } else {
            // otherwise just toggle in class on the two views
            expanded.removeClass('show');
            closed.addClass('show');
          }
          if ($this.is('span')) {
            $this.toggleClass(options.icons.time + ' ' + options.icons.date);
          } else {
            $this.find('span').toggleClass(options.icons.time + ' ' + options.icons.date);
          }

          // NOTE: uncomment if toggled state will be restored in show()
          //if (component) {
          //    component.find('span').toggleClass(options.icons.time + ' ' + options.icons.date);
          //}
        }
      },

      showPicker: function showPicker() {
        widget.find('.timepicker > div:not(.timepicker-picker)').hide();
        widget.find('.timepicker .timepicker-picker').show();
      },

      showHours: function showHours() {
        widget.find('.timepicker .timepicker-picker').hide();
        widget.find('.timepicker .timepicker-hours').show();
      },

      showMinutes: function showMinutes() {
        widget.find('.timepicker .timepicker-picker').hide();
        widget.find('.timepicker .timepicker-minutes').show();
      },

      showSeconds: function showSeconds() {
        widget.find('.timepicker .timepicker-picker').hide();
        widget.find('.timepicker .timepicker-seconds').show();
      },

      selectHour: function selectHour(e) {
        var hour = parseInt($(e.target).text(), 10);

        if (!use24Hours) {
          if (date.hours() >= 12) {
            if (hour !== 12) {
              hour += 12;
            }
          } else {
            if (hour === 12) {
              hour = 0;
            }
          }
        }
        setValue(date.clone().hours(hour));
        actions.showPicker.call(picker);
      },

      selectMinute: function selectMinute(e) {
        setValue(date.clone().minutes(parseInt($(e.target).text(), 10)));
        actions.showPicker.call(picker);
      },

      selectSecond: function selectSecond(e) {
        setValue(date.clone().seconds(parseInt($(e.target).text(), 10)));
        actions.showPicker.call(picker);
      },

      clear: clear,

      today: function today() {
        var todaysDate = getMoment();
        if (isValid(todaysDate, 'd')) {
          setValue(todaysDate);
        }
      },

      close: hide
    },
        doAction = function doAction(e) {
      if ($(e.currentTarget).is('.disabled')) {
        return false;
      }
      actions[$(e.currentTarget).data('action')].apply(picker, arguments);
      return false;
    },

    /**
     * Shows the widget. Possibly will emit dp.show and dp.change
     */
    show = function show() {
      var currentMoment = void 0;
      var useCurrentGranularity = {
        year: function year(m) {
          return m.month(0).date(1).hours(0).seconds(0).minutes(0);
        },
        month: function month(m) {
          return m.date(1).hours(0).seconds(0).minutes(0);
        },
        day: function day(m) {
          return m.hours(0).seconds(0).minutes(0);
        },
        hour: function hour(m) {
          return m.seconds(0).minutes(0);
        },
        minute: function minute(m) {
          return m.seconds(0);
        }
      };

      if (input.prop('disabled') || !options.ignoreReadonly && input.prop('readonly') || widget) {
        return picker;
      }
      if (input.val() !== undefined && input.val().trim().length !== 0) {
        setValue(parseInputDate(input.val().trim()));
      } else if (unset && options.useCurrent && (options.inline || input.is('input') && input.val().trim().length === 0)) {
        currentMoment = getMoment();
        if (typeof options.useCurrent === 'string') {
          currentMoment = useCurrentGranularity[options.useCurrent](currentMoment);
        }
        setValue(currentMoment);
      }
      widget = getTemplate();

      fillDow();
      fillMonths();

      widget.find('.timepicker-hours').hide();
      widget.find('.timepicker-minutes').hide();
      widget.find('.timepicker-seconds').hide();

      update();
      showMode();

      $(window).on('resize', place);
      widget.on('click', '[data-action]', doAction); // this handles clicks on the widget
      widget.on('mousedown', false);

      if (component && component.hasClass('btn')) {
        component.toggleClass('active');
      }
      place();
      widget.show();
      if (options.focusOnShow && !input.is(':focus')) {
        input.focus();
      }

      notifyEvent({
        type: 'dp.show'
      });
      return picker;
    },

    /**
     * Shows or hides the widget
     */
    toggle = function toggle() {
      return widget ? hide() : show();
    },
        keydown = function keydown(e) {
      var handler = null,
          index = void 0,
          index2 = void 0;
      var pressedKeys = [],
          pressedModifiers = {},
          currentKey = e.which;
      var keyBindKeys = void 0,
          allModifiersPressed = void 0;
      var pressed = 'p';

      keyState[currentKey] = pressed;

      for (index in keyState) {
        if (keyState.hasOwnProperty(index) && keyState[index] === pressed) {
          pressedKeys.push(index);
          if (parseInt(index, 10) !== currentKey) {
            pressedModifiers[index] = true;
          }
        }
      }

      for (index in options.keyBinds) {
        if (options.keyBinds.hasOwnProperty(index) && typeof options.keyBinds[index] === 'function') {
          keyBindKeys = index.split(' ');
          if (keyBindKeys.length === pressedKeys.length && keyMap[currentKey] === keyBindKeys[keyBindKeys.length - 1]) {
            allModifiersPressed = true;
            for (index2 = keyBindKeys.length - 2; index2 >= 0; index2--) {
              if (!(keyMap[keyBindKeys[index2]] in pressedModifiers)) {
                allModifiersPressed = false;
                break;
              }
            }
            if (allModifiersPressed) {
              handler = options.keyBinds[index];
              break;
            }
          }
        }
      }

      if (handler) {
        handler.call(picker, widget);
        e.stopPropagation();
        e.preventDefault();
      }
    },
        keyup = function keyup(e) {
      keyState[e.which] = 'r';
      e.stopPropagation();
      e.preventDefault();
    },
        change = function change(e) {
      var val = $(e.target).val().trim(),
          parsedDate = val ? parseInputDate(val) : null;
      setValue(parsedDate);
      e.stopImmediatePropagation();
      return false;
    },
        attachDatePickerElementEvents = function attachDatePickerElementEvents() {
      input.on({
        change: change,
        blur: options.debug ? '' : hide,
        keydown: keydown,
        keyup: keyup,
        focus: options.allowInputToggle ? show : ''
      });

      if (element.is('input')) {
        input.on({
          focus: show
        });
      } else if (component) {
        component.on('click', toggle);
        component.on('mousedown', false);
      }
    },
        detachDatePickerElementEvents = function detachDatePickerElementEvents() {
      input.off({
        change: change,
        blur: blur,
        keydown: keydown,
        keyup: keyup,
        focus: options.allowInputToggle ? hide : ''
      });

      if (element.is('input')) {
        input.off({
          focus: show
        });
      } else if (component) {
        component.off('click', toggle);
        component.off('mousedown', false);
      }
    },
        indexGivenDates = function indexGivenDates(givenDatesArray) {
      // Store given enabledDates and disabledDates as keys.
      // This way we can check their existence in O(1) time instead of looping through whole array.
      // (for example: options.enabledDates['2014-02-27'] === true)
      var givenDatesIndexed = {};
      $.each(givenDatesArray, function () {
        var dDate = parseInputDate(this);
        if (dDate.isValid()) {
          givenDatesIndexed[dDate.format('YYYY-MM-DD')] = true;
        }
      });
      return Object.keys(givenDatesIndexed).length ? givenDatesIndexed : false;
    },
        indexGivenHours = function indexGivenHours(givenHoursArray) {
      // Store given enabledHours and disabledHours as keys.
      // This way we can check their existence in O(1) time instead of looping through whole array.
      // (for example: options.enabledHours['2014-02-27'] === true)
      var givenHoursIndexed = {};
      $.each(givenHoursArray, function () {
        givenHoursIndexed[this] = true;
      });
      return Object.keys(givenHoursIndexed).length ? givenHoursIndexed : false;
    },
        initFormatting = function initFormatting() {
      var format = options.format || 'L LT';

      actualFormat = format.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g, function (formatInput) {
        var newinput = date.localeData().longDateFormat(formatInput) || formatInput;
        return newinput.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g, function (formatInput2) {
          //temp fix for #740
          return date.localeData().longDateFormat(formatInput2) || formatInput2;
        });
      });

      parseFormats = options.extraFormats ? options.extraFormats.slice() : [];
      if (parseFormats.indexOf(format) < 0 && parseFormats.indexOf(actualFormat) < 0) {
        parseFormats.push(actualFormat);
      }

      use24Hours = actualFormat.toLowerCase().indexOf('a') < 1 && actualFormat.replace(/\[.*?\]/g, '').indexOf('h') < 1;

      if (isEnabled('y')) {
        minViewModeNumber = 2;
      }
      if (isEnabled('M')) {
        minViewModeNumber = 1;
      }
      if (isEnabled('d')) {
        minViewModeNumber = 0;
      }

      currentViewMode = Math.max(minViewModeNumber, currentViewMode);

      if (!unset) {
        setValue(date);
      }
    };

    /********************************************************************************
     *
     * Public API functions
     * =====================
     *
     * Important: Do not expose direct references to private objects or the options
     * object to the outer world. Always return a clone when returning values or make
     * a clone when setting a private variable.
     *
     ********************************************************************************/
    picker.destroy = function () {
      ///<summary>Destroys the widget and removes all attached event listeners</summary>
      hide();
      detachDatePickerElementEvents();
      element.removeData('DateTimePicker');
      element.removeData('date');
    };

    picker.toggle = toggle;

    picker.show = show;

    picker.hide = hide;

    picker.disable = function () {
      ///<summary>Disables the input element, the component is attached to, by adding a disabled="true" attribute to it.
      ///If the widget was visible before that call it is hidden. Possibly emits dp.hide</summary>
      hide();
      if (component && component.hasClass('btn')) {
        component.addClass('disabled');
      }
      input.prop('disabled', true);
      return picker;
    };

    picker.enable = function () {
      ///<summary>Enables the input element, the component is attached to, by removing disabled attribute from it.</summary>
      if (component && component.hasClass('btn')) {
        component.removeClass('disabled');
      }
      input.prop('disabled', false);
      return picker;
    };

    picker.ignoreReadonly = function (ignoreReadonly) {
      if (arguments.length === 0) {
        return options.ignoreReadonly;
      }
      if (typeof ignoreReadonly !== 'boolean') {
        throw new TypeError('ignoreReadonly () expects a boolean parameter');
      }
      options.ignoreReadonly = ignoreReadonly;
      return picker;
    };

    picker.options = function (newOptions) {
      if (arguments.length === 0) {
        return $.extend(true, {}, options);
      }

      if (!(newOptions instanceof Object)) {
        throw new TypeError('options() options parameter should be an object');
      }
      $.extend(true, options, newOptions);
      $.each(options, function (key, value) {
        if (picker[key] !== undefined) {
          picker[key](value);
        } else {
          throw new TypeError('option ' + key + ' is not recognized!');
        }
      });
      return picker;
    };

    picker.date = function (newDate) {
      ///<signature helpKeyword="$.fn.datetimepicker.date">
      ///<summary>Returns the component's model current date, a moment object or null if not set.</summary>
      ///<returns type="Moment">date.clone()</returns>
      ///</signature>
      ///<signature>
      ///<summary>Sets the components model current moment to it. Passing a null value unsets the components model current moment. Parsing of the newDate parameter is made using moment library with the options.format and options.useStrict components configuration.</summary>
      ///<param name="newDate" locid="$.fn.datetimepicker.date_p:newDate">Takes string, Date, moment, null parameter.</param>
      ///</signature>
      if (arguments.length === 0) {
        if (unset) {
          return null;
        }
        return date.clone();
      }

      if (newDate !== null && typeof newDate !== 'string' && !moment.isMoment(newDate) && !(newDate instanceof Date)) {
        throw new TypeError('date() parameter must be one of [null, string, moment or Date]');
      }

      setValue(newDate === null ? null : parseInputDate(newDate));
      return picker;
    };

    picker.format = function (newFormat) {
      ///<summary>test su</summary>
      ///<param name="newFormat">info about para</param>
      ///<returns type="string|boolean">returns foo</returns>
      if (arguments.length === 0) {
        return options.format;
      }

      if (typeof newFormat !== 'string' && (typeof newFormat !== 'boolean' || newFormat !== false)) {
        throw new TypeError('format() expects a string or boolean:false parameter ' + newFormat);
      }

      options.format = newFormat;
      if (actualFormat) {
        initFormatting(); // reinit formatting
      }
      return picker;
    };

    picker.timeZone = function (newZone) {
      if (arguments.length === 0) {
        return options.timeZone;
      }

      if (typeof newZone !== 'string') {
        throw new TypeError('newZone() expects a string parameter');
      }

      options.timeZone = newZone;

      return picker;
    };

    picker.dayViewHeaderFormat = function (newFormat) {
      if (arguments.length === 0) {
        return options.dayViewHeaderFormat;
      }

      if (typeof newFormat !== 'string') {
        throw new TypeError('dayViewHeaderFormat() expects a string parameter');
      }

      options.dayViewHeaderFormat = newFormat;
      return picker;
    };

    picker.extraFormats = function (formats) {
      if (arguments.length === 0) {
        return options.extraFormats;
      }

      if (formats !== false && !(formats instanceof Array)) {
        throw new TypeError('extraFormats() expects an array or false parameter');
      }

      options.extraFormats = formats;
      if (parseFormats) {
        initFormatting(); // reinit formatting
      }
      return picker;
    };

    picker.disabledDates = function (dates) {
      ///<signature helpKeyword="$.fn.datetimepicker.disabledDates">
      ///<summary>Returns an array with the currently set disabled dates on the component.</summary>
      ///<returns type="array">options.disabledDates</returns>
      ///</signature>
      ///<signature>
      ///<summary>Setting this takes precedence over options.minDate, options.maxDate configuration. Also calling this function removes the configuration of
      ///options.enabledDates if such exist.</summary>
      ///<param name="dates" locid="$.fn.datetimepicker.disabledDates_p:dates">Takes an [ string or Date or moment ] of values and allows the user to select only from those days.</param>
      ///</signature>
      if (arguments.length === 0) {
        return options.disabledDates ? $.extend({}, options.disabledDates) : options.disabledDates;
      }

      if (!dates) {
        options.disabledDates = false;
        update();
        return picker;
      }
      if (!(dates instanceof Array)) {
        throw new TypeError('disabledDates() expects an array parameter');
      }
      options.disabledDates = indexGivenDates(dates);
      options.enabledDates = false;
      update();
      return picker;
    };

    picker.enabledDates = function (dates) {
      ///<signature helpKeyword="$.fn.datetimepicker.enabledDates">
      ///<summary>Returns an array with the currently set enabled dates on the component.</summary>
      ///<returns type="array">options.enabledDates</returns>
      ///</signature>
      ///<signature>
      ///<summary>Setting this takes precedence over options.minDate, options.maxDate configuration. Also calling this function removes the configuration of options.disabledDates if such exist.</summary>
      ///<param name="dates" locid="$.fn.datetimepicker.enabledDates_p:dates">Takes an [ string or Date or moment ] of values and allows the user to select only from those days.</param>
      ///</signature>
      if (arguments.length === 0) {
        return options.enabledDates ? $.extend({}, options.enabledDates) : options.enabledDates;
      }

      if (!dates) {
        options.enabledDates = false;
        update();
        return picker;
      }
      if (!(dates instanceof Array)) {
        throw new TypeError('enabledDates() expects an array parameter');
      }
      options.enabledDates = indexGivenDates(dates);
      options.disabledDates = false;
      update();
      return picker;
    };

    picker.daysOfWeekDisabled = function (daysOfWeekDisabled) {
      if (arguments.length === 0) {
        return options.daysOfWeekDisabled.splice(0);
      }

      if (typeof daysOfWeekDisabled === 'boolean' && !daysOfWeekDisabled) {
        options.daysOfWeekDisabled = false;
        update();
        return picker;
      }

      if (!(daysOfWeekDisabled instanceof Array)) {
        throw new TypeError('daysOfWeekDisabled() expects an array parameter');
      }
      options.daysOfWeekDisabled = daysOfWeekDisabled.reduce(function (previousValue, currentValue) {
        currentValue = parseInt(currentValue, 10);
        if (currentValue > 6 || currentValue < 0 || isNaN(currentValue)) {
          return previousValue;
        }
        if (previousValue.indexOf(currentValue) === -1) {
          previousValue.push(currentValue);
        }
        return previousValue;
      }, []).sort();
      if (options.useCurrent && !options.keepInvalid) {
        var tries = 0;
        while (!isValid(date, 'd')) {
          date.add(1, 'd');
          if (tries === 31) {
            throw 'Tried 31 times to find a valid date';
          }
          tries++;
        }
        setValue(date);
      }
      update();
      return picker;
    };

    picker.maxDate = function (maxDate) {
      if (arguments.length === 0) {
        return options.maxDate ? options.maxDate.clone() : options.maxDate;
      }

      if (typeof maxDate === 'boolean' && maxDate === false) {
        options.maxDate = false;
        update();
        return picker;
      }

      if (typeof maxDate === 'string') {
        if (maxDate === 'now' || maxDate === 'moment') {
          maxDate = getMoment();
        }
      }

      var parsedDate = parseInputDate(maxDate);

      if (!parsedDate.isValid()) {
        throw new TypeError('maxDate() Could not parse date parameter: ' + maxDate);
      }
      if (options.minDate && parsedDate.isBefore(options.minDate)) {
        throw new TypeError('maxDate() date parameter is before options.minDate: ' + parsedDate.format(actualFormat));
      }
      options.maxDate = parsedDate;
      if (options.useCurrent && !options.keepInvalid && date.isAfter(maxDate)) {
        setValue(options.maxDate);
      }
      if (viewDate.isAfter(parsedDate)) {
        viewDate = parsedDate.clone().subtract(options.stepping, 'm');
      }
      update();
      return picker;
    };

    picker.minDate = function (minDate) {
      if (arguments.length === 0) {
        return options.minDate ? options.minDate.clone() : options.minDate;
      }

      if (typeof minDate === 'boolean' && minDate === false) {
        options.minDate = false;
        update();
        return picker;
      }

      if (typeof minDate === 'string') {
        if (minDate === 'now' || minDate === 'moment') {
          minDate = getMoment();
        }
      }

      var parsedDate = parseInputDate(minDate);

      if (!parsedDate.isValid()) {
        throw new TypeError('minDate() Could not parse date parameter: ' + minDate);
      }
      if (options.maxDate && parsedDate.isAfter(options.maxDate)) {
        throw new TypeError('minDate() date parameter is after options.maxDate: ' + parsedDate.format(actualFormat));
      }
      options.minDate = parsedDate;
      if (options.useCurrent && !options.keepInvalid && date.isBefore(minDate)) {
        setValue(options.minDate);
      }
      if (viewDate.isBefore(parsedDate)) {
        viewDate = parsedDate.clone().add(options.stepping, 'm');
      }
      update();
      return picker;
    };

    picker.defaultDate = function (defaultDate) {
      ///<signature helpKeyword="$.fn.datetimepicker.defaultDate">
      ///<summary>Returns a moment with the options.defaultDate option configuration or false if not set</summary>
      ///<returns type="Moment">date.clone()</returns>
      ///</signature>
      ///<signature>
      ///<summary>Will set the picker's inital date. If a boolean:false value is passed the options.defaultDate parameter is cleared.</summary>
      ///<param name="defaultDate" locid="$.fn.datetimepicker.defaultDate_p:defaultDate">Takes a string, Date, moment, boolean:false</param>
      ///</signature>
      if (arguments.length === 0) {
        return options.defaultDate ? options.defaultDate.clone() : options.defaultDate;
      }
      if (!defaultDate) {
        options.defaultDate = false;
        return picker;
      }

      if (typeof defaultDate === 'string') {
        if (defaultDate === 'now' || defaultDate === 'moment') {
          defaultDate = getMoment();
        } else {
          defaultDate = getMoment(defaultDate);
        }
      }

      var parsedDate = parseInputDate(defaultDate);
      if (!parsedDate.isValid()) {
        throw new TypeError('defaultDate() Could not parse date parameter: ' + defaultDate);
      }
      if (!isValid(parsedDate)) {
        throw new TypeError('defaultDate() date passed is invalid according to component setup validations');
      }

      options.defaultDate = parsedDate;

      if (options.defaultDate && options.inline || input.val().trim() === '') {
        setValue(options.defaultDate);
      }
      return picker;
    };

    picker.locale = function (locale) {
      if (arguments.length === 0) {
        return options.locale;
      }

      if (!moment.localeData(locale)) {
        throw new TypeError('locale() locale ' + locale + ' is not loaded from moment locales!');
      }

      options.locale = locale;
      date.locale(options.locale);
      viewDate.locale(options.locale);

      if (actualFormat) {
        initFormatting(); // reinit formatting
      }
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.stepping = function (stepping) {
      if (arguments.length === 0) {
        return options.stepping;
      }

      stepping = parseInt(stepping, 10);
      if (isNaN(stepping) || stepping < 1) {
        stepping = 1;
      }
      options.stepping = stepping;
      return picker;
    };

    picker.useCurrent = function (useCurrent) {
      var useCurrentOptions = ['year', 'month', 'day', 'hour', 'minute'];
      if (arguments.length === 0) {
        return options.useCurrent;
      }

      if (typeof useCurrent !== 'boolean' && typeof useCurrent !== 'string') {
        throw new TypeError('useCurrent() expects a boolean or string parameter');
      }
      if (typeof useCurrent === 'string' && useCurrentOptions.indexOf(useCurrent.toLowerCase()) === -1) {
        throw new TypeError('useCurrent() expects a string parameter of ' + useCurrentOptions.join(', '));
      }
      options.useCurrent = useCurrent;
      return picker;
    };

    picker.collapse = function (collapse) {
      if (arguments.length === 0) {
        return options.collapse;
      }

      if (typeof collapse !== 'boolean') {
        throw new TypeError('collapse() expects a boolean parameter');
      }
      if (options.collapse === collapse) {
        return picker;
      }
      options.collapse = collapse;
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.icons = function (icons) {
      if (arguments.length === 0) {
        return $.extend({}, options.icons);
      }

      if (!(icons instanceof Object)) {
        throw new TypeError('icons() expects parameter to be an Object');
      }
      $.extend(options.icons, icons);
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.tooltips = function (tooltips) {
      if (arguments.length === 0) {
        return $.extend({}, options.tooltips);
      }

      if (!(tooltips instanceof Object)) {
        throw new TypeError('tooltips() expects parameter to be an Object');
      }
      $.extend(options.tooltips, tooltips);
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.useStrict = function (useStrict) {
      if (arguments.length === 0) {
        return options.useStrict;
      }

      if (typeof useStrict !== 'boolean') {
        throw new TypeError('useStrict() expects a boolean parameter');
      }
      options.useStrict = useStrict;
      return picker;
    };

    picker.sideBySide = function (sideBySide) {
      if (arguments.length === 0) {
        return options.sideBySide;
      }

      if (typeof sideBySide !== 'boolean') {
        throw new TypeError('sideBySide() expects a boolean parameter');
      }
      options.sideBySide = sideBySide;
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.viewMode = function (viewMode) {
      if (arguments.length === 0) {
        return options.viewMode;
      }

      if (typeof viewMode !== 'string') {
        throw new TypeError('viewMode() expects a string parameter');
      }

      if (viewModes.indexOf(viewMode) === -1) {
        throw new TypeError('viewMode() parameter must be one of (' + viewModes.join(', ') + ') value');
      }

      options.viewMode = viewMode;
      currentViewMode = Math.max(viewModes.indexOf(viewMode), minViewModeNumber);

      showMode();
      return picker;
    };

    picker.toolbarPlacement = function (toolbarPlacement) {
      if (arguments.length === 0) {
        return options.toolbarPlacement;
      }

      if (typeof toolbarPlacement !== 'string') {
        throw new TypeError('toolbarPlacement() expects a string parameter');
      }
      if (toolbarPlacements.indexOf(toolbarPlacement) === -1) {
        throw new TypeError('toolbarPlacement() parameter must be one of (' + toolbarPlacements.join(', ') + ') value');
      }
      options.toolbarPlacement = toolbarPlacement;

      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.widgetPositioning = function (widgetPositioning) {
      if (arguments.length === 0) {
        return $.extend({}, options.widgetPositioning);
      }

      if ({}.toString.call(widgetPositioning) !== '[object Object]') {
        throw new TypeError('widgetPositioning() expects an object variable');
      }
      if (widgetPositioning.horizontal) {
        if (typeof widgetPositioning.horizontal !== 'string') {
          throw new TypeError('widgetPositioning() horizontal variable must be a string');
        }
        widgetPositioning.horizontal = widgetPositioning.horizontal.toLowerCase();
        if (horizontalModes.indexOf(widgetPositioning.horizontal) === -1) {
          throw new TypeError('widgetPositioning() expects horizontal parameter to be one of (' + horizontalModes.join(', ') + ')');
        }
        options.widgetPositioning.horizontal = widgetPositioning.horizontal;
      }
      if (widgetPositioning.vertical) {
        if (typeof widgetPositioning.vertical !== 'string') {
          throw new TypeError('widgetPositioning() vertical variable must be a string');
        }
        widgetPositioning.vertical = widgetPositioning.vertical.toLowerCase();
        if (verticalModes.indexOf(widgetPositioning.vertical) === -1) {
          throw new TypeError('widgetPositioning() expects vertical parameter to be one of (' + verticalModes.join(', ') + ')');
        }
        options.widgetPositioning.vertical = widgetPositioning.vertical;
      }
      update();
      return picker;
    };

    picker.calendarWeeks = function (calendarWeeks) {
      if (arguments.length === 0) {
        return options.calendarWeeks;
      }

      if (typeof calendarWeeks !== 'boolean') {
        throw new TypeError('calendarWeeks() expects parameter to be a boolean value');
      }

      options.calendarWeeks = calendarWeeks;
      update();
      return picker;
    };

    picker.showTodayButton = function (showTodayButton) {
      if (arguments.length === 0) {
        return options.showTodayButton;
      }

      if (typeof showTodayButton !== 'boolean') {
        throw new TypeError('showTodayButton() expects a boolean parameter');
      }

      options.showTodayButton = showTodayButton;
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.showClear = function (showClear) {
      if (arguments.length === 0) {
        return options.showClear;
      }

      if (typeof showClear !== 'boolean') {
        throw new TypeError('showClear() expects a boolean parameter');
      }

      options.showClear = showClear;
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.widgetParent = function (widgetParent) {
      if (arguments.length === 0) {
        return options.widgetParent;
      }

      if (typeof widgetParent === 'string') {
        widgetParent = $(widgetParent);
      }

      if (widgetParent !== null && typeof widgetParent !== 'string' && !(widgetParent instanceof $)) {
        throw new TypeError('widgetParent() expects a string or a jQuery object parameter');
      }

      options.widgetParent = widgetParent;
      if (widget) {
        hide();
        show();
      }
      return picker;
    };

    picker.keepOpen = function (keepOpen) {
      if (arguments.length === 0) {
        return options.keepOpen;
      }

      if (typeof keepOpen !== 'boolean') {
        throw new TypeError('keepOpen() expects a boolean parameter');
      }

      options.keepOpen = keepOpen;
      return picker;
    };

    picker.focusOnShow = function (focusOnShow) {
      if (arguments.length === 0) {
        return options.focusOnShow;
      }

      if (typeof focusOnShow !== 'boolean') {
        throw new TypeError('focusOnShow() expects a boolean parameter');
      }

      options.focusOnShow = focusOnShow;
      return picker;
    };

    picker.inline = function (inline) {
      if (arguments.length === 0) {
        return options.inline;
      }

      if (typeof inline !== 'boolean') {
        throw new TypeError('inline() expects a boolean parameter');
      }

      options.inline = inline;
      return picker;
    };

    picker.clear = function () {
      clear();
      return picker;
    };

    picker.keyBinds = function (keyBinds) {
      if (arguments.length === 0) {
        return options.keyBinds;
      }

      options.keyBinds = keyBinds;
      return picker;
    };

    picker.getMoment = function (d) {
      return getMoment(d);
    };

    picker.debug = function (debug) {
      if (typeof debug !== 'boolean') {
        throw new TypeError('debug() expects a boolean parameter');
      }

      options.debug = debug;
      return picker;
    };

    picker.allowInputToggle = function (allowInputToggle) {
      if (arguments.length === 0) {
        return options.allowInputToggle;
      }

      if (typeof allowInputToggle !== 'boolean') {
        throw new TypeError('allowInputToggle() expects a boolean parameter');
      }

      options.allowInputToggle = allowInputToggle;
      return picker;
    };

    picker.showClose = function (showClose) {
      if (arguments.length === 0) {
        return options.showClose;
      }

      if (typeof showClose !== 'boolean') {
        throw new TypeError('showClose() expects a boolean parameter');
      }

      options.showClose = showClose;
      return picker;
    };

    picker.keepInvalid = function (keepInvalid) {
      if (arguments.length === 0) {
        return options.keepInvalid;
      }

      if (typeof keepInvalid !== 'boolean') {
        throw new TypeError('keepInvalid() expects a boolean parameter');
      }
      options.keepInvalid = keepInvalid;
      return picker;
    };

    picker.datepickerInput = function (datepickerInput) {
      if (arguments.length === 0) {
        return options.datepickerInput;
      }

      if (typeof datepickerInput !== 'string') {
        throw new TypeError('datepickerInput() expects a string parameter');
      }

      options.datepickerInput = datepickerInput;
      return picker;
    };

    picker.parseInputDate = function (parseInputDate) {
      if (arguments.length === 0) {
        return options.parseInputDate;
      }

      if (typeof parseInputDate !== 'function') {
        throw new TypeError('parseInputDate() sholud be as function');
      }

      options.parseInputDate = parseInputDate;

      return picker;
    };

    picker.disabledTimeIntervals = function (disabledTimeIntervals) {
      ///<signature helpKeyword="$.fn.datetimepicker.disabledTimeIntervals">
      ///<summary>Returns an array with the currently set disabled dates on the component.</summary>
      ///<returns type="array">options.disabledTimeIntervals</returns>
      ///</signature>
      ///<signature>
      ///<summary>Setting this takes precedence over options.minDate, options.maxDate configuration. Also calling this function removes the configuration of
      ///options.enabledDates if such exist.</summary>
      ///<param name="dates" locid="$.fn.datetimepicker.disabledTimeIntervals_p:dates">Takes an [ string or Date or moment ] of values and allows the user to select only from those days.</param>
      ///</signature>
      if (arguments.length === 0) {
        return options.disabledTimeIntervals ? $.extend({}, options.disabledTimeIntervals) : options.disabledTimeIntervals;
      }

      if (!disabledTimeIntervals) {
        options.disabledTimeIntervals = false;
        update();
        return picker;
      }
      if (!(disabledTimeIntervals instanceof Array)) {
        throw new TypeError('disabledTimeIntervals() expects an array parameter');
      }
      options.disabledTimeIntervals = disabledTimeIntervals;
      update();
      return picker;
    };

    picker.disabledHours = function (hours) {
      ///<signature helpKeyword="$.fn.datetimepicker.disabledHours">
      ///<summary>Returns an array with the currently set disabled hours on the component.</summary>
      ///<returns type="array">options.disabledHours</returns>
      ///</signature>
      ///<signature>
      ///<summary>Setting this takes precedence over options.minDate, options.maxDate configuration. Also calling this function removes the configuration of
      ///options.enabledHours if such exist.</summary>
      ///<param name="hours" locid="$.fn.datetimepicker.disabledHours_p:hours">Takes an [ int ] of values and disallows the user to select only from those hours.</param>
      ///</signature>
      if (arguments.length === 0) {
        return options.disabledHours ? $.extend({}, options.disabledHours) : options.disabledHours;
      }

      if (!hours) {
        options.disabledHours = false;
        update();
        return picker;
      }
      if (!(hours instanceof Array)) {
        throw new TypeError('disabledHours() expects an array parameter');
      }
      options.disabledHours = indexGivenHours(hours);
      options.enabledHours = false;
      if (options.useCurrent && !options.keepInvalid) {
        var tries = 0;
        while (!isValid(date, 'h')) {
          date.add(1, 'h');
          if (tries === 24) {
            throw 'Tried 24 times to find a valid date';
          }
          tries++;
        }
        setValue(date);
      }
      update();
      return picker;
    };

    picker.enabledHours = function (hours) {
      ///<signature helpKeyword="$.fn.datetimepicker.enabledHours">
      ///<summary>Returns an array with the currently set enabled hours on the component.</summary>
      ///<returns type="array">options.enabledHours</returns>
      ///</signature>
      ///<signature>
      ///<summary>Setting this takes precedence over options.minDate, options.maxDate configuration. Also calling this function removes the configuration of options.disabledHours if such exist.</summary>
      ///<param name="hours" locid="$.fn.datetimepicker.enabledHours_p:hours">Takes an [ int ] of values and allows the user to select only from those hours.</param>
      ///</signature>
      if (arguments.length === 0) {
        return options.enabledHours ? $.extend({}, options.enabledHours) : options.enabledHours;
      }

      if (!hours) {
        options.enabledHours = false;
        update();
        return picker;
      }
      if (!(hours instanceof Array)) {
        throw new TypeError('enabledHours() expects an array parameter');
      }
      options.enabledHours = indexGivenHours(hours);
      options.disabledHours = false;
      if (options.useCurrent && !options.keepInvalid) {
        var tries = 0;
        while (!isValid(date, 'h')) {
          date.add(1, 'h');
          if (tries === 24) {
            throw 'Tried 24 times to find a valid date';
          }
          tries++;
        }
        setValue(date);
      }
      update();
      return picker;
    };
    /**
     * Returns the component's model current viewDate, a moment object or null if not set. Passing a null value unsets the components model current moment. Parsing of the newDate parameter is made using moment library with the options.format and options.useStrict components configuration.
     * @param {Takes string, viewDate, moment, null parameter.} newDate
     * @returns {viewDate.clone()}
     */
    picker.viewDate = function (newDate) {
      if (arguments.length === 0) {
        return viewDate.clone();
      }

      if (!newDate) {
        viewDate = date.clone();
        return picker;
      }

      if (typeof newDate !== 'string' && !moment.isMoment(newDate) && !(newDate instanceof Date)) {
        throw new TypeError('viewDate() parameter must be one of [string, moment or Date]');
      }

      viewDate = parseInputDate(newDate);
      viewUpdate();
      return picker;
    };

    // initializing element and component attributes
    if (element.is('input')) {
      input = element;
    } else {
      input = element.find(options.datepickerInput);
      if (input.length === 0) {
        input = element.find('input');
      } else if (!input.is('input')) {
        throw new Error('CSS class "' + options.datepickerInput + '" cannot be applied to non input element');
      }
    }

    if (element.hasClass('input-group')) {
      // in case there is more then one 'input-group-addon' Issue #48
      if (element.find('.datepickerbutton').length === 0) {
        component = element.find('.input-group-addon');
      } else {
        component = element.find('.datepickerbutton');
      }
    }

    if (!options.inline && !input.is('input')) {
      throw new Error('Could not initialize DateTimePicker without an input element');
    }

    // Set defaults for date here now instead of in var declaration
    date = getMoment();
    viewDate = date.clone();

    $.extend(true, options, dataToOptions());

    picker.options(options);

    initFormatting();

    attachDatePickerElementEvents();

    if (input.prop('disabled')) {
      picker.disable();
    }
    if (input.is('input') && input.val().trim().length !== 0) {
      setValue(parseInputDate(input.val().trim()));
    } else if (options.defaultDate && input.attr('placeholder') === undefined) {
      setValue(options.defaultDate);
    }
    if (options.inline) {
      show();
    }
    return picker;
  };

  /********************************************************************************
   *
   * jQuery plugin constructor and defaults object
   *
   ********************************************************************************/

  /**
   * See (http://jquery.com/).
   * @name jQuery
   * @class
   * See the jQuery Library  (http://jquery.com/) for full details.  This just
   * documents the function and classes that are added to jQuery by this plug-in.
   */
  /**
   * See (http://jquery.com/)
   * @name fn
   * @class
   * See the jQuery Library  (http://jquery.com/) for full details.  This just
   * documents the function and classes that are added to jQuery by this plug-in.
   * @memberOf jQuery
   */
  /**
   * Show comments
   * @class datetimepicker
   * @memberOf jQuery.fn
   */
  $.fn.datetimepicker = function (options) {
    options = options || {};

    var args = Array.prototype.slice.call(arguments, 1);
    var isInstance = true;
    var thisMethods = ['destroy', 'hide', 'show', 'toggle'];
    var returnValue = void 0;

    if ((typeof options === 'undefined' ? 'undefined' : _typeof(options)) === 'object') {
      return this.each(function () {
        var $this = $(this);
        var _options = void 0;
        if (!$this.data('DateTimePicker')) {
          // create a private copy of the defaults object
          _options = $.extend(true, {}, $.fn.datetimepicker.defaults, options);
          $this.data('DateTimePicker', dateTimePicker($this, _options));
        }
      });
    } else if (typeof options === 'string') {
      this.each(function () {
        var $this = $(this);
        var instance = $this.data('DateTimePicker');
        if (!instance) {
          throw new Error('bootstrap-datetimepicker("' + options + '") method was called on an element that is not using DateTimePicker');
        }

        returnValue = instance[options].apply(instance, args);
        isInstance = returnValue === instance;
      });

      if (isInstance || $.inArray(options, thisMethods) > -1) {
        return this;
      }

      return returnValue;
    }

    throw new TypeError('Invalid arguments for DateTimePicker: ' + options);
  };

  $.fn.datetimepicker.defaults = {
    timeZone: '',
    format: false,
    dayViewHeaderFormat: 'MMMM YYYY',
    extraFormats: false,
    stepping: 1,
    minDate: false,
    maxDate: false,
    useCurrent: true,
    collapse: true,
    locale: moment.locale(),
    defaultDate: false,
    disabledDates: false,
    enabledDates: false,
    icons: {
      time: 'glyphicon glyphicon-time',
      date: 'glyphicon glyphicon-calendar',
      up: 'glyphicon glyphicon-chevron-up',
      down: 'glyphicon glyphicon-chevron-down',
      previous: 'glyphicon glyphicon-chevron-left',
      next: 'glyphicon glyphicon-chevron-right',
      today: 'glyphicon glyphicon-screenshot',
      clear: 'glyphicon glyphicon-trash',
      close: 'glyphicon glyphicon-remove'
    },
    tooltips: {
      today: 'Go to today',
      clear: 'Clear selection',
      close: 'Close the picker',
      selectMonth: 'Select Month',
      prevMonth: 'Previous Month',
      nextMonth: 'Next Month',
      selectYear: 'Select Year',
      prevYear: 'Previous Year',
      nextYear: 'Next Year',
      selectDecade: 'Select Decade',
      prevDecade: 'Previous Decade',
      nextDecade: 'Next Decade',
      prevCentury: 'Previous Century',
      nextCentury: 'Next Century',
      pickHour: 'Pick Hour',
      incrementHour: 'Increment Hour',
      decrementHour: 'Decrement Hour',
      pickMinute: 'Pick Minute',
      incrementMinute: 'Increment Minute',
      decrementMinute: 'Decrement Minute',
      pickSecond: 'Pick Second',
      incrementSecond: 'Increment Second',
      decrementSecond: 'Decrement Second',
      togglePeriod: 'Toggle Period',
      selectTime: 'Select Time'
    },
    useStrict: false,
    sideBySide: false,
    daysOfWeekDisabled: false,
    calendarWeeks: false,
    viewMode: 'days',
    toolbarPlacement: 'default',
    showTodayButton: false,
    showClear: false,
    showClose: false,
    widgetPositioning: {
      horizontal: 'auto',
      vertical: 'auto'
    },
    widgetParent: null,
    ignoreReadonly: false,
    keepOpen: false,
    focusOnShow: true,
    inline: false,
    keepInvalid: false,
    datepickerInput: '.datepickerinput',
    keyBinds: {
      up: function up(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(7, 'd'));
        } else {
          this.date(d.clone().add(this.stepping(), 'm'));
        }
      },
      down: function down(widget) {
        if (!widget) {
          this.show();
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(7, 'd'));
        } else {
          this.date(d.clone().subtract(this.stepping(), 'm'));
        }
      },
      'control up': function controlUp(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(1, 'y'));
        } else {
          this.date(d.clone().add(1, 'h'));
        }
      },
      'control down': function controlDown(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(1, 'y'));
        } else {
          this.date(d.clone().subtract(1, 'h'));
        }
      },
      left: function left(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(1, 'd'));
        }
      },
      right: function right(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(1, 'd'));
        }
      },
      pageUp: function pageUp(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(1, 'M'));
        }
      },
      pageDown: function pageDown(widget) {
        if (!widget) {
          return;
        }
        var d = this.date() || this.getMoment();
        if (widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(1, 'M'));
        }
      },
      enter: function enter() {
        this.hide();
      },
      escape: function escape() {
        this.hide();
      },
      //tab: function (widget) { //this break the flow of the form. disabling for now
      //    var toggle = widget.find('.picker-switch a[data-action="togglePicker"]');
      //    if(toggle.length > 0) toggle.click();
      //},
      'control space': function controlSpace(widget) {
        if (!widget) {
          return;
        }
        if (widget.find('.timepicker').is(':visible')) {
          widget.find('.btn[data-action="togglePeriod"]').click();
        }
      },
      t: function t() {
        this.date(this.getMoment());
      },
      delete: function _delete() {
        this.clear();
      }
    },
    debug: false,
    allowInputToggle: false,
    disabledTimeIntervals: false,
    disabledHours: false,
    enabledHours: false,
    viewDate: false
  };

  return $.fn.datetimepicker;
});

/***/ }),

/***/ 193:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {document.addEventListener('turbolinks:load', function () {
  $('.select2').select2({
    width: '100%',
    theme: 'bootstrap'
  });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),

/***/ 194:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {document.addEventListener('turbolinks:load', function () {
  $('.datetimepicker').datetimepicker({
    defaultDate: moment(),
    locale: $('html').attr('lang'),
    icons: {
      time: 'icon-clock',
      date: 'icon-event',
      up: 'icon-arrow-up',
      down: 'icon-arrow-down',
      right: 'icon-arrow-right',
      left: 'icon-arrow-left',
      previous: 'icon-arrow-left',
      next: 'icon-arrow-right',
      today: 'icon-target',
      clear: 'icon-trash',
      close: 'icon-close'
    }
  });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),

/***/ 195:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {document.addEventListener('turbolinks:load', function () {
  $('.click').click(function () {
    var target = $(this).data('target');
    var toggle = $(this).data('toggle');

    if ($(target).hasClass(toggle)) {
      $(target).removeClass(toggle);
    } else {
      $(target).addClass(toggle);
    }
  });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),

/***/ 196:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {document.addEventListener('turbolinks:load', function () {
    if (document.getElementById('post-attachment-dropzone') === null) {
        return;
    }

    var attachmentDescription = new Vue({
        el: '#modalAttachment',
        data: {
            attachment: {},
            active: null
        },
        methods: {
            loadInfo: function loadInfo(data) {
                var name = data.name + data.id;

                data.url = '/storage/' + data.path + data.name + '.' + data.extension;

                if (!this.attachment.hasOwnProperty(name)) {
                    this.attachment[name] = data;
                }
                this.active = name;
            },
            save: function save() {
                var data = this.attachment[this.active];

                $('#modalAttachment').modal('toggle');

                axios.put(platform.prefix('/systems/files/post/' + data.id), data).then();
            }
        }
    });
    Dropzone.autoDiscover = false;
    var modalAttachmentDropzone = new Dropzone('.dropzone', {
        url: platform.prefix('/systems/files'),
        method: 'post',
        uploadMultiple: false,
        parallelUploads: 100,
        maxFilesize: 9999,
        paramName: 'files',
        acceptedFiles: $('#post-attachment-dropzone').data('accepted'),
        maxThumbnailFilesize: 99999,
        previewsContainer: '.visual-dropzone',
        addRemoveLinks: false,
        dictFileTooBig: 'File is big',

        init: function init() {
            this.on('addedfile', function (e) {
                var n = Dropzone.createElement("<a href='javascript:;' class='btn-remove'><i class='icon-cross' aria-hidden='true'></i></a>");

                var t = this;
                n.addEventListener('click', function (n) {
                    n.preventDefault(), n.stopPropagation(), t.removeFile(e);
                }), e.previewElement.appendChild(n);

                var n = Dropzone.createElement("<a href='javascript:;'' class='btn-edit'><i class='icon-note' aria-hidden='true'></i></a>");

                var t = this;
                n.addEventListener('click', function (n) {
                    attachmentDescription.loadInfo(e.data);
                    $('#modalAttachment').modal('show');
                }), e.previewElement.appendChild(n);
            });

            this.on('completemultiple', function (file, json) {
                $('.sortable-dropzone').sortable('enable');
            });

            var instanceDropZone = this;

            var id = $('#post').data('post-id');
            if (id !== undefined) {

                axios.get(platform.prefix('/systems/files/post/' + id)).then(function (response) {

                    var images = response.data;

                    images.forEach(function (item) {
                        var mockFile = {
                            id: item.id,
                            name: item.original_name,
                            size: item.size,
                            type: item.mime,
                            status: Dropzone.ADDED,
                            url: '/storage/' + item.path + item.name + '.' + item.extension,
                            data: item
                        };

                        instanceDropZone.emit('addedfile', mockFile);
                        instanceDropZone.emit('thumbnail', mockFile, mockFile.url);
                        instanceDropZone.files.push(mockFile);
                        $('.dz-preview:last-child').attr('data-file-id', item.id).addClass('file-sort');
                    });

                    $('.dz-progress').remove();
                });
            }

            this.on('sending', function (file, xhr, formData) {
                formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                formData.append('storage', $('#post-attachment-dropzone').data('storage'));
            });

            this.on('removedfile', function (_ref) {
                var data = _ref.data;

                $('.files-' + data.id).remove();

                axios.delete(platform.prefix('/systems/files/' + data.id), {
                    storage: $('#post-attachment-dropzone').data('storage')
                }).then();
            });
        },
        error: function error(file, response) {
            if ($.type(response) === 'string') {
                return response; //dropzone sends it's own error messages in string
            }
            return response.message;
        },
        success: function success(file, response) {
            file.data = response;
            $('.dz-preview:last-child').attr('data-file-id', response.id).addClass('file-sort');
            $('<input type=\'hidden\' class=\'files-' + response.id + '\' name=\'files[]\' value=\'' + response.id + '\'  />').appendTo('.dropzone');
        }
    });

    $('.sortable-dropzone').sortable({
        update: function update() {
            var items = {};
            $('.file-sort').each(function (index, value) {
                var id = $(this).attr('data-file-id');
                items[id] = index;
            });

            axios.post(platform.prefix('/systems/files/sort'), {
                files: items
            }).then();
        }
    });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),

/***/ 197:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

document.addEventListener('turbolinks:load', function () {
    if (document.getElementById('filemanager') === null) {
        return;
    }

    var manager = new Vue({
        el: '#filemanager',
        data: {
            files: '',
            folders: [],
            selected_file: '',
            directories: [],
            new_filename: ''
        }
    });

    CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');

    var managerMedia = function managerMedia(o) {
        var files = $('#files');
        var options = $.extend(true, {}, o);
        this.init = function () {

            var DropzoneOptions = {
                url: options.baseUrl + '/media/upload',
                previewsContainer: '#uploadPreview',
                totaluploadprogress: function totaluploadprogress(uploadProgress, totalBytes, totalBytesSent) {
                    $('#uploadProgress .progress-bar').css('width', uploadProgress + '%');
                    if (uploadProgress == 100) {
                        $('#uploadProgress').delay(1500).slideUp(function () {
                            $('#uploadProgress .progress-bar').css('width', '0%');
                        });
                    }
                },
                processing: function processing() {
                    //$('#uploadProgress').fadeIn();
                },
                sending: function sending(file, xhr, formData) {
                    formData.append('_token', CSRF_TOKEN);
                    formData.append('upload_path', manager.folders);
                },
                success: function success(e, _ref) {
                    var success = _ref.success,
                        message = _ref.message;

                    if (success) {
                        //alert("Sweet Success!");
                    } else {
                        alert(message);
                    }
                },
                error: function error(e, _ref2, xhr) {
                    var message = _ref2.message;

                    alert(message);
                },
                queuecomplete: function queuecomplete() {
                    getFiles(manager.folders);
                }
            };

            Dropzone.autoDiscover = false;

            var filemanagerDropzone = new Dropzone("#filemanager", DropzoneOptions);
            var fileuploadDropzone = new Dropzone("#upload", DropzoneOptions);

            getFiles('/');

            files.on('dblclick', 'li .file_link', function () {
                if (!$(this).children('.details').hasClass('folder')) {
                    return false;
                }
                manager.folders.push(this.dataset.folder);
                getFiles(manager.folders);
            });

            files.on('click', 'li', function (_ref3) {
                var target = _ref3.target;

                var clicked = target;
                if (!$(clicked).hasClass('file_link')) {
                    clicked = $(target).closest('.file_link');
                }
                setCurrentSelected(clicked);
            });

            $('.breadcrumb').on('click', 'li', function () {
                var index = $(this).data('index');
                manager.folders = manager.folders.splice(0, index);
                getFiles(manager.folders);
            });

            /********** TOOLBAR BUTTONS **********/
            $('#refresh').click(function () {
                getFiles(manager.folders);
            });

            $('#new_folder_modal').on('shown.bs.modal', function () {
                $('#new_folder_name').focus();
            });

            $('#new_folder_name').keydown(function (_ref4) {
                var which = _ref4.which;

                if (which == 13) {
                    $('#new_folder_submit').trigger('click');
                }
            });

            $('#move_file_modal').on('hidden.bs.modal', function () {
                $('#s2id_move_folder_dropdown').select2('close');
            });

            $('#new_folder_submit').click(function () {
                new_folder_path = manager.files.path + '/' + $('#new_folder_name').val();
                $.post(options.baseUrl + '/media/new_folder', {
                    new_folder: new_folder_path,
                    _token: CSRF_TOKEN
                }, function (_ref5) {
                    var success = _ref5.success;

                    if (success == true) {
                        //alert('successfully created ' + $('#new_folder_name').val(), "Sweet Success!");
                        getFiles(manager.folders);
                    } else {
                        alert('Whoops!');
                    }
                    $('#new_folder_name').val('');
                    $('#new_folder_modal').modal('hide');
                });
            });

            $('#delete').click(function () {
                if (manager.selected_file.type == 'directory') {
                    $('.folder_warning').show();
                } else {
                    $('.folder_warning').hide();
                }
                $('.confirm_delete_name').text(manager.selected_file.name);
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').click(function () {
                $.post(options.baseUrl + '/media/delete_file_folder', {
                    folder_location: manager.folders,
                    file_folder: manager.selected_file.name,
                    type: manager.selected_file.type,
                    _token: CSRF_TOKEN
                }, function (_ref6) {
                    var success = _ref6.success;

                    if (success == true) {
                        //alert('successfully deleted ' + manager.selected_file.name, "Sweet Success!");
                        getFiles(manager.folders);
                        $('#confirm_delete_modal').modal('hide');
                    } else {
                        alert('Whoops!');
                    }
                });
            });

            $('#move').click(function () {
                $('#move_file_modal').modal('show');
            });

            $('#rename').click(function () {
                if (typeof manager.selected_file !== 'undefined') {
                    $('#rename_file').val(manager.selected_file.name);
                }
                $('#rename_file_modal').modal('show');
            });

            $('#move_folder_dropdown').keydown(function (_ref7) {
                var which = _ref7.which;

                if (which == 13) {
                    $('#move_btn').trigger('click');
                }
            });

            $('#move_btn').click(function () {
                source = manager.selected_file.name;
                destination = $('#move_folder_dropdown').val() + '/' + manager.selected_file.name;
                $('#move_file_modal').modal('hide');
                $.post(options.baseUrl + '/media/move_file', {
                    folder_location: manager.folders,
                    source: source,
                    destination: destination,
                    _token: CSRF_TOKEN
                }, function (_ref8) {
                    var success = _ref8.success,
                        error = _ref8.error;

                    if (success == true) {
                        //alert('Successfully moved file/folder', "Sweet Success!");
                        getFiles(manager.folders);
                    } else {
                        alert(error, 'Whoops!');
                    }
                });
            });

            $('#rename_btn').click(function () {
                source = manager.selected_file.path;
                filename = manager.selected_file.name;
                new_filename = manager.new_filename;
                $('#rename_file_modal').modal('hide');
                $.post(options.baseUrl + '/media/rename_file', {
                    folder_location: manager.folders,
                    filename: filename,
                    new_filename: new_filename,
                    _token: CSRF_TOKEN
                }, function (_ref9) {
                    var success = _ref9.success,
                        error = _ref9.error;

                    if (success == true) {
                        //alert('Successfully renamed file/folder', "Sweet Success!");
                        getFiles(manager.folders);
                    } else {
                        alert(error, 'Whoops!');
                    }
                });
            });

            /********** END TOOLBAR BUTTONS **********/

            manager.$watch('files', function (_ref10, oldVal) {
                var items = _ref10.items;

                setCurrentSelected($('*[data-index="0"]'));
                $('#filemanager #content #files').hide();
                $('#filemanager #content #files').fadeIn('fast');
                $('#filemanager .loader').fadeOut(function () {
                    $('#filemanager #content').fadeIn();
                });

                if (items.length < 1) {
                    $('#no_files').show();
                } else {
                    $('#no_files').hide();
                }
            });

            manager.$watch('directories', function (newVal, oldVal) {
                if ($('#move_folder_dropdown').select2()) {
                    $('#move_folder_dropdown').select2('destroy');
                }
                $('#move_folder_dropdown').select2();
            });

            manager.$watch('selected_file', function (newVal, oldVal) {
                if (typeof newVal == 'undefined') {
                    $('.right_details').hide();
                    $('.right_none_selected').show();
                    $('#move').attr('disabled', true);
                    $('#delete').attr('disabled', true);
                } else {
                    $('.right_details').show();
                    $('.right_none_selected').hide();
                    $('#move').removeAttr('disabled');
                    $('#delete').removeAttr('disabled');
                }
            });

            function getFiles(folders) {
                var folder_location = '/';

                if (folders != '/') {
                    var folder_location = '/' + folders.join('/');
                }

                $('#file_loader').fadeIn();

                $.post(options.baseUrl + '/media/directories', {
                    folder_location: manager.folders,
                    _token: CSRF_TOKEN
                }, function (data) {
                    manager.directories = data;
                });

                $.post(options.baseUrl + '/media/files', _defineProperty({
                    folder: folder_location,
                    _token: CSRF_TOKEN
                }, '_token', CSRF_TOKEN), function (data) {
                    $('#file_loader').hide();
                    manager.files = data;
                    files.trigger('click');
                    for (var i = 0; i < manager.files.items.length; i++) {
                        if (_typeof(manager.files.items[i].size) != undefined) {
                            manager.files.items[i].size = bytesToSize(manager.files.items[i].size);
                        }
                    }
                });
            }

            function setCurrentSelected(cur) {
                $('#files li .selected').removeClass('selected');
                $(cur).addClass('selected');
                manager.selected_file = manager.files.items[$(cur).data('index')];
                manager.new_filename = manager.selected_file.name;
            }

            function bytesToSize(bytes) {
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes == 0) return '0 Bytes';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }
        };
    };

    var media = new managerMedia({
        baseUrl: $('#filemanager').data('url')
    });

    media.init();
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),

/***/ 198:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./components/boot_controller.js": 199,
	"./components/menu_controller.js": 200,
	"./fields/input_controller.js": 201,
	"./fields/picture_controller.js": 206,
	"./fields/simplemde_controller.js": 207,
	"./fields/tinymce_controller.js": 223,
	"./fields/upload_controller.js": 224,
	"./fields/utm_controller.js": 225,
	"./layouts/html_load_controller.js": 226,
	"./layouts/left_menu_controller.js": 247,
	"./layouts/systems_controller.js": 248,
	"./screen/base_controller.js": 249,
	"./screen/modal_controller.js": 250,
	"./screen/tabs_controller.js": 251
};
function webpackContext(req) {
	return __webpack_require__(webpackContextResolve(req));
};
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) // check for number or string
		throw new Error("Cannot find module '" + req + "'.");
	return id;
};
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = 198;

/***/ }),

/***/ 199:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            console.log('Тест');
        }
    }, {
        key: "addColumn",
        value: function addColumn() {
            alert('test');
        }
    }, {
        key: "addRelation",
        value: function addRelation() {
            alert('test');
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["column", "relation"];
/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 200:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",
        value: function connect() {

            var menu = this;

            $('.dd').nestable({}).on('change', function () {
                menu.sort();

                menu.send();
            }).on('click', '.edit', function () {
                menu.edit(this);
            });

            menu.sort();

            this.checkExist();
        }
    }, {
        key: "load",
        value: function load(object) {
            this.id = object.id;
            this.labelTarget.value = object.label;
            this.slugTarget.value = object.slug;
            this.authTarget.value = object.auth;
            this.robotTarget.value = object.robot;
            this.styleTarget.value = object.style;
            this.targetTarget.value = object.target;
            this.titleTarget.value = object.title;

            this.checkExist();
        }
    }, {
        key: "sort",
        value: function sort() {
            $('.dd-item').each(function (i, item) {
                $(item).data({
                    sort: i
                });
            });
        }
    }, {
        key: "edit",
        value: function edit(element) {
            var data = $(element).parent().data();
            data.label = $(element).prev().text();
            this.load(data);
        }
    }, {
        key: "getFormData",
        value: function getFormData() {
            return {
                label: this.labelTarget.value,
                title: this.titleTarget.value,
                auth: this.authTarget.value,
                slug: this.slugTarget.value,
                robot: this.robotTarget.value,
                style: this.styleTarget.value,
                target: this.targetTarget.value
            };
        }
    }, {
        key: "add",
        value: function add() {
            if (!this.checkForm()) {
                return;
            }

            var $menu = this,
                $dd = $('.dd'),
                data = { menu: $dd.attr('data-name'), lang: $dd.attr('data-lang'), data: this.getFormData() };

            axios.get(this.getUri('create/'), { params: data }).then(function (response) {
                $menu.add2Dom(response.data.id);
            });
        }
    }, {
        key: "add2Dom",
        value: function add2Dom(id) {
            $('.dd > .dd-list').append("<li class='dd-item dd3-item' data-id='" + id + "'> <div  class='dd-handle dd3-handle'>Drag</div><div  class='dd3-content'>" + this.labelTarget.value + "</div> <div  class='edit icon-pencil'></div></li>");

            $("li[data-id=" + id + "]").data(this.getFormData());

            this.sort();
            this.clear();
            this.send();
        }
    }, {
        key: "save",
        value: function save() {
            if (!this.checkForm()) {
                return;
            }

            $("li[data-id=" + this.id + "]").data(this.getFormData());
            $("li[data-id=" + this.id + "] > .dd3-content").html(this.labelTarget.value);

            this.clear();
            this.send();
        }
    }, {
        key: "destroy",
        value: function destroy(id) {
            axios.delete(this.getUri(id)).then(function (response) {});
        }
    }, {
        key: "remove",
        value: function remove() {
            $("li[data-id=" + this.id + "]").remove();
            this.destroy(this.id);
            this.clear();
        }
    }, {
        key: "clear",
        value: function clear() {
            this.labelTarget.value = '';
            this.titleTarget.value = '';
            this.authTarget.value = 0;
            this.slugTarget.value = '';
            this.robotTarget.value = 'follow';
            this.styleTarget.value = '';
            this.targetTarget.value = '_self';
            this.id = '';

            this.checkExist();
            window.Turbolinks.visit(window.location, { action: 'replace' });
        }
    }, {
        key: "send",
        value: function send() {
            var $dd = $('.dd'),
                name = $dd.attr('data-name'),
                data = {
                lang: $dd.attr('data-lang'),
                data: $dd.nestable('serialize')
            };

            axios.put(this.getUri(name), data).then(function (response) {});
        }
    }, {
        key: "checkForm",
        value: function checkForm() {
            if (!this.labelTarget.value) {
                document.getElementById('errors.label').classList.remove("none");
                return false;
            }

            if (!this.titleTarget.value) {
                document.getElementById('errors.title').classList.remove("none");
                return false;
            }

            if (!this.slugTarget.value) {
                document.getElementById('errors.slug').classList.remove("none");
                return false;
            }

            document.getElementById('errors.slug').classList.add("none");
            document.getElementById('errors.label').classList.add("none");
            document.getElementById('errors.title').classList.add("none");

            return true;
        }
    }, {
        key: "checkExist",
        value: function checkExist() {
            if (this.exist()) {
                document.getElementById('menu.remove').classList.remove("none");
                document.getElementById('menu.reset').classList.remove("none");
                document.getElementById('menu.create').classList.add("none");
                document.getElementById('menu.save').classList.remove("none");
            } else {
                document.getElementById('menu.remove').classList.add("none");
                document.getElementById('menu.reset').classList.add("none");
                document.getElementById('menu.create').classList.remove("none");
                document.getElementById('menu.save').classList.add("none");
            }
        }
    }, {
        key: "exist",
        value: function exist() {
            return Number.isInteger(this.id) && $("li[data-id=" + this.id + "]").length > 0;
        }
    }, {
        key: "getUri",
        value: function getUri() {
            var path = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';

            return platform.prefix("/press/menu/" + path);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["id", "label", "slug", "auth", "robot", "style", "target", "title"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 201:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_inputmask__ = __webpack_require__(155);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_inputmask___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_inputmask__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            var element = this.element.querySelector('input');
            __WEBPACK_IMPORTED_MODULE_1_inputmask___default()(element.dataset.mask).mask(element);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 206:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            var image = this.data.get('image');

            if (image) {
                this.element.querySelector('.picture-preview').src = image;
            } else {
                this.element.querySelector('.picture-preview').classList.add('none');
                this.element.querySelector('.picture-remove').classList.add('none');
            }
        }

        /**
         * Event for uploading image
         *
         * @param event
         */

    }, {
        key: "upload",
        value: function upload(event) {

            var cropPanel = this.element.querySelector('.upload-panel');
            $(cropPanel).croppie('destroy');

            if (!event.target.files[0]) {
                return;
            }

            var width = this.data.get('width');
            var height = this.data.get('height');
            $(cropPanel).croppie({
                viewport: {
                    width: width,
                    height: height
                },
                boundary: {
                    width: '100%',
                    height: 500
                },
                enforceBoundary: true
            });

            var reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);

            reader.onloadend = function () {
                $(cropPanel).croppie('bind', {
                    url: reader.result
                });
            };

            $(this.element.querySelector('.modal')).modal('show');
        }

        /**
         * Action on click button "Crop"
         */

    }, {
        key: "crop",
        value: function crop() {
            var _this2 = this;

            var cropPanel = this.element.querySelector('.upload-panel');

            $(cropPanel).croppie('result', {
                type: 'blob',
                size: 'viewport',
                format: 'png'
            }).then(function (blob) {

                var data = new FormData();
                data.append('file', blob);
                data.append('storage', 'public');

                var element = _this2.element;
                axios.post(platform.prefix('/systems/files'), data).then(function (response) {

                    var image = "/storage/" + response.data.path + response.data.name + "." + response.data.extension;

                    element.querySelector('.picture-preview').src = image;
                    element.querySelector('.picture-preview').classList.remove('none');
                    element.querySelector('.picture-remove').classList.remove('none');
                    element.querySelector('.picture-path').value = image;
                    $(element.querySelector('.modal')).modal('hide');
                });
            });
        }

        /**
         *
         */

    }, {
        key: "clear",
        value: function clear() {
            this.element.querySelector('.picture-path').value = '';
            this.element.querySelector('.picture-preview').src = '';
            this.element.querySelector('.picture-preview').classList.add('none');
            this.element.querySelector('.picture-remove').classList.add('none');
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["source", "upload"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 207:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_simplemde__ = __webpack_require__(158);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_simplemde___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_simplemde__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",
        value: function connect() {

            var textarea = this.element.querySelector('textarea');

            new __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a({
                autoDownloadFontAwesome: false,
                forceSync: true,
                element: textarea,
                toolbar: [{
                    name: "bold",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleBold,
                    className: "icon-bold",
                    title: "Bold"
                }, {
                    name: "italic",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleItalic,
                    className: "icon-italic",
                    title: "Italic"
                }, {
                    name: "heading",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleHeadingSmaller,
                    className: "icon-font",
                    title: "Heading"
                }, '|', {
                    name: "quote",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleBlockquote,
                    className: "icon-quote",
                    title: "Quote"
                }, {
                    name: "code",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleCodeBlock,
                    className: "icon-code",
                    title: "Code"
                }, {
                    name: "unordered-list",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleUnorderedList,
                    className: "icon-list",
                    title: "Generic List"
                }, {
                    name: "ordered-list",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleOrderedList,
                    className: "icon-number-list",
                    title: "Numbered List"
                }, '|', {
                    name: "link",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawLink,
                    className: "icon-link",
                    title: "Link"
                }, {
                    name: "image",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawImage,
                    className: "icon-picture",
                    title: "Insert Image"
                }, {
                    name: "table",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawTable,
                    className: "icon-table",
                    title: "Insert Table"
                }, '|', {
                    name: "preview",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.togglePreview,
                    className: "icon-eye no-disable",
                    title: "Toggle Preview"
                }, {
                    name: "side-by-side",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleSideBySide,
                    className: "icon-browser no-disable no-mobile",
                    title: "Toggle Side by Side"
                }, {
                    name: "fullscreen",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.toggleFullScreen,
                    className: "icon-full-screen no-disable no-mobile",
                    title: "Toggle Fullscreen"
                }, '|', {
                    name: "horizontal-rule",
                    action: __WEBPACK_IMPORTED_MODULE_1_simplemde___default.a.drawHorizontalRule,
                    className: "icon-options",
                    title: "Insert Horizontal Line"
                }, {
                    name: "guide",
                    action: "https://simplemde.com/markdown-guide",
                    className: "icon-help",
                    title: "Markdown Guide"
                }],
                placeholder: textarea.placeholder,
                spellChecker: false
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 223:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce__ = __webpack_require__(162);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



// Core


// A theme is also required
//import 'tinymce/themes/modern';
//import 'tinymce/themes/inlite'


// Plugins

/*
import 'tinymce/plugins/advlist'
import 'tinymce/plugins/anchor'
import 'tinymce/plugins/autolink'
import 'tinymce/plugins/autoresize'
import 'tinymce/plugins/autosave'
import 'tinymce/plugins/bbcode'
import 'tinymce/plugins/charmap'
import 'tinymce/plugins/code'
import 'tinymce/plugins/codesample'
import 'tinymce/plugins/colorpicker'
import 'tinymce/plugins/contextmenu'
import 'tinymce/plugins/directionality'
import 'tinymce/plugins/emoticons'
import 'tinymce/plugins/fullpage'
import 'tinymce/plugins/fullscreen'
import 'tinymce/plugins/help'
import 'tinymce/plugins/hr'
import 'tinymce/plugins/image'
import 'tinymce/plugins/imagetools'
import 'tinymce/plugins/importcss'
import 'tinymce/plugins/insertdatetime'
import 'tinymce/plugins/legacyoutput'
import 'tinymce/plugins/link'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/media'
import 'tinymce/plugins/nonbreaking'
import 'tinymce/plugins/noneditable'
import 'tinymce/plugins/pagebreak'
import 'tinymce/plugins/paste'
import 'tinymce/plugins/preview'
import 'tinymce/plugins/print'
import 'tinymce/plugins/save'
import 'tinymce/plugins/searchreplace'
import 'tinymce/plugins/spellchecker'
import 'tinymce/plugins/tabfocus'
import 'tinymce/plugins/table'
import 'tinymce/plugins/template'
import 'tinymce/plugins/textcolor'
import 'tinymce/plugins/textpattern'
import 'tinymce/plugins/toc'
import 'tinymce/plugins/visualblocks'
import 'tinymce/plugins/visualchars'
import 'tinymce/plugins/wordcount'
*/

var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',
        value: function connect() {

            //require.context(
            //    'file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',
            //    true,
            //    /.*/
            //);


            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.baseURL = '/orchid/js/tinymce';

            var selector = this.element.querySelector('.tinymce').id;
            var input = this.element.querySelector('input');

            var plugins = 'image media table link paste contextmenu textpattern autolink codesample';
            var toolbar1 = '';
            var inline = true;

            if (this.element.dataset.theme === 'modern') {
                plugins = 'print autosave autoresize preview paste code searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern';
                toolbar1 = 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat';
                inline = false;
            }

            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.init({
                branding: false,
                selector: '#' + selector,
                theme: this.element.dataset.theme,
                min_height: 300,
                height: 300,
                max_height: 600,
                plugins: plugins,
                toolbar1: toolbar1,
                insert_toolbar: 'quickimage quicktable media codesample fullscreen',
                selection_toolbar: 'bold italic | quicklink h2 h3 blockquote | alignleft aligncenter alignright alignjustify | outdent indent | removeformat ',
                inline: inline,
                convert_urls: false,
                image_caption: true,
                image_title: true,
                image_class_list: [{
                    title: 'None',
                    value: ''
                }, {
                    title: 'Responsive',
                    value: 'img-fluid'
                }],
                setup: function setup(element) {
                    element.on('change', function () {
                        $(input).val(element.getContent());
                    });
                },
                images_upload_handler: function images_upload_handler(blobInfo, success) {
                    var data = new FormData();
                    data.append('file', blobInfo.blob());

                    axios.post(platform.prefix('/systems/files'), data).then(function (response) {
                        success('/storage/' + response.data.path + response.data.name + '.' + response.data.extension);
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            });
        }
    }, {
        key: 'disconnect',
        value: function disconnect() {
            __WEBPACK_IMPORTED_MODULE_1_tinymce_tinymce___default.a.remove('#' + this.element.querySelector('.tinymce').id);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 224:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class(props) {
        _classCallCheck(this, _class);

        var _this = _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).call(this, props));

        _this.attachments = {};
        return _this;
    }

    _createClass(_class, [{
        key: "connect",
        value: function connect() {
            this.initDropZone();
            this.initSortable();
        }
    }, {
        key: "save",
        value: function save() {
            var data = this.activeAttachment;

            $('#modalUploadAttachment').modal('toggle');
            axios.put(platform.prefix("/systems/files/post/" + data.id), data).then();
        }
    }, {
        key: "getAttachmentTargetKey",
        value: function getAttachmentTargetKey(dataKey) {
            return dataKey + "Target";
        }
    }, {
        key: "loadInfo",
        value: function loadInfo(data) {
            var name = data.name + data.id;
            data.url = '/storage/' + data.path + data.name + '.' + data.extension;
            if (!this.attachments.hasOwnProperty(name)) {
                this.attachments[name] = data;
            }
            this.activeAttachment = data;
        }
    }, {
        key: "initSortable",
        value: function initSortable() {
            $(this.dropname + '.sortable-dropzone').sortable({
                scroll: false,
                containment: "parent",
                update: function update() {
                    var items = {};
                    $('.file-sort').each(function (index, value) {
                        var id = $(this).attr('data-file-id');
                        items[id] = index;
                    });

                    axios.post(platform.prefix('/systems/files/sort'), {
                        files: items
                    }).then();
                }
            });
        }
    }, {
        key: "initDropZone",
        value: function initDropZone() {
            var data = this.data.get('data') && JSON.parse(this.data.get('data'));
            var storage = this.data.get('storage');
            var name = this.data.get('name');
            var loadInfo = this.loadInfo.bind(this);
            var dropname = this.dropname;

            Dropzone.autoDiscover = false;
            new Dropzone(dropname, {
                url: platform.prefix('/systems/files'),
                method: 'post',
                uploadMultiple: false,
                parallelUploads: 100,
                maxFilesize: 9999,
                paramName: 'files',
                maxThumbnailFilesize: 99999,
                previewsContainer: dropname + '.visual-dropzone',
                addRemoveLinks: false,
                dictFileTooBig: 'File is big',

                init: function init() {
                    this.on('addedfile', function (e) {
                        var n = Dropzone.createElement('<a href="javascript:;" class="btn-remove">&times;</a>'),
                            t = this;
                        n.addEventListener('click', function (n) {
                            n.preventDefault(), n.stopPropagation(), t.removeFile(e);
                        }), e.previewElement.appendChild(n);

                        var n = Dropzone.createElement('<a href="javascript:;" class="btn-edit"><i class="icon - note" aria-hidden="true"></i></a>'),
                            t = this;
                        n.addEventListener('click', function (n) {
                            loadInfo(e.data);
                            $('#modalUploadAttachment').modal('show');
                        }), e.previewElement.appendChild(n);
                    });

                    this.on('completemultiple', function (file, json) {
                        $(dropname + '.sortable-dropzone').sortable('enable');
                    });

                    var instanceDropZone = this;
                    var images = data;
                    images.forEach(function (item, i, arr) {
                        var mockFile = {
                            id: item.id,
                            name: item.original_name,
                            size: item.size,
                            type: item.mime,
                            status: Dropzone.ADDED,
                            url: '/storage/' + item.path + item.name + '.' + item.extension,
                            data: item
                        };

                        instanceDropZone.emit('addedfile', mockFile);
                        instanceDropZone.emit('thumbnail', mockFile, mockFile.url);
                        instanceDropZone.files.push(mockFile);
                        $(dropname + '.dz-preview:last-child').attr('data-file-id', item.id).addClass('file-sort');
                        $("<input type='hidden' class='files-" + item.id + "' name='" + name + "[]' value='" + item.id + "'  />").appendTo(dropname);
                    });

                    $(dropname + '.dz-progress').remove();

                    this.on('sending', function (file, xhr, formData) {
                        formData.append('_token', $("meta[name='csrf_token']").attr('content'));
                        formData.append('storage', storage);
                    });

                    this.on('removedfile', function (file) {
                        $(dropname + '.files-' + file.data.id).remove();
                        axios.delete(platform.prefix("/systems/files/" + file.data.id), {
                            storage: $('#post-attachment-dropzone').data('storage')
                        }).then();
                    });
                },
                error: function error(file, response) {
                    if ($.type(response) === 'string') {
                        return response; //dropzone sends it's own error messages in string
                    }
                    return response.message;
                },
                success: function success(file, response) {
                    file.data = response;
                    $(dropname + '.dz-preview:last-child').attr('data-file-id', response.id).addClass('file-sort');
                    $("<input type='hidden' class='files-" + response.id + "' name='" + name + "[]' value='" + response.id + "'  />").appendTo(dropname);
                }
            });
        }
    }, {
        key: "dropname",
        get: function get() {
            return '#dropzone-' + this.data.get('name') + ' ';
        }
    }, {
        key: "activeAttachment",
        get: function get() {
            var _this2 = this;

            var id = this.activeAchivmentId;
            return ['name', 'original_name', 'alt', 'url', 'description'].reduce(function (res, key) {
                var targetKey = _this2.getAttachmentTargetKey(key);
                var target = _this2[targetKey];
                if (key === 'url') {
                    return _extends({}, res, _defineProperty({}, key, target.href));
                }
                return _extends({}, res, _defineProperty({}, key, target.value));
            }, { id: id });
        },
        set: function set(data) {
            var _this3 = this;

            this.activeAchivmentId = data.id;
            Object.keys(data).map(function (key) {
                var value = data[key];
                var targetKey = _this3.getAttachmentTargetKey(key);
                var target = _this3[targetKey];

                if (!target) {
                    return;
                }

                if (key === 'url') {
                    target.href = value;
                    return;
                }
                target.value = value;
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["name", "original_name", "alt", "description", "url", "active"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 225:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "connect",


        /**
         *
         */
        value: function connect() {
            if (!this.urlTarget.value) {
                return;
            }

            var url = new URL(this.urlTarget.value);

            this.sourceTarget.value = this.loadParam(url, 'source');
            this.mediumTarget.value = this.loadParam(url, 'medium');
            this.campaignTarget.value = this.loadParam(url, 'campaign');
            this.termTarget.value = this.loadParam(url, 'term');
            this.contentTarget.value = this.loadParam(url, 'content');
        }

        /**
         *
         */

    }, {
        key: "generate",
        value: function generate() {
            var url = new URL(this.urlTarget.value);
            this.urlTarget.value = url.protocol + '//' + url.host + url.pathname;

            this.addParms('source', this.sourceTarget.value);
            this.addParms('medium', this.mediumTarget.value);
            this.addParms('campaign', this.campaignTarget.value);
            this.addParms('term', this.termTarget.value);
            this.addParms('content', this.contentTarget.value);
        }

        /**
         *
         * @param text
         * @returns {string}
         */

    }, {
        key: "slugify",
        value: function slugify(text) {
            return text.toString().toLowerCase().trim().replace(/\s+/g, '-') // Replace spaces with -
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
            .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

        /**
         *
         * @param replace
         * @param name
         * @param value
         */

    }, {
        key: "add",
        value: function add(replace, name, value) {
            this.urlTarget.value += replace + name + "=" + encodeURIComponent(value);
        }

        /**
         *
         * @param replace
         * @param value
         */

    }, {
        key: "change",
        value: function change(replace, value) {
            this.urlTarget.value = this.urlTarget.value.replace(replace, "$1" + encodeURIComponent(value));
        }

        /**
         *
         * @param name
         * @param value
         */

    }, {
        key: "addParms",
        value: function addParms(name, value) {
            name = "utm_" + name;
            value = this.slugify(value);

            if (value.trim().length === 0) {
                return;
            }

            var replace = new RegExp("([?&]" + name + "=)[^&]+", "");

            if (this.urlTarget.value.indexOf("?") === -1) {
                this.add("?", name, value);
                return;
            }

            if (replace.test(this.link)) {
                this.change(replace, value);
                return;
            }

            this.add("&", name, value);
        }

        /**
         *
         * @param url
         * @param param
         * @returns {string | null}
         */

    }, {
        key: "loadParam",
        value: function loadParam(url, param) {
            return url.searchParams.get('utm_' + param);
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["url", "source", "medium", "campaign", "term", "content"];
/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 226:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_turbolinks__ = __webpack_require__(163);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_turbolinks___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_turbolinks__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__platform__ = __webpack_require__(228);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_axios__ = __webpack_require__(164);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_axios__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }






var _class = function (_Controller) {
  _inherits(_class, _Controller);

  function _class() {
    _classCallCheck(this, _class);

    return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
  }

  _createClass(_class, [{
    key: "initialize",


    /**
     *
     */
    value: function initialize() {
      __WEBPACK_IMPORTED_MODULE_1_turbolinks___default.a.start();
      window.platform = Object(__WEBPACK_IMPORTED_MODULE_2__platform__["a" /* platform */])();
    }

    /**
     *
     */

  }, {
    key: "connect",
    value: function connect() {
      this.csrf();
    }

    /**
     * We'll load the axios HTTP library which allows us to easily issue requests
     * to our Laravel back-end. This library automatically handles sending the
     * CSRF token as a header based on the value of the "XSRF" token cookie.
     */

  }, {
    key: "csrf",
    value: function csrf() {
      var token = document.head.querySelector('meta[name="csrf_token"]');
      window.axios = __WEBPACK_IMPORTED_MODULE_3_axios___default.a;

      /**
       * Next we will register the CSRF Token as a common header with Axios so that
       * all outgoing HTTP requests automatically have it attached. This is just
       * a simple convenience so we don't have to attach every token manually.
       */
      window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
      window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
  }]);

  return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 228:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (immutable) */ __webpack_exports__["a"] = platform;
function platform() {
    return {

        /**
         *
         * @param path
         * @returns {*}
         */
        prefix: function prefix(path) {
            var prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

            if (prefix && prefix.content.charAt(0) !== '/') {
                prefix = '/' + prefix.content;
            } else if (prefix) {
                prefix = prefix.content;
            } else {
                return path;
            }

            return prefix + path;
        },


        /**
         *
         * @param message
         * @param type
         * @param target
         */
        alert: function alert(message) {
            var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'danger';
            var target = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '#dashboard-alerts';

            $(target).append($('<div/>', {
                class: 'alert m-b-none alert-' + type,
                text: message
            }).append($('<button/>', {
                class: 'close',
                'data-dismiss': 'alert',
                'aria-label': 'Close',
                'aria-hidden': 'true'
            }).append($('<span/>', { 'aria-hidden': 'true', html: '&times;' }))), $('<div/>', { class: 'clearfix' }));
        },


        /**
         *
         * @param idForm
         * @param message
         * @returns {boolean}
         */
        validateForm: function validateForm(idForm, message) {
            if (!document.getElementById(idForm).checkValidity()) {
                window.platform.alert(message, 'warning b-b');
                return false;
            }
            return true;
        }
    };
}
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 247:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {
            var activeMenu = false;

            $('#aside-wrap-list').children('.tab-pane').each(function () {
                if ($(this).hasClass('active')) {
                    activeMenu = true;
                }
            });

            if (!activeMenu) {
                $('#menu-default').addClass('active');
            }

            $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).parent().siblings().removeClass('open');
                $(this).parent().toggleClass('open');
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 248:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }


//import {$, jQuery}  from 'jquery';

var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "filter",


        /**
         * Stimulus gives the possibility of a change event when the field loses focus
         */
        value: function filter(event) {

            var search = event.target.value.trim().toLowerCase();

            $(".admin-element-item").hide().filter(function () {
                return $(this).html().trim().toLowerCase().indexOf(search) !== -1;
            }).show();

            $(".admin-element").show().filter(function () {
                return $(this).children('.list-group').children(":visible").length === 0;
            }).hide();
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 249:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'targetModal',


        /**
         *
         * @param event
         * @returns {*}
         */
        value: function targetModal(event) {
            var key = event.target.dataset.modalKey;

            this.application.getControllerForElementAndIdentifier(document.getElementById('screen-modal-' + key), 'screen--modal').open({
                'title': event.target.dataset.modalTitle,
                'submit': event.target.dataset.modalAction,
                'params': event.target.dataset.modalParams
            });

            return event.preventDefault();

            //TODO: $('#screen-modal-type-'+key).addClass($('#show-button-modal-'+key).data('modalType'));
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);

/***/ }),

/***/ 250:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: "open",


        /**
         *
         * @param options
         */
        value: function open(options) {
            this.titleTarget.textContent = options.title;
            this.element.querySelector('form').action = options.submit;

            if (this.data.get('async')) {
                this.asyncLoadData(JSON.parse(options.params));
            }

            $(this.element).modal('toggle');
        }

        /**
         *
         * @param params
         */


        /**
         *
         * @type {string[]}
         */

    }, {
        key: "asyncLoadData",
        value: function asyncLoadData(params) {
            var modal = this;
            axios.post(this.data.get('url') + '/' + this.data.get('method') + '/' + this.data.get('slug'), params).then(function (response) {
                modal.element.querySelector('[class="async-content"]').innerHTML = response.data;
            });
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

_class.targets = ["title"];
/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 251:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_stimulus__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var _class = function (_Controller) {
    _inherits(_class, _Controller);

    function _class() {
        _classCallCheck(this, _class);

        return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
    }

    _createClass(_class, [{
        key: 'connect',


        /**
         *
         */
        value: function connect() {
            var tabs = this.tabs();

            var activeId = tabs[window.location.href][this.data.get('slug')];

            console.log(activeId);

            if (activeId !== null) {
                $('#' + activeId).tab('show');
            }
        }

        /**
         *
         * @param event
         */

    }, {
        key: 'setActiveTab',
        value: function setActiveTab(event) {

            var activeId = event.target.id;
            var tabs = this.tabs();

            tabs[window.location.href][this.data.get('slug')] = activeId;
            localStorage.setItem('tabs', JSON.stringify(tabs));
            $('#' + activeId).tab('show');

            return event.preventDefault();
        }

        /**
         *
         * @returns {any}
         */

    }, {
        key: 'tabs',
        value: function tabs() {
            var tabs = JSON.parse(localStorage.getItem('tabs'));

            if (tabs === null) {
                tabs = {};
            }

            if (tabs[window.location.href] === undefined) {
                tabs[window.location.href] = {};
            }

            if (tabs[window.location.href][this.data.get('slug')] === undefined) {
                tabs[window.location.href][this.data.get('slug')] = null;
            }

            return tabs;
        }
    }]);

    return _class;
}(__WEBPACK_IMPORTED_MODULE_0_stimulus__["Controller"]);

/* harmony default export */ __webpack_exports__["default"] = (_class);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(1)))

/***/ }),

/***/ 252:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })

},[170]);
//# sourceMappingURL=orchid.js.map