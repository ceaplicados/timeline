<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Sucesos.php';

class DaoSucesos extends time_base{

  public function add(Sucesos $Sucesos){
    $sql="INSERT INTO Sucesos (Timeline,Nombre,Descripcion,FechaIni,NivelDetalleFechaIni,FechaIni2,NivelDetalleFechaIni2,FechaFin,NivelDetalleFechaFin,FechaFin2,NivelDetalleFechaFin2,LastUpdate) VALUES (:Timeline,:Nombre,:Descripcion,:FechaIni,:NivelDetalleFechaIni,:FechaIni2,:NivelDetalleFechaIni2,:FechaFin,:NivelDetalleFechaFin,:FechaFin2,:NivelDetalleFechaFin2,:LastUpdate);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Timeline' => $Sucesos->getTimeline(), ':Nombre' => $Sucesos->getNombre(), ':Descripcion' => $Sucesos->getDescripcion(), ':FechaIni' => $Sucesos->getFechaIni(), ':NivelDetalleFechaIni' => $Sucesos->getNivelDetalleFechaIni(), ':FechaIni2' => $Sucesos->getFechaIni2(), ':NivelDetalleFechaIni2' => $Sucesos->getNivelDetalleFechaIni2(), ':FechaFin' => $Sucesos->getFechaFin(), ':NivelDetalleFechaFin' => $Sucesos->getNivelDetalleFechaFin(), ':FechaFin2' => $Sucesos->getFechaFin2(), ':NivelDetalleFechaFin2' => $Sucesos->getNivelDetalleFechaFin2(), ':LastUpdate' => $Sucesos->getLastUpdate()));
      $Sucesos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Sucesos;
  }

  public function update(Sucesos $Sucesos){
    $sql="UPDATE Sucesos SET Timeline=:Timeline, Nombre=:Nombre, Descripcion=:Descripcion, FechaIni=:FechaIni, NivelDetalleFechaIni=:NivelDetalleFechaIni, FechaIni2=:FechaIni2, NivelDetalleFechaIni2=:NivelDetalleFechaIni2, FechaFin=:FechaFin, NivelDetalleFechaFin=:NivelDetalleFechaFin, FechaFin2=:FechaFin2, NivelDetalleFechaFin2=:NivelDetalleFechaFin2, LastUpdate=:LastUpdate WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Sucesos->getId(), ':Timeline' => $Sucesos->getTimeline(), ':Nombre' => $Sucesos->getNombre(), ':Descripcion' => $Sucesos->getDescripcion(), ':FechaIni' => $Sucesos->getFechaIni(), ':NivelDetalleFechaIni' => $Sucesos->getNivelDetalleFechaIni(), ':FechaIni2' => $Sucesos->getFechaIni2(), ':NivelDetalleFechaIni2' => $Sucesos->getNivelDetalleFechaIni2(), ':FechaFin' => $Sucesos->getFechaFin(), ':NivelDetalleFechaFin' => $Sucesos->getNivelDetalleFechaFin(), ':FechaFin2' => $Sucesos->getFechaFin2(), ':NivelDetalleFechaFin2' => $Sucesos->getNivelDetalleFechaFin2(), ':LastUpdate' => $Sucesos->getLastUpdate()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Sucesos;
  }

  public function addOrUpdate(Sucesos $Sucesos){
    if($Sucesos->getId()>0){
      $Sucesos=$this->update($Sucesos);
    }else{
      $Sucesos=$this->add($Sucesos);
    }
    return $Sucesos;
  }

  public function delete($Id){
    $sql="DELETE FROM Sucesos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Sucesos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Sucesos=new Sucesos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Sucesos=$this->createObject($result[0]);
    }
    return $Sucesos;
  }

  public function showAll(){
    $sql="SELECT * FROM Sucesos";
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
    $Sucesos=new Sucesos();
    $Sucesos->setId($row['Id']);
    $Sucesos->setTimeline($row['Timeline']);
    $Sucesos->setNombre($row['Nombre']);
    $Sucesos->setDescripcion($row['Descripcion']);
    $Sucesos->setFechaIni($row['FechaIni']);
    $Sucesos->setNivelDetalleFechaIni($row['NivelDetalleFechaIni']);
    $Sucesos->setFechaIni2($row['FechaIni2']);
    $Sucesos->setNivelDetalleFechaIni2($row['NivelDetalleFechaIni2']);
    $Sucesos->setFechaFin($row['FechaFin']);
    $Sucesos->setNivelDetalleFechaFin($row['NivelDetalleFechaFin']);
    $Sucesos->setFechaFin2($row['FechaFin2']);
    $Sucesos->setNivelDetalleFechaFin2($row['NivelDetalleFechaFin2']);
    $Sucesos->setLastUpdate($row['LastUpdate']);
    return $Sucesos;
  }

  public function getByTimeline($Timeline){
    $sql="SELECT * FROM Sucesos WHERE Timeline=$Timeline ORDER BY FechaIni";
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