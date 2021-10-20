<?php
//Erstellen Sie noch ein weiteres Dokument, in welchem ein Zeitraum eingegeben werden kann (von, bis). Geben Sie alle Filme inkl.
// der Summe der verkauften Tickets für diesen Zeitraum aus, wobei die gewählten Dati in den Eingabefeldern erhalten bleiben sollen.
include("includes/db.php");
require("includes/config.inc.php");
  $sqlw="";
  if (count($_POST)== 0) {
    $_POST['von']="";
      $_POST['bis']="";
  }
    if (count($_POST)>0) {
      te($_POST);
      $arr=array();
       if (strlen($_POST['von'])>0) {
         $arr[]="tbl_ticketverkauf.Kaufzeitpunkt >='". $_POST['von'] ."'";
       }
       if (strlen($_POST['bis'])>0) {
        $arr[]="tbl_ticketverkauf.Kaufzeitpunkt <= '". $_POST['bis'] ."'";
       }
       if (count($arr)>0) {
        $sqlw="
          WHERE(
            " . implode(" AND ",$arr) ."
            )
        ";
       }else {
         $sqlw="";
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
     margin-bottom: 3rem;
     margin-top: 3rem;
     }
    </style>


  </head>
  <body>
    <div class="center">
    <form class=""  method="post">
      <div class="mb-3">
      <label for="von" class="form-label">Von</label>
      <input type="date" class="form-control" name="von" id="von" placeholder="Von" value="<?php echo  $_POST['von']; ?>">
    </div>
    <div class="mb-3">
    <label for="bis" class="form-label">Bis</label>
    <input type="date" class="form-control" name="bis" id="bis" placeholder="Bis" value="<?php echo  $_POST['von'];?>">
  </div>
  <div class="mb-3">
  <input type="submit" class="form-control" value="filtern">
</div>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Film</th>
          <th scope="col">verkaut ticket</th>
        </tr>
      </thead>
    <?php


      $sql="
      SELECT tbl_ticketverkauf.FIDFilm ,tbl_ticketverkauf.FIDKassa,(tbl_ticketverkauf.Anzahl) AS summeTicket,tbl_ticketverkauf.Kaufzeitpunkt ,tbl_filme.*,tbl_kassen.* FROM tbl_ticketverkauf
      LEFT JOIN tbl_filme ON tbl_ticketverkauf.FIDFilm = tbl_filme.IDFilm
      LEFT JOIN tbl_kassen ON tbl_ticketverkauf.FIDKassa = tbl_kassen.IDKassa
      ". $sqlw ."
      ";
      //te($sql);
      $tikcetverkaufen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);
    if ($tikcetverkaufen->num_rows > 0) {
      // output data of each row
      while($tikcetverkauf = $tikcetverkaufen->fetch_assoc()) {
        echo '
        <tr>
          <td>'. $tikcetverkauf['Filmtitel'] .'</td>
            <td>'. $tikcetverkauf['summeTicket'] .'</td>
        </tr>
        ';
      }
    }else {
      echo "<p>Für dieser Datum gibt es keine Filme</p>";
    }


     ?>
      <tbody>
      </tbody>
    </table>

    </div>
  </body>
</html>
