<?php
namespace Acme\auth;

use Acme\auth\LoggedIn;

class Roles
{
  public static function isAdmin()
  {
    $logged_in_user = LoggedIn::user();
    return $logged_in_user && $logged_in_user->access_level == 2;
  }
}


?>
