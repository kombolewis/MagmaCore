<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;
use Magma\Utility\Helpers;
use Magma\Base\BaseController;

class HomeController extends BaseController
{
  public function __construct($routeParams) {
    parent::__construct($routeParams);
  }

  public function indexAction() {
    $user = new UserModel;
    $data = $user->getRepo()->findAll();
    Helpers::dnd($data);
  }

  protected function before() {
    echo 'this is the before hook <br>';
  }


  protected function after() {
    echo 'this is the after hook <br>';
  }
}

