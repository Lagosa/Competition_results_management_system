<?php
  require '../php/getTeachers.php';

    session_start();
    if (!isset($_SESSION['loggedin'])) {
    	header('Location: ../index.php');
    	exit();
    }
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Versenyfüzet bevezetése | Profil</title>
	<link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">

	<link rel="stylesheet" type="text/css" href="../stylesheets/formStyles.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/tanarListazas.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/header.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/animation.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../javascript/diakProfilModositas.js"></script>



    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
      function getList(){
        document.getElementById("tanarH").value = document.getElementById("selectTeacher").value;
        document.getElementById("listTeacherHF").submit();
      }
      function animateLoading(){
        document.getElementById("loadingDiv").style.visibility = "visible";
        setTimeout(function (){
          getList();
          document.getElementById("loadingDiv").style.visibility = "hidden";
        },1500);

      }
    </script>

  </head>
  <body>
    <div id="tartalom">
      <div id="header">
          <div id="image">
            <img src="../images/icon_tanar.png">
          </div>
          <div class="options" id="optionsId">
            <div class="kijelentkezes"> <a href="../php/logout.php"> Kijelentkezés </a></div>
            <div class="hamburger"> <a onclick="showMenu()"> <i class="material-icons">menu</i> </a></div>
          </div>
       </div>
	   <div id="container">

			<form id="tanarKivalaszt">
				<table class="fieldTable">
					<tr>
						<td> <i class="material-icons"> local_library </td>
						<td>
							<select class="textInput" id="selectTeacher" onchange="animateLoading()">
								<?php echo $teachers ?>
							</select>
						</td>
					</tr>
				</table>
        <div id="loadingDiv" style="visibility:hidden;" >
          <img src="../images/loading.gif" class="loading">
        </div>
			</form>
      <form style="visibility:hidden;" action="../php/tanarListazas.php" id="listTeacherHF" method="post">
        <input type="text" name="tanar" id="tanarH">
      </form>
	   </div>
    </div>
  </body>
</html>
