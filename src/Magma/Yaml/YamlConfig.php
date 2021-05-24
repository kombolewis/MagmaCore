<?php declare(strict_types=1);

namespace Magma\Yaml;

use Magma\Yaml\YamlConfig;
use Symfony\Component\Yaml\Yaml;
use Magma\Base\Exception\BaseException;

class YamlConfig
{
  private function isFileExists(string $filename) {
    if(!\file_exists($filename)) {
      throw new BaseException($filename . 'does not exist');
    }
  }

  public function getYaml($yamlFile) {
    foreach(glob(CONFIG_PATH . DS . '*.yaml') as $file) {
      $this->isFileExists($file);
      $parts = parse_url($file);
      $path = $parts['path'];
      if(\strpos($path, $yamlFile) !== false) {
        return Yaml::parseFile($file);
      }
    }
  }
  public static function file(string $yamlFile) {
    return (new YamlConfig)->getYaml($yamlFile);
  }
}

