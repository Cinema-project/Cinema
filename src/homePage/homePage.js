import React, { Component } from "react";
import Calendar from "./calendar"
import apiClient from "../api-client";
import ReactGridLayout from 'react-grid-layout'

class homePage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      title: [],
      poster: [],
      rating: []
    };
  }

  componentWillMount = () => {
    apiClient
      .get("index.php?/Home/getPopular/1/PL")
      .then(response => {
        {response.data.results.map(r =>
          this.setState(previousState =>({
            title: [...previousState.title, r.title],
            poster: [...previousState.poster, r.poster_path],
            rating: [...previousState.rating, r.vote_average]
          }))
        )}
      })
      .catch(error => {
        console.log(error);
      });
  };


  render() {
    return (
      <div className="container-fluid">
        <div className="col-md-12">
          <div className="col-md-3" style={{ paddingTop: "30px" }}>
            <Calendar />
          </div>
          <div className="col-md-9" style={{ paddingTop: "20px" }}>
            <ReactGridLayout className="layout" cols={10} rowHeight={30} width={800}>
              <div key="a" data-grid={{ x: 0, y: 0, w: 4, h: 12, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[0]}`} alt="logo"/></div>
              <div key="b" data-grid={{ x: 4, y: 0, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[1]}`} alt="logo"/></div>
              <div key="c" data-grid={{ x: 6, y: 0, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[2]}`} alt="logo"/></div>
              <div key="d" data-grid={{ x: 4, y: 6, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[3]}`} alt="logo"/></div>
              <div key="e" data-grid={{ x: 6, y: 6, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[4]}`} alt="logo"/></div>
              <div key="f" data-grid={{ x: 8, y: 0, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[5]}`} alt="logo"/></div>
              <div key="g" data-grid={{ x: 8, y: 0, w: 2, h: 6, static: true }} style={{}}><img className="img-responsive" src={`https://image.tmdb.org/t/p/w500${this.state.poster[6]}`} alt="logo"/></div>
            </ReactGridLayout>
          </div>
        </div>
      </div>
    );
  }
}

export default homePage;
