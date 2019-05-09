<?php

/**
 * @desc UnitTestCase
 *
 * @author --
 * @copyright 2014-2018
 */

use Phalcon\Di,
    \Phalcon\Test\UnitTestCase as PhalconTestCase;
use Phalcon\Di\FactoryDefault;

abstract class UnitTestCase extends PhalconTestCase
{

    /**
     * @var bool
     */
    private $_loaded = false;

    public function setUp()
    {
        $this->checkExtension('phalcon');

        // Reset the DI container
        Di::reset();

        // Instantiate a new DI container
        $di = new FactoryDefault();

        $config = include APP_PATH . "config/config.php";

        include APP_PATH . "config/services.php";

        $this->di = $di;

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }
}