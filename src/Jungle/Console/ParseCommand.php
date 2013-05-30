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
        $this->setDescription('parse jungle file');
        $this->addArgument('path', InputArgument::REQUIRED, 'path to file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $yaml = new Yaml();
        $schema = $yaml->parse(APP_ROOT . "/config/schema.yaml");

        $syntax = new Syntax($schema);
        $table = new Table();
        $result = $table->fromSyntax($syntax);

        include 'data/test2.php';

        $parser = new \Test2();
        $parser->setAction($result);
        echo $parser->parse('1+2*3');

//        var_dump($table);
        exit;

        $processorBuilder = new Processor\Builder();
        $class = $processorBuilder->build($schema)->generate();
        echo $class;

        file_put_contents('data/test.php', '<?php' . PHP_EOL . $class);

        include 'data/test.php';

        $test = new \Test();
        var_dump($test->parse('1+2'));

//        var_dump($result);

        exit;


        $parserBuilder = new Parser\Builder($schema['tokens']);
        $parser = $parserBuilder->getParser();

        $stream = new File($input->getArgument('path'));
        $parser->parse($stream);

        $lexerBuilder = new Lexer\Builder($schema);
        $lexer = $lexerBuilder->build();

        $tree = $lexer->getAST($parser);
        var_dump($tree);
//        $lexer = new Lexer($parser);
//        $lexer->getAST();
    }


}