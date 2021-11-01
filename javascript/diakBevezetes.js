
function valasztVerseny(){
  var kat = document.getElementById("kategoria");
  if(kat.value == "Mas"){
    document.getElementById("megnevezesDropdown").style.visibility = "hidden";
    document.getElementById("megnevezesMas").style.visibility = "visible";

  }
}
