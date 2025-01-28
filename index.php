<?php

/**
 * @ORM\PrePersist
 * @author Puji Ermanto<pujiermanto@gmail.com>
 * @return void
 * @since 2.0
 * @expectedException
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\config\Router;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


$logger = new Logger('my_logger');

$logger->pushHandler(new StreamHandler('app.log', Logger::WARNING));

$logger->debug('This is a debug message');
$logger->info('This is an info message');
$logger->warning('This is a warning message');
$logger->error('This is an error message');


Router::handleRequest();
