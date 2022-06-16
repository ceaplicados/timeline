<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Notas.php';

class DaoNotas extends time_base{

  public function add(Notas $Notas){
    $sql="INSERT INTO Notas (Suceso,Nota,CSS,BornBy,DateBorn,LastUpdate) VALUES (:Suceso,:Nota,:CSS,:BornBy,:DateBorn,:LastUpdate);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Suceso' => $Notas->getSuceso(), ':Nota' => $Notas->getNota(), ':CSS' => json_encode($Notas->getCSS()), ':BornBy' => $Notas->getBornBy(), ':DateBorn' => $Notas->getDateBorn(), ':LastUpdate' => $Notas->getLastUpdate()));
      $Notas->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Notas;
  }

  public function update(Notas $Notas){
    $sql="UPDATE Notas SET Suceso=:Suceso, Nota=:Nota, CSS=:CSS, BornBy=:BornBy, DateBorn=:DateBorn, LastUpdate=:LastUpdate WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Notas->getId(), ':Suceso' => $Notas->getSuceso(), ':Nota' => $Notas->getNota(), ':CSS' => json_encode($Notas->getCSS()), ':BornBy' => $Notas->getBornBy(), ':DateBorn' => $Notas->getDateBorn(), ':LastUpdate' => $Notas->getLastUpdate()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Notas;
  }

  public function addOrUpdate(Notas $Notas){
    if($Notas->getId()>0){
      $Notas=$this->update($Notas);
    }else{
      $Notas=$this->add($Notas);
    }
    return $Notas;
  }

  public function delete($Id){
    $sql="DELETE FROM Notas  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Notas WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Notas=new Notas();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Notas=$this->createObject($result[0]);
    }
    return $Notas;
  }

  public function showAll(){
    $sql="SELECT * FROM Notas";
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
    $Notas=new Notas();
    $Notas->setId($row['Id']);
    $Notas->setSuceso($row['Suceso']);
    $Notas->setNota($row['Nota']);
    $Notas->setCSS(json_decode($row['CSS']));
    $Notas->setBornBy($row['BornBy']);
    $Notas->setDateBorn($row['DateBorn']);
    $Notas->setLastUpdate($row['LastUpdate']);
    return $Notas;
  }

  public function getBySuceso($Suceso){
	  $sql="SELECT * FROM Notas WHERE Suceso=$Suceso";
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