import React from "react"
import styled from "styled-components";
import { browserHistory } from 'react-router'
import apiClient from "./api-client";
import Iframe from "react-iframe";
import Comments from "./homePage/comments"

export default class FilmPage extends React.Component {
  constructor(props){
    super(props);

    this.state = {
      filmDetails: {},
      genre: ""
    }
  }

  componentWillMount = () => {
    apiClient
      .get(`index.php/Home/getMovieDetails/PL/${this.props.location.state.id}`)
      .then(response => {
        this.setState({
          filmDetails: response.data,
          genre: response.data.genresList[0]
        })
      })
      .catch(error => {
        console.log(error);
      });

      if(this.state.time == 0){
      this.setState({
        time: "nieznany"
      })
    }
  }

  getCategory = e =>{
      if(e == 28){
        return "Akcja";
      }

      if(e == 12){
        return "Przygodowy";
      }

      if(e== 16){
        return "Animacja";
      }

      if(e == 35){
        return "Komedia";
      }

      if(e == 80){
        return "Kryminał";
      }

      if(e == 99){
        return "Dokumentalny";
      }

      if(e == 18){
        return "Dramat";
      }

      if(e == 10751){
        return "Familijny";
      }

      if(e == 14){
        return "Fantasy";
      }

      if(e == 36){
        return "Historyczny";
      }

      if(e == 27){
        return "Horror";
      }

      if(e == 10402){
        return "Muzyczny";
      }

      if(e == 9648){
        return  "Tajemnica";
      }

      if(e == 10749){
        return "Romans";
      }

      if(e == 878){
        return "Sci-Fi";
      }

      if(e == 10770){
        return  "film TV";
      }

      if(e == 53){
        return "Thriller";
      }

      if(e == 10752){
        return "Wojenny";
      }

      if(e == 37){
        return "Western";
      }
  }

  render(){
    var url = this.state.filmDetails.trailer;
    if(url !== undefined && url !== null){
    url = url.replace("watch?v=", "embed/");
    }else if(url == " "){}

    return(
      <div>
        <Back className="col-md-1" onClick={browserHistory.goBack}>
          <img
            src={require(`./images/back.png`)}
            style={{ width: "64px" }}
          />
        </Back>
        <div className="col-md-12">
          <FilmName className="col-md-6 col-md-offset-2">{this.state.filmDetails.title}</FilmName>
          <div className="col-md-10 col-md-offset-2" style={{height: "55vh", paddingBottom: "3vh"}}>
          <Iframe url={url}
          width="67%"
          height="100%"
          id="myId"
          display="initial"
          position="relative"
          allowFullScreen
        />
        <Details className="col-md-3" style={{float: "right", marginRight: "5vw"}}>
          <img
            src={require(`./images/time.png`)}
            style={{ width: "40px", marginRight: "20px" }}
          />{this.state.filmDetails.runtime} min <br/><br/>
          <img
            src={require(`./images/genres.png`)}
            style={{ width: "40px", marginRight: "20px" }}
          />
          {this.getCategory(this.state.genre)} <br/><br/>
          <img
            src={require(`./images/premiere.png`)}
            style={{ width: "40px", marginRight: "20px" }}
          />{this.state.filmDetails.premierDate}
        </Details>
      </div>
        <Text className="col-md-6 col-md-offset-2">{this.state.filmDetails.description}</Text>
        {/* <Comments className="col-md-12" idMovie={this.state.filmDetails.id}/> */}
        </div>

    </div>
  )
  }
}

const Back = styled.div`
  &:hover{
    cursor: pointer;
  }
`

const FilmName = styled.div`
  font-size: 50px;
  color: white;
  font-weight: bold;
`

const Title = styled.div`
  font-family: 'Dosis', sans-serif;
  font-size: 50px;
`

const Text = styled.div`
  font-size: 18px;
  color: white;
  overflow: auto;
`

const Details = styled.div`
  font-family: 'Oswald', sans-serif;
  font-size: 25px;
  color: rgb(198, 198, 184);
`
