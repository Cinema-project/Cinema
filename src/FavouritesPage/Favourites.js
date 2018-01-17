import React, {Component} from "react";
import apiClient from "../api-client";
import { connect } from "react-redux";
import styled from "styled-components"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"
import { Line, Circle } from 'rc-progress';
import TextTruncate from 'react-text-truncate';
var $ = require('jquery');

class Favourites extends Component{
  constructor(props){
    super(props);
    this.state = {
      favourites: [],
      backs: []
    }
  }

  componentWillMount(){
    $.ajax({
        url: process.env.NODE_ENV !== "production" ? `http://localhost:80/Cinema/index.php/Favorites/getFavorites` : `http://localhost:80/Cinema/index.php/Favorites/getFavorites`,
        type: 'POST',
        data: {
          'token' : this.props.user.token,
        },
        success: function(data) {
          console.log("DATA FAV", data);
          this.setState({
            favourites: data.movies
          })
         }.bind(this),
        error: function(xhr, status, err) {
          console.log(xhr, status);
          console.log(err);
          this.setState({
            contactMessage: 'Błąd',
          });
        }.bind(this)
      });
  }

  openFilmPage = id => {
    this.props.router.push({
      pathname: 'film_page',
      state:{
        id: id
      }
    })
  }

  getVoteAverage = vote => {
    let number = "";
    if(vote % 2 === 1 || vote % 2 === 0){
      number = vote + ".0";
    }else{
      number = vote;
    }

    return number;
  }

  render(){
    return(
      <div>
        {this.state.favourites.map(favourite=>
          <Film className="col-md-8 col-md-offset-2" onClick={this.openFilmPage.bind(this, favourite.id)}>
            <Title>{favourite.title}</Title>
            <img
              src={`https://image.tmdb.org/t/p/w600/${favourite.screen}`}
              style={{ width: "920px", height: "400px", borderRadius: "10px", opacity: "0.3"}}
            />
            <Graph className="col-md-3">
              <Circle
                percent={favourite.voteAverage * 10}
                strokeWidth="12"
                strokeColor="#D3D3D3"
                trailWidth={0}
                trailColor="rgba(124, 124, 124, 0.48)" />
                <Vote>
                  <div style={{paddingLeft: "3px"}}>
                    <img
                      src={require("../images/rating.png")}
                      style={{ width: "50px" }}
                    />
                  </div>
                  {this.getVoteAverage(favourite.voteAverage)}
                </Vote>
            </Graph>
            <Description className="col-md-7">
              <TextTruncate
                line={7}
                truncateText="…"
                text={favourite.description}
              />
            </Description>
          </Film>
        )}
      </div>
    )
  }
}

const mapStateToProps = state => {
  return {
    user: state.session.user
  };
};

export default connect(mapStateToProps)(Favourites);

const Film = styled.div`
  position: relative;
  margin-top: 10vh;
  &:hover{
    cursor: pointer;
    opacity: 0.8;
  }
`

const Graph = styled.div`
  position: absolute;
  left: 10%;
  top: 30%;
  height: 25vh;
  z-index: 4;
`

const Vote = styled.div`
  position: relative;
  left: 5vw;
  bottom: 22vh;
  color: white;
  font-size: 40px;
  font-weight: bold;
  z-index: 4;
`

const Title = styled.div`
  width: 100%;
  position: absolute;
  top: 2vh;
  opacity: 1;
  color: white;
  text-shadow: 2px 2px 10px rgba(150, 150, 150, 1);
  font-size: 45px;
  text-align: center;
  z-index: 4;
`

const Description = styled.div`
  position: absolute;
  left: 35%;
  top: 30%;
  height: 100%;
  text-align: center;
  vertical-align: middle;
  font-size: 15px;
  font-weight: bold;
  color: white;
  margin-top: 4vh;
`

const Rating = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`
