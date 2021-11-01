<?php
  require_once '../files/mpdf/vendor/autoload.php';
  require 'connectDB.php';

  $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
  $pdf -> AddPage();
  $pdf -> SetFont('Arial','B','20');
  $pdf->SHYlang = 'en';
  $pdf->SHYleftmin = 3;
  $pdf -> setFooter('{PAGENO}');
  $pdf -> WriteCell(277,10,'Versenyeredmények',0,0,'C');

  $pdf -> Ln();
  $pdf -> SetFont('Arial','I','17');
  $pdf -> WriteCell(92,10,'',0,0,'C');
  $pdf -> WriteCell(93,10,'~ tanárok pontszáma ~',0,0,'C');
  $pdf -> WriteCell(82,10,'',0,0,'C');

  $pdf -> Ln();
  $pdf -> WriteCell(277,20,'',0,0,'L');

  $pdf -> Ln();

  $sorsz = 1;
  $tanarokRes = mysqli_query($dbconn,"SELECT * FROM tanarok GROUP BY vezeteknev,keresztnev");

  $table = "<style>
  table{hypenate:auto;vertical-align:middle;text-align:center;width:100%;}
  .hTd{font-family:Arial;font-weight:bold;border-bottom:2px solid black; background-color:#cccccc;}
  td{border-bottom:1px solid black;}
  </style>";
  $table .= "<table><tr><td class='hTd'> Tanár neve </td><td class='hTd'> Tantárgy </td><td class='hTd'> Diák neve </td><td class='hTd'> Verseny </td>
  <td class='hTd'> Szakasz </td><td class='hTd'> Kategoria </td> <td class='hTd'> Eredmény </td><td class='hTd'> Típus </td><td class='hTd'> Pontszám </td><td class='hTd'> Összesen </td></tr>";
  while($row = mysqli_fetch_assoc($tanarokRes)){
    $tanarokIdRes = mysqli_query($dbconn,"SELECT * FROM tanarok WHERE vezeteknev ='".$row['vezeteknev']."' AND keresztnev='".$row['keresztnev']."'");

    $tantargydb = 0;
    $tanarPontszama = 0;
    while($rowTanarId = mysqli_fetch_assoc($tanarokIdRes)){
      $tanarPontszama = $tanarPontszama + $rowTanarId['pontszam'];
      $tanarIdNrRes = mysqli_query($dbconn,"SELECT COUNT(id) AS rowNr FROM eredmenyek WHERE tanarId=".$rowTanarId['id']);
      $tanarIdNr = mysqli_fetch_assoc($tanarIdNrRes);
      $tantargydb = $tantargydb + $tanarIdNr['rowNr'];
    }

    $tanarokIdRes = mysqli_query($dbconn,"SELECT * FROM tanarok WHERE vezeteknev ='".$row['vezeteknev']."' AND keresztnev='".$row['keresztnev']."'");
    $elso = 1;
    while($rowTanarId = mysqli_fetch_assoc($tanarokIdRes)){
      $eredmenyekRes = mysqli_query($dbconn,"SELECT megnevezes,diakId,kategoria,szakasz,eredmeny,pontszamTanar,tipus,osztaly FROM eredmenyek WHERE tanarId=".$rowTanarId['id']);
      $tanarIdNrRes = mysqli_query($dbconn,"SELECT COUNT(id) AS rowNr FROM eredmenyek WHERE tanarId=".$rowTanarId['id']);
      $tanarIdNr = mysqli_fetch_assoc($tanarIdNrRes);

      $elsoTantargy = 1;
      while($rowEredmeny = mysqli_fetch_assoc($eredmenyekRes)){
        if($sorsz % 2 == 0){
          $color = "#eeeeee";
        }else{
          $color = "white";
        }
        $diakNeveRs = mysqli_query($dbdiakconn,"SELECT vezeteknev,keresztnev FROM ".$rowEredmeny['osztaly']." WHERE id=".$rowEredmeny['diakId']);
        $diakNeve = mysqli_fetch_assoc($diakNeveRs);
        if($elso == 1){
          $table .= "<tr style='background-color:".$color.";'><td rowspan='".$tantargydb."'>".$row['vezeteknev']." ".$row['keresztnev']."</td>";
          if($elsoTantargy == 1){
            $table .= "<td rowspan='".$tanarIdNr['rowNr']."'>".$rowTanarId['tantargy']."</td>";
            $elsoTantargy = 0;
          }
          $table.="<td> ".$diakNeve['vezeteknev']." ".$diakNeve['keresztnev']." </td>
          <td> ".$rowEredmeny['megnevezes']." </td><td> ".$rowEredmeny['szakasz']." </td><td> ".$rowEredmeny['kategoria']." </td><td> ".$rowEredmeny['eredmeny']." </td><td> ".$rowEredmeny['tipus']." </td>
          <td> ".$rowEredmeny['pontszamTanar']." </td><td rowspan='".$tantargydb."'> ".$tanarPontszama." </td></tr>";
          $elso = 0;
        }else{
          $table .= "<tr style='background-color:".$color.";'>";
          if($elsoTantargy == 1){
            $table .= "<td rowspan='".$tanarIdNr['rowNr']."'>".$rowTanarId['tantargy']."</td>";
            $elsoTantargy = 0;
          }
          $table .= "<td> ".$diakNeve['vezeteknev']." ".$diakNeve['keresztnev']." </td>
          <td> ".$rowEredmeny['megnevezes']." </td><td> ".$rowEredmeny['szakasz']." </td><td> ".$rowEredmeny['kategoria']." </td><td> ".$rowEredmeny['eredmeny']." </td><td> ".$rowEredmeny['tipus']." </td>
          <td> ".$rowEredmeny['pontszamTanar']." </td></tr>";
        }
        $sorsz = $sorsz + 1;
      }
    }
  }
  $table .= "</table>";
  $pdf -> WriteHTML($table);
  $pdf -> Output("tanarok_pontszama.pdf","I");
?>
