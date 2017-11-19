import React, {Component} from "react";
import apiClient from "../api-client";

class Repertoire extends Component{
  constructor(props){
    super(props);
    this.state = {

    };
  }

  componentWillMount = () => {
    console.log("MOUNT");
    apiClient
      .get("index.php/Home/getCinemaRepertoire/3")
      .then(response => {
        console.log("REPERTUAR", response);
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

export default Repertoire;
