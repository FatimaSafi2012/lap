<?php

//Erstellen Sie alsdann eine erste Seite, in der - chronologisch geordnet - sämtliche Besuche aufgelistet sind und geben Sie sämtliche Daten zu den Besuchen und Besuchern aus
// (siehe Screenshot: besucherprotokoll.png). Für jede Person und jeden Besuch soll in der Datenbank die Möglichkeit einer Kommentarangabe bestehen;
// sollte diese leer sein, so geben Sie auf der Seite "keine" aus.

include("includes/db.php");
require("includes/config.inc.php");
 ?>
 <!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <header>
       <nav>
         <ul>
           <li><a href="index.php">Erste Seite</a></li>
            <li><a href="besuchliste.php">Besuchliste</a></li>
            <li><a href="personenFilter.php">nach Personen Filtern</a></li>
            <li><a href="datumFilter.php">nach Datum Filtern</a></li>
         </ul>
       </nav>
     </header>
<h3>Besuchliste</h3>
<ul>


<?php
$sql = "
  SELECT tbl_zt_besuche.*,tbl_zt_personen.*,tbl_zt_ausweisarten.* FROM tbl_zt_besuche
  INNER JOIN tbl_zt_personen ON tbl_zt_besuche.FIDPerson= tbl_zt_personen.IDPerson
  LEFT JOIN tbl_zt_ausweisarten ON tbl_zt_besuche.FIDAusweisart = tbl_zt_ausweisarten.IDAusweisart
";
$besuchen = $conn->query($sql) or die("Fehler in der Query:". $conn->error);

if ($besuchen->num_rows > 0) {
  // output data of each row
  while($besuch = $besuchen->fetch_assoc()) {
    if ( $besuch['Anmerkungen']== NULL) {
      $besuchAnmerkung="keine";
    }else {
      $besuchAnmerkung= $besuch['Anmerkungen'];
    }

    if ($besuch['Kommentar']== NULL) {
      $personAnmerkung="keine";
    }else {
      $personAnmerkung=$besuch['Kommentar'];
    }
    echo '
    	<li>'. $besuch['BesuchVon'] .' bis '. $besuch['BesuchBis'] .' Uhr</li>
      <ul>
      <li>'. $besuch['Vorname'] .'  '. $besuch['Nachname'] .'</li>
      <li>Ausweis: '. $besuch['Bezeichnung'] .'</li>
      <li>Anmerkungen nach Besuch: '. $besuchAnmerkung .'</li>
     <li>Anmerkungen nach Person:   '.   $personAnmerkung .'</li>
      </ul>
    ';
  }
}


 ?>
 </ul>
   </body>
 </html>
