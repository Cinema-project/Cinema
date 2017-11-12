import React, { Component } from "react";
import { Router, Route, IndexRoute, hashHistory } from "react-router";
import LandingPage from "./MainPage/LandingPage";
import homePage from "./homePage/homePage"
import Layout from "./Layout"

class App extends Component {
  render() {
    return (
      <div className="conteiner">
        <Router history={hashHistory}>
          <Route path="/">
            <IndexRoute component={LandingPage} />
            <Route component={Layout}>
              <Route path="home_page" component={homePage} />
            </Route>
          </Route>
        </Router>
      </div>
    );
  }
}

export default App;
