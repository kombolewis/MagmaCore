<?php

declare(strict_types=1);

namespace Magma\Router;

interface RouterInterface
{ 
  /**
   * add a route to the routing table
   *
   * @param string $route
   * @param array $param
   * @return void
   */
  public function add(string $route,array $param) : void;


  /**
   * Dispatch route and create controller objects, execute default
   * method on that controller object
   * 
   * @param string $url
   * @return void
   */
  public function dispatch(string $url) :void;

}

