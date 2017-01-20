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
    $handler = new MockHandler();
    $mux->add('GET|PUT|DELETE|PATCH|POST|OPTIONS', $regex, $handler);
    $mux->add('GET', '\/nothing\/', 'gregoryv\rutt\NoopHandler');

    $mid = new rutt\CRUDMiddleware($mux);
    $request = ['name' => 'golden delicious'];
    $response = new MockWriter();

    $data = [
      ['PUT','/apples/', 'create',0],
      ['GET','/apples/', 'read',0],
      ['DELETE','/apples/', 'delete',0],
      ['PATCH','/apples/', 'update',0],
      ['POST','/apples/', 'update',0],
      ['GET','/nothing/', null, 0],
      ['GET','/oranges/', null, 404],
      ['OPTIONS','/apples/', null, 501] // CRUDMiddleware only uses PUT GET PATCH POST and DELETE
    ];
    foreach($data as list($method, $uri, $expWritten, $code)) {
      $response->clear();
      $mid->route($method, $uri, $request, $response);
      $msg = sprintf('route(\'%s\', \'%s\')', $method, $uri);
      $this->assertEquals($expWritten, $response->written, $msg);
      if($code > 0) {
        $this->assertEquals($code, $response->error->getCode(), $msg);
      }
    }
  }

}


class MockHandler implements rutt\HandlerInterface {

  public function create(&$request, rutt\ResponseWriterInterface &$response){
    $response->write('create');
  }

  public function   read(&$request, rutt\ResponseWriterInterface &$response){
    $response->write('read');
  }

  public function update(&$request, rutt\ResponseWriterInterface &$response){
    $response->write('update');
  }

  public function delete(&$request, rutt\ResponseWriterInterface &$response){
    $response->write('delete');
  }

}


class MockWriter extends rutt\AbstractResponseWriter {

  public $written;
  public function write($arg) {
    $this->written = $arg;
  }

  public $error;
  public function writeError(rutt\HttpException $e) {
    $this->error = $e;
  }

  public $accepted;
  public function accepts($header) {
    return $this->accepted;
  }

  public function clear() {
    $this->written = null;
    $this->error = null;
    $this->accepted = true;
  }

}
