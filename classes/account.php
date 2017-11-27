<?php
final class account extends model  {
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
?>