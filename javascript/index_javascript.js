function display(idDisplay,idHide1,idHide2){
    document.getElementById(idHide1).style.visibility = "hidden";
	document.getElementById(idHide2).style.visibility = "hidden";
    document.getElementById(idDisplay).style.visibility = "visible";
}

var f=1;
function showPass(idPassField){
  if(f==1)
  {
    document.getElementById(idPassField).setAttribute('type','text');
    f=0;
  }else {
    document.getElementById(idPassField).setAttribute('type','password');
    f=1;
  }
}

function showDoublePass(idPassFieldOne, idPassFieldTwo)
{
  if(f==1)
  {
    document.getElementById(idPassFieldOne).setAttribute('type','text');
    document.getElementById(idPassFieldTwo).setAttribute('type','text');
    f=0;
  }else {
    document.getElementById(idPassFieldOne).setAttribute('type','password');
    document.getElementById(idPassFieldTwo).setAttribute('type','password');
    f=1;
  }
}
