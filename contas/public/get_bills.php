<?php

require_once __DIR__ ."/../controllers/BillsController.php";

// Chama o controller e define o "endpoint" que retorna as contas
$controller = new BillsController();
$controller->getBills();