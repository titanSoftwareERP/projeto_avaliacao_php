<?php
require_once __DIR__ ."/Database.php";
// Classe Model que todos os Models herdarão
class Model {
    protected $db; // Variável que guardará a instância única da conexão PDO

    // Ao instanciar este tipo de classe, definimos uma instância PDO para a variável anterior
    public function __construct() {
        try {
            $this->db = Database::getInstance();
        } catch (PDOException $e) {
            
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection error.");
        }
    }

    // Método que retorna a instância da conexão PDO usada classe (acabou nem sendo usada)
    protected function getDb() {
        return $this->db;
    }
}