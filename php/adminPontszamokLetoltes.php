<?php
  require 'connectDB.php';
  require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

  $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
  $sheet = $excel -> getActiveSheet();
  $sheet -> setTitle('pontszámok értékei');
  $sheet -> setCellValue('A1','kategória');
  $sheet -> setCellValue('B1','Szakasz');
  $sheet -> setCellValue('C1','Eredmény');
  $sheet -> setCellValue('D1','Típus');
  $sheet -> setCellValue('E1','Diák');
  $sheet -> setCellValue('F1','Tanár');

  $sql = "SELECT * FROM pontszamok";
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
    $sheet -> setCellValue('A'.$i,$row['kategoria']);
    $sheet -> setCellValue('B'.$i,$row['szakasz']);
    $sheet -> setCellValue('C'.$i,$row['eredmeny']);
    $sheet -> setCellValue('D'.$i,$row['tipus']);
    $sheet -> setCellValue('E'.$i,$row['diakPontszam']);
    $sheet -> setCellValue('F'.$i,$row['tanarPontszam']);
    $i++;
  }

  $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
	$writer->save('../files/downloads/pontszamok.xlsx');


	header("Location: ../files/downloads/pontszamok.xlsx");
	exit();
?>
