<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Return configuration information
  */

  'country_apikey' => env('COUNTRY_API', ''), // API from https://ipstack.com to get current user country and phone prefix (country dialing code) to add phone prefix without asking user to write it.
  'default_phone_prefix' => env('DEFAULT_PHONE_PREFIX', 855), // Defualt phone prefix (country dialing code) if not use dynamic user country
  'nexmo_sms_enabled' => env('NEXMO_SMS_ENABLED', false), // Enable to send password reset code or verify phone number via SMS

  'phone_validate' => [
    'enabled' => env('PHONE_VALIDATE_ENABLED', false), // Enable to validate input phone number when register new account
    'api_key' => env('PHONE_VALIDATE_API', ''), // API from https://numverify.com to validate input phone number (make sure the phone is valid/exist)
  ],

  'email_validate' => [
    'enabled' => env('EMAIL_VALIDATE_ENABLED', false), // Enable to validate email address when register new account
    'api_key' => env('EMAIL_VALIDATE_API', ''), // API from https://mailboxlayer.com to validate email address (make sure the email is valid/exist)
    'strict' => env('EMAIL_VALIDATE_STRICT', false) // If "FALSE", the validation process will assume that email is VALID in case can't connect or no respone from API source
  ],

];
