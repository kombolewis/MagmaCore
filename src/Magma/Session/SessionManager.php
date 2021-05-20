<?php declare(strict_types=1);

namespace Magma\Session;

use Magma\Session\SessionFactory;
use Magma\Session\Storage\NativeSessionStorage;

class SessionManager
{
  public static function initialize() {
    return (new SessionFactory())->create('', NativeSessionStorage::class,array());
  }
}

