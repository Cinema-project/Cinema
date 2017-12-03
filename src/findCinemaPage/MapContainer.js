import { Map, InfoWindow, Marker, GoogleApiWrapper } from 'google-maps-react';
import React, { Component } from 'react';

export class MapContainer extends Component {
  constructor(props) {
    super(props);
    this.state = { latitude: 0, longtitude: 0 }
    //ustawiam pozycje za pomoca wbudowanej w przegladarke funkcji, nie dodaje na razie warunkow
    //sprawdzajacych czy przegladraka obsluguje 
    navigator.geolocation.getCurrentPosition((position) => {
      this.setState({
        latitude: position.coords.latitude,
        longtitude: position.coords.longitude
      });
    }
    );
  }
  render() {
    //dodaje ten warunek po to ze zanim latitude nie zmieni wartosci na konkretna lokalizacje to zwracam null
    if (this.state.latitude == 0) {
      return null;
    }
    return (

      <Map google={this.props.google} initialCenter={{
        lat: this.state.latitude,
        lng: this.state.longtitude
      }} zoom={14}>

        <Marker onClick={this.onMarkerClick}
          name={'Current location'} />

        <InfoWindow onClose={this.onInfoWindowClose}>
          <div>
            <h1>"My Cinema"</h1>
          </div>
        </InfoWindow>
      </Map>
    );
  }
}

export default GoogleApiWrapper({
  apiKey: ("AIzaSyDY4NrTVqGqwe-TSMyICW7-0R8l8MlzVQs")
})(MapContainer)
