<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Cliente.php';

class DaoCliente extends time_base{

  public function add(Cliente $Cliente){
    $sql="INSERT INTO Cliente (Nombre,DateBorn,Activo,RefCode,ReferidoPor,UID,Vencimiento) VALUES (:Nombre,:DateBorn,:Activo,:RefCode,:ReferidoPor,:UID,:Vencimiento);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Nombre' => $Cliente->getNombre(), ':DateBorn' => $Cliente->getDateBorn(), ':Activo' => $Cliente->getActivo(), ':RefCode' => $Cliente->getRefCode(), ':ReferidoPor' => $Cliente->getReferidoPor(), ':UID' => $Cliente->getUID(), ':Vencimiento' => $Cliente->getVencimiento()));
      $Cliente->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Cliente;
  }

  public function update(Cliente $Cliente){
    $sql="UPDATE Cliente SET Nombre=:Nombre, DateBorn=:DateBorn, Activo=:Activo, RefCode=:RefCode, ReferidoPor=:ReferidoPor, UID=:UID, Vencimiento=:Vencimiento WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Cliente->getId(), ':Nombre' => $Cliente->getNombre(), ':DateBorn' => $Cliente->getDateBorn(), ':Activo' => $Cliente->getActivo(), ':RefCode' => $Cliente->getRefCode(), ':ReferidoPor' => $Cliente->getReferidoPor(), ':UID' => $Cliente->getUID(), ':Vencimiento' => $Cliente->getVencimiento()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Cliente;
  }

  public function addOrUpdate(Cliente $Cliente){
    if($Cliente->getId()>0){
      $Cliente=$this->update($Cliente);
    }else{
      $Cliente=$this->add($Cliente);
    }
    return $Cliente;
  }

  public function delete($Id){
    $sql="DELETE FROM Cliente  WHERE  Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return true;
  }

  public function show($Id){
    $sql="SELECT * FROM Cliente WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Cliente=new Cliente();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Cliente=$this->createObject($result[0]);
    }
    return $Cliente;
  }

  public function showAll(){
    $sql="SELECT * FROM Cliente";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $resp=array();
    foreach($sth->fetchAll() as $row){
      array_push($resp,$this->createObject($row));
    }
    return $resp;
  }

  public function advancedQuery($sql){
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $resp=array();
    foreach($sth->fetchAll() as $row){
      array_push($resp,$this->createObject($row));
    }
    return $resp;
  }

  public function createObject($row){
    $Cliente=new Cliente();
    $Cliente->setId($row['Id']);
    $Cliente->setNombre($row['Nombre']);
    $Cliente->setDateBorn($row['DateBorn']);
    $Cliente->setActivo($row['Activo']);
    $Cliente->setRefCode($row['RefCode']);
    $Cliente->setReferidoPor($row['ReferidoPor']);
    $Cliente->setUID($row['UID']);
    $Cliente->setVencimiento($row['Vencimiento']);
    return $Cliente;
  }
  
  public function getByUsuario($Usuario){
    $sql="SELECT Cliente.* FROM Cliente JOIN UsuariosCliente ON UsuariosCliente.Cliente=Cliente.Id WHERE Usuario=$Usuario";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $resp=array();
    foreach($sth->fetchAll() as $row){
      array_push($resp,$this->createObject($row));
    }
    return $resp;
  }

}