<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection;

interface DatabaseConnectionInterface
{
  /**
   * Creates a new database connection
   *
   * @return PDO
   */
  public function open() : PDO;

  /**
   * Close database connection
   *
   * @return void
   */
  public function close() : void;
}

