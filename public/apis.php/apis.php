<?php

$api_url = 'https://seu-dominio.com/api/estados/SP/cidades'; 

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json' 
));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "Erro na requisição cURL: " . $error_msg;
} else {

    $data = json_decode($response, true); 

    if (json_last_error() === JSON_ERROR_NONE && isset($data['state']) && isset($data['cities'])) {
        
        echo "## ✨ Dados Recebidos da API ✨\n\n";
        echo "Estado: **" . $data['state'] . "**\n";
        echo "Cidades encontradas: **" . count($data['cities']) . "**\n\n";
        echo "### 🏙️ Lista de Cidades:\n";
        
        echo "<ul>";
        foreach ($data['cities'] as $city) {
            echo "<li>" . $city . "</li>";
        }
        echo "</ul>";
        

    } else {
        echo "## ❌ Erro ao processar a resposta da API\n";
        echo "Resposta bruta (pode não ser JSON válido):\n";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
        echo "Erro de decodificação JSON: " . json_last_error_msg() . "\n";
    }
}

curl_close($ch);

?>