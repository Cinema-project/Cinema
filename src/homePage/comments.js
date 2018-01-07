import React, {Component} from "react";
import apiClient from "../api-client";
import Input from "../user-interface/Input";
import Button from "../user-interface/Button";
import { connect } from "react-redux";
var $ = require('jquery');

class Comments extends Component{
  constructor(props){
    super(props);
    this.state= {
        comment: [],
        nick: [],
        date: [],
        commentText: "",
        id: ""
    }
     this._handleSubmit = this._handleSubmit.bind(this);

  }

  componentWillReceiveProps = () => {
      console.log(this.props.idMovie);
      this.setState({
          id: this.props.idMovie
      })
      console.log(this.state.id);
    apiClient
      .get(`index.php/comments/getComments/${this.props.idMovie}`)
      .then(response => {
        console.log("komentarze", response);
        {response.data.results.map(r =>
          this.setState(previousState =>({
            comment: [...previousState.comment, r.comment],
            nick: [...previousState.nick, r.nick],
            date: [...previousState.date, r.date],
          }))
        )}
      })
      .catch(error => {
        console.log(error);
      });


  }
   updateComment = e => {
    this.setState({ commentText: e.target.value });
  };

  _handleSubmit(e){
  e.preventDefault();

  $.ajax({
      url: process.env.NODE_ENV !== "production" ? 'http://localhost:80/Cinema/index.php/comments/addComment/' : "http://localhost:80/Cinema/comments/addComment/",
      // url: "./php/mailer.php",
      //./index.php/Login/login
      type: 'POST',
      data: {
        'token' : this.props.user.token,   //Powinieneś móc wywołać sobie token za pomocą this.props.user.token
        'movie_id': 339877,
        'comment': this.state.commentText
      },
      success: function(data) {
        console.log(this.props.user.token);
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

  render(){
      if(this.props.idMovie == ""){
          return null;
      }
    return(
      <div className = "container-fluid">
        <div className="col-md-4 col-md-offset-2" style={{textAlign:"left", color: "red"}}>
            Komentarz 
            Nick 
            Data 
            </div>
        <div className="col-md-6 col-md-offset-2" style={{textAlign:"left", color: "red"}}>
            <br/>
            {this.state.comment[0]} 

            {this.state.nick[0]}  

            {this.state.date[0]} 
        </div>
        <div className="col-md-6 col-md-offset-2" style={{textAlign:"left", color: "red"}}>
            <form onSubmit={this._handleSubmit}>
            <Input
              onChange={this.updateComment}
              value={this.state.commentText}
              className="form-control"
              id="login"

            />
            <Button style={{color: "red"}}
              onClick={event => {
                this.onSubmit;
              }}
              label={"Dodaj"}
            />
          </form>
           </div>
      </div>
    );
  }
}

const mapStateToProps = state => {
  return {
    user: state.session.user
  };
};

export default connect(mapStateToProps)(Comments);
