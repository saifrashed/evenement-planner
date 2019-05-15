<?php
require_once 'model/DataHandler.php';

class PlanningLogic {

    public function __construct() {
        $this->DataHandler = new Datahandler("localhost", "mysql", "stardunks", "root", "Rashed112");
    }

}

?>
