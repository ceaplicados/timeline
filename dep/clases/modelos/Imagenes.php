<?php
class Imagenes {

  public $Id;
  public $URL;
  public $Formato;
  public $Optimizada;

  function __construct() {
    $this->Id = NULL;
    $this->URL = NULL;
    $this->Formato = NULL;
    $this->Optimizada = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getURL(){
    return $this->URL;
  }
  public function getFormato(){
    return $this->Formato;
  }
  public function getOptimizada(){
    return $this->Optimizada;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setURL($URL){
    return $this->URL=$URL;
  }
  public function setFormato($Formato){
    return $this->Formato=$Formato;
  }
  public function setOptimizada($Optimizada){
    return $this->Optimizada=$Optimizada;
  }

}