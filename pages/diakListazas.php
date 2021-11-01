<?php
  require '../php/bevezetesListazas.php';

?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Versenyfüzet bevezetése | Profil</title>

	<link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">


    <link rel="stylesheet" type="text/css" href="../stylesheets/formStyles.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/header.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/diakListazas.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/animation.css">


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../javascript/responsive.js"></script>
    <script type="text/javascript" src="../javascript/index_javascript.js"></script>
    <script type="text/javascript" src="../javascript/animation.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body onload="hideLoad()">
    <div id="tartalom">
      <div id="header">
          <div id="image">
            <img src="../images/icon_diak.png">
            <input type='text' value='<?php echo $oszt ?>' id='osztaly' name='osztaly' readonly>
          </div>
          <div class="options" id="optionsId">
            <div class="bevezetes"><a href="diakBevezetes.php"> Verseny bevezetése </a></div>
            <div class="listazas"><a href="diakListazas.php"> Bevezetések listázása </a> </div>
            <div class="modositas"><a href="diakProfilModositas.php"> Profil módosítása </a> </div>
            <div class="kijelentkezes"> <a href="../index.php"> Kijelentkezés </a></div>
            <div class="hamburger"> <a onclick="showMenu()"> <i class="material-icons">menu</i> </a></div>
          </div>
        </div>

      <div id="modositas">
        <div id="loadingDiv">
          <img src="../images/loading.gif" class="loading">
        </div>
          <div id="container" style="visibility:hidden;">
            <?php echo $resultListInTable ?>
          </div>

      </div>
    </div>
  </body>
</html>
