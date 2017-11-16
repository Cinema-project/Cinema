import React from "react";
import styled from "styled-components";
import Modal from "react-modal";
import landingPageImage from "../images/landingPageImage";
import SignUp from "../session/SignUp";
import SignIn from "../session/SignIn";

export class Home extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      isActiveSignIn: false,
      isActiveSignUp: false
    };
  }

  toogleModalSignIn = () => {
    this.setState({
      isActiveSignIn: !this.state.isActiveSignIn
    });
  };

  toogleModalSignUp = () => {
    this.setState({
      isActiveSignUp: !this.state.isActiveSignUp
    });
  };

  changeModal = () => {
    this.setState({
      isActiveSignUp: !this.state.isActiveSignUp,
      isActiveSignIn: !this.state.isActiveSignIn
    });
  };

  signIn = () => {
    this.toogleModalSignIn();
  };

  signUp = () => {
    this.toogleModalSignUp();
  };

  componentWillMount() {
    Modal.setAppElement("body");
  }

  render() {
    return (
      <StyledContainer className="row">
        <div className="col-md-6 col-md-offset-3">My Cinema</div>
        <StyledButtonContainer className="col-md-6 col-md-offset-3">
          <StyledButton onClick={this.signIn}>Zaloguj się</StyledButton>
          <StyledButton onClick={this.signUp}>Zarejestruj się</StyledButton>
        </StyledButtonContainer>
        <Modal
          isOpen={this.state.isActiveSignIn}
          onRequestClose={this.toogleModalSignIn}
          className="col-md-4 col-md-offset-4"
          style={styledModal}>
          <SignIn />
        </Modal>
        <Modal
          isOpen={this.state.isActiveSignUp}
          onRequestClose={this.toogleModalSignUp}
          className="col-md-4 col-md-offset-4"
          style={styledModal}>
          <SignUp modalClose={this.changeModal} />
        </Modal>
      </StyledContainer>
    );
  }
}

export default Home;

const StyledContainer = styled.div`
  background-color: black;
  background-image: url(${landingPageImage});
  background-repeat: no-repeat;
  background-position: center;
  min-height: 100vh;
  color: rgb(201, 201, 201);
  font-family: 'Roboto', cursive;
  font-size: 8vw;
  text-align: center;
`;

const StyledButtonContainer = styled.div`
  font-size: 30px;
  padding-top: 5vh;
`;

const StyledButton = styled.button`
  background-color: rgb(124, 132, 131);
  width: 180px;
  font-size: 20px;
  border-radius: 5px;
  border: none;
  margin: 10px 30px 15px 15px;
  padding: 15px 30px 15px 30px;
  box-shadow: 7px 6px 17px -2px rgba(0, 0, 0, 0.75);
  box-shadow: inset 125px 106px 160px -172px rgba(0, 0, 0, 0.75);
  outline: 0;
  &:hover {
    background-color: rgb(196, 196, 196);
    color: rgb(42, 42, 42);
  }
`;

const styledModal = {
  overlay: {
    position: "fixed",
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: "rgba(23, 23, 23, 0.9)"
  },
  content: {
    marginTop: "210px",
    borderRadius: "10px",
    opacity: "0.8",
    overflow: "auto",
    WebkitOverflowScrolling: "touch",
    outline: "none",
   height: "400px",
    color: "rgb(201, 201, 201)"
  }
};
