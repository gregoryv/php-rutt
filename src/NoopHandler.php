<?php
namespace gregoryv\rutt;

/**
 * CRUD operations do nothing
 */
class NoopHandler implements HandlerInterface
{
  public function create(&$request, ResponseWriterInterface &$response){}
  public function   read(&$request, ResponseWriterInterface &$response){}
  public function update(&$request, ResponseWriterInterface &$response){}
  public function delete(&$request, ResponseWriterInterface &$response){}
}
