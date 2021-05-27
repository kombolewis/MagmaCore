<?php declare(strict_types=1);

namespace Magma\Router;

use Magma\Router\Router;
use Magma\Router\RouterInterface;
use Magma\Base\Exception\BaseNoValueException;
use Magma\Base\Exception\BaseUnexpectedValueException;

class RouterFactory {
  /**
   * @var RouterInterface
   */
  protected RouterInterface $router;

  /**
   * @var string
   */
  protected string $dispatchUrl;

  /**
   * @var array
   */
  protected array $routes;

  /**
   * class constructor
   *
   * @param string $dispatchUrl
   * @param array $routes
   */
  public function __construct(string $dispatchUrl = null, array $routes) {
   if(empty($routes)) {
     throw new BaseNoValueException('
     There are one or more empty arguments.
     In order to continue please ensure you <code>routes.yaml</code> 
     has your defined routes and that you are passing the correct $_SERVER variable ie "QUERY_STRING".');
   } 
   $this->dispatchUrl = $dispatchUrl;
   $this->routes = $routes;
  }

  /**
   * instantiates the router object and checks whether the object implements the correct interface 
   * else throws an exception
   *
   * @param string $routerString
   * @return self
   */
  public function create(string $routerString) :self {
    $this->router = new $routerString;
    if(!$this->router instanceof RouterInterface) {
      throw new BaseUnexpectedValueException($routerString. ' is not a valid router object');
    }
    return $this;
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  public function buildRoutes() {


    if(is_array($this->routes) && !empty($this->routes)) {
      $args = [];
      foreach($this->routes as $key => $route) {
        if(isset($route['namespace']) && $route['namespace'] != '') {
          $args = [
            'namespace' => $route['namespace'],
          ];
        } elseif(isset($route['controller']) && $route['controller'] != '') {
          $args = [
            'controller' => $route['controller'],
            'action' => $route['action']
          ];
        }
        if(isset($key)) {
          $this->router->add($key, $args);
        }
      }
      $this->router->dispatch($this->dispatchUrl);
    }
    
  }
}

