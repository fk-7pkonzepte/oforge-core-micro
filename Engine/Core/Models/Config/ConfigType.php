<?php

namespace Oforge\Engine\Core\Models\Config;

/**
 * Class ConfigType
 *
 * @package Oforge\Engine\Core\Models\Config
 */
class ConfigType {
    public const DEFAULT  = self::STRING;
    public const BOOLEAN  = 'boolean';
    public const INTEGER  = 'integer';
    public const NUMBER   = 'number';
    public const PASSWORD = 'password';
    public const SELECT   = 'select';
    public const STRING   = 'string';
}
