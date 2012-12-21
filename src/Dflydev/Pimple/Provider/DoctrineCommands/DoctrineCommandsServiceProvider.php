<?php

/*
 * This file is part of the dflydev/doctrine-commands-service-provider
 *
 * (c) Dragonfly Development, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Pimple\Provider\DoctrineCommands;

use Pimple;

/**
 * Doctrine Commands Service Provider
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class DoctrineCommandsServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register(Pimple $c)
    {
        $c['console'] = $c->share($c->extend('console', function($console, $c) {
            foreach (array(
                new Command\CreateDatabaseCommand,
                new Command\DropDatabaseCommand,
            ) as $command) {
                $console->add($command);
            }

            if (class_exists('Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand')) {
                foreach (array(
                    new Command\Proxy\UpdateSchemaCommand,
                ) as $command) {
                    $console->add($command);
                }
            }

            return $console;
        }));
    }
}
