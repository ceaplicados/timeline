<?php
class AgrupacionesSucesosSucesos {

  public $Id;
  public $Agrupacion;
  public $Suceso;

  function __construct() {
    $this->Id = NULL;
    $this->Agrupacion = NULL;
    $this->Suceso = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getAgrupacion(){
    return $this->Agrupacion;
  }
  public function getSuceso(){
    return $this->Suceso;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setAgrupacion($Agrupacion){
    return $this->Agrupacion=$Agrupacion;
  }
  public function setSuceso($Suceso){
    return $this->Suceso=$Suceso;
  }

}