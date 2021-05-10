<?php
namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;
use Magma\LiquidOrm\QueryBuilder\Exception\QueryBuilderException;

class QueryBuilderFactory
{
  /**
   * Main constructor method
   * 
   * @return void
   */

   public function __construct() {
   
  }
  

	public function create(string $queryBuilderString) :QueryBuilderInterface {
    $queryBuilderObject = new $queryBuilderString;

    if(!$queryBuilderObject instanceof QueryBuilderInterface) {
      throw new QueryBuilderException($queryBuilderString .'is not a valid Query Builder object');
    }
    return new QueryBuilder;
  }
}

