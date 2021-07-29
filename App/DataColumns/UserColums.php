<?php declare(strict_types=1);

namespace App\DataColumns;

use Magma\Datatable\AbstractDatatableColumn;

class UserColums extends AbstractDatatableColumn
{ 
  public function columns(): array {
    return [
      [
        'db_row' => 'id',
        'dt_row' => 'ID',
        'class' => '',
        'show_column' => true,
        'sortable' => true,
        'formatter' => '',

      ],
      [
        'db_row' => 'fname',
        'dt_row' => 'Firstname',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'lname',
        'dt_row' => 'Lastname',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'email',
        'dt_row' => 'Email Address',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'status',
        'dt_row' => 'Status',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'created_at',
        'dt_row' => 'Published',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'updated_at',
        'dt_row' => 'Updated',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'gravatar',
        'dt_row' => 'Thumbnail',
        'class' => '',
        'show_column' => false,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => 'ip',
        'dt_row' => 'IP Address',
        'class' => '',
        'show_column' => false,
        'sortable' => false,
        'formatter' => '',

      ],
      [
        'db_row' => '',
        'dt_row' => 'Action',
        'class' => '',
        'show_column' => true,
        'sortable' => false,
        'formatter' => '',

      ]
    ];
  }
}

