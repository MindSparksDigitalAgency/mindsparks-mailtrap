<?php

namespace App\config;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Loggers
{
    private static $logger;

    public static function handlerLog()
    {
        if (!isset(self::$logger)) {
            self::$logger = new Logger('app');
            self::$logger->pushHandler(new StreamHandler(__DIR__ . '/app.log', Logger::DEBUG));
        }

        return self::$logger;
    }
}
