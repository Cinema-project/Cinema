import React, { Component } from "react";
import apiClient from "../api-client";
import styled from "styled-components"
import Button from "../user-interface/Button"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"
import { withRouter } from "react-router";

export class Announcements extends Component {
  constructor(props) {
    super(props);
    this.state = {
      films: [],
    };
  }

  componentWillMount = () => {
    const path = `index.php?/Home/getUpcoming/PL/20`;

    apiClient
      .get(path)
       .then(response => {
         this.setState({
           films: response.data.movies
         })
      })
      .catch(error => {
        console.log(error);
      });
  }

  showAnnouncement = i => {
    if(this.state.films.length > 0){
      return(
        <Film className="col-md-10 col-md-offset-1">
          abc
        </Film>
      )
    }
  }

  render() {
    return(
      <div>
        <div>{this.showAnnouncement(0)}</div>
        <div>{this.showAnnouncement(1)}</div>
        <div>{this.showAnnouncement(2)}</div>
      </div>
    )
  }
}

export default withRouter(Announcements);

const Film = styled.div`
  background-color: rgba(13, 16, 18, 1);
  border-radius: 50px;
  height: 75vh;
  margin-top: 10vh;
  overflow: hidden;

  &:hover{
    cursor: pointer;
    background-color: rgba(28, 34, 38, 1);
  }
`

const Title = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`
