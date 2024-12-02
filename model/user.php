<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM Users WHERE username = ? AND password = ?
        ");
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true; 
        } else {
            return false; 
        }
    }


    public function logout() {
        session_unset();
        session_destroy();
        header("Location: http://localhost/aht-training/final-case/");
    }
}
