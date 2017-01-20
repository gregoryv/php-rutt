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
    $this->headerWriter = $headerWriter;
  }

  /**
   * Uses phps builtin header function
   */
  public function writeHeader($header) {
    if($this->headerWriter == null) {
      // @codeCoverageIgnoreStart
      header($header);
      // @codeCoverageIgnoreEnd
    } else {
      $this->headerWriter->write($header);
    }
  }

}
