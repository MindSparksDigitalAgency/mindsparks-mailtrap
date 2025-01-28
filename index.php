<?php

/**
 * @ORM\PrePersist
 * @author Puji Ermanto<pujiermanto@gmail.com>
 * @return void
 * @since 2.0
 * @expectedException
 */

require 'vendor/autoload.php';

use App\Config\Router;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('my_logger');

$logger->pushHandler(new StreamHandler('app.log', Logger::WARNING));

$logger->debug('This is a debug message');
$logger->info('This is an info message');
$logger->warning('This is a warning message');
$logger->error('This is an error message');


Router::handleRequest();
