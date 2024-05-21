<?php 

namespace App\Validations;

use Config\Validation;

class MemberValidation {

  public function strongPassword ($pass, $fields, $data,string &$error = null):bool {
    if(!preg_match('#[0-9]#', $pass)){
      $error = 'The password must contain at least one number';
      return false;
    }elseif(!preg_match('#[A-Z]#', $pass)){
      $error = 'The password must contain at least one uppercase letter';
      return false;
    }elseif(!preg_match('#[a-z]#', $pass)){
      $error = 'The password must contain at least one lowercase';
      return false;
    }
    // elseif(!preg_match('#[!@#$%^&*]#', $pass)){
    //   $error = 'The password must contain at least one special character (! @ # $ % ^ & * ) ';
    //   return false;
    // }
    else{
      return true;
    }
  }

}

?>