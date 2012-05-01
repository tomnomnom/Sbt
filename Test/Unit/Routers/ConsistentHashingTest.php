<?php
namespace Sbt\Test\Unit\Routers;

class ConsistentHashingTest extends \PHPUnit_Framework_TestCase {
  public function testAdd(){
    $router = new \Sbt\Routers\ConsistentHashing();

    $router->add('node1');
    $this->assertEquals('node1', $router->get('key1'), "Get should have returned only node");
  }

  public function testRemove(){
    $router = new \Sbt\Routers\ConsistentHashing();

    $router->add('node1');
    $this->assertEquals('node1', $router->get('key1'), "Get should have returned only node");

    $router->remove('node1');
    $this->assertEquals(null, $router->get('key1'), "Get with no nodes should return null");
  }

  public function testRepeatable(){
    $nodes = ['node1', 'node2', 'node3', 'node4', 'node5'];
    $router = new \Sbt\Routers\ConsistentHashing($nodes);

    $nodesReturned = [];
    for ($i = 0; $i < 100; $i++){
      $nodesReturned[] = $router->get('key1');
    }
    $uniqueNodesReturned = sizeOf(array_unique($nodesReturned));

    $this->assertEquals(1, $uniqueNodesReturned, "Only 1 unique node should have been returned");
    $this->assertTrue(in_array(array_shift($nodesReturned), $nodes), "Returned node is not in original list");


    $nodesReturned = [];
    for ($i = 0; $i < 100; $i++){
      $nodesReturned[] = $router->get('key2');
    }
    $uniqueNodesReturned = sizeOf(array_unique($nodesReturned));

    $this->assertEquals(1, $uniqueNodesReturned, "Only 1 unique node should have been returned");
    $this->assertTrue(in_array(array_shift($nodesReturned), $nodes), "Returned node is not in original list");
  }
}
