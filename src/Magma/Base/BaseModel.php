<?php declare(strict_types=1);


namespace Magma\Base;

use Magma\LiquidOrm\DataRepository\DataRepository;
use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\LiquidOrm\DataRepository\DataRepositoryFactory;

class BaseModel
{
  private string $tableSchema;
  
  private string $tableSchemaID;

  private object $repository;


  public function __construct(string $tableSchema, string $tableSchemaID) {
    if(empty($tableSchema) || empty($tableSchemaID)) {
      throw new BaseInvalidArgumentException('These arguments are required');
    }

    $factory =  new DataRepositoryFactory('', $tableSchema, $tableSchemaID);
    $this->repository = $factory->create(DataRepository::class);
  }

  public function getRepo() {
    return $this->repository;
  }
}

