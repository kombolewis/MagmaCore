<?php

declare(strict_types=1);

namespace Magma\Session;

use Magma\Session\SessionInterface;
use Magma\Base\Exception\BaseException;
use Magma\Session\Storage\SessionStorageInterface;
use Magma\Base\Exception\BaseInvalidArgumentException;

class Session implements SessionInterface
{
  protected SessionStorageInterface $storage;

  protected string $sessionName;

  protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

  public function __construct(string $sessionName, SessionStorageInterface $storage) {

    if($this->isSessionKeyValid($sessionName) == false) {
      throw new BaseInvalidArgumentException($sessionName.' is not a valid session name');
    }

    $this->sessionName = $sessionName;
    $this->storage =  $storage;

  }

  public function set(string $key, $value) :void {
    $this->ensureSessionKeyIsValid($key);
    try {
      $this->storage->setSession($key,$value);
    } catch (\Throwable $th) {
      throw new BaseException('An exception was thrown in retrieving the key from the session storage '.$th);
    }

  }

  public function setArray(string $key, $value) :void {
    $this->ensureSessionKeyIsValid($key);

    try {
      $this->storage->setArraySession($key, $value);
    } catch (\Throwable $th) {
      throw new BaseException('An exception was thrown in retrieving the key from the session storage '.$th);
      
    }
  }

  public function get(string $key, $default=null) {
    $this->ensureSessionKeyIsValid($key);

    try {
      return $this->storage->getSession($key,$value);
    } catch (\Throwable $th) {
      throw new BaseException();
    }
  }

  public function delete(string $key) :bool {
    $this->ensureSessionKeyIsValid($key);

    try {
      return $this->storage->deleteSession($key);
    } catch (\Throwable $th) {
      throw new BaseException();
    }
  }

  public function invalidate() :void {
    $this->storage->invalidate();
  }

  public function flush(string $key, $value = null) {
    $this->ensureSessionKeyIsValid($key);

    try {
      return $this->storage->flush($key,$value);
    } catch (\Throwable $th) {
      throw new BaseException();
    }
  }

  public function has(string $key) {
    $this->ensureSessionKeyIsValid($key);

    
    return $this->storage->hasSession();
  }


	protected function isSessionKeyValid(string $key) :bool {
		return (\preg_match(self::SESSION_PATTERN, $key) == 1);
  }
  

	public function ensureSessionKeyIsValid(string $key) :void {
		if($this->isSessionKeyValid($key) === false) {
      throw new BaseInvalidArgumentException($key, ' is not a valid session key');
    }
	}
}

