<?php

require_once __DIR__ ."/../controllers/BillsController.php";

// Chama o controller e define o "endpoint" de atualizar conta
$controller = new BillsController();
$controller->updateBill();