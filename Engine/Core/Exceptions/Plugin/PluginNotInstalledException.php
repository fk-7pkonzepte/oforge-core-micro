<?php

namespace Oforge\Engine\Core\Exceptions\Plugin;

use Exception;

/**
 * Class PluginNotInstalledException
 *
 * @package Oforge\Engine\Core\Exceptions
 */
class PluginNotInstalledException extends Exception {

    /**
     * PluginNotInstalledException constructor.
     *
     * @param $pluginName
     */
    public function __construct($pluginName) {
        parent::__construct("The plugin '$pluginName' is not installed. You have to install it first.");
    }

}
