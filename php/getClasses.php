<?php
  require 'connectDB.php';

  $classOpt = '<option value="">Osztály</option>';

  $classRes = mysqli_query($dbconn,"SELECT osztaly,szak FROM osztalyok ORDER BY osztaly asc,szak asc") or die("Bad sql!");
  while($row = mysqli_fetch_assoc($classRes)){
    if($row['osztaly'] == 'e' && $row['szak'] == 'a'){
      $classOpt .= "<option value='elemi'>Elemi</option>";
    }else if($row['osztaly'] == '5' && $row['szak'] == 'a'){
      $classOpt .= "<option value='gimnázium'>Gimnázium</option>";
    }else if($row['osztaly'] == '9' && $row['szak'] == 'h'){
      $classOpt .= "<option value='líceum'>Líceum</option>";
    }
    $osztaly = $row['osztaly'].$row['szak'];
    $classOpt .= "<option value='{$osztaly}'>{$osztaly}</option>";
  }
  $classOpt .= "<option value='osszes'> Összes </option>";
?>
