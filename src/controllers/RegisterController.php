<?php

namespace Acme\controllers;

use duncan3dc\Laravel\BladeInstance;
use Acme\validation\Validator;
use Acme\models\User;
use Acme\email\SendEmail;
use Acme\models\UserPending;

class RegisterController extends BaseController
{

    public function getShowRegisterPage()
    {
        echo $this->blade->render('register', [  # /views/register.blade.php
          'signer' => $this->signer
        ]);
    }

    public function postShowRegisterPage()
    {
      // verify CSRF token.
      if ($this->signer->validateSignature($_POST['_token']) == false) {
        // hack attempt.
        header('HTTP/1.0 400 Bad Request');
        exit();
      }

      // $verb, $param, $label1, $label2
      $validation_data = [
        'first_name'      => 'min:3:First Name:',
        'last_name'       => 'min:3:Last Name:',
        'email'           => 'email::Email:&&unique:User:Email:',
        'verify_email'    => 'email::Verify Email:&&equals:email:Verify Email:Email',
        'password'        => 'min:3:Password:',
        'verify_password' => 'min:3:Verify Password:&&equals:password:Verify Password:Password'
      ];

      # validate data.
      $validator = new Validator();

      if (count($errors = $validator->isValid($validation_data)) > 0)
      {
        // if validation errors, redirect to register page with error msgs.
        $_SESSION['msgs'] = $errors;
        echo $this->blade->render('register', [  # /views/register.blade.php
          'signer' => $this->signer
        ]);
        # NOTE: unset(...) so that the next time this page is loaded it does not
        #       see these error msgs again.
        unset($_SESSION['msgs']);
        exit();
      }

      # Else save data into database.
      $user = new User;
      $user->first_name = $_REQUEST['first_name'];
      $user->last_name  = $_REQUEST['last_name'];
      $user->email      = $_REQUEST['email'];
      $user->password   = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
      $user->save();

      $token = md5(uniqid(rand(), true)) . md5(uniqid(rand(), true));

      $user_pending = new UserPending;
      $user_pending->token = $token;
      $user_pending->user_id = $user->id;
      $user_pending->save();

      $message = $this->blade->render('emails.welcome-email',
                                      ['token' => $token,
                                       'toAddr' => $user->email
                                      ]
      );

      # SendEmail params: ToAddr, Subject, Body, FromAddr
      SendEmail::sendEmail($user->email, 'Welcome from Acme registration', $message);

      header('Location: /success');
      exit();
    }

    // Get here when someone clicks on link in registration email.
    public function getVerifyAccount()
    {
      // look up the newly registered user with this token (get token field from $_REQUEST)
      if (($user_pending = UserPending::where('token', $_GET['token'])->first()) == null) {
        header('Location: /page-not-found?info=RegContr.getVerifyAccount() for toAddr= ' . $_GET['toAddr'] . '  token=' . $_GET['token']);
        exit();
      }

      // Make the user account active.
      $user = User::find($user_pending->user_id);
      $user->active = 1;
      $user->save();

      // delete registered user from the pending table.
      $user_pending->delete();

      header('Location: /account-activated');
      exit();
    }
}
