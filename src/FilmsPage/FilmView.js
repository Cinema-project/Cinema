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
      title: [],
      poster: [],
      rating: [],
      id: [],
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
         {response.data.results.map(r =>
           this.setState(previousState =>({
             title: [...previousState.title, r.title],
             poster: [...previousState.poster, r.poster],
             rating: [...previousState.rating, r.voteAverage],
             id: [...previousState.id, r.id]
           }))
         )}
      })
      .catch(error => {
        console.log(error);
      });

      this.getFavourites();
  }

  componentWillReceiveProps = (nextProps) => {
    const path = `index.php?/Home/getMovies/PL/${nextProps.categoryId}/${nextProps.pageNumber}`;
    this.setState({
      title: [],
      poster: [],
      rating: [],
      id: []
    })

    apiClient
      .get(path)
      .then(response => {
        {response.data.results.map(r =>
          this.setState(previousState =>({
            title: [...previousState.title, r.title],
            poster: [...previousState.poster, r.poster],
            rating: [...previousState.rating, r.voteAverage],
            id: [...previousState.id, r.id]
          }))
        )}
     })
      .catch(error => {
        console.log(error);
      });
  }

  toogleModal = number => {
    this.setState({
      isModalActive: !this.state.isModalActive,
      modalId: this.state.id[number]
    });
  };

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

    openFilmPage = i => {
      this.props.router.push({
        pathname: 'film_page',
        state:{
          id: this.state.id[i]
        }
      })
    }

    showStar = i => {
      let x = 0;
      for(var a = 0; a < this.state.favourites.length; a++){
        for(var b = 0; b < this.state.id.length; b++){
          if(this.state.favourites[a].id === this.state.id[i]){
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

    removeFromFavourites = i => {
      $.ajax({
          url: process.env.NODE_ENV !== "production" ? `http://localhost:80/Cinema/index.php/Favorites/removeFavoriteMovie/${this.state.id[i]}` : `http://localhost:80/Cinema/index.php/Favorites/removeFavoriteMovie/${this.state.id[i]}`,
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

    addToFavourites = i => {
      $.ajax({
          url: process.env.NODE_ENV !== "production" ? `http://localhost:80/Cinema/index.php/Favorites/addFavoriteMovie/${this.state.id[i]}` : `http://localhost:80/Cinema/index.php/Favorites/addFavoriteMovie/${this.state.id[i]}`,
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

    addToFavouritesOrRemove = i => {
      let x = 0;
      for(var a = 0; a < this.state.favourites.length; a++){
        for(var b = 0; b < this.state.id.length; b++){
          if(this.state.favourites[a].id === this.state.id[i]){
            x = 1;
          }
        }
      }
      if(x === 0){
        this.addToFavourites(i);
      }else{
        this.removeFromFavourites(i);
      }
    }

  viewFilm = i => {
    return(
      <Film className="col-md-8 col-md-offset-2">
        <div className="row">
          <div className="col-md-2" style={{marginTop: "4vh"}} onClick = {this.openFilmPage.bind(this,i)}>
            <ReactImageFallback
                  src={this.state.poster[i]}
                  fallbackImage={loaderImage}
                  initialImage={loaderImage}
                  className="img-responsive"

                />
          </div>
          <Title className="col-md-6" onClick = {this.openFilmPage.bind(this,i)}>{this.state.title[i]}</Title>
          <Rating className="col-md-2" onClick = {this.openFilmPage.bind(this,i)}>{this.state.rating[i]}</Rating>
          <Star className="col-md-2"
            id={i}
            onMouseOver={this.mouseOver.bind(this,i)}
            onMouseOut={this.mouseOut}
            onClick={this.addToFavouritesOrRemove.bind(this,i)}>
            {this.showStar(i)}
          </Star>
        </div>
      </Film>
    )
  }

  render() {
    return(
      <div>
        <div>{this.viewFilm(0)}</div>
        <div>{this.viewFilm(1)}</div>
        <div>{this.viewFilm(2)}</div>
        <div>{this.viewFilm(3)}</div>
        <div>{this.viewFilm(4)}</div>
        <div>{this.viewFilm(5)}</div>
        <div>{this.viewFilm(6)}</div>
        <div>{this.viewFilm(7)}</div>
        <div>{this.viewFilm(8)}</div>
        <div>{this.viewFilm(9)}</div>
        <div>{this.viewFilm(10)}</div>
        <div>{this.viewFilm(11)}</div>
        <div>{this.viewFilm(12)}</div>
        <div>{this.viewFilm(13)}</div>
        <div>{this.viewFilm(14)}</div>
        <div>{this.viewFilm(15)}</div>
        <div>{this.viewFilm(16)}</div>
        <div>{this.viewFilm(17)}</div>
        <div>{this.viewFilm(18)}</div>
        <div>{this.viewFilm(19)}</div>
        <div>{this.viewFilm(19)}</div>
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
