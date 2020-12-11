<?php

namespace app\command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tpr\Console;
use tpr\Files;
use tpr\Path;
use tpr\traits\CommandTrait;

class Build extends Console
{
    use CommandTrait;

    public function configure()
    {
        $this->setName('build')->setDescription('Build blog front page');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        unset($input, $output);

        $build_path = Path::join(Path::app(), 'blog', 'build');
        $this->shell("cd {$build_path} && rm -r build/");
        $this->shell("cd {$build_path} && yarn build");
        $this->shell('cd ' . Path::index() . ' && rm -rf static/');
        Files::copy($build_path, Path::index(), true);
    }
}
