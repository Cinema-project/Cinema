import React, {Component} from "react";
import Calendar from "./calendar"
import apiClient from "../api-client";

class homePage extends Component{
  constructor(props){
    super(props);
    this.state = {
      title: "",
      poster: "",
      rating: ""
    };
  }

  componentWillMount = () => {
    console.log("MOUNT");
    apiClient
      .get("index.php?/Home/getPopular/1/PL")
      .then(response => {
        console.log("FILMY", response);
        this.setState({
          title: response.data.results[0].title,
          poster: response.data.results[0].poster_path,
          rating: response.data.results[0].vote_average
        });
      })
      .catch(error => {
        console.log(error);
      });
  };


  render(){
    console.log("Tytul:", this.state.title);
    console.log("Plakat:", this.state.poster);
    console.log("Ocena:", this.state.rating);
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
