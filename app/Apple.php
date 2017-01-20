<?php
namespace gregoryv\app;

use gregoryv\jsonstore\Entity;

/**
 *
 */
class Apple extends Entity
{
  public $id = '';
  public $origin = 'Unknown';

  public function setValid($name, $value) {
    switch($name) {
    case 'origin':
      $this->origin = $value;
    }
  }

  public function setId($id) {
    $this->id = $id;
  }
}
