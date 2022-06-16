<?php
class Archivos {

  public $Id;
  public $Suceso;
  public $DateBorn;
  public $BornBy;
  public $Servicio;
  public $Nombre;
  public $UID;
  public $URL;
  public $MimeType;
  public $Icon;
  public $Comentario;
  public $Data;

  function __construct() {
    $this->Id = NULL;
    $this->Suceso = NULL;
    $this->DateBorn = NULL;
    $this->BornBy = NULL;
    $this->Servicio = NULL;
    $this->Nombre = NULL;
    $this->UID = NULL;
    $this->URL = NULL;
    $this->MimeType = NULL;
    $this->Icon = NULL;
    $this->Comentario = NULL;
    $this->Data = array();
  }

  public function getId(){
    return $this->Id;
  }
  public function getSuceso(){
    return $this->Suceso;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getBornBy(){
    return $this->BornBy;
  }
  public function getServicio(){
    return $this->Servicio;
  }
  public function getNombre(){
    return $this->Nombre;
  }
  public function getUID(){
    return $this->UID;
  }
  public function getURL(){
    return $this->URL;
  }
  public function getMimeType(){
    return $this->MimeType;
  }
  public function getIcon(){
    return $this->Icon;
  }
  public function getComentario(){
    return $this->Comentario;
  }
  public function getData(){
    return $this->Data;
  }

  public function setId($Id){
    return $this->Id=$Id;
  }
  public function setSuceso($Suceso){
    return $this->Suceso=$Suceso;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setBornBy($BornBy){
    return $this->BornBy=$BornBy;
  }
  public function setServicio($Servicio){
    return $this->Servicio=$Servicio;
  }
  public function setNombre($Nombre){
    return $this->Nombre=$Nombre;
  }
  public function setUID($UID){
    return $this->UID=$UID;
  }
  public function setURL($URL){
    return $this->URL=$URL;
  }
  public function setMimeType($MimeType){
    return $this->MimeType=$MimeType;
  }
  public function setIcon($Icon){
    return $this->Icon=$Icon;
  }
  public function setComentario($Comentario){
    return $this->Comentario=$Comentario;
  }
  public function setData($Data){
    return $this->Data=$Data;
  }

}