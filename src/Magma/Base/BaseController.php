<?php declare(strict_types=1);

namespace Magma\Base;

use Magma\Base\BaseView;
use Magma\Base\Exception\BaseLogicException;
use Magma\Base\Exception\BaseBadMethodCallException;

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

  public function __call($name, $argument) {
    $method = $name . 'Action';
    if(\method_exists($this, $method)) {
      if($this->before() !== false) {
        \call_user_func_array([$this, $method],$argument);
        $this->after();
      }
    } else {
      throw new BaseBadMethodCallException("Method {$method} does not exist in ".get_class($this));
    }
  }

  protected function before() {

  }


  protected function after() {
    
  }


}

