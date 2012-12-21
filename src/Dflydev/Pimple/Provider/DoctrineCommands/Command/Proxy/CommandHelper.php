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

namespace Dflydev\Pimple\Provider\DoctrineCommands\Command\Proxy;

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

/**
 * Provides some helper and convenience methods to configure doctrine commands
 * in the context of silex and multiple connections/entity managers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Beau Simensen <beau@dflydev.com>
 */
abstract class CommandHelper
{
    /**
     * Convenience method to push the helper sets of a given entity manager into the application.
     *
     * @param Application $application Application
     * @param string      $emName      Entity Manager name
     */
    static public function setApplicationEntityManager($application, $emName)
    {
        $c = $application->getContainer();

        if ($emName) {
            $em = $c['orm.ems'][$emName];
        } else {
            $em = $c['orm.em'];
        }

        $helperSet = $application->getHelperSet();
        $helperSet->set(new ConnectionHelper($em->getConnection()), 'db');
        $helperSet->set(new EntityManagerHelper($em), 'em');
    }

    /**
     * Convenience method to push the helper sets of a given connection into the application.
     *
     * @param Application $application Application
     * @param string      $connName    Connection name
     */
    static public function setApplicationConnection($application, $connName)
    {
        $c = $application->getContainer();

        if ($emName) {
            $em = $c['orm.ems'][$emName];
        } else {
            $em = $c['orm.em'];
        }

        $helperSet = $application->getHelperSet();
        $helperSet->set(new ConnectionHelper($connection), 'db');
    }
}
