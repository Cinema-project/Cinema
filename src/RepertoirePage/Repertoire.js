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
