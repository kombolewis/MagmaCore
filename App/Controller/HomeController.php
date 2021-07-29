<?php declare(strict_types=1);

namespace App\Controller;

use App\DataColumns\UserColums;
use App\Model\UserModel;
use Magma\Base\BaseController;
use Magma\Datatable\Datatable;
use Magma\Http\RequestHandler;
use Magma\Utility\Helpers;
use Magma\Yaml\YamlConfig;

class HomeController extends BaseController
{
  public function __construct($routeParams) {
    parent::__construct($routeParams);
  }

  public function indexAction() {
    $args = YamlConfig::file('controller')['user'];
    $user = new UserModel;
    $repository = $user->getRepo()->findWithSearchAndPaging((new RequestHandler)->handler(), $args);
    // Helpers::dnd($repository);

    $tableData = (new Datatable)->create(UserColums::class, $repository, $args)->table();
    $this->render('client/home/index.html.twig', [
      'table' => $tableData,
      'pagination' => (new Datatable)->create(UserColums::class, $repository, $args)->pagination()
    ]);
  }

  protected function before() {
  }


  protected function after() {
  }


}

