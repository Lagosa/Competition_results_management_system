<?php
  session_start();
  if(isset($_SESSION['loggedin'])){
    $oszt = $_SESSION['osztaly'];
    $knev = $_SESSION['knev'];
    $vnev = $_SESSION['vnev'];
    $jelszo = $_SESSION['jelszo'];
    $jelszo_ujra = $_SESSION['jelszo'];
    $uid = $_SESSION['uid'];
  }else{
    header("Location: ../index.php");
    exit();
  }
?>
