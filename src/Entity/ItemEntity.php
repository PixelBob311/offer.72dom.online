<?php

namespace App\Entity;

use App\Repository\ItemEntityRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=ItemEntityRepository::class)
 * @ORM\Table(name="offer_items")
 */
class ItemEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OfferEntity::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $square;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $complex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $house;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $liked;

    /**
     * @ORM\Column(type="json")
     */
    private $images = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffer(): ?OfferEntity
    {
        return $this->offer;
    }

    public function setOffer(?OfferEntity $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getCid(): ?string
    {
        return $this->cid;
    }

    public function setCid(string $cid): self
    {
        $this->cid = $cid;

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

    public function getSquare(): ?float
    {
        return $this->square;
    }

    public function setSquare(float $square): self
    {
        $this->square = $square;

        return $this;
    }

    public function getComplex(): ?string
    {
        return $this->complex;
    }

    public function setComplex(string $complex): self
    {
        $this->complex = $complex;

        return $this;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function setHouse(string $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLiked(): ?bool
    {
        return $this->liked;
    }

    public function setLiked(bool $liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(array $images): self
    {
        $this->images = $images;

        return $this;
    }
}
