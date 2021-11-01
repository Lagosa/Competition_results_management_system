<?php
  require "connectDB.php";
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  if(!isset($_FILES["pontszamokListaja"]["tmp_name"])){
    header("Location: ../pages/adminAdatbazisKezeles.php?error=noFileUploaded");
    exit();
  }

  $target_file = "../files/upload".basename($_FILES["pontszamokListaja"]["name"]);
  $imageFileExtension = pathinfo($target_file,PATHINFO_EXTENSION);
  move_uploaded_file($_FILES["pontszamokListaja"]["tmp_name"],$target_file);

  $spreadsheetLoaded = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);
  rename($target_file,"../files/uploads/pontszamok.".$imageFileExtension);

  $pontszamok = $spreadsheetLoaded -> getActiveSheet() -> toArray();

  mysqli_query($dbconn,"DROP TABLE IF EXISTS pontszamok");
  mysqli_query($dbconn,"CREATE TABLE pontszamok ( `id` INT NOT NULL AUTO_INCREMENT , `kategoria` VARCHAR(50) NOT NULL, `szakasz` VARCHAR(50) NOT NULL , `eredmeny` VARCHAR(50) NOT NULL ,`tipus` VARCHAR(50) NOT NULL ,`diakPontszam` DOUBLE NOT NULL , `tanarPontszam` DOUBLE NOT NULL , PRIMARY KEY (`id`))");

  $row = 1;
  while($row < sizeof($pontszamok))
  {
    $kategoria = $pontszamok[$row][0];
    $szakasz = $pontszamok[$row][1];
    $eredmeny = $pontszamok[$row][2];
    $tipus = $pontszamok[$row][3];
    $diak = $pontszamok[$row][4];
    $tanar = $pontszamok[$row][5];

    $sql = "INSERT INTO pontszamok (kategoria, szakasz,eredmeny,tipus,diakPontszam,tanarPontszam) VALUES (?,?,?,?,?,?)";
    $statement = mysqli_stmt_init($dbconn);

    if(!mysqli_stmt_prepare($statement,$sql))
    {
      header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
      exit();
    }

    mysqli_stmt_bind_param($statement, "ssssdd",$kategoria,$szakasz,$eredmeny,$tipus,$diak,$tanar);
    mysqli_stmt_execute($statement);

    $row++;
  }

  Header("Location: ../pages/adminAdatbazisKezeles.php?status=success");
  exit();
 ?>
