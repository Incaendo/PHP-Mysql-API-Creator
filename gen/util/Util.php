<?php

namespace App\UTIL;

/**
 * Description of Util
 *
 * @author <<AUTHOR>>
 */
class Util {

  /**
   * Function getCurentDate.
   * This function is used to get current Date.
   * @author <<AUTHOR>>
   */
  public function getCurentDate() {
    return Date("d-m-y");
  }

  /**
   * Function getCurentDateTime.
   * This function is used to get current date and time.
   * @author <<AUTHOR>>
   */
  public function getCurentDateTime() {
    return Date("d-m-y h:i:s");
  }

  /**
   * Function genrateOTP.
   * This function is used to genrate OTP.
   * @author <<AUTHOR>>
   */
  public function genrateOTP() {
    $OTPCode = mt_rand(100000, 999999);
    return $OTPCode;
  }

  /**
   * Check is the provided strings are equal.
   *
   * @return boolean return true if the strings are equal, if not equal return false.
   */
  public static function equals($string1, $string2) {
    if (strtolower(trim($string1)) == strtolower(trim($string2))) {
      return true;
    }

    return false;
  }

  /**
   * Check to whether string is valid alpha characters
   *
   * @param $string string,
   *
   * @return boolean
   */
  public static function isValidAlphaCharacters($string) {
    if (preg_match('/^\s*[+-]?\d+\s*$/', $string)) {
      return true;
    }
    return false;
  }

  /**
   * Check to whether number is 10 digit
   *
   * @param $number string,
   *
   * @return boolean
   */
  public static function isValidMobile($number) {
    if (preg_match('/^[0-9]{10}$/', $number)) {
      return true;
    }
    return false;
  }

  /**
   * Check to whether number is 10 digit
   *
   * @param $string string,
   *
   * @return boolean
   */
  public static function isValidEmail($string) {
    if (filter_var($string, FILTER_VALIDATE_EMAIL) === false) {
      return false;
    }
    return true;
  }

  /**
   * Check to whether date is in proper format
   *
   * @param $date date,
   * @param $format string
   *
   * @return boolean
   */
  public static function isValidDate($date, $format = 'Y-m-d') {
    $d = \DateTime::createFromFormat($format, $date);
    if ($d) {
      return $d && $d->format($format) === $date;
    }

    return false;
  }

}
