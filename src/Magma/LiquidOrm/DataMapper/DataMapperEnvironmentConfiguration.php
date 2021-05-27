<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\Base\Exception\BaseInvalidArgumentException;

class DataMapperEnvironmentConfiguration
{
  /**
   * @var array
   */
  private array $credentials = [];


  /**
   * main constructor method
   * 
   * @param array credentials
   * @return void
   */

  public function __construct(array $credentials) {
     $this->credentials = $credentials;
  }

  /**
   * Get the user defined database connection array
   *
   * @param string $driver
   * @return array
   */
  public function getDatabaseCredentials(string $driver) : array {
    $connectionArray = [];
    $this->isCredentialsValid($driver);

    foreach($this->credentials as $credential) {
      if(array_key_exists($driver, $credential)) {
        $connectionArray = $credential[$driver];
      }
    }
    return $connectionArray;
  }

  /**
   * Checks credentials for validity
   *
   * @param string $driver
   * @return void
   */
  private function isCredentialsValid(string $driver) {
    if(empty($driver) && !\is_string($driver)) {
      throw new BaseInvalidArgumentException('Invalid argument. This is another missing or off the invalid data type.');
    }
    if(!is_array($this->credentials)){
      throw new BaseInvalidArgumentException('Invalid credentials.');
    }
    if(!\in_array($driver, array_keys($this->credentials['driver']))) {
      throw new BaseInvalidArgumentException('Unsupported database driver.');
    }
  }

}

