<?php
namespace Magma\LiquidOrm;

use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\DataMapper\DataMapperFactory;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderFactory;
use Magma\LiquidOrm\EntityManager\EntityManagerFactory;
use Magma\LiquidOrm\DataMapper\DataMapperEnvironmentConfiguration;

class LiquidOrmManager
{
  protected string $tableSchema;
  
  protected string $tableSchemaID;

  protected DataMapperEnvironmentConfiguration $environmentConfiguration;

  protected array $options;

  public function __construct(DataMapperEnvironmentConfiguration $environmentConfiguration, string $tableSchema, string $tableSchemaID, array $options = []) {
    $this->environmentConfiguration = $environmentConfiguration;
    $this->tableSchema = $tableSchema;
    $this->tableSchemaID = $tableSchemaID;
    $this->options = $options;

  }

  public function initialize()  {
    $dataMapperFactory = new DataMapperFactory();
    $dataMapper =  $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnvironmentConfiguration::class);
    if($dataMapper) {
      $queryBuilderFactory = new QueryBuilderFactory();
     $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
      if($queryBuilder) {
        $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder, $this->options);

      }
    }
  }

}

