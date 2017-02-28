<?php
# All page loads start here. Because /usr/nginx/sites-available routes ALL password_get_info
# 80 requests to this page.

# NOTE: current directory, i.e. __DIR__ is vagrantProjects/public
#       require the classes that we will be using in other folders.
# see /composer.json autoload section for classmap array. Note that autoloader
# file must be regenerated after adding autoload section via 'composer dumpautoload'

# Need whoops package linkage.  flip/whoops is pretty exception handler dump formatter.
# Need /controller classes for routes.
require( __DIR__ . '/../vendor/autoload.php');


# Load in session object for all pages.
session_start();

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

# Alto Router is php http request router.
$router = new AltoRouter();

?>
