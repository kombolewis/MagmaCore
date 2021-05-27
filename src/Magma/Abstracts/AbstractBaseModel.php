<?php declare(strict_types=1);

namespace Magma\Abstracts;

use Magma\Base\BaseModel;

abstract class AbstractBaseModel extends BaseModel
{
  /**
   * Undocumented function
   *
   * @return array
   */
  abstract public function guardedID(): array;
}

