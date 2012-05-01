<?php
namespace Sbt\Types;

class SortedMap extends Map {
  protected $comparator = 'strcmp';

  public function __construct(Array $entries = array(), Callable $comparator = null){
    if (!is_null($comparator)){
      $this->comparator = $comparator;
    }
    parent::__construct($entries);
  }

  public function comparator(){
    return $this->comparator;
  }

  protected function compare($a, $b){
    return call_user_func_array(
      $this->comparator(), [$a, $b]
    );
  }

  protected function sortEntrySet(){
    uksort($this->entries, $this->comparator);
  }

  public function entrySet(){
    $this->sortEntrySet();
    return $this->entries;
  }

  public function firstKey(){
    return reset($this->keySet());
  }

  public function headMap($toKey){
    $entries = $this->entrySet();
    $headEntries = [];

    foreach ($entries as $key => $value){
      if ($this->compare($key, $toKey) > 0) break;
      $headEntries[$key] = $value;
    }

    return new SortedMap($headEntries, $this->comparator());
  }

  public function keySet(){
    $this->sortEntrySet(); 
    return parent::keySet();
  }

  public function lastKey(){
    return end($this->keySet());
  }

  public function subMap($fromKey, $toKey){
    $entries = $this->entrySet();
    $subEntries = [];

    foreach ($entries as $key => $value){
      if ($this->compare($key, $toKey) > 0) break;
      if ($this->compare($key, $fromKey) < 0) continue;
      $subEntries[$key] = $value;
    }

    return new SortedMap($subEntries, $this->comparator());
  }

  public function tailMap($fromKey){
    $entries = $this->entrySet();
    $tailEntries = [];

    foreach ($entries as $key => $value){
      if ($this->compare($key, $fromKey) < 0) continue;
      $tailEntries[$key] = $value;
    }

    return new SortedMap($tailEntries, $this->comparator());
  }

  public function values(){
    $this->sortEntrySet(); 
    return parent::values();
  }

}
