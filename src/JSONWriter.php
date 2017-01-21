<?php
namespace gregoryv\rutt;

/**
 * Response writer for JSON responses.
 */
class JSONWriter extends AbstractResponseWriter
{

  public function write($something) {
    $this->bodyWriter->write(json_encode($something));
  }

  public function writeError(HttpException $e) {
    $header = sprintf('%d %s', $e->getCode(), $e->getMessage());
    $this->writeHeader($header);
    $this->write(['error' => $header]);
  }

  /**
   * @return true if the header contains application/json or *\/*
   */
  public function accepts($header) {
    $parts = explode(',', $header);
    foreach($parts as $value) {
      $mimeQuality = explode(';', $value);
      switch($mimeQuality[0]) {
      case '*/*':
      case 'application/json':
        return true;
      }
    }
    throw new HttpException("Not Accepted", 406);
  }
}
