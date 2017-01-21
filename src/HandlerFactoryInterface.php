<?php
namespace gregoryv\rutt;

/**
 * Factory is responsible to create handlers for matching routes
 */
interface HandlerFactoryInterface
{

  /**
   * @param Route &$route reference to the route the muxer matched
   *
   * @return mixed Handler it's up to the Middleware to call it
   * @throws \Exception if handler cannot be created
   */
  public function create(Route &$route);

}
