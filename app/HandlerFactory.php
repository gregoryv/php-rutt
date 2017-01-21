<?php
namespace gregoryv\app;

use gregoryv\rutt;
use gregoryv\jsonstore;

/**
 *
 */
class HandlerFactory implements rutt\HandlerFactoryInterface
{
  /**
   * Creates handlers which require a store in the constructor
   */
  public function create(rutt\Route &$route) {
    $cls = $route->handler;
    if(!is_string($cls) || !class_exists($cls)) {
      throw new \Exception("Cannot instantiate " + $cls, 0);
    }
    $store = new jsonstore\Store();
    $store->load('app/database.json');

    // All handlers are provided with a store
    return new $route->handler($store);
  }

}
