<?php

declare(strict_types=1);

use Jdwiese\DaytimeBundle\EventListener\DataContainer\DaytimeTextListener;
use Jdwiese\DaytimeBundle\EventListener\DataContainer\HelperListener;

$GLOBALS['TL_DCA']['tl_daytime_text'] = [

    // Config
    'config' => [
        'dataContainer' => 'Table',
        'closed' => false,
        'ptable' => 'tl_daytime_category',
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => 4,
            'fields' => ['start', 'stop'],
            'panelLayout' => 'limit',
            'headerFields' => ['title', 'alias'],
            'disableGrouping' => true,
            'child_record_callback' => [DaytimeTextListener::class, 'compileDefinition'],
        ],
        'label' => [
            'fields' => ['content'],
            'format' => '%s',
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
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                    . '\'))return false;Backend.getScrollOffset()"',
            ],
            'toggle' => [
                'attributes' => 'onclick="Backend.getScrollOffset();"',
                'haste_ajax_operation' =>
                    [
                        'field' => 'published',
                        'options' =>
                            [
                                [
                                    'value' => '0',
                                    'icon' => 'invisible.gif'
                                ],
                                [
                                    'value' => '1',
                                    'icon' => 'visible.gif'
                                ]
                            ]
                    ]
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.gif'
            ]
        ],
    ],

    'metapalettes' => [
        'default' => [
            'content' => ['start', 'stop', 'content'],
            'published' => ['published'],
        ],
    ],

    'metasubpalettes' => [],

    // Fields
    'fields' => [
        'id' => [],
        'tstamp' => [],
        'start' => [
            'exclude' => false,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'rgxp' => 'time', 'datepicker' => true, 'tl_class' => 'w50'],
            'save_callback' => [
                [HelperListener::class, 'saveTime'],
            ],
            'load_callback' => [
                [HelperListener::class, 'loadTime'],
            ],
            'sql' => ['notnull' => false],
        ],
        'stop' => [
            'exclude' => false,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'rgxp' => 'time', 'datepicker' => true, 'tl_class' => 'w50'],
            'save_callback' => [
                [HelperListener::class, 'saveTime'],
            ],
            'load_callback' => [
                [HelperListener::class, 'loadTime'],
            ],
            'sql' => ['notnull' => false],
        ],
        'content' => [
            'exclude' => false,
            'search' => true,
            'inputType' => 'textarea',
            'eval' => ['mandatory' => true, 'tl_class' => 'clr'],
        ],
        'published' => [
            'exclude' => false,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => ['isBoolean' => true],
            'save_callback' => [
                [HelperListener::class, 'saveBoolean'],
            ]
        ],
    ],
];
