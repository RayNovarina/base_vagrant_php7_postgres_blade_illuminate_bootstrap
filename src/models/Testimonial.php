<?php

namespace Acme\models;

# alias to /vendor/Illuminate .....
use Illuminate\Database\Eloquent\Model as Eloquent;

class Testimonial extends Eloquent
{
  public function user()
  {
    return $this->hasOne('Acme\models\User');
  }
}
