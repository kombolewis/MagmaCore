<?php declare(strict_types=1);

namespace Magma\Session;

use Magma\Yaml\YamlConfig;
use Magma\Session\SessionFactory;
use Magma\Session\Storage\NativeSessionStorage;

class SessionManager
{
  public static function initialize() {
    return (new SessionFactory())->create('Magam', NativeSessionStorage::class, YamlConfig::file('session'));
  }
}

