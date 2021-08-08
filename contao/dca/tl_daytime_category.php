<?php

declare(strict_types=1);

use Revierstil\DaytimeBundle\EventListener\DataContainer\DaytimeCategoryListener;
use Netzmacht\Contao\Toolkit\Dca\Listener\Save\GenerateAliasListener;

$GLOBALS['TL_DCA']['tl_daytime_category'] = [

    // Config
    'config' => [
        'dataContainer' => 'Table',
        'closed' => false,
        'ctable' => ['tl_daytime_text'],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['title'],
            'panelLayout' => 'limit',
            'flag' => 11,
            'disableGrouping' => true,
        ],
        'label' => [
            'fields' => ['title', 'alias', 'insert_tag'],
            'format' => '%s',
            'showColumns' => true,
            'label_callback' => [DaytimeCategoryListener::class, 'addInsertTag'],
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'href' => 'table=tl_daytime_text',
                'icon' => 'edit.svg'
            ],
            'editheader' => [
                'href' => 'table=tl_daytime_category&amp;act=edit',
                'icon' => 'header.svg',
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                    . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.gif'
            ]

        ],
    ],

    'metapalettes' => [
        'default' => [
            'category' => ['title', 'alias'],
        ],
    ],

    'metasubpalettes' => [],

    // Fields
    'fields' => [
        'id' => [],
        'tstamp' => [],
        'title' => [
            'exclude' => false,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50'],
        ],
        'alias' => [
            'exclude' => false,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => false,
                'doNotCopy' => true,
                'maxlength' => 128,
                'tl_class' => 'w50',
            ],
            'save_callback' => [
                [
                    GenerateAliasListener::class,
                    'onSaveCallback',
                ],
            ],
            'toolkit' => [
                'alias_generator' => [
                    'factory' => 'netzmacht.contao_toolkit.data.alias_generator.factory.default_factory',
                    'fields' => ['title'],
                ],
            ],
        ],
    ],
];
