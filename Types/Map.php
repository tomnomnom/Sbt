<?php
namespace Sbt\Types;

class Map {
  protected $entries = []; 

  public function __construct(Array $entries = []){
    $this->entries = $entries;
  }

  public function clear(){
    $this->entries = [];
  }

  public function containsKey($key){
    return isSet($this->entries[$key]);
  }

  public function containsValue($value){
    return in_array($value, $this->entries);
  }

  public function entrySet(){
    return $this->entries;
  }

  public function equals(Map $map){
    return ($this->entrySet() == $map->entrySet());
  }

  public function get($key){
    if ($this->containsKey($key)){
      return $this->entries[$key];
    } 
    return null;
  }

  public function hashCode(){
    // TODO
  }

  public function isEmpty(){
    return (sizeOf($this->entries) == 0);
  }

  public function keySet(){
    return array_keys($this->entries);
  }

  public function put($key, $value){
    $this->entries[$key] = $value; 
    return $value;
  }

  public function putAll(Map $map){
    $this->entries = array_merge($this->entries, $map->entrySet());
  }

  public function remove($key){
    if (!$this->containsKey($key)){
      return null;
    }

    $value = $this->entries[$key];
    unset($this->entries[$key]);
    return $value;
  }

  public function size(){
    return sizeOf($this->entries);
  }

  public function values(){
    return array_values($this->entries);
  }
}
