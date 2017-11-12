import React, { Component, PropTypes } from "react";
import { Link } from "react-router";

export class NavbarLink extends Component {
  render() {
    return (
      <Link
        to={this.props.to}
        activeStyle={{
          color: "rgb(231, 231, 231)",
          borderBottom: "4px solid rgb(138, 2, 2)"
        }}>
        {this.props.name}
      </Link>
    );
  }
}

export default NavbarLink;
