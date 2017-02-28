<?php

namespace Acme\controllers;

use duncan3dc\Laravel\BladeInstance;
use Acme\validation\Validator;
use Acme\models\User;
use Acme\auth\LoggedIn;

class AuthenticationController extends BaseController
{
    public function getShowLoginPage()
    {
        echo $this->blade->render('login', [  # /views/login.blade.php
          'signer' => $this->signer
        ]);
    }

    public function postShowLoginPage()
    {
      // verify CSRF token.
      if ($this->signer->validateSignature($_POST['_token']) == false) {
        // hack attempt.
        header('HTTP/1.0 400 Bad Request');
        exit();
      }

      $errors = [];
      $email = $_REQUEST['email'];
      $password = $_REQUEST['password'];

      // lookup the user via email address.
      if (($user = User::where('email', '=', $email)
                        ->first()) == null) {
        array_push($errors, 'Invalid email address.');
      }
      if (count($errors) == 0) {
        // User found. validate credentials.
        // NOTE: User.password save as password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
        if (! password_verify($password, $user->password)) {
          array_push($errors, 'Invalid password.');
        }
      }
      if (count($errors) == 0) {
        // User is registered. Have they confirmed reg email?
        if ($user->active == 0) {
          # HACK: array_push($errors, 'Not an active account. You must accept your registration email first.');
        }
      }

      if (count($errors) == 0) {
        // if authentication success, log em in.
        $_SESSION['user'] = $user;
        header('Location: /');
        exit();
      }

      // if validation errors, redirect to login page with error msgs.
      $_SESSION['msgs'] = $errors;
      echo $this->blade->render('login', [  # /views/login.blade.php
        'signer' => $this->signer
      ]);
      unset($_SESSION['msgs']);
      exit();
    }

    public function getLogout()
    {
      unset($_SESSION['user']);
      session_destroy();
      header('Location: /login');
      exit();
    }

}
