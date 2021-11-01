<?php
	require 'connectDB.php';
	require_once "../files/PhpSpreadsheet-master/".'vendor/autoload.php';

	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
	$sheet = $excel -> getActiveSheet();
	$sheet -> setTitle('osztalyok');
	$sheet -> setCellValue('A1','Osztály');
	$sheet -> setCellValue('B1','Szak');
	$sheet -> setCellValue('C1','Szakasz');
	$sheet -> setCellValue('D1','Jelszó');

	$sql = "SELECT * FROM osztalyok";
	$statement = mysqli_stmt_init($dbconn);
	if(!mysqli_stmt_prepare($statement,$sql)){
		header("Location: ../pages/adminAdatbazisKezeles.php?error=databaseError");
		exit();
	}
	mysqli_stmt_execute($statement);
	$result = mysqli_stmt_get_result($statement);
	$i = 2;
	while($row = mysqli_fetch_assoc($result)){
		$osztaly = $row['osztaly'].$row['szak'];

		$excel -> getSheetByName('osztalyok');
		$sheet = $excel -> getActiveSheet();
		$sheet -> setCellValue('A'.$i,$row['osztaly']);
		$sheet -> setCellValue('B'.$i,$row['szak']);
		$sheet -> setCellValue('C'.$i,$row['szakasz']);
		$sheet -> setCellValue('D'.$i,$row['jelszo']);

		$sheet = $excel->createSheet();
		$sheet -> setTitle($osztaly);
		$sheet -> setCellValue('A1','Vezetéknév');
		$sheet -> setCellValue('B1','Keresztnév');
		$sheet -> setCellValue('C1','Pontszám');

		$sql = "SELECT * FROM ".$osztaly;
		$statementDiak = mysqli_stmt_init($dbdiakconn);
		if(!mysqli_stmt_prepare($statementDiak,$sql)){
			header("Location: ../index.php?error=databaseError");
			exit();
		}
		mysqli_stmt_execute($statementDiak);
		$resultDiak = mysqli_stmt_get_result($statementDiak);

		$j = 2;
		while($rowDiak = mysqli_fetch_assoc($resultDiak)){
			$sheet -> setCellValue("A".$j,$rowDiak['vezeteknev']);
			$sheet -> setCellValue("B".$j,$rowDiak['keresztnev']);
			$sheet -> setCellValue("C".$j,$rowDiak['pontszam']);
			$j++;
		}
		$i++;
	}


	$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
	$writer->save('../files/downloads/osztalyok.xlsx');


	header("Location: ../files/downloads/osztalyok.xlsx");
	exit();
?>
