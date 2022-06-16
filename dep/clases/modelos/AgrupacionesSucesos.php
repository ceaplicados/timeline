<?php
class AgrupacionesSucesos {

  public $Id;
  public $Nombre;
  public $Timeline;

  function __construct() {
    $this->Id = NULL;
    $this->Nombre = NULL;
    $this->Timeline = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getTimeline(){
    return $this->Timeline;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setTimeline($Timeline){
    return $this->Timeline=$Timeline;
  }

}