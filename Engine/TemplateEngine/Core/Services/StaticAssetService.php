<?php
/**
 * Created by PhpStorm.
 * User: Matthaeus.Schmedding
 * Date: 07.11.2018
 * Time: 10:39
 */

namespace Oforge\Engine\TemplateEngine\Core\Services;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Oforge\Engine\Core\Exceptions\ServiceNotFoundException;
use Oforge\Engine\Core\Exceptions\Template\TemplateNotFoundException;
use Oforge\Engine\Core\Helper\Statics;

class StaticAssetService extends BaseAssetService {

    /**
     * @param string $context
     * @param string $scope
     *
     * @return string
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ServiceNotFoundException
     * @throws TemplateNotFoundException
     */
    public function build(string $context, string $scope = TemplateAssetService::DEFAULT_SCOPE) : string {
        $dirs = $this->getAssetsDirectories();

        $output     = Statics::ASSET_CACHE_DIR . Statics::GLOBAL_SEPARATOR . $scope . Statics::GLOBAL_SEPARATOR;
        $outputFull = ROOT_PATH . $output;

        $copyFolders = ["img", "fonts"];

        //iterate over all plugins, current theme and base theme
        foreach ($dirs as $dir) {
            $baseFolder = $dir . Statics::GLOBAL_SEPARATOR . $scope . Statics::GLOBAL_SEPARATOR . Statics::ASSETS_DIR . Statics::GLOBAL_SEPARATOR;

            foreach ($copyFolders as $copy) {
                $folder = $baseFolder . $copy;

                if (file_exists($folder) && is_dir($folder)) {
                    if (!file_exists($outputFull . $copy) || (file_exists($outputFull . $copy) && !is_dir($outputFull . $copy))) {
                        mkdir($outputFull . $copy, 0750, true);
                    }

                    $this->recurseCopy($folder, $outputFull . $copy);
                }
            }
        }

        return "";
    }

    /**
     * @param $source
     * @param $dest
     */
    private function recurseCopy($source, $dest) {
        if (is_dir($source)) {
            $dir_handle = opendir($source);
            while ($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (is_dir($source . "/" . $file)) {
                        if (!is_dir($dest . "/" . $file)) {
                            mkdir($dest . "/" . $file);
                        }
                        $this->recurseCopy($source . "/" . $file, $dest . "/" . $file);
                    } else {
                        copy($source . "/" . $file, $dest . "/" . $file);
                    }
                }
            }
            closedir($dir_handle);
        } else {
            copy($source, $dest);
        }
    }
}
