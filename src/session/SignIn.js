import React from "react";
import { withRouter } from "react-router";
import { connect } from "react-redux";
import styled from "styled-components";
import Input from "../user-interface/Input";
import Button from "../user-interface/Button";
import Loader from "../user-interface/Loader";
import { callToast } from "../lib/alert";
import axios from "axios";
var $ = require('jquery');

export class SignIn extends React.Component {
  constructor(props) {
    super(props);
    this.state = { login: "", password: "", loader: false,loginCheck: "",nick:"",token:""};

    this._handleSubmit = this._handleSubmit.bind(this);
    this._handleChange = this._handleChange.bind(this);
    this._handleChangeMsg = this._handleChangeMsg.bind(this);
  }

  updateLogin = e => {
    this.setState({ login: e.target.value });
  };

  updatePassword = e => {
    this.setState({ password: e.target.value });
  };

  onSubmit = e => {
    e.preventDefault();
  };

  apiErrorState = () => {
    this.setState({ login: "", password: "", loader: false });
  };

  loaderUpdate = () => {
    this.setState({
      loader: true
    });
  };

  _handleChange = e => {
    this.setState({
      login: e.target.value,
    });
  }
  // Change <textarea> value state onUpdate (while typing) so input is updated
  _handleChangeMsg = e => {
    this.setState({
      password: e.target.value
    });
  }

  _handleChange = e => {
    this.setState({
      login: e.target.value,
    });
  }
  // Change <textarea> value state onUpdate (while typing) so input is updated
  _handleChangeMsg = e =>{
    this.setState({
      password: e.target.value
    });
  }

  _handleSubmit(e){
  e.preventDefault();

  $.ajax({
      url: process.env.NODE_ENV !== "production" ? 'http://localhost:80/Cinema/index.php/Login/login' : "http://localhost:80/Cinema/index.php/Login/login",
      // url: "./php/mailer.php",
      //./index.php/Login/login
      type: 'POST',
      data: {
        'login': this.state.login,
        'password': this.state.password
      },
      success: function(data) {
        console.log("LOGIN", data);
        this.state.loginCheck = data['status'];
        this.state.nick = data['status'];
        this.state.token = data['token'];
        console.log(this.state.token);
        if(this.state.loginCheck!=null && this.state.loginCheck!="notExist"){
          this.props.dispatch({
            type: "LOGIN",
            data: {
              login: data.status,
              token: data.token
            }
          });
        this.props.router.push("home_page");
        }else{
      callToast("Wprowadzono niepoprawny e-mail i hasło.");
      }

      }.bind(this),
      error: function(xhr, status, err) {
        console.log(xhr, status);
        console.log(err);
        this.setState({
          contactMessage: 'Błąd',
        });
      }.bind(this)
    });
  };


  render() {
    return (
     <div className="row">
        <div className="col-md-12 " style={{ paddingTop: "30px" }}>
          <form onSubmit={this._handleSubmit}>
            <Input
              onChange={this.updateLogin}
              value={this.state.login}
              className="form-control"
              id="login"
              placeholder="E-mail"
            />
            <Input
              onChange={this.updatePassword}
              value={this.state.password}
              className="form-control"
              id="password"
              placeholder="Password"
              type="password"
            />
            <ConfirmationButton
              onClick={event => {
                this.onSubmit;
                this.loaderUpdate();
              }}
              label={"Zaloguj się"}
            />
          </form>
        </div>
      </div>
    );
  }
}
export default connect()(withRouter(SignIn));

const ConfirmationButton = styled(Button)`
  background-color: rgb(124, 132, 131);
  font-family: 'Indie Flower', cursive;
  font-weight: bold;
  font-size: 20px;
  width: 100%;
`;
const loader = styled.div`text-align: center;`;
