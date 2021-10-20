<?php
//Erstellen Sie alsdann eine Seite, in der - chronologisch nach dem Erscheinungsdatum - alle Filme aufgelistet sind und geben
// Sie sämtliche Daten zum Film aus (Titel, Beschreibung, Regisseur, Darsteller, Länge in Minuten, Genre, Erscheinungsjahr,
// eigene Bewertung, etc. - siehe Filmeverwaltung_0.png und Filmeverwaltung_1.png). Ordnen Sie die Filme nach dem Titel aufsteigend.
include("includes/db.php");
require("includes/config.inc.php");
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <title></title>
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
     <h3>filmverwaltung</h3>
    <ol>
     <?php
     $sql = "
     SELECT tbl_fv_filme.*,tbl_fv_genres.IDGenre ,tbl_fv_genres.Bezeichnung,tbl_fv_personen.* FROM tbl_fv_filme
     LEFT JOIN tbl_fv_genres ON tbl_fv_filme.FIDGenre  = tbl_fv_genres.IDGenre
     INNER JOIN tbl_fv_personen ON tbl_fv_filme.FIDRegisseur  = tbl_fv_personen.IDPerson
     ORDER BY tbl_fv_filme.Titel ASC
     ";
     $filmen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);

     if ($filmen->num_rows > 0) {
       // output data of each row
       while($film = $filmen->fetch_assoc()) {
         echo '
          <li>'. $film ['Titel'].'</li>
          <ul>
          <li>'. $film ['Beschreibung'].'</li>
          <li>Regisseur: '. $film ['Nachname'].' '. $film ['Vorname'].'</li>
           <li>Dauer: '. $film ['Dauer'].'</li>
           <li>Erscheinungsjahr: '. $film ['Erscheinungsjahr'].'</li>
            <li>Genre: '. $film ['Bezeichnung'].'</li>
           <li>Eingene Bewertung: '. $film ['Bewertung'].' Stern</li>
             <li>zuletzt angesehen: '. $film ['zuletztangesehen'].' Uhr</li>   </ul>Darschlern:

         ';
         $sql="
         SELECT tbl_filme_darsteller.* , tbl_fv_personen.* FROM tbl_filme_darsteller
         LEFT JOIN tbl_fv_personen ON tbl_filme_darsteller.FIDDarsteller = tbl_fv_personen.IDPerson
         WHERE(
           tbl_filme_darsteller.FIDFilm = ". $film['IDFilm']."
           )
         ";
         //te($sql);
         $darstellern = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);
         while($darsteller = $darstellern->fetch_assoc()) {
           echo '
           <ul>
               <li> '. $darsteller ['Nachname'].' '. $darsteller ['Vorname'].'</li>
          </ul>
           ';


         }
            echo "<br>";
       }
     }


      ?>
      </ol><br>
   </body>
 </html>
