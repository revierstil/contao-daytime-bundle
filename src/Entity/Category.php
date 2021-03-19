<?php

declare(strict_types=1);

namespace Jdwiese\DaytimeBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Jdwiese\DaytimeBundle\Repository\CategoryRepository")
 * @ORM\Table(name="tl_daytime_category")
 */
class Category
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=10)
     */
    private $tstamp;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, options={"default": ""})
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=false, options={"default": ""})
     */
    private $alias;

    /**
     * One Category has Many Texts.
     * @var Category[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Text", mappedBy="parent")
     * @ORM\OrderBy({"start" = "ASC", "stop" = "ASC"})
     */
    private $texts;

    public function __construct()
    {
        $this->tstamp = time();
        $this->texts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return Collection|Category[]
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function getDefaultText(): ?Text
    {
        return $this->getTexts()->filter(function(Text $text) {
            return $text->isPublished() and $text->isDefault();
        })->first() ?: null;
    }

    public function getMatchingTexts()
    {
        $texts = $this->getTexts()->filter(function(Text $text) {
            return $text->isPublished() and !$text->isDefault();
        });

        /** @var Text $text */
        foreach ($texts as $offset => $text) {
            if ($texts->offsetExists($offset + 1)) {
                /** @var Text $nextText */
                $nextText = $texts->offsetGet($offset + 1);

                if (!$text->getStop() and $nextText->getStart()) {
                    $text->setStop($nextText->getStart());
                }
                elseif ($text->getStop() and !$nextText->getStart()) {
                    $nextText->setStart($text->getStop());
                }
            }
        }

        return $texts->filter(function(Text $text) {
            return $text->isNow();
        });
    }

    public function getCurrentText(): ?Text
    {
        $texts = $this->getMatchingTexts();
        if (!$texts->isEmpty()) {
            return $texts->last();
        }

        return $this->getDefaultText();
    }
}
