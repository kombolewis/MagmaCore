<?php
namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;

abstract class AbstractQueryBuilder implements QueryBuilderInterface
{
  protected array $key;

  protected string $sqlQuery;

  protected const SQL_DEFAULT = [
    'conditions' => [],
    'selectors' => [],
    'replace' => false,
    'distinct' => false,
    'from' => [],
    'and' => [],
    'or' => [],
    'orderBy' => [],
    'fields' => [],
    'primary_key' => '',
    'table' => '',
    'type' => '',
    'raw' => '',
  ];


  protected const QUERY_TYPES = ['insert','select','update','delete','raw','search', 'join'];

  public function __construct(){
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  protected function orderByQuery() {
    //append the orderby statement if set
    if(isset($this->key['extras']['orderby']) && $this->key['extras']['orderby'] != '') {
      $this->sqlQuery .= " ORDER BY " . $this->key['extras']['orderby'];
    }
  }

  /**
   *
   * @return void
   */
  protected function queryOffset() {
    //append the limit and offset statement for adding pagination to the query
    if(isset($this->key['params']['limit']) && $this->key['params']['offset'] != -1) {
      $this->sqlQuery .= ' LIMIT :offset, :limit';
    }
  }


  /**
   *
   * @param string $type
   * @return boolean
   */
  protected function isQueryTypeValid(string $type) : bool {
    if(\in_array($type, self::QUERY_TYPES)) return true;
    return false;
  }

  /**
   *
   * @param string $key
   * @return boolean
   */
  protected function has(string $key) :bool {
    return isset($this->key[$key]);
  }

}

