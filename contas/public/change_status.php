<?php

require_once __DIR__ ."/../controllers/BillsController.php";

// Chama o controller e define o "endpoint" de mudar status
$controller = new BillsController();
$controller->changeStatus();