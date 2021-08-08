<?php

declare(strict_types=1);

namespace Revierstil\DaytimeBundle\EventListener\DataContainer;

use Contao\DataContainer;
use Revierstil\DaytimeBundle\EventListener\ReplaceInsertTagsListener;

class DaytimeCategoryListener
{
    public function addInsertTag($row, $label, DataContainer $dc, $args)
    {
        $args[2] = sprintf('{{%s::%s}}', ReplaceInsertTagsListener::TAG, $row['alias']);

        return $args;
    }
}
