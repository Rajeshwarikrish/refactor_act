<?php
abstract class collection  {
   static public function create()  {
     $model = new static::$modelName;
     return $model;
   }

   static public function findAll()  {
      $db = dbConn::getConnection();
      $tableName = get_called_class();
      $sql = 'SELECT * FROM ' . $tableName;
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $class = static::$modelName;
      $stmt->setFetchMode(PDO::FETCH_CLASS,$class);
      $recordSet = $stmt->fetchAll();
      return $recordSet;
   }

   static public function findOne($id)  {
      $db = dbConn::getConnection();
      $tableName = get_called_class();
      $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $class = static::$modelName;
      $stmt->setFetchMode(PDO::FETCH_CLASS,$class);
      $recordSet = $stmt->fetchAll();
      return $recordSet;
   }
}
?>