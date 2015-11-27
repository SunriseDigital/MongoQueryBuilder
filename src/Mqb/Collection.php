<?php
class Mqb_Collection
{
  private $_collection;

  public function __construct(MongoCollection $collection)
  {
    $this->_collection = $collection;
  }

  public function findByColumn($column, $value)
  {
    $query = Mqb_Builder::query();
    $query->add($column, $value);
    return $this->_collection->find($query->build());
  }

  public function driver()
  {
    return $this->_collection;
  }
}