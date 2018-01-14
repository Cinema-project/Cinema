import React, {Component} from "react";
import apiClient from "../api-client";
import Input from "../user-interface/Input";
import Button from "../user-interface/Button";
import { connect } from "react-redux";
import styled from "styled-components";
var $ = require('jquery');

class Comments extends Component{
  constructor(props){
    super(props);
    this.state= {
        comments: [],
        commentText: "",
    }
     this._handleSubmit = this._handleSubmit.bind(this);
  
  }

  componentWillReceiveProps = (nextProps) => {
   
   console.log(this.props.idMovie);
    apiClient
      .get(`index.php/comments/getComments/${nextProps.idMovie}`)
      .then(response => {
       this.setState({
         comments: response.data.results
       })
        console.log(this.state.comments);
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
  console.log(this.props.idMovie);
  $.ajax({
    
      url: process.env.NODE_ENV !== "production" ? 'http://localhost:80/Cinema/index.php/comments/addComment/' : "http://localhost:80/Cinema/comments/addComment/",
      // url: "./php/mailer.php",
      //./index.php/Login/login
      type: 'POST',
      data: {
        'token' : this.props.user.token,   //Powinieneś móc wywołać sobie token za pomocą this.props.user.token
        'movie_id': this.props.idMovie,
        'comment': this.state.commentText
      },
      success: function(data) {
        console.log("dodano komentarz!");
       }.bind(this),
      error: function(xhr, status, err) {
        console.log(xhr, status);
        console.log(err);
        this.setState({
          contactMessage: 'Błąd',
        });
      }.bind(this)
    });

    //jeszce raz po dodaniu komenta
    console.log(this.props.idMovie);
    apiClient
      .get(`index.php/comments/getComments/${this.props.idMovie}`)
      .then(response => {
       this.setState({
         comments: response.data.results
       })
        console.log(this.state.comments);
      })
      .catch(error => {
        console.log(error);
      });
      this.setState({
        commentText: ""
      })

  };

  render(){
      
    return(
      <div className = "container-fluid">
        
        <div className="col-md-6 col-md-offset-1" style={{marginBottom:"2vw",marginLeft: "14vw"}}>
          <Details className="col-md-12" style={{float: "left", fontSize: "20px",marginTop:"1vw",marginBottom:"1vw"}}>
            Komentarze:
          </Details>
          {this.state.comments.map(comment=>
          <div>
             <Details className="col-md-12" style={{float: "left", fontSize: "15px",marginBottom:"4px",borderRadius:"30px",backgroundColor: "rgb(124, 132, 131)"}}>
            {comment.nick}  {comment.date}
          </Details>
          <Details className="col-md-12" style={{float: "left", fontSize: "13px",marginBottom:"1vw",fontFamily: "Georgia",fontWeight:"bold"}}>
            {comment.comment}
          </Details>
          </div>
          )}
          
       </div>
       
       
       
            
        <div className="col-md-6" style={{textAlign:"left",marginBottom:"2vw",marginLeft:"15vw"}}>
            <form onSubmit={this._handleSubmit} style={{marginBottom:"1vw"}}>
            <Input
              onChange={this.updateComment}
              value={this.state.commentText}
              className="form-control"
              id="login"
              placeholder="Wpisz komentarz"
            />
            <div className="col-md-6 col-md-offset-10" style={{textAlign:"left", color: "red"}}>
            <ConfirmationButton className="btn btn-primary"
              onClick={event => {
                this.onSubmit;
              }}
              label={"Dodaj"}
            />
            
            </div>
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
const Details = styled.div`
  font-family: 'Oswald', sans-serif;
  font-size: 25px;
  color: rgb(198, 198, 184);
  
  
`

const ConfirmationButton = styled(Button)`
  background-color: rgb(124, 132, 131);
  font-family: 'Indie Flower', cursive;
  font-weight: bold;
  font-size: 20px;
`;