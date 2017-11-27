<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

define('DATABASE', 'rk633');
define('USERNAME', 'rk633');
define('PASSWORD', 'LKVWAEKo');
define('CONNECTION', 'sql.njit.edu');

class dbConn {
protected static $db;
  private function __construct() {
       try  {
	     self::$db = new PDO( 'mysql:host=' . CONNECTION . ';dbname='
	     . DATABASE, USERNAME, PASSWORD );
	     self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	     echo 'Connection Successful<br>';
	}
	catch (PDOException $e)  {
	     echo "Connection Error:" . $e->getMessage();
	}
}

  public static function getConnection()  {
       if (!self::$db)  {
         new dbConn();
       }
       return self::$db;
  }
}


class collection  {
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
   class accounts extends collection  {
      public static $modelName = 'account';
   }

   class todos extends collection  {
      public static $modelName = 'todo';
   }

   class model  {
      protected $table;
      public function save()  {
       if ($this->id == '')  {
	   $this->insert();

	} else {
	   $this->update($this->id);
	} 
      }

   public function insert()  {
     $db = dbConn::getConnection();
     $table = $this->table;
     $arr = get_object_vars($this);
     array_pop($arr);
     $heading = array_keys($arr);
     $columnString = implode(',',$heading);
     $valueString = ':' . implode(',:',$heading);
     $query = 'INSERT INTO ' . $table . ' (' . $columnString . ') VALUES (' .
     $valueString . ')';
     $stmt = $db->prepare($query);
     $stmt->execute($arr);
   }

   public function update($id)  {
    $db = dbConn::getConnection();
    $table = $this->table;
    $arr = get_object_vars($this);
    array_pop($arr);
    $heading = array_keys($arr);
    $Array = array();
    $Value = array();
    foreach($arr as $key=> $value)  {
       if($value!='')  {
          array_push($Value, $key . '=' . ':' . $key);
	  $Array[$key] = $value;
       }
    }
    $str = implode(',',$Value);
    $query = 'UPDATE ' . $table . ' SET ' . $str . ' WHERE id=' .$id;
    $stmt = $db->prepare($query);
    $stmt->execute($Array);
  }
  
  public function delete($id)  {
    $db = dbConn::getConnection();
    $table = $this->table;
    $query = 'DELETE FROM ' . $table . ' WHERE id= ' . $id;
    $stmt = $db->prepare($query);
    $stmt->execute();
    echo '<h2>Row with id = ' . $id . ' deleted successfully<br></h2>';
  }

  public function getHeading()  {
    $table = $this->table;
    $query = 'SHOW COLUMNS FROM ' . $table;
    $db = dbConn::getConnection();
    $stmt = $db->prepare($query);
    $stmt->execute();
    $heading = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $heading;
    }
}

class account extends model  {
   public $id;
   public $email;
   public $fname;
   public $lname;
   public $phone;
   public $birthday;
   public $gender;
   public $password;

   public function __construct() {
      $this->table = 'accounts';
   }
}

class todo extends model  {
   public $id;
   public $owneremail;
   public $ownerid;
   public $createddate;
   public $duedate;
   public $message;
   public $isdone;

   public function __construct()
   {
       $this->table = 'todos';
   }
}

class table  {
   static public function create($heading,$rows)  {
   $table = NULL;
   $table .="<table border = 1>";
   foreach ($heading as $head)  {
     $table .= "<th>$head</th>";
   }
   foreach ($rows as $row)  {
     $table .= "<tr>";
     foreach ($row as $column)  {
       $table .= "<td>$column</td>";
     }
     $table .= "</tr>";
   }
   $table .= "</table>";
   echo $table;
   }
}

accounts::create();
$records = accounts::findAll();
$record = accounts::findOne(1);
$rec = new account();
$heading = $rec->getHeading();
//echo '<center>';
echo '<h2> FindAll() Function on Accounts Table</h2>';
echo table::create($heading,$records);
$rec2 = accounts::findOne(10);
echo '<h2> FindOne Function on Accounts Table</h2>';
echo table::create($heading,$rec2);
$rec->fname = 'Maria';
$rec->lname = 'Jones';
$rec->insert();
$rec2 = accounts::findOne(671);
echo '<h2>Inserted values fname=Maria and lname=Jones into accounts table</h2>';
echo table::create($heading,$rec2);
$rec->phone = '8628728399';
$rec->update(10);
$rec2 = accounts::findOne(10);
echo '<h2> Updated the values of phone where id=10 in the accounts table</h2>';
echo table::create($heading,$rec2);
$rec->delete(8);
$acc = accounts::findAll();
echo table::create($heading,$acc);

todos::create();
$records = todos::findAll();
$val = new todo();
$heading = $val->getHeading();
echo '<h2> FindAll() Function on Todos Table</h2>';
echo table::create($heading,$records);
$val->ownerid = '5';
$val->message = 'Bootstrapping program';
$val->isdone = '0';
$val->id = '2345';
$val->save();
$todo = todos::findAll();
echo '<h2> Save() Function on Todos Table executed Succesfully</h2>';
echo table::create($heading,$todo);
//echo '</center>';
?> 

















