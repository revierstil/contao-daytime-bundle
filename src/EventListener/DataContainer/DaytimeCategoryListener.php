<?php

declare(strict_types=1);

namespace Jdwiese\DaytimeBundle\EventListener\DataContainer;

use Contao\DataContainer;
use Jdwiese\DaytimeBundle\EventListener\ReplaceInsertTagsListener;

class DaytimeCategoryListener
{
    public function addInsertTag($row, $label, DataContainer $dc, $args)
    {
        $args[2] = sprintf('{{%s::%s}}', ReplaceInsertTagsListener::TAG, $row['alias']);

        return $args;
    }
}
