import React, {Component} from "react";
import axios from "axios";

class Repertoire extends Component{
  constructor(props){
    super(props);
    this.state = {

    };
  }

  componentWillMount = () => {
    console.log("MOUNT");
    axios
      .get("./index.php/Home/getCategoryList/PL")
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
