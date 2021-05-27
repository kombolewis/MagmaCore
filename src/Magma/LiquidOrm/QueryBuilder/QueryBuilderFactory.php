<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\QueryBuilder;

use Magma\Base\Exception\BaseException;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;

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
      throw new BaseException($queryBuilderString .'is not a valid Query Builder object');
    }
    return  $queryBuilderObject;
  }
}

