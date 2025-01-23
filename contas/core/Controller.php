<?php
// Classe base que todos os Controllers terão herança
class Controller {
    // Método que transforma os dados retornados pelos metodos do Model em json, atribui um código de status à resposta e envia a resposta
    protected function jsonResponse($data, $statusCode = 200) {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }
}