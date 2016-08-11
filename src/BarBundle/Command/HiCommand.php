<?php
/**
 * Command bar:hi class file
 *
 * PHP version 5.6.23
 *
 * @category BarBundle
 * @package  BarBundle
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  GIT: 1.0
 * @link     https://github.com/aoga88/chainCommand
 */
namespace BarBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;

/**
 * Class HiCommand
 *
 * @category BarBundle
 * @package  BarBundle\Command
 * @author   Osvaldo Garcia <aoga88@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/aoga88/chainCommand
 */
class HiCommand extends ContainerAwareCommand
{
    /**
     * Configures command
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('bar:hi')
            ->setDescription('Says Hi from Bar');
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
        try {
            if ($input->getArgument('command') == 'foo:hello') {
                $text = 'Hi from Bar!';
            } else {
                $logText = 'bar:hi command is a member of foo:hello 
                    command chain and cannot be executed on its own.';
                throw new Exception($logText);
            }
        } catch (Exception $e) {
            $text = 'Error: ' . $e->getMessage();
        }

        $logger->debug($text);
        $output->writeln($text);
    }
}