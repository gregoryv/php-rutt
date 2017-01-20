<?php
namespace gregoryv\rutt;

/**
 * Echoes a given string, useful for testing
 */
class NoopMiddleware extends AbstractMiddleware
{
  public $called;

  /**
   */
  public function __construct() {
    $this->called = false;
  }

  public function route($method, $uri, &$request,
                        ResponseWriterInterface &$response) {
    $this->called = true;
    $this->next($method, $uri, $request, $response);
  }

}
