<?php
namespace gregoryv\rutt;

/**
 *
 */
abstract class AbstractMiddleware implements MiddlewareInterface
{

  private $nextMiddleware;

  final public function setNext(MiddlewareInterface $next) {
    $this->nextMiddleware = $next;
  }

  final public function next($method, $uri, &$request,
                             ResponseWriterInterface &$response) {
    if(!empty($this->nextMiddleware)) {
      $this->nextMiddleware->route($method, $uri, $request, $response);
    }
  }

}
