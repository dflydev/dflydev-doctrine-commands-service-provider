<?php

/*
 * This file is part of the dflydev/doctrine-commands-service-provider
 *
 * (c) Dragonfly Development, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Silex\Provider\DoctrineCommands;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Doctrine Commands Service Provider
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class DoctrineCommandsServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['console'] = $app->share($app->extend('console', function($console, $app) {
            foreach (array(
                new Command\CreateDatabaseCommand,
                new Command\DropDatabaseCommand,
                new Command\Proxy\UpdateSchemaCommand,
            ) as $command) {
                $console->add($command);
            }

            return $console;
        }));
    }
}
