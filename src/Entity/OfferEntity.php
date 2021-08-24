<?php

namespace App\Entity;

use App\Repository\OfferEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;


/**
 * @ORM\Entity(repositoryClass=OfferEntityRepository::class)
 * @ORM\Table(name="offers")
 */
class OfferEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $b24_contact_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $b24_deal_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $b24_manager_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $manager;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;
    ////     * @Assert\Choice({"Новая", "Отправлена Клиенту", "Просмотрена Клиентом"}) почему-то не работает.
    ///  Оно добавляет, но выкидывает ошибку, которую я никак не могу перекрыть (возможно, вы забыли кавычки)
    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity=ItemEntity::class, mappedBy="offer")
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getB24ContactId(): ?int
    {
        return $this->b24_contact_id;
    }

    public function setB24ContactId(int $b24_contact_id): self
    {
        $this->b24_contact_id = $b24_contact_id;

        return $this;
    }

    public function getB24DealId(): ?int
    {
        return $this->b24_deal_id;
    }

    public function setB24DealId(int $b24_deal_id): self
    {
        $this->b24_deal_id = $b24_deal_id;

        return $this;
    }

    public function getB24ManagerId(): ?int
    {
        return $this->b24_manager_id;
    }

    public function setB24ManagerId(int $b24_manager_id): self
    {
        $this->b24_manager_id = $b24_manager_id;

        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|ItemEntity[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ItemEntity $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOffer($this);
        }

        return $this;
    }

    public function removeItem(ItemEntity $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOffer() === $this) {
                $item->setOffer(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
