<?php
namespace App\Controller;

use Magma\Base\BaseController;

class SecurityController extends BaseController
{
  public function __construct($routeParams) {
    parent::__construct($routeParams);
  }

  public function loginAction() {
    echo 'Security Controller';
  }
}

