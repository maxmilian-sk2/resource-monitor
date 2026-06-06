<?php

class Endpoint
{
    private PDO $db;

    public const TYPES = [
        'disk' => 'Disk Usage',
        'cpu' => 'CPU Usage',
        'ram' => 'RAM Usage',
        'docker_containers' => 'Docker Containers',
        'docker_networks' => 'Docker Networks',
        'docker_volumes' => 'Docker Volumes',
    ];

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all(int $userId): array
    {
        try {
            $sql = "SELECT * FROM endpoints WHERE user_id = :user_id ORDER BY id DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            Helper::log('Endpoint::all - ' . $e->getMessage());
            return [];
        }
    }

    public function find(int $id, int $userId): object|false
    {
        try {
            $sql = "SELECT * FROM endpoints WHERE id = :id AND user_id = :user_id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id, 'user_id' => $userId]);

            return $stmt->fetch();
        } catch (Exception $e) {
            Helper::log('Endpoint::find - ' . $e->getMessage());
            return false;
        }
    }

    public function create(
        int $userId,
        string $name,
        string $host,
        string $type,
        string $api_token
    ): bool
    {
        try {
            $sql = "
                INSERT INTO endpoints (user_id, name, host, type, api_token)
                VALUES (:user_id, :name, :host, :type, :api_token)
            ";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                'user_id' => $userId,
                'name' => $name,
                'host' => $host,
                'type' => $type,
                'api_token' => $api_token
            ]);
        } catch (Exception $e) {
            Helper::log('Endpoint::create - ' . $e->getMessage());
            return false;
        }
    }

    public function update(
        int $id,
        int $userId,
        string $name,
        string $host,
        string $type,
        string $api_token
    ): bool
    {
        try {
            $sql = "
                UPDATE endpoints
                SET name = :name,
                    host = :host,
                    type = :type,
                    api_token = :api_token
                WHERE id = :id AND user_id = :user_id
            ";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'user_id' => $userId,
                'name' => $name,
                'host' => $host,
                'type' => $type,
                'api_token' => $api_token
            ]);

        } catch (Exception $e) {
            Helper::log('Endpoint::update - ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id, int $userId): bool
    {
        try {
            $sql = "DELETE FROM endpoints WHERE id = :id AND user_id = :user_id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id, 'user_id' => $userId]);

        } catch (Exception $e) {
            Helper::log('Endpoint::delete - ' . $e->getMessage());
            return false;
        }
    }
}
