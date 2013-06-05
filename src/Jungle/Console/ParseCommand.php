<?php

namespace Jungle\Console;
use Jungle\Lexer;
use Jungle\Parser;
use Jungle\Processor;
use Jungle\SLR\Table;
use Jungle\Stream\File;
use Jungle\Syntax;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 16:52
 */

class ParseCommand extends Command
{


    /**
     *
     */
    protected function configure()
    {
        $this->setName('parse');
        $this->setDescription('parse schema file');
        $this->addArgument('schema', InputArgument::REQUIRED, 'path to scheme file');
        $this->addOption('class', 'c', InputArgument::OPTIONAL, 'class name');
        $this->addOption('output', 'o', InputArgument::OPTIONAL, 'output file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reader = new Syntax\Reader();
        $schema = $reader->parseFile($input->getArgument('schema'));

        $syntax = new Syntax($schema);
        $table = new Table();
        $table->fromSyntax($syntax);

        $processorBuilder = new Processor\Builder();
        $class = $processorBuilder->build($syntax, $table);

        if ($input->getOption('class')) {
            $class->setName($input->getOption('class'));
        }

        $content = '<?php' . PHP_EOL . PHP_EOL . $class->generate();

        if ($input->getOption('output')) {
            file_put_contents($input->getOption('output'), $content);
        } else {
            echo $content;
        }
    }


}