<?php
namespace gregoryv\rutt;

/**
 * Uses the builtin header function.
 */
class BuiltinHeaderWriter implements WriterInterface
{
  /**
   * @codeCoverageIgnore
   */
  public function write($header) {
    header($header);
  }
}
