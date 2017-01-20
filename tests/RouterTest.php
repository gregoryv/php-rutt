<?php
use gregoryv\rutt;

class RouterTest extends PHPUnit_Framework_TestCase
{

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $router = new rutt\Router();
    $a = $router->append(new rutt\NoopMiddleware());
    $b = $router->append(new rutt\NoopMiddleware());
    $request = [];
    $response = new rutt\JSONWriter();
    $router->route('CREATE', '/somethings/', $request, $response);
    $this->assertTrue($a->called, 'create method wasn\'t called on a');
    $this->assertTrue($b->called, 'create method wasn\'t called on b');
  }
}
