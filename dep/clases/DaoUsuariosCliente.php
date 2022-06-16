<?php
require_once 'modelos/time_base.php';
require_once 'modelos/UsuariosCliente.php';

class DaoUsuariosCliente extends time_base{

  public function add(UsuariosCliente $UsuariosCliente){
    $sql="INSERT INTO UsuariosCliente (Cliente,BornBy,BornByTipo,DateBorn,DateDie) VALUES (:Cliente,:BornBy,:BornByTipo,:DateBorn,:DateDie);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Cliente' => $UsuariosCliente->getCliente(), ':BornBy' => $UsuariosCliente->getBornBy(), ':BornByTipo' => $UsuariosCliente->getBornByTipo(), ':DateBorn' => $UsuariosCliente->getDateBorn(), ':DateDie' => $UsuariosCliente->getDateDie()));
      $UsuariosCliente->setUsuario($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $UsuariosCliente;
  }

  public function update(UsuariosCliente $UsuariosCliente){
    $sql="UPDATE UsuariosCliente SET Cliente=:Cliente, BornBy=:BornBy, BornByTipo=:BornByTipo, DateBorn=:DateBorn, DateDie=:DateDie WHERE  Usuario=:Usuario;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Usuario' => $UsuariosCliente->getUsuario(), ':Cliente' => $UsuariosCliente->getCliente(), ':BornBy' => $UsuariosCliente->getBornBy(), ':BornByTipo' => $UsuariosCliente->getBornByTipo(), ':DateBorn' => $UsuariosCliente->getDateBorn(), ':DateDie' => $UsuariosCliente->getDateDie()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $UsuariosCliente;
  }

  public function addOrUpdate(UsuariosCliente $UsuariosCliente){
    if($UsuariosCliente->getUsuario()>0){
      $UsuariosCliente=$this->update($UsuariosCliente);
    }else{
      $UsuariosCliente=$this->add($UsuariosCliente);
    }
    return $UsuariosCliente;
  }

  public function delete($Id){
    $sql="DELETE FROM UsuariosCliente  WHERE  Usuario=$Id;";
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
    $sql="SELECT * FROM UsuariosCliente WHERE Usuario=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $UsuariosCliente=new UsuariosCliente();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $UsuariosCliente=$this->createObject($result[0]);
    }
    return $UsuariosCliente;
  }

  public function showAll(){
    $sql="SELECT * FROM UsuariosCliente";
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
    $UsuariosCliente=new UsuariosCliente();
    $UsuariosCliente->setUsuario($row['Usuario']);
    $UsuariosCliente->setCliente($row['Cliente']);
    $UsuariosCliente->setBornBy($row['BornBy']);
    $UsuariosCliente->setBornByTipo($row['BornByTipo']);
    $UsuariosCliente->setDateBorn($row['DateBorn']);
    $UsuariosCliente->setDateDie($row['DateDie']);
    return $UsuariosCliente;
  }


}