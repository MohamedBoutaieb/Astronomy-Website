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
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=MerchOrder::class, mappedBy="toMerch")
     */
    private $merchOrders;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $available;


    public function __construct()
    {
        $this->merchOrders = new ArrayCollection();
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
     * @return Collection|MerchOrder[]
     */
    public function getMerchOrders(): Collection
    {
        return $this->merchOrders;
    }

    public function addMerchOrder(MerchOrder $merchOrder): self
    {
        if (!$this->merchOrders->contains($merchOrder)) {
            $this->merchOrders[] = $merchOrder;
            $merchOrder->setToMerch($this);
        }

        return $this;
    }

    public function removeMerchOrder(MerchOrder $merchOrder): self
    {
        if ($this->merchOrders->removeElement($merchOrder)) {
            // set the owning side to null (unless already changed)
            if ($merchOrder->getToMerch() === $this) {
                $merchOrder->setToMerch(null);
            }
        }

        return $this;
    }

    public function getAvailable(): ?string
    {
        return $this->available;
    }

    public function setAvailable(string $available): self
    {
        $this->available = $available;

        return $this;
    }


}
