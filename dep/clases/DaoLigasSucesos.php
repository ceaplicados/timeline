<?php
require_once 'modelos/time_base.php';
require_once 'modelos/LigasSucesos.php';

class DaoLigasSucesos extends time_base{

  public function add(LigasSucesos $LigasSucesos){
    $sql="INSERT INTO LigasSucesos (Liga,Suceso,Nota) VALUES (:Liga,:Suceso,:Nota);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Liga' => $LigasSucesos->getLiga(), ':Suceso' => $LigasSucesos->getSuceso(), ':Nota' => $LigasSucesos->getNota()));
      $LigasSucesos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $LigasSucesos;
  }

  public function update(LigasSucesos $LigasSucesos){
    $sql="UPDATE LigasSucesos SET Liga=:Liga, Suceso=:Suceso, Nota=:Nota WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $LigasSucesos->getId(), ':Liga' => $LigasSucesos->getLiga(), ':Suceso' => $LigasSucesos->getSuceso(), ':Nota' => $LigasSucesos->getNota()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $LigasSucesos;
  }

  public function addOrUpdate(LigasSucesos $LigasSucesos){
    if($LigasSucesos->getId()>0){
      $LigasSucesos=$this->update($LigasSucesos);
    }else{
      $LigasSucesos=$this->add($LigasSucesos);
    }
    return $LigasSucesos;
  }

  public function delete($Id){
    $sql="DELETE FROM LigasSucesos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM LigasSucesos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $LigasSucesos=new LigasSucesos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $LigasSucesos=$this->createObject($result[0]);
    }
    return $LigasSucesos;
  }

  public function showAll(){
    $sql="SELECT * FROM LigasSucesos";
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
    $LigasSucesos=new LigasSucesos();
    $LigasSucesos->setId($row['Id']);
    $LigasSucesos->setLiga($row['Liga']);
    $LigasSucesos->setSuceso($row['Suceso']);
    $LigasSucesos->setNota($row['Nota']);
    return $LigasSucesos;
  }


}