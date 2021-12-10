<?php
class CustomError {
  public $error;
  public $error_msg;

  function __construct($error, $error_msg) {
    $this->error = $error;
    $this->error_msg = $error_msg;
  }
}

?>