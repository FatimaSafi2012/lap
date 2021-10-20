<?php
include("includes/db.php");
require("includes/config.inc.php");
if (count($_POST)==0) {
  $_POST['von']="";
  $_POST['bis']="";
}
$sqlw="";
if (count($_POST)>0) {
  te($_POST);
  $arr=array();
  if (strlen($_POST['von'])>0) {
    $arr[]="tbl_zt_besuche.BesuchVon >='".$_POST['von']."'";
  }
  if (strlen($_POST['bis'])>0) {
    $arr[]="tbl_zt_besuche.BesuchBis <='".$_POST['bis']."'";
  }
  if (count($arr)>0) {
    $sqlw="
    WHERE(" .  implode(" AND ",$arr). ")
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
<form class="" method="post">
    <div class="mb-3">
    <label for="von" class="form-label">Von:</label>
    <input type="date" class="form-control" id="von" name="von" value="<?php echo ($_POST['von']); ?>">
    </div>
    <div class="mb-3">
    <label for="bis" class="form-label">Bis:</label>
    <input type="date" class="form-control" id="bis" name="bis" value="<?php echo ($_POST['bis']); ?>">
    </div>
    <div class="mb-3">
    <input type="submit" class="form-control" value="filtern">
    </div>
</form>
     </div>
     <ul>
<?php
$sql="
SELECT tbl_zt_besuche.*,tbl_zt_personen.*,tbl_zt_ausweisarten.* FROM tbl_zt_besuche
INNER JOIN tbl_zt_personen ON tbl_zt_besuche.FIDPerson = tbl_zt_personen.IDPerson
LEFT JOIN tbl_zt_ausweisarten ON tbl_zt_besuche.FIDAusweisart = tbl_zt_ausweisarten.IDAusweisart
". $sqlw ."
";
$besuchen = $conn->query($sql) or die("Fehler in der Query:" . $conn->error);

if ($besuchen->num_rows > 0) {
  // output data of each row
  while($besuch = $besuchen->fetch_assoc()) {
    echo '
    <li>'. $besuch['Vorname'] .'  '. $besuch['Nachname'] .'</li>
    <ul>
    <li>'. $besuch['BesuchVon'] .'  '. $besuch['BesuchBis'] .'Uhr</li>
    <li>'. $besuch['Bezeichnung'] .' </li>
    <li>Ausweisnummer: '. $besuch['Ausweisnummer'] .' </li>
    <li>AuswesGultigBis: '. $besuch['AuswesGultigBis'] .' </li>
    <li>Anmerkungen zum Bescuh: '. $besuch['Anmerkungen'] .' </li>


    </ul>
    ';
  }
} else {
  echo "Es wurde für diesr Datum keine Bescuh gefunden";
}

 ?>
     </ul>
   </body>
 </html>
