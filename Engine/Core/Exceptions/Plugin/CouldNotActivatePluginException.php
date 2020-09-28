<?php

namespace Oforge\Engine\Core\Exceptions\Plugin;

use Exception;

/**
 * Class CouldNotActivatePluginException
 *
 * @package Oforge\Engine\Core\Exceptions
 */
class CouldNotActivatePluginException extends Exception {
    /** @var string[] $dependencies */
    private $dependencies;

    /**
     * CouldNotActivatePluginException constructor.
     *
     * @param string $className
     * @param string[] $dependencies
     */
    public function __construct(string $className, $dependencies) {
        parent::__construct("The plugin $className could not be activated due to missing / not installed / not activated dependencies. Missing plugins: "
                            . implode(', ', $dependencies));
        $this->dependencies = $dependencies;
    }

    /** @return string[] */
    public function getDependencies() {
        return $this->dependencies;
    }

}
