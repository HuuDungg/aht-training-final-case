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
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            return true; 
        } else {
            return false; 
        }
    }

    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}
