<?php namespace Acme\validation;

use Respect\Validation\Validator as Valid;

  class Validator
  {
      public function isValid($validation_data)
      {
          $errors = [];

      # example $validation_data[] key/value pair: 'first_name' => 'min:3:First Name'
      #                                        or: 'verify_email' => 'email:Verify Email&&equals:email:Verify Email:Email'
      # NOTE: key is assumed to be a $_REQUEST post param name.
      foreach ($validation_data as $field_name => $field_rules) {

        $rules = explode('&&', $field_rules);

        # example: $exploded_rules = [ 'min:3:First Name']
        #                         or [ 'email:Verify Email', 'equals:email:Verify Email:Email' ]
        foreach ($rules as $rule) {
          list($verb, $param, $label1, $label2) = explode(':', $rule);

          # $field_value format: 'validation_method:param1:field_label'
          switch ($verb) {
            case 'min':
              # Minimum number of string chars is element [1]
              # example: 'first_name' => 'min:3:First Name:'
              if (Valid::stringType()->length($param, null)->Validate($_REQUEST[$field_name]) == false) {
                  array_push($errors, "'" . $label1 . "' field must be at least " . $param . ' characters long.');
              }
              break;

            case 'email':
              # example: 'email' => 'email::Email:'
              if (Valid::email()->validate($_REQUEST[$field_name]) == false) {
                  array_push($errors, "'" . $label1 . "' field must be a valid Email Address.");
              }
              break;

            case 'equals':
              # example: 'verify_email' => 'equals:email:Verify Email:Email'
              if (Valid::equals($_REQUEST[$field_name])->validate($_REQUEST[$param]) == false) {
                  array_push($errors, "'" . $label1 . "' field does not match '" . $label2 . ' field.');
              }
              break;

            case 'unique':
              # example: 'email' => 'unique:User:Email:'
              $model = 'Acme\\models\\' . $param;
              $table = new $model;
              if (($item = $table::where($field_name, $_REQUEST[$field_name])->first())!= null) {
                array_push($errors, "'" . $label1 . "' field already exists in this system!.");
              }
              break;

            default:
              array_push($errors, 'Field ' . $field_name . ' not found in POST submission.');
              break;
          } # end switch()
        } # end foreach()
      } # end foreach()
      return $errors;
      }
  }
