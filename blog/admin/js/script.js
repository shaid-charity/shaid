function contactSearch() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("contactSearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("contactDB");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    for (j = 0; j < 3; j++) {
      td = tr[i].getElementsByTagName("td")[j];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      } 
    }
  }
}