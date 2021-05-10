<?php
namespace Magma\DatabaseConnection\Exception;

class DatabaseConnectionException extends \PDOException
{
  protected $message;

  protected $code;
  
  public function __construct($message = null, $code = null) {
    $this->message = $message;
    $this->code = $code;
  }

}

