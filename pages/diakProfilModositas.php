<?php
  require '../php/sessionInformation.php';
  
  $status = "";

  if(isset($_GET['error'])){
    if($_GET['error'] === 'passwordNotTheSame')
    {
      $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> A jelszavak nem egyeznek meg!</td></tr></table>";
    }else
    if($_GET['error'] === 'somethingWentWrong')
    {
      $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Hiba történt. <br> Próbáld újra!</td></tr></table>";
    }
  }else
  if(isset($_GET['success'])){
    $status = "<table class='success'><tr><td id='wtd'><i class='material-icons'>done</i></td><td id='ttd'>Változtatások elmentve!</td></tr></table>";
  }

?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Versenyfüzet bevezetése | Profil</title>
	<link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="../stylesheets/diakProfilModositas.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/formStyles.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/header.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/status.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript" src="../javascript/responsive.js"></script>
    <script type="text/javascript" src="../javascript/index_javascript.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
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
        <div class="heading">
          Profilod adatai:
        </div>
        <form action="../php/editProfile.php" method="post">
          <table class="fieldTable">
            <tr>
              <td><i class="material-icons">perm_identity</i></td>
              <td> <input type='text' value='<?php echo $vnev ?>' id='vezeteknev' name='vezeteknev' class='textInput'> </td>
              <td> <input type='text' value='<?php echo $knev ?>' id='keresztnev' name='keresztnev' class='textInput'> </td>
            </tr>
          </table>
          <table class="fieldTable">
            <tr>
              <td> <i class="material-icons">lock</i> </td>
              <td> <input type='password' value='<?php echo $jelszo ?>' name='jelszo' class='textInput' id='jelszo'> </td>
              <td> <input type='password' value='<?php echo $jelszo ?>' name='jelszoUjra' class='textInput' id=jelszoUjra> </td>
              <td><div onclick="showDoublePass('jelszo','jelszoUjra')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td>
            </tr>
          </table>
          <div id="submit">
            <input type="submit" value="Mentés" class="submitInput">
          </div>
        </form>
      </div>
      <?php echo $status ?>
    </div>
  </body>
</html>
