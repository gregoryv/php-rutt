<?php
namespace gregoryv\rutt;

/**
 *
 */
class URIParser
{
  public function parse($uri) {
    $name = explode('/', $uri)[1]; // first word in /name/...
    return [$name];
  }
}
