<?php

//Erzeugen Sie danach noch eine Seite (datumsfilter.php), in welcher nach dem Erscheinungsjahr (von/bis) gefiltert werden kann
// (Screenshot: Datumsfilter.png). Erzeugen Sie wie zuvor auch ein geeignetes Suchformular (siehe Screenshots:
// Datumfilter_ab2000.png, Datumsfilter_bis2000.png, Datumsfilter_von1990bis1995.png sowie Datumsfilter_von1990bis2000.png).
// Stellen Sie alsdann alle Filme in diesem Zeitraum dar (geordnet nach dem Erscheinungsdatum).
include("includes/db.php");
require("includes/config.inc.php");
$sqlw="";
if (count($_POST)>0) {
  te($_POST);
  $arr=array();
  if (strlen($_POST['von'])>0) {
    $arr[]="tbl_fv_filme.Erscheinungsjahr >= '". $_POST['von'] ."'";
  }
  if (strlen($_POST['bis'])>0) {
    $arr[]="tbl_fv_filme.Erscheinungsjahr <= '". $_POST['bis'] ."'";
  }
  if (count($arr)>0) {
    $sqlw="
    WHERE(". implode(" AND ",$arr) .")
    ";
  }

}
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <title></title>
     <style media="screen">
     .center {
      margin: auto;
      width: 50%;
      border: 2px solid gray;
      padding: 10px;
      }
     </style>
   </head>
   <body>
     <header>
       <nav>
         <ul>
           <li> <a href="index.php">Erste Seite</a></li>
            <li> <a href="filmverwaltung.php">filmverwaltung</a></li>
            <li> <a href="darstellerFilter.php">Nach Darschlern filtern</a></li>
            <li> <a href="erscheinungsJahrFilter.php">Nach Erscheinungsjahr filtern</a></li>
         </ul>
       </nav>
     </header>
     <div class="center">
       <form class="" method="post">
     <div class="mb-3">
      <label for="von" class="form-label">Von:</label>
      <input type="datetime" class="form-control" id="von" name="von">
    </div>
    <div class="mb-3">
     <label for="bis" class="form-label">Bis:</label>
     <input type="datetime" class="form-control" id="bis" name="bis">
   </div>
   <div class="mb-3">
    <input type="submit" class="form-control" value="filtern">
  </div>
  </div>
  </form>
<ul>


  <?php
$sql="
SELECT tbl_fv_filme.*,tbl_fv_genres.Bezeichnung FROM tbl_fv_filme
LEFT JOIN tbl_fv_genres ON tbl_fv_filme.FIDGenre = tbl_fv_genres.IDGenre
". $sqlw  ."

";
$filmen = $conn->query($sql) or die("Fehler in der Query:" . $conn->error);

if ($filmen->num_rows > 0) {
  // output data of each row
  while($filme = $filmen->fetch_assoc()) {
    echo '<li>'. $filme['Titel'] .'</li>
    <ul>
    <li>Erscheinungsjahr: '. $filme['Erscheinungsjahr'] .'</li>
    <li>Bewertung: '. $filme['Bewertung'] .'</li>
    <li>zuletztangesehen: '. $filme['zuletztangesehen'] .'</li>
    <li>Dauer: '. $filme['Dauer'] .'</li>
    <li>Genre: '. $filme['Bezeichnung'] .'</li>
    <li>Beschreibung: '. $filme['Beschreibung'] .'</li>
    </ul>
    ';
  }
} else {
  echo "<p>für dieser Datum kein filme erzeugt wurden</p>";
}



   ?>
   </ul>
   </body>
 </html>
