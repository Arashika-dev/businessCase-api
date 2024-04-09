<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StaffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StaffRepository::class)]
#[ApiResource]
class Staff extends User
{

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $staffNumber = null;

    #[ORM\OneToMany(mappedBy: 'affectedStaff', targetEntity: Order::class)]
    #[Groups(['user:read'])]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getStaffNumber(): ?string
    {
        return $this->staffNumber;
    }

    public function setStaffNumber(string $staffNumber): static
    {
        $this->staffNumber = $staffNumber;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setAffectedStaff($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getAffectedStaff() === $this) {
                $order->setAffectedStaff(null);
            }
        }

        return $this;
    }
}
