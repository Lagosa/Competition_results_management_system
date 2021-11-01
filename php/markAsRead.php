<?php
  require 'connectDB.php';
  require 'sessionInformation.php';

  $osztaly = $_POST['osztaly'];
  if($osztaly == 'elemi' || $osztaly == 'gimnazium' || $osztaly == 'liceum'){
      $osztalyListaRes = mysqli_query($dbconn,"SELECT osztaly,szak FROM osztalyok WHERE szakasz = '".$osztaly."'");
      while($row = mysqli_fetch_assoc($osztalyListaRes)){
        mysqli_query($dbconn,"UPDATE eredmenyek SET felolvasva = 1 WHERE osztaly = '".$row['osztaly'].$row['szak']."'") or die("Bad SQL!");
      }
  }else if($osztaly == 'osszes'){
        mysqli_query($dbconn,"UPDATE eredmenyek SET felolvasva = 1");
  }else{
    mysqli_query($dbconn,"UPDATE eredmenyek SET felolvasva = 1 WHERE osztaly = '".$osztaly."'");
  }
  header("Location: ../pages/adminOldal.php?status=success");
  exit();
?>
