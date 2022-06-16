<?php
require_once 'modelos/time_base.php';
require_once 'modelos/AgrupacionesSucesos.php';

class DaoAgrupacionesSucesos extends time_base{

  public function add(AgrupacionesSucesos $AgrupacionesSucesos){
    $sql="INSERT INTO AgrupacionesSucesos (Nombre,Timeline) VALUES (:Nombre,:Timeline);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Nombre' => $AgrupacionesSucesos->getNombre(), ':Timeline' => $AgrupacionesSucesos->getTimeline()));
      $AgrupacionesSucesos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $AgrupacionesSucesos;
  }

  public function update(AgrupacionesSucesos $AgrupacionesSucesos){
    $sql="UPDATE AgrupacionesSucesos SET Nombre=:Nombre, Timeline=:Timeline WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $AgrupacionesSucesos->getId(), ':Nombre' => $AgrupacionesSucesos->getNombre(), ':Timeline' => $AgrupacionesSucesos->getTimeline()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $AgrupacionesSucesos;
  }

  public function addOrUpdate(AgrupacionesSucesos $AgrupacionesSucesos){
    if($AgrupacionesSucesos->getId()>0){
      $AgrupacionesSucesos=$this->update($AgrupacionesSucesos);
    }else{
      $AgrupacionesSucesos=$this->add($AgrupacionesSucesos);
    }
    return $AgrupacionesSucesos;
  }

  public function delete($Id){
    $sql="DELETE FROM AgrupacionesSucesos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM AgrupacionesSucesos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $AgrupacionesSucesos=new AgrupacionesSucesos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $AgrupacionesSucesos=$this->createObject($result[0]);
    }
    return $AgrupacionesSucesos;
  }

  public function showAll(){
    $sql="SELECT * FROM AgrupacionesSucesos";
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
    $AgrupacionesSucesos=new AgrupacionesSucesos();
    $AgrupacionesSucesos->setId($row['Id']);
    $AgrupacionesSucesos->setNombre($row['Nombre']);
    $AgrupacionesSucesos->setTimeline($row['Timeline']);
    return $AgrupacionesSucesos;
  }


}