<?php declare(strict_types=1);

namespace Magma\Base;

use Magma\Base\BaseView;

class BaseController
{
  protected array $routeParams;

  private object $twig;


  public function __construct(array $routeParams) {
    $this->routeParams = $routeParams;
    $this->twig = new BaseView;
  }

  public function render(string $template, array $context= []) {
    if($this->twig = null) {
      throw new BaseLogicException('You cannot use the render method id the twig bundle is not available');
    }

    return $this->twig->getTemplate($template, $context);
  } 

  




}

