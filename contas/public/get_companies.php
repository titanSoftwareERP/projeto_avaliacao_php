<?php

require_once __DIR__ ."/../controllers/CompanyController.php";

// Chama o controller e define o "endpoint" que retorna as empresas cadastradas
$controller = new CompanyController();
$controller->getCompanies();