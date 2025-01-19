<!DOCTYPE html>
<html>
<body>

<h2>Agregar Canal IPTV</h2>
<form method="post">
  Nombre del Canal:<br>
  <input type="text" name="nombre">
  <br>
  URL del Canal:<br>
  <input type="text" name="url">
  <br>
  Logo del Canal (URL):<br>
  <input type="text" name="logo">
  <br><br>
  <input type="submit" name="submit" value="Agregar Canal">
</form> 

<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $url = $_POST["url"];
    $logo = $_POST["logo"];
    agregarCanal($nombre, $url, $logo, $conn);
}
?>

</body>
</html>
