<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

interface CrudInterface
{
  /**
   * Returns the storage schema name as a string
   *
   * @return string
   */
  public function getSchema() :string;

  /**
   * Returns the primary key for the storage schema
   *
   * @return string
   */
  public function getSchemaID() :string;

  /**
   * Returns the last inserted id
   *
   * @return integer
   */
  public function lastID() :int;

  /**
   * Create method which inserts data within a certain storage table
   *
   * @param array $fields
   * @return boolean
   */
  public function create(array $fields) :bool;

  /**
   * Returns an array of database rows based on the individual supplied arguments
   *
   * @param array $selectors
   * @param array $conditions
   * @param array $parameters
   * @param array $optional
   * @return array
   */
  public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) :array;

  /**
   * Update method which updates 1 or more rows within the storage table
   *
   * @param array $fields
   * @param string $primaryKey
   * @return boolean
   */
  public function update(array $fields = [], string $primaryKey) :bool;

  /**
   * Delete will permanently delete  a row from the storage table
   *
   * @param array $conditions
   * @return boolean
   */
  public function delete(array $conditions = []) : bool;

  /**
   * Search method that returns queried search results
   *
   * @param array $selectors
   * @param array $conditions
   * @return array
   */
  public function search(array $selectors = [], array $conditions=[]) :array;

  /**
   * Returns a custom query string. The second argument can assign and associate array 
   * of conditions for the query string
   *
   * @param string $rawQuery
   * @param array $conditions
   * @return void
   */
  public function rawQuery(string $rawQuery, array $conditions = []);




}

