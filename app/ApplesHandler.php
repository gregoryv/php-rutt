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

  public function __construct(Store $store) {
    $this->store = $store;
  }

  public function create(&$request, Response &$response) {
    $apple = new Apple($request);
    $this->store->insert($apple);
    $this->store->save();
  }

  public function read(&$request, Response &$response) {
    // We know the store only holds apples
    $apples = $this->store->select();
    $response->write($apples);
  }

}
