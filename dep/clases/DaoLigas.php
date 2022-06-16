<?php
require_once 'modelos/time_base.php';
require_once 'modelos/Ligas.php';

class DaoLigas extends time_base{

  public function add(Ligas $Ligas){
    $sql="INSERT INTO Ligas (URL,Title,Descripcion,Imagen,FechaPublicacion,FechaIni,NivelDetalleFechaIni,FechaFin,NivelDetalleFechaFin,BornDate,BornBy) VALUES (:URL,:Title,:Descripcion,:Imagen,:FechaPublicacion,:FechaIni,:NivelDetalleFechaIni,:FechaFin,:NivelDetalleFechaFin,:BornDate,:BornBy);";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':URL' => $Ligas->getURL(), ':Title' => $Ligas->getTitle(), ':Descripcion' => $Ligas->getDescripcion(), ':Imagen' => $Ligas->getImagen(), ':FechaPublicacion' => $Ligas->getFechaPublicacion(), ':FechaIni' => $Ligas->getFechaIni(), ':NivelDetalleFechaIni' => $Ligas->getNivelDetalleFechaIni(), ':FechaFin' => $Ligas->getFechaFin(), ':NivelDetalleFechaFin' => $Ligas->getNivelDetalleFechaFin(), ':BornDate' => $Ligas->getBornDate(), ':BornBy' => $Ligas->getBornBy()));
      $Ligas->setId($this->_dbh->lastInsertId());
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Ligas;
  }

  public function update(Ligas $Ligas){
    $sql="UPDATE Ligas SET URL=:URL, Title=:Title, Descripcion=:Descripcion, Imagen=:Imagen, FechaPublicacion=:FechaPublicacion, FechaIni=:FechaIni, NivelDetalleFechaIni=:NivelDetalleFechaIni, FechaFin=:FechaFin, NivelDetalleFechaFin=:NivelDetalleFechaFin, BornDate=:BornDate, BornBy=:BornBy WHERE  Id=:Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute(array(':Id' => $Ligas->getId(), ':URL' => $Ligas->getURL(), ':Title' => $Ligas->getTitle(), ':Descripcion' => $Ligas->getDescripcion(), ':Imagen' => $Ligas->getImagen(), ':FechaPublicacion' => $Ligas->getFechaPublicacion(), ':FechaIni' => $Ligas->getFechaIni(), ':NivelDetalleFechaIni' => $Ligas->getNivelDetalleFechaIni(), ':FechaFin' => $Ligas->getFechaFin(), ':NivelDetalleFechaFin' => $Ligas->getNivelDetalleFechaFin(), ':BornDate' => $Ligas->getBornDate(), ':BornBy' => $Ligas->getBornBy()));
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    return $Ligas;
  }

  public function addOrUpdate(Ligas $Ligas){
    if($Ligas->getId()>0){
      $Ligas=$this->update($Ligas);
    }else{
      $Ligas=$this->add($Ligas);
    }
    return $Ligas;
  }

  public function delete($Id){
    $sql="DELETE FROM Ligas  WHERE  Id=$Id;";
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
    $sql="SELECT * FROM Ligas WHERE Id=$Id;";
    try {
      $sth=$this->_dbh->prepare($sql);
      $sth->execute();
    } catch (Exception $e) {
      var_dump($e);
      echo($sql);
    }
    $Ligas=new Ligas();
    $result=$sth->fetchAll();
    if(count($result)>0){
      $Ligas=$this->createObject($result[0]);
    }
    return $Ligas;
  }

  public function showAll(){
    $sql="SELECT * FROM Ligas";
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
    $Ligas=new Ligas();
    $Ligas->setId($row['Id']);
    $Ligas->setURL($row['URL']);
    $Ligas->setTitle($row['Title']);
    $Ligas->setDescripcion($row['Descripcion']);
    $Ligas->setImagen($row['Imagen']);
    $Ligas->setFechaPublicacion($row['FechaPublicacion']);
    $Ligas->setFechaIni($row['FechaIni']);
    $Ligas->setNivelDetalleFechaIni($row['NivelDetalleFechaIni']);
    $Ligas->setFechaFin($row['FechaFin']);
    $Ligas->setNivelDetalleFechaFin($row['NivelDetalleFechaFin']);
    $Ligas->setBornDate($row['BornDate']);
    $Ligas->setBornBy($row['BornBy']);
    return $Ligas;
  }

  public function getBySuceso($Suceso){
    $sql="SELECT Ligas.* FROM Ligas JOIN LigasSucesos ON LigasSucesos.Liga=Ligas.Id WHERE Suceso=$Suceso ORDER BY FechaIni";
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