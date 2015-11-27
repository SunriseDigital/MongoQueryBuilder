<?php
ini_set('include_path', get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/..');
require_once 'Mqb/Query.php';

class Mqb_Builder
{
  public static function query()
  {
    return new Mqb_Query();
  }
}