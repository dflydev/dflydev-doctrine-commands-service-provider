<?php

/*
 * This file is part of the dflydev/doctrine-commands-service-provider
 *
 * The code was originally distributed inside the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 * (c) Doctrine Project, Benjamin Eberlei <kontakt@beberlei.de>
 * (c) Dragonfly Development, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Silex\Provider\DoctrineCommands\Command;

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Database tool allows you to easily drop and create your configured databases.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Beau Simensen <beau@dflydev.com>
 */
class CreateDatabaseCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:database:create')
            ->setDescription('Creates the configured databases')
            ->addOption('connection', null, InputOption::VALUE_OPTIONAL, 'The connection to use for this command')
            ->setHelp(<<<EOT
The <info>doctrine:database:create</info> command creates the default
connections database:

<info>console doctrine:database:create</info>

You can also optionally specify the name of a connection to create the
database for:

<info>console doctrine:database:create --connection=default</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getDoctrineConnection($input->getOption('connection'));

        $params = $connection->getParams();
        $name = isset($params['path']) ? $params['path'] : $params['dbname'];

        unset($params['dbname']);

        $tmpConnection = DriverManager::getConnection($params);

        // Only quote if we don't have a path
        if (!isset($params['path'])) {
            $name = $tmpConnection->getDatabasePlatform()->quoteSingleIdentifier($name);
        }

        $error = false;
        try {
            $tmpConnection->getSchemaManager()->createDatabase($name);
            $output->writeln(sprintf('<info>Created database for connection named <comment>%s</comment></info>', $name));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Could not create database for connection named <comment>%s</comment></error>', $name));
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            $error = true;
        }

        $tmpConnection->close();

        return $error ? 1 : 0;
    }
}
