<?php
namespace Sbt\Test\Unit\Types;

class MapTest extends \PHPUnit_Framework_TestCase {
  public function testClear(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $map->clear();
    
    $this->assertEquals(
      0, sizeOf($map->entrySet()), "Clear should produce an empty entrySet"
    );
  }

  public function testContainsKey(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $this->assertTrue(
      $map->containsKey('key1'),
      "Map should have contained key1"
    );
    $this->assertTrue(
      $map->containsKey('key2'),
      "Map should have contained key2"
    );
    $this->assertFalse(
      $map->containsKey('key3'),
      "Map should not have contained key3"
    );
  }

  public function testContainsValue(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $this->assertTrue(
      $map->containsValue('value1'),
      "Map should have contained value1"
    );
    $this->assertTrue(
      $map->containsValue('value2'),
      "Map should have contained value2"
    );
    $this->assertFalse(
      $map->containsValue('value3'),
      "Map should not have contained value3"
    );
  }

  public function testEntrySet(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2'
    ];
    $map = new \Sbt\Types\Map($entries);

    $this->assertEquals($entries, $map->entrySet(), "entrySet did not match input");
  }

  public function testEquals(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2'
    ];
    $map1 = new \Sbt\Types\Map($entries);
    $map2 = new \Sbt\Types\Map($entries);

    $this->assertTrue(
      $map1->equals($map2), "Maps should match but don't"
    );

    $map3 = new \Sbt\Types\Map([
      'key1' => 'value1'  
    ]);

    $this->assertFalse(
      $map1->equals($map3), "Maps shouldn't match but do"
    );
  }

  public function testGet(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);
    
    $this->assertEquals('value1', $map->get('key1'), "Key lookup failed");
    $this->assertEquals('value2', $map->get('key2'), "Key lookup failed");
    $this->assertEquals(null,     $map->get('key3'), "Unknown key should return null");
  }

  public function testIsEmpty(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $this->assertFalse($map->isEmpty(), "Map shouldn't be empty but is");

    $map->clear();

    $this->assertTrue($map->isEmpty(), "Map should be empty but isn't");
  }

  public function testKeySet(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2'
    ];
    $map = new \Sbt\Types\Map($entries);

    $keys = array_keys($entries);
    $this->assertEquals($keys, $map->keySet(), "Keys don't match expected keys");
  }

  public function testPut(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);
    $map->put('key3', 'value3');
    $map->put('key4', 'value4');
    
    $this->assertEquals('value3', $map->get('key3'), "Key lookup failed");
    $this->assertEquals('value4', $map->get('key4'), "Key lookup failed");
  }

  public function testPutAll(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $subMap = new \Sbt\Types\Map([
      'key3' => 'value3',
      'key4' => 'value4'
    ]);

    $map->putAll($subMap);

    $this->assertEquals('value1', $map->get('key1'), "Key lookup failed");
    $this->assertEquals('value2', $map->get('key2'), "Key lookup failed");
    $this->assertEquals('value3', $map->get('key3'), "Key lookup failed");
    $this->assertEquals('value4', $map->get('key4'), "Key lookup failed");
  }

  public function testRemove(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $this->assertEquals('value1', $map->remove('key1'), "Remove should return key value");
    $this->assertEquals(null, $map->get('key1'), "Removed key lookup should return null");

    $this->assertEquals(null, $map->remove('key1'), "Removal of invalid key should return null");
  }

  public function testSize(){
    $map = new \Sbt\Types\Map([
      'key1' => 'value1',
      'key2' => 'value2'
    ]);

    $this->assertEquals(2, $map->size(), "Map size should be 2");

    $map->put('key3', 'value3');
    $this->assertEquals(3, $map->size(), "Map size should be 3");
  }

  public function testValues(){
    $entries = [
      'key1' => 'value1',
      'key2' => 'value2'
    ];
    $map = new \Sbt\Types\Map($entries);

    $values = array_values($entries);
    $this->assertEquals($values, $map->values(), "Values don't match those expected");
  }
}
