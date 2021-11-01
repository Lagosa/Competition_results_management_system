<?php
  require 'sessionInformation.php';
  require 'connectDB.php';

  $resultListInTable = "<table  id='lista'> <tr class='headingCollumn'> <td> Diák </td> <td> Verseny </td> <td> Tantárgy </td>
  <td> Tanár </td> <td> Kategoria </td> <td> Szakasz </td> <td> Eredmény </td> <td> Periódus </td> <td> Típus </td> <td> Csapattagok száma </td></tr>";

 // Eredmények kikérése
  $sql = "SELECT * FROM eredmenyek WHERE osztaly = ?;";
  $statement = mysqli_stmt_init($dbconn);

  if(!mysqli_stmt_prepare($statement,$sql)){
    header("Location: ../pages/diakBevezetes.php?error=databaseError&details=eredmenyekSelectionFail");
    exit();
  }
  mysqli_stmt_bind_param($statement,"s",$oszt);
  mysqli_stmt_execute($statement);
  $result = mysqli_stmt_get_result($statement);


  while ($row = mysqli_fetch_assoc($result)) {
    // Diák id-jának helyettesítése a névvel
    $sql = "SELECT vezeteknev,keresztnev FROM $oszt WHERE id = {$row['diakId']}";
    $inStatement = mysqli_stmt_init($dbdiakconn);
    if(!mysqli_stmt_prepare($inStatement,$sql)){
      header("Location: ../pages/diakBevezetes.php?error=databaseError&details=insertFail");
      exit();
    }
    mysqli_stmt_execute($inStatement);
    $inResult = mysqli_stmt_get_result($inStatement);
    $inRow = mysqli_fetch_assoc($inResult);
    $diakNeve = $inRow['vezeteknev'] .' '. $inRow['keresztnev'];

    // Tanár id-jának helyettesítlse a névvel
    $sql = "SELECT vezeteknev,keresztnev FROM tanarok WHERE id = {$row['tanarId']}";
    $inStatement = mysqli_stmt_init($dbconn);
    if(!mysqli_stmt_prepare($inStatement,$sql)){
      header("Location: ../pages/diakBevezetes.php?error=databaseError&details=insertFail");
      exit();
    }
    mysqli_stmt_execute($inStatement);
    $inResult = mysqli_stmt_get_result($inStatement);
    $inRow = mysqli_fetch_assoc($inResult);
    $tanarNeve = $inRow['vezeteknev'] . ' ' .$inRow['keresztnev'];

    // Adatok táblázatba helyezése
    $resultListInTable .= "<tr><td> $diakNeve </td><td> {$row['megnevezes']}</td><td> {$row['tantargy']} </td><td> $tanarNeve </td>
    <td> {$row['kategoria']} </td><td> {$row['szakasz']} </td><td> {$row['eredmeny']} </td><td> {$row['periodus']} </td><td> {$row['tipus']} </td>
    <td> {$row['csapatSzam']} </td></tr>";
  }

  $resultListInTable .= "</table>"
?>
