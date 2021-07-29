<?php
declare(strict_types=1);

namespace Magma\Utility;

class Paginator
{
  protected float $totalPages;
  protected float $offset;
  protected int $page;

  public function __construct(float $totalRecords, int $recordsPerPage, int $page)
  {
    $this->totalPages = ceil($totalRecords / $recordsPerPage);
    $this->page = filter_var($page, FILTER_VALIDATE_INT);
    $this->offset = $recordsPerPage * ($this->page - 1);
  }

  public function getOffset() :int {
    return (int)$this->offset;
  }


  public function getPage() :int {
    return $this->page;
  }


  public function getTotalPages() {
    return $this->totalPages;
  }
}

