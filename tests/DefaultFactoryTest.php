<?php
use gregoryv\rutt;

class DefaultFactoryTest extends PHPUnit_Framework_TestCase
{

  public function setUp()
  {
    $this->o = new rutt\DefaultFactory();
  }

  /**
   * @test
   * @group unit
   */
  public function test()
  {
    $data = [
      ['gregoryv\rutt\NoopHandler', true],
      ['gregoryv\rutt\NoSuchThing', false],
      [new rutt\NoopHandler(), true]
    ];
    foreach($data as list($cls, $expOk)) {
      $route = new rutt\Route($cls, []);
      try {
        $this->o->create($route);
        if(!$expOk) {
          $this->fail('Should fail when creating instance of ' + $cls);
        }
      } catch(\Exception $e) {
        if($expOk) {
          $this->fail('Should not fail when creating instance of ' + $cls);
        }
      }
    }
  }
}
