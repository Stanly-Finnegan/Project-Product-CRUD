<?php 
namespace App\Controllers\Helpers;

use App\Controllers\BaseController;

class HelpersController extends BaseController
{
    public function validateStatustoString($type,$item)
    {
      if(strtolower($type) === 'active'){
        switch ($item){
          case true:
            return 'Active';
          case false:
            return 'Non Active';
        }
      }
      else if(strtolower($type) === 'status'){
        switch ($item){
          case 0:
            return 'Pending';
          case 1:
            return 'Approve';
          case 2:
            return 'Reject';
        }
      }
      else if(strtolower($type) === 'paid'){
        switch ($item){
          case 0:
            return 'Pending';
          case 1:
            return 'Paid';
          case 2:
            return 'Cancel';
        }
      }
      else if(strtolower($type) === 'show'){
        switch ($item){
          case false:
            return 'Hide';
          case true:
            return 'Show';
        }
      }
    }
}

?>