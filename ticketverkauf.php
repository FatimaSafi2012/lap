<?php
//Erstellen Sie eine Seite, in der Sie auswählen können, an welcher Kassa wieviele Tickets eines bestimmten Filmes verkauft.
// Bitte beachten Sie, dass nur Tickets für Filme zum Verkauf stehen sollen, die auch aktuell gezeigt werden.
// Speichern Sie den Verkauf in die Datenbank.
include("includes/db.php");
require("includes/config.inc.php");
function InsertInDb(){
  global $conn;
  if (count($_POST)>0) {
    te($_POST);
    $sql = "
    INSERT INTO tbl_ticketverkauf(FIDFilm, FIDKassa, Anzahl)
  VALUES (
    '".$_POST['film']."',
  '".$_POST['kasse']."',
  '".$_POST['anzahl']."'
      )
  ";
  if ($conn->query($sql) === TRUE) {
    echo "<p>Ihre Datensatz ist erfolgreich in datenbank eingetragen</p>";
  } else {
    echo "<p>Ihre Datensatz ist erfolgreich in datenbank eingetragen</p>" . $sql . "<br>" . $conn->error;
  }
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
     }
    </style>

  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="index.php">Start Seite</a></li>
          <li><a href="ticketverkauf.php">Ticketverkauf</a></li>
          <li><a href="ticketverkaufPreKasse.php">Ticketverkauf Ja Kasse</a></li>
          <li><a href="index.php"></a></li>
        </ul>
      </nav>
    </header>
<h3>Ticketverkauf</h3>
<div class="center">
<form class=""  method="post">
  <div class="mb-3">
    <label for="kasse" class="form-label">Kasse: </label>
  <?php echo showticket(); ?>
</div>
<div class="mb-3">
  <label for="film" class="form-label">Film:</label>
  <?php echo showFilmen(); ?>
</div>
<div class="mb-3">
  <label for="anzahl" class="form-label">Anzahl:</label>
  <input type="number" min="1" max="9999" class="form-control" id="anzahl" name="anzahl" >
</div>
<div class="mb-3">
  <input type="submit" class="form-control" value="verkauf">
</div>
</form>
<?php echo InsertInDb(); ?>


<table class="table">
  <thead>
    <tr>
      <th scope="col">Kasse:</th>
      <th scope="col">Filme</th>
      <th scope="col">Anzahl</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql="
    SELECT tbl_ticketverkauf.*,tbl_filme.*,tbl_kassen.* FROM tbl_ticketverkauf
    LEFT JOIN tbl_filme ON tbl_ticketverkauf.FIDFilm = tbl_filme.IDFilm
    LEFT JOIN tbl_kassen ON tbl_ticketverkauf.FIDKassa = tbl_kassen.IDKassa
    ";
    $ticketverkaufen = $conn->query($sql)or die("fehler in der Query;" . $conn->error);

    if ($ticketverkaufen->num_rows > 0) {
      // output data of each row
      while($ticketverkauf = $ticketverkaufen->fetch_assoc()) {
        echo '
        <tr>
        <td>'. $ticketverkauf['Kassanummer'].'</td>
        <td>'. $ticketverkauf['Filmtitel'].'</td>
        <td>'. $ticketverkauf['Anzahl'].'</td>
        </tr>
        ';
      }
    }
     ?>

  </tbody>
</table>

</div>

<?php
function showticket(){
  global $conn;
  $r='<select class="form-select" name="kasse" id="kasse"><option selected>-</option>';
  $sql="
  SELECT * FROM tbl_kassen
  ";
  $kassen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);

if ($kassen->num_rows > 0) {
  // output data of each row
  while($kasse = $kassen->fetch_assoc()) {
    $r.='
    <option value='. $kasse['IDKassa'] .'>'. $kasse['Kassanummer'] .'</option>
  ';
  }
}
$r.='</select>';
return $r;

}

function showFilmen(){
  global $conn;
  $r='<select class="form-select" name="film" id="film"><option selected>-</option>';
  $sql="
  SELECT * FROM tbl_filme
  ";
  $filmen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);

if ($filmen->num_rows > 0) {
  // output data of each row
  while($filme = $filmen->fetch_assoc()) {
    $r.='
    <option value='. $filme['IDFilm'] .'>'. $filme['Filmtitel'] .'</option>
  ';
  }
}
$r.='</select>';
return $r;

}


 ?>
  </body>
</html>
