<?php
namespace gregoryv\rutt;

/**
 * Implements the part of Middlewares which links them together.
 */
abstract class AbstractMiddleware implements MiddlewareInterface
{

  private $nextMiddleware;

  /**
   * There can only be one next middleware, multiple calls to this method
   * will overwrite previously set middlewares.
   */
  final public function setNext(MiddlewareInterface $next) {
    $this->nextMiddleware = $next;
  }

  /**
   * Calls the next middleware route method if there is one, does nothing
   * otherwise.
   */
  final public function next($method, $uri, &$request,
                             ResponseWriterInterface &$response) {
    if(!empty($this->nextMiddleware)) {
      $this->nextMiddleware->route($method, $uri, $request, $response);
    }
  }

}
