<?php declare(strict_types=1);

namespace Magma\GlobalManager;

interface GlobalManagerInterface
{
  /**
   * Set the value of the global  variable
   *
   * @param string $key
   * @param [type] $value
   * @return void
   */
  public static function set(string $key, $value) :void;


  /**
   * get the value of the set global variable
   *
   * @param string $key
   * @return void
   */
  public static function get(string $key);

  
}

