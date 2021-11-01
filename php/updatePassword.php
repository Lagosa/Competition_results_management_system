<?php
  require "connectDB.php";

  $felhasznalo = $_POST["felhasznalo"];
  $jelszo = $_POST["jelszo"];

  if($felhasznalo == "diak")
  {
    mysqli_query($dbconn,"UPDATE osztalyok SET jelszo = '".$jelszo."'");
  }else{
    mysqli_query($dbconn,"UPDATE jelszavak SET ".$felhasznalo."Jelszo = '".$jelszo."'");
  }
  Header("Location: ../pages/adminAdatbazisKezeles.php?status=success");
  exit();
?>
