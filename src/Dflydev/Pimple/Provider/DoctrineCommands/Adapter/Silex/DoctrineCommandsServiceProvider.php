<?php

/*
 * This file is part of the dflydev/doctrine-commands-service-provider
 *
 * (c) Dragonfly Development, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Pimple\Provider\DoctrineCommands\Adapter\Silex;

use Dflydev\Pimple\Provider\DoctrineCommands\DoctrineCommandsServiceProvider as BaseDoctrineCommandsServiceProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Silex Doctrine Commands Service Provider
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
        $serviceProvider = new BaseDoctrineCommandsServiceProvider;
        $serviceProvider->register($app);
    }
}
