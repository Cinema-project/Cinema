import React, {Component} from "react";
import apiClient from "../api-client";
import { connect } from "react-redux";
var $ = require('jquery');

class Favourites extends Component{
  constructor(props){
    super(props);
    this.state = {
      favourites: []
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
    console.log("FAV PAGE:", this.state.favourites);
    return(
      <div className = "row">
      </div>
    );
  }
}

const mapStateToProps = state => {
  return {
    user: state.session.user
  };
};

export default connect(mapStateToProps)(Favourites);
