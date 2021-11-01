function tableCreate() {

  var container = document.getElementById('container');
  var tbl = document.createElement('table');
  var tblbdy = document.createElement('tbody');

  var versenyek = [["Diak neve","Verseny neve"],["Marton Krisztian","Descopera-Ti Pasiunea in IT"],["Szekely Evelin-Beata","Descopera-Ti Pasiunea in IT"],["Varga Zoltan","Descopera-Ti Pasiunea in IT"],
                    ["Varga Zoltan","X. Gazdasagi Esettenulmany Verseny"]];

  tbl.style.width = "100%";
  tbl.setAttribute("id","lista");

  var tr = document.createElement("tr");


  var td = document.createElement("td");
  td.appendChild(document.createTextNode(versenyek[0][0]));
  td.setAttribute("class","headingCollumn1");
  tr.appendChild(td);
  var td = document.createElement("td");
  td.appendChild(document.createTextNode(versenyek[0][1]));
  td.setAttribute("class","headingCollumn2");
  tr.appendChild(td);


  tblbdy.appendChild(tr);

  for(var i=1;i<5;i++)
  {
    var tr = document.createElement('tr');
    for(var j=0;j<2;j++)
    {
      var td = document.createElement('td');
      td.appendChild(document.createTextNode(versenyek[i][j]));
      tr.appendChild(td);
    }
    tblbdy.appendChild(tr);
  }
  tbl.appendChild(tblbdy);
  container.appendChild(tbl);
}
