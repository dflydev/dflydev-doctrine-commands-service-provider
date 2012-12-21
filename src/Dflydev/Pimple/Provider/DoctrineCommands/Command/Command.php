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

namespace Dflydev\Pimple\Provider\DoctrineCommands\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * Base class for Doctrine console commands to extend from.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Beau Simensen <beau@dflydev.com>
 */
abstract class Command extends BaseCommand
{
    protected $app;

    /**
     * Get a Doctrine Entity Manager by name.
     *
     * @param string $name
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager($name = null)
    {
        $c = $this->getApplication()->getContainer();

        if (null === $name) {
            return $c['orm.em'];
        }

        return $c['orm.ems'][$name];
    }

    /**
     * Get a Doctrine DBAL connection by name.
     *
     * @param string $name
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDoctrineConnection($name = null)
    {
        $c = $this->getApplication()->getContainer();

        if (null === $name) {
            return $c['db'];
        }

        return $c['dbs'][$name];
    }
}
