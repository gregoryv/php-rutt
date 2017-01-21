<?php
namespace gregoryv\rutt;

/**
 * Responsible for finding a route for a given method and URI
 */
interface MuxerInterface
{
  /**
   * @return mixed class name or object which should handle the request
   */
  public function match($method, $uri);
}
