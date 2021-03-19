<?php

declare(strict_types=1);

namespace Jdwiese\DaytimeBundle\EventListener\DataContainer;

use Contao\BackendTemplate;
use Jdwiese\DaytimeBundle\Repository\TextRepository;

class DaytimeTextListener
{
    /**
     * @var TextRepository
     */
    private $textRepository;

    public function __construct(TextRepository $textRepository)
    {
        $this->textRepository = $textRepository;
    }

    public function compileDefinition(array $row)
    {
        $text = $this->textRepository->find($row['id']);

        $objTemplate = new BackendTemplate('be_daytime_text');
        $objTemplate->setData([
            'timespan' => $text->getTimespanAsString(),
            'content' => $text->getContent(),
            'class' => $text->isPublished() ? 'daytime_text published' : 'daytime_text unpublished',
            'debug' => '<pre>' . print_r($row, true) . '</pre>',
        ]);

        return $objTemplate->parse();
    }
}
