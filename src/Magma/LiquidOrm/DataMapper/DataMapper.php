<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use PDO;
use Exception;
use PDOStatement;
use Magma\Base\Exception\BaseNoValueException;
use Magma\LiquidOrm\DataMapper\DataMapperInterface;
use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\DatabaseConnection\DatabaseConnectionInterface;
use Magma\Utility\Helpers;

class DataMapper implements DataMapperInterface
{
  /**
   * @var DatabaseConnectionInterface
   */
  private DatabaseConnectionInterface $dbh;

  /**
   * @var PDOStatement
   */
  private PDOStatement $statement;

  /**
   * main constructor
   */
  public function __construct(DatabaseConnectionInterface $db) {
    $this->dbh = $db;
  }

  /**
   * checks if value is empty
   *
   * @param [type] $value
   * @param string $errorMessage
   * @return boolean
   */
  private function isEmpty($value, string $errorMessage = null) {
    if(empty($value)) {
      throw new BaseNoValueException($errorMessage);
    }
  }
  private function isArray(array $value) {
    if(!is_array($value)) {
      throw new BaseInvalidArgumentException('Argument requires type array');
    }
  }
  /**
   * @inheritDoc
   */
  public function prepare(string $sqlQuery) :self {
    $this->statement = $this->dbh->open()->prepare($sqlQuery);
    return $this;

  }

  /**
   * @inheritDoc
   *
   */
  public function bind($value) {
    try {
      switch($value){
        case \is_bool($value):
        case intval($value):
          $dataType = PDO::PARAM_INT;
          break;
        case \is_null($value):
          $dataType = PDO::PARAM_NULL;
          break;
        default:
          $dataType = PDO::PARAM_STR;
          break;
      }
      return $dataType;
    } catch (Exception $exception) {
      throw $exception;
    }
  }

  /**
   * @inheritDoc 
   */
  public function bindParameters(array $fields, bool $isSearch = false) :self {
    if(is_array($fields)) {
      $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
      if($type) {
        return $this;
      }
    }
    return false;
  }
  /**
   * Bind value to corresponding placeholder e.g '?' in the
   * sql statement
   *
   * @param array $fields
   * @return PDOStatement
   * @throws BaseInvalidArgumentException
   */
  protected function bindValues(array $fields) :PDOStatement{
    $this->isArray($fields);
    foreach($fields as $key => $value) {
      $this->statement->bindValue(':' . $key, $value, $this->bind($value));
    }
    return $this->statement;

  }

  /**
   * pass in associative array and have it automatically bound but with search 
   *
   * @param array $fields
   * @return void
   */
  protected function bindSearchValues(array $fields) {
    $this->isArray($fields);
    foreach($fields as $key => $value) {
      $this->statement->bindValue(':' . $key, '%' . $value . '%', $this->bind($value));
    }
    return $this->statement;

  }

  /**
   * @inheritDoc
   *
   */
  public function execute()  {
    if($this->statement) return $this->statement->execute();
  }

  /**
   * @inheritDoc
   *
   */
  public function numRows() :int {
    if($this->statement) return $this->statement->rowCount();
  }

  /**
   * @inheritDoc
   *
   */
  public function result() : object {
    if($this->statement) return $this->statement->fetch(PDO::FETCH_OBJ);
  }

  /**
   * @inheritDoc
   *
   */
  public function results() : array {
    if($this->statement) return $this->statement->fetchAll();
  }

  /**
   * @inheritDoc
   *
   */
  public function getLastId() : int {
    try {
      if($this->dbh->open()) {
        $lastID = $this->dbh->open()->lastInsertId();
        if(!empty($lastID)) {
          return intval($lastID);
        }
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function buildQueryParameters(array $conditions = [], array $parameters = []) {
    return (!empty($parameters) || !empty($conditions)) ? array_merge($conditions,$parameters) : $parameters ;
  }

  public function persist(string $sqlQuery, array $parameters) {
    try {
      return $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * @inheritDoc
   *
   */
  public function column() {
    if($this->statement) return $this->statement->fetchColumn();
  }
}

