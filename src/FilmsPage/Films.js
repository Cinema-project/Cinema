import React, {Component} from "react";
import apiClient from "../api-client";

class Films extends Component{
  constructor(props){
    super(props);
    this.state = {

    };
  }

  componentWillMount = () => {
    console.log("MOUNT");
    apiClient
      .get("index.php/Home/getMovies")
      .then(response => {
        console.log("FILMY", response);
      })
      .catch(error => {
        console.log(error);
      });
  };

  render(){
    return(
      <div className = "row">
      </div>
    );
  }
}

export default Films;
