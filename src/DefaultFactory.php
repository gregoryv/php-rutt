<?php
namespace gregoryv\rutt;

/**
 * Creates handlers from named classes, works with empty constructors.
 */
class DefaultFactory
{
  /**
   * If the handler in the route is a string we try to instantiate it
   * otherwise it's returned
   *
   * @throws \Exception if instantiation fails
   */
  public function create(Route &$route) {
    $cls = $route->handler;
    if(!is_string($cls)) {
      return $cls;
    }
    if(is_string($cls) && class_exists($cls)) {
        return new $route->handler();
    }
    throw new \Exception("Cannot instantiate " + $cls, 0);
  }
}
