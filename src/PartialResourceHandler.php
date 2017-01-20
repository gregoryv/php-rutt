<?php
namespace gregoryv\rutt;

/**
 * Extend this class if you only want to implement a partial handler.
 */
class PartialResourceHandler implements HandlerInterface
{

  private $notImplemented;

  public function __construct() {
    $this->notImplemented = new HttpException("Not Implemented", 501);
  }

  public function create(&$request, ResponseWriterInterface &$response) { throw $this->notImplemented; }
  public function   read(&$request, ResponseWriterInterface &$response) { throw $this->notImplemented; }
  public function update(&$request, ResponseWriterInterface &$response) { throw $this->notImplemented; }
  public function delete(&$request, ResponseWriterInterface &$response) { throw $this->notImplemented; }

}
