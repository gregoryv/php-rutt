<?php
namespace gregoryv\jsonstore;

/**
 *
 */
class Store
{
  private $db;

  public function __construct() {
    $this->db = [];
  }

  public function insert(Entity &$en) {
    // also store type
    $en->setId(count($this->db));
    $this->db[] = $en;

  }

  public function select() {
    return $this->db;
  }

  public function load($file) {
    if(file_exists($file)) {
      $this->db = json_decode(file_get_contents($file));
    }
    $this->file = $file;
  }

  public function save($file = null) {
    if ($file == null) {
      $file = $this->file;
    }
    $fp = fopen($file, 'w');
    fwrite($fp, json_encode($this->db));
    fclose($fp);
  }
}
