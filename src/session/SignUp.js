import React, { Component, PropTypes } from "react";
import styled from "styled-components";
import { callToast } from "../lib/alert";
import { toast } from "react-toastify";
import { connect } from "react-redux";
import Input from "../user-interface/Input";
import Button from "../user-interface/Button";
import { withRouter } from "react-router";
import Loader from "../user-interface/Loader";
var $ = require('jquery');
export class SignUp extends Component {
  constructor(props) {
    super(props);
    this.state = {
      login: "",
      nick: "",
      password: "",
      confirmPassword: "",
      loader: false
    };
    this._handleSubmit = this._handleSubmit.bind(this);
  }

  updateLogin = e => {
    this.setState({
      login: e.target.value
    });
  };

  updateNick = e => {
    this.setState({
      nick: e.target.value
    });
  };

  updatePassword = e => {
    this.setState({
      password: e.target.value
    });
  };
  updateConfirmPassword = e => {
    this.setState({
      confirmPassword: e.target.value
    });
  };

  closeModal = () => {
    this.props.modalClose();
  };

  clearForm = () => {
    this.setState({
      password: "",
      confirmPassword: ""
    });
  };

  validateEmail = email => {
    var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(email);
  };

  checkConditions = () => {
    if (
      this.state.password.length >= 8 &&
      this.state.password === this.state.confirmPassword &&
      this.validateEmail(this.state.login)
    ) {
      return true;
    } else {
      return false;
    }
  };

  wrongRegistrationAlerts = () => {
    if (
      this.state.password.length < 8 &&
      !this.validateEmail(this.state.login)
    ) {
      callToast("Wprowadzone hasło jest za krótkie oraz podano nieprawidłowy adres e-mail.");
    } else if (
      this.state.password !== this.state.confirmPassword &&
      !this.validateEmail(this.state.login)
    ) {
      callToast("Wprowadzone hasła są różne oraz podano nieprawidłowy adres e-mail.");
    } else if (!this.validateEmail(this.state.login)) {
      callToast("Wprowadzony adres e-mail nie jest poprawny.");
    } else if (this.state.password !== this.state.confirmPassword) {
      callToast("Wprowadzone hasła są różne.");
    } else {
      callToast(
        "Wprowadzone hasło jest za krótkie. Wprowadź hasło zawierające conajmniej 8 znaków."
      );
    }
    this.clearForm();
    this.loadingOff();
  };

  onSubmit = e => {
    e.preventDefault();
    if (!this.checkConditions()) {
      this.wrongRegistrationAlerts();
    }
  };

  loaderUpdate = () => {
    this.setState({
      loader: true
    });
  };
  loader = () => {
    if (this.state.loader === true) {
      return <Loader />;
    }
  };

  loadingOff = () => {
    this.setState({
      loader: false
    });
  };

  _handleSubmit(e) {
    e.preventDefault();

    if (!this.checkConditions()) {
      this.wrongRegistrationAlerts();
    } else {
      $.ajax({
        url: process.env.NODE_ENV !== "production" ? 'http://localhost:80/Cinema/index.php/Login/register' : "http://localhost:80/Cinema/index.php/Login/register",
        // url: "./php/mailer.php",
        type: 'POST',
        data: {
          'login': this.state.login,
          'password': this.state.password,
          'nick': this.state.nick
        },
        success: function (data) {
          this.state.loginCheck = data;
          if (this.state.loginCheck == "Login not unique") {
            callToast("Użytkownik już istnieje!");
          }
          else if (this.state.loginCheck == "notExist") {
            callToast("Zarejestrowano, proszę się zalogować");
            this.props.modalClose();
          }
          else if (this.state.loginCheck == "Nick not unique") {
            callToast("Ten nick jest już zajęty!");
          }


        }.bind(this),
        error: function (xhr, status, err) {
          console.log(xhr, status);
          console.log(err);
          this.setState({
            contactMessage: 'Błąd',
          });
        }.bind(this)
      });
    }
  };

  render() {
    return (
      <div className="row">
        <div className="col-md-12">
          <form onSubmit={this._handleSubmit}>
            <Input
              onChange={this.updateLogin}
              value={this.state.login}
              placeholder="E-mail"
              id="login"
              type="email"
              required />

            <Input
              onChange={this.updateNick}
              value={this.state.nick}
              placeholder="Nick"
              id="nick"
              type="text"
              required />

            <Input
              onChange={this.updatePassword}
              value={this.state.password}
              placeholder="Password"
              id="password"
              type="password"
              required />

            <Input
              onChange={this.updateConfirmPassword}
              value={this.state.confirmPassword}
              placeholder="Confirm password"
              type="password"
              required />

            <StyledButton
              onClick={event => {
                this.onSubmit;
                this.loaderUpdate();
                ;
              }}
              label={"Zarejestruj się"}
            />
          </form>
          {/* <loader>
            {this.loader()}
          </loader> */}
        </div>
      </div>
    );
  }
}

const options = {
  autoClose: 3000,
  type: toast.TYPE.WARN,
  hideProgressBar: false,
  position: toast.POSITION.TOP_CENTER
};

export default connect()(withRouter(SignUp));

const StyledButton = styled(Button) `
  background-color: rgb(124, 132, 131);
  font-family: 'Indie Flower', cursive;
  font-weight: bold;
  font-size: 20px;
  width: 100%;
`;
const loader = styled.div`
  padding-top: 10px;
  text-align: center;
`;
