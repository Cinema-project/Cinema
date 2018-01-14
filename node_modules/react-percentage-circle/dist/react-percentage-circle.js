(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.ReactPercentageCircle = f()}})(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';
/* eslint-disable no-unused-vars */
var hasOwnProperty = Object.prototype.hasOwnProperty;
var propIsEnumerable = Object.prototype.propertyIsEnumerable;

function toObject(val) {
	if (val === null || val === undefined) {
		throw new TypeError('Object.assign cannot be called with null or undefined');
	}

	return Object(val);
}

function shouldUseNative() {
	try {
		if (!Object.assign) {
			return false;
		}

		// Detect buggy property enumeration order in older V8 versions.

		// https://bugs.chromium.org/p/v8/issues/detail?id=4118
		var test1 = new String('abc');  // eslint-disable-line
		test1[5] = 'de';
		if (Object.getOwnPropertyNames(test1)[0] === '5') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test2 = {};
		for (var i = 0; i < 10; i++) {
			test2['_' + String.fromCharCode(i)] = i;
		}
		var order2 = Object.getOwnPropertyNames(test2).map(function (n) {
			return test2[n];
		});
		if (order2.join('') !== '0123456789') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test3 = {};
		'abcdefghijklmnopqrst'.split('').forEach(function (letter) {
			test3[letter] = letter;
		});
		if (Object.keys(Object.assign({}, test3)).join('') !==
				'abcdefghijklmnopqrst') {
			return false;
		}

		return true;
	} catch (e) {
		// We don't expect any of the above to throw, but better to be safe.
		return false;
	}
}

module.exports = shouldUseNative() ? Object.assign : function (target, source) {
	var from;
	var to = toObject(target);
	var symbols;

	for (var s = 1; s < arguments.length; s++) {
		from = Object(arguments[s]);

		for (var key in from) {
			if (hasOwnProperty.call(from, key)) {
				to[key] = from[key];
			}
		}

		if (Object.getOwnPropertySymbols) {
			symbols = Object.getOwnPropertySymbols(from);
			for (var i = 0; i < symbols.length; i++) {
				if (propIsEnumerable.call(from, symbols[i])) {
					to[symbols[i]] = from[symbols[i]];
				}
			}
		}
	}

	return to;
};

},{}],2:[function(require,module,exports){
(function (global){
'use strict';

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var React = (typeof window !== "undefined" ? window['React'] : typeof global !== "undefined" ? global['React'] : null);
var assign = require('object-assign');

var defaultProps = {
  strokeWidth: 1,
  strokeColor: '#3FC7FA',
  trailWidth: 1,
  trailColor: '#D9D9D9'
};

var Caption = React.createClass({
  displayName: 'Caption',

  render: function render() {
    var props = assign({}, this.props);
    var text = props.text || '';
    var className = props.className;
    delete props.text;
    delete props.className;
    return React.createElement(
      'text',
      _extends({}, props, { className: className }),
      text
    );
  }
});

var Circle = React.createClass({
  displayName: 'Circle',

  render: function render() {
    var props = assign({}, this.props);
    var strokeWidth = props.strokeWidth;
    var radius = 50 - strokeWidth / 2;
    var pathString = 'M 50,50 m 0,-' + radius + '\n     a ' + radius + ',' + radius + ' 0 1 1 0,' + 2 * radius + '\n     a ' + radius + ',' + radius + ' 0 1 1 0,-' + 2 * radius;
    var len = Math.PI * 2 * radius;
    var pathStyle = {
      'strokeDasharray': len + 'px ' + len + 'px',
      'strokeDashoffset': (100 - props.percent) / 100 * len + 'px',
      'transition': 'stroke-dashoffset 0.6s ease 0s, stroke 0.6s ease'
    };
    ['strokeWidth', 'strokeColor', 'trailWidth', 'trailColor'].forEach(function (item) {
      if (item === 'trailWidth' && !props.trailWidth && props.strokeWidth) {
        props.trailWidth = props.strokeWidth;
        return;
      }
      if (!props[item]) {
        props[item] = defaultProps[item];
      }
    });

    return React.createElement(
      'svg',
      { className: 'rc-progress-circle', viewBox: '0 0 100 100' },
      React.createElement('path', { className: 'rc-progress-circle-trail', d: pathString, stroke: props.trailColor,
        strokeWidth: props.trailWidth, fillOpacity: '0' }),
      React.createElement('path', { className: 'rc-progress-circle-path', d: pathString, strokeLinecap: 'round',
        stroke: props.strokeColor, strokeWidth: props.strokeWidth, fillOpacity: '0', style: pathStyle }),
      this.props.children
    );
  }
});

module.exports = {
  Circle: Circle,
  Caption: Caption
};

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"object-assign":1}]},{},[2])(2)
});