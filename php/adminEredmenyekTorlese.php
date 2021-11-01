<?php
  require "connectDB.php";

  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit();
  }
   mysqli_query($dbconn,"DROP TABLE IF EXISTS eredmenyek");
   mysqli_query($dbconn,"CREATE TABLE eredmenyek ( `id` INT NOT NULL AUTO_INCREMENT , `osztaly` VARCHAR(25) NOT NULL , `diakId` INT NOT NULL , `tanarId` INT NOT NULL , `megnevezes` VARCHAR(550) NOT NULL, `tantargy` VARCHAR(255) NOT NULL, `kategoria` VARCHAR(50) NOT NULL, `periodus` VARCHAR(150) NOT NULL, `szakasz` VARCHAR(150) NOT NULL, `eredmeny` VARCHAR(50) NOT NULL, `tipus` VARCHAR(50) NOT NULL, `csapatSzam` INT NOT NULL, `pontszamTanar` DOUBLE NOT NULL, `pontszamDiak` DOUBLE NOT NULL, `felolvasva` BOOLEAN NOT NULL, PRIMARY KEY (`id`))");

   header("Location: ../pages/adminAdatbazisKezeles.php?status=success");
   exit();
 ?>
