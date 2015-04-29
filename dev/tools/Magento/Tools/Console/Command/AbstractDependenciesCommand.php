<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tools\Console\Command;

use Magento\Framework\App\Utility\Files;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDependenciesCommand extends Command
{
    /**
     * Input key for directory option
     */
    const INPUT_KEY_DIRECTORY = 'directory';

    /**
     * Input key for output path of report file
     */
    const INPUT_KEY_OUTPUT = 'output';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDefinition([
                new InputOption(
                    self::INPUT_KEY_DIRECTORY,
                    'd',
                    InputOption::VALUE_REQUIRED,
                    'Path to base directory for parsing',
                    BP
                ),
                new InputOption(
                    self::INPUT_KEY_OUTPUT,
                    'o',
                    InputOption::VALUE_REQUIRED,
                    'Path to report file',
                    $this->getDefaultOutputPath()
                )
            ]
        );
        parent::configure();
    }

    /**
     * Build dependencies report
     *
     * @param string $outputPath
     * @return void
     */
    abstract protected function buildReport($outputPath);

    /**
     * Get path to the default output report file
     *
     * @return string
     */
    abstract protected function getDefaultOutputPath();

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            Files::setInstance(new Files($input->getOption(self::INPUT_KEY_DIRECTORY)));
            $this->buildReport($input->getOption(self::INPUT_KEY_OUTPUT));
            $output->writeln('<info>Report successfully processed.</info>');
        } catch (\Exception $e) {
            $output->writeln(
                '<error>Please, check passed path. Dependencies report generator failed: ' .
                $e->getMessage() . '</error>'
            );
        }
    }
}
