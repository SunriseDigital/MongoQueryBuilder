<?php
class Mqb_Query
{
  private $_queries = array();

  public function add($key, $value)
  {
    if(!isset($this->_queries[$key]))
    {
      $this->_queries[$key] = $value;
    }
    else
    {
      $values[] = $this->_queries[$key];
      $values[] = $value;
      $this->_queries[$key] = $values;
    }

    return $this;
  }

  public function build()
  {
    return $this->_queries;
  }
}