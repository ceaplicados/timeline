<?php
class Cliente {

  public $Id;
  public $Nombre;
  public $DateBorn;
  public $Activo;
  public $RefCode;
  public $ReferidoPor;
  public $UID;
  public $Vencimiento;

  function __construct() {
    $this->Id = NULL;
    $this->Nombre = NULL;
    $this->DateBorn = NULL;
    $this->Activo = NULL;
    $this->RefCode = NULL;
    $this->ReferidoPor = NULL;
    $this->UID = NULL;
    $this->Vencimiento = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getActivo(){
    return $this->Activo;
  }
  public function getRefCode(){
    return $this->RefCode;
  }
  public function getReferidoPor(){
    return $this->ReferidoPor;
  }
  public function getUID(){
    return $this->UID;
  }
  public function getVencimiento(){
    return $this->Vencimiento;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setActivo($Activo){
    return $this->Activo=$Activo;
  }
  public function setRefCode($RefCode){
    return $this->RefCode=$RefCode;
  }
  public function setReferidoPor($ReferidoPor){
    return $this->ReferidoPor=$ReferidoPor;
  }
  public function setUID($UID){
    return $this->UID=$UID;
  }
  public function setVencimiento($Vencimiento){
    return $this->Vencimiento=$Vencimiento;
  }

}