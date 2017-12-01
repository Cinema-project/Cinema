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
      url: ""
    }
  }

  componentDidMount = () => {
    apiClient
      .get(`index.php/Home/getMovieDetails/PL/${this.props.id}`)
      .then(response => {
        console.log("DETALE", response);
        this.setState({
          title: response.data.title,
          overview: response.data.overview
        })
      })
      .catch(error => {
        console.log(error);
      });

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

  render(){
    var url = this.state.url;
    if(url !== undefined){
      url = url.replace("watch?v=", "embed/");

    }
    return(
      <div className="row">
      <div className="col-md-6 col-md-offset-3" style={{width: "100vw", height: "100vh"}}>
        <h1 className="col-md-12">{this.state.title}</h1>
        <div className="col-md-12" style={{height: "52vh", paddingBottom: "3vh"}}>
        <Iframe url={url}
        width="50%"
        height="100%"
        id="myId"
        display="initial"
        position="relative"
        allowFullScreen
      />
    </div>
      <Text className="col-md-6">{this.state.overview}</Text>
      </div>
    </div>
    )
  }
}

const Text = styled.div`
  overflow: auto;
`
