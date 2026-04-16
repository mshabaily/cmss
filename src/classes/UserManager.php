<?php

namespace CMSS;

class UserManager
{

    use Singleton;

    private static function new_user($user, $pdo): int
    {
        $stmt = $pdo->prepare("
                    INSERT INTO cmss_users (email, password_hash, firstname, surname, role, date_added)
                    VALUES (:email, :password_hash, :firstname, :surname, :role, NOW())
                ");

        $stmt->execute([
            ':email' => $user['email'],
            ':firstname' => $user['firstname'],
            ':surname' => $user['surname'],
            ':role' => $user['role'],
            ':password_hash' => $user['password_hash']
        ]);

        return (int) $pdo->lastInsertId();
    }

    private static function update_user($user, $pdo): void
    {
        $stmt = $pdo->prepare("
                    UPDATE cmss_users
                    SET email = :email,
                    firstname = :firstname,
                    surname = :surname,
                    role = :role
                    WHERE user_id = :id
                ");

        $stmt->execute([
            ':email' => $user['email'],
            ':firstname' => $user['firstname'],
            ':surname' => $user['surname'],
            ':role' => $user['role'],
            ':id' => $user['user_id'],
        ]);
    }

    private function update_password($user, $pdo)
    {
        $stmt = $pdo->prepare("
                    UPDATE cmss_users
                    SET password_hash = :password_hash
                    WHERE user_id = :id
                ");

        $stmt->execute([
            ':password_hash' => $user['password_hash'],
            ':id' => $user['user_id']
        ]);
    }

    public function save($user): Response
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();

            if ($user['user_id'] != -1) {
                self::update_user($user, $pdo);
                if ($user['password_hash']) {
                    self::update_password($user, $pdo);
                }
            } else {
                $user['user_id'] = self::new_user($user, $pdo);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            return new Response(500, "Couldn't save user");
        }

        $response = new Response(200, "User save successful");
        $response->data['user_id'] = $user['user_id'];
        return $response;
    }

    public function delete($user): Response
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("
                DELETE FROM cmss_users
                WHERE user_id = :user_id
            ");

            $stmt->execute([
                ':user_id' => $user['id'],
            ]);

            $pdo->commit();

            return new Response(200, "User deleted successfully");
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            Database::getInstance()->error("Couldn't delete user: " . $e->getMessage());
            return new Response(500, "Couldn't delete user");
        }
    }

    public function get_user_id($email)
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $stmt = $pdo->prepare("
                SELECT user_id
                FROM cmss_users
                WHERE email = :email
                LIMIT 1
            ");

            $stmt->execute([
                ':email' => $email,
            ]);

            return $stmt->fetchColumn();
        } catch (\Throwable $e) {
            Database::getInstance()->error("Couldn't find user: " . $e->getMessage());
            return new Response(500, "Couldn't find user");
        }
    }

    public function verify_account($id, $password) : bool
    {
        $user = cmss_user($id);
        return password_verify($password, $user['password_hash']);
    }

    public function generate_reset_hash($id)
    {
        $pdo = Database::getInstance()->pdo();

        $token = bin2hex(random_bytes(32));
        $hash = hash('sha256', $token);

        $expires_at = date('Y-m-d H:i:s', time() + 300);

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                    INSERT INTO cmss_reset_hashes (hash, user_id, expires_at)
                    VALUES (:hash, :user_id, :expires_at)
                ");

            $stmt->execute([
                ':hash' => $hash,
                ':user_id' => $id,
                ':expires_at' => $expires_at
            ]);

            $pdo->commit();
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            return new Response(500, "Couldn't save hash");
        }

        $response = new Response(200, "Hash save successful");
        $response->data['hash'] = $hash;

        return $response;
    }

    public function identify_reset_hash($hash)
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $stmt = $pdo->prepare("
                SELECT *
                FROM cmss_reset_hashes
                WHERE hash = :hash
                LIMIT 1
            ");

            $stmt->execute([
                ':hash' => $hash,
            ]);

            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Database::getInstance()->error("Couldn't find hash: " . $e->getMessage());
            return new Response(400, "Couldn't find hash");
        }

        if ($row['expires_at'] <= time()) {
            return new Response(400, "Hash has expired");
        }

        $response = new Response(200, 'Hash found');
        $response->data['user_id'] = $row['user_id'];

        return $response;
    }
}

?>