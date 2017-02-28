<?php

namespace Acme\models;

# alias to /vendor/Illuminate .....
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserPending extends Eloquent
{
  // tutorial author doesnt like default Eloquent naming convention that would
  // refer to this table as 'user_pendings' so we override.
  protected $table = 'users_pending';
  
}
