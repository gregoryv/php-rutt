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
    $mux = new rutt\Mux();
    $regex = '\/(apples)\/';
    $handler = new rutt\MockHandler();
    $mux->add('GET|PUT|DELETE|PATCH|POST|OPTIONS', $regex, $handler);
    $mux->add('GET', '\/nothing\/', 'gregoryv\rutt\NoopHandler');
    $mux->add('GET', '\/blowup\/', 'dynamite :-)');

    $factory = new MockFactory();
    $mid = new rutt\CRUDMiddleware($mux);
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
      ['GET','/blowup/', null, 500]
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
    $mux = new rutt\Mux();
    $regex = '\/(apples)\/';
    $mux->add('GET|PUT|DELETE|PATCH|POST|OPTIONS', $regex, 'this is what fails');
    $factory = new MockFactory();
    $mid = new rutt\CRUDMiddleware($mux, $factory);
    $request = [];
    $response = new rutt\MockWriter();

    $data = [
      ['PUT','/apples/'],
      ['GET','/apples/'],
      ['DELETE','/apples/' ],
      ['PATCH','/apples/' ],
      ['POST','/apples/'],
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

  public function create(rutt\Route &$route) {
    throw new rutt\HttpException("NotFound", 404);
  }
}
