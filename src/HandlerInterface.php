<?php
namespace gregoryv\rutt;

/**
 * Defines methods for handling CRUD operations.
 */
interface HandlerInterface
{
  public function create(&$request, ResponseWriterInterface &$response);
  public function   read(&$request, ResponseWriterInterface &$response);
  public function update(&$request, ResponseWriterInterface &$response);
  public function delete(&$request, ResponseWriterInterface &$response);
}
