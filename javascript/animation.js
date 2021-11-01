function hideLoad(){
  document.getElementById("loadingDiv").style.visibility = "visible";
      setTimeout(function (){
        document.getElementById("loadingDiv").style.visibility = "hidden";
        document.getElementById("container").style.visibility = "visible";
      },1000);
  }
