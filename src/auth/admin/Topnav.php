<?php

namespace Acme\helpers\Admin;

use Acme\auth\Roles;

class Topnav
{
  public static function picklist()
  {
    if (Roles::isAdmin() == false) {
      return '';
    }
    return "<li><a href=\"#\">Admin</a></li>";
  }

}

?>
