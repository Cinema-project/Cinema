import React, {Component} from "react";
import ReactPaginate from "react-paginate";

class Announcements extends Component{
  constructor(props){
    super(props);
    this.state = {
      page: 1
    }
  }

  handlePageClick = e => {
    const page = e.selected + 1; //bo paginacja  od zera bierze a kino dopiero od 1
    this.setState({
      page: page
    })
  }

  render(){
    return(
      <div className = "container-fluid">
        <div className="col-md-12" style={{textAlign:"center"}}>
            <ReactPaginate previousLabel={"wstecz"}
                       nextLabel={"następny"}
                       //breakLabel={<a href="">...</a>}
                       breakClassName={"break-me"}
                       pageCount={99999}
                       marginPagesDisplayed={0}
                       pageRangeDisplayed={6}
                       onPageChange={this.handlePageClick}
                       containerClassName={"pagination"}
                       subContainerClassName={"pages pagination"}
                       activeClassName={"active"} />

            </div>
      </div>
    );
  }
}

export default Announcements;
