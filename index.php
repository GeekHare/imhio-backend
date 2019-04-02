<?php
use Api\ApiEngine;

// Require config
require_once __DIR__ . "/config.php";

// Require composer
require_once __DIR__ . "/vendor/autoload.php";

// Init API
$ApiEngine = new ApiEngine(
    $_SERVER["REQUEST_URI"],
    $_SERVER["REQUEST_METHOD"],
    file_get_contents("php://input"),
    $allowed_routes
);
$ApiEngine->run();
