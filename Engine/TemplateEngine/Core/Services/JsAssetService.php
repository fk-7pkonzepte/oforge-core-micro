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
use MatthiasMullie\Minify\JS;
use Oforge\Engine\Core\Exceptions\ServiceNotFoundException;
use Oforge\Engine\Core\Exceptions\Template\TemplateNotFoundException;
use Oforge\Engine\Core\Helper\Statics;

class JsAssetService extends BaseAssetService {
    /**
     * JsAssetService constructor.
     *
     * @throws ServiceNotFoundException
     */
    public function __construct() {
        parent::__construct();
        $this->key = "js";
    }

    /**
     * @param string $scope
     * @param string $context
     *
     * @return string
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ServiceNotFoundException
     * @throws TemplateNotFoundException
     */
    public function build(string $context, string $scope = TemplateAssetService::DEFAULT_SCOPE) : string {
        parent::build($context);

        $dirs             = $this->getAssetsDirectories();
        $hasFilesToMinify = false;

        $fileName = "scripts." . bin2hex(openssl_random_pseudo_bytes(16));

        $folder     = Statics::ASSET_CACHE_DIR . Statics::GLOBAL_SEPARATOR . $scope . Statics::GLOBAL_SEPARATOR . $this->key;
        $fullFolder = ROOT_PATH . $folder;
        $output     = $folder . Statics::GLOBAL_SEPARATOR . $fileName;
        $outputFull = ROOT_PATH . $output;

        if (!file_exists($fullFolder) || (file_exists($fullFolder) && !is_dir($fullFolder))) {
            mkdir($fullFolder, 0750, true);
        }

        //iterate over all plugins, current theme and base theme
        foreach ($dirs as $dir) {
            $folder = $dir . Statics::GLOBAL_SEPARATOR . $scope . Statics::GLOBAL_SEPARATOR . Statics::ASSETS_DIR . Statics::GLOBAL_SEPARATOR . Statics::ASSETS_JS
                      . Statics::GLOBAL_SEPARATOR;
            if (file_exists($folder) && file_exists($folder . Statics::ASSETS_IMPORT_JS)) {
                if ($file = fopen($folder . Statics::ASSETS_IMPORT_JS, "r")) {
                    while (!feof($file)) {
                        $line = trim(fgets($file));

                        if (strlen($line) > 0 && file_exists($folder . $line)) {
                            file_put_contents($outputFull . ".js", file_get_contents($folder . $line), FILE_APPEND);
                            $hasFilesToMinify = true;
                        }
                    }
                    fclose($file);
                }
            }
        }

        if ($hasFilesToMinify) {
            $minifier = new JS($outputFull . ".js");
            $minifier->minify($outputFull . ".min.js");
            $output = str_replace('\\', '/', $output);
            $this->storage->set($this->getAccessKey($scope), $output . ".min.js");
            $this->removeOldAssets($fullFolder, $fileName, ".js");

            return $output . ".min.js";
        }

        return "";
    }
}
