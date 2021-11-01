<?php
  require '../php/sessionInformation.php';
  require '../php/connectDB.php';
  $status = '';
  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields') {
      $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Maradtak üresen mezők!</td></tr></table>";
    }else if($_GET['error'] == 'databaseError'){
      $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Hiba történt. <br> Próbáld újra!</td></tr></table>";
    }
  }else if(isset($_GET['status'])){
    if($_GET['status'] == 'success'){
      $status = "<table class='success'><tr><td id='wtd'><i class='material-icons'>done</i></td><td id='ttd'>Verseny sikeresen bejegyezve!</td></tr></table>";
    }
  }

  $diak = "";
  $tantargy = "";
  $tanar = "";
  $kategoria = "";
  $verseny = "";
  $periodus = "";
  $szakasz = "";
  $eredmeny = "";
  $versenyMas = "";
  $tipus = "";
  $csapatSzam = "";

  $displayCsapatSzamInput = "";
  $displayMasVersenyInput = "";

  $sql = "SELECT * FROM {$oszt}";
  $result = mysqli_query($dbdiakconn,$sql) or die ("Bad SQL: $sql");

  $optDiak = "<option value=''> Diák neve </option>";
  while($row = mysqli_fetch_assoc($result)){
    $optDiak .= "<option value='{$row['id']}'> {$row['vezeteknev']} {$row['keresztnev']} </option>";
  }


  $sql = "SELECT DISTINCT tantargy FROM tanarok WHERE tantargy != '' ORDER BY tantargy asc";
  $result = mysqli_query($dbconn,$sql) or die ("Bad SQL: $sql");

  $optTantargy = "<option value=''> Tantárgy megnevezése </option>";
  while($row = mysqli_fetch_assoc($result)){
    $optTantargy .= "<option value='{$row['tantargy']}'> {$row['tantargy']} </option>";
  }

  $optTanar = "<option value=''> Tanár neve </option>";
  $optVerseny = "<option value=''> Verseny neve </option>";
  $optVersenyMas = "";

    $optKategoria = "<option value=''> Verseny kategoriája </option>
    <option value='olimpia'> Olimpia </option>
    <option value='tamogatott'> Elismert </option>
    <option value='nem tamogatott'> Nem Elismert </option>
    <option value='Mas'> Mas - Nem szerepel a listan</option>";

    $optPeriodus = "<option value=''> Verseny periódusa </option>
    <option value='szeptember'> Szeptember </option>
    <option value='oktober'> Október </option>
    <option value='november'> November </option>
    <option value='december'> December </option>
    <option value='januar'> Január </option>
    <option value='februar'> Február </option>
    <option value='marcius'> Március </option>
    <option value='aprilis'> Április </option>
    <option value='majus'> Május </option>
    <option value='junius'> Június </option>";

    $optSzakasz = "<option value=''> Verseny szakasza </option>
    <option value='helyi'> Helyi </option>
    <option value='megyei'> Megyei </option>
    <option value='regionalis'> Regionális </option>
    <option value='orszagos'> Országos </option>
    <option value='nemzetkozi'> Nemzetközi </option>";

    $optEredmeny = "<option value=''> Elért eredmény </option>
    <option value='1'> I. díj </option>
    <option value='2'> II. díj </option>
    <option value='3'> III.díj </option>
    <option value='dicseret'> Dícséret </option>
    <option value='kulondij'> Különdíj </option>
    <option value='reszvetel'> Részvétel </option>";

    $optTipus = "<option value=''> Verseny Típusa </option>
    <option value='egyeni'> Egyéni </option>
    <option value='csapatos'> Csapatos </option>";


  if(isset($_GET['diakNeve'])){

    $diak = $_GET['diakNeve'];
    $tantargy = $_GET['tantargy'];
    $tanar = $_GET['tanar'];
    $kategoria = $_GET['kategoria'];
    $verseny = $_GET['verseny'];
    $versenyMas = $_GET['versenyMas'];
    $periodus = $_GET['periodus'];
    $szakasz = $_GET['szakasz'];
    $eredmeny = $_GET['eredmeny'];
    $tipus = $_GET['tipus'];
    $csapatSzam = $_GET['csapatSzam'];

    if($diak != ""){
      $sql = "SELECT vezeteknev,keresztnev FROM {$oszt} WHERE id = {$diak}";
      $diakNeveRes = mysqli_query($dbdiakconn,$sql) or die ("Bad SQL: $sql");
      $res = mysqli_fetch_assoc($diakNeveRes);
      $optDiak = "<option value='$diak'> {$res['vezeteknev']} {$res['keresztnev']} </option>";

    }
    if($tantargy != ""){
      $optTantargy = "<option value='$tantargy'> $tantargy </option>";
    }
    if($tanar != ""){
      $sql = "SELECT vezeteknev,keresztnev FROM tanarok WHERE id = {$tanar}";
      $tanarNeveRes= mysqli_query($dbconn,$sql) or die ("Bad SQL: $sql");
      $res = mysqli_fetch_assoc($tanarNeveRes);
      $optTanar = "<option value='$tanar'> {$res['vezeteknev']} {$res['keresztnev']} </option>";
    }
    else{
      $sql = "SELECT id,vezeteknev,keresztnev FROM tanarok WHERE tantargy = '$tantargy'";
      $result = mysqli_query($dbconn,$sql) or die ("Bad SQL: $sql");

      while($row = mysqli_fetch_assoc($result)){
        $optTanar .= "<option value='{$row['id']}'> {$row['vezeteknev']} {$row['keresztnev']} </option>";
      }
    }
    if($kategoria != ""){
      $optKategoria = "<option value='$kategoria'> $kategoria </option>";
      if($kategoria == "Mas"){
        $displayMasVersenyInput = "document.getElementById('versenyMas').style.visibility = 'visible'; document.getElementById('verseny').style.visibility = 'hidden';";
      }
    }
    if($verseny != ""){
      $sql = "SELECT megnevezes FROM versenyek WHERE id = {$verseny}";
      $versenyNeveRes = mysqli_query($dbconn,$sql) or die ("Bad SQL: $sql");
      $res = mysqli_fetch_assoc($versenyNeveRes);
      $optVerseny = "<option value='{$verseny}'> {$res['megnevezes']} </option>";
    }
    else{
      if($versenyMas != ""){
        $optVersenyMas = "<input type='text' name='versenyMas' id='versenyMas' class='textInput' value='$versenyMas'>";
      }else{
        $sql = "SELECT id,megnevezes FROM versenyek WHERE kategoria = '{$kategoria}' AND (tantargy = '{$tantargy}' OR tantargy = 'multidisciplináris')";
        $result = mysqli_query($dbconn,$sql) or die ("Bad SQL: $sql");

        while($row = mysqli_fetch_assoc($result)){
          $optVerseny .= "<option value='{$row['id']}'> {$row['megnevezes']} </option>";
        }
      }
    }

    if($periodus != ""){
      $optPeriodus = "<option value='$periodus'>$periodus</option>";
    }

    if($szakasz != ""){
      $optSzakasz = "<option value='$szakasz'>$szakasz </option>";
    }

    if($eredmeny != ""){
      $optEredmeny = "<option value='$eredmeny'> $eredmeny </option>";
    }

    if($tipus != ""){
      $optTipus = "<option value='$tipus'> $tipus </option>";
      if($tipus == "csapatos"){
        $displayCsapatSzamInput = "document.getElementById('tipus').style.display = 'block';";
      }
    }

    if($csapatSzam != ""){
      $optCsapatSzam = "<input type='text' name='csapatSzam' class='textInput' id='csapatSzam' value='$csapatSzam' >";
    }

  }

?>
