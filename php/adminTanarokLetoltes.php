<?php
  require 'connectDB.php';
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
  $sheet = $excel -> getActiveSheet();
  $sheet -> setTitle('tanárok listája');
  $sheet -> setCellValue('A1','Tanár neve');
  $sheet -> setCellValue('B1','Tantárgy');
  $sheet -> setCellValue('C1','Pontszám');

  $sql = "SELECT * FROM tanarok";
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
    $sheet -> setCellValue('A'.$i,$row['vezeteknev'].' '.$row['keresztnev']);
    $sheet -> setCellValue('B'.$i,$row['tantargy']);
    $sheet -> setCellValue('C'.$i,$row['pontszam']);
    $i++;
  }

  $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
	$writer->save('../files/downloads/tanarok.xlsx');


	header("Location: ../files/downloads/tanarok.xlsx");
	exit();
?>
