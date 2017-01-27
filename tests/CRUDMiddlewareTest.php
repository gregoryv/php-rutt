<?php
use gregoryv\rutt;

class CRUDMiddlewareTest extends PHPUnit_Framework_TestCase
{

  /**
   * @test
   * @group unit
   */
  public function route() {
    // Prepare muxer
    $factory = new MockFactory();
    $mid = new rutt\CRUDMiddleware($factory);
    $request = ['name' => 'golden delicious'];
    $response = new rutt\MockWriter();

    $data = [
      ['PUT','/apples/', 'create',0],
      ['GET','/apples/', 'read',0],
      ['DELETE','/apples/', 'delete',0],
      ['PATCH','/apples/', 'update',0],
      ['POST','/apples/', 'update',0],
      ['GET','/nothing/', null, 0],
      ['GET','/oranges/', null, 404],
      ['OPTIONS','/apples/', null, 501], // CRUDMiddleware only uses PUT GET PATCH POST and DELETE
      ['POST', '/blowup/', null, 500]
    ];
    foreach($data as list($method, $uri, $expWritten, $code)) {
      $response->clear();
      $mid->route($method, $uri, $request, $response);
      $msg = sprintf('route(\'%s\', \'%s\')', $method, $uri);
      if($code > 0) {
        $this->assertEquals($code, $response->error->getCode(), $msg);
      } else {
        $this->assertEquals($expWritten, $response->written, $msg);
      }
    }
  }


  /**
   * @test
   * @group unit
   */
  public function middleware_fails_when_no_matchin_handler_is_found() {
    $factory = new MockFactory();
    $mid = new rutt\CRUDMiddleware($factory);
    $request = [];
    $response = new rutt\MockWriter();

    $data = [
      ['PUT','/oranges/'],
      ['GET','/oranges/'],
      ['DELETE','/oranges/'],
      ['PATCH','/oranges/' ],
      ['POST','/oranges/']
    ];
    foreach($data as list($method, $uri)) {
      $response->clear();
      $mid->route($method, $uri, $request, $response);
      $msg = sprintf('route(\'%s\', \'%s\')', $method, $uri);
      $this->assertEquals(404, $response->error->getCode(), $msg);
    }
  }

}

class MockFactory implements rutt\HandlerFactoryInterface {

  public function create($resource, $id=null) {
    if($resource == 'apples') {
      return new rutt\MockHandler();
    }
    if($resource == 'blowup') {
      throw new \Exception('testing');
    }
    throw new rutt\HttpException("NotFound", 404);
  }
}
