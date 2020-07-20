<?php
/**
 * 扩展配置文件
 * User: Master King
 * Date: 2019/3/6
 */

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

$config = [];
$configPath = realpath(app('app')->basePath().DIRECTORY_SEPARATOR.'service');
function getNestedDirectory(SplFileInfo $file, $configPath)
{
    $directory = $file->getPath();

    if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
        $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
    }

    return $nested;
}
$files = [];
foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
    $directory = getNestedDirectory($file, $configPath);

    $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
}
ksort($files, SORT_NATURAL);
foreach ($files as $key => $path) {
    $config[$key] = require $path;
}

return $config;