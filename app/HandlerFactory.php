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
    $name = $resourceid = null;
    $name = $route->parts[1];
    if(count($route->parts) == 3) {
      $resourceid = $route->parts[2];
    }
    if($cls == 'resource') {
      switch($route->parts[1]) {
      case 'apples':
        $cls = 'gregoryv\app\ApplesHandler';
        break;
      default:
        throw new rutt\HttpException("Not Found", 404);
      }
    }
    if(!is_string($cls) || !class_exists($cls)) {
      throw new \Exception("Cannot instantiate " + $cls, 0);
    }
    $store = new jsonstore\Store();
    $store->load('app/database.json');

    // All handlers are provided with a store and a resourceid if
    // one has been found in the uri
    // This part requires that the muxer is provided with similar
    // routes to our resources /RESOURCE/[ID]
    return new $cls($store, $resourceid);
  }

}
