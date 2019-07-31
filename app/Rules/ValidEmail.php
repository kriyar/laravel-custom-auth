<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidEmail implements Rule
{
  /**
  * Create a new rule instance.
  *
  * @return void
  */
  public function __construct()
  {
    //
  }

  /**
  * Determine if the validation rule passes.
  *
  * @param  string  $attribute
  * @param  mixed  $value
  * @return bool
  */
  public function passes($attribute, $value)
  {
    $email_verified_at = DB::table('users')
    ->where('email', '=', $value)
    ->value('email_verified_at');

    if ($email_verified_at) {
      return true;
    } else {
      return support_validate_email($value) ? true : false;
    }
  }

  /**
  * Get the validation error message.
  *
  * @return string
  */
  public function message()
  {
    return 'The :attribute is invalid.';
  }
}
