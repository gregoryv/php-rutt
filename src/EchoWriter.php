<?php
namespace gregoryv\rutt;

/**
 *
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
