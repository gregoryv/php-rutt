<?php
namespace gregoryv\rutt;

class MockHandler implements HandlerInterface {

  public function create(&$request, ResponseWriterInterface &$response){
    $response->write('create');
  }

  public function read(&$request, ResponseWriterInterface &$response){
    $response->write('read');
  }

  public function update(&$request, ResponseWriterInterface &$response){
    $response->write('update');
  }

  public function delete(&$request, ResponseWriterInterface &$response){
    $response->write('delete');
  }

}