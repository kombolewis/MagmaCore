<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataRepository;

use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\LiquidOrm\EntityManager\EntityManagerInterface;
use Magma\LiquidOrm\DataRepository\DataRepositoryInterface;

class DataRepository implements DataRepositoryInterface
{
  protected EntityManagerInterface $em;

  public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
  }

  private function isArray(array $conditions) :void {
    if(\is_array($conditions)) {
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

  public function findWithSearchAndPaging(array $args, object $request) : array {
    return [];
  }

  public function findAndReturn(int $id, array $selectors) : self {
    return $this;
  }

  
}

