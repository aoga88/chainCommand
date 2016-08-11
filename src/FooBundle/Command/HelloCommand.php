<?php
/**
 * Command foo:hello class file
 *
 * PHP version 5.6.23
 *
 * @category FooBundle
 * @package  FooBundle
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  GIT: 1.0
 * @link     https://github.com/aoga88/chainCommand
 */
namespace FooBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class HelloCommand
 *
 * @category FooBundle
 * @package  FooBundle\Command
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/aoga88/chainCommand
 */
class HelloCommand extends ContainerAwareCommand
{
    /**
     * Configures command
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('foo:hello')
            ->setDescription('Says Hello from Foo');
    }

    /**
     * Executes command
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        $logText = $this->getName() . ' is a master command of a 
                    command chain that has registered member commands';
        $logger->debug($logText);

        $chain = $this->getContainer()->get('chain');
        foreach ($chain->getCommands() as $command) {
            $logText = $command . ' registered as a member of ' . $this->getName();
            $logger->debug($logText);
        }

        $text = 'Hello from Foo!';
        $logger->debug('Executing ' . $this->getName() . ' command itself first');
        $logger->debug($text);
        $output->writeln($text);

        $logger->debug('Executing foo:hello chain members:');
        foreach ($chain->getCommands() as $command) {
            $consoleCommand = $this->getApplication()->get($command);
            $input = new ArrayInput(['command' => $this->getName()]);
            $consoleCommand->run($input, $output);
        }
        $logger->debug('Execution of ' . $this->getName() . ' chain completed.');
    }

    /**
     * Gets command chain
     *
     * @param $commands Array of command names
     *
     * @return Array
     */
    public function getChain($commands)
    {
        $this->_commands = $commands;
    }

    /**
     * Get local commands array
     *
     * @return mixed
     */
    public function getCommands()
    {
        return $this->_commands;
    }

    /**
     * Chain commands
     *
     * @var _commands Array of commands
     */
    private $_commands;
}