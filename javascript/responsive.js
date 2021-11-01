function showMenu()
{
  var x = document.getElementById("optionsId");
  if(x.className === "options")
  {
    x.className +=" responsive";
  }else {
    x.className ="options";
  }
}
