<?php
include 'view/header.php';
require_once 'controller/PlanningController.php';

$controller = new PlanningController();
$controller->handleRequest();
include 'view/footer.php';
?>
