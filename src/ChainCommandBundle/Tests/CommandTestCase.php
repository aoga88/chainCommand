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
namespace ChainCommandBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class CommandTestCase
 *
 * @category ChainCommandBundle
 * @package  ChainCommandBundle\Tests
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/aoga88/chainCommand
 */
abstract class CommandTestCase extends WebTestCase
{
    /**
     * Runs a command
     *
     * @param $client  Console client
     * @param $command Command to run
     *
     * @return string
     */
    public function runCommand(Client $client, $command)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        $fp = tmpfile();
        $input = new StringInput($command);
        $output = new StreamOutput($fp);

        $application->run($input, $output);

        fseek($fp, 0);
        $output = '';
        while (!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;
    }
}