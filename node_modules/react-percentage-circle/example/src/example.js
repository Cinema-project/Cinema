var React = require('react');
var ReactDOM = require('react-dom');
const Circle = require('react-percentage-circle').Circle;
const Caption = require('react-percentage-circle').Caption;

var App = React.createClass({
  getInitialState() {
    return {
      percent: 30,
      color: '#3FC7FA',
    };
  },
  changeState() {
    const colorMap = ['#3FC7FA', '#85D262', '#FE8C6A'];
    this.setState({
      percent: parseInt(Math.random() * 100, 10),
      color: colorMap[parseInt(Math.random() * 3, 10)],
    });
  },
  render() {
    const containerStyle = {
      width: '250px',
    };
    const circleContainerStyle = {
      width: '250px',
      height: '250px',
    };
    return (
      <div>
        <h3>Circle Progress {this.state.percent}%</h3>
        <div style={circleContainerStyle}>
          <Circle percent={this.state.percent} strokeWidth="6" strokeColor={this.state.color}>
              <Caption text={this.state.percent} x="50" y="50" textAnchor="middle" className='caption-text'/>
          </Circle>
        </div>
        <p>
          <button onClick={this.changeState}>Change State</button>
        </p>
      </div>
      );
  },
});

ReactDOM.render(<App />, document.getElementById('app'));
