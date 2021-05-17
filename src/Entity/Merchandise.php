<?php

namespace App\Entity;

use App\Repository\MerchandiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MerchandiseRepository::class)
 */
class Merchandise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $inStock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="Merch")
     */
    private $toOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="toMerch")
     */
    private $orderedby;

    public function __construct()
    {
        $this->toOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getInStock(): ?int
    {
        return $this->inStock;
    }

    public function setInStock(int $inStock): self
    {
        $this->inStock = $inStock;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    /**
     * @return Collection|Order[]
     */
    public function getToOrder(): Collection
    {
        return $this->toOrder;
    }

    public function addToOrder(Order $toOrder): self
    {
        if (!$this->toOrder->contains($toOrder)) {
            $this->toOrder[] = $toOrder;
            $toOrder->setMerch($this);
        }

        return $this;
    }

    public function removeToOrder(Order $toOrder): self
    {
        if ($this->toOrder->removeElement($toOrder)) {
            // set the owning side to null (unless already changed)
            if ($toOrder->getMerch() === $this) {
                $toOrder->setMerch(null);
            }
        }

        return $this;
    }

    public function getOrderedby(): ?Order
    {
        return $this->orderedby;
    }

    public function setOrderedby(?Order $orderedby): self
    {
        $this->orderedby = $orderedby;

        return $this;
    }
}
