<?php
namespace gregoryv\jsonstore;

/**
 *
 */
abstract class Entity
{

  function __construct(&$values = null) {
    if(!empty($values)) {
      foreach(get_object_vars($this) as $name => $val) {
        if(isset($values[$name])) {
          $this->setValid($name, $values[$name]);
        }
      }
    }
  }

  abstract function setValid($name, $value);

  abstract function setId($id);
}
