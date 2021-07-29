<?php
namespace Magma\Datatable;

use Magma\Base\Exception\BaseUnexpectedValueException;
use Magma\Datatable\AbstractDatatable;
use Magma\Datatable\DatatableColumnInterface;
use Magma\Utility\Helpers;

class Datatable extends AbstractDatatable
{
  protected string $element = '';
  /**
   * Class constructor.
   */
  public function __construct() {
    parent::__construct();
  }

  public function create(string $dataColumnString, array $dataRepository = [], array $sortContoller = []) :self {
    $this->dataColumnObject = new $dataColumnString;
    if(!$this->dataColumnObject instanceof DatatableColumnInterface) {
      throw new BaseUnexpectedValueException($dataColumnString. ' is not a valid dataColumn object');
    }
    $this->dataColumns = $this->dataColumnObject->columns();
    $this->sortController = $sortContoller;
    $this->getRepositoryParts($dataRepository);
    return $this;
  }

  /**
   * 
   *
   * @param array $dataRepository
   * @return void
   */
  private function getRepositoryParts(array $dataRepository) :void{
    list(
      $this->dataOptions,
      $this->currentPage,
      $this->totalPages,
      $this->totalRecords,
      $this->direction,
      $this->sortDirection,
      $this->tdClass,
      $this->tableColumn,
      $this->tableOrder,
    ) = $dataRepository;
  }


  public function table() :?string {
    extract($this->attr);

    $this->element .= $before;
    if(is_array($this->dataColumns) && count($this->dataColumns) > 0) {
      if(is_array($this->dataOptions) && $this->dataOptions != null) {
        $this->element .= '<table id="'. (isset($table_id) ? $table_id : '') .'"  class="'.implode(' ', $table_class).'">';
        $this->element .= ($show_table_thead) ? $this->tableGridElements($status) : '';
        $this->element .= '<tbody>';
          foreach($this->dataOptions as $row) {
            $this->element .= '<tr>';
            foreach($this->dataColumns as $column) {
              if(isset($column['show_column']) && $column['show_column'] != false) { 
                $this->element .= '<td class="'.$column['class'].'">';
                if(is_callable($column['formatter'])) {
                  $this->element .= call_user_func_array($column['formatter'], [$row]);
                } else {
                  $this->element .= (isset($row[$column['db_row']]) ? $row[$column['db_row']] : '');
                }
                $this->element .= '</td>';
              }

            }
            $this->element .= '</tr>';

          }
        $this->element .= '</tbody>';
        // $this->element .= ($show_table_tfoot) ? $this->tableGridElements($status, true) : '';

        $this->element .= '</table>';

      }
    }
    $this->element .= $after;
    return $this->element;

  }

  public function pagination() : ?string {
    $element = '';
    $element .= sprintf('Showing %s - %s of %s', $this->currentPage, $this->totalPages, $this->totalRecords);
    $queryStatus = ($this->sortController['query'] ? $this->sortController['query'] : '');
    $status = (isset($_GET[$queryStatus]) ? $_GET[$queryStatus] : '');
    if($this->currentPage == 1) {
      $element .= sprintf('<a href="%s"> Previous', 'javascript:void(0)');
    } else {
      if($status) {
        $element .= sprintf('<a href="?'.$queryStatus.'%s&page=%s">', $status, ($this->currentPage - 1));
      } else {
        $element .= sprintf('<a href="?page=%s">', ($this->currentPage - 1));
      }
    }
    $element .= ' Previous </a>';

    if($this->currentPage  ==  $this->totalPages){
      $element .= sprintf('<a href="%s"> Next', 'javascript:void(0)');
    } else {
      if($status) {
        $element .= sprintf('<a href="?'.$queryStatus.'%s&page=%s">', $status, ($this->currentPage + 1));
      } else {
        $element .= sprintf('<a href="?page=%s">', ($this->currentPage + 1));
      }
    }
    $element .= ' Next </a>';
    
    return $element;

  }


	private function tableGridElements(string $status, bool $inFoot = false) :string {
    $element = sprintf('<%s>', ($inFoot) ? 'tfoot' : 'thead');
    $element .= '<tr>';
      foreach($this->dataColumns as $column) {
        if(isset($column['show_column']) && $column['show_column'] != false) {
          $element .= '<th>';
          $element .= $this->tableSorting($column, $status);
          $element .= '</th>';
        }
      }
    $element .= '</tr>';
    $element .= sprintf('</%s>', ($inFoot) ? 'tfoot' : 'thead');
    return $element;
  }

  private function tableSorting(array $column, string $status) {
    $element = '';
    if(isset($column['sortable']) && $column['sortable'] != false) {
      $element .= '<a class="uk-link-reset" href="'.$this->defineHrefAttr($column, $status).'" >';
      $element .= $column['dt_row'];
      $element .= '<i class="fas fa-sort'.($this->tableColumn == $column['db_row'] ? '-' . $this->direction : '').'"></i>';
      $element .= '</a>';
    } else {
      $element .= $column['dt_row'];
    }
    return $element;
  }

  private function defineHrefAttr(array $column, string $status){
    if($status){
      return '?status=' . $status . '&column=' . $column['db_row'] . '&order' . $this->sortDirection . '';
    } 
    return '?column=' . $column['db_row'] . '&order=' . $this->sortDirection . '';
  }



  

}

