<?php
namespace gregoryv\rutt;

/**
 * Uses the builtin echo function.
 */
class EchoWriter implements WriterInterface
{
  /**
   * @codeCoverageIgnore
   */
  public function write($args) {
      echo $args;
  }
}
