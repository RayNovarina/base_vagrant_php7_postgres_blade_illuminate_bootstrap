<?php
# load/alias Manager.php file from /vendor/illuminate/database/capsule folder.
use Illuminate\Database\Capsule\Manager as Capsule;

# create new Manager instance.
$capsule = new Capsule;

# create connection to db. use env variables.
$capsule->addconnection([
    'driver'      => getenv('DB_DRIVER'),
    'host'        => getenv('DB_HOST'),
    'database'    => getenv('DB_DATABASE'),
    'username'    => getenv('DB_USER'),
    'password'    => getenv('DB_PASS'),
    'charset'     => 'utf8',
    'collation'   => 'utf8_unicode_ci',
    'prefix'      => ''
]);

# "boot that"
$capsule->setAsGlobal();
$capsule->bootEloquent();

?>
