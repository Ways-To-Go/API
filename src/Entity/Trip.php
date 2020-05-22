<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(normalizationContext={"groups"={"trip"}},
 *     collectionOperations={
 *          "get",
 *         "post"={"security_post_denormalize"="user == object.getAuthor()"}
 *     },
 *    itemOperations={
 *         "get",
 *         "put"={"security"="object.getAuthor() == user"},
 *         "delete"={"security"="object.getAuthor() == user"}
 *     }
)
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 * @ApiFilter(SearchFilter::class, properties={"title": "ipartial","keywords": "ipartial", "stages.city": "exact"})
*/
class Trip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"trip", "user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"trip", "user"})
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"trip", "user"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"trip", "user"})
     */
    private $vegan;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"trip", "user"})
     */
    private $ecological;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"trip:read", "trip:write"})
     * @Groups({"trip"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="recordedTrips")
     * @Groups({"trip", "user"})
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="trip", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"trip", "user"})
     */
    private $stages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="trip", cascade={"persist", "remove"})
     * @Groups({"trip", "user"})
     */
    private $photos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"trip", "user"})
     */
    private $keywords;

    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getVegan(): ?bool
    {
        return $this->vegan;
    }

    public function setVegan(bool $vegan): self
    {
        $this->vegan = $vegan;

        return $this;
    }

    public function getEcological(): ?bool
    {
        return $this->ecological;
    }

    public function setEcological(bool $ecological): self
    {
        $this->ecological = $ecological;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(User $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->addRecordedTrip($this);
        }

        return $this;
    }

    public function removeFollower(User $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
            $follower->removeRecordedTrip($this);
        }

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setTrip($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getTrip() === $this) {
                $stage->setTrip(null);
            }
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
            $photo->setTrip($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getTrip() === $this) {
                $photo->setTrip(null);
            }
        }

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }
}
