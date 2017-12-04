import React from "react";
import styled from "styled-components";
import { Link } from "react-router";
import { connect } from "react-redux";
import Button from "./user-interface/Button";
import NavbarLink from "./NavbarLink";
import homePageBackground from "./images/it.jpg";

class Layout extends React.Component {
  render() {
    console.log("login:", this.props.user.login);
    return (
      <div className="container-fluid">
        <Background className="row">
          <div className="col-md-12">
            <Searchbar>
              <div className="col-md-4" style={{float: "left"}}>
                  <a href="https://www.facebook.com"><img
                    src={require("./images/facebook.png")}
                    style={{ width: "32px"}}
                  /></a>
                <a href="https://www.twitter.com"><img
                    src={require("./images/twitter.png")}
                    style={{ width: "32px"}}
                  /></a>
              <a href="https://www.instagram.com"><img
                  src={require("./images/instagram.png")}
                  style={{ width: "32px"}}
                /></a>
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
            <Nick>{this.props.user.login}</Nick>
            <Logout className="col-md-4">
              <a href="#">
                <span class="glyphicon glyphicon-log-out" style={{float: "right", fontSize: "40px"}}></span>
              </a>
            </Logout>
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

const mapStateToProps = state => {
  return {
    user: state.session.user
  };
};

export default connect(mapStateToProps)(Layout);

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

const Nick = styled.div`
  color: white;
  font-size: 20px;
  margin-left: 40vw;
  font-weight: bold;
  font-style: italic;
  transform: translateX(20vw);
`

const Logout = styled.div`
  transform: translateY(-3.5vh);
`

const StyledNavbar = styled.div`
  overflow: hidden;
  text-align: center;
  transform: translateY(-3vh);
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
  overflow: hidden;
  padding-top: 10px;
  margin-top: 10px;
  text-align: left;
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
