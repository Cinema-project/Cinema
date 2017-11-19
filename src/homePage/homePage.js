import React, { Component } from "react";
import Calendar from "./calendar"
import apiClient from "../api-client";
var ReactGridLayout = require('react-grid-layout');

class homePage extends Component {
  constructor(props) {
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


  render() {
    console.log("Tytul:", this.state.title);
    console.log("Plakat:", this.state.poster);
    console.log("Ocena:", this.state.rating);
    return (
      <div className="row">
        <div className="col-md-12">

          <div className="col-md-3" style={{ paddingTop: "30px" }}>
            <Calendar />
          </div>
          <div className="col-md-9">
            <h1 style={{textAlign:"center"}}>Najlepiej ocenianie!</h1>
            <ReactGridLayout className="layout" cols={10} rowHeight={30} width={800}>
              <div key="a" data-grid={{ x: 1, y: 0, w: 2, h: 6, static: true }} style={{ }}><img className="img-responsive" src="https://i.pinimg.com/736x/fd/5e/66/fd5e662dce1a3a8cd192a5952fa64f02--classic-poster-classic-movies-posters.jpg" alt="logo"/></div>
              <div key="b" data-grid={{ x: 1, y: 0, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src="https://images-na.ssl-images-amazon.com/images/I/41xdbKFRo1L.jpg" alt="logo"/></div>
              <div key="c" data-grid={{ x: 1, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}>b</div>
              <div key="d" data-grid={{ x: 3, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}></div>
              <div key="e" data-grid={{ x: 3, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}>b</div>
              <div key="f" data-grid={{ x: 3, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}><img className="img-responsive" src="https://d9hhrg4mnvzow.cloudfront.net/seopages.adobeprojectm.com/make/posters/movie-posters/af9eaa0f-movie-1_09w0fb09w0fb000000.jpeg" alt="logo"/></div>
              <div key="g" data-grid={{ x: 5, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}>b</div>
              <div key="h" data-grid={{ x: 5, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}></div>
              <div key="i" data-grid={{ x: 5, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}>b</div>
              <div key="j" data-grid={{ x: 7, y: 0, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src="https://d9hhrg4mnvzow.cloudfront.net/seopages.adobeprojectm.com/make/posters/movie-posters/af9eaa0f-movie-1_09w0fb09w0fb000000.jpeg" alt="logo"/></div>
              <div key="k" data-grid={{ x: 7, y: 0, w: 2, h: 6, static: true }} style={{backgroundColor: 'white'}}><img className="img-responsive" src="https://d9hhrg4mnvzow.cloudfront.net/seopages.adobeprojectm.com/make/posters/movie-posters/af9eaa0f-movie-1_09w0fb09w0fb000000.jpeg" alt="logo"/></div>
            </ReactGridLayout>
          </div>

        </div>
      </div>
    );
  }
}

export default homePage;
