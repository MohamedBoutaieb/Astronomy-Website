<?php

namespace App\Entity;

use App\Repository\MerchOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MerchOrderRepository::class)
 */
class MerchOrder
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="merchOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $toOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Merchandise::class, inversedBy="merchOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $toMerch;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getToOrder(): ?Order
    {
        return $this->toOrder;
    }

    public function setToorder(?Order $toOrder): self
    {
        $this->toOrder = $toOrder;

        return $this;
    }

    public function getToMerch(): ?Merchandise
    {
        return $this->toMerch;
    }

    public function setToMerch(?Merchandise $toMerch): self
    {
        $this->toMerch = $toMerch;

        return $this;
    }


}
