<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("./controller/TaskController.php");
include("./controller/UserController.php");


$userController = new UserController();
$taskController = new TaskController();
$act = $_GET["act"] ?? "/";

switch ($act) {
    case "/":
        $userController->loginForm();
        break;
    case "processLogin":
        $userController->login();
        break;
    case "logout":
        $userController->logout();
        break;
    case "list":
        $taskController->display();
        break;
    // case for api
    case "getAll":
        $taskController->getAll();
        break;
    case "delete":
        $taskController->delete();
        break;
    case "create":
        $taskController->create();
        break;
    case "detail":
        $taskController->getById();
        break;
    case "update":
        $taskController->update();
        break;
    default:
        echo "404 - Page not found";
}
