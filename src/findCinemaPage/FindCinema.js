import React, {Component} from "react";
import MapContainer from "./MapContainer"

class FindCinema extends Component{
  render(){
    return(
      <div className = "row">
        <div className = "col-md-3 col-md-offset-4" style={{height: "70vh", width: "70vh", paddingTop: "50px"}}>
          <MapContainer/>
        </div>
      </div>
    );
  }
}

export default FindCinema;
