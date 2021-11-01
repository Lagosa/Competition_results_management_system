<?php
  require 'connectDB.php';

  $teachers = "<option value=''> Név kiválasztása </option>";
  $sql = "SELECT vezeteknev,keresztnev,id FROM tanarok GROUP BY vezeteknev,keresztnev";
  $result = mysqli_query($dbconn,$sql) or die ("Bad SQL: $sql");
  while($row = mysqli_fetch_assoc($result)){
    $teachers .= "<option value='{$row['id']}'> {$row['vezeteknev']} {$row['keresztnev']} </option>";
  }

?>
