<?php
require_once 'Mqb/Collection.php';
class Mqb_Db
{
  private $_collections = array();

  private $_mongo, $_connection;

  public function __construct($host, $user, $password, $db_name)
  {
    $this->_mongo = new Mongo("mongodb://{$user}:{$password}@{$host}/{$db_name}", array('w' => 1, 'wTimeoutMS' => 1000));
    $this->_connection = $this->_mongo->$db_name;
  }

  public function mongo()
  {
    return $this->_mongo;
  }

  public function connection()
  {
    return $this->_connection;
  }

  public function __get($name)
  {
    if(!isset($this->_collections[$name]))
    {
      $this->_collections[$name] = new Mqb_Collection($this->_connection->$name);
    }

    return $this->_collections[$name];
  }
}