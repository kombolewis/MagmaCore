<?php declare(strict_types=1);

namespace Magma\Utility;

use Magma\Base\Exception\BaseInvalidArgumentException;

class Sortable
{
  protected array $columns;
  protected string $column;
  protected string $order;
  protected string $direction;
  protected string $sortDirection = '';
  protected string $class = 'highlight';


  /**
   * Class constructor.
   */
  public function __construct(array $columns) {
    if(empty($columns)) {
      throw new BaseInvalidArgumentException('invalid Argument please specify a default columns array');
    }
    $this->columns = $columns;
  }

  public function getColumn() : string {
    if(is_array($this->columns)) {
      $this->column = isset($_GET['column']) && in_array($_GET['column'], $this->columns) ? $_GET['column'] : $this->columns[0];
      if($this->column) return $this->column;
    }
  }

  public function getDirection() :string{
    $this->order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
    if($this->order) return $this->order;
  }


  public function sortDirection() :string {
    $this->direction = str_replace(array('ASC', 'DESC'), array('up', 'down'), $this->getDirection());
    if($this->direction) return $this->direction;
  }

  public function sortDescAsc() :string {
    if($this->getDirection()) return $this->getDirection() == 'ASC' ? 'desc' : 'asc';
  }

  public function getClass() {
    return $this->class;
  }

}

