<?php
//Erzeugen Sie eine weitere Seite (darstellerfilter.php), in welcher nach Darstellern (keine Regisseure; diese sollen nicht angezeigt werden)
// gefiltert werden kann (Screenshot: Darstellerfilter.png). Erzeugen Sie hierzu ein geeignetes Suchformular
// (siehe Screenshots Darstellerfilter_BradPitt.png, Darstellerfilter_Tom.png, Darstellerfilter_TomCruise.png),
// wo nach Vor- und/oder Nachname einer Person gefiltert werden kann. Stellen Sie alsdann alle Besuche dieser Person dar.
include("includes/db.php");
require("includes/config.inc.php");
$sqlw="";
if (count($_POST)>0) {
  te($_POST);
  $arr=array();
       if (strlen($_POST['vorname'])>0) {
         $arr[]="tbl_fv_personen.Vorname LIKE '%".$_POST['vorname']."%'";
       }
       if (strlen($_POST['nachname'])>0) {
     $arr[]="tbl_fv_personen.Nachname LIKE '%".$_POST['nachname']."%'";
       }
       $sqlw="
         WHERE(
           " . implode(" AND ",$arr) . "
           )
       ";
       }else {
         $sqlw="";
       }
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
     <form class=""  method="post">
       <div class="form-group">
        <label for="vorname">Vorname</label>
        <input type="text" class="form-control" id="vorname" name="vorname">
      </div>
      <div class="form-group">
       <label for="nachname">Nachname:</label>
       <input type="text" class="form-control" id="nachname" name="nachname">
     </div>
     <div class="form-group">
      <input type="submit" class="form-control" value="filtern">
    </div>
     </form>
   </div>
   <ul>


   <?php
$sql="
SELECT tbl_filme_darsteller.*,tbl_fv_filme.*,tbl_fv_personen.* FROM tbl_filme_darsteller
INNER JOIN tbl_fv_filme ON tbl_filme_darsteller.FIDFilm  = tbl_fv_filme.IDFilm
LEFT JOIN tbl_fv_personen ON tbl_filme_darsteller.FIDDarsteller  = tbl_fv_personen.IDPerson
". $sqlw ."
";
$darstellrn = $conn->query($sql) or die("Fehler in der Query:" . $conn->error);

if ($darstellrn->num_rows > 0) {
  // output data of each row
  while($darstellr = $darstellrn->fetch_assoc()) {
    echo '
    <li>'. $darstellr['Vorname'] .' '. $darstellr['Nachname'] .'</li>
    <ul>
    <li>'. $darstellr['Titel'] .'</li>
    <li>Erscheinungsjahr: '. $darstellr['Erscheinungsjahr'] .'</li>
    <li>Bewertung: '. $darstellr['Bewertung'] .'</li>
    <li>zuletztangesehen: '. $darstellr['Titel'] .' Uhr</li>
    <li>zuletztangesehen: '. $darstellr['Beschreibung'] .' Uhr</li>
    </ul>
    ';
  }
} else {
  echo "<p> Gibt es keine Bescuh </p>";
}

    ?>

   </ul>

   </body>
 </html>
