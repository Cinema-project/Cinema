import React, { Component } from "react";
import apiClient from "../api-client";
import { DropdownButton, MenuItem, Button } from "react-bootstrap";

class Films extends Component {
  constructor(props) {
    super(props);
    this.state = {
      genres: [],
      };
  }

  componentWillMount = () => {
    console.log("MOUNT");
    apiClient
      .get("index.php/Home/getCategoryList/PL")
      .then(response => {
        this.setState((state) => ({ genres: response.data.genres }))
      })
      .catch(error => {
        console.log(error);
      });




  };

  loadMovies = e => {
    const category = e;
    console.log(category);
    apiClient
      .get('index.php?/Home/getMovies/PL/'+category)
      .then(response => {
       console.log(response);
      })
      .catch(error => {
        console.log(error);
      });
  }

  render() {
    return (
      <div className="container-fluid">
        <div className="col-md-12" style={{ paddingTop: "5vh", paddingLeft: "5vh" }}>
          <DropdownButton title= {"Wybierz kategorie"} onSelect={this.loadMovies}>
            {this.state.genres.map((genre) => (
              <MenuItem eventKey={genre.id}>{genre.name} </MenuItem>
            ))}
          </DropdownButton>
        </div>
      </div>
    );
  }
}

export default Films;
