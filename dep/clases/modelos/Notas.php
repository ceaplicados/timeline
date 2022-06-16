<?php
class Notas {

  public $Id;
  public $Suceso;
  public $Nota;
  public $CSS;
  public $BornBy;
  public $DateBorn;
  public $LastUpdate;

  function __construct() {
    $this->Id = NULL;
    $this->Suceso = NULL;
    $this->Nota = array();
    $this->CSS = NULL;
    $this->BornBy = NULL;
    $this->DateBorn = NULL;
    $this->LastUpdate = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getSuceso(){
    return $this->Suceso;
  }
  public function getNota(){
    return $this->Nota;
  }
  public function getCSS(){
    return $this->CSS;
  }
  public function getBornBy(){
    return $this->BornBy;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getLastUpdate(){
    return $this->LastUpdate;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setSuceso($Suceso){
    return $this->Suceso=$Suceso;
  }
  public function setNota($Nota){
    return $this->Nota=$Nota;
  }
  public function setCSS($CSS){
    return $this->CSS=$CSS;
  }
  public function setBornBy($BornBy){
    return $this->BornBy=$BornBy;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setLastUpdate($LastUpdate){
    return $this->LastUpdate=$LastUpdate;
  }

}