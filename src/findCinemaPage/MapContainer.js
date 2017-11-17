import React, { Component } from 'react';
import GoogleMapReact from 'google-map-react';

const AnyReactComponent = ({ text }) => <div>{text}</div>;

class MapContainer extends Component {
  static defaultProps = {
    center: {lat: 51.75924850000001, lng: 19.45598330000007},
    zoom: 11
  };

  render() {
    return (
      <GoogleMapReact
        defaultCenter={this.props.center}
        defaultZoom={this.props.zoom}
      >
        <AnyReactComponent
          lat={51.75924850000001}
          lng={19.45598330000007}
          text={'MY CINEMA'}
        />
      </GoogleMapReact>
    );
  }
}

export default MapContainer;
