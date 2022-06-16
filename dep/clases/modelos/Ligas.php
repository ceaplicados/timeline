<?php
class Ligas {

  public $Id;
  public $URL;
  public $Title;
  public $Descripcion;
  public $Imagen;
  public $FechaPublicacion;
  public $FechaIni;
  public $NivelDetalleFechaIni;
  public $FechaFin;
  public $NivelDetalleFechaFin;
  public $BornDate;
  public $BornBy;

  function __construct() {
    $this->Id = NULL;
    $this->URL = NULL;
    $this->Title = NULL;
    $this->Descripcion = NULL;
    $this->Imagen = NULL;
    $this->FechaPublicacion = NULL;
    $this->FechaIni = NULL;
    $this->NivelDetalleFechaIni = NULL;
    $this->FechaFin = NULL;
    $this->NivelDetalleFechaFin = NULL;
    $this->BornDate = NULL;
    $this->BornBy = NULL;
  }

  public function getId(){
    return $this->Id;
  }
  public function getURL(){
    return $this->URL;
  }
  public function getTitle(){
    return $this->Title;
  }
  public function getDescripcion(){
    return $this->Descripcion;
  }
  public function getImagen(){
    return $this->Imagen;
  }
  public function getFechaPublicacion(){
    return $this->FechaPublicacion;
  }
  public function getFechaIni(){
    return $this->FechaIni;
  }
  public function getNivelDetalleFechaIni(){
    return $this->NivelDetalleFechaIni;
  }
  public function getFechaFin(){
    return $this->FechaFin;
  }
  public function getNivelDetalleFechaFin(){
    return $this->NivelDetalleFechaFin;
  }
  public function getBornDate(){
    return $this->BornDate;
  }
  public function getBornBy(){
    return $this->BornBy;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setURL($URL){
    return $this->URL=$URL;
  }
  public function setTitle($Title){
    return $this->Title=$Title;
  }
  public function setDescripcion($Descripcion){
    return $this->Descripcion=$Descripcion;
  }
  public function setImagen($Imagen){
    return $this->Imagen=$Imagen;
  }
  public function setFechaPublicacion($FechaPublicacion){
    return $this->FechaPublicacion=$FechaPublicacion;
  }
  public function setFechaIni($FechaIni){
    return $this->FechaIni=$FechaIni;
  }
  public function setNivelDetalleFechaIni($NivelDetalleFechaIni){
    return $this->NivelDetalleFechaIni=$NivelDetalleFechaIni;
  }
  public function setFechaFin($FechaFin){
    return $this->FechaFin=$FechaFin;
  }
  public function setNivelDetalleFechaFin($NivelDetalleFechaFin){
    return $this->NivelDetalleFechaFin=$NivelDetalleFechaFin;
  }
  public function setBornDate($BornDate){
    return $this->BornDate=$BornDate;
  }
  public function setBornBy($BornBy){
    return $this->BornBy=$BornBy;
  }

}