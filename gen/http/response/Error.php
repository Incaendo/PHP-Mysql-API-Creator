<?php

namespace App\Response;

/**
 * Error
 * @author <<AUTHOR>>
 */
class Error {

  private $code;
  private $message;
  private $internalMessage;

  public function getCode() {
    return $this->code;
  }

  public function getMessage() {
    return $this->message;
  }

  public function getInternalMessage() {
    return $this->internalMessage;
  }

  public function setCode($code) {
    $this->code = $code;
  }

  public function setMessage($message) {
    $this->message = $message;
  }

  public function setInternalMessage($internalMessage) {
    $this->internalMessage = $internalMessage;
  }

}
