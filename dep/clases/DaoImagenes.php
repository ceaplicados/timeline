<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Imagenes.php';

class DaoImagenes extends time_base{

  public function add(Imagenes $Imagenes){
    $sql="INSERT INTO Imagenes (URL,Formato,Optimizada) VALUES (:URL,:Formato,:Optimizada);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':URL' => $Imagenes->getURL(), ':Formato' => $Imagenes->getFormato(), ':Optimizada' => $Imagenes->getOptimizada()));
      $Imagenes->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Imagenes;
  }

  public function update(Imagenes $Imagenes){
    $sql="UPDATE Imagenes SET URL=:URL, Formato=:Formato, Optimizada=:Optimizada WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Imagenes->getId(), ':URL' => $Imagenes->getURL(), ':Formato' => $Imagenes->getFormato(), ':Optimizada' => $Imagenes->getOptimizada()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Imagenes;
  }

  public function addOrUpdate(Imagenes $Imagenes){
    if($Imagenes->getId()>0){
      $Imagenes=$this->update($Imagenes);
    }else{
      $Imagenes=$this->add($Imagenes);
    }
    return $Imagenes;
  }

  public function delete($Id){
    $sql="DELETE FROM Imagenes  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Imagenes WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Imagenes=new Imagenes();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Imagenes=$this->createObject($result[0]);
    }
    return $Imagenes;
  }

  public function showAll(){
    $sql="SELECT * FROM Imagenes";
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
    $Imagenes=new Imagenes();
    $Imagenes->setId($row['Id']);
    $Imagenes->setURL($row['URL']);
    $Imagenes->setFormato($row['Formato']);
    $Imagenes->setOptimizada($row['Optimizada']);
    return $Imagenes;
  }


}