'use strict';

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var React = require('react');
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