<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

interface DataMapperInterface
{
  /**
   * prepare the query string
   *
   * @param string $sqlQuery
   * @return self
   */
  public function prepare(string $sqlQuery) : self;

  /**
   * combination method which combines both methods above one of which is optimized 
   * for binding search queries once the second argument $type is set to search
   *
   * @param mixed $value
   * @return void
   */
  public function bind($value);

  /**
   * Explicit data type for the parameter using PDO::PARAM_* constants
   * 
   * @param array $fields
   * @param boolean $isSearch
   * @return mixed
   */
  public function bindParameters(array $fields, bool $isSearch = false) :self;

  /**
   * return number of rows in affected by a DELETE, INSERT, or UPDATE statement
   *
   * @return int|null
   */
  public function numRows() : int;

  /**
   * Execute the function that will execute the prepared statement
   *
   * @return void
   */
  public function execute() : void;
  
  /**
   * Returns a single database row as an object
   *
   * @return Object
   */
  public function result() : Object;
  
  /**
   * Return all the rows within the database as an array 
   *
   * @return array
   */
  public function results() : array;

  /**
   * Returns the last inserted row id from the database table
   *
   * @return integer
   * @throws Throwable
   */
  public function getLastId() :int;

}

