<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *  @Groups("trip")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("trip")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("trip")
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("trip")
     */
    private $mark;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("trip")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups("trip")
     */
    private $arrival;

    /**
     * @ORM\Column(type="date")
     * @Groups("trip")
     */
    private $departure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trip", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trip;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Transport", mappedBy="stageFrom", cascade={"persist", "remove"})
     * @Groups("trip")
     */
    private $departureTransport;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Transport", mappedBy="stageTo", cascade={"persist", "remove"})
     * @Groups("trip")
     */
    private $arrivalTransport;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="stage")
     * @Groups("trip")
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(?int $mark): self
    {
        $this->mark = $mark;

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

    public function getArrival(): ?\DateTimeInterface
    {
        return $this->arrival;
    }

    public function setArrival(\DateTimeInterface $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(\DateTimeInterface $departure): self
    {
        $this->departure = $departure;

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

    public function getDepartureTransport(): ?Transport
    {
        return $this->departureTransport;
    }

    public function setDepartureTransport(Transport $departureTransport): self
    {
        $this->departureTransport = $departureTransport;

        // set the owning side of the relation if necessary
        if ($departureTransport->getStageFrom() !== $this) {
            $departureTransport->setStageFrom($this);
        }

        return $this;
    }

    public function getArrivalTransport(): ?Transport
    {
        return $this->arrivalTransport;
    }

    public function setArrivalTransport(?Transport $arrivalTransport): self
    {
        $this->arrivalTransport = $arrivalTransport;

        // set (or unset) the owning side of the relation if necessary
        $newStageTo = null === $arrivalTransport ? null : $this;
        if ($arrivalTransport->getStageTo() !== $newStageTo) {
            $arrivalTransport->setStageTo($newStageTo);
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setStage($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getStage() === $this) {
                $photo->setStage(null);
            }
        }

        return $this;
    }
}
