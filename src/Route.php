<?php
namespace gregoryv\rutt;

/**
 *
 */
class Route
{

  /**
   * mixed classname or handler object
   */
  public $handler;

  /**
   * Matched parts of the uri
   */
  public $parts;

  public function __construct($handler, $parts) {
    $this->handler = $handler;
    $this->parts = $parts;
  }

}
