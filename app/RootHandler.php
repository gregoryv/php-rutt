<?php
namespace gregoryv\app;

use gregoryv\rutt;

/**
 *
 */
class RootHandler extends rutt\AbstractMiddleware
{

  private $mux;

  public function __construct() {
    $mux = new rutt\Mux();
    $mux->add('GET', '^$');
    $this->mux = $mux;
  }

  public function route($method, $uri, &$request,
                        rutt\ResponseWriterInterface &$response) {
    try {
      $route = $this->mux->match($method, $uri);
      $response->write(['resources' => ['apples']]);
    } catch(rutt\HttpException $e) {
      $this->next($method, $uri, $request, $response);
    }

  }

}
