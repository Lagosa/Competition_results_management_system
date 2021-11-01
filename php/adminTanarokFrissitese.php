<?php
  require "connectDB.php";
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  if($_FILES["tanarokListaja"]["error"] != 0){
    header("Location: ../pages/adminAdatbazisKezeles.php?error=noFileUploaded");
    exit();
  }

  $target_file = "../files/upload".basename($_FILES["tanarokListaja"]["name"]);
  $imageFileExtension = pathinfo($target_file,PATHINFO_EXTENSION);
  move_uploaded_file($_FILES["tanarokListaja"]["tmp_name"],$target_file);

  $spreadsheetLoaded = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);
  rename($target_file,"../files/uploads/tanarok.".$imageFileExtension);

  $tanarok = $spreadsheetLoaded -> getActiveSheet() -> toArray();

  mysqli_query($dbconn,"DROP TABLE IF EXISTS tanarok");
  mysqli_query($dbconn,"CREATE TABLE tanarok ( `id` INT NOT NULL AUTO_INCREMENT , `vezeteknev` VARCHAR(255) NOT NULL , `keresztnev` VARCHAR(255) NOT NULL , `tantargy` VARCHAR(255) NOT NULL , `pontszam` FLOAT , PRIMARY KEY (`id`))");

  $row = 1;
  while($row < sizeof($tanarok))
  {
    $vnev = strtok($tanarok[$row][0], ' ');
    $knev = strtok(' ');
    $tantargy = $tanarok[$row][1];
    $pontszam = $tanarok[$row][2];

    $sql = "INSERT INTO tanarok (vezeteknev, keresztnev,tantargy,pontszam) VALUES (?,?,?,?)";
    $statement = mysqli_stmt_init($dbconn);

    if(!mysqli_stmt_prepare($statement,$sql))
    {
      header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
      exit();
    }

    mysqli_stmt_bind_param($statement, "sssi",$vnev,$knev,$tantargy,$pontszam);
    mysqli_stmt_execute($statement);

    $row++;
  }

  Header("Location: ../pages/adminAdatbazisKezeles.php?status=success");
  exit();
 ?>
