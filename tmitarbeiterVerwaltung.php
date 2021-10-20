<?php
include("includes/db.php");
require("includes/config.inc.php");
$msg="";
if (count($_POST)>0) {
  switch ($_POST['wasTun']) {
    case 'speichern':

    $sql = "
    INSERT INTO tbl_mitarbeiter (Vorname, Nachname, MANummer)
    VALUES (
      '". $_POST['Vorname']."',
      '". $_POST['Nachname']."',
    '". $_POST['MANummer']."'
       )";

    if ($conn->query($sql) === TRUE) {
      $msg= "<p>Ihre Datensatz ist erfolgreich eingetragen</p>";
    } else {
      $msg= "<p>Ihre Datensatz konnte leider nicht  erfolgreich eingetragen werden</p>";
    }      break;

    case 'aktualsiern':
    $id=$_POST['welcheID'];

    $sql = "
    UPDATE tbl_mitarbeiter SET
     Vorname='". $_POST['Vorname_' . $id]."',
     Nachname='". $_POST['Nachname_' . $id]."',
     MANummer='". $_POST['MANummer_' . $id]."'
     WHERE(
       IDMitarbeiter= ". $id ."
       ) ";

  if ($conn->query($sql) === TRUE) {
    $msg='<p>Ihre Datensatz ist erfolgreich aktualisiert</p>';
  } else {
    $msg='<p>Ihre Datensatz konnte leider nicht erfolgreich einfügt werden</p>';
  }

  break;

  case 'loeschen':
  $id=$_POST['welcheID'];
  $sql = "
  DELETE FROM tbl_mitarbeiter
   WHERE(
     IDMitarbeiter=".   $id ."
     )
";

if ($conn->query($sql) === TRUE) {
  $msg='<p>Ihre Datensatz ist erfolgreich gelöscht.</p>';
} else {
  $msg='<p>Ihre Datensatz konnte leider nicht erfolgreich gelöscht werden.</p>';
}

    // code...
    break;
    default:
      // code...
      break;
  }
}
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Mitarbeiter</title>
    <script type="text/javascript">
      function speichern(){
        document.getElementById("wasTun").value="speichern";
        document.getElementById("frm").submit();
      }

      function aktualsiern(aktualsiernID){
        document.getElementById("wasTun").value="aktualsiern";
        document.getElementById("welcheID").value=aktualsiernID;
        document.getElementById("frm").submit();
      }

      function loschen(loschendeID){
        if (confirm("Wollen Sie wirklich der Eintrag löschen?")) {
          document.getElementById("wasTun").value="loeschen";
          document.getElementById("welcheID").value=loschendeID;
          document.getElementById("frm").submit();
        }
      }
    </script>
  </head>
  <body>
    <?php
    echo ($msg);

     ?>
    <form id="frm"  method="post">
      <input type="hidden" name="wasTun" id="wasTun" value="">
      <input type="hidden" name="welcheID" id="welcheID" value="">

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">IDMitarbeiter</th>
      <th scope="col">Vorname</th>
      <th scope="col">Nachname</th>
      <th scope="col">MANummer</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
    <tr>
      <td></td>
      <td scope="col"><input type="text" name="Vorname" value=""></td>
      <td scope="col"><input type="text" name="Nachname" value=""></td>
      <td scope="col"><input type="text" name="MANummer" value=""></td>
      <td> <button type="button" onclick="speichern();" name="button">INS</button></td>
    <td scope="col"></td>
    </tr>
  </thead>
  <tbody>

  <?php
$sql="

SELECT * FROM tbl_mitarbeiter
";
$mitarbeiter = $conn->query($sql);

if ($mitarbeiter->num_rows > 0) {
  // output data of each row
  while($mitarbeit = $mitarbeiter->fetch_assoc()) {
    echo'
    <tr>
      <td>'.$mitarbeit['IDMitarbeiter'].'</td>
      <td><input type="text" value="'.$mitarbeit['Vorname'].'" name="Vorname_'.$mitarbeit['IDMitarbeiter'].'"></td>
      <td><input type="type" value="'.$mitarbeit['Nachname'].'" name="Nachname_'.$mitarbeit['IDMitarbeiter'].'"></td>
      <td><input type="number" value="'.$mitarbeit['MANummer'].'" name="MANummer_'.$mitarbeit['IDMitarbeiter'].'"></td>
      <td><button type="button" onclick="aktualsiern('.$mitarbeit['IDMitarbeiter'].');">UPDATE</button></td>
      <td> <button type="button" onclick="loschen('.$mitarbeit['IDMitarbeiter'].');">DELETE</button></td>
    </tr>
    ';
  }
}

   ?>


  </tbody>
  </table>
  </form>
  </body>
</html>
