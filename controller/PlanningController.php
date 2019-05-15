<?php
require 'model/PlanningLogic.php';

class PlanningController {
    public function __construct() {
        $this->PlanningLogic = new PlanningLogic();
    }

    public function __destruct() {
    }

    public function handleRequest() {
        try {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
            switch ($action) {
                case 'create':
                    $this->collectCreateProduct();
                    break;
                case 'read':
                    $this->collectReadProduct();
                    break;
                case 'update':
                    $this->collectUpdateProduct();
                    break;
                case 'delete':
                    $this->collectDeleteProduct();
                    break;
                default:
                    $this->collectHome();
                    break;
            }
        } catch (ValidationException $e) {
            $errors = $e->getErrors();
            return $errors;
        }
    }


    public function collectHome() {
        include 'view/home.php';
    }
}


?>
