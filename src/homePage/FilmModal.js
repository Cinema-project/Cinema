import React, { Component } from "react";
import apiClient from "../api-client";
import Iframe from "react-iframe";
import styled from "styled-components"

export default class FilmModal extends Component{
  constructor(props){
    super(props);

    this.state = {
      title: "",
      overview: "",
      budget: "",
      genre: "",
      url: "",
      date: "",
      time: ""
    }
  }

  componentWillMount= () => {
      apiClient
        .get(`index.php?/Home/getTrailerPath/PL/${this.props.id}`)
        .then(response => {
          console.log(response);
          this.setState({
            url: response.data[0]
          })
        })
        .catch(error => {
          console.log(error);
        });
  }

  componentDidMount = () => {
    apiClient
      .get(`index.php/Home/getMovieDetails/PL/${this.props.id}`)
      .then(response => {
        console.log("DETALE", response);
        this.setState({
          title: response.data.title,
          overview: response.data.description,
          budget: response.data.budget,
          genre: response.data.genresList[0],
          //production: response.data.production_companies[0].name,
          date: response.data.premierDate,
          time: response.data.runtime
        })
      })
      .catch(error => {
        console.log(error);
      });

      
  }

  getCategory = e =>{
    console.log(e);
    if(e == 28){
      return "Akcja";
    }

    if(e == 12){
      return "Przygodowy";
    }

    if(e== 16){
      return "Animacja";
    }

    if(e == 35){
      return "Komedia";
    }

    if(e == 80){
      return "Kryminał";
    }

    if(e == 99){
      return "Dokumentalny";
    }

    if(e == 18){
      return "Dramat";
    }

    if(e == 10751){
      return "Familijny";
    }

    if(e == 14){
      return "Fantasy";
    }

    if(e == 36){
      return "Historyczny";
    }

    if(e == 27){
      return "Horror";
    }

    if(e == 10402){
      return "Muzyczny";
    }

    if(e == 9648){
      return  "Tajemnica";
    }

    if(e == 10749){
      return "Romans";
    }

    if(e == 878){
      return "Sci-Fi";
    }

    if(e == 10770){
      return  "film TV";
    }

    if(e == 53){
      return "Thriller";
    }

    if(e == 10752){
      return "Wojenny";
    }

    if(e == 37){
      return "Western";
    }
  }

  render(){
    var url = this.state.url;
    if(url !== undefined){
    url = url.replace("watch?v=", "embed/");

    }
    if(this.state.time == 0){
      this.setState({
        time: "nieznany"
      })
    }

    return(
      <div className="row">
      <div className="col-md-12" style={{width: "100vw", height: "100vh"}}>
        <Title className="col-md-6 col-md-offset-2">{this.state.title}</Title>
        <div className="col-md-10 col-md-offset-2" style={{height: "55vh", paddingBottom: "3vh"}}>
        <Iframe url={url}
        width="67%"
        height="100%"
        id="myId"
        display="initial"
        position="relative"
        allowFullScreen
      />
      <Details className="col-md-3" style={{float: "right", marginRight: "5vw"}}>
        {this.state.time} min <br/>
        Gatunek: {this.getCategory(this.state.genre)} <br/>
        Premiera: {this.state.date}
      </Details>
    </div>
      <Text className="col-md-6 col-md-offset-2">{this.state.overview}</Text>
      </div>
    </div>
    )
  }
}

const Title = styled.div`
  font-family: 'Dosis', sans-serif;
  font-size: 50px;
`

const Text = styled.div`
  font-size: 15px;
  overflow: auto;
`

const Details = styled.div`
  font-family: 'Oswald', sans-serif;
  font-size: 18px;
  color: rgb(198, 198, 184);
`
