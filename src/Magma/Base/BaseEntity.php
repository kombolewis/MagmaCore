<?php declare(strict_types=1);

namespace Magma\Base;

use Magma\Utility\Sanitizer;
use Magma\Base\Exception\BaseInvalidArgumentException;

class BaseEntity
{
  /**
   * main class constructor.
   */
  public function __construct(array $dirtyData) {
    if(empty($dirtyData)) {
      throw new BaseInvalidArgumentException('No Data was Submitted');
    }
    if(is_array($dirtyData)) {
      foreach($this->cleanData($dirtyData) as $key => $value) {
        $this->$key = $value;
      }
    }
  }

	public function cleanData(array $dirtyData) :array {
    $cleanData = Sanitizer::clean($dirtyData);
    
    if($cleanData) {
      return $cleanData;
    }
	}
}

