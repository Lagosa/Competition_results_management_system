<?php
  require 'connectDB.php';
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  if($_FILES["osztalyokExcel"]["error"] != 0){
    header("Location: ../pages/adminAdatbazisKezeles.php?error=noFileUploaded");
    exit();
  }

  $target_file = "../files/uploads/" . basename($_FILES["osztalyokExcel"]['name']);
  $imageFileExtension = pathinfo($target_file,PATHINFO_EXTENSION);
  move_uploaded_file($_FILES['osztalyokExcel']['tmp_name'],$target_file);

  $spreadsheetLoaded = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);

  rename($target_file,"../files/uploads/osztalyok.".$imageFileExtension);

  $osztalyok = $spreadsheetLoaded -> setActiveSheetIndexByName("osztalyok")->toArray();

  mysqli_query($dbconn,"DROP TABLE IF EXISTS osztalyok");
  mysqli_query($dbconn,"CREATE TABLE osztalyok ( `id` INT NOT NULL AUTO_INCREMENT , `osztaly` INT NOT NULL , `szak` VARCHAR(5) NOT NULL , `szakasz` VARCHAR(25) NOT NULL"
  .", `jelszo` VARCHAR(100), `vezeteknev` VARCHAR(255) NOT NULL DEFAULT 'DEFAULT_USER' , `keresztnev` VARCHAR(255) NOT NULL DEFAULT 'DEFAULT_USER' , PRIMARY KEY (`id`))");

  $row = 1;
  while($row<sizeof($osztalyok))
  {
    $sql = "INSERT INTO osztalyok (osztaly,szak,szakasz,jelszo) VALUES (?,?,?,?)";
    $statement = mysqli_stmt_init($dbconn);

    if(!mysqli_stmt_prepare($statement,$sql))
    {
      header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
      exit();
    }

    $oszt = $osztalyok[$row][0];
    $szak = $osztalyok[$row][1];
    $szakasz = $osztalyok[$row][2];
	  $jelszo = $osztalyok[$row][3];

    mysqli_stmt_bind_param($statement,"isss",$oszt,$szak,$szakasz,$jelszo);
    mysqli_stmt_execute($statement);

    $osztalynev = $oszt . $szak;
    $nevsor = $spreadsheetLoaded -> setActiveSheetIndexByName($osztalynev) -> toArray();

    mysqli_query($dbdiakconn,"DROP TABLE IF EXISTS ".$osztalynev);
    mysqli_query($dbdiakconn,"CREATE TABLE ".$osztalynev." ( `id` INT NOT NULL AUTO_INCREMENT , `vezeteknev` VARCHAR(255) NOT NULL , `keresztnev` VARCHAR(255) NOT NULL , `pontszam` INT , PRIMARY KEY (`id`))");

    $nrStudentRows = 1;
    while($nrStudentRows < sizeof($nevsor))
    {
      $vnev = $nevsor[$nrStudentRows][0];
      $knev = $nevsor[$nrStudentRows][1];
      $pontszam = $nevsor[$nrStudentRows][2];

      $sql = "INSERT INTO ".$osztalynev." (vezeteknev, keresztnev,pontszam) VALUES (?,?,?)";
      $statement = mysqli_stmt_init($dbdiakconn);
      if(!mysqli_stmt_prepare($statement,$sql))
      {
        header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
        exit();
      }
      mysqli_stmt_bind_param($statement,"ssi",$vnev,$knev,$pontszam);
      mysqli_stmt_execute($statement);

      $nrStudentRows++;
    }
    $row++;
  }

  header("Location: ../pages/adminAdatbazisKezeles.php?status=success");
  exit();

?>
