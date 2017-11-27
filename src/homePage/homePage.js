import React, { Component } from "react";
import Calendar from "./calendar"
import apiClient from "../api-client";
import ReactGridLayout from 'react-grid-layout'
import styled from "styled-components"

class homePage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      title: [],
      poster: [],
      rating: []
    };
  }

  componentWillMount = () => {
    const rand = Math.floor(1 + Math.random() * 100);
    apiClient
      .get(`index.php?/Home/getPopular/${rand}/PL`)
      .then(response => {
        {response.data.results.map(r =>
          this.setState(previousState =>({
            title: [...previousState.title, r.title],
            poster: [...previousState.poster, r.poster_path],
            rating: [...previousState.rating, r.vote_average]
          }))
        )}
      })
      .catch(error => {
        console.log(error);
      });
  };


  render() {
    console.log("rand:", this.state.random);
    return (
      <div className="container-fluid">
          <div className="col-md-12" style={{ paddingTop: "5vh" }}>
            <div className="col-md-8 col-md-offset-2">
              <div className="col-md-4">
                <PosterContainer>
                  <img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[0]}`} alt="logo"/>
                  <p>{this.state.title[0]} <br/> {this.state.rating[0]}</p>
                </PosterContainer>
              </div>
              <div className="col-md-4">
                <PosterContainer>
                  <img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[1]}`} alt="logo"/>
                  <p>{this.state.title[1]} <br/> {this.state.rating[1]}</p>
                </PosterContainer>
              </div>
              <div className="col-md-4">
                <PosterContainer>
                  <img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[2]}`} alt="logo"/>
                  <p>{this.state.title[2]} <br/> {this.state.rating[2]}</p>
                </PosterContainer>
              </div>
          </div>
          <div className="col-md-8 col-md-offset-2" style={{paddingTop: "5vh"}}>
            <div className="col-md-4">
              <PosterContainer>
                <img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[3]}`} alt="logo"/>
                <p>{this.state.title[3]} <br/> {this.state.rating[3]}</p>
              </PosterContainer>
            </div>
            <div className="col-md-4">
              <PosterContainer>
                <img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[4]}`} alt="logo"/>
                <p>{this.state.title[4]} <br/> {this.state.rating[4]}</p>
              </PosterContainer>
            </div>
            <div className="col-md-4">
              <PosterContainer>
                <img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[5]}`} alt="logo"/>
                <p>{this.state.title[5]} <br/> {this.state.rating[5]}</p>
              </PosterContainer>
            </div>
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
      opacity: 0.8;
    }
  }
`
