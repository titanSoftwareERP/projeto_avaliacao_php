<?php

require_once __DIR__ ."/../controllers/BillsController.php";

// Chama o controller e define o "endpoint" de mudar criar conta a pagar
$controller = new BillsController();
$controller->createBill();