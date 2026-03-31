<?php

namespace CMSS;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

trait HasLogger {
    public static Logger $logger;

    protected function load_logger($name): void
    {
        $logDir = ROOT_PATH . '/logs';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        self::$logger = new Logger(self::class);
        self::$logger->pushHandler(new StreamHandler($logDir . '/' . $name . '.log', Logger::DEBUG));
    }

    public function error($str): void
    {
        self::$logger->error($str);
    }

    public function log($str): void
    {
        self::$logger->info($str);
    }
}