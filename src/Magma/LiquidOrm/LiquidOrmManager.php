<?php declare(strict_types=1);
namespace Magma\LiquidOrm;

use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\DataMapper\DataMapperFactory;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderFactory;
use Magma\LiquidOrm\EntityManager\EntityManagerFactory;
use Magma\LiquidOrm\DataMapper\DataMapperEnvironmentConfiguration;
use Magma\LiquidOrm\EntityManager\Crud;

class LiquidOrmManager
{
  protected string $tableSchema;
  
  protected string $tableSchemaID;

  protected DataMapperEnvironmentConfiguration $environmentConfiguration;

  protected array $options;

  public function __construct(string $tableSchema, string $tableSchemaID, array $options = []) {
    // $this->environmentConfiguration = $environmentConfiguration;
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
        $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
        return $entityManagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchemaID, $this->options);

      }
    }
  }

}

