import React, {Component} from "react";
import apiClient from "../api-client";
import { connect } from "react-redux";
import styled from "styled-components"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"
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

  render(){
    return(
      <div>
        {this.state.favourites.map(favourite=>
          <Film className="col-md-8 col-md-offset-2" style={{marginTop: "10vh"}}>
            <Title>{favourite.title}</Title>
            <img
              src={`https://image.tmdb.org/t/p/w500/${favourite.screen}`}
              style={{ width: "920px", height: "400px", borderRadius: "10px", opacity: "0.3"}}
            />
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

const Poster = styled.div`
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 4;

  &:hover{
    cursor: pointer;
  }
`

const Film = styled.div`
  position: relative;
`

const Title = styled.div`
  width: 100%;
  position: absolute;
  opacity: 1;
  color: white;
  text-shadow: 2px 2px 10px rgba(150, 150, 150, 1);
  font-size: 45px;
  text-align: center;
`

const Description = styled.div`
  text-align: center;
  font-size: 15px;
  color: white;
  margin-top: 4vh;
`

const Rating = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`
