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
      modalId: "",
      hover: false
    };
  }

  componentWillMount = () => {
    const path = `index.php/Home/getNowPlaying/20`;

    apiClient
      .get(path)
       .then(response => {
         console.log("SPON", response);
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
        id: this.state.films.id[i]
      }
    })
  }

  mouseOver = () => {
        this.setState({
          hover: true
        });
    }

    mouseOut = () => {
        this.setState({
          hover: false
        });
    }

    closeModal = () => {
      this.setState({
        isModalActive: false
      })
    }

    makeReservation = () => {
      console.log("TICKET");
    }

  viewFilm = i => {
    if(this.state.films.length > 0){
      return(
        <Film className="col-md-8 col-md-offset-2">
          <div className="row">
            <div className="col-md-2" style={{marginTop: "4vh"}} onClick={this.openFilmPage.bind(this,i)}>
              <ReactImageFallback
                    src={this.state.films[i].poster}
                    fallbackImage={loaderImage}
                    initialImage={loaderImage}
                    className="img-responsive"
                  />
            </div>
            <Title className="col-md-6"  onClick={this.openFilmPage.bind(this,i)}>{this.state.films[i].title}</Title>
            <Ticket className="col-md-2" onClick={this.makeReservation}>
              <a target="_blank" href={this.state.films[i].eventList[0].link}>
                <img
                  src={require("../images/ticket.png")}
                  style={{ width: "200px" }}
                />
              </a>
            </Ticket>
          </div>
        </Film>
      )
    }
  }

  render() {
    console.log("FILMYYYY", this.state.films);
    return(
      <div>
        <div>{this.viewFilm(0)}</div>
        <div>{this.viewFilm(1)}</div>
        <div>{this.viewFilm(2)}</div>
        <div>{this.viewFilm(3)}</div>
        <div>{this.viewFilm(4)}</div>
        <div>{this.viewFilm(5)}</div>
        <div>{this.viewFilm(6)}</div>
        <div>{this.viewFilm(7)}</div>
        <div>{this.viewFilm(8)}</div>
        <div>{this.viewFilm(9)}</div>
        <div>{this.viewFilm(10)}</div>
        <div>{this.viewFilm(11)}</div>
        <div>{this.viewFilm(12)}</div>
        <div></div>
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
  background-color: rgba(30, 32, 32, 0.28);
  height: 31vh;
  margin-top: 5vh;
  overflow: hidden;
  &:hover{
    cursor: pointer;
    background-color: rgba(93, 93, 93, 0.28);
  }
`

const Title = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`
const styledModal = {
  overlay: {
    position: "fixed",
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: "rgba(23, 23, 23, 0.99)",
  },
  content: {
    position: "absolute",
    top: "0px",
    left: "-35vw",
    right: "0px",
    bottom: "0px",
    opacity: "1",
    WebkitOverflowScrolling: "touch",
    outline: "none",
    height: "100%",
    width: "100%",
    color: "rgb(201, 201, 201)",
    overflowY: "scroll",
    overflowX: "hidden"
  }
};
