<?php

/*
 * This file is part of the dflydev/console-service-provider
 *
 * (c) Dragonfly Development, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Silex\Provider\Console;

use Silex\Application as SilexApplication;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * Silex Console Application
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Application extends BaseApplication
{
    /**
     * Constructor
     *
     * @param SilexApplication $silexApplication Silex Application
     * @param string           $name             The name of the application
     * @param string           $version          The version of the application
     */
    public function __construct(SilexApplication $silexApplication, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
        $this->silexApplication = $silexApplication;
    }

    /**
     * Get the Silex Application
     *
     * @return SilexApplication
     */
    public function getSilexApplication()
    {
        return $this->silexApplication;
    }
}
