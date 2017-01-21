<?php
use gregoryv\rutt;

class MockWriterTest extends PHPUnit_Framework_TestCase
{

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $w = new rutt\MockWriter();

    $text = 'anything';
    $w->write($text);
    $this->assertEquals($text, $w->written);

    $e = new rutt\HttpException('Internal Server Error', 500);
    $w->writeError($e);
    $this->assertEquals($e, $w->error);

    $header = 'Accept: */*;0.8';
    $w->accepted = true;
    $this->assertTrue($w->accepts($header));

  }
}
