<?php declare(strict_types=1);

namespace App\Entity;

use Magma\Base\BaseEntity;

class UserEntity extends BaseEntity
{
  /**
   * main constructor.
   */
  public function __construct(array $dirtyData) {
   parent::__construct($dirtyData);
  }
}

