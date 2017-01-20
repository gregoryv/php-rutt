<?php
namespace gregoryv\rutt;

/**
 *
 */
class Router
{
  private $first;
  private $last;

  /**
   * @param $mid middleware to add last in the chain
   * @return MiddlewareInterface the given middleware
   */
  public function append(MiddlewareInterface $mid) {
    if(empty($this->first)) {
      $this->first = $mid;
      $this->last = $mid;
      return $mid;
    }
    $this->last->setNext($mid);
    $this->last = $mid;
    return $mid;
  }

  public function route($method, $uri, &$request, &$response) {
    if($this->first == null) {
      $response->writeError(new HttpException("Not Found", 404));
      return;
    }
    $this->first->route($method, $uri, $request, $response);
  }
}
