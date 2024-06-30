<?php

require_once __DIR__ ."/../core/Controller.php";
require_once __DIR__ ."/../models/BillsModel.php";

class BillsController extends Controller {

    private $billsModel;

    public function __construct() {
        $this->billsModel = new BillsModel();
    }
    public function createBill(){
        $data = json_decode(file_get_contents('php://input'), true);
        $value = $data['value'];
        $dueDate = $data['date'];
        $companyId = $data['companyId'];

        $response = ['success' => false];

        if ($this->billsModel->createBill($value, $dueDate, $companyId)) {
           $response['success'] = true;
        }

        echo json_encode($response);
    }

    public function getBills(){
        $companyId = isset($_GET['companyId']) ? $_GET['companyId'] : null;
        $value = isset($_GET['value']) ? $_GET['value'] : null;
        $comparison = isset($_GET['comparison']) ? $_GET['comparison'] : null;
        $dueDate = isset($_GET['dueDate']) ? $_GET['dueDate'] : null;

        $bills = $this->billsModel->getBills($companyId, $value, $comparison, $dueDate);
        echo json_encode($bills);
    }
    
    public function updateBill(){
        $data = json_decode(file_get_contents('php://input'), true);
        $billId = $data['billId'];
        $newValue = isset($data['newValue']) ? $data['newValue'] : null;
        $newDate = isset( $data['newDate']) ? $data['newDate'] : null;

        $response = ['success'=> false];

        if($this->billsModel->updateBill($billId, $newValue, $newDate)){
            $response['success'] = true;
        }

        echo json_encode($response);
    }  

    public function deleteBill(){
        $data = json_decode(file_get_contents('php://input'), true);
        $billId = $data['billId'];

        $response = ['success'=> false];
        if($this->billsModel->deleteBill($billId)){
            $response['success'] = true;
        }

        echo json_encode($response);
    }

    public function changeStatus(){
        $data = json_decode(file_get_contents('php://input'), true);
        $billId = $data['billId'];
        $newStatus = $data['newStatus'];

        $response = ['success'=> false];

        if($this->billsModel->changeStatus($billId, $newStatus)){
            $response['success'] = true;
        }
        echo json_encode($response);
    }
}