<?php
namespace gregoryv\rutt;

/**
 * Mux uses regular expression for matching both method and uri.
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
  public function add($methodExpr, $expression, $handler=null) {
    $this->map[] = [$methodExpr, $expression, $handler];
  }

  /**
   * @return Route if one is matched, null otherwise
   *
   * @throws HttpException 404 if no uri matches or 501 if uri ok but no method matches
   */
  public function match($method, $uri) {
    $route = null;
    $methodFound = false;
    foreach($this->map as list($methodExpr, $expression, $handler)) {

      if(mb_ereg($expression, $uri, $parts) == 0) {
        //printf("\nexpr=%s uri=%s count=%d", $expression, $uri, $parts);
        continue;
      }
      $route = new Route($handler, $parts);

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
