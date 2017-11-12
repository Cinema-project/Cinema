import React from "react";
import styled from "styled-components";

export class Input extends React.Component {
  render() {
    return <StyledInput {...this.props} className="form-control" />;
  }
}

export default Input;

const StyledInput = styled.input`
  width: 100%;
  height: 40px;
  margin-bottom: 10px;
`;
