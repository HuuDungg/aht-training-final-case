<?php
include("./model/user.php");
class UserController
{
    private $userModel;
    public function __construct() {
        $this->userModel = new User($this->connectDatabase());
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

    public function login(){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $result = $this->userModel->login($username, $password);
        if($result){
            header("Location: http://localhost/aht-training/final-case/?act=list");
        }else{
            header("Location: http://localhost/aht-training/final-case/");
        }
    }

    public function logout(){
        $this->userModel->logout();
    }

    public function loginForm(){
        require("./view/user/login.php");
    }


}