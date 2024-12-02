<?php
session_start();
include("./model/task.php");

class TaskController
{
    private $taskModel;
    private $user_id;

    public function __construct() {
        $this->user_id = $_SESSION["user_id"] ?? null; 
        $this->taskModel = new Task($this->connectDatabase(), $this->user_id);
    }

    private function connectDatabase() {
        $username = "root";
        $password = "12345678";
        $port = 3306;
        $dbname = "aht";
        try {
            $pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function display(){
        require("./view/task/list.php");
    }

    public function getAll(){
        $tasks = $this->taskModel->getAll();
        echo json_encode($tasks );
    }

    public function create(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $status = 0;
            $content = $_POST['content'];
            $priority = $_POST['priority'];
            $this->taskModel->create($title,  $status, $content, $priority);
        }
    }

    public function delete(){
        $id = $_GET["id"];
        $this->taskModel->delete($id);
    }

    public function getById() {
        $id = $_GET['id'];
        $task = $this->taskModel->getById($id);
        echo json_encode($task);
    }

    public function update() {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $status = $_POST['status'];
    $content = $_POST['content'];
    $priority = $_POST['priority'];

    $this->taskModel->update($id, $title, $status, $content, $priority);
    
    echo json_encode(['message' => 'Task updated successfully!']);
}
}
?>
