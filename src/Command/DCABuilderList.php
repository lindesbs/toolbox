<?php

namespace lindesbs\toolbox\Command;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\DcaLoader;
use lindesbs\toolbox\Classes\DCA;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

#[AsCommand(name: 'toolbox:dcabuilder:list')]
class DCABuilderList extends Command
{

    private Serializer $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        private readonly ContaoFramework $contaoFramework,
        private readonly Environment $twig
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = "tl_article";

        $this->contaoFramework->initialize();
        $dcaLoader = $this->contaoFramework->createInstance(DcaLoader::class, [$table]);
        $dcaLoader->load();

        $dcaBuilderFile = $this->twig->render('@toolbox/dcaBuilder_php.twig', [
            'tableName' => $table,
            'phpArray' => $this->varexport($GLOBALS['TL_DCA'][$table])
        ]);

        $dcaBuilder = new DCA();
        $dcaBuilder->load($GLOBALS['TL_DCA'][$table]);

        file_put_contents("testing.php", $dcaBuilderFile);

        return Command::SUCCESS;
    }


    private function varexport(array $expression): string
    {
        $export = var_export($expression, true);

        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
        return join(PHP_EOL, array_filter(["["] + $array));
    }

}