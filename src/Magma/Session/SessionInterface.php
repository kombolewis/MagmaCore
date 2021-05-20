<?php

declare(strict_types=1);

namespace Magma\Session;

interface SessionInterface
{
  public function set(string $key, $value): void;

  public function setArray(string $key, $value): void;

  public function get(string $key, $default = null): void;

  public function delete(string $key): void;

  public function invalidate(): void;

  public function flush(string $key, $value): void;

  public function has(string $key): void;




}

