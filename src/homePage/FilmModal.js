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
    url = url.replace("watch?v=", "embed/");
    return(
      <div className="col-md-6 col-md-offset-3" style={{width: "100vw", height: "100vh"}}>
        <Text className="col-md-12">{this.state.title}</Text>
        <Iframe url={url}
        width="50%"
        height="50%"
        id="myId"
        className="col-md-12"
        display="initial"
        position="relative"
        allowFullScreen
      />
      <Text className="col-md-6">{this.state.overview}</Text>
      </div>
    )
  }
}

const Text = styled.div`
  overflow: auto;
`
