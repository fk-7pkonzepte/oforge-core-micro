<?php

namespace Oforge\Engine\Core\Exceptions\Template;

use Exception;

/**
 * Class IllegalTemplateEngineException
 *
 * @package Oforge\Engine\Core\Exceptions\Template
 */
class IllegalTemplateEngineException extends Exception {

    /**
     * IllegalTemplateEngineException constructor.
     *
     * @param string $engineType
     */
    public function __construct(string $engineType) {
        parent::__construct("Config key '$engineType' exists but the call to '$engineType' is illegal.");
    }

}
