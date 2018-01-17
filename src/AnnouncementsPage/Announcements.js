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

  openFilmPage = i => {
    this.props.router.push({
      pathname: 'film_page',
      state:{
        id: this.state.films[i].id
      }
    })
  }

  showAnnouncement = (i) => {
    if(this.state.films.length > 0){
      return(
        <Film className="col-md-10 col-md-offset-1" onClick={this.openFilmPage.bind(this,i)}>
          <Poster className="col-md-4">
            <ReactImageFallback
                src={this.state.films[i].poster}
                fallbackImage={loaderImage}
                initialImage={loaderImage}
                className="img-responsive"
              />
          </Poster>
          <PremierDate className="col-md-8">
            {this.state.films[i].premierDate}
          </PremierDate>
          <Description>
            {this.state.films[i].description}
          </Description>
        </Film>
      )
    }
  }

  render() {
    console.log(this.state.films);
    return(
      <div>
        <div>{this.showAnnouncement(0)}</div>
        <div>{this.showAnnouncement(3)}</div>
        <div>{this.showAnnouncement(11)}</div>
        <div>{this.showAnnouncement(7)}</div>
        <div>{this.showAnnouncement(8)}</div>
      </div>
    )
  }
}

export default withRouter(Announcements);

const Film = styled.div`
  background-color: rgba(13, 16, 18, 1);
  position: relative;
  height: 68vh;
  margin-top: 10vh;
  overflow: hidden;

  &:hover{
    cursor: pointer;
    background-color: rgba(28, 34, 38, 1);
  }
`

const Poster = styled.div`
  left: -3%;
  height: 100%;
`

const PremierDate = styled.div`
  color: rgb(219, 219, 219);
  font-size: 40px;
  text-align: center;
`

const Description = styled.div`
  font-size: 25px;
  margin-top: 7%;
  font-style: italic;
  color: white;
`
