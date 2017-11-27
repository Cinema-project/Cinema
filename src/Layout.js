import React from "react";
import styled from "styled-components";
import { Link } from "react-router";
import { connect } from "react-redux";
import Button from "./user-interface/Button";
import NavbarLink from "./NavbarLink";
import homePageBackground from "./images/it.jpg";

class Layout extends React.Component {
  render() {
    return (
      <div className="container-fluid">
        <Background className="row">

          <div className="col-md-12">
            <Searchbar>
              <div className="col-md-4" style={{float: "left"}}>
                <Link to="home_page" style={{ border: "none" }}>
                <img
                  src={require("./images/facebook.png")}
                  style={{ width: "32px" }}
                />
              </Link>
                <Link to="home_page" style={{ border: "none" }}>
                <img
                  src={require("./images/twitter.png")}
                  style={{ width: "32px" }}
                />
              </Link>
              <Link to="home_page" style={{ border: "none" }}>
              <img
                src={require("./images/instagram.png")}
                style={{ width: "32px" }}
              />
            </Link>
            </div>
              <div className="col-md-4">
              <Link to="home_page" style={{ border: "none" }}>
                <img
                  src={require("./images/icon2.png")}
                  style={{ width: "64px" }}
                />
              </Link>
              <Link to="home_page">
                MyCinema
              </Link>
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
          <div className="col-md-12" style={{paddingTop: "15vh"}}>
            {this.props.children}
          </div>
          </Background>
      </div>
    );
  }
}

export default connect()(Layout);

const Background = styled.div `
  background-color: black;
background-image: url(${homePageBackground});
box-shadow: inset 10px 0px 30px 30px #000000;
background-repeat: no-repeat;
background-position: center;
background-size: auto;
min-height: 40vh;
max-height: 40vh;
min-width: 98.5vw;
`

const StyledNavbar = styled.div`
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
    color: white;
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
  ${'' /* background-color: gray; */}
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
    color: white;
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
