<?php

header('Content-Type: text/html; charset=utf-8');

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
    echo "<h2>Erro na requisição cURL</h2>";
    echo "<p>" . htmlspecialchars($curl_error, ENT_QUOTES, 'UTF-8') . "</p>";
    exit;
}

if ($http_code < 200 || $http_code >= 300) {
    echo "<h2>Erro HTTP: " . intval($http_code) . "</h2>";
    echo "<pre>" . htmlspecialchars($response, ENT_QUOTES, 'UTF-8') . "</pre>";
    exit;
}

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<h2>Erro ao decodificar JSON</h2>";
    echo "<pre>" . htmlspecialchars(json_last_error_msg(), ENT_QUOTES, 'UTF-8') . "</pre>";
    exit;
}

if (!is_array($data)) {
    echo "<h2>Resposta inesperada da API</h2>";
    echo "<pre>" . htmlspecialchars($response, ENT_QUOTES, 'UTF-8') . "</pre>";
    exit;
}

// Saída HTML segura com a lista de municípios
echo "<!doctype html><html><head><meta charset='utf-8'><title>Municípios - {$uf}</title></head><body>";
echo "<h1>Municípios do estado {$uf}</h1>";
echo "<p>Total: " . count($data) . "</p>";
echo "<ul>";
foreach ($data as $city) {
    $name = isset($city['nome']) ? $city['nome'] : (is_string($city) ? $city : json_encode($city));
    echo "<li>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</li>";
}
echo "</ul>";
echo "</body></html>";

?>