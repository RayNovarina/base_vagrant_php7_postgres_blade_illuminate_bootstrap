<?php

# get session, run autoloader, install whoops exception handler, get AltoRouter instance.
include(__DIR__ . '/../bootstrap/start.php');

# Load runtime params from /.env file and store em in the server environment.
Dotenv::load(__DIR__ . '/../');

# connect to db via illuminate ORM.
include(__DIR__ . '/../bootstrap/db.php');

# Run http request thru our route definitions.
include(__DIR__ . '/../routes.php');

# Get and process the matching route, if any.
if ($match = $router->match()) {

  if (is_string($match['target'])) {
    // normal case. route maps to controller:method string.

    # assign all keys in array to variables. (controller name and action method name)
    # in target, i.e. route = PageController@getShowRegister
    list($controller, $method) = explode('@', $match['target']);

    # execute the controller method.
    if (is_callable(array($controller, $method))) {
      $object = new $controller();
      call_user_func_array(array($object, $method), array($match['params']));
    } else {
      echo "Routing error: Can not find $controller -> $method";
    }
  } else {
    // testing case. route maps to a inline test function.
    if (is_callable($match['target'])) {
      call_user_func_array($match['target'], $match['params']);
    } else {
      echo 'Routing error: inline function missing.';
    }
  }

} else {
  echo "Routing error: Can not find ANY matching route.";
}

?>
