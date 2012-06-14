<?php
namespace Sbt\Http;

abstract class Client {
  abstract public function get();
  abstract public function post();
  abstract public function put();
  abstract public function delete();
  abstract public function options();
  abstract public function trace();
  abstract public function head();
  abstract public function connect();
  abstract public function patch();

  public function preferJson(){
    $this->preferType('application/json');
  }
  public function preferType($type){}
}
