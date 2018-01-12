import React, { Component } from "react";
import { Router, Route, IndexRoute, hashHistory } from "react-router";
import LandingPage from "./MainPage/LandingPage";
import HomePage from "./homePage/homePage"
import FindCinema from "./findCinemaPage/FindCinema"
import Repertoire from "./RepertoirePage/Repertoire"
import Announcements from "./AnnouncementsPage/Announcements"
import Favourites from "./FavouritesPage/Favourites"
import Films from "./FilmsPage/Films"
import Layout from "./Layout"
import FilmPage from "./FilmPage"

class App extends Component {
  render() {
    return (
      <div className="conteiner">
        <Router history={hashHistory}>
          <Route path="/">
            <IndexRoute component={LandingPage} />
            <Route component={Layout}>
              <Route path="home_page" component={HomePage} />
              <Route path="repertoire" component={Repertoire} />
              <Route path="announcements" component={Announcements} />
              <Route path="favourites" component={Favourites} />
              <Route path="films" component={Films} />
              <Route path="find_cinema" component={FindCinema} />
            </Route>
            <Route path="film_page" component={FilmPage} />
          </Route>
        </Router>
      </div>
    );
  }
}

export default App;
