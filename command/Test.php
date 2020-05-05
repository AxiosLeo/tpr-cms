<?php

namespace app\command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tpr\Console;

class Test extends Console
{
    public function configure()
    {
        $this->setName("test")->setDescription('test command')->addArgument("action")->addOption("action");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        unset($input, $output);

        $this->output->writeln("this is test command");
    }
}
