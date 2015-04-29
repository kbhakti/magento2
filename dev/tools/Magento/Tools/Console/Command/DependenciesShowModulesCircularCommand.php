<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tools\Console\Command;

use Magento\Framework\App\Utility\Files;
use Magento\Tools\Dependency\ServiceLocator;

/**
 * Command for showing number of circular dependencies between modules
 */
class DependenciesShowModulesCircularCommand extends AbstractDependenciesCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Shows number of circular dependencies between modules')
            ->setName('info:dependencies:show-modules-circular');
        parent::configure();
    }

    /**
     * Return default output file for modules circular dependencies report
     *
     * @return string
     */
    protected function getDefaultOutputPath()
    {
        return 'modules-circular-dependencies.csv';
    }

    /**
     * Build circular dependencies between modules report
     *
     * @param string $outputPath
     * @return void
     */
    protected function buildReport($outputPath)
    {
        $filesForParse = Files::init()->getComposerFiles('code', false);

        ServiceLocator::getCircularDependenciesReportBuilder()->build(
            [
                'parse' => ['files_for_parse' => $filesForParse],
                'write' => ['report_filename' => $outputPath],
            ]
        );
    }
}
