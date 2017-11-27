import React from "react";
import styled from "styled-components";
import Modal from "react-modal";
import landingPageImageDesktop from "../images/Deadpool.png";
import landingPageImageMobile from "../images/blur.jpg";
import SignUp from "../session/SignUp";
import SignIn from "../session/SignIn";
import MediaQuery from "react-responsive";

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
      <div>
      <MediaQuery query='(min-device-width: 1224px)'>
        <BackgroundDesktop>
          <StyledContainer className="container-fluid">
            <div className="col-md-6 col-md-offset-3">MyCinema</div>
            <StyledButtonContainer className="col-md-6 col-md-offset-3">
              <StyledButton onClick={this.signIn}>Zaloguj się</StyledButton>
              <StyledButton onClick={this.signUp}>Zarejestruj się</StyledButton>
            </StyledButtonContainer>
            <Text className="col-md-6 col-md-offset-3">
              Odkrywaj świat filmów z MyCinema!
            </Text>
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
      </BackgroundDesktop>
    </MediaQuery>
    <MediaQuery query='(max-width: 1224px)'>
      <BackgroundMobile>
        <StyledContainer className="container-fluid">
          <div className="col-md-6 col-md-offset-3">MyCinema</div>
          <StyledButtonContainer className="col-md-6 col-md-offset-3">
            <StyledButton onClick={this.signIn}>Zaloguj się</StyledButton>
            <StyledButton onClick={this.signUp}>Zarejestruj się</StyledButton>
          </StyledButtonContainer>
          <Text className="col-md-6 col-md-offset-3">
            Odkrywaj świat filmów z MyCinema!
          </Text>
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
    </BackgroundMobile>
    </MediaQuery>
  </div>
    );
  }
}

export default Home;

const BackgroundDesktop = styled.div`
  background-color: black;
  background-image: url(${landingPageImageDesktop});
  background-repeat: no-repeat;
  background-position: center;
  opacity: 0.95;
  background-size: auto;
  min-height: 100vh;
  max-width: 100vw;
`
const BackgroundMobile = styled.div`
  background-color: black;
  background-image: url(${landingPageImageMobile});
  background-repeat: no-repeat;
  background-position: center;
  opacity: 0.95;
  background-size: auto;
  min-height: 100vh;
  max-width: 100vw;
`

const StyledContainer = styled.div`
  color: rgb(255, 255, 255);
  padding-top: 5vh;
  font-family: 'Indie Flower', cursive;
  font-size: 12vh;
  text-shadow: 4px 4px 9px rgba(150, 150, 150, 1);
  text-align: center;
`;

const StyledButtonContainer = styled.div`
  font-size: 30px;
  padding-top: 10vh;
`;

const Text = styled.div`
  font-size: 50%;
  padding-top: 20vh;
`

const StyledButton = styled.button`
  background-color: rgb(124, 132, 131);
  width: 220px;
  font-size: 25px;
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
    marginTop: "30vh",
    borderRadius: "10px",
    opacity: "0.7",
    overflow: "auto",
    WebkitOverflowScrolling: "touch",
    outline: "none",
    height: "400px",
    color: "rgb(201, 201, 201)"
  }
};
