<?php
namespace Sbt\Test\Unit\Types;

class SortedMapTest extends \PHPUnit_Framework_TestCase {

  public function testCompatator(){
    // Test default comparator
    $map = new \Sbt\Types\SortedMap();
    $this->assertEquals('strcmp', $map->comparator(), "Default comparator should be strcmp");

    $comparator = function($a, $b){
      return strcmp($a, $b);
    };
    $map = new \Sbt\Types\SortedMap([], $comparator);
    $this->assertEquals($comparator, $map->comparator(), "Returned comparator does not match");
  }

  public function testEntrySet(){
    $entries = [
      'key3' => 'value3',
      'key2' => 'value2',
      'key1' => 'value1'
    ];
    $map = new \Sbt\Types\SortedMap($entries);

    $this->assertNotSame($entries, $map->entrySet(), "Order matched but shouldn't");

    uksort($entries, 'strcmp');
    $this->assertSame($entries, $map->entrySet(), "Order should not match but should");
  }

  public function testFirstKey(){
    $map = new \Sbt\Types\SortedMap([
      'key3' => 'value3',
      'key2' => 'value2',
      'key1' => 'value1'
    ]);

    $this->assertEquals('key1', $map->firstKey(), "First key should be key1");
  }

  public function testHeadMap(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2',
      'key3' => 'value3'
    ];
    $map = new \Sbt\Types\SortedMap($entries);

    $entries = $map->entrySet();

    array_pop($entries);
    $this->assertSame($entries, $map->headMap('key2')->entrySet(), "Maps should match");

    array_pop($entries);
    $this->assertSame($entries, $map->headMap('key1')->entrySet(), "Maps should match");
  }

  public function testKeySet(){
    $entries = [
      'key3' => 'value3',
      'key2' => 'value2',
      'key1' => 'value1'
    ];
    $map = new \Sbt\Types\SortedMap($entries);

    $keys = array_keys($entries);
    $this->assertNotSame($keys, $map->keySet(), "Order matched but shouldn't");

    uksort($entries, 'strcmp');
    $keys = array_keys($entries);
    $this->assertSame($keys, $map->keySet(), "Order should not match but should");
  }

  public function testLastKey(){
    $map = new \Sbt\Types\SortedMap([
      'key3' => 'value3',
      'key2' => 'value2',
      'key1' => 'value1'
    ]);

    $this->assertEquals('key3', $map->lastKey(), "Last key should be key3");
  }

  public function testSubMap(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2',
      'key3' => 'value3',
      'key4' => 'value4'
    ];
    $map = new \Sbt\Types\SortedMap($entries);

    $entries = $map->entrySet();

    array_shift($entries);
    $this->assertSame($entries, $map->subMap('key2', 'key4')->entrySet(), "Maps should match");

    array_pop($entries);
    $this->assertSame($entries, $map->subMap('key2', 'key3')->entrySet(), "Maps should match");
  }

  public function testTailMap(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2',
      'key3' => 'value3'
    ];
    $map = new \Sbt\Types\SortedMap($entries);

    $entries = $map->entrySet();

    array_shift($entries);
    $this->assertSame($entries, $map->tailMap('key2')->entrySet(), "Maps should match");

    array_shift($entries);
    $this->assertSame($entries, $map->tailMap('key3')->entrySet(), "Maps should match");
  }

  public function testValues(){
    $entries = [
      'key3' => 'value3',
      'key2' => 'value2',
      'key1' => 'value1'
    ];
    $map = new \Sbt\Types\SortedMap($entries);

    $values = array_values($entries);
    $this->assertNotSame($values, $map->values(), "Order matched but shouldn't");

    uksort($entries, 'strcmp');
    $values = array_values($entries);
    $this->assertSame($values, $map->values(), "Order should not match but should");
  }


}
