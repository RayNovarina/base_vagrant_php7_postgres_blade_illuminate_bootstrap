=============
var_dump($_SERVER);
exit();
dd($_url);
print_r($errors);
=============
Based on How to Create a Slack Interface for Your PHP Application tutorial at
https://code.tutsplus.com/tutorials/how-to-create-a-slack-interface-for-your-php-application--cms-25269
by Jarkko Laine21 Apr 2016

But first setting up PHP7/Laraval/Illuminate/Whoops dev environment in Vagrant
based on udemy Intoduction to Modern Programming with PHP
at: https://www.udemy.com/introduction-to-modern-programming-with-php/learn/v4/content

I. Setting up Dev environment:
1) vagrant init ubuntu/trusty64; vagrant up --provider virtualbox

Vagrantfile:

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 80,   host:  8080    # apache
  config.vm.network "forwarded_port", guest: 5432, host: 54320    # postgres
  config.vm.network "forwarded_port", guest: 3306, host: 33060    # mysql
  config.vm.network "forwarded_port", guest: 1080, host:  1080    # mailcatcher

end

2) download tutorial install zip, move /resources and install.sh to project root.
   ssh into vagrant vm. i.e. vagrant ssh
   cd to /vagrant and run install script: $ sh install.sh

x) Pauses for MariaDb install: root user password = 'secret'

x) has an install error for mailcatcher. I just ignored it because mailcatcher
   is already running on my dev system.

x) Vagrant commands of interest:
   vagrant halt
   vagrant up
   vagrant port
   vagrant ssh
     or ssh -l vagrant -p 2222 localhost
     Password is 'vagrant'

3) Install composer in VM /vagrant
   $ curl -sS https://getcomposer.org/installer | php
   $ sudo mv composer.phar /usr/local/bin/composer
   $ which composer
   $ composer init
    package name: rcn/slackforphp
    author: Ray Nova <Rnova94037@Gmail.com>
    no/no
    confirm - yes

  creates a /slackinterfaceforphp/composer.json file.

  5) Change webserver nginx to use /public folder
    $ cd /etc/nginx/
      cd sites-available
    $  sudo vi default
        'root/vagrant;'   change to 'root/vagrant/public;'
    Change nginx to forward all url requests to /index.php which will handle 404s, etc.
        'location/ { try_files $uri $uri/ =404; }' change to
        'location / {
            try_files $uri $uri/ /index.php?$query_string;
          }'
    $ sudo service nginx restart

  6) install some composer packages via https://packagist.org into projectRoot/vendor folder.
     a) flip/whoops  (excepton handler)
        install instuctions at github repository.
          vm/vagrant$ composer require filp/whoops
     b) vlucas/phpdotenv  (environment handler)
     c) illuminate/database  (ORM db interface)
        via edit of /composer.json:
        "require": {
            "filp/whoops": "^2.1",
            "vlucas/phpdotenv": "~1.1",
            "illuminate/database": "5.1.*",
        },
     d) OR wait till step 7.  vm/vagrant$ composer update
        also can use dumpautoload    Dumps the autoloader

  7) copy files from /Acme project to /SlackInterfaceForPhp
      .env
      .gitignore
      composer.json
      env.example
      phinx.yml
      phpunit.xml
      routes.php

  8) install the composer packages:
     vm/vagrant$ composer update
       composer.json now:
       {"_comment1": "Note: after running composer update for illuminate 5.1.* i get a dependency err. missing mbstring extension in php.ini. So i did a sudo apt-get install php7.0-mbstring AND the change composer.json to use illuminate 5.4.* and did the composer update again.",

           "name": "rcn/slackforphp",
           "authors": [
               {
                   "name": "Ray Novarina",
                   "email": "rnova94037@gmail.com"
               }
           ],
           "require": {
               "filp/whoops": "^2.1",               # exception handler
               "vlucas/phpdotenv": "~1.1",          # environment access
               "illuminate/database": "5.1.*",      # ORM sql db
               "altorouter/altorouter": "1.1.0",    # HTTP routes
               "respect/validation": "^1.1",        # form validation
               "duncan3dc/blade": "^3.0",           # Laraval templates
               "robmorgan/phinx": "^0.6.6",         # db:migration
               "symfony/var-dumper": "^3.2",        # prettify object to string
               "cocur/slugify": "^2.3",             # url tags to db tag
               "swiftmailer/swiftmailer": "^5.4",   # localhost email intercept
               "kunststube/csrfp": "^0.1.0"         # HTTP CSRF
           },
           "autoload": {
             "psr-4": { "SlackInterfaceForPhp\\": "src/" }          # PHP code standards to prepend Acme as
                                                                    # namespace for all objects in /src
           }
       }
    9) Recreate project structure:
       /SlackInteraceForPhp
        .env
        routes.php
        /bootstrap
        /cache
        /db
        /public
        /src
        /test
        /vendor
        /views

    10) web app load sequence: for url = 'localhost:8080'
        Note: shared project folder with vm is ~/Sites/AtomProjects/SlackInterfaceForPhp/
        /Vagrantfile config.vm.network "forwarded_port", guest: 80,   host:  8080
        -> forwards request to web server nginx
        /etc/nginx/sites-available/default  'root/vagrant/public;'
        -> /vagrant/public/index.php
          require /bootstrap/start.php (composer update, start session(), hook whoops, hook routes plugin)
          require /bootstrap/db.php (hook db handler via env variables)
          require /routes.php
          # Run http request thru our route definitions.
          # Get and process the matching route, if any.
          ->controller/method
            controllers at are /src/controllers
            views are at /views
          default root is /views/home.blade.php
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

        # connect to db via illuminate ORM.
        include(__DIR__ . '/../bootstrap/db.php');
        per .env file:
          DB_DATABASE='slackphp'
          DB_DRIVER='pgsql'

    11) Database: postgres
      Db admin tool: pgAdmin at www.pgadmin.org/download
      Connect to postgres database server:
        Name: wafs Host: localhost  Port: 54320  Username: postgres Password: secret
      Create 'slackphp' db:


    xx) Git

    xx) Phinx for db migrations: doc at http://docs.phinx.org
      phinx is installed in /vendor/bin in our vm/vagrant folder.
      Run phinx commands in the vm/vagrant folder. Postgres lives there.
      (no: we already copied one. First init phinx, makes phinx.yml file which needs to be modified
        for db name, credentials.)
      # $ php vendor/bin/phinx init
      $ php vendor/bin/phinx create CreateUsersTable
        .... create CreatePagesTable
        .... create CreateUsersPendingTable
        cut and paste from filled int xxxx_create_xxxx_table.php files.
      $ php vendor/bin/phinx migrate (could add default of '-e development')

    xx) Add Admin User:
      Register admin@example.com and then manually set that user active and admin.
        UPDATE users SET active = 1 WHERE id=1
        UPDATE users SET access_level=2 WHERE id=1

    xx) Registration email:
    
