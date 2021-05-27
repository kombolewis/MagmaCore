<?php declare(strict_types=1);

namespace Magma\Session;

use Magma\Session\Session;
use Magma\Session\SessionInterface;
use Magma\Session\Storage\SessionStorageInterface;
use Magma\Base\Exception\BaseInvalidArgumentException;

class SessionFactory
{

  public function __construct() {

  }

  public function create(string $sessionName, string $storageString, array $options = []) :SessionInterface {

    $storageObject =  new $storageString($options);
    if(!$storageObject instanceof SessionStorageInterface) {
      throw new BaseInvalidArgumentException($sessionString.' is not a valid session storage object');
    }
    return new Session($sessionName, $storageObject);
  }


}

