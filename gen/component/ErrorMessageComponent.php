<?php
namespace App\Component;

/**
 * @file
 * Class ErrorMessageComponent
 * This class is used for api's  Error Message and Code.
 * @author <<AUTHOR>>
 */
class ErrorMessageComponent {

  public function errorMessageByCode($request = array()) {
    $errorList = false;
    if (isset($request) && !empty($request)) {
      try {
        $errors = \Slim\Registry::getEm()->getRepository('App\Model\ErrorMessageModel')->findByErrorCode($request);
        foreach ($errors as $error) {
          $errorList = $error->getData();
        }
      } catch (Exception $e) {
        
      }
    }
    return $errorList;
  }

}
