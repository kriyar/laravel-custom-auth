<?php

use Illuminate\Support\Facades\Log;

if (! function_exists('support_current_user_ip')) {
  /**
  * Return current user IP
  */
  function support_current_user_ip() {
    $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
  }
}

if (! function_exists('support_current_user_country')) {
  /**
  * Return current user country
  */
  function support_current_user_country() {
    $apikey = config('support.country_apikey', ''); // API Key from ipstack.com
  	$info = array();
  	if ($apikey) {
  		$ip = support_current_user_ip();

  		$url = "http://api.ipstack.com/$ip?access_key=$apikey";

  		$d = file_get_contents($url);
  		$data = $d !== FALSE ? json_decode($d , true) : array();
  		if (isset($data['country_code']) && !empty($data['country_code'])) {
  			$info = $data;
  		}
  	}
    return $info;
  }
}

if (! function_exists('support_current_user_country_phone_prefix')) {
  /**
  * Return current user country phone prefix
  */
  function support_current_user_country_phone_prefix() {
    $country = support_current_user_country();
    return isset($country['location']['calling_code']) ? $country['location']['calling_code'] : config('support.default_phone_prefix');
  }
}

if (! function_exists('support_index_phone_number')) {
  /**
  * Index phone number
  */
  function support_index_phone_number($phone) {
    $phone_number = trim(preg_replace("/[^0-9]/", '', $phone));
    if (!empty($phone_number)) {
      // Remove 0 at the beginning
      if (substr($phone_number, 0, 1) == 0) {
        $phone_number = substr($phone_number, 1);
      }
    }
    return $phone_number;
  }
}


if (! function_exists('support_validate_phone_number')) {
  /**
  * Return integer phone number
  */
  function support_validate_phone_number($phone_num, $countrycode = NULL, $return_format = 'international') {
    $phone_number = trim(preg_replace("/[^0-9]/", '', $phone_num));

    $validate = config('support.phone_validate.enabled');
    $apikey = config('support.phone_validate.api_key');
    if ($validate && !empty($apikey)) {
      $url = 'http://apilayer.net/api/validate?access_key='. $apikey .'&number='. $phone_number;

      if ($countrycode !== NULL) {
        $url .= '&country_code=' . $countrycode;
      }

      // Initialize CURL:
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Store the data:
      $json = curl_exec($ch);
      curl_close($ch);

      // Decode JSON response:
      $data = json_decode($json, true);
      if (is_array($data) && array_key_exists('valid', $data)) {
        if ($data['valid']) {
          return $return_format == 'local' ? $data['local_format'] : preg_replace("/[^0-9]/", '', $data['international_format']);
        } else {
          return '';
        }
      } else {
        $msg = isset($data['error']['info']) && is_string($data['error']['info']) ? ' ' . $data['error']['info'] : '';
        Log::error('Could not validate phone ' . $phone_number . ': ' . $msg);
        return $phone_number;
      }
    }
    return $phone_number;
  }
}

if (! function_exists('support_validate_email')) {
  /**
  * Return validate email or NULL
  */
  function support_validate_email($email, $strict = NULL) {
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $validate = config('support.email_validate.enabled');
      $apikey = config('support.email_validate.api_key');
      $strict = $strict === NULL ? config('support.email_validate.strict') : $strict;
      if ($validate && !empty($apikey)) {
        $url = 'http://apilayer.net/api/check?access_key='. $apikey .'&email='. $email . '&smtp=1&format=1';

        // Initialize CURL:
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $data = json_decode($json, true);
        if (is_array($data) && array_key_exists('mx_found', $data)) {
          if ($data['mx_found'] && $data['smtp_check']) {
            return $email;
          } else {
            return false;
          }
        } else {
          $msg = isset($data['error']['info']) && is_string($data['error']['info']) ? $data['error']['info'] : '';
          Log::error('Could not validate email ' . $email . ': ' . $msg);
          if ($strict) { // If can't validate with API, force to validate again, so need to return FALSE
            return false;
          }
        }
      }
      return $email;
    }
    return false;
  }

}

if (! function_exists('support_generate_random_string')) {
  /**
  * Custom helper function to generate a random string.
  */
  function support_generate_random_string($length = 8) {
    $valid_characters = "123456789bcdfghjklmnpqrstxyvwzBCDFGHJKLMNPQRSTXYVWZ";

    $valid_char_number = strlen($valid_characters);

    $result = "";

    for ($i = 0; $i < $length; $i++) {

      $index = mt_rand(0, $valid_char_number - 1);

      $result .= $valid_characters[$index];
    }

    return $result;
  }
}

if (! function_exists('support_encrypt_string')) {
  /**
  * Custom helper function to encrypt a string.
  */
  function support_encrypt_string($data, $length = 8) {
    $string_prefix = support_generate_random_string($length);
    $string_suffix = support_generate_random_string($length);
    $separator = '#SP#';
    $string = $string_prefix . $separator . $data . $separator . $string_suffix;
    return base64_encode($string);
  }
}

if (! function_exists('support_decrypt_string')) {
  /**
  * Custom helper function to decrypt a string.
  */
  function support_decrypt_string($encrypt_string) {
    $separator = '#SP#';
    $string_decode = base64_decode($encrypt_string);
    $exploded_string_array = explode($separator, $string_decode);
    return isset($exploded_string_array[1]) ? $exploded_string_array[1] : '';
  }
}
