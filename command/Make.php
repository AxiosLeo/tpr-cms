<?php

namespace app\command;

use Exception;
use Nette\PhpGenerator\Parameter;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use tpr\Console;
use tpr\Files;
use tpr\Path;

class Make extends Console
{
    protected function configure()
    {
        $this->setName('make')
            ->setDescription('generate code of command')
            ->addArgument('CommandName')
            ->addOption('namespace');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        unset($input, $output);

        $command_name = $this->input->getArgument('CommandName');
        if (empty($command_name)) {
            $this->output->error('command name cannot be empty');
            die();
        }

        $command_type = [
            'Global',
            'Custom Type',
        ];

        $type = $this->output->choice('select command type', $command_type, 'Global');

        $namespace = '';
        $save_path = '';

        $class_name = ucfirst($command_name);
        $class_name = str_replace(['-'], '', $class_name);

        switch ($type) {
            case 'Global':
                $namespace = "command";

                $save_path = Path::command() . $class_name . '.php';
                break;
            case 'Custom Type':
                $custom_type = $this->output->ask('Type Name', 'Default');
                $namespace   = __NAMESPACE__ . $custom_type;
                $save_path   = Path::command() . $custom_type . '/' . $class_name . '.php';
                break;
        }

        if (file_exists($save_path)) {
            $confirm = $this->output->confirm($save_path . ' 已存在, 是否覆盖?', false);
            if (!$confirm) {
                exit(1);
            }
        }

        try {
            $namespace = new PhpNamespace($namespace);
            $namespace->addUse('\\tpr\\Console');
            $namespace->addUse('Symfony\\Component\\Console\\Input\\InputInterface');
            $namespace->addUse('Symfony\\Component\\Console\\Output\\OutputInterface');

            $Command = $namespace->addClass($class_name);
            $Command->addExtend(Console::class);
            $Command->addMethod('configure')->setBody('
$this->setName("' . $command_name . '")->setDescription(\'\')->addArgument("action")->addOption("action");
        ');
            $inputParam = new Parameter('input');
            $inputParam->setTypeHint('Symfony\\Component\\Console\\Input\\InputInterface');
            $outputParam = new Parameter('output');
            $outputParam->setTypeHint('Symfony\\Component\\Console\\Output\\OutputInterface');
            $Command->addMethod('execute')->setParameters([$inputParam, $outputParam])->setBody('
parent::execute($input, $output);
unset($input, $output);

$this->output->writeln("this is ' . $command_name . ' command");
        ');

            $printer = new PsrPrinter();
            $content = $printer->printNamespace($namespace);
            Files::save($save_path, "<?php\n\n" . $content);

            $this->output->success('Done! Save Path : ' . $save_path);
        } catch (Exception $e) {
            dump($e);
        }
    }
}
