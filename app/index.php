<?php
/**
 * Example application serving only json
 */
require_once __DIR__ . '/../vendor/autoload.php';

use gregoryv\rutt;
use gregoryv\app;

// This application only serves JSON
$writer = new rutt\JSONWriter();

try {
  // Lets make sure the client understands JSON
  $writer->accepts($_SERVER['HTTP_ACCEPT']);

  // Define all middlewares the router should use
  $router = new rutt\Router();
  $mux = new rutt\Mux();
  $mux->add('GET', '\/(apples)\/', 'gregoryv\app\ApplesHandler');
  $router->append( new rutt\CRUDMiddleware($mux) );

  // Route the request
  $method = $_SERVER['REQUEST_METHOD'];
  $uri    = $_SERVER['REQUEST_URI'];
  $router->route($method, $uri, $_REQUEST, $writer);

} catch(rutt\HttpException $e) {

  $msg = sprintf('%d %s', $e->getCode(), $e->getMessage());
  header(sprintf('HTTP/1.0 %s', $msg));
  // Writing plain text response
  echo $msg;

}
