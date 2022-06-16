<?php
class LigasSucesos {

  public $Id;
  public $Liga;
  public $Suceso;
  public $Nota;

  function __construct() {
    $this->Id = NULL;
    $this->Liga = NULL;
    $this->Suceso = NULL;
    $this->Nota = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getLiga(){
    return $this->Liga;
  }
  public function getSuceso(){
    return $this->Suceso;
  }
  public function getNota(){
    return $this->Nota;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setLiga($Liga){
    return $this->Liga=$Liga;
  }
  public function setSuceso($Suceso){
    return $this->Suceso=$Suceso;
  }
  public function setNota($Nota){
    return $this->Nota=$Nota;
  }

}