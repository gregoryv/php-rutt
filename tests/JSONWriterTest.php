<?php
use gregoryv\rutt;

class JSONWriterTest extends PHPUnit_Framework_TestCase implements rutt\WriterInterface
{

  public function setUp()
  {
    $this->o = new rutt\JSONWriter($this, $this);
  }

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $obj = ['name' => 'gregory'];
    $this->o->write($obj);
    $this->assertEquals('{"name":"gregory"}', $this->written);

    $this->o->writeError(new rutt\HttpException("Not Found", 404));
    $this->assertEquals('{"error":"404 Not Found"}', $this->written);
  }


  /**
   * @test
   * @group unit
   */
  public function accepts() {
    $data = [
      ['*/*', true],
      ['*/*;0.8', true],
      ['application/json', true],
      ['text/html', false]
    ];
    foreach($data as list($header, $exp)) {
      try {
        $this->o->accepts($header);
        if(!$exp) {
          $this->fail(sprintf('accepts("%s") should fail', $header));
        }
      } catch(rutt\HttpException $e) {
        if(!$exp) {
          $this->assertEquals(406, $e->getCode());
        } else {
          $this->fail(sprintf('accepts("%s") should be ok', $header));
        }
      }
    }

  }

  public function write($args) {
    $this->written = $args;
  }
}
