<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransportRepository")
 */
class Transport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="departureTransport", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $stageFrom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="arrivalTransport", cascade={"persist"})
     */
    private $stageTo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("trip")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $distance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStageFrom(): ?Stage
    {
        return $this->stageFrom;
    }

    public function setStageFrom(Stage $stageFrom): self
    {
        $this->stageFrom = $stageFrom;

        return $this;
    }

    public function getStageTo(): ?Stage
    {
        return $this->stageTo;
    }

    public function setStageTo(?Stage $stageTo): self
    {
        $this->stageTo = $stageTo;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
