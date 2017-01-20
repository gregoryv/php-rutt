<?php
use gregoryv\rutt\URIParser;

class URIParserTest extends PHPUnit_Framework_TestCase
{

  public function setUp()
  {
    $this->o = new URIParser();
  }

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $data = [
      ['/a/', ['a']],
      ['/nada/', ['nada']],
      ['/nada%s/', ['nada%s']]
    ];
    foreach($data as list($uri, $exp)) {
      $res = $this->o->parse($uri);
      $this->assertEquals($exp, $res);
    }
  }
}
