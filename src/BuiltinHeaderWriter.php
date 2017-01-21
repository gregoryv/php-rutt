<?php
namespace gregoryv\rutt;

/**
 * Uses the builtin echo function.
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
