<?php

declare(strict_types=1);

namespace Jdwiese\DaytimeBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Jdwiese\DaytimeBundle\Repository\TextRepository")
 * @ORM\Table(name="tl_daytime_text")
 */
class Text
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
     * @ORM\Column(type="integer", length=10, options={"default": "0"})
     */
    private $pid;

    /**
     * Many Texts have One Parent-Category.
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="texts")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=10)
     */
    private $tstamp;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="time", nullable=true)
     */
    private $start;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="time", nullable=true)
     */
    private $stop;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $content;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private $published;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPid(): int
    {
        return $this->pid;
    }

    public function getParent(): Category
    {
        return $this->parent;
    }

    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    public function getStart(): ?DateTime
    {
        return $this->start;
    }

    public function getStop(): ?DateTime
    {
        return $this->stop;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function getTimespanAsString(): string
    {
        if ($this->start and $this->stop) {
            return sprintf('von %s Uhr bis %s Uhr', $this->start->format('H:i'), $this->stop->format('H:i'));
        }
        elseif ($this->start) {
            return sprintf('ab %s Uhr', $this->start->format('H:i'));
        }
        elseif ($this->stop) {
            return sprintf('bis %s Uhr', $this->stop->format('H:i'));
        }

        return 'wenn kein anderer Text angezeigt wird';
    }

    public function isDefault(): bool
    {
        return !$this->start and !$this->stop;
    }

    public function isNow(): bool
    {
        $now = new DateTime();
        $time = $now->format('H:i');

        if ($this->start and $this->stop) {
            $start = $this->start->format('H:i');
            $stop = $this->stop->format('H:i');
            return $time >= $start and $time < $stop;
        }

        elseif ($this->start) {
            $start = $this->start->format('H:i');
            return $time >= $start;
        }

        elseif ($this->stop) {
            $stop = $this->stop->format('H:i');
            return $time < $stop;
        }

        return false;
    }
}
