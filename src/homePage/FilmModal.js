import React, { Component } from "react";
import apiClient from "../api-client";

export default class FilmModal extends Component{
  constructor(props){
    super(props);

    this.state = {
      filmDetails: []
    }
  }

  componentWillMount = () => {
    apiClient
      .get(`index.php/Home/getMovieDetails/PL/${this.props.id}`)
      .then(response => {
        console.log("RESP", response);
      })
      .catch(error => {
        console.log(error);
      });
  }

  render(){
    return(
      <div>
        {this.props.id}<br/>
      </div>
    )
  }
}
