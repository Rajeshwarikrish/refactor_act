<?php
namespace classes\collection;
use classes\collection\accounts;
use classes\collection\todos;
use classes\db\dbConn;
use \PDO;

abstract class collection  {
   /*static public function create()  {
     $model = new static::$modelName;
     return $model;
   }*/
   

   static public function findAll()  {
      $db = dbConn::getConnection();
      $tableName = get_called_class();
      $tableName = str_replace('classes\collection\\','',$tableName);
      $sql = 'SELECT * FROM ' . $tableName;
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $class = static::$modelName;
      $stmt->setFetchMode();
      $recordSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $recordSet;
   }

   static public function findOne($id)  {
      $db = dbConn::getConnection();
      $tableName = get_called_class();
      $tableName = str_replace('classes\collection\\','',$tableName);
      $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $class = static::$modelName;
      $stmt->setFetchMode();
      $recordSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $recordSet;
   }
}
?>