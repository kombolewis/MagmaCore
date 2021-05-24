<?php declare(strict_types=1);

namespace App\Controller;

use Magma\Base\BaseController;

class HomeController extends BaseController
{
  public function __construct($routeParams) {
    parent::__construct($routeParams);
  }

  public function indexAction() {
    echo 'index <br>';
  }

  protected function before() {
    echo 'this is the before hook <br>';
  }


  protected function after() {
    echo 'this is the after hook <br>';
  }
}

