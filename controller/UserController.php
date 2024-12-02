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
        $this->userModel->login($username, $password);
    }

    public function isLogin(){
        return $this->userModel->isLoggedIn();
    }

    public function logout(){
        $this->userModel->logout();
    }


}