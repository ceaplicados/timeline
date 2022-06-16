<?php
require_once 'modelos/time_base.php';
require_once 'modelos/AgrupacionesSucesosSucesos.php';

class DaoAgrupacionesSucesosSucesos extends time_base{

  public function add(AgrupacionesSucesosSucesos $AgrupacionesSucesosSucesos){
    $sql="INSERT INTO AgrupacionesSucesosSucesos (Agrupacion,Suceso) VALUES (:Agrupacion,:Suceso);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Agrupacion' => $AgrupacionesSucesosSucesos->getAgrupacion(), ':Suceso' => $AgrupacionesSucesosSucesos->getSuceso()));
      $AgrupacionesSucesosSucesos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $AgrupacionesSucesosSucesos;
  }

  public function update(AgrupacionesSucesosSucesos $AgrupacionesSucesosSucesos){
    $sql="UPDATE AgrupacionesSucesosSucesos SET Agrupacion=:Agrupacion, Suceso=:Suceso WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $AgrupacionesSucesosSucesos->getId(), ':Agrupacion' => $AgrupacionesSucesosSucesos->getAgrupacion(), ':Suceso' => $AgrupacionesSucesosSucesos->getSuceso()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $AgrupacionesSucesosSucesos;
  }

  public function addOrUpdate(AgrupacionesSucesosSucesos $AgrupacionesSucesosSucesos){
    if($AgrupacionesSucesosSucesos->getId()>0){
      $AgrupacionesSucesosSucesos=$this->update($AgrupacionesSucesosSucesos);
    }else{
      $AgrupacionesSucesosSucesos=$this->add($AgrupacionesSucesosSucesos);
    }
    return $AgrupacionesSucesosSucesos;
  }

  public function delete($Id){
    $sql="DELETE FROM AgrupacionesSucesosSucesos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM AgrupacionesSucesosSucesos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $AgrupacionesSucesosSucesos=new AgrupacionesSucesosSucesos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $AgrupacionesSucesosSucesos=$this->createObject($result[0]);
    }
    return $AgrupacionesSucesosSucesos;
  }

  public function showAll(){
    $sql="SELECT * FROM AgrupacionesSucesosSucesos";
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
    $AgrupacionesSucesosSucesos=new AgrupacionesSucesosSucesos();
    $AgrupacionesSucesosSucesos->setId($row['Id']);
    $AgrupacionesSucesosSucesos->setAgrupacion($row['Agrupacion']);
    $AgrupacionesSucesosSucesos->setSuceso($row['Suceso']);
    return $AgrupacionesSucesosSucesos;
  }


}