<?php

namespace Oforge\Engine\TemplateEngine\Core\Exceptions;

/**
 * Class InvalidScssVariableException
 *
 * @package Oforge\Engine\Core\Exceptions\Template
 */
class InvalidScssVariableException extends \Exception {
    /** @var null */
    private $invalidVariables;

    /**
     * InvalidScssVariableException constructor.
     *
     * @param string $missingOption
     * @param null $invalidVariables
     */
    public function __construct(string $missingOption, $invalidVariables = null) {
        parent::__construct("Invalid variable. Missing option $missingOption. " . implode(', ', $invalidVariables));
        $this->invalidVariables = $invalidVariables;
    }

    /**
     * @return null
     */
    public function getInvalidVariables() {
        return $this->invalidVariables;
    }

}
