<?php

require_once __DIR__ ."/../core/Model.php";

// Model de empresas, concentra as funções relacionadas às empresas
class CompanyModel extends Model {

    // Método que pega todas as empresas cadastradas
    public function getAllCompanies(){
        $stmt = $this->db->query("SELECT * from tbl_empresa"); // Prepara e executa uma query que não contém parâmetros
        return $stmt->fetchAll(); // Retorna todas as empresas em um array
    }
}