<?php
include("includes/db.php");
require("includes/config.inc.php");
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style media="screen">
.center {
 margin: auto;
 width: 50%;
 border: 2px solid gray;
 padding: 10px;
 margin-bottom: 3rem;
 }
</style>

     <title></title>
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

     <div class="center">
<form class="" method="post">
  <div class="mb-3">
  <label for="film" class="form-label">Filme:</label>
  <?php echo showFilmen(); ?>
</div>
<div class="mb-3">
<input type="submit" class="form-control" value="verkauf anzeigen">
</div>
</form>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Filmtitel</th>
      <th scope="col">Anzahl</th>
      <th scope="col">Kasse</th>
    </tr>
  </thead>
  <tbody>

<?php
if (count($_POST)>0) {
  te($_POST);
  $sql="
  SELECT * FROM tbl_filme
  WHERE(
    tbl_filme.IDFilm = ". $_POST['film']."
    )
  ";
  //te($sql);
  $filmen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);

  // output data of each row
  while($filme = $filmen->fetch_assoc()) {
    $sql="
    SELECT tbl_ticketverkauf.FIDFilm ,tbl_ticketverkauf.FIDKassa ,tbl_ticketverkauf.Anzahl,tbl_kassen.* FROM tbl_ticketverkauf
    INNER JOIN tbl_kassen ON tbl_ticketverkauf.FIDKassa  = tbl_kassen.IDKassa
    WHERE(
      tbl_ticketverkauf.FIDFilm = ". $filme['IDFilm']."
      )
    ";
    $ticketverkaufen = $conn->query($sql)or die("Fehler in der Query:" . $conn->error);

    // output data of each row
    while($ticketverkauf = $ticketverkaufen->fetch_assoc()) {

      echo '
      <tr>
        <td>'. $filme['Filmtitel'].'</td>
        <td>'. $ticketverkauf['Anzahl'].'</td>
        <td>'. $ticketverkauf['Kassanummer'].'</td>
      </tr>
    ';

    }

}

}
 ?>

  </tbody>
</table>
<?php
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
