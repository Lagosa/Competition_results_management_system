<?php
  require "connectDB.php";
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  if($_FILES["tanarokListaja"]["error"] != 0){
    header("Location: ../pages/adminAdatbazisKezeles.php?error=noFileUploaded");
    exit();
  }

  $target_file = "../files/upload".basename($_FILES["versenyekListaja"]["name"]);
  $imageFileExtension = pathinfo($target_file,PATHINFO_EXTENSION);
  move_uploaded_file($_FILES["versenyekListaja"]["tmp_name"],$target_file);

  $spreadsheetLoaded = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);
  rename($target_file,"../files/uploads/versenyek.".$imageFileExtension);

  $versenyek = $spreadsheetLoaded -> getActiveSheet() -> toArray();

  mysqli_query($dbconn,"DROP TABLE IF EXISTS versenyek");
  mysqli_query($dbconn,"CREATE TABLE versenyek ( `id` INT NOT NULL AUTO_INCREMENT , `megnevezes` VARCHAR(255) NOT NULL , `tantargy` VARCHAR(255) NOT NULL , `kategoria` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`))");

  $row = 1;
  while($row < sizeof($versenyek))
  {
    $megnevezes = $versenyek[$row][0];
    $tantargy = $versenyek[$row][1];
    $kategoria = $versenyek[$row][2];

    $sql = "INSERT INTO versenyek (megnevezes, tantargy,kategoria) VALUES (?,?,?)";
    $statement = mysqli_stmt_init($dbconn);

    if(!mysqli_stmt_prepare($statement,$sql))
    {
      header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
      exit();
    }

    mysqli_stmt_bind_param($statement, "sss",$megnevezes,$tantargy,$kategoria);
    mysqli_stmt_execute($statement);

    $row++;
  }

  Header("Location: ../pages/adminAdatbazisKezeles.php?status=success");
  exit();
 ?>
