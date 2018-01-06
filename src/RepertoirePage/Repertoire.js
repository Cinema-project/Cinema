import React, {Component} from "react";
import apiClient from "../api-client";
import RepertoireFilm from "./RepertoireFilm"
class Repertoire extends Component{
  constructor(props){
    super(props);
    this.state = {
      category: 12,
      page : 1
    };
  }

  componentDidMount = () => {
    console.log("MOUNT");
    apiClient
      .get("index.php/Home/getNowPlaying/40")
      .then(response => {
        console.log("REPERTUAR", response);
      })
      .catch(error => {
        console.log(error);
      });
  };

  render(){
    return(
      <div className = "container-fluid">
          <div className="col-md-12" style={{textAlign: "center"}}>
            <RepertoireFilm className="col-md-12" />
            </div>
      </div>
    );
  }
}

export default Repertoire;
