import React, { Component } from "react";

var $ = require('jquery');

class Repertoire extends Component {
  constructor(props) {
    super(props);
    this.state = { genres: [] };


  }
  componentWillMount() {
    $.ajax({
      url: process.env.NODE_ENV !== "production" ? './index.php/Home/getCategoryList/PL' : "./index.php/Home/getCategoryList/PL",

      type: 'POST',
      data: {},
      success: function (data) {
        var myObject = JSON.parse(data);
        this.state.genres = myObject.genres;
         {this.state.genres.map(function (item) {
                    console.log(item.id);
                    console.log(item.name);
                  })}
      }.bind(this),
      error: function (xhr, status, err) {
        console.log(xhr, status);
        console.log(err);
        this.setState({
          contactMessage: 'Błąd pobierania kategorii',
        });
      }.bind(this)
    });
  };
  render() {
    return (
      <div className="row">
        <div className="col-md-12">
          <div className="cold-md-2">
            
          </div>
        </div>

      </div>
    );
  }
}

export default Repertoire;
