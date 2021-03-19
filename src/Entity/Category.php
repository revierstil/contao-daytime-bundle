<?php

declare(strict_types=1);

namespace Jdwiese\DaytimeBundle\Entity;

use DateTime;
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
     */
    private $texts;

    public function __construct()
    {
        $this->tstamp = time();
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

}
