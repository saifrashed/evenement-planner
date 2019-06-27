<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-06-06
 * Time: 13:40
 */

include '../classes/admin.php';

$admin = new Admin();

$operation = $_GET['operation'];

echo var_dump($operation);


switch($operation) {
    case 'update_activity':
        $admin->updateActivity($_GET['id'], $_GET['title'], $_GET['description'], $_GET['date']);
        break;
    case 'delete_activity':
        $admin->deleteActivity($_GET['id']);
        break;
    default:
        echo 'no operation';
        break;
}
