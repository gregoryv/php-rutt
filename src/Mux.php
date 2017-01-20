<?php
namespace gregoryv\rutt;

/**
 * Mux is responsible for mapping method and uri to a destination
 * class or object.
 */
class Mux implements MuxerInterface
{

  private $map;

  public function __construct() {
    $this->map = [];
  }

  /**
   * Adds rule for matching a route
   */
  public function add($methodExpr, $expression, $handler) {
    $this->map[] = [$methodExpr, $expression, $handler];
  }

  /**
   * @return Rutt if one is matched, null otherwise
   *
   * @throws HttpException 404 if no uri matches or 501 if uri ok but no method matches
   */
  public function match($method, $uri) {
    $route = null;
    $methodFound = false;
    // todo to be able to throw 501 if
    foreach($this->map as list($methodExpr, $expression, $handler)) {

      if(mb_ereg($expression, $uri, $parts) == 0) {
        //printf("\nexpr=%s uri=%s count=%d", $expression, $uri, $parts);
        continue;
      }
      $route = new Rutt($handler, $parts);

      if(!mb_ereg_match($methodExpr, $method)) {
        //printf("\nmethodExpr=%s method=%s", $methodExpr, $method);
        continue;
      }
      $methodFound = true;
    }
    if(empty($route)) {
      throw new HttpException("Not Found", 404);
    }
    if(!$methodFound) {
      throw new HttpException("Not Implemented", 501);
    }
    return $route;
  }
}
