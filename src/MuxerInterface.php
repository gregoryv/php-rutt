<?php
namespace gregoryv\rutt;

/**
 *
 */
interface MuxerInterface
{
  /**
   * @return mixed class name or object which should handle the request
   */
  public function match($method, $uri);
}
