<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidPhone implements Rule
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
    $input = support_index_phone_number($value);
    $phone_prefix = support_current_user_country_phone_prefix();
    $prefix_from_input = mb_substr($input, 0, strlen($phone_prefix));
    if ($phone_prefix != $prefix_from_input) {
      $phone_number = $phone_prefix . $input;
    } else {
      $phone_number = $input;
    }

    $phone_verified_at = DB::table('users')
    ->where('phone_number', '=', $phone_number)
    ->value('phone_verified_at');

    if ($phone_verified_at) {
      return true;
    } else {
      $valid = support_validate_phone_number($phone_number);
      if ($valid) {
        return true;
      }
    }
    return false;
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
