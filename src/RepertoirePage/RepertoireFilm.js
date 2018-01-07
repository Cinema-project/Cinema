import React, { Component } from "react";
import apiClient from "../api-client";
import styled from "styled-components"
import Modal from "react-modal";
import FilmModal from "../homePage/FilmModal"
import Button from "../user-interface/Button"
import ReactImageFallback from "react-image-fallback"
import loaderImage from "../images/loader.GIF"

export default class RepetoireFilm extends Component {
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
    const path = `index.php/Home/getNowPlaying/20`;
    
    //const path = `index.php?/Home/getMovies/PL/`;
    apiClient
      .get(path)
       .then(response => {
         console.log(response);
         {response.data.movies.map(r =>
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
      isModalActive: true,
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

    closeModal = () => {
      this.setState({
        isModalActive: false
      })
    }

  viewFilm = i => {
    
    return(
      <Film className="col-md-8 col-md-offset-2" >
        <Modal
          isOpen={this.state.isModalActive}
          onRequestClose={this.toogleModal}
          className="col-md-4 col-md-offset-4"
          style={styledModal}>
          <Button
            onClick={this.closeModal}
            label={"X"}
            style={{marginLeft: "98vw", color: "black"}}
          />
          <FilmModal title={this.state.modalTitle} id={this.state.modalId}/>
        </Modal>
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
          
          
        </div>
      </Film>
    )
  }

  render() {
    if(this.isModalActive){
      return null;
    }
    return(
      <div>
        <div onClick = {this.toogleModal.bind(this,0)}>{this.viewFilm(0)}</div>
        <div onClick = {this.toogleModal.bind(this,1)}>{this.viewFilm(1)}</div>
        <div onClick = {this.toogleModal.bind(this,2)}>{this.viewFilm(2)}</div>
        <div onClick = {this.toogleModal.bind(this,3)}>{this.viewFilm(3)}</div>
        <div onClick = {this.toogleModal.bind(this,4)}>{this.viewFilm(4)}</div>
        <div onClick = {this.toogleModal.bind(this,5)}>{this.viewFilm(5)}</div>
        <div onClick = {this.toogleModal.bind(this,6)}>{this.viewFilm(6)}</div>
        <div onClick = {this.toogleModal.bind(this,7)}>{this.viewFilm(7)}</div>
        <div onClick = {this.toogleModal.bind(this,8)}>{this.viewFilm(8)}</div>
        <div onClick = {this.toogleModal.bind(this,9)}>{this.viewFilm(9)}</div>
        <div onClick = {this.toogleModal.bind(this,10)}>{this.viewFilm(10)}</div>
        <div onClick = {this.toogleModal.bind(this,11)}>{this.viewFilm(11)}</div>
        <div>{this.viewFilm(12)}</div>
        <div></div>
      </div>
    )
  }
}

const Film = styled.div`
  background-color: rgba(30, 32, 32, 0.28);
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
    color: "rgb(201, 201, 201)"
  }
};