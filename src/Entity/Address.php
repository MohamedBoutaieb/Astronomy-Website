<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $zip;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="address", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $Country;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="address")
     */
    private $shipment;

    public function __construct()
    {
        $this->shipment = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getAddress() !== $this) {
            $user->setAddress($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(?string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getShipment(): Collection
    {
        return $this->shipment;
    }

    public function addShipment(Order $shipment): self
    {
        if (!$this->shipment->contains($shipment)) {
            $this->shipment[] = $shipment;
            $shipment->setAddress($this);
        }

        return $this;
    }

    public function removeShipment(Order $shipment): self
    {
        if ($this->shipment->removeElement($shipment)) {
            // set the owning side to null (unless already changed)
            if ($shipment->getAddress() === $this) {
                $shipment->setAddress(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getId();
    }


}
