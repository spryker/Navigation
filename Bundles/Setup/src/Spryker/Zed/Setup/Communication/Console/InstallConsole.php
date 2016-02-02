<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Setup\Communication\Console;

use Spryker\Zed\Console\Business\Model\Console;
use Spryker\Zed\Setup\Communication\SetupCommunicationFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method SetupCommunicationFactory getFactory()
 */
class InstallConsole extends Console
{

    const COMMAND_NAME = 'setup:install';
    const DESCRIPTION = 'Setup the application';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $setupInstallCommandNames = $this->getFactory()->getSetupInstallCommandNames();

        foreach ($setupInstallCommandNames as $key => $value) {
            if (is_array($value)) {
                $this->runDependingCommand($key, $value);
            } else {
                $this->runDependingCommand($value);
            }

            if ($this->hasError()) {
                return $this->getLastExitCode();
            }
        }
    }

}
