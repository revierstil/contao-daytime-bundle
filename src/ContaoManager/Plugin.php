<?php

declare(strict_types=1);

/*
 * This file is part of contao daytime bundle.
 *
 * (c) Jan-Dirk Wiese
 *
 * @license LGPL-3.0-or-later
 */

namespace Revierstil\DaytimeBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Revierstil\DaytimeBundle\RevierstilDaytimeBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(RevierstilDaytimeBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
