<?php
# Alto Router is php http request router, i.e. $router = new AltoRouter();

# Define map of http requests to web pages.
#       http Verb     Url                 Target: controller@method                                       Route name for path
// RegisterController routes
$router->map('GET',   '/register',          'Acme\controllers\RegisterController@getShowRegisterPage',      'register');
$router->map('POST',  '/register',          'Acme\controllers\RegisterController@postShowRegisterPage',     'register_post');
$router->map('GET',   '/verify-account',    'Acme\controllers\RegisterController@getVerifyAccount',         'verify_account');

// TestimonialController routes
// $router->map('GET',   '/testimonials',      'Acme\controllers\TestimonialController@getShowTestimonials',   'testimonials');
// $router->map('GET',   '/testimonial/[*]',   'Acme\controllers\TestimonialController@getShowTestimonial',    'testimonial');

// AuthenticationController routes
$router->map('GET',   '/login',             'Acme\controllers\AuthenticationController@getShowLoginPage',   'login');
$router->map('POST',  '/login',             'Acme\controllers\AuthenticationController@postShowLoginPage',  'login_post');
$router->map('GET',   '/logout',            'Acme\controllers\AuthenticationController@getLogout',          'logout');

// admin routes
if (Acme\auth\Roles::isAdmin()) {
  $router->map('POST',  '/admin/page/edit', 'Acme\controllers\AdminController@postSavePage',                'save_page');
  $router->map('GET',  '/admin/page/add',  'Acme\controllers\AdminController@getAddPage',                   'add_page');
}

// NOT: put route to '/' last because matcher will stop at first match.
// PageController routes
$router->map('GET',   '/page-not-found',    'Acme\controllers\PageController@getShow404',                   '404');
// NOTE: GET/[*] catches any unknown routes and looks in our DB for a html page else page-not-found.
$router->map('GET',   '/[*]',               'Acme\controllers\PageController@getShowDbPage',                'generic_db_page');
$router->map('GET',   '/',                  'Acme\controllers\PageController@getShowHomePage',              'home');

?>
