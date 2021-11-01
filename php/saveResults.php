<?php
  require 'sessionInformation.php';
  header("Location: ../pages/diakBevezetes.php?diakNeve={$_POST['diak']}&tantargy={$_POST['tantargy']}&tanar={$_POST['tanar']}&kategoria={$_POST['kategoria']}"
  ."&verseny={$_POST['verseny']}&versenyMas={$_POST['versenyMas']}&periodus={$_POST['periodus']}&szakasz={$_POST['szakasz']}&eredmeny={$_POST['eredmeny']}&tipus={$_POST['tipus']}"
  ."&csapatSzam={$_POST['csapatSzam']}");
?>
