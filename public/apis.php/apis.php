<?php

header('Content-Type: application/json; charset=utf-8');

// Verifica se é uma requisição para a API de raposas
if (isset($_GET['fox'])) {
    // API de raposas aleatórias
    $api_url = "https://randomfox.ca/floof/";

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: PHP cURL'
        ],
    ]);

    $response = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($curl_errno) {
        echo json_encode(['error' => 'Erro na requisição cURL: ' . $curl_error]);
        exit;
    }

    if ($http_code < 200 || $http_code >= 300) {
        echo json_encode(['error' => 'Erro HTTP: ' . $http_code, 'response' => $response]);
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

// Recebe o UF via query string, ex: ?uf=SP — padrão SP
$uf = isset($_GET['uf']) ? strtoupper(substr($_GET['uf'], 0, 2)) : 'SP';

// API pública do IBGE que retorna os municípios de um estado
$api_url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios";

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: PHP cURL'
    ],
]);

$response = curl_exec($ch);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($curl_errno) {
    echo json_encode(['error' => 'Erro na requisição cURL: ' . $curl_error]);
    exit;
}

if ($http_code < 200 || $http_code >= 300) {
    echo json_encode(['error' => 'Erro HTTP: ' . $http_code, 'response' => $response]);
    exit;
}

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Erro ao decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

if (!is_array($data)) {
    echo json_encode(['error' => 'Resposta inesperada da API', 'response' => $response]);
    exit;
}

// Saída JSON com a lista de municípios
echo json_encode(['uf' => $uf, 'total' => count($data), 'municipios' => array_column($data, 'nome')]);

?>
