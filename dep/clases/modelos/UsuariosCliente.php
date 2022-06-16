<?php
class UsuariosCliente {

  public $Usuario;
  public $Cliente;
  public $BornBy;
  public $BornByTipo;
  public $DateBorn;
  public $DateDie;

  function __construct() {
    $this->Usuario = NULL;
    $this->Cliente = NULL;
    $this->BornBy = NULL;
    $this->BornByTipo = NULL;
    $this->DateBorn = NULL;
    $this->DateDie = NULL;
  }

  public function getUsuario(){
    return $this->Usuario;
  }
  public function getCliente(){
    return $this->Cliente;
  }
  public function getBornBy(){
    return $this->BornBy;
  }
  public function getBornByTipo(){
    return $this->BornByTipo;
  }
  public function getDateBorn(){
    return $this->DateBorn;
  }
  public function getDateDie(){
    return $this->DateDie;
  }

  public function setUsuario($Usuario){
    return $this->Usuario=$Usuario;
  }
  public function setCliente($Cliente){
    return $this->Cliente=$Cliente;
  }
  public function setBornBy($BornBy){
    return $this->BornBy=$BornBy;
  }
  public function setBornByTipo($BornByTipo){
    return $this->BornByTipo=$BornByTipo;
  }
  public function setDateBorn($DateBorn){
    return $this->DateBorn=$DateBorn;
  }
  public function setDateDie($DateDie){
    return $this->DateDie=$DateDie;
  }

}