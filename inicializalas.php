<html>
  <head>
    <title>Versenyfüzet bevezetése | inicializálás</title>

    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="stylesheets/formStyles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <charset meta="utf-8">
    <script>
      function letrehoz()
      {
        document.getElementById("text").innerHTML = "<?php
          $conn = mysqli_connect('localhost','root','');
          mysqli_query($conn,"CREATE DATABASE versenyfelelos");
          mysqli_query($conn,"CREATE DATABASE osztalyok");
          $conn = mysqli_connect('localhost','root','','versenyfelelos');
          mysqli_query($conn,"CREATE TABLE osztalyok ( `id` INT NOT NULL AUTO_INCREMENT , `osztaly` INT NOT NULL , `szak` VARCHAR(5) NOT NULL , `szakasz` VARCHAR(25) NOT NULL , `jelszo` VARCHAR(100), `vezeteknev` VARCHAR(255) NOT NULL DEFAULT 'DEFAULT_USER' , `keresztnev` VARCHAR(255) NOT NULL DEFAULT 'DEFAULT_USER' , PRIMARY KEY (`id`))");
          mysqli_query($conn,"CREATE TABLE jelszavak (`tanarJelszo` VARCHAR(255), `adminJelszo` VARCHAR(255))");
         mysqli_query($conn,"INSERT INTO jelszavak (tanarJelszo,adminJelszo) VALUES ('versenyek','versenyek')");
         header("Location: /Versenyfelelos/index.php");
         exit();
        ?>";
      }
    </script>
  </head>
  <body style="background-color:#dddcdc;">
      <div style="width:100%;height: 250px;"> <button class="submitInput" style="background-color: #FF5722;width:250px;margin-left: 38%; margin-right: 47%; position:absolute; padding:5px; height:60px;font-family:arial;font-weight:550;" onclick="letrehoz();"><i class='material-icons' style="color: #660000;">warning</i> Adatbázisok létrehozva!</button></div>
      <div id="text"> </div>
  </body>
</html>
