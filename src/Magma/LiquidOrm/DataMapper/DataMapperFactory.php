<?php
declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\Yaml\YamlConfig;
use Magma\Base\Exception\BaseException;
use Magma\LiquidOrm\DataMapper\DataMapper;
use Magma\LiquidOrm\DataMapper\DataMapperInterface;
use Magma\DatabaseConnection\DatabaseConnectionInterface;

class DataMapperFactory
{
  /**
   * Main constructor class
   * 
   * @return void
   */
  public function __construct() {

  }

  public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration) :DataMapperInterface {
    $credentials = (new $dataMapperEnvironmentConfiguration(YamlConfig::file('database')))->getDatabaseCredentials('mysql');
    $databaseConnectionObject = new $databaseConnectionString($credentials);

    if(!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
      throw new BaseException($databaseConnectionString .'string is not a valid database connection object');
    }
    return new DataMapper($databaseConnectionObject);
  }
}

