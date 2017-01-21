<?php
namespace gregoryv\rutt;

/**
 * One step in the Router sequence handling a request.
 */
interface MiddlewareInterface
{
  public function setNext(MiddlewareInterface $next);

  public function route($method, $uri, &$request,
                        ResponseWriterInterface &$response);

}
