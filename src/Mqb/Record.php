<?php
class Mqb_Record
{
  private $_values = array();
  private $_updated = array();
  private $_is_new = true;
  public function __construct()
  {

  }

  public function bindFromDb(array $values)
  {
    $this->_values = $values;
    $this->_is_new = false;
  }

  public function get($name)
  {
    if(isset($this->_updated[$name]))
    {
      return $this->_updated[$name];
    }

    if(isset($this->_values[$name]))
    {
      return $this->_values[$name];
    }

    return null;
  }

  public function set($name, $value)
  {
    $this->_updated[$name] = $value;
    return $this;
  }

  public function toArray()
  {
    return array_merge($this->_values, $this->_updated);
  }

  public function isNew()
  {
    return $this->_is_new;
  }

  public function save(Mqb_Collection $collection)
  {
    if($this->isNew())
    {
      $res = $collection->driver()->insert($this->_updated);
      $this->_is_new = false;
    }

    $this->_values = array_merge($this->_values, $this->_updated);
    $this->_updated = array();
  }
}