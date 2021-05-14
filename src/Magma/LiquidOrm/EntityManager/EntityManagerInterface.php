<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

interface EntityManagerInterface
{
  /**
   * get Crud class
   *
   * @return object
   */
  public function getCrud() : object;
}

