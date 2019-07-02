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



switch($operation) {
    case 'update_activity':
        $admin->updateActivity($_GET['id'], $_GET['title'], $_GET['description'], $_GET['date'], $_GET['delete-users'], $_GET['add-users']);
        break;
    case 'update_status':
        $admin->updateTodoStatus($_GET['todo_id'], $_GET['activity_id'], $_GET['status']);
        break;
    case 'delete_activity':
        $admin->deleteActivity($_GET['id']);
        break;
    case 'delete_user':
        $admin->deleteUser($_GET['id']);
        break;
    case 'delete_todo':
        $admin->deleteTodo($_GET['id']);
        break;
    case 'add_activity':
        $admin->addActivity($_GET['activity_name'], $_GET['activity_desc'], $_GET['planned_date']);
        break;
    case 'add_todo':
        $admin->addTodo($_GET['todo_name'], $_GET['todo_desc'], $_GET['activity_id'], $_GET['user_id'], $_GET['cat_id']);
        break;
    default:
        echo 'no operation';
        break;
}
