import React from "react";
import styled from "styled-components";

class Button extends React.Component {
  render() {
    return (
      <StyledButton
        onClick={this.props.onClick}
        style={this.props.style}
        className={this.props.className}
      >
        {this.props.label}
      </StyledButton>
    );
  }
}

export default Button;

const StyledButton = styled.button`
  border-radius: 5px;
  border: none;
  height: 40px;
  box-shadow: 7px 6px 17px -2px rgba(0, 0, 0, 0.75);
  text-shadow: 7px 6px 17px -2px rgba(0, 0, 0, 0.75);
  outline: 0;
  color: rgb(255, 255, 255);
  font-size: 20px;
  font-family: 'Julee', cursive;
`;
