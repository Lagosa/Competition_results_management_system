<?php
  require 'connectDB.php';
  require 'calculateScore.php';
  require 'sessionInformation.php';
  header("Location: ../pages/diakBevezetes.php?log=sendValuesFile");

  $diak = $_POST['diak'];
  $tantargy = $_POST['tantargy'];
  $tanar = $_POST['tanar'];
  $kategoria = $_POST['kategoria'];
  $verseny = "";
  if($_POST['verseny'] != ""){
    $sql = "SELECT megnevezes FROM versenyek WHERE id = ?";
    $statement = mysqli_stmt_init($dbconn);
    if(!mysqli_stmt_prepare($statement,$sql)){
      header("Location: ../pages/diakBevezetes.php?error=databaseError&details=competitionName");
      exit();
    }else{
      mysqli_stmt_bind_param($statement,'i',$_POST['verseny']);
      mysqli_stmt_execute($statement);

      $result = mysqli_stmt_get_result($statement);
      $row = mysqli_fetch_assoc($result);

      $verseny = $row['megnevezes'];
    }
  }else if($_POST['versenyMas'] != ""){
    $verseny = $_POST['versenyMas'];
  }
  $periodus = $_POST['periodus'];
  $tantargy = $_POST['tantargy'];
  $szakasz = $_POST['szakasz'];
  $eredmeny = $_POST['eredmeny'];
  $tipus = $_POST['tipus'];
  $csapatSzam = $_POST['csapatSzam'];

  if($tipus == 'egyeni'){
	$csapatSzam = 1;
  }

  $tanarPontszam = $tanarPontszam / $csapatSzam ;


  if($diak == '' || $tantargy == '' || $tanar == '' || $kategoria == ''|| $szakasz == '' || $periodus == '' || $eredmeny == '' || $tipus == ''){
    header("Location: ../pages/diakBevezetes.php?error=emptyFields");
    exit();
  }else{
    // Elmenti az adattáblába a versenyeredményeket
    $sql = "INSERT INTO eredmenyek (osztaly,diakId, tanarId, megnevezes, tantargy, kategoria, periodus, szakasz, eredmeny, tipus, csapatSzam, pontszamTanar, pontszamDiak, felolvasva)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,0)";

    $statement = mysqli_stmt_init($dbconn);

    if(!mysqli_stmt_prepare($statement,$sql)){
      header("Location: ../pages/diakBevezetes.php?error=databaseError&details=insertFail");
      exit();
    }
    mysqli_stmt_bind_param($statement,'siisssssssiii',$oszt,$diak,$tanar,$verseny,$tantargy,$kategoria,$periodus,$szakasz,$eredmeny,$tipus,$csapatSzam,$tanarPontszam,$diakPontszam);
    mysqli_stmt_execute($statement);

    // Kiszámítja a diáknak és tanárnak járó pontszámot és lementi azt
    $regiPontszam = mysqli_query($dbdiakconn,"SELECT pontszam FROM ".$oszt." WHERE id = ".$diak);
    $row = mysqli_fetch_assoc($regiPontszam);
    $regiPontszam = $row['pontszam'];

    $pontszam = $diakPontszam + $regiPontszam;
    mysqli_query($dbdiakconn,'UPDATE '.$oszt.' SET pontszam = '.$pontszam.' WHERE id ='.$diak);

    $regiPontszam = mysqli_query($dbconn, "SELECT pontszam FROM tanarok WHERE id=".$tanar);
    $row = mysqli_fetch_assoc($regiPontszam);
    $regiPontszam = $row['pontszam'];

    $pontszam = $tanarPontszam + $regiPontszam;
    mysqli_query($dbconn,"UPDATE tanarok SET pontszam = ".$pontszam." WHERE id = ".$tanar);

    header("Location: ../pages/diakBevezetes.php?status=success");
    exit();
  }

?>
