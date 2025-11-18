<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Verifica se é uma requisição para a API de raposas
if (isset($_GET['fox'])) {
    // API de raposas aleatórias
    $api_url = "https://randomfox.ca/floof.json";

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Accept: application/json\r\nUser-Agent: PHP\r\n',
            'timeout' => 10
        ]
    ]);

    $response = file_get_contents($api_url, false, $context);

    if ($response === false) {
        echo json_encode(['error' => 'Erro na requisição HTTP']);
        exit;
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Erro ao decodificar JSON: ' . json_last_error_msg()]);
        exit;
    }

    echo json_encode($data);
    exit;
}





?>
