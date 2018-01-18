import React, { Component } from "react";
import apiClient from "../api-client";
import styled from "styled-components"
import { withRouter } from "react-router";
import Button from "../user-interface/Button"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"
import { connect } from "react-redux";
var $ = require('jquery');

export class FilmView extends Component {
  constructor(props) {
    super(props);
    this.state = {
      films: [],
      isModalActive: false,
      modalId: "",
      hoveredDivId: -1,
      favourites: []
    };
  }

  getFavourites = () => {
    $.ajax({
        url: process.env.NODE_ENV !== "production" ? `http://localhost:80/Cinema/index.php/Favorites/getFavorites` : `http://localhost:80/Cinema/index.php/Favorites/getFavorites`,
        type: 'POST',
        data: {
          'token' : this.props.user.token,
        },
        success: function(data) {
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

  componentWillMount = () => {
    const path = `index.php?/Home/getMovies/PL/${this.props.categoryId}/${this.props.pageNumber}`;

    apiClient
      .get(path)
       .then(response => {
         this.setState({
           films: response.data.results
         })
      })
      .catch(error => {
        console.log(error);
      });

      this.getFavourites();
  }

  componentWillReceiveProps = (nextProps) => {
    const path = `index.php?/Home/getMovies/PL/${nextProps.categoryId}/${nextProps.pageNumber}`;
    this.setState({
      films: []
    })

    apiClient
      .get(path)
      .then(response => {
        this.setState({
          films: response.data.results
        })
     })
      .catch(error => {
        console.log(error);
      });
  }

  mouseOver = i => {
        this.setState({
          hoveredDivId: i
        });

    }

    mouseOut = () => {
        this.setState({
          hoveredDivId: -1
        });
    }

    closeModal = () => {
      this.setState({
        isModalActive: false
      })
    }

    openFilmPage = id => {
      this.props.router.push({
        pathname: 'film_page',
        state:{
          id: id
        }
      })
    }

    showStar = i => {
      let x = 0;
      for(var a = 0; a < this.state.favourites.length; a++){
        for(var b = 0; b < this.state.films.length; b++){
          if(this.state.favourites[a].id === this.state.films[i].id){
            x = 1;
          }
        }
      }
      if(this.state.hoveredDivId === i || x === 1){
        return(
            <img
            src={require("../images/yellowStar.png")}
            style={{ width: "64px" }}
          />
        )
      }else{
        return(
          <img
          src={require("../images/whiteStar.png")}
          style={{ width: "64px" }}
        />
        )
      }
    }

    removeFromFavourites = id => {
      $.ajax({
          url: process.env.NODE_ENV !== "production" ? `http://localhost:80/Cinema/index.php/Favorites/removeFavoriteMovie/${id}` : `http://localhost:80/Cinema/index.php/Favorites/removeFavoriteMovie/${id}`,
          type: 'POST',
          data: {
            'token' : this.props.user.token
          },
          success: function(data) {
              this.getFavourites();
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

    addToFavourites = id => {
      $.ajax({
          url: process.env.NODE_ENV !== "production" ? `http://localhost:80/Cinema/index.php/Favorites/addFavoriteMovie/${id}` : `http://localhost:80/Cinema/index.php/Favorites/addFavoriteMovie/${id}`,
          type: 'POST',
          data: {
            'token' : this.props.user.token
          },
          success: function(data) {
              this.getFavourites();
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

    addToFavouritesOrRemove = id => {
      let x = 0;
      for(var a = 0; a < this.state.favourites.length; a++){
        for(var b = 0; b < this.state.films.length; b++){
          if(this.state.favourites[a].id === id){
            x = 1;
          }
        }
      }
      if(x === 0){
        this.addToFavourites(id);
      }else{
        this.removeFromFavourites(id);
      }
    }

  render() {
    console.log(this.state.films);
    return(
      <div>
        {this.state.films.map((film, i) =>
          <Film className="col-md-8 col-md-offset-2">
            <div className="row">
              <div className="col-md-2" style={{marginTop: "4vh"}} onClick = {this.openFilmPage.bind(this, film.id)}>
                <ReactImageFallback
                      src={film.poster}
                      fallbackImage={loaderImage}
                      initialImage={loaderImage}
                      className="img-responsive"
                    />
              </div>
              <Title className="col-md-6" onClick = {this.openFilmPage.bind(this, film.id)}>{film.title}</Title>
              <Rating className="col-md-2" onClick = {this.openFilmPage.bind(this, film.id)}>{film.voteAverage}</Rating>
              <Star className="col-md-2"
                id={i}
                onMouseOver={this.mouseOver.bind(this,i)}
                onMouseOut={this.mouseOut}
                onClick={this.addToFavouritesOrRemove.bind(this,film.id)}>
                {this.showStar(i)}
              </Star>
            </div>
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

export default connect(mapStateToProps)(withRouter(FilmView));

const Film = styled.div`
  background-color: rgba(13, 16, 18, 1);
  border-radius: 15px;
  height: 31vh;
  margin-top: 5vh;
  overflow: hidden;
  &:hover{
    cursor: pointer;
    background-color: rgba(40, 54, 68, 1);
  }
`

const Title = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`

const Rating = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`

const Star = styled.div`
  text-align: center;
  margin-top: 10vh;
`
