import React, { Component } from "react";
import apiClient from "../api-client";
import styled from "styled-components"
import { withRouter } from "react-router";
import Modal from "react-modal";
import FilmModal from "../homePage/FilmModal"
import Button from "../user-interface/Button"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"

export class FilmView extends Component {
  constructor(props) {
    super(props);
    this.state = {
      title: [],
      poster: [],
      rating: [],
      id: [],
      isModalActive: false,
      modalId: "",
      hover: false
    };
  }

  componentWillMount = () => {
    const path = `index.php?/Home/getMovies/PL/${this.props.categoryId}/${this.props.pageNumber}`;

    apiClient
      .get(path)
       .then(response => {
         console.log(response);
         {response.data.results.map(r =>
           this.setState(previousState =>({
             title: [...previousState.title, r.title],
             poster: [...previousState.poster, r.poster],
             rating: [...previousState.rating, r.voteAverage],
             id: [...previousState.id, r.id]
           }))
         )}
      })
      .catch(error => {
        console.log(error);
      });
  }

  componentWillReceiveProps = (nextProps) => {
    const path = `index.php?/Home/getMovies/PL/${nextProps.categoryId}/${nextProps.pageNumber}`;
    console.log(nextProps.pageNumber);
    console.log(nextProps.categoryId);
    this.setState({
      title: [],
      poster: [],
      rating: [],
      id: []
    })

    apiClient
      .get(path)
      .then(response => {
        console.log(response);
        {response.data.results.map(r =>
          this.setState(previousState =>({
            title: [...previousState.title, r.title],
            poster: [...previousState.poster, r.poster],
            rating: [...previousState.rating, r.voteAverage],
            id: [...previousState.id, r.id]
          }))
        )}
     })
      .catch(error => {
        console.log(error);
      });
  }

  toogleModal = number => {
    this.setState({
      isModalActive: !this.state.isModalActive,
      modalId: this.state.id[number]
    });
  };

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

    showStar = () => {
        if(this.state.hover === false){
          return(
            <img
              src={require("../images/whiteStar.png")}
              style={{ width: "64px" }}
            />
          )
        } else if(this.state.hover === true){
          return(
            <img
              src={require("../images/yellowStar.png")}
              style={{ width: "64px" }}
            />
          )
        }
    }

    closeModal = () => {
      this.setState({
        isModalActive: false
      })
    }

    openFilmPage = i => {
      this.props.router.push({
        pathname: 'film_page',
        state:{
          id: this.state.id[i]
        }
      })
    }

  viewFilm = i => {
    return(
      <Film className="col-md-8 col-md-offset-2">
        {/* <Modal
          isOpen={this.state.isModalActive}
          onRequestClose={this.toogleModal}
          className="col-md-4 col-md-offset-4"
          style={styledModal}>
          <Button
            onClick={this.closeModal}
            label={"X"}
            style={{marginLeft: "80vw", color: "black"}}
          />
          <FilmModal title={this.state.modalTitle} id={this.state.modalId}/>
        </Modal> */}
        <div className="row">
          <div className="col-md-2" style={{marginTop: "4vh"}}>
            <ReactImageFallback
                  src={this.state.poster[i]}
                  fallbackImage={loaderImage}
                  initialImage={loaderImage}
                  className="img-responsive"

                />
          </div>
          <Title className="col-md-6">{this.state.title[i]}</Title>
          <Rating className="col-md-2">{this.state.rating[i]}</Rating>
          <Star className="col-md-2" onMouseOver={this.mouseOver.bind(this,i)} onMouseOut={this.mouseOut.bind(this,i)}>
            {this.showStar()}
          </Star>
        </div>
      </Film>
    )
  }

  render() {
    return(
      <div>
        <div onClick = {this.openFilmPage.bind(this,0)}>{this.viewFilm(0)}</div>
        <div onClick = {this.openFilmPage.bind(this,1)}>{this.viewFilm(1)}</div>
        <div onClick = {this.openFilmPage.bind(this,2)}>{this.viewFilm(2)}</div>
        <div onClick = {this.openFilmPage.bind(this,3)}>{this.viewFilm(3)}</div>
        <div onClick = {this.openFilmPage.bind(this,4)}>{this.viewFilm(4)}</div>
        <div onClick = {this.openFilmPage.bind(this,5)}>{this.viewFilm(5)}</div>
        <div onClick = {this.openFilmPage.bind(this,6)}>{this.viewFilm(6)}</div>
        <div onClick = {this.openFilmPage.bind(this,7)}>{this.viewFilm(7)}</div>
        <div onClick = {this.openFilmPage.bind(this,8)}>{this.viewFilm(8)}</div>
        <div onClick = {this.openFilmPage.bind(this,9)}>{this.viewFilm(9)}</div>
        <div onClick = {this.openFilmPage.bind(this,10)}>{this.viewFilm(10)}</div>
        <div onClick = {this.openFilmPage.bind(this,11)}>{this.viewFilm(11)}</div>
        <div onClick = {this.openFilmPage.bind(this,12)}>{this.viewFilm(12)}</div>
        <div onClick = {this.openFilmPage.bind(this,13)}>{this.viewFilm(13)}</div>
        <div onClick = {this.openFilmPage.bind(this,14)}>{this.viewFilm(14)}</div>
        <div onClick = {this.openFilmPage.bind(this,15)}>{this.viewFilm(15)}</div>
        <div onClick = {this.openFilmPage.bind(this,16)}>{this.viewFilm(16)}</div>
        <div onClick = {this.openFilmPage.bind(this,17)}>{this.viewFilm(17)}</div>
        <div onClick = {this.openFilmPage.bind(this,18)}>{this.viewFilm(18)}</div>
        <div>{this.viewFilm(19)}</div>
      </div>
    )
  }
}

export default withRouter(FilmView);

const Film = styled.div`
  background-color: rgba(50, 52, 52, 0.28);
  height: 31vh;
  margin-top: 5vh;

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

const Rating = styled.div`
  text-align: center;
  font-size: 30px;
  color: white;
  padding-top: 12vh;
`

const Star = styled.div`
  text-align: center;
  margin-top: 10vh;
`

const styledModal = {
  overlay: {
    position: "fixed",
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: "rgba(23, 23, 23, 0.99)"
  },
  content: {
    position: "fixed",
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
