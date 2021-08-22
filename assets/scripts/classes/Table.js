class Pagination {

  constructor(number_of_results , page=1, results_per_page=12) {
    this.page = parseInt(page);
    this.number_of_results  = number_of_results ;
    this.results_per_page = results_per_page;
    this.number_of_pages = Math.ceil(this.number_of_results  / this.results_per_page) ;
    }


}
