<?php

require_once 'Database.php';

class User extends Database
{
    public function login(string $username, string $password): bool
    {
        $stmt = $this->conn->prepare(
            'SELECT password FROM users WHERE username = :username'
        );

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false
            && password_verify($password, $user['password']);
    }
}