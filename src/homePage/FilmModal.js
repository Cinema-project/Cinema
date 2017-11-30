import React, { Component } from "react";
import apiClient from "../api-client";
import Iframe from "react-iframe";

export default class FilmModal extends Component{
  constructor(props){
    super(props);

    this.state = {
      title: "",
      url: ""
    }
  }

  componentDidMount = () => {
    apiClient
      .get(`index.php/Home/getMovieDetails/PL/${this.props.id}`)
      .then(response => {
        this.setState({
          title: response.data.title
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
      <div>
        <Iframe url={url}
        width="300px"
        height="300px"
        id="myId"
        className="myClassname"
        display="initial"
        position="relative"
        allowFullScreen/>
      </div>
    )
  }
}
