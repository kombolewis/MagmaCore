<?php declare(strict_types=1);

namespace Magma\Traits;

use Magma\Session\SessionManager;
use Magma\GlobalManager\GlobalManager;
use Magma\Base\Exception\BaseLogicException;

trait SystemTrait
{
  public static function sessionInit(bool $useSessionGlobal = false) {
    $session = SessionManager::initialize();
    if(!$session) {
      throw new BaseLogicException('Please enable session within you session.yaml configuration file');
    }else if($useSessionGlobal == true) {
      GlobalManager::set('global_session', $session);
    } else {
      return $session;
    }

  }
}

