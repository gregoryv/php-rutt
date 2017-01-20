<?php
namespace gregoryv\rutt;

/**
 *
 */
interface MiddlewareInterface
{
  public function setNext(MiddlewareInterface $next);

  public function route($method, $uri, &$request,
                        ResponseWriterInterface &$response);

}
