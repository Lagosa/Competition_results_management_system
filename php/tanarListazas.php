<?php
  require_once "../files/mpdf" . '/vendor/autoload.php';
  require 'connectDB.php';


  $tanarID = $_POST['tanar'];
  $tanarNeveRes = mysqli_query($dbconn,"SELECT keresztnev,vezeteknev,pontszam FROM tanarok WHERE id = {$tanarID}") or die ("Bad SQL");
  $row = mysqli_fetch_assoc($tanarNeveRes);
  $tanarNeve = $row['vezeteknev'] .' '. $row['keresztnev'];
  $pontszam = $row['pontszam'];


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
  $pdf -> WriteCell(93,10,'~ tanárra lebontva ~',0,0,'C');
  $pdf -> WriteCell(5,10,'',0,0,'C');
  $pdf -> SetFont('Courier','I','15');
  $pdf -> WriteCell(20,10,'tanár: ',0,0,'L');
  $pdf -> SetFont('Courier','B','15');
  $pdf -> WriteCell(67,10,$tanarNeve,0,0,'C');

  $pdf -> Ln();
  $pdf -> WriteCell(190,5,'',0,0,'C');
  $pdf -> SetFont('Courier','I','15');
  $pdf -> WriteCell(30,5,'pontszám:',0,0,'L');
  $pdf -> SetFont('Courier','B','15');
  $pdf -> WriteCell(57,5,$pontszam,0,0,'C');

  $pdf -> Ln();
  $pdf -> WriteCell(277,20,'',0,0,'L');

  $pdf -> Ln();

  $versenyekLista = mysqli_query($dbconn,"SELECT * FROM eredmenyek WHERE tanarId = {$tanarID} ORDER BY osztaly asc,megnevezes asc");
  $sorsz = 1;
  $pdf -> SetFont('Courier','','10');
  $table = "<style>
  table{hypenate:auto;vertical-align:middle;text-align:center;width:100%;}
  .hTd{font-family:Arial;font-weight:bold;border-bottom:2px solid black; background-color:#cccccc;}
  td{border-bottom:1px solid black;} </style>";
  $table .= "<table> <tr > <td class='hTd'> Sorsz. </td> <td class='hTd'> Diák </td><td class='hTd'> Osztály </td><td class='hTd'> Verseny </td><td class='hTd'> Szakasz </td>
  <td class='hTd'> Kategória </td><td class='hTd'> Eredmény </td><td class='hTd'> Típus </td><td class='hTd'> Csapat. Szám. </td><td class='hTd'> Pontszám </td></tr>";

  while($row = mysqli_fetch_assoc($versenyekLista)){
    $diakNeveRes = mysqli_query($dbdiakconn,"SELECT vezeteknev,keresztnev FROM {$row['osztaly']} WHERE id= {$row['diakId']}");
    $rowH = mysqli_fetch_assoc($diakNeveRes);

    if($sorsz % 2 == 0){
      $color = "#eeeeee";
    }else{
      $color = "white";
    }

    $table .= "<tr style='background-color:".$color.";'><td>" . $sorsz . "</td><td>".$rowH['vezeteknev'].$rowH['keresztnev']."</td><td>".$row['osztaly']."</td><td>".$row['megnevezes'].
    "</td><td>".$row['szakasz']."</td><td>".$row['kategoria']."</td><td>".$row['eredmeny']."
    </td><td>".$row['tipus']."</td><td>".$row['csapatSzam']."</td><td>".$row['pontszamTanar']."</td> </tr>";

    $sorsz = $sorsz + 1;
  }
  $table .= "</table>";
  $pdf->WriteHTML($table);
  $pdf -> Output();

?>
