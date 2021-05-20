<?php declare(strict_types=1);

namespace Magma\GlobalManager;

use Magma\GlobalManager\GlobalManagerInterface;
use Magma\GlobalManager\Exception\GlobalManagerException;

class GlobalManager implements GlobalManagerInterface
{
  /**
   * @inheritDoc
   *
   * @param string $key
   * @param [type] $value
   * @return void
   */
  public static function set(string $key, $value) :void {
    $GLOBALS[$key] = $value;
  }

  /**
   * @inheritDoc
   *
   * @param string $key
   * @return mixed
   */
  public static function get(string $key) {
    
    self::isGlobalValid($key);

    try {
      return $GLOBALS[$key];
    } catch (\Throwable $th) {
      throw new GlobalManagerException('an exception was thrown trying to retrieve the data');
    }
  }

  /**
   * check validity of key
   *
   * @param string $key
   * @return void
   */
  private static function isGlobalValid(string $key) :void {

    if(!isset($GLOBALS[$key])) {
      throw new GlobalManagerInvalidArgumentException('Invalid global key. Please ensure you have set '.$key.' before accessing it');
    }

    if(empty($key)) {
      throw new GlobalManagerInvalidArgumentException('Argument cannot be empty');
    }
  }
}

