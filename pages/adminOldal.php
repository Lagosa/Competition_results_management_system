<?php
  require '../php/getClasses.php';

  session_start();
  if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit();
}

  $status = '';
  if(isset($_GET['status'])){
    if($_GET['status'] == 'success'){
      $status = "<table class='success'><tr><td id='wtd'><i class='material-icons'>done</i></td><td id='ttd'>Művelet sikeresen végrehajtva!</td></tr></table>";
    }
  }
  if(isset($_GET['error'])){
    if($_GET['error'] == 'databaseError'){
      $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'>Hiba történt! <br> Próbáld újra!</td></tr></table>";
    }
  }
 ?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Versenyfüzet bevezetése | Admin oldal</title>

    <link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="../stylesheets/formStyles.css">
      <link rel="stylesheet" type="text/css" href="../stylesheets/adminOldal.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/header.css">

    <link rel="stylesheet" type="text/css" href="../stylesheets/status.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/animation.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript" src="../javascript/adminOldal.js"></script>
    <script type="text/javascript" src="../javascript/responsive.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
      function animateGetList(){
        document.getElementById("loadingDiv").style.visibility = "visible";
        setTimeout(function (){
          document.getElementById("diakH").value = document.getElementById("diakI").value;
          document.getElementById("diakFelolvas").submit();

          document.getElementById("loadingDiv").style.visibility = "hidden";
        },1500);
      }
      function animateMarkAsRead(){
        document.getElementById("loadingDiv").style.visibility = "visible";
        setTimeout(function (){
          document.getElementById("diakR").value = document.getElementById("diakI").value;
          document.getElementById("diakFormMarkAsRead").submit();

          document.getElementById("loadingDiv").style.visibility = "hidden";
        },1500);
      }
      function animateStudentScore(){
        document.getElementById("loadingDiv").style.visibility = "visible";
        setTimeout(function (){
          document.getElementById("diakPontszamH").value = document.getElementById("diakPontszamI").value;
          document.getElementById("diakPontszam").submit();

          document.getElementById("loadingDiv").style.visibility = "hidden";
        },2500);
      }
      function animateTeacherScore(){
        document.getElementById("loadingDiv").style.visibility = "visible";
        setTimeout(function (){
          document.getElementById("tanarPontszam").submit();

          document.getElementById("loadingDiv").style.visibility = "hidden";
        },1500);
      }

    </script>

  </head>
  <body>
    <div id="tartalom">
      <div id="header">
        <div id="image">
          <img src="../images/icon_admin.png">
        </div>
        <div class="options" id="optionsId" >
          <div class="bevezetes" style="background-color: #3d5d7a;"> <a href="adminOldal.php"> Lekérdezések </a></div>
          <div class="listazas" > <a href="adminAdatbazisKezeles.php"> Adatbázis kezelése </a></div>
          <div class="kijelentkezes"> <a href="../php/logout.php"> Kijelentkezés </a></div>
          <div class="hamburger"> <a onclick="showMenu()"> <i class="material-icons">menu</i> </a></div>
        </div>
      </div>

      <div id="bevezetes">
		<div id="content">
			<div id="options">
				<button id="felolvas" onclick="display('felolvasas','szamitasok'),hideSzamitasok()">
						<img src="../images/felolvasas.png">
						Felolvasás
				</button>

				<button id="szamitas" onclick="display('szamitasok','felolvasas'),displayChilds()">
						<img src="../images/szamitas.png">
						 Pontszámok számítása
				</button>
			</div>
			<div class="form">
				<div id="felolvasas">

					<table class="fieldTable">
						<tr>
						<td> <i class="material-icons">class</i> </td>
							<td>
                <form id="valaszt" action="../php/diakFelolvas.php">
									<select  id="diakI" class="textInput">
										<?php echo $classOpt ?>
									</select>
                </form>
							</td>
						</tr>
					</table>
          <input type="submit" class="submitInput" value="Generálás" onclick="animateGetList()">
        <br><input type="submit" style="background-color:#991111; width:190px;" class="submitInput" value="Megjelölés olvasottként" onclick="animateMarkAsRead()">
				</div>
				<div id="szamitasok">
					<input type="submit" class="submitInput" value="Diákok" onclick="display('szamitasOsztaly','szamitasValasztTanar')" id="szamitasValasztDiak">
          <input type="submit" class="submitInput" value="Tanárok" onclick="display('szamitasTanar','szamitasValasztDiak')" id="szamitasValasztTanar">

        <div class="szamitasContainer">
          <div id="szamitasOsztaly">
            <table class="fieldTable">
  						<tr>
  						<td> <i class="material-icons">class</i> </td>
  							<td>
  								<form id="valaszt">
  									<select id="diakPontszamI" class="textInput">
  										<?php echo $classOpt ?>
  									</select>
  								</form>
  							</td>
  						</tr>
  					</table>
            <input type="submit" class="submitInput" value="Pontszám generálása" onclick="animateStudentScore()">
          </div>
          <div id="szamitasTanarContainer">
            <div id="szamitasTanar">
              <input type="submit" class="submitInput" value="Pontszám generálása" onclick="animateTeacherScore()">
            </div>
          </div>
        </div>
        </div>
        <div id="loadingDiv" style="visibility:hidden;" >
          <img src="../images/loading.gif" class="loading">
        </div>
			</div>
		</div>
      </div>
    </div>
    <form id="diakFelolvas" style="visibility:hidden" action="../php/diakFelolvas.php" method="post">
        <input type="text" name="osztaly" id="diakH">
    </form>
    <form id="diakPontszam" style="visibility:hidden" action="../php/diakPontszam.php" method="post">
        <input type="text" name="osztaly" id="diakPontszamH">
    </form>
    <form id="tanarPontszam" style="visibility:hidden" action="../php/tanarPontszam.php" method="post">
    </form>
    <form id="diakFormMarkAsRead" style="visibility:hidden" action="../php/markAsRead.php" method="post">
        <input type="text" name="osztaly" id="diakR">
    </form>
    <?php echo $status ?>
  </body>
</html>
