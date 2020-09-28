<?php

namespace Oforge\Engine\Console\Commands\Doctrine;

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Monolog\Logger;
use Oforge\Engine\Console\Abstracts\AbstractCommand;
use Oforge\Engine\Console\Lib\Input;

/**
 * Class DoctrineOrmWrapperCommand
 *
 * @package Oforge\Engine\Console\Commands\Doctrine
 */
class DoctrineOrmWrapperCommand extends AbstractCommand {

    /**
     * DoctrineOrmWrapperCommand constructor.
     */
    public function __construct() {
        parent::__construct('orm', self::TYPE_EXTENDED);
        $this->setDescription('Run doctrine orm command or show list of commands');
    }

    /**
     * @inheritdoc
     */
    public function handle(Input $input, Logger $output) : void {
        $entityManager = Oforge()->DB()->getForgeEntityManager()->getEntityManager();
        $helperSet     = ConsoleRunner::createHelperSet($entityManager);
        $helperSet->set(new EntityManagerHelper($entityManager), 'em');
        $helperSet->set(new ConnectionHelper($entityManager->getConnection()), 'db');
        $_SERVER['argv'] = array_slice($_SERVER['argv'], 1);
        ConsoleRunner::run($helperSet, []);
    }

}
