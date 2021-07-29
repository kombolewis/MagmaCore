<?php
namespace Magma\Router;

use Magma\Utility\Helpers;
use Magma\Router\RouterInterface;
use Magma\Base\Exception\BaseException;
use Magma\Base\Exception\BaseBadMethodCallException;

class Router implements RouterInterface
{
  /**
   * returns an array of routes from our routing table
   * 
   * @var array
   */
  protected array $routes = [];

  /**
   * returns an array of route parameters
   * 
   * @var array
   */
  protected array $params = [];

  /**
   * adds a suffix onto the controller name
   * 
   * @var string
   */
  protected string $controllerSuffix = 'controller';

  /**
   * @inheritDoc
   */
  public function add(string $route, array $params) : void {
    $route = \preg_replace('/\//', '\\/', $route);
    $route = '/^' . $route .'$/i';
    $this->routes[$route] = $params;
  }


  /**
   * @inheritDoc
   *
   * @param string $url
   * @return void
   */
  public function dispatch(string $url) : void {
    $url = $this->formatQueryString($url);
    if($this->match($url)) {
      $controllerString = $this->params['controller'] . '-' . $this->controllerSuffix;
      $controllerString = $this->transformUpperCamelCase($controllerString);
      $controllerString = $this->getNamespace() . $controllerString;
      
      if(class_exists($controllerString)) {
        $controllerObject =  new $controllerString($this->params);
        $action = $this->params['action'];
        $action = $this->transformCamelCase($action);

        if(\is_callable([$controllerObject, $action])) {
          $controllerObject->$action();
        } else {
          throw new BaseBadMethodCallException('Invalid Method');
        }
      } else {
        throw new BaseException('Controller class does not exist');
      }

    } else {
      throw new BaseException('404 Error no page found');
    }
  }

  /**
   * returns transformed controller name
   *
   * @param string $string
   * @return string
   */
  public function transformUpperCamelCase(string $string) : string {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /**
   * return transformed object method name
   *
   * @param string $string
   * @return string
   */
  public function transformCamelCase(string $string) : string {
    return lcfirst($this->transformUpperCamelCase($string));
  }

  /**
   * match the route to the routes in the routing table,
   * setting the $this->params property if a route is found
   *
   * @param string $url
   * @return boolean
   */
  private function match(string $url) : bool {
    foreach($this->routes as $route => $params) {
      if(\preg_match($route, $url, $matches)) {
        foreach($matches as $key => $match) {
          if(\is_string($key)) {
            $params[$key] = $match;
          }
        }
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  /**
   * Get the namespace for the controller class. The namespace defined within the route
   * parameters only if it was added.
   *
   * @param string $string
   * @return string
   */
  public function getNamespace() : string {
    $namespace = 'App\Controller\\';
    if(array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] .'\\';
    }
    return $namespace;
  }

  public function formatQueryString(string $url) {
    if($url != '') {
      $parts = explode('&', $url, 2);
      if(strpos($parts[0], '=') === false) {
        $url = $parts[0];
      }else {
        $url = '';
      }
    }
    return rtrim($url, '/');
  }

}

