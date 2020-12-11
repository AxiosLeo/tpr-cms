<?php

namespace app\command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tpr\Console;
use tpr\Files;
use tpr\Path;

/**
 * @internal
 * @coversNothing
 */
class Clear extends Console
{
    public function configure()
    {
        $this->setName('clear')
            ->addArgument('path', InputArgument::OPTIONAL, 'project path', Path::cache())
            ->setDescription('Clear cache');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        unset($input, $output);

        $cache_path = $this->input->getArgument('path');
        if (file_exists($cache_path)) {
            if ($this->output->confirm('clear cache now? (' . $cache_path . ')')) {
                Files::remove($cache_path);
                $this->output->success('Clear cache : ' . $cache_path);
            }
        }
    }
}
