import React from "react";
import styled from "styled-components";
import { Link } from "react-router";
import { connect } from "react-redux";
import Button from "./user-interface/Button";
import NavbarLink from "./NavbarLink";

class Layout extends React.Component {
  render() {
    return (
      <div className="container-fluid">
        <div className="row">

          <div className="col-md-12">
            <Searchbar>
              <div className="col-md-4">
              <Link to="home_page" style={{ border: "none" }}>
                <img
                  src={require("./images/navbarImage.png")}
                  style={{ width: "80px" }}
                />
              </Link>
              <Link to="home_page">
                MyCinema
              </Link>
            </div>
            <div className="col-md-4">
              <div className="input-group" style={{width: "30vw", marginTop: "3.5vh"}}>
                <input
                  onChange={this.updatePlace}
                  type="text"
                  className="form-control"
                  placeholder="Enter text"
                />
                <span className="input-group-btn">
                  <button
                    onClick={this.onSubmit}
                    className="btn btn-info"
                    type="button">
                    Search
                  </button>
                </span>
              </div>
            </div>
            <div className="col-md-4">
              <a href="#">
                <span class="glyphicon glyphicon-log-out" style={{float: "right", fontSize: "40px"}}></span>
              </a>
            </div>
            </Searchbar>
          </div>
          <div className="col-md-12">
            <StyledNavbar>
              <NavbarLink to="repertoire" name="Repertuar" />
              <NavbarLink to="announcements" name="Zapowiedzi" />
              <NavbarLink to="favourites" name="Ulubione" />
              <NavbarLink to="films" name="Filmy" />
              <NavbarLink to="find_cinema" name="Znajdź kino" />
            </StyledNavbar>
          </div>
          <div className="col-md-12">
            {this.props.children}
          </div>
        </div>
      </div>
    );
  }
}

export default connect()(Layout);

const StyledNavbar = styled.div`
  background-color: gray;
  overflow: hidden;
  margin-bottom: 0px;
  text-align: center;
  ${'' /* text-shadow: 3px 3px 1px rgba(0, 0, 0, 1); */}
  a {
    margin-left: 75px;
    margin-right: 25px;
    text-align: center;
    font-family: 'Julee', cursive;
    font-size: 20px;
    font-size: 2vmax;
    color: black;
    text-decoration: none;

    &:hover {
      color: rgb(231, 231, 231);
      text-decoration: none;
      border-bottom: 4px solid rgb(138, 2, 2);
      cursor: pointer;
    }
  }
`;

const Searchbar = styled.div`
  background-color: gray;
  overflow: hidden;
  padding-top: 10px;
  margin-top: 10px;
  text-align: left;
  ${'' /* text-shadow: 3px 3px 1px rgba(0, 0, 0, 1); */}
  a {
    margin-left: 5px;
    margin-right: 25px;
    text-align: center;
    font-family: 'Julee', cursive;
    font-size: 50px;
    font-size: 4vmax;
    color: black;
    text-decoration: none;
  }
`;

const TopStripUserInformation = styled.div`
  display: flex;
  justify-content: flex-end;
  align-items: center;
  background-color: rgb(27, 27, 27);
  color: rgb(159, 159, 159);
  box-shadow: 2px 2px 1px rgba(0, 0, 0, 1);
  padding: 0px 20px 0px 5px;
  text-align: right;
  font-size: 12px;
`;

const StyledButton = styled(Button)`
  margin-left:10px;
  border-radius: 0px;
  background-color: rgb(166, 1, 1);
  height: 30px;
  color: rgb(208, 208, 208);
  font-family: Arial;
  font-size: 12px;
  padding-left: 15px;
  padding-right: 15px;
  box-shadow: none;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
`;

const StyledUserIcon = styled.div`
  display: inline;
  cursor: pointer;
  padding: 10px;
`;
const StyledCharacterSidebar = styled.div`
  text-align: right;
  margin-bottom: -25px;
`;
