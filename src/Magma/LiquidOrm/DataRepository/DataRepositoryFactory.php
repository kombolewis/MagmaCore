<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataRepository;

use Magma\Base\Exception\BaseException;
use Magma\LiquidOrm\LiquidOrmManager;

class DataRepositoryFactory
{
  protected string $tableSchema;
  
  protected string $tableSchemaID;
  
  protected  $crudIdentifier;

  public function __construct(string $crudIdentifier, string $tableSchema, string $tableSchemaID){
    $this->crudIdentifier = $crudIdentifier;
    $this->tableSchemaID = $tableSchemaID;
    $this->tableSchema = $tableSchema;

  }

  public function create(string $dataRepositoryString) {
    $em =  (new LiquidOrmManager($this->tableSchema, $this->tableSchemaID))->initialize();
    $dataRepositoryObject = new $dataRepositoryString($em);
    if(!$dataRepositoryObject instanceof DataRepositoryInterface) {
      throw new BaseException($dataRepositoryString.' Is not a valid repository object');
    }
    return $dataRepositoryObject;
  }
}

