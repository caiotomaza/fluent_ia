<?php
class api {
    private $apiKey = 'AIzaSyCW3nNw4Moam7nuQU2A8vFMECK8JuZGrKo';
    public function obterResposta($pergunta) {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $this->apiKey;

        $dados = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $pergunta]
                    ]
                ]
            ],
            "generationConfig" => [
                "maxOutputTokens" => 300 // Limita o tamanho da resposta para agilizar
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos

        $resposta = curl_exec($ch);

        if (curl_errno($ch)) {
            $resultado = 'Erro na requisição: ' . curl_error($ch);
        } else {
            $resultadoArray = json_decode($resposta, true);
            if (isset($resultadoArray['candidates'][0]['content']['parts'][0]['text'])) {
                $resultado = $resultadoArray['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $resultado = "Erro na resposta da API.";
            }
        }
        curl_close($ch);
        return $resultado;
    }
}
?>