import React, {Component} from "react";
import Calendar from "./calendar"
import axios from "axios";

class homePage extends Component{

  render(){
    return(
      <div className = "row">
        <div className = "col-md-12">

            <div className = "col-md-2" style={{paddingTop: "30px"}}>
              <Calendar />
            </div>
            <div className = "col-md-10">
            </div>

        </div>
      </div>
    );
  }
}

export default homePage;
