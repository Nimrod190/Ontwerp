<?php

class Database
{
    protected PDO $conn;

    public function __construct()
    {
        $this->conn = new PDO(
            'mysql:host=localhost;dbname=film_database;charset=utf8mb4',
            'root',
            ''
        );

        $this->conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }
}