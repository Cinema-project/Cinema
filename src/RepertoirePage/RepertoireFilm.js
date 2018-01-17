import React, { Component } from "react";
import apiClient from "../api-client";
import styled from "styled-components"
import Button from "../user-interface/Button"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"
import { withRouter } from "react-router";

export class RepetoireFilm extends Component {
  constructor(props) {
    super(props);
    this.state = {
      films: [],
      hover: false,
      hoveredDivId: -1
    };
  }

  componentWillMount = () => {
    const path = `index.php/Home/getNowPlaying/20`;

    apiClient
      .get(path)
       .then(response => {
         this.setState({
           films: response.data.movies
         })
      })
      .catch(error => {
        console.log(error);
      });
  }



  openFilmPage = i => {
    this.props.router.push({
      pathname: 'film_page',
      state:{
        id: this.state.films[i].id
      }
    })
  }

  mouseOver = i => {
        this.setState({
          hoveredDivId: i
        });

    }

    mouseOut = () => {
        this.setState({
          hoveredDivId: -1
        });
    }

    showTicket = i => {
      if(this.state.hoveredDivId === i){
        return(
            <img
            src={require("../images/ticketYellow.png")}
            style={{ width: "200px" }}
          />
        )
      }else{
        return(
          <img
          src={require("../images/ticket.png")}
          style={{ width: "200px" }}
        />
      )
      }
    }

  render() {
    return(
      <div>
        {this.state.films.map((film, i) =>
          <Film className="col-md-8 col-md-offset-2">
            <div className="row">
              <div className="col-md-2" style={{marginTop: "4vh"}} onClick={this.openFilmPage.bind(this,i)}>
                <ReactImageFallback
                      src={film.poster}
                      fallbackImage={loaderImage}
                      initialImage={loaderImage}
                      className="img-responsive"
                    />
              </div>
              <Title className="col-md-6"  onClick={this.openFilmPage.bind(this,i)}>{film.title}</Title>
              <Ticket className="col-md-2" id={i} onMouseOver={this.mouseOver.bind(this,i)} onMouseOut={this.mouseOut}>
                <a target="_blank" href={film.eventList[0].link}>
                  {this.showTicket(i)}
                </a>
              </Ticket>
            </div>
          </Film>
        )}
      </div>
    )
  }
}

export default withRouter(RepetoireFilm);

const Ticket = styled.div`
  width: auto;
  margin-left: 40px;
  margin-top: 10px;
  z-index: 4;
`

const Film = styled.div`
  background-color: rgba(13, 16, 18, 1);
  border-radius: 15px;
  height: 31vh;
  margin-top: 5vh;
  overflow: hidden;
  &:hover{
    cursor: pointer;
    background-color: rgba(40, 54, 68, 1);
  }
`

const Title = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`
