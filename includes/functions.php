<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-06-06
 * Time: 13:40
 */

/**
 * Auto loads classes
 *
 * @param $class_name
 */
function __autoload($class_name) {
    require_once "classes/" . $class_name . '.php';
}

function setTitle($filePath, $relPath) {
    switch ($filePath) {
        case $relPath . '/account.php':
            $title = 'Account';
            break;
        case $relPath . '/dashboard.php':
            $title = 'Dashboard';
            break;
        case $relPath . '/admin.php':
            $title = 'Admin';
            break;
        case $relPath . '/todos.php':
            $title = 'Taken';
            break;
        default:
            $title = 'Evenementen planner';
            break;
    }

    return $title;
}
