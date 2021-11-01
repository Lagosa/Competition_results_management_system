<?php
  require 'connectDB.php';
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
  $sheet = $excel -> getActiveSheet();
  $sheet -> setTitle('versenyek listája');
  $sheet -> setCellValue('A1','Verseny megnevezése');
  $sheet -> setCellValue('B1','Tantárgy');
  $sheet -> setCellValue('C1','Kategória');

  $sql = "SELECT * FROM versenyek";
  $statement = mysqli_stmt_init($dbconn);
  if(!mysqli_stmt_prepare($statement,$sql)){
		header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
		exit();
	}
  mysqli_stmt_execute($statement);
  $result = mysqli_stmt_get_result($statement);
  $i = 2;
  while($row = mysqli_fetch_assoc($result))
  {
    $sheet -> setCellValue('A'.$i,$row['megnevezes']);
    $sheet -> setCellValue('B'.$i,$row['tantargy']);
    $sheet -> setCellValue('C'.$i,$row['kategoria']);
    $i++;
  }

  $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
	$writer->save('../files/downloads/versenyek.xlsx');


	header("Location: ../files/downloads/versenyek.xlsx");
	exit();
?>
