<?php
/**
 * CommandTestCase class file
 *
 * PHP version 5.6.23
 *
 * @category ChainCommandBundle
 * @package  ChainCommandBundle
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  GIT: 1.0
 * @link     https://github.com/aoga88/chainCommand
 */
namespace ChainCommandBundle\Tests\Controller;

use ChainCommandBundle\Tests\CommandTestCase;

/**
 * Class DefaultControllerTest
 *
 * @category ChainCommandBundle
 * @package  ChainCommandBundle\Tests
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/aoga88/chainCommand
 */
class DefaultControllerTest extends CommandTestCase
{
    /**
     * Tests foo:hello also runs bar:hi
     *
     * @return void
     */
    public function testFooRunsHi()
    {
        $client = static::createClient();
        $output = $this->runCommand($client, "foo:hello");
        $this->assertContains('Hello from Foo!', $output);
        $this->assertContains('Hi from Bar!', $output);
    }

    /**
     * Tests bar:hi can't be run itself
     *
     * @return void
     */
    public function testHiCantRunItself()
    {
        $client = static::createClient();
        $output = $this->runCommand($client, "bar:hi");
        $this->assertContains('bar:hi command is a member of foo:hello', $output);
    }
}
