<?php
abstract class Mqb_Record
{
  private $_values = array();
  private $_updated = array();
  private $_is_new = true;
  public function __construct()
  {

  }

  abstract protected function _getCollectionName();

  public function bindFromDb(array $values)
  {
    $this->_values = $values;
    $this->_is_new = false;
  }

  public function getId()
  {
    return $this->get('_id');
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

  public function getZendDate($name)
  {
    $value = $this->get($name);
    if($value instanceof MongoDate)
    {
      return new Zend_Date($value->sec);
    }

    return new Zend_Date($value);
  }

  public function save(Mqb_Db $db)
  {
    $cname = $this->_getCollectionName();
    $collection = $db->$cname;

    if($this->isNew())
    {
      if(!isset($this->_updated['_id']))
      {
        $this->_updated['_id'] = new MongoId();
      }

      $res = $collection->driver()->insert($this->_updated);
      $this->_is_new = false;
    }
    else
    {
      $query = Mqb_Builder::query()->add('_id', $this->getId());
      $res = $collection->driver()->update($query->build(), array('$set' => $this->_updated));
    }

    $this->_values = array_merge($this->_values, $this->_updated);
    $this->_updated = array();

    return $res;
  }
}