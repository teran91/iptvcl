<?php
// Archivo JSON para almacenar los datos
$dataFile = 'data.json';

// Cargar datos existentes
$channels = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Manejar envío de formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $channelName = $_POST['channel_name'] ?? '';
    $channelUrl = $_POST['channel_url'] ?? '';
    $logoUrl = $_POST['logo_url'] ?? '';

    if ($channelName && $channelUrl) {
        // Agregar canal a la lista
        $channels[] = [
            'name' => $channelName,
            'url' => $channelUrl,
            'logo' => $logoUrl
        ];

        // Guardar en el archivo JSON
        file_put_contents($dataFile, json_encode($channels, JSON_PRETTY_PRINT));

        // Generar la lista M3U
        generateM3U($channels);

        echo "<p>Canal agregado con éxito.</p>";
    } else {
        echo "<p>Error: Por favor, completa todos los campos.</p>";
    }
}

// Función para generar la lista M3U
function generateM3U($channels) {
    $m3uContent = "#EXTM3U\n";
    foreach ($channels as $channel) {
        $m3uContent .= "#EXTINF:-1 tvg-logo=\"{$channel['logo']}\",{$channel['name']}\n";
        $m3uContent .= "{$channel['url']}\n";
    }
    file_put_contents('playlist.m3u', $m3uContent);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Canales IPTV</title>
</head>
<body>
    <h1>Agregar Canales IPTV</h1>
    <form method="POST" action="">
        <label for="channel_name">Nombre del Canal:</label><br>
        <input type="text" id="channel_name" name="channel_name" required><br><br>

        <label for="channel_url">URL del Canal:</label><br>
        <input type="url" id="channel_url" name="channel_url" required><br><br>

        <label for="logo_url">URL del Logo (opcional):</label><br>
        <input type="url" id="logo_url" name="logo_url"><br><br>

        <button type="submit">Agregar Canal</button>
    </form>

    <h2>Canales Existentes</h2>
    <ul>
        <?php foreach ($channels as $channel): ?>
            <li><?php echo htmlspecialchars($channel['name']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
