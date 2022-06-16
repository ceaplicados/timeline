<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Archivos.php';

class DaoArchivos extends time_base{

  public function add(Archivos $Archivos){
    $sql="INSERT INTO Archivos (Suceso,DateBorn,BornBy,Servicio,Nombre,UID,URL,MimeType,Icon,Comentario,Data) VALUES (:Suceso,:DateBorn,:BornBy,:Servicio,:Nombre,:UID,:URL,:MimeType,:Icon,:Comentario,:Data);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Suceso' => $Archivos->getSuceso(), ':DateBorn' => $Archivos->getDateBorn(), ':BornBy' => $Archivos->getBornBy(), ':Servicio' => $Archivos->getServicio(), ':Nombre' => $Archivos->getNombre(), ':UID' => $Archivos->getUID(), ':URL' => $Archivos->getURL(), ':MimeType' => $Archivos->getMimeType(), ':Icon' => $Archivos->getIcon(), ':Comentario' => $Archivos->getComentario(), ':Data' => json_encode($Archivos->getData())));
      $Archivos->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Archivos;
  }

  public function update(Archivos $Archivos){
    $sql="UPDATE Archivos SET Suceso=:Suceso, DateBorn=:DateBorn, BornBy=:BornBy, Servicio=:Servicio, Nombre=:Nombre, UID=:UID, URL=:URL, MimeType=:MimeType, Icon=:Icon, Comentario=:Comentario, Data=:Data WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Archivos->getId(), ':Suceso' => $Archivos->getSuceso(), ':DateBorn' => $Archivos->getDateBorn(), ':BornBy' => $Archivos->getBornBy(), ':Servicio' => $Archivos->getServicio(), ':Nombre' => $Archivos->getNombre(), ':UID' => $Archivos->getUID(), ':URL' => $Archivos->getURL(), ':MimeType' => $Archivos->getMimeType(), ':Icon' => $Archivos->getIcon(), ':Comentario' => $Archivos->getComentario(), ':Data' => json_encode($Archivos->getData())));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Archivos;
  }

  public function addOrUpdate(Archivos $Archivos){
    if($Archivos->getId()>0){
      $Archivos=$this->update($Archivos);
    }else{
      $Archivos=$this->add($Archivos);
    }
    return $Archivos;
  }

  public function delete($Id){
    $sql="DELETE FROM Archivos  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Archivos WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Archivos=new Archivos();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Archivos=$this->createObject($result[0]);
    }
    return $Archivos;
  }

  public function showAll(){
    $sql="SELECT * FROM Archivos";
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
    $Archivos=new Archivos();
    $Archivos->setId($row['Id']);
    $Archivos->setSuceso($row['Suceso']);
    $Archivos->setDateBorn($row['DateBorn']);
    $Archivos->setBornBy($row['BornBy']);
    $Archivos->setServicio($row['Servicio']);
    $Archivos->setNombre($row['Nombre']);
    $Archivos->setUID($row['UID']);
    $Archivos->setURL($row['URL']);
    $Archivos->setMimeType($row['MimeType']);
    $Archivos->setIcon($row['Icon']);
    $Archivos->setComentario($row['Comentario']);
    if(isset($row['Data'])){
      $Archivos->setData(json_decode($row['Data'],true));
    }
    return $Archivos;
  }
  
  public function getBySuceso($Suceso){
	  $sql="SELECT * FROM Archivos WHERE Suceso=$Suceso";
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