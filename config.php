<?php
// Value for header "Access-Control-Allow-Origin"
define("ACAO", "https://f-imhio.me");

// routes
$allowed_routes = [
    "email/check" => [ "methods" => [ "POST" ] ],
];