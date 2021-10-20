<?php
//Erzeugen Sie eine weitere Seite (besucherfilter.php), in welcher nach Personen gefiltert werden kann (Screenshot: Besucherfilter.png).
// Erzeugen Sie hierzu ein geeignetes Suchformular (siehe Screenshots), wo nach Vor- und/oder Nachname einer Person gefiltert werden kann.
//  Stellen Sie alsdann alle Besuche dieser Person dar.
include("includes/db.php");
require("includes/config.inc.php");
if (count($_POST)==0) {
  $_POST['vorname']="";
  $_POST['nachname']="";
}
$sqlw="";
if (count($_POST)>0) {
  te($_POST);
  $arr= array();
  if (strlen($_POST['vorname'])>0) {
    $arr[]="tbl_zt_personen.Vorname LIKE '%". $_POST['vorname'] ."%'";
  }
  if (strlen($_POST['nachname'])>0) {
      $arr[]="tbl_zt_personen.Nachname LIKE '%". $_POST['nachname'] ."%'";
    }
    if (count($arr)>0) {
      $sqlw="
         WHERE(
           " . implode(" AND ",$arr) . "
           )
      ";
    }
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
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
           <li><a href="index.php">Erste Seite</a></li>
            <li><a href="besuchliste.php">Besuchliste</a></li>
            <li><a href="personenFilter.php">nach Personen Filtern</a></li>
            <li><a href="datumFilter.php">nach Datum Filtern</a></li>
         </ul>
       </nav>
     </header>
     <div class="center">
     <form class=""  method="post">
       <div class="mb-3">
    <label for="vorname" class="form-label">Voname:</label>
    <input type="text" class="form-control" id="vorname" name="vorname" value="<?php echo ($_POST['vorname']); ?>">
      </div>
      <div class="mb-3">
   <label for="nachname" class="form-label">Nachname:</label>
   <input type="text" class="form-control" id="nachname" name="nachname" value="<?php echo ($_POST['nachname']); ?>">
     </div>
     <div class="mb-3">
  <input type="submit" class="form-control" value="Filtern">
    </div>
    </form>
    </div>
<ul>
    <?php
$sql="
SELECT * FROM tbl_zt_personen
".   $sqlw ."
";
$personen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);
  // output data of each row
  if ($personen->num_rows > 0) {
  while($person = $personen->fetch_assoc()) {
    $sql="
    SELECT tbl_zt_besuche.*,tbl_zt_ausweisarten.* FROM tbl_zt_besuche
    LEFT JOIN tbl_zt_ausweisarten ON tbl_zt_besuche.FIDAusweisart = tbl_zt_ausweisarten.IDAusweisart
    WHERE(
      tbl_zt_besuche.FIDPerson=".$person['IDPerson']."
      )
    ";
    $besuchen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);
  //te($besuchen);
        echo '<li>'. $person['Vorname'] .'  '. $person['Nachname'] .'</li>';
      // output data of each row

      while($besuch = $besuchen->fetch_assoc()) {

        echo '
        <ul>
        <li>'. $besuch['BesuchVon'].' bis '. $besuch['BesuchBis'].' Uhr</li>
        <li>Ausweisart: '. $besuch['Bezeichnung'].'</li>
        <li>Ausweisnummer: '. $besuch['Ausweisnummer'].'</li>
        <li>Ausweis Gültig Bis: '. $besuch['AuswesGultigBis'].'</li>
        <li>Anmerkungen zum Besuch: '. $besuch['Anmerkungen'].'</li><br>
        </ul>
        ';
      }
    }
  }else {
    echo "<p>Für dieser Person gibt es keine Bescuh</p>";
  }


     ?>
     </ul>
   </body>
 </html>
