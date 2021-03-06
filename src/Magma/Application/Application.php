<?php declare(strict_types=1);

namespace Magma\Application;

use Magma\Router\Router;
use Magma\Yaml\YamlConfig;
use Magma\Application\Config;
use Magma\Traits\SystemTrait;
use Magma\Router\RouterFactory;

class Application
{
  protected string $appRoot;
  /**
   * main class constructor.
   */
  public function __construct(string $appRoot) {
    $this->appRoot = $appRoot;
   
  }

	public function run() :self {
    $this->constants();

		if(\version_compare($phpVersion =PHP_VERSION, $coreVersion = Config::MAGMA_MIN_VERSION, '<')) {
      die(\sprintf('You are running PHP %s, but the core framework requires atleast PHP %s',$phpVersion, $coreVersion));
    }
    $this->environment();
    $this->errorHandler();
    return $this;
  }

  private function constants() :void {
    defined('DS')  or define('DS', DIRECTORY_SEPARATOR);
    defined('APP_ROOT') or define('APP_ROOT', $this->appRoot);
    defined('CONFIG_PATH') or define('CONFIG_PATH', APP_ROOT . DS . 'Config');
    defined('TEMPLATE_PATH') or define('TEMPLATE_PATH', APP_ROOT . DS . 'App' . DS);
    defined('LOG_DIR') or define('LOG_DIR', APP_ROOT . DS . 'tmp' . DS .'log');
	}

	private function environment() {
		\ini_set('default_charset', 'UTF-8');
  }
  
  private function errorHandler() : void{
    \error_reporting(E_ALL | E_STRICT);
    \set_error_handler('Magma\ErrorHandling\ErrorHandling::errorHandler');
    \set_exception_handler('Magma\ErrorHandling\ErrorHandling::exceptionHandler');
  }

  public function setSession() {
    SystemTrait::sessionInit(true);
    return $this;
  }

  /**
   * Undocumented function
   *
   * @param string $url
   * @param array $routes
   * @return self
   */
  public function setRouteHandler(string $url = null, array $routes = []) :self {

    $query = $_SERVER['REQUEST_URI']; 
    if(\strlen($query) > 1) {
      $query = ltrim($_SERVER['REQUEST_URI'],'/');
    }
    
    $url = ($url) ?? $query;
    $routes = ($routes) ? $routes : YamlConfig::file('routes');
    $factory = new RouterFactory($url, $routes);
    $factory->create(Router::class)->buildRoutes();
    return $this;
  }
}

