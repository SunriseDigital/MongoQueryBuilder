<?php
require_once dirname(__FILE__).'/../src/Mqb/Builder.php';

class BuilderTest extends PHPUnit_Framework_TestCase
{
  public function testSimple()
  {
    $builder = new Mqb_Builder();

    $query = $builder->query();
    $query->add('some_column', 'value1');
    $this->assertEquals(array(
      'some_column' => 'value1'
    ), $query->build());

    $query->add('some_column', 'value2');
    $this->assertEquals(array(
      'some_column' => array(
        'value1',
        'value2'
      )
    ), $query->build());
  }
}