<?php
use gregoryv\rutt;

class PartialResourceHandlerTest extends PHPUnit_Framework_TestCase
{

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $handler = new rutt\PartialResourceHandler();
    $request = [];
    $writer = new rutt\JSONWriter();
    try {
        $handler->create($request, $writer);
      $this->fail('PartialResourceHandler should throw HttpException');
    } catch(rutt\HttpException $e) {
    }

  }
}
