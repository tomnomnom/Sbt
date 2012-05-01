<?php
namespace Sbt\Routers;

class ConsistentHashing {
  protected $replicaCount;
  protected $circle;
  
  public function __construct(Array $nodes = array(), $replicaCount = 128){
    // TODO: inject + create factory
    $this->circle = new \Sbt\Types\SortedMap();
    $this->replicaCount = (int) $replicaCount;

    foreach ($nodes as $node){
      $this->add($node);
    }
  }

  public function add($node){
    for ($i = 0; $i < $this->replicaCount; $i++){
      $this->circle->put($this->hash($node.$i), $node);
    }
  }

  public function remove($node){
    for ($i = 0; $i < $this->replicaCount; $i++){
      $this->circle->remove($this->hash($node.$i));
    }
  }

  public function get($key){
    if ($this->circle->isEmpty()){
      return null;
    }

    $hash = $this->hash($key);

    if (!$this->circle->containsKey($hash)){
      $tailMap = $this->circle->tailMap($hash);

      $hash = $tailMap->isEmpty()?
        $this->circle->firstKey() : $tailMap->firstKey();
    }

    return $this->circle->get($hash);
  }

  protected function hash($value){
    return substr(md5($value), 0, 8);
  }

}
