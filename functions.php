<?php
include 'db_connection.php';

function agregarCanal($nombre, $url, $logo, $conn) {
    $sql = "INSERT INTO canales (nombre, url, logo) VALUES ('$nombre', '$url', '$logo')";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo canal agregado correctamente";
        actualizarM3U($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function actualizarM3U($conn) {
    $sql = "SELECT nombre, url, logo FROM canales";
    $result = $conn->query($sql);

    $m3u = "#EXTM3U\n";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $m3u .= "#EXTINF:-1, tvg-logo=\"" . $row["logo"] . "\", " . $row["nombre"] . "\n" . $row["url"] . "\n";
        }
    }

    file_put_contents("lista.m3u", $m3u);
}
?>
