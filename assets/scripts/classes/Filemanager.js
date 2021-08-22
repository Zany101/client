class FileManager {

  constructor(total, current=1, numpage=12) {
    this.current = parseInt(current);
    this.total = total;
    this.numpage = numpage;
    this.pages = this.total / this.numpage;
    }



}
