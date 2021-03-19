<?php

namespace Jdwiese\DaytimeBundle\EventListener\DataContainer;

use Contao\DataContainer;
use DateTime;

class HelperListener
{
    public function saveEmptyNull($varValue, DataContainer $dc)
    {
        return ('' === $varValue) ? null : $varValue;
    }

    public function saveBoolean($varValue, DataContainer $dc)
    {
        return (bool)$varValue ? 1 : 0;
    }

    public function saveDate($varValue, object $dc)
    {
        if ($varValue !== '') {
            return date('Y-m-d', $varValue);
        }
        return null;
    }

    public function loadDate($varValue, DataContainer $dc)
    {
        if ($varValue) {
            return DateTime::createFromFormat('Y-m-d', $varValue)->getTimestamp();
        }
        return null;
    }

    public function saveTime($varValue, object $dc)
    {
        if ((string)$varValue !== '') {
            return date('H:i:s', $varValue);
        }
        return null;
    }

    public function loadTime($varValue, DataContainer $dc)
    {
        if ($varValue) {
            return DateTime::createFromFormat('H:i:s', $varValue)->getTimestamp();
        }
        return null;
    }
}
