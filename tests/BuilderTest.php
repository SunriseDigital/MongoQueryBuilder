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

  public function testHasQuery()
  {
    $builder = new Mqb_Builder();

    $query = $builder->query();
    $query->add('some_column', $builder->query()->add('$gt', 12));
    $this->assertEquals(array(
      'some_column' => array('$gt' => 12)
    ), $query->build());

    $query->add('some_column', $builder->query()->add('$lt', 20));
    $this->assertEquals(array(
      'some_column' => array(
        '$gt' => 12,
        '$lt' => 20
      )
    ), $query->build());
  }

  public function testComplexQuery()
  {
    $builder = new Mqb_Builder();

    $query = $builder->query();
    $query
      ->add('$and', $builder->query()
        ->add('$or', $builder->query()->add('exp', 1))
        ->add('$or', $builder->query()->add('exp', 2))
      )
      ->add('$and', $builder->query()
        ->add('foobar', $builder->query()->add('$gt', 12))
        ->add('foobar', $builder->query()->add('$lt', 30))
      )
      ->add('$and', $builder->query()->add('uid', "aakldkd8fds689f"));

    $this->assertEquals(array(
      '$and' => array (
        array (
          '$or' => array (
            array (
              'exp' => 1,
            ),
            array (
              'exp' => 2,
            ),
          ),
        ),
        array (
          'foobar' => array (
            '$gt' => 12,
            '$lt' => 30,
          ),
        ),
        array (
          'uid' => 'aakldkd8fds689f',
        ),
      ),
    ), $query->build());
  }

  public function testComplexQueryWithMethod()
  {
    $builder = new Mqb_Builder();

    $query = $builder->query();
    $query
      ->addAnd($builder->query()
        ->addOr($builder->query()->add('exp', 1))
        ->addOr($builder->query()->add('exp', 2))
      )
      ->addAnd($builder->query()
        ->add('foobar', $builder->query()->add('$gt', 12))
        ->add('foobar', $builder->query()->add('$lt', 30))
      )
      ->addAnd($builder->query()->add('uid', "aakldkd8fds689f"));

    $this->assertEquals(array(
      '$and' => array (
        array (
          '$or' => array (
            array (
              'exp' => 1,
            ),
            array (
              'exp' => 2,
            ),
          ),
        ),
        array (
          'foobar' => array (
            '$gt' => 12,
            '$lt' => 30,
          ),
        ),
        array (
          'uid' => 'aakldkd8fds689f',
        ),
      ),
    ), $query->build());
  }
}