<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Timelines.php';

class DaoTimelines extends time_base{

  public function add(Timelines $Timelines){
    do{
      $nonce=$this->nonce('',8);
      $nonceExists=$this->getByNonce($nonce);
    }while($nonceExists->getId()>0);
    $Timelines->setNonce($nonce);
    
    $sql="INSERT INTO Timelines (Nombre,Descripcion,Cliente,Nonce,DateBorn,CreatedBy,LastUpdated) VALUES (:Nombre,:Descripcion,:Cliente,:Nonce,:DateBorn,:CreatedBy,:LastUpdated);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Nombre' => $Timelines->getNombre(), ':Descripcion' => $Timelines->getDescripcion(), ':Cliente' => $Timelines->getCliente(), ':Nonce' => $Timelines->getNonce(), ':DateBorn' => $Timelines->getDateBorn(), ':CreatedBy' => $Timelines->getCreatedBy(), ':LastUpdated' => $Timelines->getLastUpdated()));
      $Timelines->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Timelines;
  }

  public function update(Timelines $Timelines){
    $sql="UPDATE Timelines SET Nombre=:Nombre, Descripcion=:Descripcion, Cliente=:Cliente, Nonce=:Nonce, DateBorn=:DateBorn, CreatedBy=:CreatedBy, LastUpdated=:LastUpdated WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Timelines->getId(), ':Nombre' => $Timelines->getNombre(), ':Descripcion' => $Timelines->getDescripcion(), ':Cliente' => $Timelines->getCliente(), ':Nonce' => $Timelines->getNonce(), ':DateBorn' => $Timelines->getDateBorn(), ':CreatedBy' => $Timelines->getCreatedBy(), ':LastUpdated' => $Timelines->getLastUpdated()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Timelines;
  }

  public function addOrUpdate(Timelines $Timelines){
    if($Timelines->getId()>0){
      $Timelines=$this->update($Timelines);
    }else{
      $Timelines=$this->add($Timelines);
    }
    return $Timelines;
  }

  public function delete($Id){
    $sql="DELETE FROM Timelines  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Timelines WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Timelines=new Timelines();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Timelines=$this->createObject($result[0]);
    }
    return $Timelines;
  }

  public function showAll(){
    $sql="SELECT * FROM Timelines";
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
    $Timelines=new Timelines();
    $Timelines->setId($row['Id']);
    $Timelines->setNombre($row['Nombre']);
    $Timelines->setDescripcion($row['Descripcion']);
    $Timelines->setCliente($row['Cliente']);
    $Timelines->setNonce($row['Nonce']);
    $Timelines->setDateBorn($row['DateBorn']);
    $Timelines->setCreatedBy($row['CreatedBy']);
    $Timelines->setLastUpdated($row['LastUpdated']);
    return $Timelines;
  }
  
  public function getByCliente($Cliente){
    $sql="SELECT * FROM Timelines WHERE Cliente=$Cliente";
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
  
  public function getByNonce($Nonce){
    $sql="SELECT * FROM Timelines WHERE Nonce='$Nonce';";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Timelines=new Timelines();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Timelines=$this->createObject($result[0]);
    }
    return $Timelines;
  }
  
  public function getFechaMin($Timeline){
    $sql="SELECT MIN(FechaIni) AS FechaMin FROM Sucesos WHERE Timeline=$Timeline";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Timelines=new Timelines();
    $result=$sth->fetchAll();
    $fechaMin=NULL;
    if(count($result)>0){
      $fechaMin=$result[0]["FechaMin"];
    }
    return $fechaMin;
  }
  public function getFechaMax($Timeline){
    $sql="SELECT MAX(FechaFin) AS FechaMax,MAX(FechaFin2) AS FechaMax2 FROM Sucesos WHERE Timeline=$Timeline";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Timelines=new Timelines();
    $result=$sth->fetchAll();
    $fechaMin=NULL;
    if(count($result)>0){
      $fechaMin=$result[0]["FechaMax"];
      if($result[0]["FechaMax2"]){
        $fechaMin=$result[0]["FechaMax2"];
      }
    }
    return $fechaMin;
  }

}