<?php
require_once dirname(__FILE__).'/../src/Mqb/Builder.php';

class BuilderTest extends PHPUnit_Framework_TestCase
{
  public function testSimple()
  {
    $builder = new Mqb_Builder();
    $query = $builder->query();
    $query->add('some_column', 'value');

    $this->assertEquals(array('some_column' => 'value'), $query->build());
  }
}