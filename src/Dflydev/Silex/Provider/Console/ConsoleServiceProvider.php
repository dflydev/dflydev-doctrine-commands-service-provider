<?php

/*
 * This file is part of the dflydev/console-service-provider
 *
 * (c) Doctrine Development, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Silex\Provider\Console;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Silex Console Service Provider
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ConsoleServiceProvider implements ServiceProviderInterface
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
        foreach ($this->getDefaults($app) as $key => $value) {
            if (!isset($app[$key])) {
                $app[$key] = $value;
            }
        }

        $app['console'] = $app->share(function() use ($app) {
            $args = array($app);
            if (isset($app['console.name'])) {
                $args[] = $app['console.name'];
                if (isset($app['console.version'])) {
                    $args[] = $app['console.version'];
                }
            }

            $class = new \ReflectionClass($app['console.class']);

            return $class->newInstanceArgs($args);
        });
    }

    protected function getDefaults()
    {
        return array(
            'console.name' => 'My Silex Application',
            'console.version' => 'n/a',
            'console.class' => 'Dflydev\Silex\Provider\Console\Application',
        );
    }
}
