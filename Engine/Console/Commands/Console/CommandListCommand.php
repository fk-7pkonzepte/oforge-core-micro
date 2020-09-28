<?php

namespace Oforge\Engine\Console\Commands\Console;

use GetOpt\Command;
use GetOpt\Operand;
use GetOpt\Option;
use Monolog\Logger;
use Oforge\Engine\Console\Abstracts\AbstractCommand;
use Oforge\Engine\Console\Lib\Input;
use Oforge\Engine\Console\Services\ConsoleService;
use Oforge\Engine\Core\Exceptions\ServiceNotFoundException;

/**
 * Class CommandListCommand
 *
 * @package Oforge\Engine\Console\Commands\Core
 */
class CommandListCommand extends AbstractCommand {

    /**
     * CommandListCommand constructor.
     */
    public function __construct() {
        parent::__construct('list', self::TYPE_DEFAULT);
        $this->setDescription('Display command list');
        $this->addOperands([
            Operand::create('filter', Operand::OPTIONAL)#
                   ->setDescription('Optional command prefix for filtering')#
                   ->setDefaultValue(''),#
        ]);
        $this->addOptions([
            Option::create('e', 'extended')#
                  ->setDescription('Include extended commands')#
                  ->setDefaultValue(0),#
            Option::create(null, 'cronjob')#
                  ->setDescription('Display only cronjob commands')#
                  ->setDefaultValue(0),#
            Option::create(null, 'dev')#
                  ->setDescription('Display only development commands')#
                  ->setDefaultValue(0),#
        ]);
    }

    /**
     * @inheritdoc
     * @throws ServiceNotFoundException
     */
    public function handle(Input $input, Logger $output) : void {
        $listType = self::TYPE_DEFAULT;
        if ($input->getOption('cronjob')) {
            $listType = self::TYPE_CRONJOB;
        } elseif ($input->getOption('dev')) {
            $listType = self::TYPE_DEVELOPMENT;
        } elseif ($input->getOption('extended')) {
            $listType |= self::TYPE_EXTENDED;
        }
        $prefix       = $input->getOperand('filter');
        $prefixLength = strlen($prefix);
        /** @var ConsoleService $consoleService */
        $consoleService = Oforge()->Services()->get('console');
        $commands       = $consoleService->getCommands($listType);
        if ($prefixLength > 0) {
            $commands = array_filter($commands, function ($command) use ($prefix, $prefixLength) {
                /** @var Command $command */
                return substr($command->getName(), 0, $prefixLength) === $prefix;
            });
        }
        echo $consoleService->getRenderer()->renderCommands($commands, false);
    }

}
