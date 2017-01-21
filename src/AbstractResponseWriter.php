<?php
namespace gregoryv\rutt;

/**
 *
 */
abstract class AbstractResponseWriter implements ResponseWriterInterface
{

  // Writer to to print the actual string
  protected $bodyWriter;
  private $headerWriter;

  public function __construct(WriterInterface $bodyWriter = null,
                              WriterInterface $headerWriter = null) {
    $this->bodyWriter = empty($bodyWriter) ? new EchoWriter() : $bodyWriter;
    $this->headerWriter = empty($headerWriter) ? new BuiltinHeaderWriter() : $headerWriter;
  }

  public function writeHeader($header) {
    $this->headerWriter->write($header);
  }

}
