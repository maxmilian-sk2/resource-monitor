<?php

class Database
{
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;

    private PDO $connection;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'db';
        $this->dbname = getenv('DB_NAME') ?: 'resmon';
        $this->username = getenv('DB_USER') ?: 'resmon';
        $this->password = getenv('DB_PASS') ?: 'resmon';

        $this->connect();
    }

    private function connect(): void
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        $this->connection = new PDO($dsn, $this->username, $this->password);

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
