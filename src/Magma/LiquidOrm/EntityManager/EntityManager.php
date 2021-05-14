<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

use Magma\LiquidOrm\EntityManager\CrudInterface;
use Magma\LiquidOrm\EntityManager\EntityManagerInterface;

class EntityManager implements EntityManagerInterface
{
  /**
   * @var CrudInterface
   *
   */
  protected CrudInterface $crud;
  /**
   * main constructor class
   * 
   * @return void
   */

   public function __construct(CrudInterface $crud) {
     $this->crud = $crud;
   }

  /**
   * @inheritDoc
   *
   * @return object
   */ 
  public function getCrud() :object {
    return $this->crud;
  }
}

