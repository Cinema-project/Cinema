import React from "react";
import { withRouter } from "react-router";
import { connect } from "react-redux";
import styled from "styled-components";
import Input from "../user-interface/Input";
import Button from "../user-interface/Button";
import Loader from "../user-interface/Loader";
import { callToast } from "../lib/alert";
var $ = require('jquery');

export class SignIn extends React.Component {
  constructor(props) {
    super(props);
    this.state = { login: "", password: "", loader: false };
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
      url: process.env.NODE_ENV !== "production" ? './index.php/Login/login' : "./index.php/Login/login",
      // url: "./php/mailer.php",
      type: 'POST',
      data: {
        'login': this.state.login,
        'password': this.state.password
      },
      success: function(data) {
        this.setState({
          successMsg: '<div class="hehe"><h1>Wszystko GIT!</h1></div>'
        });
        $('#formContact').slideUp();
        $('#formContact').after(this.state.successMsg);
      }.bind(this),
      error: function(xhr, status, err) {
        console.log(xhr, status);
        console.log(err);
        this.setState({
          contactMessage: 'Błąd',
        });
      }.bind(this)
    });
    if(this.state.login == "admin" && this.state.password == "admin"){
      this.props.router.push("home_page");
    }else{
      callToast("Entered login and password aren't correct!");
    }
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
              label={"Sign In"}
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
  font-size: 1.5vw;
  width: 100%;
`;
const loader = styled.div`text-align: center;`;
