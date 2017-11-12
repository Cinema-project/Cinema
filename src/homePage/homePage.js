import React, {Component} from "react";
import Calendar from "./calendar"

class homePage extends Component{
  render(){
    return(
      <div className = "row">
        <div className = "col-md-12">

            <div className = "col-md-3" style={{backgroundColor: "gray"}}>
              <Calendar />
              <Calendar />
            </div>
            <div className = "col-md-9">
            </div>

        </div>
      </div>
    );
  }
}

export default homePage;
