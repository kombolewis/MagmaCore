<?php declare(strict_types=1);

namespace Magma\Datatable;

use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\Datatable\DatatableInterface;

abstract class AbstractDatatable implements DatatableInterface
{
  protected const TABLE_PROPERTIES = [
    'status' => '',
    'orderby' => '',
    'table_class' => ['uk-table'],
    'table_id' => 'datatable',
    'show_table_thead' => true,
    'show_table_tfoot' => true,
    'before' => '<div>',
    'after' => '</div>' 
  ];

  protected const COLUMNS_PARTS = [
    'db_row' => '',
    'dt_row' => '',
    'class' => '',
    'show_column' => true,
    'sortable' => false,
    'formatter' => '',
  ];

  protected array $attr = [];

  /**
   * Class constructor.
   */
  public function __construct() {

    $this->attr = self::TABLE_PROPERTIES;
    foreach($this->attr  as $key => $value) {
      if(!$this->validAttributes($key, $value)) {
        $this->validAttributes($key, self::TABLE_PROPERTIES[$key]);
      }
    }
  }

  public function setAttr($attributes = []) :self{
    if(is_array($attributes) && count($attributes) > 0) {
      $propKeys = array_keys(self::TABLE_PROPERTIES);
      foreach($attributes as $key => $value) {
        if(!in_array($key, $propKeys)) {
          throw new BaseInvalidArgumentException('Invalid Argument set');
        }
        $this->validAttributes($key, $value);
        $this->attr[$key] = $value;
      }
    }
    return $this;
  }


  /**
   * validate attributtes
   *
   * @param string $key
   * @param [type] $value
   * @return void
   */
	private function validAttributes(string $key, $value) {
		if(empty($key)) {
      throw new BaseInvalidArgumentException('Invalid or empty attribute key. Ensure the key is present and of the correct datatype.');
    }
    switch($key) {
      case 'status':
      case 'orderby':
      case 'table_id':
      case 'before':
      case 'after':
        if(!is_string($value)) {
          throw new BaseInvalidArgumentException('Invalid argument type '.$value.' should be a string');
        }
        break;
      case 'show_table_thead':
      case 'show_table_tfoot':
        if(!is_bool($value)) {
          throw new BaseInvalidArgumentException('Invalid argument type '. $value .'should be a boolean');
        }
        break;
      case 'table_class':
        if(!is_array($value)) {
          throw new BaseInvalidArgumentException('Invalid argument type '. $value .'should be array');
        }
        break;
    }
    $this->attr[$key] = $value;
  }
  

}

