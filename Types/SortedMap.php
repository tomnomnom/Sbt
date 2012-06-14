<?php
namespace Sbt\Types;

class SortedMap extends Map {
  protected $comparator = 'strcmp';

  // A flag to determine the need to sort - purely for performance
  protected $sorted = false;

  public function __construct(Array $entries = array(), Callable $comparator = null){
    if (!is_null($comparator)){
      $this->comparator = $comparator;
    }
    parent::__construct($entries);
  }

  public function comparator(){
    return $this->comparator;
  }

  public function put($key, $value){
    $this->sorted = false;
    parent::put($key, $value);
  }

  protected function sortEntrySet(){
    if (!$this->sorted){
      uksort($this->entries, $this->comparator);
      $this->sorted = true;
    }
  }

  public function entrySet(){
    $this->sortEntrySet();
    return $this->entries;
  }

  public function firstKey(){
    $keys = $this->keySet();
    return reset($keys);
  }

  public function headMap($toKey){
    $entries = $this->entrySet();
    $headEntries = [];

    $comparator = $this->comparator;
    foreach ($entries as $key => $value){
      if ($comparator($key, $toKey) > 0) break;
      $headEntries[$key] = $value;
    }

    return new SortedMap($headEntries, $this->comparator);
  }

  public function keySet(){
    $this->sortEntrySet(); 
    return parent::keySet();
  }

  public function lastKey(){
    $keys = $this->keySet();
    return end($keys);
  }

  public function subMap($fromKey, $toKey){
    $entries = $this->entrySet();
    $subEntries = [];

    $comparator = $this->comparator;
    foreach ($entries as $key => $value){
      if ($comparator($key, $toKey) > 0) break;
      if ($comparator($key, $fromKey) < 0) continue;
      $subEntries[$key] = $value;
    }

    return new SortedMap($subEntries, $this->comparator);
  }

  public function tailMap($fromKey){
    $entries = $this->entrySet();
    $tailEntries = [];

    $comparator = $this->comparator;
    foreach ($entries as $key => $value){
      if ($comparator($key, $fromKey) < 0) continue;
      $tailEntries[$key] = $value;
    }

    return new SortedMap($tailEntries, $this->comparator);
  }

  public function values(){
    $this->sortEntrySet(); 
    return parent::values();
  }

}
