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
      if(!in_array($key, array('$and', '$or')) && $this->_queries[$key] instanceof Mqb_Query)
      {
        $this->_queries[$key]->_merge($value);
      }
      else
      {
        if(is_array($this->_queries[$key]))
        {
          $values = $this->_queries[$key];
        }
        else
        {
          $values[] = $this->_queries[$key];
        }

        $values[] = $value;
        $this->_queries[$key] = $values;
      }
    }

    return $this;
  }

  private function _merge(Mqb_Query $query)
  {
    foreach($query->_queries as $key => $value)
    {
      $this->add($key, $value);
    }
  }

  private function _buildValue($value)
  {
    if(is_array($value))
    {
      $values = array();
      foreach($value as $val)
      {
        $values[] = $this->_buildValue($val);
      }
      return $values;
    }
    else if($value instanceof Mqb_Query)
    {
      return $value->build();
    }
    else
    {
      return $value;
    }
  }

  public function build()
  {
    $result = array();
    foreach($this->_queries as $key => $value)
    {
      $result[$key] = $this->_buildValue($value);
    }

    return $result;
  }
}