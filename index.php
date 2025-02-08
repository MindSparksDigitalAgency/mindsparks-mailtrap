<?php

/**
 * @ORM\PrePersist
 * @author Puji Ermanto<pujiermanto@gmail.com>
 * @return void
 * @since 2.0
 * @expectedException
 */
require_once __DIR__ . '/vendor/autoload.php';

use App\config\{Router, Loggers};


ini_set('display_errors', 1);
error_reporting(E_ALL);


Loggers::handlerLog();
Router::handleRequest();
