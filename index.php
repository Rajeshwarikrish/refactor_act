<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
/*include 'dbConn.php';
include 'collection.php';
include 'model.php';
include 'table.php';
*/

class myLoader {
  public static function autoload($class) {
    include 'classes/' . $class . '.php';
  }
}

spl_autoload_register(array('myLoader', 'autoload'));


accounts::create();
$records = accounts::findAll();
$record = accounts::findOne(1);
$rec = new account();
$heading = $rec->getHeading();
//echo '<center>';
echo '<h2> FindAll() Function on Accounts Table</h2>';
echo table::create($heading,$records);
$rec2 = accounts::findOne(10);
echo '<hr><h2> FindOne Function on Accounts Table where id = 10</h2>';
echo table::create($heading,$rec2);
$rec->fname = 'Maria';
$rec->lname = 'Jones';
$rec->insert();
$rec2 = accounts::findOne(671);
echo '<hr><h2>Inserted values fname=Maria and lname=Jones into accounts table</h2>';
echo table::create($heading,$rec2);
$rec->phone = '8628728399';
$rec->update(10);
$rec2 = accounts::findOne(10);
echo '<hr><h2> Updated the values of phone where id=10 in the accounts table</h2>';
echo table::create($heading,$rec2);
$rec->delete(8);
$acc = accounts::findAll();
echo table::create($heading,$acc);

todos::create();
$records = todos::findAll();
$val = new todo();
$heading = $val->getHeading();
echo '<hr><h2> FindAll() Function on Todos Table</h2>';
echo table::create($heading,$records);
$val->ownerid = '5';
$val->message = 'Bootstrapping program';
$val->isdone = '0';
$val->id = '2345';
$val->save();
$todo = todos::findAll();
echo '<hr><h2> Save() Function on Todos Table executed Succesfully</h2>';
echo table::create($heading,$todo);
//echo '</center>';
?> 

















