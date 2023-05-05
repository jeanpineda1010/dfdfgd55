<?php
$token = 'TU_TOKEN_DE_TELEGRAM';
$chat_id = '@TU_CANAL_DE_TELEGRAM';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image']['tmp_name'];
    $filename = $_FILES['image']['name'];

    // Carga la biblioteca para interactuar con la API de Telegram
    require 'Telegram.php';
    $telegram = new Telegram($token);

    // Envía la imagen al canal de Telegram
    $response = $telegram->sendPhoto([
      'chat_id' => $chat_id,
      'photo' => curl_file_create($file, 'image/jpeg', $filename),
      'caption' => 'Imagen enviada desde mi página web'
    ]);

    if ($response['ok']) {
      http_response_code(200);
    } else {
      http_response_code(500);
    }
  } else {
    http_response_code(400);
  }
} else {
  http_response_code(405);
}
?>