<?php
namespace gregoryv\rutt;

/**
 * Factory is responsible to create handlers for matching routes
 */
interface HandlerFactoryInterface
{

  /**
   *
   * @return mixed Handler it's up to the Middleware to call it
   * @throws \Exception if handler cannot be created
   */
  public function create($resource, $id=null);

}
