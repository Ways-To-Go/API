<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"trip", "post"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"trip", "post"})
     */
    private $path;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"trip", "post"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trip", inversedBy="photos")
     */
    private $trip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="photos", cascade={"persist"})
     * @Groups({"trip", "post"})
     */
    private $stage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"trip", "post"})
     */
    private $isCover;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    public function getIsCover(): ?bool
    {
        return $this->isCover;
    }

    public function setIsCover(?bool $isCover): self
    {
        $this->isCover = $isCover;

        return $this;
    }
}
