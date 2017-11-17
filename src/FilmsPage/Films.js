import React, {Component} from "react";
import axios from "axios";

class Films extends Component{
  constructor(props){
    super(props);
    this.state = {

    };
  }

  componentWillMount = () => {
    console.log("MOUNT");
    axios
      .get("./index.php/Home/getMovies")
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
