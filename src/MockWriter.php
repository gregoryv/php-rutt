<?php
namespace gregoryv\rutt;

class MockWriter extends AbstractResponseWriter {

  public $written;
  public function write($arg) {
    $this->written = $arg;
  }

  public $error;
  public function writeError(HttpException $e) {
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