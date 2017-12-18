import React, { Component } from "react";
import apiClient from "../api-client";
import { DropdownButton, MenuItem, Button } from "react-bootstrap";
import ReactPaginate from "react-paginate";
import FilmView from "./FilmView"

class Films extends Component {
  constructor(props) {
    super(props);
    this.state = {
      genres: [],
      category: "",
      dropdownTitle: "Wybierz kategorie",
      page: 1
      };
  }

  componentWillMount = () => {
    apiClient
      .get("index.php/Home/getCategoryList/PL")
      .then(response => {
        this.setState((state) => ({ genres: response.data.genres }))
      })
      .catch(error => {
        console.log(error);
      });
 };

  loadMovies = e => {
    this.state.category = e;
    if(this.state.category === 28){
      this.setState((state) => ({dropdownTitle: "Akcja"}))
    }

    if(this.state.category === 12){
      this.setState((state) => ({dropdownTitle: "Przygodowy"}))
    }

    if(this.state.category === 16){
      this.setState((state) => ({dropdownTitle: "Animacja"}))
    }

    if(this.state.category === 35){
      this.setState((state) => ({dropdownTitle: "Komedia"}))
    }

    if(this.state.category === 80){
      this.setState((state) => ({dropdownTitle: "Kryminał"}))
    }

    if(this.state.category === 99){
      this.setState((state) => ({dropdownTitle: "Dokumentalny"}))
    }

    if(this.state.category === 18){
      this.setState((state) => ({dropdownTitle: "Dramat"}))
    }

    if(this.state.category === 10751){
      this.setState((state) => ({dropdownTitle: "Familijny"}))
    }

    if(this.state.category === 14){
      this.setState((state) => ({dropdownTitle: "Fantasy"}))
    }

    if(this.state.category === 36){
      this.setState((state) => ({dropdownTitle: "Historyczny"}))
    }

    if(this.state.category === 27){
      this.setState((state) => ({dropdownTitle: "Horror"}))
    }

    if(this.state.category === 10402){
      this.setState((state) => ({dropdownTitle: "Muzyczny"}))
    }

    if(this.state.category === 9648){
      this.setState((state) => ({dropdownTitle: "Tajemnica"}))
    }

    if(this.state.category === 10749){
      this.setState((state) => ({dropdownTitle: "Romans"}))
    }

    if(this.state.category === 878){
      this.setState((state) => ({dropdownTitle: "Sci-Fi"}))
    }

    if(this.state.category === 10770){
      this.setState((state) => ({dropdownTitle: "film TV"}))
    }

    if(this.state.category === 53){
      this.setState((state) => ({dropdownTitle: "Thriller"}))
    }

    if(this.state.category === 10752){
      this.setState((state) => ({dropdownTitle: "Wojenny"}))
    }

    if(this.state.category === 37){
      this.setState((state) => ({dropdownTitle: "Western"}))
    }
  }

  handlePageClick = e => {
    const page = e.selected + 1; //bo paginacja  od zera bierze a kino dopiero od 1
    this.setState({
      page: page
    })
  }

  render() {
    return (
      <div className="container-fluid">
        <div className="col-md-12" style={{ paddingTop: "5vh", paddingLeft: "5vh" }}>
          <div className = "col-md-12">
            <DropdownButton title= {this.state.dropdownTitle} onSelect={this.loadMovies}>
              {this.state.genres.map((genre) => (
                <MenuItem eventKey={genre.id}>{genre.name} </MenuItem>
              ))}
            </DropdownButton>
          </div>
          <FilmView className="col-md-12" categoryId={this.state.category} pageNumber={this.state.page}/>
          <div className="col-md-12" style={{textAlign:"center"}}>
            <ReactPaginate previousLabel={"wstecz"}
                       nextLabel={"następny"}
                       breakLabel={<a href="">...</a>}
                       breakClassName={"break-me"}
                       pageCount={this.state.pageCount}
                       marginPagesDisplayed={2}
                       pageRangeDisplayed={3}
                       onPageChange={this.handlePageClick}
                       containerClassName={"pagination"}
                       subContainerClassName={"pages pagination"}
                       activeClassName={"active"} />

            </div>
        </div>
      </div>
    );
  }
}

export default Films;
