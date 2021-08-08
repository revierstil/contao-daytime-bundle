<?php

declare(strict_types=1);

namespace Revierstil\DaytimeBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Revierstil\DaytimeBundle\Repository\CategoryRepository;

/**
 * @Hook("replaceInsertTags")
 */
class ReplaceInsertTagsListener
{
    public const TAG = 'daytime';

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(
        string $tag,
        bool $useCache,
        string $cachedValue,
        array $flags,
        array $tags,
        array $cache,
        int $_rit,
        int $_cnt
    )
    {
        $chunks = explode('::', $tag);

        $tagname = array_shift($chunks);
        if (self::TAG !== $tagname) {
            return false;
        }

        $strCategory = array_shift($chunks);
        if (!$strCategory) {
            return 'Missing category';
        }

        $objCategory = $this->categoryRepository->findOneByIdOrAlias($strCategory);
        if (!$objCategory) {
            return sprintf('Category %s not found', $strCategory);
        }

        $text = $objCategory->getCurrentText();
        if (!$text) {
            return sprintf('Not text found in category "%s" for this daytime', $objCategory->getTitle());
        }

        return $text->getContent();
    }
}
