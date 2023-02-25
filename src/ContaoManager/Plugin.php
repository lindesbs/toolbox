<?php

declare(strict_types=1);

namespace lindesbs\toolbox\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use lindesbs\toolbox\ToolboxBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ToolboxBundle::class)
                ->setLoadAfter([ContaoNewsBundle::class]),
        ];
    }
}
