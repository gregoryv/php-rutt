<?php
namespace gregoryv\app;

use gregoryv\rutt;
use gregoryv\rutt\ResponseWriterInterface as Response;
use gregoryv\jsonstore\Store;

/**
 * Resource handler for Apples
 */
class ApplesHandler extends rutt\PartialResourceHandler
{
  private $store;
  private $resourceid;

  public function __construct(Store $store, $resourceid = null) {
    $this->store = $store;
    $this->resourceid = $resourceid;
  }

  public function create(&$request, Response &$response) {
    $apple = new Apple($request);
    $this->store->insert($apple);
    $this->store->save();
  }

  public function read(&$request, Response &$response) {
    // We know the store only holds apples
    $apples = $this->store->select();
    if($this->resourceid != null) {
      foreach($apples as $apple) {
        if($apple->id == $this->resourceid) {
          $response->write($apple);
          return;
        }
      }
      $nof = new rutt\HttpException('Not Found', 404);
      $response->writeError($nof);
      return;
    }

    $response->write($apples);
  }

}
