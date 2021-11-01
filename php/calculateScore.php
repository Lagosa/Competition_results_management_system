<?php
  require 'connectDb.php';
  require 'sessionInformation.php';

  $diakPontszam = "";
  $tanarPontszam = "";

  $kategoria = $_POST['kategoria'];
  $szakasz = $_POST['szakasz'];
  $eredmeny = $_POST['eredmeny'];
  $tipus = $_POST['tipus'];

  $sql = "SELECT diakPontszam,tanarPontszam FROM pontszamok WHERE kategoria=? AND szakasz=? AND eredmeny=? AND tipus=?;";
  $statement = mysqli_stmt_init($dbconn);

  if(!mysqli_stmt_prepare($statement,$sql)){
    header("Location: ../pages/diakBevezetes.php?error=databaseError&details=scoreFail&sql=$sql");
    exit();
  }

  mysqli_stmt_bind_param($statement,'ssss',$kategoria,$szakasz,$eredmeny,$tipus);
  mysqli_stmt_execute($statement);

  $result = mysqli_stmt_get_result($statement);
  $row = mysqli_fetch_assoc($result);

  $diakPontszam = $row['diakPontszam'];
  $tanarPontszam = $row['tanarPontszam'];
?>
