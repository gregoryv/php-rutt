<?php
use gregoryv\rutt;

class RouterTest extends PHPUnit_Framework_TestCase
{

  /**
   * @test
   * @group unit
   */
  public function test_route()
  {
    $router = new rutt\Router();  
    $request = [];
    $response = new rutt\MockWriter();
    $router->route('CREATE', '/somethings/', $request, $response);
    $this->assertNotNull($response->error);

    $a = $router->append(new rutt\NoopMiddleware());
    $b = $router->append(new rutt\NoopMiddleware());
    $router->route('CREATE', '/somethings/', $request, $response);    
    $response->written = null;
    
    $this->assertTrue($a->called, 'create method wasn\'t called on a');
    $this->assertTrue($b->called, 'create method wasn\'t called on b');
  }
}
