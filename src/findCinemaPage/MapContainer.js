import { Map, InfoWindow, Marker, GoogleApiWrapper } from 'google-maps-react';
import React, { Component } from 'react';
import apiClient from "../api-client";
import locationImage from "../images/location.png";

export class MapContainer extends Component {
  constructor(props) {
    super(props);
    this.state = { latitude: 0, longtitude: 0,cinemaLocation: [], showingInfoWindow: false,activeMarker: {},selectedPlace: {}};

    //ustawiam pozycje za pomoca wbudowanej w przegladarke funkcji, nie dodaje na razie warunkow
    //sprawdzajacych czy przegladraka obsluguje
    navigator.geolocation.getCurrentPosition((position) => {
      this.setState({
        latitude: position.coords.latitude,
        longtitude: position.coords.longitude
      });
    }
    );
    apiClient
      .get("index.php/Home/getCinemasLocalization")
      .then(response => {
        this.setState((state)=>({cinemaLocation: response.data.result}))
      })
      .catch(error => {
        console.log(error);
      });
  }

  onMarkerClick = (props,marker,e) => {
    this.setState({
      selectedPlace: props,
      activeMarker: marker,
      showingInfoWindow: true
    })

  }
  render() {
    
    //dodaje ten warunek po to ze zanim latitude nie zmieni wartosci na konkretna lokalizacje to zwracam null
    if (this.state.latitude == 0) {
      return null;
    }

    if(this.state.cinemaLocation.length == 0) {
      return null;
    }
    return (

      <Map google={this.props.google} initialCenter={{
        lat: this.state.latitude,
        lng: this.state.longtitude
      }} zoom={14}>

        {this.state.cinemaLocation.map((clocation)=>(

           <Marker title={clocation.name}
           name={clocation.name}
          icon={{
          url:locationImage
    }}   onClick={this.onMarkerClick}
         position={{lat: clocation.locationNS, lng: clocation.locationEW}} />
        ))}


        <InfoWindow marker={this.state.activeMarker} visible={this.state.showingInfoWindow}>
          <div>
            <img src={locationImage}/> Kino
            <h3>{this.state.selectedPlace.name}</h3>
          </div>
        </InfoWindow>
      </Map>
    );
  }
}

export default GoogleApiWrapper({
  apiKey: ("AIzaSyDY4NrTVqGqwe-TSMyICW7-0R8l8MlzVQs")
})(MapContainer)
