<?php

class User
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all(): array
    {
        try {
            $sql = "SELECT * FROM users ORDER BY id DESC";

            return $this->db->query($sql)->fetchAll();
        } catch (Exception $e) {
            Helper::log('User::all - ' . $e->getMessage());
            return [];
        }
    }

    public function find(int $id): object|false
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            Helper::log('User::find - ' . $e->getMessage());
            return false;
        }
    }

    public function findByUsername(string $username): object|false
    {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['username' => $username]);

            return $stmt->fetch();
        } catch (Exception $e) {
            Helper::log('User::findByUsername - ' . $e->getMessage());
            return false;
        }
    }

    public function create(
        string $username,
        string $password,
        string $role
    ): bool
    {
        try {
            $sql = "
                INSERT INTO users (username, password, role)
                VALUES (:username, :password, :role)
            ";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role
            ]);
        } catch (Exception $e) {
            Helper::log('User::create - ' . $e->getMessage());
            return false;
        }
    }

    public function update(
        int $id,
        string $username,
        string $password,
        string $role
    ): bool
    {
        try {
            if (!empty($password)) {
                $sql = "
                    UPDATE users
                    SET username = :username,
                        password = :password,
                        role = :role
                    WHERE id = :id
                ";

                $params = [
                    'id' => $id,
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role
                ];
            } else {
                $sql = "
                    UPDATE users
                    SET username = :username,
                        role = :role
                    WHERE id = :id
                ";

                $params = [
                    'id' => $id,
                    'username' => $username,
                    'role' => $role
                ];
            }

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);

        } catch (Exception $e) {
            Helper::log('User::update - ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);

        } catch (Exception $e) {
            Helper::log('User::delete - ' . $e->getMessage());
            return false;
        }
    }
}
