<?php

declare(strict_types=1);

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace Jdwiese\DaytimeBundle\Tests;

use Jdwiese\DaytimeBundle\JdwieseDaytimeBundle;
use PHPUnit\Framework\TestCase;

class JdwieseDaytimeBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new JdwieseDaytimeBundle();

        $this->assertInstanceOf('Jdwiese\DaytimeBundle\JdwieseDaytimeBundle', $bundle);
    }
}
