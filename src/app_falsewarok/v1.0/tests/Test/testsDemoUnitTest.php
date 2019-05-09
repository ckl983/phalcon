<?php
/**
 * @desc DemoUnitTest演示类
 *
 * @author --
 * @copyright 2014-2018
 */

namespace Test;

use Phalcon\Di;

/**
 * Class DemoUnitTest
 */
class DemoUnitTest extends \UnitTestCase
{

    public function testTest()
    {
        $this->assertNotEquals(1, 0);
        $this->assertEquals(1, 1);
    }
}