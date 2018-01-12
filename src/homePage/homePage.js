import React, { Component } from "react";
import Calendar from "./calendar"
import apiClient from "../api-client";
import ReactGridLayout from 'react-grid-layout'
import styled from "styled-components"
import Button from "../user-interface/Button"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"

class homePage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      title: [],
      poster: [],
      rating: [],
      id: [],
      isModalActive: false,
      modalId: ""
    };
  }

  componentWillMount = () => {
    const rand = Math.floor(1 + Math.random() * 40);
    const rand2 = Math.floor(1+Math.random()*6);
    apiClient
      .get(`index.php?/Home/getPopular/PL/${rand}/${rand2}`)
      .then(response => {
        console.log(response);
        {
          response.data.movies.map(r =>
            this.setState(previousState => ({
              title: [...previousState.title, r.title],
              poster: [...previousState.poster, r.poster],
              rating: [...previousState.rating, r.voteAverage],
              id: [...previousState.id, r.id]
            }))
          )
        }
      })
      .catch(error => {
        console.log(error);
      });
  };

  openFilmPage = i => {
    this.props.router.push({
      pathname: 'film_page',
      state:{
        id: this.state.id[i]
      }
    })
  }

  closeModal = () => {
    this.setState({
      isModalActive: !this.state.isModalActive
    })
  }

  viewPoster = i => {
    return(
      <PosterContainer onClick={this.openFilmPage.bind(this, i)}>
        <ReactImageFallback
          src={this.state.poster[i]}
          fallbackImage={loaderImage}
          initialImage={loaderImage}
          className="img-responsive"
        />
        <p>{this.state.title[i]} <br /> {this.state.rating[i]}</p>
      </PosterContainer>
    )
  }

  render() {
    return (
      <div className="container-fluid">
        <div className="col-md-12" style={{ paddingTop: "5vh" }}>
          <div className="col-md-8 col-md-offset-2">
            <div className="col-md-4">{this.viewPoster(0)}</div>
            <div className="col-md-4">{this.viewPoster(1)}</div>
            <div className="col-md-4">{this.viewPoster(2)}</div>
          </div>
          <div className="col-md-8 col-md-offset-2" style={{ paddingTop: "5vh" }}>
            <div className="col-md-4">{this.viewPoster(3)}</div>
            <div className="col-md-4">{this.viewPoster(4)}</div>
            <div className="col-md-4">{this.viewPoster(5)}</div>
          </div>
        </div>
      </div>
    );
  }
}

export default homePage;

const PosterContainer = styled.div`
  position: relative;
  width: 100%;
  height: 100%;
  p{
    position: absolute;
    display: block;
    width: 100%;
    height: 20%;
    background-color: black;
    left: 0px;
    bottom: -10px;
    font-size: 20px;
    text-align:center;
    color:white;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
  }

  &:hover{
    cursor: pointer;
    p{
      opacity: 0.85;
    }
  }
`

const styledModal = {
  overlay: {
    position: "fixed",
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: "rgba(23, 23, 23, 0.99)"
  },
  content: {
    position: "fixed",
    top: "0px",
    left: "-35vw",
    right: "0px",
    bottom: "0px",
    opacity: "1",
    WebkitOverflowScrolling: "touch",
    outline: "none",
    height: "100%",
    width: "100%",
    color: "rgb(201, 201, 201)",
    overflowY: "scroll",
    overflowX: "hidden"
  }
};
