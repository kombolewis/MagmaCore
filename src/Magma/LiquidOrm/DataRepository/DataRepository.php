<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataRepository;

use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\LiquidOrm\EntityManager\EntityManagerInterface;
use Magma\LiquidOrm\DataRepository\DataRepositoryInterface;
use Magma\Utility\Helpers;
use Magma\Utility\Paginator;
use Magma\Utility\Sortable;

class DataRepository implements DataRepositoryInterface
{
  protected EntityManagerInterface $em;

  public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
  }

  private function isArray(array $conditions) :void {
    if(!\is_array($conditions)) {
      throw new BaseInvalidArgumentException('The argument supplied is not an array');
    }
  }

  private function isEmpty(int $id) :void {
    if(empty($id)) {
      throw new BaseInvalidArgumentException('Argument should not be empty');
    }
  }

  public function find(int $id) :array {
    $this->isEmpty($id);
    try {
      return $this->findOneBy(['id' => $id]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function findOneBy(array $conditions) : array {
    $this->isArray($conditions);

    try {
      return $this->em->getCrud()->read([], $conditions);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function findAll() :array {

    try {
      // return $this->em->getCrud()->read();
      return $this->findBy();
    } catch (\Throwable $th) {
      throw $th;
    }
  } 

  public function findBy(array $selectors = [], array $conditions = [], array $parameters= [], array $optional = []) : array {

    try {
      return $this->em->getCrud()->read($selectors, $conditions, $parameters, $optional);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function findObjectBy(array $conditions = [], array $selectors = []) :array {
    return [];
  }

  public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional) : array {
    $this->isArray($conditions);
   
    try {
      return $this->em->getCrud()->search($selectors, $conditions, $parameters, $optional);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function findByIdAndDelete(array $conditions) :bool {
    $this->isArray($conditions);
    try {
      $result = $this->findOneBy($conditions);
      if($result !=null && count($result) > 0) {
        $delete = $this->em->getCrud()->delete($conditions);
        if($delete) {
          return true;
        }
      } 
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function findByIdAndUpdate(array $fields, int $id) :bool {
    $this->isArray($fields);

    try {
      $result = $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id]);
      if($result != null && count($result) > 0) {
        $params = (!empty($fields)) ? array_merge(['id' => $id], $fields) :  $fields;
        $update = $this->em->getCrud()->update($params, $this->em->getCrud()->getSchemaID());
        if($update) return true;
        return false;
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function findWithSearchAndPaging(object $request, array $args) : array {
    list($conditions, $totalRecords) = $this->getCurrentQueryStatus($request, $args);
    $sorting = new Sortable($args['sort_columns']);
    $paging  = new Paginator($totalRecords, $args['records_per_page'],$request->query->getInt('page', 1));
    $parameters = [
      'limit' => $args['records_per_page'],
      'offset' => $paging->getOffset(),

    ];
    $optional = [
      'orderby' => $sorting->getColumn() . ' ' . $sorting->getDirection()
    ];
    
    if($request->query->getAlnum($args['filter_alias'])) {
      $searchRequest = $request->query->getAlnum($args['filter_alias']);
      for ($i=0; $i < count($args['filter_by']); $i++) { 
        $searchConditions = [$args['filter_by'][$i] => $searchRequest];
        
      }
      $results = $this->findBySearch($args['filter_by'], $searchConditions);
    } else {
      $queryConditions = array_merge($args['additional_conditions'], $conditions);
      $results = $this->findBy($args['selectors'], $queryConditions, $parameters, $optional);

    }
     
    return [
      $results, 
      $paging->getPage(),
      $paging->getTotalPages(),
      $totalRecords,
      $sorting->sortDirection(),
      $sorting->sortDescAsc(),
      $sorting->getClass()
    ];


  }

  private function getCurrentQueryStatus(object $request, array $args) {
    $totalRecords = 0;
    $req = $request->query;
    $status =  $req->getAlnum($args['query']);
    $searchResults =  $req->getAlnum($args['filter_alias']);
    if($searchResults) {
      for ($i=0; $i < count($args['filter_by']); $i++) { 
        $conditions = [$args['filter_by'][$i] => $searchResults];
        $totalRecords = $this->em->getCrud()->countRecords($conditions, $args['filter_by'][$i]);

      }
    } else if($status) {
      $conditions = [$args['query'] => $status];
      $totalRecords = $this->em->getCrud()->countRecords($conditions);

    } else {
      $conditions = [];
      $totalRecords = $this->em->getCrud()->countRecords($conditions);
    }

    return [$conditions,$totalRecords];
  }

  public function findAndReturn(int $id, array $selectors) : self {
    return $this;
  }

  
}

