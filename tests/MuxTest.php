<?php
use gregoryv\rutt;

class MuxTest extends PHPUnit_Framework_TestCase
{

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $mux = new rutt\Mux();
    $handler = 'MyHandlerClass';
    $mux->add('GET|POST', '\/(\w+)\/', $handler);

    $data = [
      ['GET', '/apples/', true, 0],
      ['POST', '/apples/', true, 0],
      ['DELETE', '/apples/', false, 501],
      ['GET', '//sdffd', false, 404],
    ];

    foreach($data as list($method, $uri, $exp, $code)) {
      try {
        $r = $mux->match($method, $uri);
        if($exp) {
          $this->assertNotNull($r, sprintf('match(%s, %s) should return a route', $method, $uri));
          $this->assertInstanceOf(rutt\Route::class, $r);
          $this->assertEquals($handler, $r->handler);
        } else {
          $this->fail(sprintf("Should throw HttpException(%d)", $code));
        }
      } catch(rutt\HttpException $e) {
        $this->assertEquals($code, $e->getCode());
      }
    }
  }
}
