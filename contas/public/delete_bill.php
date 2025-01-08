<?php

require_once __DIR__ ."/../controllers/BillsController.php";

// Chama o controller e define o "endpoint" de eletar conta a pagar
$controller = new BillsController();
$controller->deleteBill();