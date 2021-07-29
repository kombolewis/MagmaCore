<?php declare(strict_types=1);

namespace Magma\Twig;

use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
  public function getGlobals(): array
  {
    return [];
  }
}

