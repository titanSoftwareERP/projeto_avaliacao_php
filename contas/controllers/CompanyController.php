<?php

require_once __DIR__ ."/../core/Controller.php";
require_once __DIR__ ."/../models/CompanyModel.php";

class CompanyController extends Controller {
    private $companyModel;

    public function __construct() {
        $this->companyModel = new CompanyModel();
    }

    public function getCompanies(){
        $companies = $this->companyModel->getAllCompanies();
        echo json_encode($companies);
    }
}