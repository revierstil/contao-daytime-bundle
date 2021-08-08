<?php

declare(strict_types=1);

/*
 * This file is part of contao daytime bundle.
 *
 * (c) Jan-Dirk Wiese
 *
 * @license LGPL-3.0-or-later
 */

namespace Revierstil\DaytimeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RevierstilDaytimeBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
