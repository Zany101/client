class Pagination {

  constructor(number_of_results , page=1, results_per_page=12) {
    this.page = parseInt(page);
    this.number_of_results  = number_of_results ;
    this.results_per_page = results_per_page;
    this.number_of_pages = Math.ceil(this.number_of_results  / this.results_per_page) ;
    }

  calc() {
    var limiter;
    var breaker;
    var array = [];

    if (this.page > 1) {
      this.breaker = this.page + 2;
      this.limiter = this.page - 1;
    } else {
      this.breaker = 2;
      this.limiter = 1;
    }


    if (this.page >= this.number_of_pages && this.page == (this.number_of_pages - this.number_of_pages +2)) {
      this.limiter = this.limiter - 2;
      this.breaker = this.breaker + 1;
    } else if (this.page == this.number_of_pages - 1 && this.page == (this.number_of_pages - this.number_of_pages +1)) {
      this.limiter = this.limiter - 1;
      this.breaker = this.breaker + 2;
    }



    // Handle Output

    var showing = this.page * this.results_per_page;
    var to = showing + this.results_per_page;

    if (this.page == this.number_of_pages) {
      to = this.number_of_results;
    }
    array.push(
      "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" tabindex=\"-1\">Showing "+showing+" to "+to+" of "+this.number_of_results +" entires</a></li>"
    );

    if (this.page > 1) {
      array.push(
        "<li class=\"page-item\"><a class=\"page-link\" href=\"1\"><span><i class=\"fa fa-angle-double-left\"></i></span></a></li>",
        "<li class=\"page-item\"><a class=\"page-link\" href=\""+(this.page-1)+"\"><span><i class=\"fa fa-angle-left\"></i></span></a></li>"
      );
    }

      for (var i = this.limiter; i <= this.breaker-1 ; i++) {
        if (i > this.number_of_pages && i > 1) break;
        array.push(
          "<li class=\"page-item "+(i == this.page ?  "active" : "")+"\"><a class=\"page-link\" href=\""+i+"\">"+i+"</a></li>"
        );
      }

    if (this.page >= 1 && this.page < this.number_of_pages) {
      array.push(
        "<li class=\"page-item\"><a class=\"page-link\" href=\""+ (this.page+1) +"\"><span><i class=\"fa fa-angle-right\"></i></span></a></li>",
        "<li class=\"page-item\"><a class=\"page-link\" href=\""+this.number_of_pages+"\"><span><i class=\"fa fa-angle-double-right\"></i></span></a></li>"
      );
    }

    return array;
  }

  get render() {
    return this.calc();
  }

}
