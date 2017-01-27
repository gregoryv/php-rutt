<?php
// Example application using the gregoryv\rutt router
require_once __DIR__ . '/../vendor/autoload.php';

use gregoryv\rutt;
use gregoryv\app;

// This application only serves JSON
$writer = new rutt\JSONWriter();

try {
  // Lets make sure the client understands JSON
  $writer->accepts($_SERVER['HTTP_ACCEPT']);
} catch(rutt\HttpException $e) {

  $msg = sprintf('%d %s', $e->getCode(), $e->getMessage());
  header(sprintf('HTTP/1.0 %s', $msg));
  // Writing plain text response
  echo $msg;
  exit;
}


// Define all middlewares the router should use
$router = new rutt\Router();
$router->append(new app\RootHandler());
$factory = new app\HandlerFactory();
$router->append(new rutt\CRUDMiddleware($factory));

// Route the request
$method = $_SERVER['REQUEST_METHOD'];
$uri    = $_SERVER['REQUEST_URI'];
$router->route($method, $uri, $_REQUEST, $writer);
