<?php
namespace gregoryv\rutt;

/**
 *
 */
interface ResponseWriterInterface extends WriterInterface
{
  public function writeHeader($header);

  public function writeError(HttpException $e);

  /**
   * @return true if this writer can write the requested format
   * @throws HttpException, 406 Not Acceptable
   */
  public function accepts($acceptHeader);
}
