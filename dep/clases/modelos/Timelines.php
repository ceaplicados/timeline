<?php
class Timelines {

  public $Id;
  public $Nombre;
  public $Descripcion;
  public $Cliente;
  public $Nonce;
  public $DateBorn;
  public $CreatedBy;
  public $LastUpdated;
  public $Sucesos;
  public $fechaMin;
  public $fechaMax;

  function __construct() {
    $this->Id = NULL;
    $this->Nombre = NULL;
    $this->Descripcion = NULL;
    $this->Cliente = NULL;
    $this->Nonce = NULL;
    $this->DateBorn = NULL;
    $this->CreatedBy = NULL;
    $this->LastUpdated = NULL;
    $this->Sucesos = array();
    $this->fechaMin= NULL;
    $this->fechaMax= NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getDescripcion(){
    return $this->Descripcion;
  }
  public function getCliente(){
    return $this->Cliente;
  }
  public function getNonce(){
    return $this->Nonce;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getCreatedBy(){
    return $this->CreatedBy;
  }
  public function getLastUpdated(){
    return $this->LastUpdated;
  }
  public function getSucesos(){
    return $this->Sucesos;
  }
  public function getfechaMin(){
    return $this->fechaMin;
  }
  public function getfechaMax(){
    return $this->fechaMax;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setDescripcion($Descripcion){
    return $this->Descripcion=$Descripcion;
  }
  public function setCliente($Cliente){
    return $this->Cliente=$Cliente;
  }
  public function setNonce($Nonce){
    return $this->Nonce=$Nonce;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setCreatedBy($CreatedBy){
    return $this->CreatedBy=$CreatedBy;
  }
  public function setLastUpdated($LastUpdated){
    return $this->LastUpdated=$LastUpdated;
  }
  public function setSucesos($Sucesos){
    return $this->Sucesos=$Sucesos;
  }
  public function setfechaMin($fechaMin){
    return $this->fechaMin=$fechaMin;
  }
  public function setfechaMax($fechaMax){
    return $this->fechaMax=$fechaMax;
  }

}