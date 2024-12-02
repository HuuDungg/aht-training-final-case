<?php

class Task {
    private $pdo;
    private $userId;

    public function __construct($pdo, $userId) {
        $this->pdo = $pdo;
        $this->userId = $userId;
    }

    public function create($title, $status, $content, $priority) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Tasks (title, status, content, priority, user_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$title, $status, $content, $priority, $this->userId]);
    }

    public function getAll() {
        $stmt = $this->pdo->prepare("
            SELECT * FROM Tasks WHERE user_id = ?
        ");
        $stmt->execute([$this->userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM Tasks WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$id, $this->userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $status, $content, $priority) {
        $stmt = $this->pdo->prepare("
            UPDATE Tasks 
            SET title = ?, status = ?, content = ?, priority = ? 
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$title, $status, $content, $priority, $id, $this->userId]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("
            DELETE FROM Tasks WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$id, $this->userId]);
    }
}
