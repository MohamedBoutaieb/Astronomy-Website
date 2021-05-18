<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalQuantity;


    /**
     * @ORM\ManyToMany(targetEntity=Merchandise::class)
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(name="username", referencedColumnName="username", nullable=false)
     */
    private $buyer;




    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="shipment")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=MerchOrder::class, mappedBy="toorder")
     */
    private $merchOrders;
    /**
     * @var string
     */


    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->merchOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(?float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getTotalQuantity(): ?int
    {
        return $this->totalQuantity;
    }

    public function setTotalQuantity(?int $totalQuantity): self
    {
        $this->totalQuantity = $totalQuantity;

        return $this;
    }


    /**
     * @return Collection|Merchandise[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Merchandise $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
        }

        return $this;
    }

    public function removeItem(Merchandise $item): self
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }






    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setShipment($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getShipment() === $this) {
                $address->setShipment(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

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
            $merchOrder->setToorder($this);
        }

        return $this;
    }

    public function removeMerchOrder(MerchOrder $merchOrder): self
    {
        if ($this->merchOrders->removeElement($merchOrder)) {
            // set the owning side to null (unless already changed)
            if ($merchOrder->getToorder() === $this) {
                $merchOrder->setToorder(null);
            }
        }

        return $this;
    }
}
