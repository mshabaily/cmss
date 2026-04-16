<?php

namespace CMSS;

class Database
{

    use Singleton, HasLogger;

    private static ?\PDO $pdo = null;

    protected function __construct()
    {
        self::load_logger('database');

        if (file_exists(ROOT_PATH . '/.env')) {
            self::init();
        }
    }

    public static function init()
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $_ENV['DB_HOST'],
            $_ENV['DB_NAME'],
            $_ENV['DB_CHARSET']
        );

        self::$pdo = new \PDO(
            $dsn,
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]
        );
    }

    public static function write_to_env(string $key, string $value)
    {
        $env_path = ROOT_PATH . '/.env';

        $lines = file_exists($env_path)
            ? file($env_path, FILE_IGNORE_NEW_LINES)
            : [];

        $found = false;

        foreach ($lines as &$line) {
            if (strpos($line, $key . '=') === 0) {
                $line = $key . '="' . addslashes($value) . '"';
                $found = true;
                break;
            }
        }

        if (!$found) {
            $lines[] = $key . '="' . addslashes($value) . '"';
        }

        $result = file_put_contents($env_path, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX);

        if ($result === false) {
            return new Response(500, 'Could not write to .env file');
        }
    }

    public static function install(string $host, string $name, string $username, string $password)
    {

        $env_path = ROOT_PATH . '/.env';

        try {
            if (!file_exists($env_path)) {
                if (file_put_contents($env_path, '') === false) {
                    return new Response(500, 'Could not create .env file');
                }
            }

            self::write_to_env('DB_HOST', $host);
            self::write_to_env('DB_NAME', $name);
            self::write_to_env('DB_USER', $username);
            self::write_to_env('DB_PASS', $password);
            self::write_to_env('DB_CHARSET', "utf8mb4");

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $host,
                $name,
                "utf8mb4"
            );

            self::$pdo = new \PDO(
                $dsn,
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            );

            $schema = file_get_contents(ROOT_PATH . '/src/sql/setup.sql');

            if ($schema === false) {
                return new Response(500, 'Could not read schema.sql');
            }

            self::$pdo->exec($schema);

            return new Response(200, "Database tables established");
        } catch (\Exception $e) {
            return new Response(500, "Error establishing database tables");
        }
    }

    public static function handle_error($pdo, $e): void
    {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        self::getInstance()->error("Couldn't save record: " . $e->getMessage());
    }

    public function pdo(): \PDO
    {
        if (!self::$pdo) {
            throw new \Exception("Database not initialized");
        }
        return self::$pdo;
    }
}
