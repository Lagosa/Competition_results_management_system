<?php

  session_start();
  if (!isset($_SESSION['loggedin'])) {
  header('Location: ../index.php');
  exit();
  }

  $status = '';
  if(isset($_GET['status']))
  {
    if($_GET['status'] == "success")
    {
      $status = "<table class='success'><tr><td id='wtd'><i class='material-icons'>done</i></td><td id='ttd'>Művelet sikeresen végrehajtva!</td></tr></table>";
    }
  }
  if(isset($_GET["error"]))
  {
    if($_GET['error'] == "databaseError")
    {
      $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'>Hiba történt! <br> Próbáld újra!</td></tr></table>";
    }
    if($_GET['error'] == "noFileUploaded")
    {
      $status = " <table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Nem volt helyes fájl kiválasztva! </td></tr></table>";
    }
  }
 ?>
<!Doctype html>
<html>
<head>
  <title> Versenyfüzet bevezetése | Admin oldal </title>

  <meta charset="utf-8">
  <link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">

  <link rel="stylesheet" type="text/css" href="../stylesheets/header.css">
  <link rel="stylesheet" type="text/css" href="../stylesheets/status.css">
  <link rel="stylesheet" type="text/css" href="../stylesheets/animation.css">
  <link rel="stylesheet" type="text/css" href="../stylesheets/formStyles.css">
  <link rel="stylesheet" type="text/css" href="../stylesheets/adminAdatbazisKezeles.css">

  <script type="text/javascript" src="../javascript/index_javascript.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div id="tartalom">
    <div id="header">
      <div id="header_contents">
        <div id="image">
          <img src="../images/icon_admin.png">
        </div>
        <div class="options" id="optionsId">
          <div class="bevezetes" > <a href="adminOldal.php"> Lekérdezések </a></div>
          <div class="listazas" style="background-color: #3d5d7a;"> <a href="adminAdatbazisKezeles.php"> Adatbázis kezelése </a></div>
          <div class="kijelentkezes"> <a href="../php/logout.php"> Kijelentkezés </a></div>
          <div class="hamburger"> <a onclick="showMenu()"> <i class="material-icons">menu</i> </a></div>
        </div>
      </div>
    </div>
    <div id="content">
      <table class="fieldTable">
        <tr>
          <td class="label"> Osztályok frissítése </td>
          <form id="uploadForm" action="../php/adminOsztalyokFrissitese.php" method="post" enctype="multipart/form-data">
            <td>
                <input type="file" class="textInput upload" name="osztalyokExcel" id="osztalyokExcel" accept=".xls,.xlsx">
            </td>
            <td> <button type="submit" onclick="" class="submitInput"> frissítés </button> </td>
          </form>
            <td> <form action='../php/adminOsztalyLetoltes.php'> <button class="submitInput download"> letöltés </button></form> </td>
        </tr>
      </table>
      <table class="fieldTable">
        <tr>
          <td class="label"> Tanárok frissítése </td>
          <form id="uploadForm" action="../php/adminTanarokFrissitese.php" method="post" enctype="multipart/form-data">
            <td>
                <input type="file" class="textInput upload" name="tanarokListaja" id='tanarokListaja' accept=".xls,.xlsx">
            </td>
            <td> <button type="submit" onclick="" class="submitInput"> frissítés </button> </td>
          </form>
            <td> <form action='../php/adminTanarokLetoltes.php' method="post"> <button type='submit' class="submitInput download"> letöltés </button></form> </td>
        </tr>
      </table>
      <table class="fieldTable">
        <tr>
          <td class="label"> Versenyek frissítése </td>
          <form id="uploadForm" action="../php/adminVersenyekFrissitese.php" method="post" enctype="multipart/form-data">
            <td>
                <input type="file" class="textInput upload" name="versenyekListaja">
            </td>
            <td> <button type="submit" class="submitInput"> frissítés </button> </td>
          </form>
            <td> <form action="../php/adminVersenyekLetoltes.php" method="post"><button type='submit' class="submitInput download"> letöltés </button></form> </td>
        </tr>
      </table>
      <table class="fieldTable">
        <tr>
          <td class="label"> Pontszámok frissítése </td>
          <form id="uploadForm" action="../php/adminPontszamokFrissitese.php" method="post" enctype="multipart/form-data">
            <td>
                <input type="file" class="textInput upload" name="pontszamokListaja">
            </td>
            <td> <button type="submit" class="submitInput"> frissítés </button> </td>
          </form>
            <td> <form action="../php/adminPontszamokLetoltes.php" method="post"> <button type="submit" class="submitInput download"> letöltés </button> </form> </td>
        </tr>
      </table>
        <div id="passwords">
        <table class="fieldTable pass">
          <tr><td colspan="2"> <div class="label"> Diákok jelszava </div> </td></tr>
          <form action="../php/updatePassword.php" method="post">
          <tr><td><input type="text" name="felhasznalo" value="diak" style="display:none;"> <input type="password" id="jelszoDiak" name="jelszo" class="textInput"> </td>
           <td class="icon"><div onclick="showPass('jelszoDiak')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td> </tr>
          <tr><td><button type="submit" class="submitInput mentes">mentés</button></td> </tr></form>
        </table>
        <table class="fieldTable pass">
          <tr><td colspan="2"> <div class="label"> Tanárok jelszava </div> </td></tr>
          <form action="../php/updatePassword.php" method="post">
          <tr><td><input type="text" name="felhasznalo" value="tanar" style="display:none;"><input type="password" id="jelszoTanar" name="jelszo" class="textInput"> </td>
           <td class="icon"><div onclick="showPass('jelszoTanar')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td> </tr>
          <tr><td><button class="submitInput mentes">mentés</button></td> </tr></form>
        </table>
        <table class="fieldTable pass pass56">
          <tr><td colspan="2"> <div class="label"> Adminisztrátor jelszava </div> </td></tr>
          <form action="../php/updatePassword.php" method="post">
          <tr><td><input type="text" name="felhasznalo" value="admin" style="display:none;"><input type="password" id="jelszoAdmin" name="jelszo" class="textInput"> </td>
           <td class="icon"><div onclick="showPass('jelszoAdmin')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td> </tr>
          <tr><td><button class="submitInput mentes">mentés</button></td> </tr></form>
        </table>
      </div>
      <table class="fieldTable">
        <tr>
          <td class="label"> Eredmények törlése </td>
          <form id="uploadForm" method="post" action="../php/adminEredmenyekTorlese.php">
            <td>
              <i class="material-icons warning">warning</i>
            </td>
            <td> <button type="submit" class="submitInput"> törlés </button> </td>
          </form>
        </tr>
      </table>
    </div>
  </div>
  <?php
    echo $status;
   ?>
</body>
</html>
