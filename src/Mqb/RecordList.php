<?php

class Mqb_RecordList implements Iterator
{
  private $_record_class_name;
  protected $_cursor;

  public function __construct(MongoCursor $cursor, $record_class_name = 'Mqb_Record')
  {
    $this->_record_class_name = $record_class_name;
    $this->_cursor = $cursor;
  }

  public function count()
  {
    return $this->_cursor->count();
  }

  public function first()
  {
    $array = $this->_cursor->getNext();
    if($array === null)
    {
      return null;
    }

    return $this->_createRecord($array);
  }

  private function _createRecord(array $array)
  {
    $record = new $this->_record_class_name();
    if(!$record instanceof Mqb_Record)
    {
      throw new Exception("Record class must be Mqb_Record sub class.");
    }
    $record->bindFromDb($array);
    return $record;
  }

  //////////////////////////////////////
  // Iterator
  public function rewind()
  {
    $this->_cursor->rewind();
  }

  public function current()
  {
    $array = $this->_cursor->current();
    if($array === null)
    {
      return null;
    }

    return $this->_createRecord($array);
  }

  public function key()
  {
    return $this->_cursor->key();
  }

  public function next()
  {
    $this->_cursor->next();
  }

  public function valid()
  {
    return $this->_cursor->valid();
  }
}