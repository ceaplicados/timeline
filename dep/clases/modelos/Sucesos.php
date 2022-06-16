<?php
class Sucesos {

  public $Id;
  public $Timeline;
  public $Nombre;
  public $Descripcion;
  public $FechaIni;
  public $NivelDetalleFechaIni;
  public $FechaIni2;
  public $NivelDetalleFechaIni2;
  public $FechaFin;
  public $NivelDetalleFechaFin;
  public $FechaFin2;
  public $NivelDetalleFechaFin2;
  public $LastUpdate;
  public $Ligas;
  public $Notas;
  public $Archivos;

  function __construct() {
    $this->Id = NULL;
    $this->Timeline = NULL;
    $this->Nombre = NULL;
    $this->Descripcion = NULL;
    $this->FechaIni = NULL;
    $this->NivelDetalleFechaIni = NULL;
    $this->FechaIni2 = NULL;
    $this->NivelDetalleFechaIni2 = NULL;
    $this->FechaFin = NULL;
    $this->NivelDetalleFechaFin = NULL;
    $this->FechaFin2 = NULL;
    $this->NivelDetalleFechaFin2 = NULL;
    $this->LastUpdate = NULL;
    $this->Ligas = array();
    $this->Notas = array();
    $this->Archivos = array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getTimeline(){
    return $this->Timeline;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getDescripcion(){
    return $this->Descripcion;
  }
  public function getFechaIni(){
    return $this->FechaIni;
  }
  public function getNivelDetalleFechaIni(){
    return $this->NivelDetalleFechaIni;
  }
  public function getFechaIni2(){
    return $this->FechaIni2;
  }
  public function getNivelDetalleFechaIni2(){
    return $this->NivelDetalleFechaIni2;
  }
  public function getFechaFin(){
    return $this->FechaFin;
  }
  public function getNivelDetalleFechaFin(){
    return $this->NivelDetalleFechaFin;
  }
  public function getFechaFin2(){
    return $this->FechaFin2;
  }
  public function getNivelDetalleFechaFin2(){
    return $this->NivelDetalleFechaFin2;
  }
  public function getLastUpdate(){
    return $this->LastUpdate;
  }
  public function getLigas(){
    return $this->Ligas;
  }
  public function getNotas(){
    return $this->Notas;
  }
  public function getArchivos(){
    return $this->Archivos;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setTimeline($Timeline){
    return $this->Timeline=$Timeline;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setDescripcion($Descripcion){
    return $this->Descripcion=$Descripcion;
  }
  public function setFechaIni($FechaIni){
    return $this->FechaIni=$FechaIni;
  }
  public function setNivelDetalleFechaIni($NivelDetalleFechaIni){
    return $this->NivelDetalleFechaIni=$NivelDetalleFechaIni;
  }
  public function setFechaIni2($FechaIni2){
    return $this->FechaIni2=$FechaIni2;
  }
  public function setNivelDetalleFechaIni2($NivelDetalleFechaIni2){
    return $this->NivelDetalleFechaIni2=$NivelDetalleFechaIni2;
  }
  public function setFechaFin($FechaFin){
    return $this->FechaFin=$FechaFin;
  }
  public function setNivelDetalleFechaFin($NivelDetalleFechaFin){
    return $this->NivelDetalleFechaFin=$NivelDetalleFechaFin;
  }
  public function setFechaFin2($FechaFin2){
    return $this->FechaFin2=$FechaFin2;
  }
  public function setNivelDetalleFechaFin2($NivelDetalleFechaFin2){
    return $this->NivelDetalleFechaFin2=$NivelDetalleFechaFin2;
  }
  public function setLastUpdate($LastUpdate){
    return $this->LastUpdate=$LastUpdate;
  }
  public function setLigas($Ligas){
    return $this->Ligas=$Ligas;
  }
  public function setNotas($Notas){
    return $this->Notas=$Notas;
  }
  public function setArchivos($Archivos){
    return $this->Archivos=$Archivos;
  }
}