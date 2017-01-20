<?php
namespace gregoryv\rutt;

/**
 *
 */
class Route
{
  public $handler;
  public $parts;

  public function __construct($handler, $parts) {
    $this->handler = $handler;
    $this->parts = $parts;
  }

}
