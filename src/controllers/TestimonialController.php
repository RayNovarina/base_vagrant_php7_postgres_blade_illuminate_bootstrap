<?php
namespace Acme\controllers;

use duncan3dc\Laravel\BladeInstance;
use Acme\validation\Validator;
use Acme\models\Testimonial;
use Acme\auth\LoggedIn;

class TestimonialController extends BaseController
{
  public function getShowTestimonials()
  {
      $testimonials = Testimonial::all();

      echo $this->blade->render('testimonials', [
        'testimonials' => $testimonials
      ]);
  }

  public function getShowTestimonial()
  {
    // extract record id from Url
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    $db_id = $uri[2];

    // $testimonial = Testimonial::find($db_id)->first();
    // dd($testimonial);

    if ($db_id == '' || ($testimonial = Testimonial::find($db_id)->first()) == null) {
      header('HTTP/1.0 400 Bad Request');
      exit();
    }
    echo $this->blade->render('show-testimonial', [  # /views/show-testimonial.blade.php
      'testimonial' => $testimonial
    ]);
  }
  public function getShowAdd()
  {
    echo $this->blade->render('add-testimonial', [  # /views/add-testimonial.blade.php
      'signer' => $this->signer
    ]);
  }

  public function postShowAdd()
  {
    // verify CSRF token.
    if ($this->signer->validateSignature($_POST['_token']) == false) {
      // hack attempt.
      header('HTTP/1.0 400 Bad Request');
      exit();
    }

    // $verb, $param, $label1, $label2
    $validation_data = [
      'title'           => 'min:3:Title:',
      'testimonial'     => 'min:10:Testimonial:'
    ];

    # validate data.
    $validator = new Validator();

    if (count($errors = $validator->isValid($validation_data)) > 0)
    {
      // if validation errors, redirect to add-testimonial page with error msgs.
      $_SESSION['msgs'] = $errors;
      echo $this->blade->render('add-testimonial', [  # /views/add-testimonial.blade.php
        'signer' => $this->signer
      ]);
      # NOTE: unset(...) so that the next time this page is loaded it does not
      #       see these error msgs again.
      unset($_SESSION['msgs']);
      exit();
    }

    # Else save data into database.
    $testimonial = new Testimonial;
    $testimonial->title = $_REQUEST['title'];
    $testimonial->testimonial  = $_REQUEST['testimonial'];
    $testimonial->user_id = LoggedIn::user()->id;
    $testimonial->save();

    header('Location: /testimonial-saved');
    exit();

  }

}
?>
